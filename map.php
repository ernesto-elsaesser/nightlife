<?php
$slug = $_GET['city'];
$city_json = file_get_contents("cities/$slug.json");
$info = json_decode($city_json);
$bbox = $info['bbox'];
$bounds = sprintf('[[%f, %f], [%f, %f]]', $bbox['east'], $bbox['north'], $bbox['west'], $bbox['south']);
$hotspots = file_get_contents("hotspots/$slug.json");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>Nightlife Map</title>
<link rel="stylesheet" href='https://api.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' />
</head>
<body style="margin: 0">
<div id="map" style="width: 100%; height: 100%"></div>
<script src='https://api.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.js'></script>
<script>

mapboxgl.accessToken = "pk.eyJ1IjoiZXJuZXN0by1lbHNhZXNzZXIiLCJhIjoiY2p4YXJjYTVhMDVxcTN5cDlueHF0N3JudSJ9.KG2s_HZELVZsNLWeB0DC4Q";

var mapboxMap = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/ernesto-elsaesser/ck2jkxebz3wnh1dmt5x8n57sd',
    pitchWithRotate: false,
    dragRotate: false
});

mapboxMap.on('style.load', function () {

  mapboxMap.addSource('hotspots', {
        'type': 'geojson',
        'data': {
            'type': 'FeatureCollection',
            'features': [{
                'type': 'Feature',
                'properties': {},
                'geometry': {
                    'type': 'MultiPoint',
                    'coordinates': <?php echo $hotspots; ?>,
                }
            }]
        }
    })

  mapboxMap.addLayer({
      'id': 'hotspots',
      'type': 'circle',
      'source': 'hotspots',
      'paint': {
          'circle-blur': 1.0,
          'circle-opacity': 0.3,
          'circle-radius': [
              'interpolate', ['linear'], ['zoom'],
          ].concat([8, 4, 10, 8, 12, 32, 14, 128, 16, 512]),
          'circle-color': '#bb00ff'
      }
    }, 'road-label')

  let options = mapboxMap.cameraForBounds(<?php echo $bounds; ?>)
  options.zoom += 0.8
  mapboxMap.jumpTo(options)
  mapboxMap.resize()
})
</script>
</body>
</html>
