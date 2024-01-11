<?php

    echo '<div class="main-panel" id="main-panel">
    <nav class="navbar navbar-expand-lg navbar-transparent bg-primary navbar-absolute">
      <div class="container-fluid">
        <div class="navbar-wrapper">
          <div class="navbar-toggle">
            <button type="button" class="navbar-toggler">
              <span class="navbar-toggler-bar bar1"></span>
              <span class="navbar-toggler-bar bar2"></span>
              <span class="navbar-toggler-bar bar3"></span>
            </button>
          </div>
          <a class="navbar-brand" href="#pablo" style="color:#ff5900">Dashboard </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar navbar-kebab"></span>
          <span class="navbar-toggler-bar navbar-kebab"></span>
          <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
          
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#pablo" style="color:#ff5900">
                <i class="now-ui-icons media-2_sound-wave"></i>
                <p>
                  <span class="d-lg-none d-md-block">Stats</span>
                </p>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#ff5900">
                <i class="now-ui-icons location_world"></i>
                <p>
                  <span class="d-lg-none d-md-block">Some Actions</span>
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <!-- Çıkış yap seçeneği ekleniyor -->
                <a class="dropdown-item" href="logout.php">Çıkış Yap</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <!-- Account olarak adlandırılan butona tıklandığında açılır menü -->
              <a class="nav-link dropdown-toggle" id="accountDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#ff5900">
                <i class="now-ui-icons users_circle-08"></i>
                <p>
                  <span class="d-lg-none d-md-block">Account</span>
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                <!-- Çıkış yap seçeneği ekleniyor -->
                <a class="dropdown-item" href="info.php">Profil</a>
                <a class="dropdown-item" href="logout.php">Çıkış Yap</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>';
?>