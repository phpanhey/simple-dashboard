
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <title>simple -- a rather simple dashboard</title>
    <meta name="description" content="a simple dashboard">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.1.1/css/pico.min.css">
  </head>
<body>

<?php 
function calculateMemory(){
  $pieces = array_filter(explode(" ", shell_exec("free -m")));
  $res =[];
  array_push($res,$pieces[53],$pieces[61],$pieces[68]);
  return $res;
}

function getRunningContainerNames(){
  return array_filter(explode("\n", shell_exec("docker ps --format \"{{.Names}}\"")));
}
$mem = calculateMemory();
$container = getRunningContainerNames();
?>
<div class="container">
  <h1>simple -- arsd</h1>


<!-- container -->
<h3>container</h3>
<ul>

<?php
foreach ($container as $c) {
  echo "<li>" .$c ."</li>";
}
?>

<!-- memory -->
</ul>
  <h3>memory in mb</h3>
    <?php
      echo  "Used: " . $mem[1] . " Free: " . $mem[2];
    ?>

    <progress value="<?php echo $mem[1] ?>" max="<?php echo $mem[0] ?>" />


</div>
</body>
</html>
