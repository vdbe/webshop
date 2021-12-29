<?php
$NEEDS_TO_BE_LOGGED_IN = 0;
require_once __DIR__ . '/include/php_header.php';

if (isset($_SESSION['user'])) {
    header("Location: http://" . $_SERVER['HTTP_HOST']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email'])) {
        // TODO: Error
    } elseif (empty($_POST['password'])) {
        // TODO: Error
        // Don't check for password match if users change/disable js it's on them
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            // TODO: Error
            echo 4;
        } else {
            // We made it there everything is valid
            require_once 'include/class/db.php';
            require_once 'include/class/user.php';

            $db = new DB();

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::login($db, $email, $password);
            if ($user !== false) {
                $_SESSION['user'] = serialize($user);
                header("Location: http://" . $_SERVER['HTTP_HOST']);
                exit();
            } else {
                // TODO: Error
            }
        }
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login</title>
</head>

<body>
    <script>
        function validateLoginForm(form) {
            return true;
        }
    </script>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <form id="login-form" class="text-left" onsubmit="return validateLoginForm(this)" method="post">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">

                                <div class="mb-md-5 mt-md-4 pb-5">

                                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                        <label class="form-label" for="email">Email</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                        <label class="form-label" for="password">Password</label>
                                    </div>

                                    <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>

                                    <input class="btn btn-outline-light btn-lg px-5" type="submit" value="Submit">
                                </div>

                                <div>
                                    <p class="mb-0">Don&apos;t have an account? <a href="/sign_up" class="text-white-50 fw-bold">Sign Up</a></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>

</html>