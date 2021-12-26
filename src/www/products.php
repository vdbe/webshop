<?php
$NEEDS_TO_BE_LOGGED_IN = 1;
$NO_SEARCHBAR = true;

require_once __DIR__ . '/include/php_header.php';
require_once __DIR__ . '/include/header.php';

?>
<link rel="stylesheet" href="/css/products.css">

<div class="container">
    <form id="products-search-form" onsubmit="return productSearchFormOnSubmit(this); return false;" method="POST">
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

<div id="products-wrapper" class="flex-container">
</div>

<script src="/js/products.js"></script>
<?php
require_once __dir__ . '/include/footer.php';
?>