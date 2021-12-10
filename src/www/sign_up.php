<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['displayname'])) {
        // TODO: Error
        echo "yes";
    } elseif (empty($_POST['displayname'])) {
        // TODO: Error
    } elseif (empty($_POST['firstname'])) {
        // TODO: Error
    } elseif (empty($_POST['lastname'])) {
        // TODO: Error
    } elseif (empty($_POST['dob'])) {
        // TODO: Error
    } elseif (empty($_POST['email'])) {
        // TODO: Error
    } elseif (empty($_POST['password'])) {
        // TODO: Error
        // Don't check for password match if users change/disable js it's on them
    } else {
        // No values are empty
        if (!preg_match('/^[a-zA-Z0-9]{4,}$/', $_POST['displayname'])) {
            // TODO: Error
            echo 1;
        } /* else if (!preg_match("/[~!@#\$%\^&\*\(\)=\+\|\[\]\{\};\\:\",\.\<\>\?\/]+/", $_POST['firstname'])) {
            // TODO: Error
            echo 2;
        } else if (!preg_match("/[~!@#\$%\^&\*\(\)=\+\|\[\]\{\};\\:\",\.\<\>\?\/]+/", $_POST['lastname'])) {
            // TODO: Error
            echo 3;
        } */ else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            // TODO: Error
            echo 4;
        } else {
            // We made it there everything is valid
            require_once 'include/class/db.php';
            require_once 'include/class/user.php';

            $db = new DB('database', 'Webuser', 'Lab2021', 'webshop');

            $email = $_POST['email'];

            $email_exists = User::check_if_email_exists($db, htmlspecialchars($email));
            $displayname_exists = User::check_if_displayname_exists($db, htmlspecialchars($email));

            if ($email_exists == false && $displayname_exists == false) {
                $role_id = 1;
                $displayname = $_POST['displayname'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $password = $_POST['password'];
                $dob = $_POST['dob'];
                $active = 1;

                // Create user
                User::create($db, $role_id, $displayname, $firstname, $lastname, $email, $dob, $password, $active);
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

    <title>Sign up</title>
    <script>
        function validateSignUpForm(form) {
            password = document.getElementById("password");
            passwordRepeat = document.getElementById("passwordRepeat");

            if (password.value != passwordRepeat.value) {
                alert("Passwords don't match");
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <form id="signup-form" class="text-left" action="sign_up.php" onsubmit="return validateSignUpForm(this)" method="post">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-5 mt-md-4 pb-5">

                                    <h2 class="fw-bold mb-2 text-uppercase">Sign up</h2>
                                    <p class="text-white-50 mb-5">Please enter your signup info</p>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="displayname" name="displayname" class="form-control form-control-lg" required />
                                        <label class="form-label" for="displayname">Display name</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="firstname" name="firstname" class="form-control form-control-lg" required />
                                        <label class="form-label" for="firstname">Firstname</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="lastname" name="lastname" class="form-control form-control-lg" required />
                                        <label class="form-label" for="firstname">Lastname</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="date" id="dob" name="dob" class="form-control form-control-lg" required />
                                        <label class="form-label" for="dob">Date of birth</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                        <label class="form-label" for="typeemailx">email</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                        <label class="form-label" for="passord">Password</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="passwordRepeat" class="form-control form-control-lg" />
                                        <label class="form-label" for="passordRepeat">Repeat password</label>
                                    </div>

                                    <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>

                                    <input class="btn btn-outline-light btn-lg px-5" type="submit" value="Submit">
                                </div>

                                <div>
                                    <p class="mb-0">Don&apos;t have an account? <a href="#!" class="text-white-50 fw-bold">Sign Up</a></p>
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