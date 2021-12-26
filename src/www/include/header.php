<?php
require_once __DIR__ . '/php_header.php';

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- <title>&#35;&#36;&#64;&#33;&#37; CSS</title> -->
    <title>Bricks!!!</title>
</head>

<body>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!--<a class="navbar-brand" href="/#">&#35;&#36;&#64;&#33;&#37; CSS</a> -->
            <a class="navbar-brand" href="/#">Bricks</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/about#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/products#">Products</a>
                    </li>
                </ul>
                <?php
                if ($LOGGED_IN == 1 && !(isset($NO_SEARCHBAR) && $NO_SEARCHBAR != true)) {
                ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <form action="/products" method="GET">
                                <div class="input-group mb-3">
                                    <input name='name' type="text" class="form-control" placeholder="Search products" aria-label="Search products" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit" id="button-addon2">Search</button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    </ul>
                <?php
                }
                ?>
                <ul class="navbar-nav ms-auto">
                    <?php
                    if ($LOGGED_IN == 1) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                echo htmlspecialchars($USER->displayname);
                                ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/shopping-cart#">Shopping cart</a></li>
                                <?php
                                if ($IS_ADMIN == 1) {
                                ?>
                                    <li><a class="dropdown-item" href="/admin-panel">Admin panel</a></li>
                                <?php
                                }
                                ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/sign_out">Log out</a></li>
                            </ul>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login">Login</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <!-- <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
            </div>
        </div>
    </nav>