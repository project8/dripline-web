<?php
require_once __DIR__ . '/SplClassLoader.php'; // https://gist.github.com/jwage/221634
$classLoader = new SplClassLoader('PhpAmqpLib', '/usr/share/php');
$classLoader->register();
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class FibonacciRpcClient {
    private $connection;
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;

    public function __construct() {
        $this->connection = new AMQPStreamConnection(
            '172.17.0.2', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        list($this->callback_queue, ,) = $this->channel->queue_declare(
            "", false, false, true, true);
        $this->channel->basic_consume(
            $this->callback_queue, "dripline_rpc_client_php", false, false, false, false,
            array($this, 'on_response'));
    }
    public function on_response($rep) {
        if($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;
        }
    }

    public function call($n) {
        $this->response = null;
        $this->corr_id = uniqid();

        $msg = new AMQPMessage(
            (string) $n,
            array('correlation_id' => $this->corr_id,
                  'reply_to' => $this->callback_queue)
            );
        $this->channel->basic_publish($msg, '', 'rpc_queue');
        while(!$this->response) {
            $this->channel->wait();
        }
        return intval($this->response);
    }
};


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $ret_data = array("index_value"=>$_POST["value"]);

    $fibonacci_rpc = new FibonacciRpcClient();
    $ret_data["fib_val"] = $fibonacci_rpc->call($ret_data["index_value"]);

    echo json_encode($ret_data);
} else {
echo $value;
}

?>
