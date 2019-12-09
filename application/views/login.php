<?php $this->load->view('templates/header'); ?>
<div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
    <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
            <div class="col-lg-4 mx-auto">
                <div class="auto-form-wrapper">
                    <?php if($this->session->flashdata('salah')){ ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" style="font-size:13px;">
                        <?= $this->session->flashdata('salah'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:-5px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php } ?>
                    <?php echo form_open('login', array('id' => 'formLogin')); ?>
                        <div class="form-group">
                            <label class="label">Username</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                    <i class="mdi mdi-check-circle-outline"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="*********">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                    <i class="mdi mdi-check-circle-outline"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary submit-btn btn-block" type="submit">Login</button>
                        </div>
                    <?php echo form_close(); ?>
                    <div id="respon" class="text-center"></div>
                </div><br>
                <p class="footer-text text-center">copyright © 2018 Team. All rights reserved.</p>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
<?php $this->load->view('templates/footer_2'); ?>