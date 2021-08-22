<?php
session_start();
if (empty($_SESSION['login_id'])) {
  header("Location: owner-login.php");
}
include './conf_config.php';

if (isset($_GET['nobill'])) {
  $key = $_GET['nobill'];
  $reports = mysqli_query($conn, "SELECT a.*,b.nama_lengkap FROM transaksi a LEFT JOIN karyawan b ON a.idkaryawan=b.id_karyawan WHERE a.no_nota LIKE '%$key%'");
} else {
  $reports = mysqli_query($conn, "SELECT a.*,b.nama_lengkap FROM transaksi a LEFT JOIN karyawan b ON a.idkaryawan=b.id_karyawan");
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
    KepKop - Owner Report
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
            <form class="navbar-form mr-2">
              <div class="input-group no-border">
                <input type="text" value="" name="search-product" id="search-report" class="form-control px-2" placeholder="Search Report By Bill Number">
                <button type="button" class="btn btn-white btn-round btn-just-icon btn-search">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
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
                  <div class="row" style="align-items: center;">
                    <h4 class="card-title col text-left">Report</h4>
                  </div>
                  <p class="card-category"> Here is a list of all of transactions</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          Bill Number
                        </th>
                        <th>
                          Date Transaction
                        </th>
                        <th>
                          Cashier
                        </th>
                        <th>
                          Grand Total
                        </th>
                      </thead>
                      <tbody>
                        <?php $total = 0;
                        while ($row = mysqli_fetch_array($reports)) {

                          $total += (int)$row['gtotal'];
                          $id = $row['idtransaksi'];

                        ?>
                          <tr onclick="detailTran('<?= $id ?>')">
                            <td>
                              <?= $row['no_nota'] ?>
                            </td>
                            <td>
                              <?= date('Y-m-d H:i:s', strtotime($row['tgl_transaksi'])) ?>
                            </td>
                            <td>
                              <?= $row['nama_lengkap'] ?>
                            </td>
                            <td>
                              <?= number_format($row['gtotal'], 0, ',', '.') ?>
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
    function detailTran(id) {
      window.open('http://localhost/kepkop/report-detail.php?idtransaksi=' + id)
    }

    $('.btn-search').click(function() {
      let search = $('#search-report').val();
      window.open('http://localhost/kepkop/owner-report.php?nobill=' + search, "_self");
    });
  </script>
  
</body>

</html>