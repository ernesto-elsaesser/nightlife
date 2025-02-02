<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Nightlife Map</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" />
  </head>
  <body>

      <div id="search">
        <input id="searchfield" type="text" placeholder="Search" />
      </div>
      <div id="citylist">
        <a class="citybox" href="#seoul"><span class="fi fi-kr"></span><span class="name">Seoul</span><span class="pop">10M</span></a>
        <a class="citybox" href="#london"><span class="fi fi-gb"></span><span class="name">London</span><span class="pop">9M</span></a>
        <a class="citybox" href="#new-york"><span class="fi fi-us"></span><span class="name">New York</span><span class="pop">9M</span></a>
        <a class="citybox" href="#tokyo"><span class="fi fi-jp"></span><span class="name">Tokyo</span><span class="pop">8M</span></a>
        <a class="citybox" href="#singapore"><span class="fi fi-sg"></span><span class="name">Singapore</span><span class="pop">6M</span></a>
        <a class="citybox" href="#bangkok"><span class="fi fi-th"></span><span class="name">Bangkok</span><span class="pop">5M</span></a>
        <a class="citybox" href="#los-angeles"><span class="fi fi-us"></span><span class="name">Los Angeles</span><span class="pop">4M</span></a>
        <a class="citybox" href="#dubai"><span class="fi fi-ae"></span><span class="name">Dubai</span><span class="pop">3M</span></a>
        <a class="citybox" href="#berlin"><span class="fi fi-de"></span><span class="name">Berlin</span><span class="pop">3M</span></a>
        <a class="citybox" href="#rome"><span class="fi fi-it"></span><span class="name">Rome</span><span class="pop">2M</span></a>
        <a class="citybox" href="#paris"><span class="fi fi-fr"></span><span class="name">Paris</span><span class="pop">2M</span></a>
        <a class="citybox" href="#hamburg"><span class="fi fi-de"></span><span class="name">Hamburg</span><span class="pop">2M</span></a>
        <a class="citybox" href="#vienna"><span class="fi fi-at"></span><span class="name">Vienna</span><span class="pop">2M</span></a>
        <a class="citybox" href="#kuala-lumpur"><span class="fi fi-my"></span><span class="name">Kuala Lumpur</span><span class="pop">1M</span></a>
        <a class="citybox" href="#milan"><span class="fi fi-it"></span><span class="name">Milan</span><span class="pop">1M</span></a>
        <a class="citybox" href="#munich"><span class="fi fi-de"></span><span class="name">Munich</span><span class="pop">1M</span></a>
        <a class="citybox" href="#odesa"><span class="fi fi-ua"></span><span class="name">Odesa</span><span class="pop">1M</span></a>
        <a class="citybox" href="#cologne"><span class="fi fi-de"></span><span class="name">Cologne</span><span class="pop">1M</span></a>
        <a class="citybox" href="#amsterdam"><span class="fi fi-nl"></span><span class="name">Amsterdam</span><span class="pop">0.7M</span></a>
        <a class="citybox" href="#athens"><span class="fi fi-gr"></span><span class="name">Athens</span><span class="pop">0.7M</span></a>
        <a class="citybox" href="#portland"><span class="fi fi-us"></span><span class="name">Portland</span><span class="pop">0.7M</span></a>
        <a class="citybox" href="#frankfurt-am-main"><span class="fi fi-de"></span><span class="name">Frankfurt am Main</span><span class="pop">0.7M</span></a>
        <a class="citybox" href="#stuttgart"><span class="fi fi-de"></span><span class="name">Stuttgart</span><span class="pop">0.6M</span></a>
        <a class="citybox" href="#dusseldorf"><span class="fi fi-de"></span><span class="name">Düsseldorf</span><span class="pop">0.6M</span></a>
        <a class="citybox" href="#dresden"><span class="fi fi-de"></span><span class="name">Dresden</span><span class="pop">0.6M</span></a>
        <a class="citybox" href="#bremen"><span class="fi fi-de"></span><span class="name">Bremen</span><span class="pop">0.5M</span></a>
        <a class="citybox" href="#lisbon"><span class="fi fi-pt"></span><span class="name">Lisbon</span><span class="pop">0.5M</span></a>
        <a class="citybox" href="#nuremberg"><span class="fi fi-de"></span><span class="name">Nuremberg</span><span class="pop">0.5M</span></a>
        <a class="citybox" href="#kherson"><span class="fi fi-ua"></span><span class="name">Kherson</span><span class="pop">0.3M</span></a>
        <a class="citybox" href="#porto"><span class="fi fi-pt"></span><span class="name">Porto</span><span class="pop">0.2M</span></a>
        <a class="citybox" href="#freiburg-im-breisgau"><span class="fi fi-de"></span><span class="name">Freiburg im Breisgau</span><span class="pop">0.2M</span></a>
      </div>
    </div>

    <script>
    const searchField = document.getElementById("searchfield");
    const cityBoxes = document.getElementsByClassName("citybox");

    searchField.addEventListener("input", function () {
      let query = searchField.value.toLowerCase();
      for (box of cityBoxes) {
        let slug = box.href.split('#')[1];
        if (slug.startsWith(query)) {
          box.style.display = 'inline-block';
        } else {
          box.style.display = 'none';
        }
      }
    });
    </script>
  </body>
</html>
