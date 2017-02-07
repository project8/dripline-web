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
    document.getElementById(name).innerHTML=value;
}
</script>

<body>
<h1> Local js function </h1>

Time was: <span width=40 id="this_time"></span><button type="button" onClick=set_time()>Set Time</button>

<hr>

<h1> Local update from callback to js file </h1>

<button type="button" onclick=subdir_callback("time_goes_here",local_update)>Set Time Remote</button>
<p id="time_goes_here">No Value</p>

<hr>
<h1> Now with some ajax </h1>
<button type="button" onclick=get_php("ajax_here",local_update)>Post Ajax</button>
<p id="ajax_here">No Value</p>

<hr>
<h1> Now with some ajax+amqp </h1>
<form id="fib_form">
Fib. Index: <input type="int" name="fib_index">
<button type="button" onclick=get_amqp(form.fib_index.value,"amqp_here",local_update)>Post Ajax</button>
<!--
<button type="button" onclick=get_amqp(form.fib_index.value,local_update)>Post Ajax</button>
-->
<p id="amqp_here">No Value</p>
</form>

</body>
</html>
