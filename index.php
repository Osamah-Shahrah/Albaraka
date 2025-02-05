<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!session_start()) {
    die("Failed to start session");
}

include 'db.php';

// Security Headers
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self';");




function osamah_encrypt_ind($data) {
    $key='Osamah_qader_NajeAbdullahShahrah';
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







// Check if already logged in
if (isset($_SESSION['logged_in_user']) && isset($_SESSION['id_user']) && isset($_SESSION['name']) && $_SESSION['name'] !== "") {
    header('location:home/olo');
    exit;
}

$error = "";  // Initialize error message variable

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['Email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Prepare the SQL statement
    $stmt = mysqli_prepare($con, "SELECT id_user, name, status, password_user FROM users WHERE email_user = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    // Error handling
    if (mysqli_stmt_error($stmt)) {
        $error = "Error: " . htmlspecialchars(mysqli_stmt_error($stmt));
    } else {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $row['password_user'])) {
                if ($row['status'] === 1) {
                    // Regenerate session ID upon login
                    session_regenerate_id(true);
                    
                    $_SESSION['id_user'] = osamah_encrypt_ind($row['id_user']);
                    $_SESSION['name'] =  osamah_encrypt_ind($row['name']);
                    $_SESSION['logged_in_user'] = osamah_encrypt_ind(1);

                    header("location:home/olo");
                    exit;
                } else {
                    $error = "هذا الحساب غير فعال";
                }
            } else {
                $error = "خطاء في الايميل او كلمه المرور";
            }
        } else {
            $error = "خطاء في الايميل او كلمه المرور";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($con); // Close the database connection
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>تسجيل الدخول</title>
  <link rel="apple-touch-icon" href="img/web_img/icon.png">
  <link rel="shortcut icon" type="image/x-icon" href="img/web_img/icon.png">

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="Design/plugins/fontawesome-free/css/all.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="Design/plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="Design/dist/css/adminlte.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="Design/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="Design/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="Design/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- css for message -->
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="Design/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="Design/plugins/toastr/toastr.min.css">


</head>


<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>تسجيل</b> الدخول</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">تسجيل الدخول</p>

                <form method="POST">

                    <div class="input-group mb-3">
                        <input type="Email" name="Email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="كلمة المرور">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($error != "") { ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php } ?>

                    <button class="btn btn-block btn-primary" type="submit" name="login">تسجيل الدخول</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>