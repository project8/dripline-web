<?php
//require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/SplClassLoader.php'; // https://gist.github.com/jwage/221634
$classLoader = new SplClassLoader('PhpAmqpLib', '/usr/share/php/PhpAmqpLib');
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
            "", false, false, true, false);
        $this->channel->basic_consume(
            $this->callback_queue, '', false, false, false, false,
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


$value = 15;
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //$value = $_POST["value"];
    //echo $value;
    echo 3;
} else {
echo $value;
}

/*
$ret_data = array();

//echo "requested index: ", $value, "<br>";
$fibonacci_rpc = new FibonacciRpcClient();
$response = $fibonacci_rpc->call($value);
$ret_data["result"]=$response;
//echo " result is: ", $response, "<br>";
echo json_encode($ret_data);
*/
?>
