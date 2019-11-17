<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $titulo ?></title>

    <!--Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('/application/assets/bootstrap/css/bootstrap.css') ?>">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?php echo base_url('/application/assets/datatables/datatables.css') ?>">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="<?php echo base_url('/application/assets/fontawesome/css/all.css') ?>">

    <!-- Full Calendar -->
    <link rel="stylesheet" href="<?php echo base_url('/application/assets/fullcalendar/packages/core/main.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/application/assets/fullcalendar/packages/daygrid/main.css') ?>">

    <!-- Arquivo Principal de CSS -->
    <link rel="stylesheet" href="<?php echo base_url('/application/assets/personalizado/css/principal.css') ?>">

    <!-- Arquivos CSS personalizados -->
    <?php foreach ($css_array as $css) { ?>
        <link rel="stylesheet" href="<?php echo $css ?>">
    <?php } ?>

</head>
<body <?php echo ( ! empty($id_body) ? 'id="'.$id_body.'" ' : ''); echo ( ! empty($classe_body) ? 'class="'.$classe_body.'"' : ''); ?>>
