<!DOCTYPE html>
<html lang="<?= \app\core\Session::getAttribut('lang');?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <!---------- Dan Enriqué ----------->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= WEBROOT;?>assets/plugins/images/logoPF.jpg">

   <!-- <link rel="shortcut icon" href="<?/*= ASSETS; */?>plugins/images/favicon.ico" type="image/x-icon">-->


    <title><?= $this->lang['titre3'] ?></title>

    <!-- jQuery JavaScript -->
    <script src="<?= ASSETS; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Telephone CSS -->
    <link href="<?= ASSETS ?>plugins/telPlug/css/intlTelInput.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="<?= ASSETS; ?>ampleadmin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="<?= ASSETS; ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="<?= ASSETS; ?>plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/styleadmin.css" rel="stylesheet"/>
    <!-- color CSS -->
    <link href="<?= ASSETS; ?>ampleadmin-minimal/css/colors/default.css" id="theme" rel="stylesheet">
    <link href="<?= ASSETS; ?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" >
    <link href="<?= ASSETS; ?>plugins/bower_components/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?= ASSETS; ?>plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">

    <!-- CSS Validation -->
    <link href="<?= ASSETS; ?>plugins/formValidation.min.css">

    <!-- Jquery-confirm CSS -->
    <link href="<?= ASSETS; ?>plugins/jconfirm/css/jquery-confirm.css" rel="stylesheet"/>

    <!-- select2 CSS -->
    <link href="<?= ASSETS ?>plugins/select2/select2.min.css" rel="stylesheet">


<style>
    .fa-toggle-on{
        color: green !important;
    }
    .fa-toggle-off{
        color: red !important;
    }
</style>
</head>
<body data-racine="<?= RACINE; ?>" data-webroot="<?= WEBROOT; ?>" data-assets="<?= ASSETS; ?>" class="fix-header">