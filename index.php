<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Covid-vaccine</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">예방접종</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav> -->
        <!-- Page Content-->
        <section>
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5">
                    <div class="col-lg-6">
                        <h1 class="mt-5">코로나 예방접종센터 위치정보</h1>
                        <p>전국 코로나 예방접종센터의 위치 정보 입니다.</p>
                    </div>
                    <div id="map" style="width: 1920px;height: 1080px;"></div>

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
        </section>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
