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

    function calculateDiskSpace($path)
    {
    $output = [];
    exec("df -h", $output);
    $res = [];
    foreach ($output as $item) {
        if (str_contains($item, $path)) {
            $pieces           = explode("  ", $item);
            $res["total"]     = $pieces[1];
            $res["used"]      = $pieces[2];
            $res["available"] = $pieces[3];

            return $res;
        }
    }
    return $res;
    }

    function deleteLastChar($str)
    {
    return substr($str, 0, -1);
    }

    $mem       = calculateMemory();
    $diskspace = calculateDiskSpace(getenv("DISK_SPACE_PATH"));

?>
<div class="container">
  <h1>~simple -- </h1>

<div class="grid">
  <!-- memory -->
  <article>
      <h3><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M9 2V5M15 2V5M9 19V22M15 19V22M19 9H22M19 14H22M2 9H5M2 14H5M9.8 19H14.2C15.8802 19 16.7202 19 17.362 18.673C17.9265 18.3854 18.3854 17.9265 18.673 17.362C19 16.7202 19 15.8802 19 14.2V9.8C19 8.11984 19 7.27976 18.673 6.63803C18.3854 6.07354 17.9265 5.6146 17.362 5.32698C16.7202 5 15.8802 5 14.2 5H9.8C8.11984 5 7.27976 5 6.63803 5.32698C6.07354 5.6146 5.6146 6.07354 5.32698 6.63803C5 7.27976 5 8.11984 5 9.8V14.2C5 15.8802 5 16.7202 5.32698 17.362C5.6146 17.9265 6.07354 18.3854 6.63803 18.673C7.27976 19 8.11984 19 9.8 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
 </svg> memory</h3>
        <?php
            echo "used: " . $mem["used"] . " mb" . " | available: " . $mem["available"] . " mb";
        ?>
        <progress value="<?php echo $mem["used"] ?>" max="<?php echo $mem["total"] ?>" />
  </article>

  <!-- diskspace -->
  <article>

      <h3><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M7 3V6.4C7 6.96005 7 7.24008 7.10899 7.45399C7.20487 7.64215 7.35785 7.79513 7.54601 7.89101C7.75992 8 8.03995 8 8.6 8H15.4C15.9601 8 16.2401 8 16.454 7.89101C16.6422 7.79513 16.7951 7.64215 16.891 7.45399C17 7.24008 17 6.96005 17 6.4V4M17 21V14.6C17 14.0399 17 13.7599 16.891 13.546C16.7951 13.3578 16.6422 13.2049 16.454 13.109C16.2401 13 15.9601 13 15.4 13H8.6C8.03995 13 7.75992 13 7.54601 13.109C7.35785 13.2049 7.20487 13.3578 7.10899 13.546C7 13.7599 7 14.0399 7 14.6V21M21 9.32548V16.2C21 17.8802 21 18.7202 20.673 19.362C20.3854 19.9265 19.9265 20.3854 19.362 20.673C18.7202 21 17.8802 21 16.2 21H7.8C6.11984 21 5.27976 21 4.63803 20.673C4.07354 20.3854 3.6146 19.9265 3.32698 19.362C3 18.7202 3 17.8802 3 16.2V7.8C3 6.11984 3 5.27976 3.32698 4.63803C3.6146 4.07354 4.07354 3.6146 4.63803 3.32698C5.27976 3 6.11984 3 7.8 3H14.6745C15.1637 3 15.4083 3 15.6385 3.05526C15.8425 3.10425 16.0376 3.18506 16.2166 3.29472C16.4184 3.4184 16.5914 3.59135 16.9373 3.93726L20.0627 7.06274C20.4086 7.40865 20.5816 7.5816 20.7053 7.78343C20.8149 7.96237 20.8957 8.15746 20.9447 8.36154C21 8.59171 21 8.8363 21 9.32548Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
 </svg>  discspace</h3>
        <?php
            echo "used: " . $diskspace["used"] . " | available: " . $diskspace["available"];
        ?>
        <progress value="<?php echo deleteLastChar($diskspace["used"]) ?>" max="<?php echo deleteLastChar($diskspace["total"]) ?>" />
  </article>
</div>

<!-- links -->
<article>
    <h3><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M5 7.8C5 6.11984 5 5.27976 5.32698 4.63803C5.6146 4.07354 6.07354 3.6146 6.63803 3.32698C7.27976 3 8.11984 3 9.8 3H14.2C15.8802 3 16.7202 3 17.362 3.32698C17.9265 3.6146 18.3854 4.07354 18.673 4.63803C19 5.27976 19 6.11984 19 7.8V21L12 17L5 21V7.8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
 </svg>  fav</h3>
    <ul>
    <li><a href=<?php echo getenv("PAPERLESS_URL")?>>paperless ngx</a></li>
    <li><a href=<?php echo getenv("YELLYFIN_URL")?>>yellyfin</a></li>
    </ul>
</article>
</div>
</body>
</html>
