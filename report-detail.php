<?php
session_start();
if (empty($_SESSION['login_id'])) {
    header("Location: owner-login.php");
}
include './conf_config.php';
$idtransaksi = $_GET['idtransaksi'];
$detailtransaksi = mysqli_query($conn, "SELECT  c.qty, c.stotal, d.itemid, d.nama_item, d.harga_item, e.nama_kategori FROM transaksi_detail c
    LEFT JOIN item d ON c.itemid=d.itemid
    LEFT JOIN kategori_item e ON d.idkategori=e.idkategori WHERE c.idtransaksi='$idtransaksi'");
$transaksi = mysqli_query($conn, "SELECT a.*,b.nama_lengkap FROM transaksi a LEFT JOIN karyawan b ON a.idkaryawan=b.id_karyawan WHERE a.idtransaksi='$idtransaksi'");
if (mysqli_num_rows($transaksi) > 0) {
    $resulReport = mysqli_fetch_array($transaksi);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="vendors/material-dashboard/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="images/logoo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        KepKop - Owner Report Detail
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
                    <li class="nav-item">
                        <a class="nav-link" href="owner-home.php">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item ">
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
                    <li class="nav-item active">
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
                        <a class="navbar-brand" href="javascript:;">Report</a>
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <div class="row" style="align-items: center;">
                                        <h4 class="card-title col text-left">Report Detail</h4>
                                    </div>
                                    <p class="card-category"> Here is a detail of transaction</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <span style="font-weight: bold;">Bill Number</span>
                                        </div>
                                        <div>
                                            <span>: <?= $resulReport['no_nota'] ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <span style="font-weight: bold;">Date Transaction</span>
                                        </div>
                                        <div>
                                            <span>: <?= date('Y-m-d H:i:s', strtotime($resulReport['tgl_transaksi'])) ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <span style="font-weight: bold;">Cashier</span>
                                        </div>
                                        <div>
                                            <span>: <?= $resulReport['nama_lengkap'] ?></span>
                                        </div>
                                    </div>
                                    <div class="table-responsive py-3">
                                        <h5 style="font-weight: bold;">Detail Product</h5>
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>
                                                    Product Name
                                                </th>
                                                <th>
                                                    Product Price
                                                </th>
                                                <th>
                                                    Quantity
                                                </th>
                                                <th>
                                                    Subtotal
                                                </th>
                                            </thead>
                                            <tbody>
                                                <?php $total = 0;
                                                while ($row = mysqli_fetch_array($detailtransaksi)) {

                                                    $total += (int)$row['stotal'];

                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?= $row['nama_item'] ?>
                                                        </td>
                                                        <td>
                                                            <?= number_format($row['harga_item'], 0, ',', '.') ?>
                                                        </td>
                                                        <td>
                                                            <?= $row['qty'] ?>
                                                        </td>
                                                        <td>
                                                            <?= number_format($row['stotal'], 0, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr class="bg-primary text-white" style="font-weight: bold;">
                                                    <td class="text-right" colspan="3">Total</td>
                                                    <td><?= number_format($total, 0, ',', '.') ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <span style="font-weight: bold;">Grand Total</span>
                                        </div>
                                        <div>
                                            <span>: Rp <?= number_format($resulReport['gtotal'], 0, ',', '.') ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <span style="font-weight: bold;">Paid Received</span>
                                        </div>
                                        <div>
                                            <span>: Rp <?= number_format($resulReport['paidreceived'], 0, ',', '.') ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <span style="font-weight: bold;">Paid Change</span>
                                        </div>
                                        <div>
                                            <span>: Rp <?= number_format($resulReport['paidchange'], 0, ',', '.') ?></span>
                                        </div>
                                    </div>
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
</body>

</html>