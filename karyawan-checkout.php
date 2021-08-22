<?php
session_start();

if (empty($_SESSION['karyawan_id'])) {
    header("Location: karyawan-login.php");
}
if (isset($_SESSION['products']) && !empty($_SESSION['products'])) {
    $products = $_SESSION['products'];
} else {
    $products = [];
}
$gtotal = 0;
?>
<?php include 'header.php'; ?>

<style>
    body {
        color: #000;
        overflow-x: hidden;
        height: 100%;
        background-color: #fff;
        background-repeat: no-repeat
    }

    .plus-minus {
        position: relative
    }

    .plus {
        position: absolute;
        top: -4px;
        left: 2px;
        cursor: pointer
    }

    .minus {
        position: absolute;
        top: 8px;
        left: 5px;
        cursor: pointer;
    }

    .vsm-text:hover {
        color: #FF5252
    }

    .book,
    .book-img {
        width: 180px;
        height: 180px;
        border-radius: 5px
    }

    .book {
        margin: 20px 15px 5px 15px
    }

    .border-top {
        border-top: 1px solid #EEEEEE !important;
        margin-top: 20px;
        padding-top: 15px
    }

    .card {
        margin: 40px 0px;
        padding: 40px 50px;
        border-radius: 20px;
        border: none;
        box-shadow: 1px 5px 10px 1px rgba(0, 0, 0, 0.2)
    }

    input,
    textarea {
        background-color: #F3E5F5;
        padding: 8px 15px 8px 15px;
        width: 100%;
        border-radius: 5px !important;
        box-sizing: border-box;
        border: 1px solid #F3E5F5;
        font-size: 15px !important;
        color: #000 !important;
        font-weight: 300
    }

    input:focus,
    textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #9FA8DA;
        outline-width: 0;
        font-weight: 400
    }

    button:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        outline-width: 0
    }

    .pay {
        width: 80px;
        height: 40px;
        border-radius: 5px;
        border: 1px solid #673AB7;
        margin: 10px 20px 10px 0px;
        cursor: pointer;
        box-shadow: 1px 5px 10px 1px rgba(0, 0, 0, 0.2)
    }

    .gray {
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        -o-filter: grayscale(100%);
        -ms-filter: grayscale(100%);
        filter: grayscale(100%);
        color: #E0E0E0
    }

    .gray .pay {
        box-shadow: none
    }

    #tax {
        border-bottom: 1px lightgray solid;
        margin-top: 10px;
        padding-top: 10px
    }

    .btn-blue {
        border: none;
        border-radius: 10px;
        background-color: #673AB7;
        color: #fff;
        padding: 8px 15px;
        margin: 20px 0px;
        cursor: pointer
    }

    .btn-blue:hover {
        background-color: #311B92;
        color: #fff
    }

    #checkout {
        float: left
    }

    #check-amt {
        float: right
    }

    @media screen and (max-width: 768px) {

        .book,
        .book-img {
            width: 150px;
            height: 150px
        }

        .card {
            padding-left: 15px;
            padding-right: 15px
        }

        .mob-text {
            font-size: 13px
        }


    }

    .pad-left {
        padding-left: 30px
    }
</style>

