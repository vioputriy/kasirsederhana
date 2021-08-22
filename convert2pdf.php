<?php

include './conf_config.php';
require_once __DIR__ . '/vendor/autoload.php ';

use Mpdf\Mpdf;

$idtransaksi = $_GET['idTransaksi'];
    $qTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE idtransaksi='$idtransaksi'");
    if (mysqli_num_rows($qTransaksi) > 0) {
        $rTransaksi = mysqli_fetch_array($qTransaksi);
    }

    $qTranDetail = mysqli_query($conn, "SELECT a.*,b.nama_item,b.harga_item FROM transaksi_detail a INNER JOIN item b ON a.itemid=b.itemid WHERE idtransaksi='$idtransaksi'");
    $output = '<div id="capture">
    <div class="container bootstrap snippets bootdeys">
        <div class="panel panel-default invoice" id="invoice">
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-6 top-left">
                    </div>

                    <div class="col-sm-6 top-right">
                        <h3 class="marginright">' . $rTransaksi['no_nota'] . '</h3>
                        <span class="marginright">' . date('d F Y H:i:s', strtotime($rTransaksi['tgl_transaksi'])) . '</span>
                    </div>

                </div>
                <hr>
                <div class="row">

                    <div class="col-xs-4 text-left payment-details">
                        <p class="lead marginbottom payment-info">Payment details</p>
                        <p>Date: ' . $rTransaksi['tgl_transaksi'] . '</p>
                        <p>Total Amount: ' . number_format($rTransaksi['gtotal'], 0, ',', '.') . '</p>
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

                        <tbody>';
    $no = 1;
    while ($row = mysqli_fetch_array($qTranDetail)) {
        $output .= '<tr>
                            <td class="text-center" style="text-align: center;">' . $no . '</td>
                            <td style="text-align: center;">' . $row['nama_item'] . '</td>
                            <td class="text-center" style="text-align: center;">' . $row['qty'] . '</td>
                            <td class="text-center" style="text-align: center;">' . number_format($row['harga_item'], 0, ',', '.') . '</td>
                            <td class="text-center" style="text-align: center;">' . number_format($row['stotal'], 0, ',', '.') . '</td>
                        </tr>';
        $no++;
    }

    $output .= '</tbody>
        </table>

    </div>

    <div class="row">
        <div class="col-md-5 margintop">


        </div>
        <div class="col-md-7 text-right invoice-total" style="text-align: right;">
            <p>Subtotal : Rp. ' . number_format($rTransaksi['gtotal'], 0, ',', '.') . '</p>
            <p>Total Paid : Rp. ' . number_format($rTransaksi['paidreceived'], 0, ',', '.') . ' </p>
            <p>Paid Change : Rp. ' . number_format($rTransaksi['paidchange'], 0, ',', '.') . ' </p>
        </div>
    </div>

</div>
</div>
</div>
</div>';
    $mpdf = new Mpdf();
    $mpdf->WriteHTML($output);
    $mpdf->Output($nama, 'I');