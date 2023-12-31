<?php
use frontend\widgets\topNavWidget;
use frontend\widgets\leftMenuWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<?= topNavWidget::widget() ?>
<?= leftMenuWidget::widget() ?>
<div id="content-page" class="content-page">
    <div class="container-fluid checkout-content">
        <div class="row">
            <div id="cart" class="card-block show p-0 col-12">
                <div class="row align-item-center">
                    <div class="col-lg-8">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between iq-border-bottom mb-0">
                                <div class="iq-header-title">
                                    <h4 class="card-title"></h4>
                                </div>
                            </div>
                            <div class="iq-card-body" id="listCart">
                                <ul class="list-inline p-0 m-0">
                                    <?php
                                    $total = 0;
                                    foreach ($cart as $key => $value){
                                        ?>

                                        <li class="checkout-product">
                                            <div class="row align-items-center">
                                                <div class="col-sm-2">
                                             <span class="checkout-product-img">
                                             <a href="javascript:void();">
                                                 <img class="img-fluid rounded"
                                                      src="<?php echo $value['product_image'] ?>"
                                                      style="object-fit: cover; height: 90px; width: 150px; margin-left: 30px"
                                                      alt="<?= $value["product_name"]?>">
                                             </a>
                                             </span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="checkout-product-details">
                                                        <h5><?= $value["product_name"]?></h5>
                                                        <p class="text-success">Còn hàng</p>
                                                        <div class="price">
                                                            <h5 style="color: red">
                                                                <?php echo number_format($value['product_price'], 0, ',', '.'); ?>Đ
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <div class="row align-items-center mt-2">
                                                                <div class="col-sm-7 col-md-6">
                                                                    <div>Số Lượng: <?php echo $value['amount']?></div>
                                                                </div>
                                                                <div class="col-sm-5 col-md-6">
                                                                <span class="product-price">
                                                                    <h5 style="color: red">
                                                                        <?php echo number_format($value['product_price'] * $value['amount'], 0, ',', '.');
                                                                        $total += $value['product_price'] * $value['amount'];
                                                                        ?>Đ
                                                                    </h5>
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <p><b>Chi tiết hóa đơn</b></p>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Tổng chưa thuế</span>
                                    <span>
                                        <strong>
                                            <?php echo number_format($total * (95/100), 0, ',', '.'); ?>Đ
                                        </strong>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Thuế VAT 8%</span>
                                    <span>
                                        <strong>
                                            <?php echo number_format($total * (5/100), 0, ',', '.'); ?>Đ
                                        </strong>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Phí vận chuyển</span>
                                    <span class="text-success">Miễn phí</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="text-dark">
                                        <strong>Tổng</strong>
                                    </span>
                                    <span class="text-dark" >
                                        <strong style="color: red">
                                            <?php echo number_format($total, 0, ',', '.'); ?>Đ
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <?php $form = ActiveForm::begin(); ?>
                            <div class="iq-card" style="height: 600px; padding: 10px">
                                <div class="card-body iq-card-body p-0 iq-checkout-policy">
                                    <div class="col-md-12 col-sm-12 estimate-ship-tax">
                                        <span class="estimate-title" style="margin-left: 35%">
                                            <strong style="font-size: 18px">
                                                Order Information
                                            </strong>
                                        </span>
                                        <p></p>
                                        <div class="form-group">
                                            <?= $form->field($model, 'user_name')->textInput(['autofocus' => true, 'placeholder' => 'Người nhận']) ?>
                                        </div>
                                        <div class="form-group">

                                            <?= $form->field($model, 'user_email')->textInput(['placeholder' => 'Email']) ?>
                                        </div>
                                        <div class="form-group">

                                            <?= $form->field($model, 'user_mobile')->textInput(['placeholder' => 'Mobile']) ?>
                                        </div>

                                        <div class="form-group">

                                            <?= $form->field($model, 'user_address')->textInput(['placeholder' => 'Address']) ?>
                                        </div>

                                        <div class="form-group">
                                            <?= $form->field($model, 'payment_id')->dropDownList($payment, ['prompt'=>'- Phương thức thanh toán -']) ?>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                                $vnd_to_usd = $total/23500
                                            ?>
                                            <div id="paypal-button"></div>
                                            <input type="hidden" id="vnd_to_usd" value="<?php echo round($vnd_to_usd,2)?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <?= Html::submitButton('Thanh Toán', ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    var usd = document.getElementById("vnd_to_usd").value;
    paypal.Button.render({
        // Configure environment
        env: 'sandbox',

        client: {
            sandbox: 'AY5do5qschROo-fAFJp06oQ91RSPIEPvm9cXKFrxRe9hPaQ8JSHHwppglUwgHU4dujyd5aAZBsISQIB9',
            production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            size: 'small',
            color: 'gold',
            shape: 'pill',
        },

        // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {

            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: usd,
                        currency: 'USD'
                    }
                }]
            });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                // Show a confirmation message to the buyer
                window.alert('Cảm Ơn Bạn Đã Mua Hàng');
            });
        }
    }, '#paypal-button');

</script>