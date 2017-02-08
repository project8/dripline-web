<?php
require_once __DIR__ . '/SplClassLoader.php'; // https://gist.github.com/jwage/221634
$classLoader = new SplClassLoader('PhpAmqpLib', '/usr/share/php');
$classLoader->register();
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class DriplineRpcClient {
    private $connection;
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;

    public function __construct() {
        /* These args should all be configured elsewhere and loaded */
        $this->connection = new AMQPStreamConnection(
            '172.17.0.2', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();

        /*queue_declare(queue, passive, durable, exclusive, auto_delete, nowait, arguments, ticket*/
        list($this->callback_queue, ,) = $this->channel->queue_declare(
            "", false, false, true, true);
        /*queue_bind(queue, exchange, routing_key, nowait, arguments, ticket)*/
        $this->channel->queue_bind($this->callback_queue, 'requests', $this->callback_queue);

        /*basic_consume(queue, consumer_tag, no_local, no_ack, exclusive, nowait, callback, ticket, arguments)*/
        $this->channel->basic_consume(
            $this->callback_queue, '', false, false, false, false,
            array($this, 'on_response'));
    }
    public function on_response($rep) {
        if($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;
        }
    }

    /**
     * send a dripline message
     * @param string $target -- routing key the message is sent to
     * @param json $request_message -- json object *not string* to use as message body (will be encoded)
    */
    public function send_message($target, $request_message) {
        $this->response = null;
        $this->corr_id = uniqid();

        /*AMQPMessage.__construct(body, properties)*/
        $msg = new AMQPMessage(
            //(string) $request_message,
            (string) json_encode($request_message),
            array('correlation_id' => $this->corr_id,
                  'reply_to' => $this->callback_queue,
                  'content_encoding' => 'application/json',
                 )
            );

        /*basic_publish(msg, exchange, routing_key, mandatory, immediate, ticket)*/
        $this->channel->basic_publish($msg, 'requests', $target);
        $counter = 0;
        while(!$this->response and $counter<10) {
            $this->channel->wait();
            $counter += 1;
        }
        return $this->response;
    }
};


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //$ret_data = array("index_value"=>$_POST["value"]);
    $dripline_rpc = new DriplineRpcClient();
    $reply = $dripline_rpc->send_message($_POST["target"], $_POST["msg"]);

    echo $reply;
} else {
echo $value;
}

?>
