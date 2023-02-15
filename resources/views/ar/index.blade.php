<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
        <script src="https://unpkg.com/aframe-look-at-component@0.8.0/dist/aframe-look-at-component.min.js"></script>
        <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/aframe-text-geometry-component@0.5.1/dist/aframe-text-geometry-component.min.js"></script>
        <script src="https://cdn.rawgit.com/donmccurdy/aframe-extras/v4.2.0/dist/aframe-extras.min.js"></script>
    </head>

    <body style="margin: 0; overflow: hidden;">
        <a-scene
            embedded
            loading-screen="enabled: false;"
            arjs="sourceType: webcam; debugUIEnabled: false;"
        >
        <a-assets>
            <a-asset-item id="exoFont" src="assets/exoBlack.typeface.json"></a-asset-item>
        </a-assets>

            @foreach ($models as $model)

                @switch($model->kinds)
                    @case("text")
                        <a-text 
                            value="{{ $model->title }}" 
                            font="assets/Exo2Bold.fnt" 
                            color="red" 
                            rotation="-90 90 00" 
                            align="center" 
                            scale="100 100 100" 
                            gps-entity-place="latitude: {{ $model->latitude }}; longitude: {{ $model->longitude }};"
                            look-at="[gps-camera]"
                        ></a-text>
                    @break

                    @case("model")
                        <a-assets>
                            <a-asset-items id="model{{ $model->id }}" src="{{ $model->url }}" ></a-asset-items>
                        </a-assets>
                        <a-entity
                            gps-entity-place="latitude: {{ $model->latitude }}; longitude: {{ $model->longitude }};"
                            gltf-model="#model{{ $model->id }}"
                            scale="50 50 50"
                            rotation="0 0 0"
                            pisition="0 -1 0"
                            animation-mixer
                        ></a-entity>
                    @break

                    @case("image")
                        <a-image
                            src="{{ $model->url }}"
                            look-at="[gps-camera]"
                            scale="10 10 10"
                            gps-entity-place="latitude: {{ $model->latitude }}; longitude: {{ $model->longitude }};"
                        ></a-image>
                    @break

                @endswitch

            @endforeach

            <a-camera gps-camera rotation-reader></a-camera>
        </a-scene>
    </body>
</html>
