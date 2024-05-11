<?php
include_once("..\admin\session\logged.php");
$sessionManager = new SessionManager();
$sessionManager->requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../../assets/images/favicon-32x32.png">
    <link rel="stylesheet" href="../../css/main.css">
    <title>Quantity Calculation</title>
</head>
<body>
    <div class="container-fluid">
        <!-- HEADER -->
        <header class="d-flex justify-content-between align-items-center">
            <div class="logo img-fluid px-2">
                <img src="../../../assets/images/green_tree-150-01-removebg-preview.png" alt="">
            </div>
            <div class="header-btn p-3">
                <button class="btn btn-secondary me-md-2 px-4 bg-primary" type="button">
                    <a class="text-white text-decoration-none" href="logout.php">Logout</a>
                </button>
            </div>
        </header>  
            <!-- QUANTITY CALCULATOR -->
            <div class="container m-5">
                <h4 class="quantity-title text-primary">Pack content</h4>
                <form class="quantity-form" action="">
                   <div class="row">
                        <div class="drug-wrapper col input-group">
                            <label class="col" for="drug-name">Drug name</label>
                            <input class="col form-control" type="text" id="drug-name">
                        </div>
                        <div class="per-pack-wrapper col input-group">
                            <label class="col" for="drug-name">Drug name</label>
                            <input class="col form-control" type="text" id="drug-name">
                        </div>
                   </div>
                </form>

            </div>
    </div>
</body>
</html>