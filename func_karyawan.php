<?php

session_start();
include "conf_config.php";

$func = $_POST['func'];

if ($func == 'addtocart') {
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];
    $getProduct = mysqli_query($conn, "SELECT * FROM item WHERE itemid='$product_id'");
    if (mysqli_num_rows($getProduct) > 0) {
        $product = mysqli_fetch_array($getProduct);
        $subtotal = (int)$quantity * $product['harga_item'];
        if (!empty($_SESSION['products'])) {
            $exist = false;
            $key = 0;
            foreach ($_SESSION['products'] as $item) {
                if ($item['product_id'] == $product_id) {
                    $_SESSION['products'][$key]['quantity'] = $_SESSION['products'][$key]['quantity'] + (int)$quantity;
                    $_SESSION['products'][$key]['subtotal'] = $_SESSION['products'][$key]['subtotal'] + $subtotal;
                    $exist = true;
                }
                $key++;
            }
            if ($exist == false) {
                $_SESSION['products'][] = [
                    'product_id' => $product['itemid'],
                    'nama_item' => $product['nama_item'],
                    'harga_item' => $product['harga_item'],
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'image' => $product['image']
                ];
            }
        } else {
            $_SESSION['products'][] = [
                'product_id' => $product['itemid'],
                'nama_item' => $product['nama_item'],
                'harga_item' => $product['harga_item'],
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'image' => $product['image']
            ];
        }
    }
    // unset($_SESSION['products']);
    echo json_encode($_SESSION['products']);
} else if ($func == 'changecart') {
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];
    if (!empty($_SESSION['products'])) {
        $key = 0;
        foreach ($_SESSION['products'] as $item) {
            if ($item['product_id'] == $product_id) {
                $subtotal = $item['harga_item'] * (int)$quantity;
                $_SESSION['products'][$key]['quantity'] = (int)$quantity;
                $_SESSION['products'][$key]['subtotal'] = $subtotal;
            }
            $key++;
        }
    }

    // unset($_SESSION['products']);
    echo json_encode($_SESSION['products']);
} else if ($func == 'deletecart') {
    $product_id = $_POST['product_id'];
    $products = [];
    if (!empty($_SESSION['products'])) {
        $key = 0;
        foreach ($_SESSION['products'] as $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['products'][$key]);
            } else {
                array_push($products, $_SESSION['products'][$key]);
            }
            $key++;
        }
    }
    $_SESSION['products'] = $products;
    // unset($_SESSION['products']);
    echo json_encode($_SESSION['products']);
} else if ($func == 'submitorder') {
    $gtotal = (int)$_POST['gtotal'];
    $paidreceived = (int)$_POST['paidreceived'];
    $paidchange = $paidreceived - $gtotal;
    $date = date('Y-m-d H:i:s');
    $noNota = 'KEPKOP-' . strtoupper(uniqid());
    $idkaryawan = $_SESSION['karyawan_id'];
    mysqli_query($conn, "INSERT INTO transaksi (gtotal,no_nota,tgl_transaksi,paidreceived,paidchange,idkaryawan) VALUES('$gtotal','$noNota','$date','$paidreceived','$paidchange','$idkaryawan')");
    $idtransaksi = mysqli_insert_id($conn);
    if (!empty($_SESSION['products'])) {
        foreach ($_SESSION['products'] as $item) {
            $itemid = $item['product_id'];
            $qty = $item['quantity'];
            $stotal = $item['subtotal'];
            mysqli_query($conn, "INSERT INTO transaksi_detail (idtransaksi,itemid,qty,stotal) VALUES('$idtransaksi','$itemid','$qty','$stotal')");
        }
    }
    $url = "struk.php?idtransaksi=$idtransaksi";
    unset($_SESSION['products']);
    echo "<script language='javascript'>window.location.href='" . $url . "'</script>";
}
