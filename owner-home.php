<?php

include 'conf_config.php';
session_start();
if(empty($_SESSION['login_id'])){
    header("Location: owner-login.php");
}
$date = date('Y-m-d');
$today = date('d F Y');
$transactions = mysqli_query($conn, "SELECT * FROM transaksi WHERE tgl_transaksi LIKE '$date%'");
$transactionChart = mysqli_query($conn, "SELECT SUM(gtotal) as gtotal, tgl_transaksi FROM transaksi  GROUP BY DATE(tgl_transaksi) ORDER BY tgl_transaksi DESC LIMIT 5");
$countTransaction = mysqli_num_rows($transactions);
$totalAmount = 0;
$arrChart = [];
$arrtgl = [];
if(!empty($countTransaction)){
  while($row = mysqli_fetch_array($transactions)){
    $totalAmount += (int)$row['gtotal'];
    
  }
}
if(mysqli_num_rows($transactionChart) > 0){
  while($crt = mysqli_fetch_array($transactionChart)){
    array_push($arrChart, (int)$crt['gtotal']);
    array_push($arrtgl, date('d M Y', strtotime($crt['tgl_transaksi'])));
  }
}
$arrChart = array_reverse($arrChart);
$arrtgl = array_reverse($arrtgl);
$average = !empty($countTransaction) ? intval($totalAmount) / intval($countTransaction) : 0;
$dataChart = json_encode($arrChart);
$dataTgl = json_encode($arrtgl);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="vendors/material-dashboard/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="images/logoo.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    KepKop - Owner Dashboard
  </title>
  <?php include 'owner-header.php' ?>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="vendors/material-dashboard/assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo"><span class="simple-text logo-normal">
          Kepkop
        </span></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
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
            <a class="navbar-brand" href="javascript:;">Dashboard</a>
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
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">receipt_long</i>
                  </div>
                  <p class="card-category">Total Transaction</p>
                  <h3 class="card-title"><?= $countTransaction ?>
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> <?= $today ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">Revenue</p>
                  <h3 class="card-title">Rp <?= number_format($totalAmount, 0, ',', '.') ?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> <?= $today ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">receipt_long</i>
                  </div>
                  <p class="card-category">Average Amount Transaction</p>
                  <h3 class="card-title">Rp <?= number_format($average, 0, ',', '.')?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> <?= $today ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <canvas id="myChart" width="400" height="400"></canvas>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Sales</h4>
                  <!-- <p class="card-category"> -->
                    <!-- <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p> -->
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> <?= $arrtgl[0] . ' - ' . $arrtgl[count($arrtgl) - 1] ?>
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
  <script src="vendors/chart.js/dist/Chart.min.js"></script>
  <script>
    var dataChart = '<?= $dataChart ?>';
    var dataLabel = '<?= $dataTgl ?>';
    var ctx = document.getElementById('myChart');
    dataChart = JSON.parse(dataChart);
    dataLabel = JSON.parse(dataLabel);
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dataLabel,
        datasets: [{
          label: 'Total Amount',
          data: dataChart,
          backgroundColor: [
            'rgba(255, 255, 255, 0.5)'
          ],
          borderColor: [
            'rgba(255, 255, 255, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  </script>
  
</body>

</html>