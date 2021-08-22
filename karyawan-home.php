<?php
session_start();
if (empty($_SESSION['karyawan_id'])) {
    header("Location: karyawan-login.php");
}
include "conf_config.php";
$url = "customer-detail-kos.php";
$tgl = date("Y-m-d");
$product = mysqli_query($conn, "SELECT b.*, a.nama_kategori FROM kategori_item a INNER JOIN item b ON a.idkategori=b.idkategori WHERE a.isdel='0'");
$subtotal = 0;
foreach ($_SESSION['products'] as $item) {
    $subtotal += $item['subtotal'];
}

?>



<?php include 'header.php'; ?>
<style>
    body {
        background: linear-gradient(to right, #c04848, #480048);
        min-height: 100vh
    }

    .text-gray {
        color: #aaa
    }

    img {
        height: 170px;
        width: 140px
    }
</style>

<div class="col-lg-12">
    <div class="row">
        <div class="col text-right mt-3 mr-2">
            <a href="conf_logout.php" style="border: none;" title="Logout"><i class="material-icons">exit_to_app</i></a>
        </div>
        <div class="col-md-12">
            <div class="container py-5">
                <div class="row text-center text-white mb-5">
                    <div class="col-lg-7 mx-auto">
                        <h1 class="display-4">Product List</h1>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-8 mx-auto">
                        <!-- List group-->
                        <ul class="list-group shadow">
                            <!-- list group item-->
                            <?php
                            $kategori_name = '';
                            while ($row = mysqli_fetch_array($product)) {
                                if ($kategori_name != $row['nama_kategori']) { ?>
                                    <h3 class="text-white mt-5"><?= $row['nama_kategori'] ?></h3>

                                <?php $kategori_name = $row['nama_kategori'];
                                } ?>
                                <li class="list-group-item">
                                    <!-- Custom content-->
                                    <div class="media align-items-lg-center flex-column flex-lg-row p-3">
                                        <div class="media-body order-2 order-lg-1">
                                            <h5 class="mt-0 font-weight-bold mb-2"><?= $row['nama_item'] ?></h5>
                                            <p class="font-italic text-muted mb-0 small"><?= $row['descitem'] ?></p>
                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                <h6 class="font-weight-bold my-2">Rp. <?= number_format($row['harga_item'], 0, ',', '.') ?></h6>
                                            </div>
                                        </div>

                                        <img src="./img/product/<?= $row['image'] ?>" alt="Generic placeholder image" width="200" class="ml-lg-5 order-1 order-lg-2">

                                    </div>
                                    <div class="text-center pull-left">
                                        <div class="row col mr-2 text-center my-3" style="margin: 0 auto;">
                                            <button class="btn btn-success col-md-4 plus-qty" id="plus-qty<?= $row['itemid']; ?>" product-id="<?= $row['itemid']; ?>">+</button>
                                            <span class="col-md-4 align-middle" id="qty<?= $row['itemid']; ?>">0</span>
                                            <button class="btn btn-success col-md-4 min-qty" id="min-qty<?= $row['itemid']; ?>" product-id="<?= $row['itemid']; ?>" disabled>-</button>
                                        </div>
                                    </div>
                                    <button class="col-md-3 mt-3 btn btn-primary add-cart" product-id="<?= $row['itemid']; ?>">+ Add to cart</button> <!-- End -->
                                </li> <!-- End -->
                                <!-- list group item-->
                            <?php } ?>


                        </ul> <!-- End -->
                    </div>
                </div>
                <a href="./karyawan-checkout.php">
                    <div class="row text-center bg-primary mb-4 d-none checkout-btn" style="width: 90%; height: 50px; border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); position: fixed; bottom: 0; right: 0; left: 0; margin-right: auto; margin-left: auto; z-index: 10; align-items: center;">
                        <div class="col text-left ml-2 text-white font-weight-bold">
                            Checkout
                        </div>
                        <span class="col text-right mr-2 text-white font-weight-bold" id="price-ck">

                        </span>
                    </div>
                </a>

            </div>

        </div>

    </div>

</div>

<script>
    $(document).ready(function() {
        let subtotal = '<?= $subtotal; ?>';
        if (parseInt(subtotal) > 0) {
            $('#price-ck').text('Rp. ' + parseInt(subtotal).toLocaleString('id'));
            $('.checkout-btn').removeClass('d-none');
        }
    });

    $('.plus-qty').click(function() {
        let id = $(this).attr('product-id');
        let qty = parseInt($('#qty' + id).text());
        qty += 1;
        $('#min-qty' + id).removeAttr('disabled');
        $('#qty' + id).text(qty);
    });

    $('.min-qty').click(function() {
        let id = $(this).attr('product-id');
        let qty = parseInt($('#qty' + id).text());
        qty -= 1;
        if (qty == 0) {
            $('#min-qty' + id).attr('disabled', true);
        }
        $('#qty' + id).text(qty);
    });

    $('.add-cart').click(function() {
        let prodid = $(this).attr('product-id');
        let quantity = parseInt($('#qty' + prodid).text());
        $.ajax({
            url: 'http://localhost/kepkop/func_karyawan.php',
            method: 'POST',
            data: {
                func: 'addtocart',
                quantity: quantity,
                product_id: prodid
            },
            success: function(res) {
                if (res != null) {
                    let result = JSON.parse(res);
                    let subtotal = 0;
                    result.map((item, index) => {
                        subtotal += parseInt(item.subtotal);
                    });
                    $('#price-ck').text('Rp. ' + subtotal.toLocaleString('id'));
                    $('.checkout-btn').removeClass('d-none');
                }
            }
        });
    });
</script>

<?php
include "footer.php";
?>