<?php
require_once "../config/config.php";
unset($_SESSION['username']);
echo "<script>window.location='" . base_url('auth/login.php') . "';</script>";
