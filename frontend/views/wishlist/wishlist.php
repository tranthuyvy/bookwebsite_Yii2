<?php

use frontend\models\Wishlist;
use frontend\models\Product;
use yii\widgets\LinkPager;

?>
<div id="content-page" class="content-page">
    <div class="col-lg-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center position-relative">
                <div class="iq-header-title">
                    <h4 class="card-title mb-0">Product</h4>
                </div>
            </div>

            <div class="iq-card-body">
                <div class="row">
                    <?php foreach ($wishlistItems as $wishlistItem) {
                        $product = $wishlistItem['product']
                        ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height browse-bookcontent">
                                <div class="iq-card-body p-0">
                                    <div class="d-flex align-items-center">
                                        <div class="col-6 p-0 position-relative image-overlap-shadow">
                                            <a href="javascript:void();">
                                                <img class="img-fluid rounded w-100"
                                                     src="<?php echo $product['product_image']; ?>"
                                                     style="object-fit: cover; height: 280px; width: 220px"
                                                     alt="$value['product_name']">
                                            </a>
                                            <div class="view-book">
                                                <a href="<?= Yii::$app->homeUrl?>product/detail?id=<?php echo $product["product_id"] ?>" class="btn btn-sm btn-white">
                                                    <!--                                                    --><?php //= Yii::$app->homeUrl.'product/detail/'.$value['product_id'] ?>
                                                    Xem
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <h6 class="mb-1"><?php echo $product['product_name']; ?></h6>
                                                <div class="mb-3 d-block">
                                                    <span class="font-size-20 text-warning">
                                                        <?php
                                                            $averageRating = min($wishlistItem['average_rating'], 5);

                                                            $fullStars = floor($averageRating);
                                                            $remainingStars = round($averageRating - $fullStars);

                                                            for ($i = 1; $i <= $fullStars; $i++) {
                                                                echo '<i class="fa fa-star mr-1"></i>';
                                                            }

                                                            if ($remainingStars > 0) {
                                                                echo '<i class="fas fa-star-half-alt mr-1"></i>';
                                                                $emptyStars = max(5 - $fullStars - 1, 0);
                                                            } else {
                                                                $emptyStars = max(5 - $fullStars, 0);
                                                            }

                                                            for ($i = 1; $i <= $emptyStars; $i++) {
                                                                echo '<i class="far fa-star mr-1" style="color: black"></i>';
                                                            }
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="price d-flex align-items-center">
                                                <h6 style="color: red">
                                                    <b><?php echo number_format($product['product_price'], 0, ',', '.'); ?>
                                                        Đ</b></h6>
                                            </div>

                                            <button class="btn btn-outline-primary" type="button" onclick="addCart(<?= $product['product_id']; ?>)">
                                                <i class="ri-shopping-cart-2-fill text-primary"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" type="button" onclick="removeFromWishlist(<?= $product['product_id']; ?>)">
                                                <i class="ri-delete-bin-line text-danger"></i>
                                            </button>
                                            <script>
                                                function removeFromWishlist(id) {
                                                    var result = confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi wishlist?");
                                                    if (result) {
                                                        $.get("<?= Yii::$app->homeUrl ?>wishlist/remove", {'id': id}, function (data) {
                                                            if (data.success) {
                                                                $("#item_" + id).remove();
                                                                location.reload();
                                                            }
                                                        });
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>