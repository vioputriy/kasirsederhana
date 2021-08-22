<?php
session_start();
include "./conf_config.php";
if (empty($_SESSION['karyawan_id'])) {
    header("Location: karyawan-login.php");
}
$idtransaksi = $_GET['idtransaksi'];
$qTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE idtransaksi='$idtransaksi'");
if (mysqli_num_rows($qTransaksi) > 0) {
    $rTransaksi = mysqli_fetch_array($qTransaksi);
}

$qTranDetail = mysqli_query($conn, "SELECT a.*,b.nama_item,b.harga_item FROM transaksi_detail a INNER JOIN item b ON a.itemid=b.itemid WHERE idtransaksi='$idtransaksi'");

?>
<?php include 'header.php'; ?>
<style>
    body {
        margin-top: 20px;
        background: #eee;
    }

    /*Invoice*/
    .invoice .top-left {
        font-size: 65px;
        color: #3ba0ff;
    }

    .invoice .top-right {
        text-align: right;
        padding-right: 20px;
    }

    .invoice .table-row {
        margin-left: -15px;
        margin-right: -15px;
        margin-top: 25px;
    }

    .invoice .payment-info {
        font-weight: 500;
    }

    .invoice .table-row .table>thead {
        border-top: 1px solid #ddd;
    }

    .invoice .table-row .table>thead>tr>th {
        border-bottom: none;
    }

    .invoice .table>tbody>tr>td {
        padding: 8px 20px;
    }

    .invoice .invoice-total {
        margin-right: -10px;
        font-size: 16px;
    }

    .invoice .last-row {
        border-bottom: 1px solid #ddd;
    }

    .invoice-ribbon {
        width: 85px;
        height: 88px;
        overflow: hidden;
        position: absolute;
        top: -1px;
        right: 14px;
    }

    .ribbon-inner {
        text-align: center;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        position: relative;
        padding: 7px 0;
        left: -5px;
        top: 11px;
        width: 120px;
        background-color: #66c591;
        font-size: 15px;
        color: #fff;
    }

    .ribbon-inner:before,
    .ribbon-inner:after {
        content: "";
        position: absolute;
    }

    .ribbon-inner:before {
        left: 0;
    }

    .ribbon-inner:after {
        right: 0;
    }

    .marginleft {
        margin-left: 100px;
    }



    @media(max-width:575px) {

        .invoice .top-left,
        .invoice .top-right,
        .invoice .payment-details {
            text-align: center;
        }

        .invoice .from,
        .invoice .to,
        .invoice .payment-details {
            float: none;
            width: 100%;
            text-align: center;
            margin-bottom: 25px;
        }

        .invoice p.lead,
        .invoice .from p.lead,
        .invoice .to p.lead,
        .invoice .payment-details p.lead {
            font-size: 22px;
        }

        .invoice .btn {
            margin-top: 10px;
        }

        .marginleft {
            margin-left: 10px;
        }

    }

    @media print {
        .invoice {
            width: 900px;
            height: 800px;
        }
    }
</style>
<div id="capture">
    <div class="container bootstrap snippets bootdeys">
        <div class="panel panel-default invoice" id="invoice">
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-6 top-left">
                    </div>
                    <input type="hidden" value="<?= $rTransaksi['idtransaksi']; ?>" id="id_transaksi">
                    <div class="col-sm-6 top-right">
                        <h3 class="marginright"><?= $rTransaksi['no_nota'] ?></h3>
                        <span class="marginright"><?= date('d F Y H:i:s', strtotime($rTransaksi['tgl_transaksi'])) ?></span>
                    </div>

                </div>
                <hr>
                <div class="row">

                    <div class="col-xs-4 text-left payment-details">
                        <p class="lead marginbottom payment-info">Payment details</p>
                        <p>Date: <?= $rTransaksi['tgl_transaksi'] ?></p>
                        <p>Total Amount: <?= number_format($rTransaksi['gtotal'], 0, ',', '.') ?></p>
                    </div>

                </div>

                <div class="row table-row" style="overflow-x:auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:5%; text-align: center;">#</th>
                                <th style="width:50%; text-align: center;" >Item</th>
                                <th class="text-center" style="width:15%; text-align: center;">Quantity</th>
                                <th class="text-center" style="width:15%; text-align: center;">Unit Price</th>
                                <th class="text-center" style="width:15%; text-align: center;">Total Price</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1;
                            while ($row = mysqli_fetch_array($qTranDetail)) { ?>
                                <tr>
                                    <td class="text-center" style="text-align: center;"><?= $no ?></td>
                                    <td style="text-align: center;"><?= $row['nama_item'] ?></td>
                                    <td class="text-center" style="text-align: center;"><?= $row['qty'] ?></td>
                                    <td class="text-center" style="text-align: center;"><?= number_format($row['harga_item'], 0, ',', '.') ?></td>
                                    <td class="text-center" style="text-align: center;"><?= number_format($row['stotal'], 0, ',', '.') ?></td>
                                </tr>
                            <?php $no++;
                            } ?>

                        </tbody>
                    </table>

                </div>

                <div class="row">
                    <div class="col-md-5 margintop">


                    </div>
                    <div class="col-md-7 text-right invoice-total" style="text-align: right;">
                        <p>Subtotal : Rp. <?= number_format($rTransaksi['gtotal'], 0, ',', '.') ?></p>
                        <p>Total Paid : Rp. <?= number_format($rTransaksi['paidreceived'], 0, ',', '.') ?> </p>
                        <p>Paid Change : Rp. <?= number_format($rTransaksi['paidchange'], 0, ',', '.') ?> </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="margintop marginleft mb-3">
    <p class="lead marginbottom">THANK YOU!</p>

    <button class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
    <a href="./karyawan-home.php"><button class="btn btn-primary"> <span> <span id="checkout">Order Menu</span></span> </button></a>

</div>
<script>
    $('#invoice-print').click(function() {
        let idtransaksi = $('#id_transaksi').val();
        window.open('http://localhost/kepkop/convert2pdf.php?idTransaksi='+idtransaksi);
    });
</script>
<?php
include "footer.php";
?>