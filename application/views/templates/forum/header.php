<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $judul; ?></title>
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/logo-bl.png" type="image/x-icon">

    <!-- css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- jquery-ui -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/jquery_ui/jquery-ui.min.css">
    <!-- jquery datetimepicker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/jquery_datetimepicker/jquery.datetimepicker.min.css">
    <!-- mdi icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/mdi/css/materialdesignicons.min.css">
    <!-- lightbox -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/lightbox/dist/ekko-lightbox.css">
    <!-- owlCarousel -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/owlCarousel/dist/assets/owl.carousel.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/forum_style.css">
    <!-- chat css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/chat.css">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC|PT+Sans+Caption|Amaranth|Bowlby+One+SC|Coiny|Permanent+Marker|Bungee|Roboto+Slab|Tenor+Sans"
        rel="stylesheet">

    <!-- script -->
    <!-- jquery -->
    <script src="<?= base_url(); ?>assets/jquery/jquery.min.js"></script>
    <!-- jquery ui -->
    <script src="<?= base_url(); ?>assets/jquery_ui/jquery-ui.min.js"></script>
    <!-- jquery datetimepicker -->
    <script src="<?= base_url(); ?>assets/jquery_datetimepicker/jquery.datetimepicker.full.js"></script>
    <!-- bootstrap -->
    <script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- popper -->
    <script src="<?= base_url(); ?>assets/bootstrap/js/popper.min.js"></script>
    <!-- lightbox -->
    <script src="<?= base_url(); ?>assets/lightbox/dist/ekko-lightbox.min.js"></script>
    <!-- owlCarousel -->
    <script src="<?= base_url(); ?>assets/owlCarousel/dist/owl.carousel.min.js"></script>
    <!-- ckeditor -->
    <script src="<?= base_url(); ?>assets/ckeditor/ckeditor.js"></script>

</head>

<body>
    <!-- judul + logo -->
    <div class="container-fluid judul-header">
        <a href="<?= base_url(); ?>" class="logo">
            <img src="<?= base_url(); ?>assets/images/logo-ubl.png" alt="Universitas Budi Luhur" class="logo-judul">
        </a>
        <a href="<?= base_url('forums'); ?>" class="judul">
            Forums <span class="kms">Knowledge Management Systems - Univeristas Budi Luhur</span>
        </a>
    </div>
    <!-- .//judul + logo -->