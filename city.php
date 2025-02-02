<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Nightlife Map</title>
    <link rel="stylesheet" href='https://api.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' />
    <link rel="stylesheet" href="style.css?v=20250201">
  </head>
  <body>

    <div id="cityname"></div>
    <div id="map"></div>

    <script src='https://api.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.js'></script>
    <script>
    
    mapboxgl.accessToken = "pk.eyJ1IjoiZXJuZXN0by1lbHNhZXNzZXIiLCJhIjoiY2p4YXJjYTVhMDVxcTN5cDlueHF0N3JudSJ9.KG2s_HZELVZsNLWeB0DC4Q";

    // from GeoNames
    const bounds = {
      'amsterdam': [[5.073263264070009, 52.48581648590481], [4.706113719572571, 52.26223792333679]],
      'athens': [[23.862199162449446, 38.089507106318344], [23.593480837550555, 37.87801289368165]],
      'bangkok': [[100.80374454913354, 14.047239531812492], [100.19914345086647, 13.460718468187507]],
      'berlin': [[13.7604692835498, 52.6749171487584], [13.0883332178678, 52.3382418348765]],
      'bremen': [[8.990780355986441, 53.59732659216395], [8.481735118728865, 53.01102137830653]],
      'cologne': [[6.972890903720807, 50.959219025077154], [6.927985101565835, 50.915449013912095]],
      'dresden': [[13.786581145811093, 51.07425076373171], [13.688065285884342, 51.027883739261306]],
      'dubai': [[55.57707854537283, 25.31932788539388], [55.04147145462717, 24.83517211460612]],
      'dusseldorf': [[6.939965353894652, 51.351446231223406], [6.689822638811385, 51.124476583498094]],
      'frankfurt-am-main': [[8.80038192361686, 50.2271295064786], [8.47276066855846, 50.0152488338247]],
      'freiburg-im-breisgau': [[7.867036516645867, 48.005277594122404], [7.836964950998306, 47.98989656964283]],
      'hamburg': [[10.32527718680763, 53.73943730358849], [9.730130859481674, 53.39508508510774]],
      'kherson': [[32.71531986726082, 46.70603152686485], [32.513840132739176, 46.56786847313515]],
      'kuala-lumpur': [[101.8432813360293, 3.297688621924978], [101.52978842715468, 2.9847148141702418]],
      'lisbon': [[-9.013526947547053, 38.8100232000407], [-9.253139652452948, 38.62331019995929]],
      'london': [[0.2811882683122086, 51.68293389615384], [-0.4991631942360928, 51.297523767519486]],
      'los-angeles': [[-118.155289, 34.337306], [-118.668176, 33.703652]],
      'milan': [[9.277930280126062, 45.535977599221184], [9.06591510184385, 45.39217387866174]],
      'munich': [[11.7230825332677, 48.2481457759892], [11.360877208388, 48.0615537735515]],
      'new-york': [[-73.7000090638712, 40.91553277600008], [-74.25559136315213, 40.49611539517034]],
      'nuremberg': [[11.152909737997533, 49.489907458168354], [11.003700902984782, 49.388130219286225]],
      'odesa': [[30.93424953334717, 46.61651498969091], [30.553410466652828, 46.35492501030909]],
      'paris': [[2.4698353037826, 48.9021475933448], [2.22421910588045, 48.8155622380591]],
      'portland': [[-122.472021, 45.653272], [-122.83675, 45.432393000000005]],
      'porto': [[-8.524779316156721, 41.21446012345356], [-8.69720668384328, 41.084751876546434]],
      'rome': [[12.726343428495486, 42.05054833023755], [12.334658845099607, 41.765760675629664]],
      'seoul': [[127.28083982490483, 37.71542912762669], [126.6673455565496, 37.382850837966146]],
      'singapore': [[104.15841009400835, 1.5978899866585003], [103.54172799803366, 0.9814476920961595]],
      'stuttgart': [[9.233446338611078, 48.81079535607505], [9.134318822891228, 48.752218519176644]],
      'tokyo': [[139.918908366, 35.817706], [139.562782, 35.520966306]],
      'vienna': [[16.577514130310014, 48.3226666526653], [16.18183037911802, 48.11790334229859]],
    }

    var mapboxMap = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/ernesto-elsaesser/ck2jkxebz3wnh1dmt5x8n57sd',
        pitchWithRotate: false,
        dragRotate: false
    });
    
    function updateCity() {

      let slug = window.location.hash.substr(1);

      if (slug) {
        let options = mapboxMap.cameraForBounds(bounds[slug]);
        options.zoom += 0.8;
        mapboxMap.jumpTo(options);
        page.style.display = 'block';
        menu.style.display = 'none';
        mapboxMap.resize();
      } else {
        menu.style.display = 'block';
        page.style.display = 'none';
      }

    }
    
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
                        'coordinates': hotspots,
                    }
                }]
            }
        });

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
        }, 'road-label');

      updateCity();

    });

    window.addEventListener('hashchange', updateCity);

    const hotspots = [
      // amsterdam
      [4.900735518583502, 52.37513595363214], [4.896626770967174, 52.373172101810894], [4.89802165756214, 52.37417431438777], [4.893729271747986, 52.366679899993585], [4.896802180960776, 52.36589330663219], [4.880318925310718, 52.365185120776175], [4.88210817844157, 52.363480960848705],
      // athens
      [23.733699468612826, 37.97567888785251], [23.73199474808834, 37.978128452296104], [23.73529537538613, 37.98571250198569], [23.730295745658992, 37.98327649789749], [23.718695127122572, 37.98027783508991], [23.715780196864046, 37.98139182128314], [23.709332017820174, 37.97739995912394], [23.722909403867874, 37.96165955816569], [23.722134085180414, 37.98340230782266], [23.716870202115672, 37.982333807166], [23.733638143896002, 37.97673794416839], [23.7274174027732, 37.97985519628887], [23.733264223022275, 37.97739692023082], [23.741108634870102, 37.97733579336112],
      // bangkok
      [100.4996274911627, 13.754335552717976], [100.49574868730974, 13.760609011743071], [100.49836469161096, 13.757769905465722], [100.52665123282043, 13.728663016094075], [100.53417630425162, 13.728977911810702], [100.53403737986184, 13.727560877756488], [100.55376369926626, 13.74665083567838], [100.56341831800222, 13.738535056327109], [100.55701284979631, 13.738985940328163], [100.58242907562078, 13.733203313603696], [100.5834461602517, 13.731647195948199],
      // berlin
      [13.42546717928198, 52.481748145634015], [13.435765105242183, 52.48091856342677], [13.412218231576418, 52.51308749395156], [13.426706555547014, 52.50921074831754], [13.418005234547167, 52.51367024313606], [13.406042784972755, 52.50443511460563], [13.417265114978676, 52.500193842466814], [13.407797936113099, 52.50453223817851], [13.422336636218319, 52.500071911257294], [13.437335200492925, 52.49923008105321], [13.451855087140075, 52.494502581263674], [13.440420011546223, 52.50169077017222], [13.442015603460476, 52.501367003188136], [13.444462177776956, 52.50046044285813], [13.458131082099413, 52.5029210631308], [13.452759255878192, 52.50819798163943],
      // bremen
      [8.813330206127489, 53.07983212395263], [8.809521705119835, 53.0808946783672], [8.81969764426691, 53.075914108244234], [8.827631655459498, 53.07247156517741], [8.820539389846601, 53.076398161875545],
      // cologne
      [6.944512447312434, 50.92954527907489], [6.942973169529267, 50.929799370298014], [6.9405176549257135, 50.93238640198635], [6.939711366551734, 50.936428350939224], [6.939418170766913, 50.93751384310184], [6.932418121670054, 50.9354814115504], [6.907432337415088, 50.9510150591627], [6.924390164955497, 50.95095999124851], [6.917746892307832, 50.94897750272355], [6.927362155357969, 50.94669202908594],
      // dresden
      [13.751134538252671, 51.07106632723034], [13.749198914197024, 51.06868902886086], [13.747040468095832, 51.05297540276709], [13.737391675462675, 51.05091059205017], [13.74155978145376, 51.04711200298544], [13.731617712451794, 51.043756214020846], [13.737219291144243, 51.037394298487385], [13.753472076298294, 51.06464520615313], [13.74815495839448, 51.068480515437955],
      // dubai
      [55.15052837796267, 25.08656284599634], [55.13196892225858, 25.07004070079026], [55.14648976779617, 25.08869987603107], [55.13950161088209, 25.087590268941938], [55.30511463983211, 25.159663161260966], [55.298914801000336, 25.157403162870295], [55.155049226905874, 25.099230862659653], [55.21001748242327, 25.116204407573576], [55.20004430455447, 25.117413168764756], [55.29709521460464, 25.240174157168667], [55.301732038327316, 25.248799084480822],
      // dusseldorf
      [6.791814834503839, 51.221542583867944], [6.776610149732846, 51.231542477365394], [6.770481149121196, 51.225481354635434],
      // frankfurt-am-main
      [8.671927221551357, 50.10926905386941], [8.670200036751055, 50.10721896113998], [8.666745667138343, 50.10553252876127], [8.675663655375047, 50.11017495810424], [8.676425003306719, 50.11231105943048], [8.67801907555841, 50.116476182958365], [8.683110589885388, 50.11240260450424], [8.684765247022682, 50.113005980143754], [8.685835892559567, 50.114516429500384], [8.692169036151398, 50.1050834835861], [8.688823498782824, 50.106452162504326],
      // freiburg-im-breisgau
      [7.855127563505391, 47.99047247676265], [7.8521400880837575, 47.99498031679971],
      // hamburg
      [9.95681616244633, 53.55111757928236], [9.959553112091072, 53.54897800350017], [9.970644960656585, 53.546923908977504], [9.969528573302426, 53.55075385903234], [9.95641732314914, 53.561552403601496], [9.957726562111446, 53.56103815857861], [9.96142199467252, 53.55994693501276],
      // kherson
      [32.642598316185286, 46.67243701645211], [32.64600798562631, 46.676092529308306], [32.616682764591985, 46.66995381982352], [32.649164715448165, 46.65509476626633], [32.61876715933872, 46.63285214912622], [32.62065031015783, 46.63588498235444], [32.62092422298866, 46.6302188537513], [32.61571987894564, 46.63482703657388], [32.611439990749545, 46.63186467837306],
      // kuala-lumpur
      [101.71130328362563, 3.147278507290409], [101.70712592056907, 3.1469410426411315], [101.71031639852924, 3.1474674874536817], [101.67542906507384, 3.0943452721079296], [101.67672776067747, 3.095588040069771], [101.7110995151998, 3.1461257112401597], [101.7091521600803, 3.14588565934352], [101.72239540365433, 3.1427279507825148], [101.72078584930745, 3.1428243787940175],
      // lisbon
      [-9.142187027679455, 38.70716891238473], [-9.144016155504573, 38.706285300722584], [-9.146068116223574, 38.71081028522016], [-9.145036705455624, 38.712673276293486], [-9.145017605260165, 38.71496841454018],
      // london
      [-0.1102209867713384, 51.461107911685275], [-0.11586126636140648, 51.46381484607693], [-0.14279311949485418, 51.54308232856587], [-0.14189769898757731, 51.53940673722326], [-0.10049607534384108, 51.499633131458836], [-0.09767332347561819, 51.4962255282135], [-0.12179161088391766, 51.49068809068885], [-0.11931671949932365, 51.489900476551526], [-0.12928372025291424, 51.46571666628256], [-0.13782191955667145, 51.46162059847552], [-0.13385546185321573, 51.52080755292167], [-0.13257038552242761, 51.512353711028624], [-0.13840830369127843, 51.51701494224335], [-0.1403854928654198, 51.516195060314004], [-0.14453071760675584, 51.51429686426874], [-0.10836192110144793, 51.52239282753777], [-0.10135033006565664, 51.518629164317645], [-0.08927624368345732, 51.528487957542325], [-0.08997486283709577, 51.52626646754362], [-0.07926270258394652, 51.52455198268271],
      // los-angeles
      [-118.3642675616754, 34.09833295304645], [-118.39085782783582, 34.090670071275966], [-118.36623524137323, 34.09745219732888], [-118.31983997603453, 34.101761597614754], [-118.33320132386943, 34.10192055970663], [-118.36540827888538, 34.09840210344379], [-118.38869875728273, 34.09088274975899], [-118.38629252852002, 34.09005558007962], [-118.46301131166558, 33.989312874894765], [-118.464566643343, 33.9901608206502], [-118.47626488678799, 33.98968148336445], [-118.47363238263677, 33.989064990538225], [-118.24406028345206, 34.05275339413372], [-118.25724231211368, 34.04233522269455], [-118.25371358444013, 34.04761168240425], [-118.25042792951507, 34.052997192154066], [-118.257135132288, 34.04542583763508], [-118.29163718718075, 34.05762672277329], [-118.29693939887503, 34.05840191013267], [-118.29591014601516, 34.05987474655571], [-118.29640917770315, 34.06176097338144], [-118.3018361473182, 34.063414617153825], [-118.38195438631637, 34.085758636234786], [-118.38617053693352, 34.08370369391582], [-118.32591376503314, 34.10256308038933], [-118.32848596475901, 34.09677565439692], [-118.19473513084134, 33.76691956470707], [-118.18961800917958, 33.76857154547055], [-118.4787746918962, 33.99703180495855], [-118.4813155664821, 33.99972347033686], [-118.49241279699834, 34.01593795884531], [-118.49775002734836, 34.01522943519396], [-118.49929282049737, 34.01806349433012],
      // milan
      [9.201388529646607, 45.47007903263102], [9.199612311995224, 45.47715900442034], [9.1818288673214, 45.47002354120784], [9.175941485561822, 45.472431907892], [9.174582859006051, 45.47746003404751], [9.203274100965444, 45.45075091189983], [9.192831239409657, 45.45789621222204], [9.185379273433767, 45.45215473657595], [9.175671250582297, 45.455711380523695], [9.168675185621026, 45.456924448030065], [9.175435428265018, 45.45816505832221], [9.185890222072828, 45.45557353020379], [9.171136169866571, 45.4575095194337], [9.157120890447942, 45.45130021983249], [9.161072566873202, 45.45159591632762], [9.180514815350733, 45.453206753743956], [9.174455578011447, 45.44222829749012], [9.188727885069227, 45.483151641417095],
      // munich
      [11.583742024005744, 48.15708254384896], [11.588154532525209, 48.164032105971955], [11.589094233421577, 48.1621517291303], [11.575913118418356, 48.13497600204755], [11.581120349654839, 48.139173739274895], [11.58040608342364, 48.13582172762992], [11.565339950285676, 48.1378180833797], [11.56641909781905, 48.133280877862035], [11.559755361922953, 48.13758403092129], [11.561859699611233, 48.14030257355745], [11.573541471647502, 48.14329100398797], [11.571895771658092, 48.14168879485271],
      // new-york
      [-74.00235810741408, 40.73926223335428], [-74.00637683409744, 40.74318990748412], [-74.00297218938893, 40.739117529300955], [-74.00084656256178, 40.73631339276966], [-74.0016459375955, 40.73179680063842], [-74.00122887236512, 40.73669524800397], [-73.96115073332088, 40.70951639415122], [-73.96661511305247, 40.7128958177517], [-73.95702217001234, 40.722002750895285], [-73.95825645652874, 40.72206956842018], [-73.95107770897778, 40.71474604447877], [-73.95589594104524, 40.71199528834532], [-73.98569742458683, 40.723111378422715], [-73.9871975937423, 40.72180389026545], [-73.98756013463272, 40.72260923021301], [-73.99805121115246, 40.72935374971283], [-73.99838708366927, 40.73254583095451], [-74.00280940449301, 40.72935374975731], [-74.00268345238925, 40.72917346155239], [-74.01314121423077, 40.70416307495506], [-73.97987593102357, 40.73100245623604], [-73.98318654397542, 40.72659304308959], [-73.98326680126387, 40.728584917615194], [-73.98850313425606, 40.72315516670284], [-73.99178189337228, 40.723512036181376], [-73.92000400229223, 40.70777453304285], [-73.92116059023844, 40.70982024388587], [-73.95307312535171, 40.57487172638065], [-73.96963315962103, 40.57421317423436], [-73.99963196516299, 40.5707885985895],
      // nuremberg
      [11.087309195792585, 49.45119422680801], [11.077281857667316, 49.447843119655175], [11.07216751252949, 49.45302676663914],
      // odesa
      [30.75188146716667, 46.48368056457207], [30.754794917604357, 46.47674069235839],
      // paris
      [2.3325275484013446, 48.885701900557734], [2.332986819646095, 48.884418384489834], [2.331685551122206, 48.883738862651114], [2.3341732703632943, 48.88235462292474], [2.3354362662908557, 48.881222034653916], [2.3397763524179425, 48.87153475468821], [2.3398911702425096, 48.87047744443498], [2.3456320608111696, 48.86735573141141], [2.355043852885103, 48.859482799448074], [2.3594069297194267, 48.85600785938459], [2.3664452612033244, 48.86472574254941], [2.3778786262500375, 48.86553003845404], [2.3651565293120598, 48.869507852458895], [2.363801708603006, 48.86620389804372], [2.3702317583978356, 48.85496506874176], [2.3719831120130834, 48.853508324082185], [2.3950857380844752, 48.87128680205021], [2.3980615798223255, 48.86285213682487],
      // portland
      [-122.66101816096001, 45.52162813762254], [-122.65823761291, 45.518566655143786], [-122.66166960364936, 45.51978013540176], [-122.66141538211073, 45.518677984699394], [-122.67142475254346, 45.52553996017298], [-122.67446070495743, 45.52605820226725], [-122.65981165666582, 45.52248023709706],
      // porto
      [-8.614729680906038, 41.146681825314516], [-8.61415032376837, 41.146184958232254],
      // rome
      [12.471507136377824, 41.890873298062616], [12.46891807079993, 41.890223375485846], [12.469189019511361, 41.886637476840406], [12.516770699827305, 41.89653232342863], [12.51558401575278, 41.89715799872232], [12.472551398274732, 41.89440721429875], [12.473066382401754, 41.89584073830798], [12.474181323642739, 41.875287050943854], [12.476174008486424, 41.87682573839814], [12.473849209502134, 41.8758732219579], [12.47294101790854, 41.897150758336835],
      // seoul
      [126.92405616864266, 37.552984624118054], [126.92250023486747, 37.552837505866606], [126.92028766852775, 37.550494891389505], [127.04282092110009, 37.52759044300244], [127.03984523883673, 37.52851039634754], [126.99765023250546, 37.53515520104274], [126.99698832812584, 37.534129194479235], [126.99741312106573, 37.53549481767344],
      // singapore
      [103.84002385750574, 1.291827926631413], [103.84626882925585, 1.2895422119515132], [103.84540088402207, 1.2899231645440636], [103.84855512411207, 1.282748547752675], [103.85444021614552, 1.2847591355706953], [103.85896655015057, 1.277329523967083], [103.86014052201625, 1.2802387507517068],
      // stuttgart
      [9.21940339217798, 48.802035722235956], [9.21555722061899, 48.804701539192365], [9.171068956292544, 48.78068389292142], [9.180865102986672, 48.77446291473146], [9.175982806186141, 48.77332802805566], [9.178196871030565, 48.771245257225274], [9.180036679932186, 48.78511056685136], [9.17864273982849, 48.78273239093721], [9.1712498789432, 48.77497383369564], [9.175013250179319, 48.773222902634956], [9.171584936177055, 48.77509319559172], [9.16891137769909, 48.76445277695137], [9.16825334231308, 48.76476630030109], [9.169977108680001, 48.763370752639105], [9.172499558191362, 48.77029261812987], [9.168734438819087, 48.76546471536659], [9.172248550398848, 48.770337736531104], [9.169042494028588, 48.76577305301683], [9.172408282918155, 48.770435492804324], [9.172819023210451, 48.77027757854293], [9.173423723858832, 48.76959327779056], [9.178993304759587, 48.77135259164132],
      // tokyo
      [139.7027328053693, 35.65825361484731], [139.69414729363223, 35.65881823383222], [139.69930308396954, 35.661932673272176], [139.7046923470267, 35.69367680640562], [139.73695404235343, 35.66176001933964], [139.7309064456402, 35.66161274785395], [139.73113714416866, 35.66469200427589], [139.67011552572404, 35.66245818673178], [139.66731759152816, 35.66185104963233], [139.71211300494105, 35.647995955705795], [139.7081571309394, 35.646905942258385], [139.79393706312487, 35.71281695980808], [139.70121280536284, 35.697859607742046], [139.70334270377805, 35.694962656102604], [139.70626914957086, 35.69359852106763],
      // vienna
      [16.339738523670206, 48.211763351618515], [16.352507855262786, 48.23150093574537], [16.339398008151477, 48.21125279589839], [16.340530682030135, 48.21283648496467], [16.33942011355927, 48.21271647761651], [16.37383372967446, 48.21720150856251], [16.362050338206757, 48.23481374362919], [16.37368266056066, 48.216849202044074], [16.362541312850226, 48.23443640213782], [16.363364092752903, 48.20839760033371], [16.360131317188035, 48.2075259126936], [16.35973196008817, 48.20707344232184], [16.364229160888954, 48.20415752060782], [16.33896115840318, 48.19360262764292], [16.387578700308467, 48.212103536756814], [16.4022759437793, 48.21350352581777], [16.394017336282445, 48.217313277171826], [16.3594907797131, 48.20130223541585], [16.352976715395442, 48.200199920312485], [16.369022131975356, 48.20209757678799], [16.372988165441683, 48.19969150334137], [16.373781372133067, 48.201245213917844], [16.366191046616137, 48.19686965019724], [16.359558157179578, 48.19208571839653], [16.355679910329485, 48.18998354650185], [16.358017459912503, 48.201903626972125], [16.34370383116945, 48.19825695461009], [16.344915208901085, 48.1972150104055], [16.358811553334732, 48.204327918421825], [16.37560519320607, 48.2119907376605], [16.373598346379197, 48.21700131868397], [16.36621911933682, 48.19767480928854], [16.362783324136643, 48.197812219484774], [16.40289379170426, 48.21144149239677],
    ];

    </script>
  </body>
</html>
