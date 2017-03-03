<?php
    if (! isset($_SESSION["p8_amqp_config"])) {
        $json_data = json_decode(file_get_contents("/var/www/project8_authentications.json"));
        $_SESSION["p8_amqp_config"] = $json_data->amqp;
    }
?>
