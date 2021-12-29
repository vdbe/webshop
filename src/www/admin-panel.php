<?php

$NEEDS_TO_BE_LOGGED_IN = 1;
$ADMIN_ONLY = 1;

require_once __DIR__ . '/include/php_header.php';
require_once __DIR__ . '/include/header.php';
?>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newProductModal" data-bs-whatever="@getbootstrap">Add product</button>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newCategoryModal" data-bs-whatever="@getbootstrap">Add Category</button>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-bs-whatever="@getbootstrap">Edit Category</button>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" data-bs-whatever="@getbootstrap">Edit User</button>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" data-bs-whatever="@getbootstrap">Edit Product</button>

<div class="modal fade" id="newProductModal" tabindex="-1" aria-hidden="true">
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
                        <label for="newProduct-description-text" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" id="newProduct-description-text"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="categories-select" class="col-form-label">Category:</label>
                        <select name="categories" class="category-select" id="categories-select">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="available-checkbox" class="col-form-label">Available:</label>
                        <input name="available" type="checkbox" id="available-checkbox" checked=checked>
                    </div>
                    <div class="mb-3">
                        <label for="stock-number" class="col-form-label">Stock:</label>
                        <input name="stock" type="number" id="stock-number" min="0" max="99999" value="10">
                    </div>
                    <div class="mb-3">
                        <label for="unitprice-number" class="col-form-label">Unit price:</label>
                        <input name="unitprice" type="number" id="unitprice-number" step="0.01" min="0.01" max="9999" value="10">
                    </div>
                    <!--
                    <div class="mb-3">
                        <label for="product-images" class="col-form-label">Pictures: </label>
                    </div>
                     -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" value="Submit" class="btn btn-primary" data-bs-dismiss="modal">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCategoryLabel">New product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newCategory-form" onsubmit="return addCategory(this)">
                    <div class="mb-3">
                        <label for="category-name" class="col-form-label">Name:</label>
                        <input name="name" type="text" class="form-control" id="category-name">
                    </div>
                    <div class="mb-3">
                        <label for="newCategory-description-text" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" id="newCategory-description-text"></textarea>
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

<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryLabel">edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategory-form" onsubmit="return editCategoryFormOnSubmit(this)">
                    <div class="mb-3">
                        <label for="edit-category-categories-select" class="col-form-label">Category:</label>
                        <select name="categories" id="edit-category-categories-select" onchange="updateEditCategoryForm(this)" class="category-select">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-category-category-name" class="col-form-label">Name:</label>
                        <input name="name" type="text" class="form-control" id="edit-category-category-name">
                    </div>
                    <div class="mb-3">
                        <label for="edit-category-description-text" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" id="edit-category-description-text"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" value="Submit" class="btn btn-primary" data-bs-dismiss="modal">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUser-form" onsubmit="return editUserFormOnSubmit(this)">
                    <div class="mb-3">
                        <label for="editUser-user-select" class="col-form-label">User:</label>
                        <select name="user" id="editUser-user-select" onchange="updateEditUserForm(this)" class="user-select">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUser-role-select" class="col-form-label">Role:</label>
                        <select name="role" id="editUser-role-select" class="role-select">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUser-displayname" class="col-form-label">Displayname:</label>
                        <input name="displayname" type="text" class="form-control" id="editUser-displayname">
                    </div>
                    <div class="mb-3">
                        <label for="editUser-active-checkbox" class="col-form-label">Active:</label>
                        <input name="active" type="checkbox" id="editUser-active-checkbox" checked=checked>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" value="Submit" class="btn btn-primary" data-bs-dismiss="modal">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductLabel">Edit product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editproduct-form" onsubmit="editProductOnSubmit(this); return false;">
                    <div class="mb-3">
                        <label for="editProduct-product-select" class="col-form-label">Product:</label>
                        <select name="product" id="editProduct-product-select" onchange="updateEditProductsForm(this)" class="product-select">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editProduct-product-name" class="col-form-label">Name:</label>
                        <input name="name" type="text" class="form-control" id="editProduct-product-name">
                    </div>
                    <div class="mb-3">
                        <label for="editProduct-description-text" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" id="editProduct-description-text"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editProduct-categories-select" class="col-form-label">Category:</label>
                        <select name="categories" class="category-select" id="editProduct-categories-select">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editProduct-available-checkbox" class="col-form-label">Available:</label>
                        <input name="available" type="checkbox" id="editProduct-available-checkbox" checked=checked>
                    </div>
                    <div class="mb-3">
                        <label for="editProduct-stock-number" class="col-form-label">Stock:</label>
                        <input name="stock" type="number" id="editProduct-stock-number" min="0" max="9999" value="10">
                    </div>
                    <div class="mb-3">
                        <label for="editProduct-unitprice-number" class="col-form-label">Unit price:</label>
                        <input name="unitprice" type="number" id="editProduct-unitprice-number" step="0.01" min="0.01" max="9999" value="10">
                    </div>
                    <!--
                    <div class="mb-3">
                        <label for="product-images" class="col-form-label">Pictures: </label>
                    </div>
                     -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" value="Submit" class="btn btn-primary" data-bs-dismiss="modal">Edit</button>
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