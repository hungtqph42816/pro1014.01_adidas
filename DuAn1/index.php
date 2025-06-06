<?php
session_start();

require_once 'config/db.php';
include 'views/layouts/header.php';
include 'views/home.php';
include 'views/product_list.php';
include 'views/layouts/footer.php';
require_once '../routes/web.php';
