/*
Dictionary of return codes from the dripline standard with their meanings
*/
var retcodes = {
    1: "No action taken warning",
    100: "Generic AMQP error",
    101: "AMQP Connection Error",
    102: "AMQP Routing Key Error",
    200: "Generic Hardware Related Error",
    201: "Hardware Connection Error",
    202: "Hardware no Response Error",
    300: "Generic Dripline Error",
    301: "No message encoding error",
    302: "Decoding Falied Error",
    303: "Payload related error",
    304: "Value Error",
    305: "Timeout",
    306: "Method not supported",
    307: "Access denied",
    308: "Invalid key",
    400: "Generic Database Error",
    500: "Generic DAQ Error",
    501: "DAQ Not Enabled",
    502: "DAQ Running",
    999: "Unhandled core-language or dependency exception"
}

/*
sender_info required for all request payloads
This data should either be computed at runtime or in a bootstrap script, should also
consider if this data should be computed here, or if the php should assign it.
*/
var sender_info = {
    "username": "laroque",
    "exe": "apache2",
    "package": "dripline-web",
    "service_name": "dripline_amqp_client_php",
    "hostname": "marvin",
    "version": "wp2.1.1",
    "commit": ""
}

function check_retcode(reply_message) {
    /*
    Parse dripline reply message to check the return code for success or raise alerts
    */
    var reply = JSON.parse(reply_message);
    var thiscode = reply["retcode"];
    if (thiscode == 0) {
        console.log("success code");
    } else if (thiscode < 100) {
        console.log("got a warning, code", thiscode);
        console.log("that is '",retcodes[thiscode],"'");
    } else {
        console.log("got an error, code", thiscode);
        console.log("that is '",retcodes[thiscode],"'");
        alert("Dripline retcode: "+thiscode + " ("+retcodes[thiscode]+"):\n"+reply["return_msg"])
    }
    return thiscode;
}

function dripline_set(target, value, callback_args, page_callback)
{
    console.log("in dripline_set");
    dripline_base_send(target, {"values": [value]}, 0, {"args":callback_args, "cb":page_callback}, dripline_request_cb);
}

function dripline_get(target, callback_args, page_callback)
{
    console.log("using dripline to 'get'", target);
    dripline_base_send(target, {}, 1, {"args":callback_args,"cb":page_callback}, dripline_request_cb);
}

function dripline_request_cb(callback_args, result) {
    retcode = check_retcode(result);
    if (retcode == 0) {
        var data = JSON.parse(result);
        //callback_args["cb"](callback_args["args"], JSON.stringify(data["payload"]));
        callback_args["cb"].apply(this, [callback_args["args"], JSON.stringify(data["payload"])]);
    }
}

function dripline_base_send(target, payload, msgop, callback_args, page_callback)
{
    console.log("in dripline_base_send");
    var msg = {
        "msgtype":3,
        "msgop":msgop,
        "payload": payload,
        "timestamp": (new Date()).toJSON(),
        "sender_info": sender_info
    }
    console.log("msg is:", msg);
    console.log("encoded:", JSON.stringify(msg));
    $.ajax({
        type: "POST",
        data: {"target":target, "msg":msg},
        datatype: "json",
        url: "/dripline-web/src/php/dripline_amqp_client.php",
        // this timeout value may need to be more adaptive later
        timeout: 10000,
        success: function(result_data) {
            console.log("rpc returned!");
            console.log("rpc result data is: ", result_data);
            page_callback(callback_args, result_data);
        },
        error: function(err1, err2, err3) {
            console.log("e1: ", err1);
            console.log("e2: ", err2);
            console.log("e3: ", err3);
        },
        complete: function(data) {
            console.log('in complete');
        }
    });
    console.log("ajax done");
}
