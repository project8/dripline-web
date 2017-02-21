function dripline_set(target, value, callback_args, page_callback)
{
    console.log("in dripline_set");
    dripline_base_send(target, {"values": [value]}, 0, callback_args, page_callback);
}

function dripline_get(target, callback_args, page_callback)
{
    console.log("in dripline_get");
    dripline_base_send(target, {}, 1, callback_args, page_callback);
}

function dripline_base_send(target, payload, msgop, callback_args, page_callback)
{
    console.log("in dripline_base_send");
    var msg = {
        "msgtype":3,
        "msgop":msgop,
        "payload": payload,
        "timestamp": (new Date()).toJSON(),
        "sender_info": {
            "username": "laroque",
            "exe": "apache2",
            "package": "dripline-web",
            "service_name": "dripline_amqp_client_php",
            "hostname": "marvin",
            "version": "wp2.1.1",
            "commit": ""
        }
    }
    console.log("msg is:", msg);
    console.log("encoded:", JSON.stringify(msg));
    $.ajax({
        type: "POST",
        data: {"target":target, "msg":msg},
        datatype: "json",
        url: "/dripline-web/php/dripline_amqp_client.php",
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
