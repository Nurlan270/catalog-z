<!doctype html>
<html lang="en">
<head>
    <?php require_once __DIR__ . '/../../assets/includes/meta.php' ?>
    <?php require_once __DIR__ . '/../../app/controllers/auth.php' ?>
    <link rel="stylesheet" href="/assets/css/auth.css">
    <title>Catalog-Z Registration</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
                <div class="card-img-left d-none d-md-flex">
                    <!-- Background image for card set in CSS! -->
                </div>
                <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title text-center mb-5 fw-light fs-5">Register</h5>
                    <?php if (!empty($msg)): ?>
                        <div class="alert alert-danger"><?= $msg ?></div>
                    <?php endif; ?>
                    <form action="reg.php" method="post">

                        <div class="form-floating mb-3">
                            <input type="text" name="username" value="<?= $username ?>" class="form-control" id="floatingInputUsername" placeholder="myusername"
                                   required autofocus>
                            <label for="floatingInputUsername">Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" name="email" value="<?= $email ?>" class="form-control" id="floatingInputEmail"
                                   placeholder="name@example.com" required>
                            <label for="floatingInputEmail">Email address</label>
                        </div>

                        <hr>

                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="passwordAgain" class="form-control" id="floatingPasswordConfirm"
                                   placeholder="Confirm Password" required>
                            <label for="floatingPasswordConfirm">Confirm Password</label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" name="remember" type="checkbox" value="0" id="rememberPasswordCheck">
                            <label class="form-check-label" for="rememberPasswordCheck">
                                Remember me
                            </label>
                        </div>

                        <div class="d-grid mb-2">
                            <button name="register-btn" class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">
                                Register
                            </button>
                        </div>

                        <hr class="my-4">

                        <a class="d-block text-center mt-2" href="/public/auth/log.php">Have an account? Sign In</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>