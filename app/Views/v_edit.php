<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.min.css" integrity="sha512-oIQ0EBio8LJupRpgmDsIsvm0Fsr6c3XNHLB7at5xb+Cf6eQuCX9xuX8XXGRIcokNgdqL1ms7nqbQ6ryXMGxXpg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #map{
            height: 600px;
            width: 100%;
        }
    </style>

</head>
  <body>
    <!-- <h1>Hello, world!</h1> -->
    <div class="container">
    <div class="card">
  <div class="card-header">
    <b>EDIT DATA</b> 
  </div>
  <div class="card-body">
  <form action="<?= base_url('objek/simpaneditdata/') .'/'. $objek['id'] ?>" method="POST" enctype="multipart/form-data">
  <?=csrf_field(); ?>
  <div class="mb-3">
  <label for="input_nama" class="form-label">Nama</label>
  <input type="text" class="form-control text-primary" id="input_nama" name="input_nama" placeholder="Isikan nama Objek" 
  value ="<?=$objek['nama']?>">
</div>
<div class="mb-3">
  <label for="input_deskripsi" class="form-label">Deskripsi</label>
  <textarea class="form-control text-primary" id="input_deskripsi" name="input_deskripsi" rows="3"><?=$objek['deskripsi']?></textarea>
</div>

<div class="mb-3">
  <label for="input_longitude" class="form-label">Longitude</label>
  <input type="text" class="form-control text-primary" id="input_longitude" name="input_longitude" placeholder="Isikan longitude"
  value ="<?=$objek['longitude']?>">
</div>

<div class="mb-3">
  <label for="input_latitude" class="form-label">Latitude</label>
  <input type="text" class="form-control text-primary" id="input_latitude" name="input_latitude" placeholder="Isikan latitude"
  value ="<?=$objek['latitude']?>">
</div>

<div id="map"></div>

<div class="my-3 row">
  <div class="col-2">
    <img src="<?= base_url('upload/foto/') .'/'. $objek['foto'] ?>" alt="" width="150" height="100">
  </div>
  <div class="col-8">
  <label for="input_foto" class="form-label">Input Foto</label>
  <input type="file" class="form-control text-primary" id="input_foto" name="input_foto">
  <input type="hidden" name="input_foto_lama" value ="<?= $objek['foto'] ?>">
  </div>

</div>

<hr>
<div class="row">
  <div class="col">
    <a href="<?= base_url('objek/table') ?>" class="btn btn-secondary btn-sm mx-2">BATAL</a>
</div>
<div class="mb-3 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">SIMPAN</button>
</div>

  </div>
</div>
</form>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.min.js" integrity="sha512-TL+GX2RsOUlTndpkgHVnSQ9r6zldqHzfyECrdabkpucdFroZ3/HAhMmP2WYaPjsJCoot+0McmdPOLjmmicG9qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var center = [1.4064625526626648, 99.27624202738768];
        var map = L.map('map').setView(center, 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);

var marker = L.marker(center, {draggable: true}).addTo(map);

// event
marker.on('dragend', function (e){
    var lat = marker.getLatLng().lat;
    var lng = marker.getLatLng().lng;
    document.getElementById("input_latitude").value = lat;
    document.getElementById("input_longitude").value = lng;
})

// map moveend 
map.on('moveend', function (event){
  // get center
  var center = map.getCenter();
  var lng = center.lng;
  var lat = center.lat;

  //set marker position
  marker.setLatLng(center, {
    draggable: true
  }).update();

  //set input value
  document.getElementById("input_latitude").value = lat;
  document.getElementById("input_longitude").value = lng;
});
    </script>
</body>
</html>