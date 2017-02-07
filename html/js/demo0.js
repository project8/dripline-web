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

function get_amqp(sendto, callme)
{
    console.log("in get_php (with ajax magix)");
    $.ajax({    
        type: "POST",
        data: {"value":"5"},
        //datatype: "json"
        url: "php/rpc_client.php",
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
