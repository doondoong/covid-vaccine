<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>전국예방접종센터</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/pavicon1.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="https://www.data.go.kr/" target="_blank">자료출처_공공데이터포털</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="https://kim-portpolio.herokuapp.com/">BACK</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                            </ul>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>COVID-19 백신 예방접종 센터</h1>
                <p class="lead">공공 API를 연동하여 전국의 코로나 백신 예방접종 센터를 표시하였습니다.</p>
                <p>장소의 명칭과 연락처를 표시하였습니다.</p>

                    <div id="map" style="width: 100%;height: 70vh;"></div>
                    
                    <script
                        src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=5559ee2cb69f113b5b1a42efc1079a70&libraries=clusterer"></script>
                    <script>
                        const url =
                            'https://api.odcloud.kr/api/15077586/v1/centers?page=1&perPage=10000&serviceKey=JY2IrnH%2BeDL0QgjOWdN%2BMl391sDS2pEHx6nUh4sGXoWXY6XDdyAEd93qh09Je7VB7EodOBQT6nZJGJthmTh9fw%3D%3D';

                        var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
                            mapOption = {
                                center: new kakao.maps.LatLng(37.553174, 126.972625), // 지도의 중심좌표
                                level: 4, // 지도의 확대 레벨
                                mapTypeId: kakao.maps.MapTypeId.ROADMAP // 지도종류
                            };

                        // 지도를 생성한다 
                        var map = new kakao.maps.Map(mapContainer, mapOption);

                        var clusterer = new kakao.maps.MarkerClusterer({
                            map: map, // 마커들을 클러스터로 관리하고 표시할 지도 객체 
                            averageCenter: true, // 클러스터에 포함된 마커들의 평균 위치를 클러스터 마커 위치로 설정 
                            minLevel: 9 // 클러스터 할 최소 지도 레벨 
                        });

                        // 인포윈도우를 표시하는 클로저를 만드는 함수입니다 
                        function makeOverListener(map, marker, infowindow) {
                            return function () {
                                infowindow.open(map, marker);
                            };
                        }

                        // 인포윈도우를 닫는 클로저를 만드는 함수입니다 
                        function makeOutListener(infowindow) {
                            return function () {
                                infowindow.close();
                            };
                        }

                        fetch(url)
                            .then((res) => res.json())
                            .then((myJson) => {
                                var markers = [];
                                const data = myJson.data;

                                for (var i = 0; i < data.length; i++) {
                                    // 지도에 마커를 생성하고 표시한다
                                    var marker = new kakao.maps.Marker({
                                        position: new kakao.maps.LatLng(data[i]['lat'], data[i]['lng']), // 마커의 좌표
                                        map: map // 마커를 표시할 지도 객체
                                    });

                                    // 인포윈도우를 생성합니다
                                    var infowindow = new kakao.maps.InfoWindow({
                                        content: data[i]['facilityName'] + "<br/>" + data[i]['phoneNumber'],
                                    });

                                    markers.push(marker);
                                    kakao.maps.event.addListener(
                                        marker,
                                        'mouseover',
                                        makeOverListener(map, marker, infowindow));
                                    kakao.maps.event.addListener(
                                        marker,
                                        'mouseout',
                                        makeOutListener(infowindow)
                                    );
                                }

                                // 클러스터러에 마커들을 추가합니다
                                clusterer.addMarkers(markers);
                            })
                    </script>

            </div>
        </div>
    </body>
</html>
