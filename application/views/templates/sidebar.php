<?php $controller = $this->router->fetch_class(); 
$hak    = $this->session->userdata('hak');
$akses  = $this->session->userdata('akses');
?>
<!-- sidebar -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <?php if($this->session->userdata('login')){ ?>
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="user-wrapper">
                    <div class="profile-image">
                        <img src="<?php echo base_url('assets/images/faces/'.$login->foto_user); ?>" alt="<?= $login->foto_user; ?>">
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name"><?php echo $login->nama; ?></p>
                        <div>
                            <small class="designation text-muted">
                                <?php
                                echo $akses;
                                ?>
                            </small>
                            <span class="status-indicator online"></span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <?php } ?>
        <li class="nav-item <?php if($controller == 'home')echo 'active'; ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>">
                <i class="menu-icon mdi mdi-home"></i>
                <span class="menu-title">Home</span>
            </a>
        </li>
        <?php if($this->session->userdata('login') && $akses != "Dosen"){ ?>
            <?php if(substr($hak, 0, 1) == 'r' || substr($hak, 1, 1) == 'r'){ ?>
            <li class="nav-item <?php if($controller == 'user' || $controller == 'kategori')echo 'active'; ?>">
                <a class="nav-link" data-toggle="collapse" href="#ui-master" aria-expanded="false" aria-controls="ui-master">
                    <i class="menu-icon mdi mdi-file-cabinet"></i>
                    <span class="menu-title">Master</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-master">
                    <ul class="nav flex-column sub-menu">
                        <?php if($akses == "Administrator"){ ?>
                            <li class="nav-item <?php if($controller == 'akses')echo 'active'; ?>">
                                <a class="nav-link" href="<?php echo base_url('akses'); ?>">
                                    <i class="menu-icon mdi mdi-account-key-outline"></i>
                                    <span class="menu-title">Akses</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item <?php if($controller == 'user')echo 'active'; ?>">
                            <a class="nav-link" href="<?php echo base_url('user'); ?>">
                                <i class="menu-icon mdi mdi-account-plus-outline"></i>
                                <span class="menu-title">User</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if($controller == 'kategori')echo 'active'; ?>">
                            <a class="nav-link" href="<?php echo base_url('kategori'); ?>">
                                <i class="menu-icon mdi mdi-tag-multiple"></i>
                                <span class="menu-title">Kategori</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php } ?>
            <li class="nav-item <?php if($controller == 'document' || $controller == 'video')echo 'active'; ?>">
                <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="menu-icon mdi mdi-folder-multiple-image"></i>
                    <span class="menu-title">Media</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="auth">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item <?php if($controller == 'foto')echo 'active'; ?>">
                            <a class="nav-link" href="<?php echo base_url('document'); ?>">
                                <i class="menu-icon mdi mdi-file-document-box-multiple-outline"></i>
                                <span class="menu-title">Document</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if($controller == 'video')echo 'active'; ?>">
                            <a class="nav-link" href="<?php echo base_url('video'); ?>">
                                <i class="menu-icon mdi mdi-library-video"></i>
                                <span class="menu-title">Video</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php } ?>
        <?php if($this->session->userdata('login')){ ?>
            <li class="nav-item <?php if($controller == 'forums')echo 'active'; ?>">
                <a class="nav-link" href="<?php echo base_url('forums'); ?>">
                    <i class="menu-icon mdi mdi-forum-outline"></i>
                    <span class="menu-title">Forums</span>
                </a>
            </li>
            <li class="nav-item <?php if($controller == 'pesan')echo 'active'; ?>">
                <a class="nav-link" data-toggle="collapse" href="#pesan" aria-expanded="false" aria-controls="pesan">
                    <i class="menu-icon mdi mdi-message-outline"></i>
                    <span class="menu-title">Pesan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="pesan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item <?php if($this->uri->segment(2) == 'new')echo 'active'; ?>">
                            <a class="nav-link" href="<?php echo base_url('pesan/new'); ?>">
                                <i class="menu-icon mdi mdi-email-plus-outline"></i>
                                <span class="menu-title">Tulis Pesan Baru</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if($this->uri->segment(2) == 'inbox')echo 'active'; ?>">
                            <a class="nav-link" href="<?php echo base_url('pesan/inbox'); ?>">
                                <i class="menu-icon mdi mdi-inbox"></i>
                                <span class="menu-title">Pesan Masuk</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if($this->uri->segment(2) == 'sent')echo 'active'; ?>">
                            <a class="nav-link" href="<?php echo base_url('pesan/sent'); ?>">
                                <i class="menu-icon mdi mdi-send"></i>
                                <span class="menu-title">Pesan Keluar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('login/logout'); ?>">
                    <i class="menu-icon mdi mdi-logout"></i>
                    <span class="menu-title">Logout</span>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>
<!-- sidebar ends -->
<div class="main-panel">