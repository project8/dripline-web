<html>
<head>
    <script type="text/javascript" src="js/dripline_rpc_interface.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<script>
function local_update(name, value) {
    console.log("using local updater");
    document.getElementById(name).innerHTML=JSON.stringify(JSON.parse(value), null, 2);
}
</script>

<style>
pre {
    border-style: solid;
    border-width: 2px;
    border-radius: 5px;
}
</style>

<!-- reusable list of sensor names -->
<datalist id="sensors">
  <option value="flux_capacitance"></option>
  <option value="flux_inductance"></option>
</datalist>

<body>

  <h1>Simple dripline interface demo</h1>
  <p>
    Warning, this page will allow you to send dripline commands without any sanity checks. It is intended for debugging and testing where lower-level access is required, not regular operational tasks. If you find yourself using it regularly for the same task, consider making a dedicated page for that activity.
  </p>

  <h2>Retrieve value</h2>
  <form id="get_form">
    Sensor name: <input type="text" name="get_target" list="sensors" spellcheck=false>
    <button type="button" onclick=dripline_get(form.get_target.value,"get_output",local_update)>Get</button><br>
    <pre id="get_output"></pre>
  </form>

  <hr>
  <h2>Assign value</h2>
  <form id="set_form">
    Sensor name: <input type="text" name="set_target" list="sensors" spellcheck=false>
    New value: <input type="text" name="set_value">
    <button type="button" onclick=dripline_set(form.set_target.value,form.set_value.value,"set_output",local_update)>Set</button><br>
    <pre id="set_output"></pre>
  </form>

</body>
</html>