<div class="container px-4 py-5 mx-auto">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="row d-flex justify-content-center">
                            <div class="col-5">
                                <h4 class="heading">Order Item</h4>
                            </div>
                            <div class="col-7">

                            </div>
                        </div>
                        <div class="body-cart">
                            <?php foreach ($products as $product) { ?>
                                <div class="row d-flex justify-content-center border-top">
                                    <div class="col-5">
                                        <div class="row d-flex">
                                            <div class="book"> <img src="./img/product/<?= !empty($product['image']) ? $product['image'] : 'coffee.jpg' ?>" class="book-img"> </div>
                                            <div class="my-auto flex-column d-flex pad-left">
                                                <h6 class="mob-text"><?= $product['nama_item'] ?></h6>
                                                <span id="harga<?= $product['product_id']; ?>" price="<?= $product['harga_item'] ?>">Rp. <?= number_format($product['harga_item'], 0, ',', '.') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-auto col-7 text-right">

                                        <h6 class="mob-text" id="subtotal<?= $product['product_id']; ?>">Rp. <?= number_format($product['subtotal'], 0, ',', '.') ?></h6>
                                        <div class="row d-flex justify-content-end px-3">
                                            <button class="badge badge-primary p-2 mr-1 plus-qty" style="border: none;" id="plus-qty<?= $product['product_id']; ?>" product-id="<?= $product['product_id']; ?>">+</button>
                                            <span class="align-middle" id="qty<?= $product['product_id']; ?>"><?= $product['quantity']; ?></span>
                                            <button class="badge badge-primary p-2  ml-1 min-qty" style="border: none;" id="min-qty<?= $product['product_id']; ?>" product-id="<?= $product['product_id']; ?>">-</button>
                                            <!-- <p class="mb-0" id="cnt1">1</p>
                                            <div class="d-flex flex-column plus-minus"> <span class="vsm-text plus ">+</span> <span class="vsm-text minus">-</span> </div> -->
                                        </div>
                                        <br>
                                        <span class="mt-2 del-cart" style="color: red; cursor: pointer;" product-id="<?= $product['product_id']; ?>">Hapus</span>

                                    </div>
                                </div>
                            <?php $gtotal += (int)$product['subtotal'];
                            } ?>
                        </div>


                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4 mt-2 pull-right">
                        <form action="func_karyawan.php" method="POST">
                            <div class="row d-flex justify-content-between px-4" id="tax">
                                <p class="mb-1 text-left">Grand Total</p>
                                <h6 class="mb-1 text-right" id="gtotal">Rp. <?= number_format($gtotal, 0, ',', '.') ?></h6>
                            </div>
                            <div class="row d-flex justify-content-between px-4 py-2 mt-2">
                                <input type="text" class="form-control" name="paidreceived" id="paidreceived" placeholder="Enter Your Price" required>
                            </div>
                            <input type="hidden" name="func" id="func" value="submitorder">
                            <input type="hidden" name="gtotal" id="input_gtotal" value="<?= $gtotal ?>">
                            <button type="submit" class="btn-block btn-blue" id="pay-btn"> <span> <span id="checkout">Pay</span> <span id="check-amt">Rp. <?= number_format($gtotal, 0, ',', '.') ?></span> </span> </button>
                            <a href="./karyawan-home.php"><button class="btn-block btn btn-success" type="button" style="border-radius: 10px;"> <span> <span id="checkout">Order Menu</span></span> </button></a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let stotal = parseInt($('#input_gtotal').val());
        if (stotal <= 0) {
            $('#pay-btn').attr('disabled', true);
        }
    });

    $('.plus-qty').click(function() {
        let id = $(this).attr('product-id');
        let qty = parseInt($('#qty' + id).text());
        let harga = parseInt($('#harga' + id).attr('price'));
        qty += 1;
        if (qty > 1) {
            $('#min-qty' + id).attr('disabled', true);
        }
        let stotal = qty * harga;
        $('#min-qty' + id).removeAttr('disabled');
        $('#qty' + id).empty();
        $('#subtotal' + id).empty();
        $('#qty' + id).text(qty);
        $('#subtotal' + id).text('Rp. ' + stotal.toLocaleString('id'));
        $.ajax({
            url: 'http://localhost/kepkop/func_karyawan.php',
            method: 'POST',
            data: {
                func: 'changecart',
                quantity: qty,
                product_id: id
            },
            success: function(res) {
                if (res != null) {
                    let result = JSON.parse(res);
                    let subtotal = 0;
                    result.map((item, index) => {
                        subtotal += parseInt(item.subtotal);
                    });
                    $('#check-amt').empty();
                    $('#gtotal').empty();
                    $('#gtotal').text('Rp. ' + subtotal.toLocaleString('id'));
                    $('#check-amt').text('Rp. ' + subtotal.toLocaleString('id'));
                    $('#input_gtotal').val(subtotal);
                }
            }
        });
    });

    $('.min-qty').click(function() {
        let id = $(this).attr('product-id');
        let qty = parseInt($('#qty' + id).text());
        let harga = parseInt($('#harga' + id).attr('price'));
        qty -= 1;
        if (qty == 1) {
            $('#min-qty' + id).attr('disabled', true);
        }
        let stotal = qty * harga;
        $('#qty' + id).empty();
        $('#subtotal' + id).empty();
        $('#qty' + id).text(qty);
        $('#subtotal' + id).text('Rp. ' + stotal.toLocaleString('id'));
        if (stotal <= 0) {
            $('#pay-btn').attr('disabled', true);
        }
        $.ajax({
            url: 'http://localhost/kepkop/func_karyawan.php',
            method: 'POST',
            data: {
                func: 'changecart',
                quantity: qty,
                product_id: id
            },
            success: function(res) {
                if (res != null) {
                    let result = JSON.parse(res);
                    let subtotal = 0;
                    result.map((item, index) => {
                        subtotal += parseInt(item.subtotal);
                    });
                    $('#check-amt').empty();
                    $('#gtotal').empty();
                    $('#gtotal').text('Rp. ' + subtotal.toLocaleString('id'));
                    $('#check-amt').text('Rp. ' + subtotal.toLocaleString('id'));
                    $('#input_gtotal').val(subtotal);
                }
            }
        });
    });

    $('.del-cart').click(function() {
        let id = $(this).attr('product-id');
        $.ajax({
            url: 'http://localhost/kepkop/func_karyawan.php',
            method: 'POST',
            data: {
                func: 'deletecart',
                product_id: id
            },
            success: function(res) {
                if (res != null) {
                    let result = JSON.parse(res);
                    let subtotal = 0;
                    let html = '';
                    result.map((item, index) => {
                        if (item.image) {
                            var image = item.image;
                        } else {
                            var image = 'coffee.jpg';
                        }
                        html += `<div class="row d-flex justify-content-center border-top">
                                <div class="col-5">
                                    <div class="row d-flex">
                                        <div class="book"> <img src="./img/product/` + image + `" class="book-img"> </div>
                                        <div class="my-auto flex-column d-flex pad-left">
                                            <h6 class="mob-text">` + item.nama_item + `</h6>
                                            <span id="harga` + item.product_id + `" price="` + item.harga_item + `">Rp. ` + parseInt(item.harga_item).toLocaleString('id') + `</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="my-auto col-7 text-right">

                                    <h6 class="mob-text" id="subtotal` + item.product_id + `">Rp. ` + item.subtotal.toLocaleString('id') + `</h6>
                                    <div class="row d-flex justify-content-end px-3">
                                        <button class="badge badge-primary p-2 mr-1 plus-qty" style="border: none;" id="plus-qty` + item.product_id + `" product-id="` + item.product_id + `">+</button>
                                        <span class="align-middle" id="qty` + item.product_id + `">` + item.quantity + `</span>
                                        <button class="badge badge-primary p-2  ml-1 min-qty" style="border: none;" id="min-qty` + item.product_id + `" product-id="` + item.product_id + `" disabled>-</button>
                                        <!-- <p class="mb-0" id="cnt1">1</p>
                                            <div class="d-flex flex-column plus-minus"> <span class="vsm-text plus ">+</span> <span class="vsm-text minus">-</span> </div> -->
                                    </div>
                                    <br>
                                    <span class="mt-2 del-cart" style="color: red; cursor: pointer;" product-id="` + item.product_id + `">Hapus</span>

                                </div>
                            </div>`;
                        subtotal += parseInt(item.subtotal);
                    });
                    $('#check-amt').empty();
                    $('#gtotal').empty();
                    $('.body-cart').empty();
                    $('.body-cart').html(html);
                    $('#gtotal').text('Rp. ' + subtotal.toLocaleString('id'));
                    $('#check-amt').text('Rp. ' + subtotal.toLocaleString('id'));
                    $('#input_gtotal').val(subtotal);
                }
            }
        });
    });
</script>
<?php
include "footer.php";
?>