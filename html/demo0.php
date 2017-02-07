<html>
<head>
    <script type="text/javascript" src="js/demo0.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<script>
function set_time() {
    console.log("setting time in set_time()");
    local_update("this_time", Date());
    //document.getElementById("this_time").innerHTML=Date();
}
</script>
<script>
function local_update(name, value) {
    console.log("using local updater");
    document.getElementById(name).innerHTML=JSON.stringify(JSON.parse(value), null, 2);
}
</script>

<body>

<h1> Now with some ajax+amqp </h1>
<form id="fib_form">
Fib. Index: <input type="int" name="fib_index">
<button type="button" onclick=get_amqp(form.fib_index.value,"amqp_here",local_update)>Post Ajax</button>
<p id="amqp_here">No Value</p>
</form>

</body>
</html>
