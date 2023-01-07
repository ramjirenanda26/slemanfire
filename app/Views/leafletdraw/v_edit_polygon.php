<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Lokasi Objek</title>
    <link href="https://unsorry.net/assets-date/images/favicon.png" rel="shortcut icon" type="image/png" />
    
    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        html,
        body,
        #map {
            height: 100%;
            width: 100%;
            margin: 0px;
            overflow: hidden;
        }

        #map {
            width: auto;
            height: calc(100%-56px);
            margin-top: 56px;
        }
    </style>
</head>

<body>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.min.js"></script>
    <!-- teraformer -->
    <script src="https://cdn.jsdelivr.net/npm/terraformer@1.0.12/terraformer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/terraformer-wkt-parser@1.2.1/terraformer-wkt-parser.min.js"></script>

    <!-- boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand " href="#">
                <i class="fas fa-map-marked-alt"></i>
                Peta Lokasi Objek</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <?php if (auth()->loggedIn()) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('objek'); ?>">
                                <i class="fas fa-plus-circle mx-1"></i>Tambah Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('objek/table'); ?>">
                                <i class="fas fa-table mx-1"></i>Tabel Data</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link active <?= auth()->loggedIn() ? 'text-danger' : '' ?>" href="<?= auth()->loggedIn() ? base_url('logout') : base_url('login') ?>">
                            <i class="fas fa-sign-in-alt "></i>
                            <?= auth()->loggedIn() ? 'Keluar' : 'Masuk' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('leafletdraw/delete'); ?>">
                            <i class="fas fa-trash mx-1"></i>Hapus Geometri Lokasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal">
                            <i class="fas fa-info-circle mx-1"></i>Info</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- map -->
    <div id="map"></div>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> Info </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>WebGIS ini dibuat oleh SIG UGM</p>
                    <p>With Love</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Polygon-->
    <div class="modal fade" id="polygonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Polygon</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('leafletdraw/simpan_edit_data_polygon') ?>" method="POST">
                        <?= csrf_field() ?>

                        <input type="hidden" name="id_polygon" id="id_polygon">

                        <label for="edit_polygon_name">Nama</label>
                        <input type="text" class="form-control" id="edit_polygon_name" name="edit_polygon_name">

                        <label for="edit_polygon_deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="edit_polygon_deskripsi" id="edit_polygon_deskripsi" rows="2"></textarea>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_point">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* Initial Map */
        var map = L.map("map").setView([1.3868980965602753, 99.28173504043164], 12);

        /* Tile Basemap */
        var basemap = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | <a href="https://www.unsorry.net" target="_blank">unsorry@2022</a>',
            }
        );
        basemap.addTo(map);

        // draw item
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        //GeoJSON Polygon
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
					layer.on({
						click: function (e) {
                            // open modal 
                            $('#id_polygon').val(feature.properties.id);
                            $('#edit_polygon_name').val(feature.properties.name);
                            $('#edit_polygon_deskripsi').val(feature.properties.deskripsi);
                            $('#polygonModal').modal('show');
                           
						},
						mouseover: function (e) {
							polygon.bindTooltip(feature.properties.nama, {
								sticky: true,
							});
						},
					});
				},
			});
			$.getJSON("<?= base_url('api/one_polygon') . "/" . $idpolygon ?>", function (data) {
				polygon.addData(data);
				map.addLayer(polygon);
                map.fitBounds(polygon.getBounds());
			});

            // draw control
        var drawControl = new L.Control.Draw({
            draw: {
                polygon: false,
                marker: false,
                polyline: false,
                circle: false,
                rectangle: false,
                circlemarker: false
            },
            edit : {
                featureGroup: polygon,
                edit: true,
                remove: false,
            },
        });

        map.addControl(drawControl);

        /* Draw Event */
        map.on(L.Draw.Event.EDITED, function(e) {
            var type = e.layerType;
            var layers = e.layers;
            
            layers.eachLayer(function (layer){
            // convert geometry to geoJSON
            var drawnItemsJSON = layer.toGeoJSON().geometry;

            // convert GeoJSON to WKT
            var drawnItemsWKT = Terraformer.WKT.convert(drawnItemsJSON);

            console.log(drawnItemsWKT)

            map.addLayer(layer);

            var confirm = window.confirm("Apakah Anda yakin ingin mengubah polygon ini?");

            if (confirm){
                // Edit  polygon dengan ajax
                $.ajax({
                    url: "<?= base_url('leafletdraw/simpan_edit_geom_polygon') ?>",
                    type: "POST",
                    data: {
                        "id" : <?= $idpolygon; ?>,
                        "geom": drawnItemsWKT,
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"},
                        
                        success: function(data) {
                            // redirect
                            window.location.href = "<?= base_url('leafletdraw/edit') ?>";
                            console.log("Data berhasil diubah");
                        },
                        error: function(data) {
                            console.log("Data gagal diubah");
                        }
                    });
                }
        });
    });

    </script>
</body>

</html>