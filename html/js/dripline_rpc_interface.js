function dripline_get(target, callback_args, callme)
{
    console.log("in dripline_get");
    console.log("target is", target);
    var msg = {
        "msgtype":3,
        "msgop":1,
        "payload": {},
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
        data: {"target":target, "msg":JSON.stringify(msg)},
        //data: {"target":target, "msg":msg},
        datatype: "json",
        url: "php/dripline_amqp_client.php",
        // this timeout value may need to be more adaptive later
        timeout: 10000,
        success: function(result_data) {
            console.log("rpc returned!");
            console.log("rpc result data is: ", result_data);
            callme(callback_args, result_data);
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

function get_amqp(post_arg, callback_args, callme)
{
    console.log("in get_php (with ajax magix)");
    console.log("post arg is", post_arg);
    $.ajax({    
        type: "POST",
        data: {"value":post_arg},
        //datatype: "json"
        url: "php/demo_rpc_client.php",
        success: function(result_data) {
            console.log("rpc result data is: ", result_data);
            callme(callback_args, result_data);
        },
        error: function(err1, err2, err3) {
            console.log("e1: ", err1);
            console.log("e2: ", err2);
            console.log("e3: ", err3);
        }
    });
}
