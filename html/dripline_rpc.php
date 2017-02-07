<html>
<head>
    <script type="text/javascript" src="js/demo0.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<script>
function local_update(name, value) {
    console.log("using local updater");
    document.getElementById(name).innerHTML=JSON.stringify(JSON.parse(value), null, 2);
}
</script>

<body>

  <h1>Simple dripline interface demo</h1>

  <h2>Retrieve value</h2>
  <form id="get_form">
    Sensor name: <input type="text" name="get_target" list="get_targets">
      <datalist id="get_targets">
        <option value="flux_capacitance"></option>
        <option value="flux_inductance"></option>
      </datalist>
    </select>
    <button type="button" onclick=get_amqp(form.get_target.value,"amqp_here",local_update)>Get</button><br>
    <pre id="amqp_here"></pre>
  </form>

  <hr>
  <h2>Assign value</h2>

</body>
</html>
