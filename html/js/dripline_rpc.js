function get_fib_number(index, andthen)
{
    console.error("wtf?");
    console.log("in ajax");
    console.log("data are:", index);
    $.ajax({
        type: "POST",
        //timeout: 5000,
        //data: {"value":3},
        dataType: "json",
        url: "php/post_reply.php",
        success: function(newdata) {
            console.log("rpc success, new data is:");
            console.log(newdata);
            andthen(newdata);
        },
        error: function(err1, err2, err3) {
            console.error("this is dumb");
            console.error("error1: "+JSON.stringify(err1));
            console.error("error2: "+JSON.stringify(err2));
            console.error("error3: "+JSON.stringify(err3));
        }
    });
    console.error("crap");
    /*
    $.post("php/rpc_client.php",
           {"value": index},
           function(newdata, status) {
                console.log("rpc_success, new data is:");
                console.log(newdata);
                andthen(newdata);
           }
          ).fail(function(resp) {console.error('Error: ' + resp.responseText);});
    */
}
