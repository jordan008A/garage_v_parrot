// IIFE for map
(function () {
  let setting = {
    "query": "1 Allée Gabriel Biénès, Toulouse, France",
    "width": 300,
    "height": 200,
    "satellite": false,
    "zoom": 18,
    "placeId": "ChIJDVsvDIW7rhIR2zL7KlVw--4",
    "cid": "0xeefb70552afb32db",
    "coords": [43.5821047, 1.4358032],
    "lang": "fr",
    "queryString": "1 Allée Gabriel Biénès, Toulouse, France",
    "centerCoord": [43.5821047, 1.4358032],
    "id": "map-9cd199b9cc5410cd3b1ad21cab2e54d3",
    "embed_id": "1040941"
  };
  let d = document;
  let s = d.createElement('script');
  s.src = 'https://1map.com/js/script-for-user.js?embed_id=1040941';
  s.async = true;
  s.onload = function (e) {
    window.OneMap.initMap(setting)
  };
  let to = d.getElementsByTagName('script')[0];
  to.parentNode.insertBefore(s, to);
})();
