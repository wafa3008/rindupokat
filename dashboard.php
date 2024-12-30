<?php
ob_start();
session_start();
require_once './config/app.php';

// Initialize CSRF token if not set
$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

// Redirect if not logged in or if logged in with an invalid session
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
} elseif (!empty($_SESSION['user']['id_pelanggan'])) {
    header("Location: " . getBaseUrl());
    exit;
}

$dashboard = new DashboardController($_SERVER['QUERY_STRING']);
$auth = new AuthController();

// Get content path and menu name
$contentPath = $dashboard->getContentPath();
$menu = $dashboard->getMenuName();

// Handle logout action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aksi']) && $_POST['aksi'] === 'logout') {
        $auth->keluar();
        $_SESSION['icon_message'] = 'success';
        $_SESSION['message'] = 'Anda berhasil keluar dari sesi ini';
        header("Location: login.php");  // Redirect after logout
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $app_name ?> | Dashboard</title>
    <link rel="icon" type="image/x-icon" href="<?= $logo ?>">

    <style>
        html>body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans",
                "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"
                , "Noto Color Emoji" !important;
        }
    </style>

    <!-- AdminLTE CDN CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Datatables CSS -->
    <link href="https://cdn.datatables.net/v/bs4/dt-2.1.8/datatables.min.css" rel="stylesheet">

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/fceaeeb499.js" crossorigin="anonymous"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/v/bs4/dt-2.1.8/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.5.1/js/dataTables.rowGroup.js"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include './views/dashboard/layouts/navbar.php'; ?>
        <!-- Main Sidebar Container -->
        <?php include './views/dashboard/layouts/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                <?= $contentPath ? htmlspecialchars(ucfirst($dashboard->getSubName())) : '' ?>
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="./">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= $contentPath ? htmlspecialchars(ucfirst($dashboard->getSubName())) : '' ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <?php
                    if (!$contentPath) {
                        include './views/dashboard/layouts/404.php';
                    } elseif ($contentPath) {
                        include $contentPath;
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <?php include './views/dashboard/layouts/footer.php'; ?>
    </div>

    <!-- Sweetalert2 Message -->
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

<?php
ob_end_flush(); // End output buffering and send output
?>