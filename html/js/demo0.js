function subdir_callback(value, callme)
{
    console.log("in demo0.js calling provided callback");
    callme(value, Date());
}

function get_php(sendto, callme)
{
    console.log("in get_php");
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
