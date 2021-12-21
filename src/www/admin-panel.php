<?php

$NEEDS_TO_BE_LOGGED_IN = 1;
$ADMIN_ONLY = 1;

require_once __DIR__ . '/include/php_header.php';
require_once __DIR__ . '/include/header.php';
?>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newProductModal" data-bs-whatever="@getbootstrap">Add product</button>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newProductModal" data-bs-whatever="@getbootstrap">Change product</button>

<div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProductLabel">New product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newproduct-form" onsubmit="return addProduct(this)">
                    <div class="mb-3">
                        <label for="product-name" class="col-form-label">Name:</label>
                        <input name="name" type="text" class="form-control" id="product-name">
                    </div>
                    <div class="mb-3">
                        <label for="desription-text" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" id="description-text"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="categories-select" class="col-form-label">Description:</label>
                        <select name="categories" id="categories-select">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="available-checkbox" class="col-form-label">Available:</label>
                        <input name="available" type="checkbox" id="available-checkbox" checked=checked>
                    </div>
                    <div class="mb-3">
                        <label for="stock-number" class="col-form-label">Stock:</label>
                        <input name="stock" type="number" id="stock-number" min="0" max="9999" value="10">
                    </div>
                    <div class="mb-3">
                        <label for="unitprice-number" class="col-form-label">Stock:</label>
                        <input name="unitprice" type="number" id="unitprice-number" step="0.01" min="0.01" max="9999" value="10">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" value="Submit" class="btn btn-primary" data-bs-dismiss="modal">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include_once __DIR__ . "/include/footer.php";
?>
<script src="/js/admin-panel.js"></script>