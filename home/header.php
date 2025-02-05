<?php
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Content-Security-Policy: default-src \'self\'; script-src \'self\'');
function osamah_encrypt_2($data)
{
    $key = 'Osamah_qader_NajeAbdullahShahrah';
    // تأكد من أن مفتاح التشفير قوي بما فيه الكفاية
    if (strlen($key) !== 32) {
        throw new Exception('Invalid encryption key length. Must be 32 characters.');
    }

    // تحويل البيانات إلى سلسلة JSON
    $jsonData = json_encode($data);

    // تشفير البيانات باستخدام AES-256-CBC
    $ivlen = openssl_cipher_iv_length('AES-256-CBC');
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext = openssl_encrypt($jsonData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

    // دمج المفتاح التمهيدي (IV) مع نص المشفر
    $ciphertext = base64_encode($iv . $ciphertext);

    return $ciphertext;
}


function osamah_decrypt_2($ciphertext)
{
    $key = 'Osamah_qader_NajeAbdullahShahrah';
    // فك تشفير البيانات
    $ivlen = openssl_cipher_iv_length('AES-256-CBC');
    $decoded = base64_decode($ciphertext);
    $iv = substr($decoded, 0, $ivlen);
    $ciphertext = substr($decoded, $ivlen);
    $originalData = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

    // تحويل البيانات المشفرة إلى JSON
    $data = json_decode($originalData, true);

    return $data;
}







include '../db.php';
$id_user_head = osamah_decrypt_2($_SESSION['id_user']);
$publi_fk_id_branch = 0;

// Prepare the SQL statement
$stmt = mysqli_prepare($con, "SELECT u.fk_branch,u.img_user,br.name_branch,jo.job_name,u.`status` FROM `users` u JOIN branch br ON u.fk_branch=br.id_branch JOIN jobs_table jo ON u.user_job=jo.job_id WHERE `id_user`=? ;");
mysqli_stmt_bind_param($stmt, "i", $id_user_head);
mysqli_stmt_execute($stmt);

// Error handling
if (mysqli_stmt_error($stmt)) {
    // Handle error, log it, and provide a user-friendly message
    die("Error: " . mysqli_stmt_error($stmt));
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit;
}

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if ($row['status'] === 1) {
        // Access user data without exposing sensitive information

        $_SESSION['publi_fk_id_branch'] = osamah_encrypt_2($row['fk_branch']);
        $_SESSION['publi_img_user'] = $row['img_user'];
        $_SESSION['name_branch'] = $row['name_branch'];
        $_SESSION['job_name'] = $row['job_name'];

        $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);
    } else {
        // User is inactive, clear session and redirect
        session_unset();
        session_destroy();
        header('Location: ../index.php');
        exit;
    }
} else {
    // User not found, clear session and redirect
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit;
}


mysqli_stmt_close($stmt);



$stmt2 = mysqli_prepare($con, "SELECT * FROM `system_info`");

mysqli_stmt_execute($stmt2);

// Error handling
if (mysqli_stmt_error($stmt2)) {
    // Handle error, log it, and provide a user-friendly message
    die("Error: " . mysqli_stmt_error($stmt2));
}

$result2 = mysqli_stmt_get_result($stmt2);

$row2 = mysqli_fetch_assoc($result2);


$_SESSION['icon_system'] = $row2['icon_system'];
$_SESSION['name_system'] = $row2['name_system'];

mysqli_stmt_close($stmt2);


?>

<html lang="ar">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['name_system']); ?></title>
    <link rel="apple-touch-icon" href="../img/web_img/icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="../img/web_img/icon.png">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../Design/plugins/fontawesome-free-6.7.1-web/css/all.min.css">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="../Design/plugins/ekko-lightbox/ekko-lightbox.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../Design/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../Design/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../Design/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../Design/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../Design/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../Design/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- css for message -->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../Design/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../Design/plugins/toastr/toastr.min.css">
    <!-- Select2 important for select  -->
    <link rel="stylesheet" href="../Design/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../Design/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">



</head>



<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">


            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto" dir="rtl" alidn="right">
                <li class="nav-item dropdown user-menu">
                    <a href="olo" class="nav-link" data-bs-toggle="dropdown">
                        <img src="../img/web_img/<?php echo htmlspecialchars($_SESSION['icon_system']); ?>"
                            class="user-image rounded-circle shadow"
                            alt="<?php echo htmlspecialchars($_SESSION['name_system']); ?>"> <span
                            class="d-none d-md-inline"><?php echo htmlspecialchars($_SESSION['name_system']); ?></span>
                    </a>
                </li>
            </ul>


            <ul class="navbar-nav ml-auto" dir="rtl" alidn="right">
                <?php if (isset($_SESSION['name']) != "") {  ?>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="../img/img_user/<?php echo htmlspecialchars($_SESSION['publi_img_user']); ?>"
                            class="user-image rounded-circle shadow" alt="User Image"> <span
                            class="d-none d-md-inline"><?php echo htmlspecialchars(osamah_decrypt_2($_SESSION['name'])); ?></span> </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="dropdown-header">
                            <h6><?php echo htmlspecialchars($_SESSION['name_branch']); ?></h6>
                            <span><?php echo htmlspecialchars($_SESSION['job_name']); ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="my">
                                <i class="bi bi-person"></i>
                                <span>الملف الشخصي</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-question-circle"></i>
                                <span>طلب مساعده؟</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="out">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>تسجيل الخروج</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li>
                <!--end::User Menu Dropdown-->
                <?php } ?>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="olo" class="nav-link">الرئيسية</a>
                </li>

            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">


            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->

                        <?php
                        $sql = "SELECT * FROM `pages`JOIN pages_permission ON pages.id_page=pages_permission.fk_page_id  WHERE `page_status`=1 AND pages_permission.user_pages_status=1 AND pages_permission.fk_user_id=? ORDER BY `pages`.`sort` ASC ;";




                        $sql_page_show = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($sql_page_show, "i", $id_user_head);
                        mysqli_stmt_execute($sql_page_show);

                        $result_page_show = mysqli_stmt_get_result($sql_page_show);
                        while ($array_page = mysqli_fetch_assoc($result_page_show)) {


                        ?>


                        <li class="nav-item has-treeview">
                            <a href="<?php echo htmlspecialchars($array_page['link']); ?>" class="nav-link">
                                <i class="<?php echo htmlspecialchars($array_page['icon_page']); ?>"></i>
                                <p>
                                    <?php echo htmlspecialchars($array_page['name_page']); ?>
                                    <i class="right fas fa-angle-right"></i>
                                </p>
                            </a>

                        </li>



                        <?php }
                        ?>



                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">