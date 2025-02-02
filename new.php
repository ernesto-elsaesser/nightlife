import sys
import unicodedata
import requests

URL = "http://api.geonames.org/getJSON?username=cityglance&lang=en&geonameId=%s"
BOX = '<a class="citybox" href="#%s"><img class="flag" src="flags/%s.svg"><span class="name">%s</span><span class="pop">%.1fM</span></a>'
BOUNDS = "      '%s': [[%f, %f], [%f, %f]]"

geoname_id = sys.argv[1]
res = requests.get(URL % geoname_id)
info = res.json()

name = info['name']
bbox = info['bbox']
country_code = info['countryCode']
population = info['population']

norm_name = unicodedata.normalize('NFD', name.lower())
ascii_name = norm_name.encode('ascii', 'ignore')
slug = ascii_name.decode('utf-8').replace(' ', '-')

print(BOX % (slug, country_code.lower(), name, population / 1_000_000))
print(BOUNDS % (bbox['east'], bbox['north'], bbox['west'], bbox['south']))

# lng = float(info['lng'])
# lat = float(info['lat'])
# print(BOUNDS % (lng - 0.5, lat - 0.5, lng + 0.5, lat + 0.5))
