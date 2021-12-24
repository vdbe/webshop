<?php
$NEEDS_TO_BE_LOGGED_IN = 1;
$NO_SEARCHBAR = true;

require_once __DIR__ . '/include/php_header.php';
require_once __DIR__ . '/include/header.php';

?>
<link rel="stylesheet" href="/css/products.css">

<div class="container">
    <form id="products-search-form" onsubmit="return productSearchFormOnSubmit(this)" method="POST">
        <div class="row">
            <div class="col-sm">
                <input name="name" placeholder="Search name" type="text" class="form-control" id="product-search-form-name">
            </div>
            <div class="col-sm">
                <input name="description" placeholder="Search description" type="text" class="form-control" id="product-search-form-description">
            </div>
            <div class="col-sm">
                <select name="category" class="category-select" id="product-search-form-category" onchange="productSearchFormOnSubmit(this.parentElement.parentElement.parentElement)">
                    <option value="">all</option>
                </select>
            </div>
            <div class="col-sm">
                <button type="submit" value="Submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
</div>

<!--
<div class="card" style="width: 18rem"><img src="/assets/placeholder.gif" class="card-img-top" alt="roll">
    <div class="card-body">
        <h5 class="card-title">food</h5>
        <p class="card-subtitle text-muted">This is test 123</p>
        <p class="mb-1">Unitprice: 9</p>
        <input name="stock" class="card-text" type="number" id="stock-number" min="0" max="9999" value="10">
        <p class="btn btn-primary card-link mt-1" href="#">Place order</p>
    </div>
</div>
-->

<br>

<div id="products-wrapper" class="flex-container">
</div>

<script src="/js/products.js"></script>
<?php
require_once __dir__ . '/include/footer.php';
?>