<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url('');?>/css/index.css" type="text/css" rel="stylesheet" media="all" />
    <title>Sleman Fire: About Page</title>
  </head>
  <body>
    <section>
      <header>
        <a href="#"><img src="<?php echo base_url('');?>/img/bnpb (1).png" class="logo" /></a>
        <ul>
          <li><a href="<?= base_url()?>">Beranda</a></li>
          <li><a href="<?= base_url("view/about")?>">Tentang</a></li>
          <li><a href="<?= base_url("objek/map")?>">Peta Sebaran Damkar</a></li>
          <li class="nav-item">
					<a class="nav-link <?= auth()->loggedIn()? 'text-danger' : '' ?>
					"href="<?= auth()->loggedIn() ? base_url('logout') : base_url('login')?>
					">
					<i class="fas fa-sign-in-alt"></i>
					<?= auth()->loggedIn() ? 'Logout' : 'Login' ?></a>
					</li>
					<li class="nav-item">
					</li>
        </ul>
      </header>
      <div class="content">
        <div class="textBox">
          <h2>Apa itu <span>Sleman Fire?</span></h2>
          <p>
            Sleman Fire adalah sebuah platform website berbasis GIS yang menyediakan informasi mengenai sebaran lokasi posko pemadam kebakaran, cakupan area posko pemadam kebakaran, serta manajemen asset di masing-masing posko pemadam
            kebakaran di seluruh Kabupaten Sleman.
          </p>
        </div>
        <div class="imgBox">
          <img src="<?php echo base_url('');?>/img/pos.png" alt="damkar" />
        </div>
      </div>
    </section>
  </body>
</html>
