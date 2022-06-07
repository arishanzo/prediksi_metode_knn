<?php
require_once "../config/config.php";
if (!isset($_SESSION['username'])) {
    echo "<script>window.location='" . base_url('') . "';</script>";
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Penjualan</title>

        <!-- Custom fonts for this template-->
        <link href="<?= base_url() ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../datatable/css/datatables.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <link href="../sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="<?= base_url() ?>/css/sb-admin-2.min.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">


                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                    <span>Sistem Prediksi KNN</span>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/dashboard/index.php">
                        <i class="fas fa-home"></i>
                        <span>Home</span></a>
                </li>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/barang/index.php">
                        <i class="fas fa-dolly-flatbed"></i>
                        <span>Barang</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/penjualan/index.php">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Data Penjualan</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/prediksi/index.php">
                        <i class="fas fa-poll"></i>
                        <span>Prediksi</span></a>
                </li>
            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">

                            <div class="sidebar-brand-text mx-3"></div>
                        </a>
                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">


                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="dropdown-item" href="../auth/logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>


                            </li>
                        </ul>

                    </nav>

                    <!-- Bootstrap core JavaScript-->
                    <script src="<?= base_url() ?>/vendor/jquery/jquery.min.js"></script>
                    <script src="<?= base_url() ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                    <script src="../datatable/js/datatables.min.js"></script>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.all.min.js"></script>
                    <script src="../sweetalert/sweetalert.min.js"></script>

                    <!-- Core plugin JavaScript-->
                    <script src="<?= base_url() ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

                    <!-- Custom scripts for all pages-->
                    <script src="<?= base_url() ?>/js/sb-admin-2.min.js"></script>

                    <script type="text/javascript" src="<?= base_url() ?>/chartjs/Chart.js"></script>
                <?php

            }
                ?>