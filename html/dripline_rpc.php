<html>
<head>
    <script type="text/javascript" src="js/dripline_rpc.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<script>
function show_result(data) {
    console.log("got here")
    document.getElementById("fib_result").innerHTML = data["result"];
}
function set_result(data) {
    document.getElementById("fib_result").innerHTML = data;
    console.log("got data");
    console.log(data);
}
</script>
<body>

<form id="fib_form" action="", method="set_result()">
Index: <input type="int" name="fib_index"><br>
<input type="submit", value="Get" onClick=get_fib_number(form.fib_index.value)>
<button type="button" onClick=set_result(form.fib_index.value)>Set Data</button>
</form>
Result: <span id="fib_result"></span>

</body>
</html>
