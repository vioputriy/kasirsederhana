<?php
session_start();
include './conf_config.php';
if (isset($_GET['productid']) && !empty($_GET['productid'])) {
    $productid = $_GET['productid'];
    $product = mysqli_query($conn, "SELECT a.*, b.nama_kategori FROM item a INNER JOIN kategori_item b ON a.idkategori=b.idkategori WHERE a.itemid = '$productid'");
    $rproduct = mysqli_fetch_array($product);
}
$categories = mysqli_query($conn, "SELECT * FROM kategori_item");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="vendors/material-dashboard/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="images/logoo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Kepkop - Owner Create Product
    </title>
    <?php include 'owner-header.php' ?>

</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="vendors/material-dashboard/assets/img/sidebar-1.jpg">
            <div class="logo"><span class="simple-text logo-normal">
                    Kepkop
                </span></div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="owner-home.php">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="owner-product.php">
                            <i class="material-icons">inventory_2</i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="owner-category.php">
                            <i class="material-icons">category</i>
                            <p>Product Categories</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="owner-karyawan.php">
                            <i class="material-icons">people</i>
                            <p>Cashiers</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="owner-report.php">
                            <i class="material-icons">report</i>
                            <p>Report</p>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand" href="javascript:;">Product</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <form class="navbar-form">
                        </form>
                        <ul class="navbar-nav">
                            <li>
                            <a href="conf_logout.php" style="border: none;" title="Logout"><i class="material-icons">exit_to_app</i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php if (!empty($_SESSION['msg'])) { ?>
                            <div class="<?= strpos($_SESSION['msg'], 'Failed') !== FALSE ? 'bg-danger' : 'bg-success' ?> text-white mx-3 py-2 px-2 rounded" style="width: 100%; font-weight: bold;"><?= $_SESSION['msg']; ?></div>
                        <?php }
                        unset($_SESSION['msg']); ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title"><?= isset($_GET['productid']) && !empty($_GET['productid']) ? 'Edit Product' : 'Create Product' ?></h4>
                                </div>
                                <div class="card-body">
                                    <form action="func_owner.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="productid" value="<?= isset($_GET['productid']) && !empty($_GET['productid']) ? $_GET['productid'] : '' ?>">
                                        <input type="hidden" name="func" value="<?= isset($_GET['productid']) && !empty($_GET['productid']) ? 'editproduct' : 'createproduct' ?>">
                                        <div class="row py-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Product Name</label>
                                                    <input type="text" class="form-control" name="product_name" id="product_name" value="<?= isset($_GET['productid']) && !empty($_GET['productid']) && !empty($rproduct['nama_item']) ? $rproduct['nama_item'] : '' ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row py-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Product Price</label>
                                                    <input type="text" class="form-control" name="product_price" id="product_price" value="<?= isset($_GET['productid']) && !empty($_GET['productid']) && !empty($rproduct['harga_item']) ? number_format($rproduct['harga_item'], 0, ',', '') : '' ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row py-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Product Category</label>
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="">-- Choose Category --</option>
                                                        <?php while ($row = mysqli_fetch_array($categories)) { ?>
                                                            <option value="<?= $row['idkategori'] ?>" <?= $rproduct['idkategori'] == $row['idkategori'] ? 'selected' : '' ?>><?= $row['nama_kategori'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row py-2">
                                            <div class="col-md-12">
                                                <img id="blah" class="d-none" src="#" alt="your image" />
                                                <div class="form-group">
                                                    <label class="bmd-label-floating badge badge-primary text-white p-2" style="font-size: 18px;" for="image_product"><i class="material-icons">insert_photo</i> Browse Image</label>
                                                    <input type="file" class="form-control" name="image_product" id="image_product" onchange="readURL(this)">
                                                    <input type="hidden" value="<?= isset($_GET['productid']) && !empty($_GET['productid']) && !empty($rproduct['image']) ? $rproduct['image'] : '' ?>" name="imagelama">
                                                    <span><?= isset($_GET['productid']) && !empty($_GET['productid']) && !empty($rproduct['image']) ? $rproduct['image'] : '' ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row py-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Product Desc</label>
                                                    <textarea class="form-control" rows="5" name="product_desc" id="product_desc"><?= isset($_GET['productid']) && !empty($_GET['productid']) && !empty($rproduct['descitem']) ? $rproduct['descitem'] : '' ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary pull-right"><?= isset($_GET['productid']) && !empty($_GET['productid']) ? 'Edit Product' : 'Create Product' ?></button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">

                </div>
            </footer>
        </div>
    </div>
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Filters</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger active-color">
                        <div class="badge-colors ml-auto mr-auto">
                            <span class="badge filter badge-purple" data-color="purple"></span>
                            <span class="badge filter badge-azure" data-color="azure"></span>
                            <span class="badge filter badge-green" data-color="green"></span>
                            <span class="badge filter badge-warning" data-color="orange"></span>
                            <span class="badge filter badge-danger" data-color="danger"></span>
                            <span class="badge filter badge-rose active" data-color="rose"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">Images</li>
                <li class="active">
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="vendors/material-dashboard/assets/img/sidebar-1.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="vendors/material-dashboard/assets/img/sidebar-2.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="vendors/material-dashboard/assets/img/sidebar-3.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="vendors/material-dashboard/assets/img/sidebar-4.jpg" alt="">
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php include 'owner-footer.php' ?>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
                $('#blah').removeClass('d-none')
            }
        }
    </script>

</body>

</html>