<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/index.css" type="text/css" rel="stylesheet" media="all" />
    <title>Sleman Fire: Landing Page</title>
  </head>
  <body>
    <section>
      <header>
        <a href="#"><img src="img/bnpb (1).png" class="logo" /></a>
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
          <h2><span>Sleman Fire:</span> WebGIS Asset & Manajemen Damkar Sleman</h2>
          <p>Platform WebGIS yang menyediakan informasi sebaran posko damkar serta pemantauan manajemen asset damkar Kabupaten Sleman</p>
          <a href="<?= base_url("objek/map")?>">Mulai Eksplor!</a>
        </div>
        <div class="imgBox">
          <img src="img/damkar.png" alt="damkar" />
        </div>
      </div>
    </section>
  </body>
</html>
