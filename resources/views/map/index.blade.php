<html>
<head>
  <!-- leafletのCDNを追加する -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
  <!-- マップを表示するdiv要素を作成する -->
  <div id="map" style="width: 100%; height: 100%;"></div>
  <script>

  // leafletのマップを作成する
    var map = L.map('map').setView([35.69807992575762, 139.41375152665768], 18); // 立川駅を中心に表示
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: "© <a href='https://www.openstreetmap.org/copyright'>OpenStreetMap</a> contributors",
      maxZoom: 20,
      maxNativeZoom: 18
    });
    var gsi = L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
      attribution: "<a href='https://maps.gsi.go.jp/development/ichiran.html' target='_blank'>地理院タイル</a>",
      maxZoom: 20,
      maxNativeZoom: 18
    });
    var m_mono = new L.tileLayer('https://tile.mierune.co.jp/mierune_mono/{z}/{x}/{y}.png', {
      attribution: "Maptiles by <a href='http://mierune.co.jp/' target='_blank'>MIERUNE</a>, under CC BY. Data by <a href='http://osm.org/copyright' target='_blank'>OpenStreetMap</a> contributors, under ODbL.",
      maxZoom: 20,
      maxNativeZoom: 18
    });
    var baseMaps = {
      "OpenStreetMaps" : osm,
      "地理院地図" : gsi,
      "MIERUNE MONO" : m_mono
    };
    L.control.layers(baseMaps).addTo(map);
    L.control.scale({imperial:false}).addTo(map);
    osm.addTo(map);//地理院地図をデフォルトに

    
    // 現在位置を取得する関数
    function onLocationFound(e) {
        // 現在位置の緯度経度を取得
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // 現在位置にマーカーを表示
        L.marker(e.latlng).addTo(map)
            .bindPopup("現在地<br>緯度: " + lat + "<br>経度: " + lng).openPopup();

        // 現在位置を地図の中心にする
        map.setView(e.latlng, 25);
    }

    // 現在位置の取得に失敗したときの関数
    function onLocationError(e) {
        alert(e.message);
    }

    // 現在位置の取得を試みる
    map.locate({setView: true, maxZoom: 16});

    // 現在位置の取得に成功したときのイベント
    map.on('locationfound', onLocationFound);

    // 現在位置の取得に失敗したときのイベント
    map.on('locationerror', onLocationError);

    var points = [
      @foreach ($models as $model)
        @switch($model->kinds)
          @case("text")
                {name: '{{ $model->title }}', lat: {{ $model->latitude }}, lng: {{ $model->longitude }}},
          @break

          @case("model")
            {name: '{{ $model->title }}', lat: {{ $model->latitude }}, lng: {{ $model->longitude }}},
          @break

          @case("image")
            {name: '{{ $model->title }}', lat: {{ $model->latitude }}, lng: {{ $model->longitude }}, image: '{{ $model->url }}'},
          @break
        @endswitch
      @endforeach
    ];

    // ポイントデータの配列をループして、マップにマーカーとポップアップを追加する
    for (var i = 0; i < points.length; i++) {
      var point = points[i];
      // マーカーを作成する
      var marker;
      if (point.image) {
        // 画像の場合は、iconオプションを追加する
        var icon = L.icon({
          iconUrl: point.image, // 画像のURLを指定する
          iconSize: [170, 170], // 画像のサイズを指定する
          iconAnchor: [25, 50], // 画像の中心点を指定する
          popupAnchor: [0, -50] // ポップアップの位置を指定する
        });
        marker = L.marker([point.lat, point.lng], {icon: icon}).addTo(map);
      } else {
        // 画像でない場合は、通常のマーカーを作成する
        marker = L.marker([point.lat, point.lng]).addTo(map);
      }
      // ポップアップを作成する
      var popup = L.popup().setContent(point.name);
      // マーカーにポップアップをバインドする
      marker.bindPopup(popup);
      //marker.bindPopup(popup, {closeOnClick: false}).openPopup();
    }
  </script>
</body>
</html>