<html>

<head>
    <title>Earthquake Markers</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <style>
        /*
 * Always set the map height explicitly to define the size of the div element
 * that contains the map.
 */
        #map {
            height: 100%;
        }

        /*
 * Optional: Makes the sample page fill the window.
 */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI9Dy68H76Ml1AW1D4oIdsR32z0PGE18Y&callback=initMap&v=weekly"
        defer></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        var map, marker;

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('b4ff51f92127edbe0ff6', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('specialline');
        channel.bind('rider-location', function(data) {
            marker.setPosition({
                lat: Number(data.lat),
                lng: Number(data.lng)
            })
            // alert(JSON.stringify(data));
        });
    </script>


    <script>
        function initMap() {
            const myLatLng = {
                lat: {{ $riders->lat ?? '25.2100' }},
                lng: {{ $riders->lng ?? '55.2900' }}
            };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: myLatLng,
            });
            // const icon = {
            //     url: "{{ asset('build/assets/img/uploads/avatars/1.png') }}", // url
            //     scaledSize: new google.maps.Size(35, 35), // scaled size
            //     origin: new google.maps.Point(0, 0), // origin
            //     anchor: new google.maps.Point(0, 0) // anchor
            // };
            // const image = "{{ asset('build/assets/img/uploads/avatars/1.png') }}";
            // "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";

            marker = new google.maps.Marker({
                position: myLatLng,
                map,
                title: "{{ $riders->name }}",
                label : {
                    text : 'ABOD',
                    fontFamily : 'cairo',
                    color: "white",
                    fontSize:"10px"

                },
                // label: {
                //     text: "abod",
                //     // fontFamily: "Material Icons",
                //     color: "yellow",
                //     fontSize: "20px",
                // },
            });
        }

        window.initMap = initMap;
    </script>


</body>

</html>
