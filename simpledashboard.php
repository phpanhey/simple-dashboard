<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <meta http-equiv="refresh" content="10" > 
    <title>simple -- a rather simple dashboard</title>
    <meta name="description" content="a simple dashboard">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.1.1/css/pico.min.css">
  </head>
<body>
<?php
    function calculateMemory()
    {
    $memfile  = file("/proc/meminfo");
    $memindex = [];
    $res      = [];
    foreach ($memfile as $item) {
        $key   = [];
        $value = [];
        preg_match("/[0-9]+/", $item, $value);
        preg_match("/[a-zA-Z]+/", $item, $key);
        $memindex[$key[0]] = $value[0];
    }
    $res["total"]     = round($memindex["MemTotal"] / 1024);
    $res["available"] = round($memindex["MemAvailable"] / 1024);
    $res["used"]      = round(($memindex["MemTotal"] - $memindex["MemAvailable"]) / 1024);
    return $res;
    }
    $mem = calculateMemory();
?>
<div class="container">
  <h1>~simple -- </h1>
<!-- memory -->
<article>
    <h3>memory</h3>
      <?php
          echo "used: " . $mem["used"] . " mb" . " | available: " . $mem["available"] . " mb";
      ?>
      <progress value="<?php echo $mem["used"] ?>" max="<?php echo $mem["total"] ?>" />
</article>

<!-- links -->
<article>
    <h3>fav</h3>
    <ul>
      <li><a href="http://192.168.178.135:8000/dashboard">paperless ngx</a></li>
    </ul>
</article>
</div>
</body>
</html>
