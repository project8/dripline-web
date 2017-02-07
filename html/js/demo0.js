function subdir_callback(value, callme)
{
    console.log("in demo0.js calling provided callback");
    callme(value, Date());
}

function get_php(sendto, callme)
{
    console.log("in get_php (with ajax magix)");
    $.ajax({    
        type: "POST",
        url: "php/demo0.php",
        success: function(result_data) {
            callme(sendto, result_data);
        },
        error: function(err1, err2, err3) {
            console.log("e1: ", err1);
            console.log("e2: ", err2);
            console.log("e3: ", err3);
        }
    });
}

function get_amqp(post_arg, callback_args, callme)
{
    console.log("in get_php (with ajax magix)");
    console.log("post arg is", post_arg);
    $.ajax({    
        type: "POST",
        data: {"value":post_arg},
        //datatype: "json"
        url: "php/rpc_client.php",
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
