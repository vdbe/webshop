<?php

$NEEDS_TO_BE_LOGGED_IN = 1;

require_once __DIR__ . '/include/php_header.php';
require_once __DIR__ . '/include/header.php';

?>
<link rel="stylesheet" href="/css/products.css">

<div class="container">
    <div class="row">
        <div class="col-sm">
            <h5 id='price'>Total price: </h5>
        </div>
        <div class="col-sm">
            <form id="products-search-form" onsubmit="placeOrderFormOnSubmit(this); return false;" method="POST">
                <button type="submit" value="Submit" class="btn btn-primary">Place order</button>
            </form>
        </div>
    </div>
</div>

<div id="products-wrapper" class="flex-container">
</div>

<script src="/js/shopping-cart.js"></script>
<?php
require_once __dir__ . '/include/footer.php';
?>