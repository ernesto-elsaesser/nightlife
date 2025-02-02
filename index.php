<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>Cities</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" />
<style>
.citybox {
  display: inline-block;
  width: 256px;
  height: 16px;
  margin: 4px 6px;
  padding: 14px;
  text-align: left;
  border: 1px solid #777;
  border-radius: 5px;
  text-decoration: none;
  outline: none;
}
.citybox .fi {
  float: left;
  width: 20px;
  height: 16px;
  margin-right: 12px;
}
.citybox .name {
  float: left;
  font-size: 18px;
}
.citybox .pop {
  float: right;
  color: #aaa;
  font-size: 16px;
  font-weight: lighter;
}
</style>
</head>
<body style="margin: 0 auto 40px; text-align: center">
<input id="search" type="text" placeholder="Filter" />
<div id="citylist">
<?php
# from http://api.geonames.org/getJSON?username=cityglance&lang=en&geonameId=<ID>
$files = scandir("cities");
foreach( $files as $file ) {
    $parts = explode('.', $file);
    if ($parts[1] != 'json') continue;
    $json = file_get_contents($file);
    $data = json_decode($json);
    $cc = strtolower($data['countryCode']);
    $asciiName = $data['asciiName'];
    $name = $data['name'];
    $pop = sprintf("%.1f", $data['population'] / 1000000);
    echo "<a class=\"citybox\" href=\"map.php?city=$asciiName\"><span class=\"fi fi-$cc\"></span><span class=\"name\">$name</span><span class=\"pop\">${pop}M</span></a>";
}
?>
</div>
<script>
const cityBoxes = document.getElementsByClassName("citybox")
document.getElementById("searchfield").addEventListener("input", function () {
  let query = searchField.value.toLowerCase()
  for (box of cityBoxes) {
    if (box.innerText.startsWith(query)) {
      box.style.display = 'inline-block'
    } else {
      box.style.display = 'none'
    }
  }
})
</script>
</body>
</html>
