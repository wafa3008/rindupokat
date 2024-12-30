<?php
session_start();

$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

if (isset($_SESSION['user'])) {
    // Redirect to the appropriate page if the user is logged in
    $redirectUrl = empty($_SESSION['user']['id_pelanggan']) ? 'dashboard.php' : getBaseUrl();
    // Prevent redirection loop by checking if the current page is not the redirect destination
    if ($_SERVER['PHP_SELF'] !== $redirectUrl) {
        header("Location: $redirectUrl");
        exit;
    }
}
$cAuth = new AuthController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['icon_message'] = 'error';
        $_SESSION['message'] = 'Token CSRF tidak valid';
        exit;
    }

    $data = $_POST;
    $result = $cAuth->daftar($data);

    if (is_array($result)) {
        $errors = $result;
    } else {
        $redirectUrl = empty($_SESSION['user']['id_pelanggan']) ? 'dashboard.php' : getBaseUrl();
        header("Location: $redirectUrl");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#712cf9">
    <title><?= $app_name ?> | Register</title>
    <link rel="icon" type="image/x-icon" href="<?= $logo ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- custom css untuk tampilan user -->
    <link href="./assets/css/home.css" rel="stylesheet">

    <!-- theme dark/light -->
    <script src="./assets/js/color-themes.js"></script>

    <style>
        .container {
            max-width: 960px;
        }
    </style>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path
                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z">
            </path>
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"></path>
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z">
            </path>
            <path
                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z">
            </path>
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path
                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
            </path>
        </symbol>
    </svg>

    <!-- Tombol Ubah Tema -->
    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button"
            aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (dark)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#moon-stars-fill"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
                    aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="dark"
                    aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"
                    aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="container px-5">
        <main class="px-5">
            <div class="pt-5 pb-3 text-center">
                <div class="col-12 text-center">
                    <img class="mb-4" src="<?= $logo ?>" alt="" width="72" height="57">
                </div>
                <h2>Register Member baru</h2>
                <p class="lead">Klik tautan berikut jika anda sudah memiliki akun, untuk melakukan <a
                        href="login.php">login</a></p>
            </div>

            <div class="row g-5">
                <div class="col-12">
                    <h4 class="mb-3">User</h4>
                    <form action="" method="post">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text"
                                    class="form-control <?= isset($errors['username']) ? 'is-invalid' : ''; ?>"
                                    id="username" name="username" value="">
                                <?php if (isset($errors['username'])): ?>
                                    <div class="invalid-feedback"><?= $errors['username'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password"
                                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>"
                                    id="password" name="password" value="">
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                                <?php endif; ?>
                            </div>

                            <hr class="mt-4">

                            <div class="col-12">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text">@</span>
                                    <input type="text"
                                        class="form-control <?= isset($errors['nama']) ? 'is-invalid' : ''; ?>"
                                        id="nama" name="nama" placeholder="Nama Lengkap">
                                    <?php if (isset($errors['nama'])): ?>
                                        <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                    class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>" id="email"
                                    name="email" placeholder="you@example.com">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea type="text"
                                    class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : ''; ?>"
                                    id="alamat" name="alamat"></textarea>
                                <?php if (isset($errors['alamat'])): ?>
                                    <div class="invalid-feedback"><?= $errors['alamat'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-12">
                                <label for="telp" class="form-label">No. Handphone / WA</label>
                                <input type="text"
                                    class="form-control <?= isset($errors['telp']) ? 'is-invalid' : ''; ?>" id="telp"
                                    name="telp" placeholder="08XXXXXXXXX">
                                <?php if (isset($errors['telp'])): ?>
                                    <div class="invalid-feedback"><?= $errors['telp'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr class="my-4">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <button class="w-100 btn btn-primary btn-lg" type="submit">Register</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_SESSION["message"]) && isset($_SESSION["icon_message"])) { ?>
        <script>
            $(document).ready(function () {
                Swal.fire({
                    title: '<?= ucfirst($_SESSION['icon_message']); ?>',
                    text: '<?= $_SESSION['message']; ?>',
                    icon: '<?= $_SESSION['icon_message']; ?>',
                })
            });
        </script>
        <?php
        unset($_SESSION["icon_message"]);
        unset($_SESSION["message"]);
    } ?>
</body>

</html>