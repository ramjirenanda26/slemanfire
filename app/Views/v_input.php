<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peta Lokasi Damkar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.min.css" integrity="sha512-oIQ0EBio8LJupRpgmDsIsvm0Fsr6c3XNHLB7at5xb+Cf6eQuCX9xuX8XXGRIcokNgdqL1ms7nqbQ6ryXMGxXpg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #map{
            height: 600px;
            width: 100%;

        }
        .container{
          margin-top:60px;
        }
    </style>

</head>
  <body>
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
                            <a class="nav-link" href="<?=base_url('')?>">
                            <i class="fas fa-map-marked-alt"></i>
                            Beranda
                            </a>
                        </li>
                    
                    <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('objek/table')?>">
                            <i class="fas fa-table"></i>
                                     Manajemen Asset
                            </a>
                        </li>
                        <?php endif; ?>

                            <a class="nav-link <?= auth()->loggedIn() ? 'text-danger': ''?>" aria-current="page" href=
                            "<?=auth()->loggedIn() ? base_url('logout') : base_url('login')?>">
                                <i class="fas fa-sign-in-alt"></i>
                                <?=auth()->loggedIn()? 'Logout':'Login'?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal">
                                    <i class="fas fa-info-circle"></i>
                                     Info
                            </a>
        </li>
    </div>
  </div>
</nav>
    <!-- <h1>Hello, world!</h1> -->
    <div class="container">
    <div class="card">
  <div class="card-header">
    <b>INPUT DATA</b> 
  </div>
  <div class="card-body">
  <form action="<?= base_url('objek/simpantambahdata') ?>" method="POST" enctype="multipart/form-data">
  <?=csrf_field(); ?>
  <div class="mb-3">
  <label for="input_nama" class="form-label">Nama</label>
  <input type="text" class="form-control <?=($validation->hasError('input_nama')) ? 'is-invalid' : '' ?>" 
  id="input_nama" name="input_nama" placeholder="Isikan nama Pos Pemadam Kebakaran">

  <div class="invalid-feedback">
  <?= $validation->getError('input_nama'); ?>
  </div>

</div>
<div class="mb-3">
  <label for="input_deskripsi" class="form-label">Deskripsi</label>
  <textarea class="form-control" id="input_deskripsi" name="input_deskripsi"  rows="3" ></textarea>
</div>

<div class="mb-3">
  <label for="input_longitude" class="form-label">Longitude</label>
  <input type="text" class="form-control <?=($validation->hasError('input_longitude')) ? 'is-invalid' : '' ?>
  " id="input_longitude" name="input_longitude" placeholder="Isikan longitude"  >
  
  <div class="invalid-feedback">
  <?= $validation->getError('input_longitude'); ?>
  </div>

</div>

<div class="mb-3">
  <label for="input_latitude" class="form-label">Latitude</label>
  <input type="text" class="form-control <?=($validation->hasError('input_longitude')) ? 'is-invalid' : '' ?> 
  " id="input_latitude" name="input_latitude" placeholder="Isikan latitude"  >
  
  <div class="invalid-feedback">
  <?= $validation->getError('input_latitude'); ?>
  </div>

</div>

<div id="map"></div>

<div class="mb-3">
  <label for="input_foto" class="form-label">Input Foto</label>
  <input type="file" class="form-control <?=($validation->hasError('input_foto')) ? 'is-invalid' : '' ?> 
  " id="input_foto" name="input_foto">
  <div class="invalid-feedback">
  <?= $validation->getError('input_foto'); ?>
  </div>
</div>


<div>
    <div class="mb-3 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">SIMPAN</button>
    </div>
</div>

  </div>
</div>
</form>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0/leaflet.min.js" integrity="sha512-TL+GX2RsOUlTndpkgHVnSQ9r6zldqHzfyECrdabkpucdFroZ3/HAhMmP2WYaPjsJCoot+0McmdPOLjmmicG9qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var center = [-7.9, 110.45];
        var map = L.map('map').setView(center, 10);
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