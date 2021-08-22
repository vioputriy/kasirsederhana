<?php
session_start();
include './conf_config.php';

$func = $_POST['func'];
$typedelete = $_GET['typedel'];

function redirect($url)
{
    echo "<script language='javascript'>window.location.href='" . $url . "'</script>";
}

if ($func == 'createproduct') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['category'];
    $product_desc = $_POST['product_desc'];
    $nama = '';
    if (!empty($_FILES['image_product']['tmp_name'])) {
        $ekstensi_diperbolehkan = array('png', 'jpg');
        $nama = $_FILES['image_product']['name'];
        $x = explode('.', $nama);
        $ekstensi = strtolower(end($x));
        $ukuran    = $_FILES['image_product']['size'];
        $file_tmp = $_FILES['image_product']['tmp_name'];

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 1044070) {
                move_uploaded_file($file_tmp, 'img/product/' . $nama);
            } else {
                $_SESSION['msg'] = "Image size too high";
                redirect('owner-product.php');
            }
        } else {
            $_SESSION['msg'] = "File extension not allowed to upload";
            redirect('owner-product.php');
        }
    }

    mysqli_query($conn, "INSERT INTO item (nama_item,harga_item,idkategori,image,descitem) VALUES('$product_name','$product_price','$product_category','$nama','$product_desc')");

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['msg'] = "Add Product Successfully";
    }else{
        $_SESSION['msg'] = "Add Product Failed";
    }
    redirect('owner-product.php');
} else if ($func == 'editproduct') {
    $product_id = $_POST['productid'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['category'];
    $product_desc = $_POST['product_desc'];
    $imagelama = $_POST['imagelama'];
    $nama = $imagelama;
    if (!empty($_FILES['image_product']['tmp_name'])) {
        $ekstensi_diperbolehkan = array('png', 'jpg');
        $nama = $_FILES['image_product']['name'];
        $x = explode('.', $nama);
        $ekstensi = strtolower(end($x));
        $ukuran    = $_FILES['image_product']['size'];
        $file_tmp = $_FILES['image_product']['tmp_name'];
        if (file_exists('img/product/' . $imagelama)) {
            unlink('img/product/' . $imagelama);
        }
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 1044070) {
                move_uploaded_file($file_tmp, 'img/product/' . $nama);
            } else {
                $_SESSION['msg'] = "Image size too high";
                redirect('create-product.php?productid=' . $product_id);
            }
        } else {
            $_SESSION['msg'] = "File extension not allowed to upload";
            redirect('create-product.php?productid=' . $product_id);
        }
    }

    mysqli_query($conn, "UPDATE item SET nama_item='$product_name',harga_item='$product_price',idkategori='$product_category',image='$nama',descitem='$product_desc' WHERE itemid='$product_id'");

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['msg'] = "Edit Product Successfully";
    }else{
        $_SESSION['msg'] = "Edit Product Failed";
    }
    redirect('create-product.php?productid=' . $product_id);
} else if ($func == 'createcategory') {
    $category_name = $_POST['category_name'];

    mysqli_query($conn, "INSERT INTO kategori_item (nama_kategori) VALUES('$category_name')");

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['msg'] = "Add Category Successfully";
    }else{
        $_SESSION['msg'] = "Add Category Failed";
    }
    redirect('owner-category.php');
} else if ($func == 'editcategory') {
    $category_id = $_POST['idkategori'];
    $category_name = $_POST['category_name'];

    mysqli_query($conn, "UPDATE kategori_item SET nama_kategori='$category_name' WHERE idkategori='$category_id'");

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['msg'] = "Edit Category Successfully";
    }else{
        $_SESSION['msg'] = "Edit Category Failed";
    }
    redirect('create-category.php?idkategori=' . $category_id);
} else if ($func == 'createcashier') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conpassword = $_POST['conpassword'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $fullname = $_POST['fullname'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $date = date('Y-m-d');
    if ($conpassword == $password) {
        mysqli_query($conn, "INSERT INTO karyawan (nama,pass,nama_lengkap, telp, email,kota_asal,jenis_kelamin,date_created) VALUES('$username','$password','$fullname','$phone','$email','$city','$gender','$date')");

        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['msg'] = "Add Cashier Successfully";
        }else{
            $_SESSION['msg'] = "Add Cashier Failed";
        }
    } else {
        $_SESSION['msg'] = "Confirm Password is not match";
    }

    redirect('owner-karyawan.php');
} else if ($func == 'editcashier') {
    $id_karyawan = $_POST['idkaryawan'];
    $phone = $_POST['phone'];
    $fullname = $_POST['fullname'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $date = date('Y-m-d');

    mysqli_query($conn, "UPDATE karyawan SET telp='$phone', nama_lengkap='$fullname', kota_asal='$city', jenis_kelamin='$gender' WHERE id_karyawan='$id_karyawan'");

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['msg'] = "Edit Cashier Successfully";
    }else{
        $_SESSION['msg'] = "Edit Cashier Failed";
    }
    redirect('create-cashier.php?idkaryawan=' . $id_karyawan);
}

if ($typedelete == 'product') {
    $product_id = $_GET['productid'];
    mysqli_query($conn, "UPDATE item SET isdel='1' WHERE itemid='$product_id'");
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['msg'] = "Delete Product Successfully";
    }else{
        $_SESSION['msg'] = "Delete Product Failed";
    }
    redirect('owner-product.php');
} else if ($typedelete == 'category') {
    $idkategori = $_GET['idkategori'];
    mysqli_query($conn, "UPDATE kategori_item SET isdel='1' WHERE idkategori='$idkategori'");
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['msg'] = "Delete Category Successfully";
    }else{
        $_SESSION['msg'] = "Delete Category Failed";
    }
    redirect('owner-category.php');
}else if ($typedelete == 'cashier') {
    $idkaryawan = $_GET['idkaryawan'];
    mysqli_query($conn, "UPDATE karyawan SET isdel='1' WHERE id_karyawan='$idkaryawan'");
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['msg'] = "Delete Cashier Successfully";
    }else{
        $_SESSION['msg'] = "Delete Cashier Failed";
    }
    redirect('owner-karyawan.php');
}
