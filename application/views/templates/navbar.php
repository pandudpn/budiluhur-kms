<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo base_url(); ?>">
            <img src="<?= base_url('assets/images/logo-bl.png'); ?>" alt="Universitas Budi Luhur" style="width: 60px!important; height:60px!important; margin-top:-2px;">
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url(); ?>">
            <img src="<?= base_url('assets/images/logo-bl.png'); ?>" alt="Universitas Budi Luhur" style="width: 60px!important; height:60px!important; margin-top:-2px;">
        </a>
    </div>
    <?php if($this->session->userdata('login')){ ?>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-xl-inline-block">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <span class="profile-text">Hello, <?php echo $login->nama; ?></span>
                    <img class="img-xs rounded-circle" src="<?php echo base_url('assets/images/faces/'.$login->foto_user); ?>" alt="<?php echo $login->foto_user; ?>">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <a class="dropdown-item mt-3" href="<?php echo base_url('login/logout'); ?>" style="padding-top: 10px; padding-bottom:10px;">
                        Logout <i class="mdi mdi-logout-variant"></i>
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
    <?php }else{ ?>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <div class="navbar-nav navbar-nav-right">
            <a href="<?php echo base_url('login'); ?>" style="text-decoration:none;list-style:none;color:#fff;letter-spacing:3px;margin-right:10px;">Login</a>
        </div>
    </div>
    <?php } ?>
</nav>
<div class="container-fluid page-body-wrapper">