<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>LeafletJS GeoJSON Point</title>
		<link
			href="https://unsorry.net/assets-date/images/favicon.png"
			rel="shortcut icon"
			type="image/png"
		/>
		<link
			rel="stylesheet"
			href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css"
		/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="http://localhost/petalokasiobjek/public/dist/leaflet.awesome-markers.css" />
		<style>
			html,
			body,
			#map {
				height: 100%;
				width: 100%;
				margin: 0px;
			}
			#map{
				width: auto;
				height: cal(100%-56px);
				margin-top: 56px;
			}
		</style>
	</head>
	<body>
		<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
		<script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
		<script src="http://localhost/petalokasiobjek/public/dist/leaflet.awesome-markers.js"></script>
		<!--NAVBAR-->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">
				<i class="fas fa-map-marked-alt mx-1" href="<?= base_url()?>"></i>Peta Lokasi Pos Damkar</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
				</li>

				<?php if (auth()->loggedIn()): ?>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('objek') ?>">
							<i class="fas fa-plus-circle"></i> Input Data</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('objek/table') ?>">
							<i class="fas fa-table"></i> Manajemen Asset</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('leafletdraw') ?>">
							<i class="fas fa-draw-polygon"></i> Tambah Data Spasial</a>
					</li>
				<?php endif; ?>

					<li class="nav-item">
					<a class="nav-link <?= auth()->loggedIn()? 'text-danger' : '' ?>
					"href="<?= auth()->loggedIn() ? base_url('logout') : base_url('login')?>
					">
					<i class="fas fa-sign-in-alt"></i>
					<?= auth()->loggedIn() ? 'Logout' : 'Login' ?></a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fas fa-info"></i> Info</a>
					</li>
				</ul>
				</div>
			</div>
		</nav>
		<!-- Map-->
		<div id="map"></div>

		<!-- Modal -->
			<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Info</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Sleman Fire dibuat menggunakan Codeigniter 4 dan Database PostgreSQL</p>
					<p>Dibuat oleh Ramji Renanda Sitorus</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
			</div>
		<script>
			/* Initial Map */
			var map = L.map("map").setView([-7.690077316284304, 110.40105510544743], 11);

			/* Tile Basemap */
			var basemap = L.tileLayer(
				"https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
				{
					attribution:
						'<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | <a href="https://www.unsorry.net" target="_blank">unsorry@2022</a>',
				}
			);

			basemap.addTo(map);

			var redMarker = L.AwesomeMarkers.icon({
        icon: "truck-pickup",
        markerColor: "red",
        stylePrefix: "fas",
        prefix: "fa",
      });


			/* GeoJSON Point */
			var point = L.geoJson(null, {
				pointToLayer: function (feature, latlng) {
          return L.marker(latlng, {
            icon: redMarker,
          });
        },
				onEachFeature: function (feature, layer) {
					var popupContent = "Nama Gedung: " + feature.properties.nama + "<br>" +
						"Deskripsi: " + feature.properties.deskripsi;
					layer.on({
						click: function (e) {
							point.bindPopup(popupContent);
						},
						mouseover: function (e) {
							point.bindTooltip(feature.properties.nama);
						},
					});
				},
			});
			$.getJSON("http://localhost/petalokasiobjek/public/api", function(data) {
				point.addData(data);
				map.addLayer(point);
			});

			

			/* GeoJSON Polygon */
			var polygon = L.geoJson(null, {
				/* Style polygon */
				style: function (feature) {
					return {
						color: "#3388ff",
						fillColor: "#3388ff",
						weight: 2,
						opacity: 1,
						fillOpacity: 0.2,
					};
				},
				onEachFeature: function (feature, layer) {
					var popupContent = "Desa: " + feature.properties.DESA + "<br>" +
						"Kecamatan: " + feature.properties.KECAMATAN + "<br>" +
						"Sumber Data: " + feature.properties.SUMBER;
					layer.on({
						click: function (e) {
							polygon.bindPopup(popupContent);
						},
						mouseover: function (e) {
							polygon.bindTooltip(feature.properties.kecamatan, {
								sticky: true,
							});
						},
					});
				},
			});
			$.getJSON("http://localhost/petalokasiobjek/public/data/AR_ADMIN_DES_SLEMAN.geojson", function (data) {
				polygon.addData(data);
				map.addLayer(polygon);
			});

			/* GeoJSON Line */
			var line = L.geoJson(null, {
				/* Style polyline */
				style: function (feature) {
					return {
						color: "#F68080",
						weight: 3,
						opacity: 1,
					};
				},
				onEachFeature: function (feature, layer) {
					var popupContent = "Kelas Jalan: " + feature.properties.keterangan + "<br>" +
						"Panjang: " + feature.properties.panjang_km + " km";
					layer.on({
						click: function (e) {
							line.bindPopup(popupContent);
						},
						mouseover: function (e) {
							line.bindTooltip(feature.properties.keterangan, {
								sticky: true,
							});
						},
					});
				},
			});
			$.getJSON("http://localhost/petalokasiobjek/public/data/lines.geojson", function (data) {
				line.addData(data);
				map.addLayer(line);
			});

			
		</script>
	</body>
</html>
