<?php

include '../db.php';

//include 'message.php';

$dates = date('Y-m-d');

function osamah_encrypt($data) {
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


function osamah_decrypt($ciphertext) {
    $key='Osamah_qader_NajeAbdullahShahrah';
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


function encrypt_id($id)
{
    return base64_encode($id);
}

// Function to decrypt data
function decrypt_id($encoded_id)
{
    return base64_decode($encoded_id);
}

//all messge
function get_mess_info()
{
    include '../db.php';
?>
<div class="card card-warning" align="right">

    <div class="card-header">
        <h5>الرسائل</h5>
    </div>

    <!-- /.card-header -->

    <div class="card-body">
        <div class="table-responsive">

            <table id="show_all_order" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم الرسالة</th>
                        <th>من</th>
                        <th>إلى</th>
                        <th>اسم المرسل</th>
                        <th>رقم المرسل</th>
                        <th>تاريخ الاستلام</th>
                        <th>اسم المستلم</th>
                        <th>رقم المستلم</th>
                        <th>تاريخ التسليم</th>
                        <th>حالة الرسالة</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count_row = 0;
                        $sql = "SELECT o.`fk_level_mess`,o.QR, o.`id_order`, c1.cus_name AS 'sender_name', c1.cus_phone AS 'sender_phone', c2.cus_name AS 'recipient_name', c2.cus_phone AS 'recipient_phone', o.`date_of_receipt_sender`, o.`date_of_receipt_recipient`, o.`status_order`, br1.name_branch AS 'branch_sender', br2.name_branch AS 'branch_recipient' 
                        FROM `order` o 
                        JOIN customer c1 ON o.custom_id_sender = c1.id_customer 
                        JOIN customer c2 ON o.custom_id_recipient = c2.id_customer 
                        JOIN branch br1 ON o.fk_id_branch_sender = br1.id_branch 
                        JOIN branch br2 ON o.fk_id_branch_recipient = br2.id_branch 
                        WHERE   o.`fk_id_branch_sender` = ? OR o.fk_id_branch_recipient=? AND o.fk_level_mess <=5 
                        ORDER BY `o`.`date_of_receipt_sender` DESC";

                        $stmt = mysqli_prepare($con, $sql);
                        if (!$stmt) {
                            die('Prepare failed: ' . mysqli_error($con));
                        }

                        $publi_fk_id_branch = osamah_decrypt($_SESSION['publi_fk_id_branch']);
                        mysqli_stmt_bind_param($stmt, 'ii',$publi_fk_id_branch, $publi_fk_id_branch);

                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);

                            if (mysqli_num_rows($result) == 0) {
                                echo "<td colspan='11'><h6 class='text-center'> لا يوجد بيانات</h6></td>";
                            } else {
                                while ($row = mysqli_fetch_assoc($result)) {

                                    $fk_level_mess = $row['fk_level_mess'];

                        ?>

                    <tr>
                        <td><?php echo htmlspecialchars( $count_row += 1); ?></td>
                        <td class="sorting_1"><?php echo htmlspecialchars( $row['QR']); ?></td>
                        <td><?php echo htmlspecialchars( $row['branch_sender']); ?></td>
                        <td><?php echo htmlspecialchars( $row['branch_recipient']) ;?></td>
                        <td><?php echo htmlspecialchars( $row['sender_name'] );?></td>
                        <td><?php echo htmlspecialchars( $row['sender_phone']); ?></td>
                        <td><?php echo htmlspecialchars( $row['date_of_receipt_sender']); ?></td>
                        <td><?php echo htmlspecialchars( $row['recipient_name'] );?></td>
                        <td><?php echo htmlspecialchars( $row['recipient_phone'] );?></td>
                        <td><?php echo htmlspecialchars( $row['date_of_receipt_recipient']); ?></td>
                        <td>



                            <?php
                                            // Prepare the SQL statement to prevent SQL injection
                                            $stmt = mysqli_prepare($con, "SELECT * FROM `level_mess` WHERE `id_level_mess`=?");
                                            mysqli_stmt_bind_param($stmt, 'i', $fk_level_mess);
                                            mysqli_stmt_execute($stmt);
                                            $result_t = mysqli_stmt_get_result($stmt);

                                            if (mysqli_num_rows($result_t) > 0) {
                                                $r_u = mysqli_fetch_assoc($result_t);


                                                echo ($r_u['icon_status']);
                                                echo ($r_u['small_class']);
                                                echo ($r_u['name_level_mess']);
                                                echo ($r_u['close_small']);
                                                echo ($r_u['close_icon']);
                                            } else {
                                                echo "<td><h6 class='text-center'>لا يوجد </h6></td>";
                                            }

                                            // Handle order status
                                            if ($row['status_order'] == 2) {
                                                echo "<small class='badge badge-danger'> مسترجعة </small>";
                                            } elseif ($row['status_order'] == 3) {
                                                echo "<small class='badge badge-danger'> ملغية </small>";
                                            }
                                            ?>
                        </td>



                    </tr>
                    <?php

                                }
                            }
                        } else {
                            die('Execute failed: ' . mysqli_stmt_error($stmt));
                        }

                        mysqli_stmt_close($stmt);

                        ?>

                </tbody>

            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?php } ?>








<?php

function info_box_one($color, $icon, $titel, $number)
{
?>
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-<?php echo htmlspecialchars( $color); ?>"><i
                class="fas fa-<?php echo htmlspecialchars( $icon); ?>"></i></span>

        <div class="info-box-content">
            <span class="info-box-text"><?php echo htmlspecialchars( $titel); ?></span>
            <span class="info-box-number"><?php echo htmlspecialchars( $number); ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<?php }
?>





<?php

function chec_use_permission($page_id)
{
    include '../db.php';
    $sql_search_user_per = "SELECT * FROM `pages` JOIN pages_permission ON pages.id_page=pages_permission.fk_page_id
WHERE pages.id_page = ? AND pages_permission.fk_user_id = ?  AND pages.page_status = 1 AND pages_permission.user_pages_status = 1 ";

    $ty1= osamah_decrypt($_SESSION['id_user']);
    $stmt = mysqli_prepare($con, $sql_search_user_per);
    mysqli_stmt_bind_param($stmt, "ii", $page_id, $ty1);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        return true ;
    } else {
        return false;
    }
}
?>









<?php

function content_header($page_title)
{
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class=" col-sm-6">
                    <ol class="breadcrumb float-sm-left">

                        <li class="breadcrumb-item"><a href="olo">الرئيسية</a></li>
                        <li class="breadcrumb-item active"><?php echo htmlspecialchars( $page_title); ?></li>
                    </ol>
            </div>
            <div class="col-sm-6" align="right">
                <h1 class="text-dark" "><?php echo htmlspecialchars( $page_title); ?></h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?php }
?>





<?php
function get_users($link, $link_ver, $color_style, $text, $type,$name_table) {
    include '../db.php';

    ?>

<div class="card card-warning card-outline">
    <div class="card-header">
        <h5>الموظفين</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="<?php echo htmlspecialchars( $name_table) ; ?>" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>بيانات الموظف</th>
                        <th>رقم الهاتف</th>
                        <th>البريد الإلكتروني</th>
                        <?php if ($type) { ?>
                        <th>حالة الموظف</th>
                        <?php } ?>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count_row = 0;
                            $ty2=osamah_decrypt($_SESSION['publi_fk_id_branch']);
                        // Prepare the SQL statement to prevent SQL injection
                        $stmt = mysqli_prepare($con, "SELECT * FROM users WHERE status != 3 AND `fk_branch`= ?  ");
                        mysqli_stmt_bind_param($stmt, "i",$ty2);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $count_row++;
                            ?>

                    <tr>
                        <td><?php echo htmlspecialchars( $count_row); ?></td>
                        <td>
                            <img width='50px' height='50px' class='img-fluid rounded'
                                src="../img/img_user/<?php echo ($row['img_user']); ?>"
                                alt="<?php echo htmlspecialchars($row['name']); ?>">

                            <?php echo htmlspecialchars($row['name']); ?>

                            <input type="hidden" name="id_user" id="id_user"
                                value="<?php echo htmlspecialchars($row['id_user']); ?>">
                        </td>
                        <td><?php echo htmlspecialchars($row['user_phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['email_user']); ?></td>

                        <?php if ($type) { ?>
                        <td>
                            <?php
                                        $status_sc = $row['status'] == 1 ? 'checked' : 'check';
                                        ?>

                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input"
                                        id="<?php echo htmlspecialchars( $row['id_user']); ?>" name="user_status"
                                        value="<?php echo htmlspecialchars( $row['status']); ?>"
                                        <?php echo htmlspecialchars( $status_sc); ?>>
                                    <label class="custom-control-label"
                                        for="<?php echo htmlspecialchars( $row['id_user']); ?>">
                                        <?php
                                                    if ($row['status'] == 1) {
                                                        echo "<small class='badge badge-warning'> مفعل </small>";
                                                    } else {
                                                        echo "<small class='badge badge-danger'> غيرمفعل </small>";
                                                    }
                                                    ?>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <?php } ?>
                        <td>
                            <a title="😉" class="btn btn-<?php echo htmlspecialchars( $color_style); ?> btn-sm"
                                href="<?php echo htmlspecialchars( $link); ?>?<?php echo htmlspecialchars( $link_ver); ?>=<?php echo encrypt_id( $row['id_user']); ?>"
                                role="button">
                                <?php echo htmlspecialchars($text); ?>
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
}
?>






<?php

function get_service($name_table, $link_ver, $color_style, $title, $button_name, $id_item, $name_show,$statues)
{
    include '../db.php';
    $name = "n";
    $detiles = "d";
    if ($id_item) {
        $sql = "SELECT * FROM " . $name_table . " WHERE " . $link_ver . "=? AND ".$statues."=1 ;";
        $stmt = mysqli_prepare($con, $sql);

        mysqli_stmt_bind_param($stmt, "i", $id_item);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                $name = $row[1];
                $detiles = $row[2];
            }
        }
    }
?>
<div class="col">
    <div class="card card-<?php echo htmlspecialchars($color_style); ?> card-outline " >
        <div class="card-header">
            <h4><?php echo htmlspecialchars( $title); ?></h4>
        </div>
        <!-- /.card-header -->


        <form role="form" action="IIihjndiuh" method="post" type="form" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="name_<?php echo htmlspecialchars( $name_table); ?>">اسم
                        <?php echo htmlspecialchars( $name_show); ?></label>
                    <input type="text" class="form-control" id="name_<?php echo htmlspecialchars( $name_table); ?>"
                        name="name_<?php echo htmlspecialchars( $name_table); ?>"
                        value="<?php if ($id_item) {
                                                                                                                                                        echo htmlspecialchars($name);
                                                                                                                                                    } ?>"
                        placeholder="اسم <?php echo htmlspecialchars( $name_show); ?>" required>
                    <input type="hidden" class="form-control" id="id_<?php echo htmlspecialchars( $name_table); ?>"
                        name="id_<?php echo htmlspecialchars( $name_table); ?>"
                        value="<?php if ($id_item) {
                                                                                                                                                        echo htmlspecialchars($id_item);
                                                                                                                                                    } ?>">

                </div>
                <div class="form-group">
                    <label for="detil_<?php echo htmlspecialchars( $name_table); ?>">وصف
                        <?php echo htmlspecialchars( $name_show); ?></label>
                    <input type="text" class="form-control" id="detil_<?php echo htmlspecialchars( $name_table); ?>"
                        name="detil_<?php echo htmlspecialchars( $name_table); ?>"
                        value="<?php if ($id_item) {
                                                                                                                                                            echo htmlspecialchars($detiles);
                                                                                                                                                        } ?>"
                        placeholder="وصف <?php echo htmlspecialchars( $name_show); ?>" required>
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">

                <button type="submit" name="<?php echo htmlspecialchars( $button_name); ?>"
                    id="<?php echo htmlspecialchars( $button_name); ?>"
                    class="btn btn-block btn-<?php if ($id_item) {
                                                                                                                                            echo "danger";
                                                                                                                                        } else {
                                                                                                                                            echo htmlspecialchars($color_style);
                                                                                                                                        }; ?> btn-sm"><?php if ($id_item) {
                                                                                                                                                                                                                echo "تعديل";
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                echo "إضافة";
                                                                                                                                                                                                            } ?></button>
            </div>
        </form>

        <div class="table-responsive">

            <table id="<?php echo htmlspecialchars( $name_table); ?>" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th># </th>
                        <th>اسم <?php echo htmlspecialchars( $name_show); ?></th>
                        <th>وصف <?php echo htmlspecialchars( $name_show); ?></th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count_row = 0;
                        $sql_table = "SELECT * FROM " . $name_table." WHERE ".$statues."=1;";
                        $stmt_table = mysqli_prepare($con, $sql_table);

                       
                        if (mysqli_stmt_execute($stmt_table)) {
                            $result_table = mysqli_stmt_get_result($stmt_table);
                
                            if (mysqli_num_rows($result_table) > 0) {
                              

                        while ($r = mysqli_fetch_array($result_table)) {
                        ?>

                    <tr>
                        <td><?php echo htmlspecialchars( $count_row += 1); ?></td>
                        <td>
                            <?php echo htmlspecialchars( $r[1]) ?>
                            <input type="hidden" name="<?php echo htmlspecialchars( $link_ver); ?>"
                                id='<?php echo htmlspecialchars( $link_ver); ?>'
                                value=" <?php echo htmlspecialchars( $r[0]); ?>"></input>
                        </td>
                        <td><?php echo htmlspecialchars( $r[2]); ?></td>

                        <td>
                            <a title="تعديل البيانات"
                                class="btn btn-<?php echo htmlspecialchars($color_style); ?> btn-sm "
                                href="nnnnnkug?<?php echo htmlspecialchars( $link_ver); ?>=<?php echo encrypt_id( $r[0]); ?>"
                                role=" button">
                                <i class="fas fa-edit"></i></a>
                        </td>


                    </tr>
                    <?php

                        }
                    }}
                        ?>

                </tbody>

            </table>
        </div>

        <!-- /.card -->
    </div>
</div>
<?php }
?>













<?php
//counts  the main branch
function get_coun_order()
{
    include '../db.php';
    $publi_fk_id_branch=osamah_decrypt($_SESSION['publi_fk_id_branch']);

    
    $sql_coun_ord = "SELECT COUNT(`id_order`)as 'coun_ord' FROM `order` WHERE `check_receipt_sender`=1 AND (`fk_id_branch_sender` = ? OR fk_id_branch_recipient=?) ;";

    $stmt_sql_coun_ord = mysqli_prepare($con,$sql_coun_ord);
    mysqli_stmt_bind_param($stmt_sql_coun_ord, 'ii',$publi_fk_id_branch,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_coun_ord);
    $result_coun_ord = mysqli_stmt_get_result($stmt_sql_coun_ord);

    if (mysqli_num_rows($result_coun_ord) > 0) {
        $r_u = mysqli_fetch_assoc($result_coun_ord);
        return $r_u['coun_ord'];
    }
}


function get_coun_wait_export()
{
    include '../db.php';
    $publi_fk_id_branch=osamah_decrypt($_SESSION['publi_fk_id_branch']);

    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` WHERE  `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=1  AND (`fk_id_branch_sender` = ? OR fk_id_branch_recipient=?) ;";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, 'ii',$publi_fk_id_branch ,$publi_fk_id_branch);
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}


function get_coun_recev_driver_export()
{
    include '../db.php';
    $publi_fk_id_branch=osamah_decrypt($_SESSION['publi_fk_id_branch']);

    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=2 AND (`fk_id_branch_sender` = ? OR fk_id_branch_recipient=?) ;";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, 'ii',$publi_fk_id_branch,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}

function get_coun_export()
{
    include '../db.php';
    $publi_fk_id_branch=osamah_decrypt($_SESSION['publi_fk_id_branch']);

    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=3 AND (`fk_id_branch_sender` = ? OR fk_id_branch_recipient=?) ;";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, 'ii',$publi_fk_id_branch,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}


function get_coun_wait_import()
{
    include '../db.php';
    $publi_fk_id_branch=osamah_decrypt($_SESSION['publi_fk_id_branch']);


    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` WHERE `check_receipt_sender`=1  AND `status_order`=1 AND  `fk_level_mess`=4  AND (`fk_id_branch_sender` = ? OR fk_id_branch_recipient=?)  ;";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, 'ii',$publi_fk_id_branch,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}


function get_coun_import()
{
    include '../db.php';
    $publi_fk_id_branch=osamah_decrypt($_SESSION['publi_fk_id_branch']);


    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND  `fk_level_mess`=5 AND (`fk_id_branch_sender` = ? OR fk_id_branch_recipient=?)  ;";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, 'ii',$publi_fk_id_branch,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}

function get_coun_compliat()
{
    include '../db.php';
    $publi_fk_id_branch=osamah_decrypt($_SESSION['publi_fk_id_branch']);


    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1  AND `fk_level_mess`=6 AND (`fk_id_branch_sender` = ? OR fk_id_branch_recipient=?)  ;";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, 'ii',$publi_fk_id_branch,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}

function get_count_stop()
{
    include '../db.php';
    $publi_fk_id_branch=osamah_decrypt($_SESSION['publi_fk_id_branch']);

    $sql_ord_stop = "SELECT COUNT(`id_order`)as 'stop' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`!=1 AND(`fk_id_branch_sender` = ? OR fk_id_branch_recipient=?) ;";
   
   
    $stmt_sql_ord_stop = mysqli_prepare($con,$sql_ord_stop);
    mysqli_stmt_bind_param($stmt_sql_ord_stop, 'ii',$publi_fk_id_branch,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_ord_stop);
    $result_sql_ord_stop = mysqli_stmt_get_result($stmt_sql_ord_stop);

    if (mysqli_num_rows($result_sql_ord_stop) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_ord_stop);
        return $r_u['stop'];
    }
    
   
}



//counts for user


function get_user_coun_order($user_id)
{
    include '../db.php';


    
    $sql_coun_ord = "SELECT COUNT(`id_order`)as 'coun_ord' FROM `order` WHERE `check_receipt_sender`=1 AND (`user_id_receipt_sender`= ? OR `user_id__export`=? OR `user_id__import`=? OR `user_id__receipt_recipient` =? OR `fk_id_driver`=?) ;";

    $stmt_sql_coun_ord = mysqli_prepare($con,$sql_coun_ord);
    mysqli_stmt_bind_param($stmt_sql_coun_ord, 'iiiii',$user_id,$user_id,$user_id,$user_id,$user_id );
    mysqli_stmt_execute($stmt_sql_coun_ord);
    $result_coun_ord = mysqli_stmt_get_result($stmt_sql_coun_ord);

    if (mysqli_num_rows($result_coun_ord) > 0) {
        $r_u = mysqli_fetch_assoc($result_coun_ord);
        return $r_u['coun_ord'];
    }
}

function get_user_coun_wait_export($user_id)
{
    include '../db.php';


    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=1 AND (`user_id_receipt_sender`=? OR `fk_id_driver`=? );";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, 'ii',$user_id,$user_id );
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}

function get_user_coun_recvev_driver_export($user_id)
{
    include '../db.php';


    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=2 AND (`user_id__export`=? OR `fk_id_driver`=? );";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, 'ii',$user_id,$user_id );
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}

function get_user_coun_export($user_id)
{
    include '../db.php';


    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=3 AND (`user_id__export`=? OR `fk_id_driver`=? );";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, 'ii',$user_id,$user_id );
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}

function get_user_coun_wait_import($user_id)
{
    include '../db.php';



    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=4 AND (`user_id__import`=? OR `fk_id_driver`=? );";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, 'ii',$user_id ,$user_id );
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}

function get_user_coun_import($user_id)
{
    include '../db.php';



    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=5 AND (`user_id__receipt_recipient`=? OR `fk_id_driver`=? );";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, 'ii',$user_id ,$user_id );
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}


function get_user_coun_complait($user_id)
{
    include '../db.php';



    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` WHERE `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=6 AND (`user_id__receipt_recipient`=? OR `fk_id_driver`=? );";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, 'ii',$user_id ,$user_id );
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}

function get_user_count_stop($user_id)
{
    include '../db.php';


    $sql_ord_stop = "SELECT COUNT(`id_order`)as 'stop' FROM `order` WHERE `status_order`!=1  AND(`user_id_receipt_sender`= ? OR `user_id__export`=? OR `user_id__import`=? OR `user_id__receipt_recipient` =? OR `fk_id_driver`=?) ;";
   
   
    $stmt_sql_ord_stop = mysqli_prepare($con,$sql_ord_stop);
    mysqli_stmt_bind_param($stmt_sql_ord_stop, 'iiiii',$user_id,$user_id,$user_id,$user_id,$user_id );
    mysqli_stmt_execute($stmt_sql_ord_stop);
    $result_sql_ord_stop = mysqli_stmt_get_result($stmt_sql_ord_stop);

    if (mysqli_num_rows($result_sql_ord_stop) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_ord_stop);
        return $r_u['stop'];
    }
    
   
}


//counts branch


function get_branch_coun_order($branch_id)
{
    include '../db.php';
    
    $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);
    
    $sql_coun_ord = "SELECT COUNT(`id_order`)as 'coun_ord' FROM `order` o WHERE  `check_receipt_sender`=1 AND ((o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)) ;";

    $stmt_sql_coun_ord = mysqli_prepare($con,$sql_coun_ord);
    mysqli_stmt_bind_param($stmt_sql_coun_ord, "iiii",$publi_fk_id_branch,$branch_id,$branch_id,$publi_fk_id_branch);
    mysqli_stmt_execute($stmt_sql_coun_ord);
    $result_coun_ord = mysqli_stmt_get_result($stmt_sql_coun_ord);

    if (mysqli_num_rows($result_coun_ord) > 0) {
        $r_u = mysqli_fetch_assoc($result_coun_ord);
        return $r_u['coun_ord'];
    }
}

function get_branch_coun_wait_export($branch_id)
{
    include '../db.php';
    
    $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);

    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` o WHERE  `check_receipt_sender`=1 AND `status_order`=1  AND `fk_level_mess`=1 AND ((o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)) ;";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, "iiii",$publi_fk_id_branch,$branch_id,$branch_id,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}
function get_branch_coun_recev_driver_export($branch_id)
{
    include '../db.php';
    
    $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);

    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` o WHERE  `check_receipt_sender`=1 AND `status_order`=1  AND `fk_level_mess`=2 AND ((o.`fk_id_branch_sender` = ? and o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)) ;";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, "iiii",$publi_fk_id_branch,$branch_id,$branch_id,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}
function get_branch_coun_export($branch_id)
{
    include '../db.php';
    
    $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);

    $sql_export = "SELECT COUNT(`id_order`)as 'export' FROM `order` o WHERE  `check_receipt_sender`=1 AND `status_order`=1  AND `fk_level_mess`=3 AND ((o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)) ;";
    
    
    $stmt_sql_export = mysqli_prepare($con,$sql_export);
    mysqli_stmt_bind_param($stmt_sql_export, "iiii",$publi_fk_id_branch,$branch_id,$branch_id,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_export);
    $result_sql_export = mysqli_stmt_get_result($stmt_sql_export);

    if (mysqli_num_rows($result_sql_export) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_export);
        return $r_u['export'];
    }
    

}
function get_branch_coun_wait_import($branch_id)
{
    include '../db.php';
    

    $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);

    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` o WHERE  `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=4 AND ((o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)) ;";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, "iiii",$publi_fk_id_branch,$branch_id,$branch_id,$publi_fk_id_branch);
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}
function get_branch_coun_import($branch_id)
{
    include '../db.php';
    

    $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);

    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` o WHERE  `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=5 AND ((o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)) ;";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, "iiii",$publi_fk_id_branch,$branch_id,$branch_id,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}
function get_branch_coun_complait($branch_id)
{
    include '../db.php';
    

    $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);

    $sql_import = "SELECT COUNT(`id_order`)as 'import' FROM `order` o WHERE  `check_receipt_sender`=1 AND `status_order`=1 AND `fk_level_mess`=6 AND ((o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?));";
    
    $stmt_sql_import = mysqli_prepare($con,$sql_import);
    mysqli_stmt_bind_param($stmt_sql_import, "iiii",$publi_fk_id_branch,$branch_id,$branch_id,$publi_fk_id_branch );
    mysqli_stmt_execute($stmt_sql_import);
    $result_sql_import = mysqli_stmt_get_result($stmt_sql_import);

    if (mysqli_num_rows($result_sql_import) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_import);
        return $r_u['import'];
    }
    

}
function get_branch_count_stop($branch_id)
{
    include '../db.php';
    
 $publi_fk_id_branch = osamah_decrypt_2($_SESSION['publi_fk_id_branch']);

    $sql_ord_stop = "SELECT COUNT(`id_order`)as 'stop' FROM `order` o WHERE `status_order`!=1 AND ((o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)) ;";
   
   
    $stmt_sql_ord_stop = mysqli_prepare($con,$sql_ord_stop);
    mysqli_stmt_bind_param($stmt_sql_ord_stop,"iiii",$publi_fk_id_branch,$branch_id,$branch_id,$publi_fk_id_branch);
    mysqli_stmt_execute($stmt_sql_ord_stop);
    $result_sql_ord_stop = mysqli_stmt_get_result($stmt_sql_ord_stop);

    if (mysqli_num_rows($result_sql_ord_stop) > 0) {
        $r_u = mysqli_fetch_assoc($result_sql_ord_stop);
        return $r_u['stop'];
    }
    
   
}


?>










<?php
function get_select($name_labe,$id_input,$id_item,$value,$name_id_table,$name_table)
{

    include '../db.php';
    ?>
<div class="form-group">
    <label><?php echo htmlspecialchars( $name_labe); ?></label>
    <select name="<?php echo htmlspecialchars( $id_input); ?>" id="<?php echo htmlspecialchars( $id_input); ?>"
        class="form-control select2bs4">
        <?php
    $branch_selected = 0;
    if ($id_item > 0) {
        $sql = "SELECT * FROM `".$name_table."` WHERE ".$name_id_table." = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $value);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $branch_selected = $row[0];
            echo "<option  value='$row[0]'>$row[1]</option>";
        }

        $sql = "SELECT * FROM `".$name_table."` WHERE ".$name_id_table." != ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $branch_selected);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            echo "<option value='0'>لاشيء</option>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                echo "<option value='$row[0]'>$row[1]</option>";
            }
        }
    } else {
        

        $sql = "SELECT * FROM ".$name_table."  ;";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            echo "<option value='0'>لاشيء</option>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                echo "<option value='$row[0]'>$row[1]</option>";
            }
        }
    }
    ?>
    </select>
</div>
<?php }
?>










<?php
function get_select_2($name_labe,$id_input,$id_item,$value,$name_id_table,$name_table)
{
    $main_value=osamah_decrypt($_SESSION['publi_fk_id_branch']);
    include '../db.php';
    ?>
<div class="form-group">
    <label><?php echo htmlspecialchars( $name_labe); ?></label>
    <select name="<?php echo htmlspecialchars( $id_input); ?>" id="<?php echo htmlspecialchars( $id_input); ?>"
        class="form-control select2bs4">
        <?php
    $branch_selected = 0;
    if ($id_item > 0) {
        $sql = "SELECT * FROM `".$name_table."` WHERE ".$name_id_table." = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $value);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $branch_selected = $row[0];
            echo "<option  value='$row[0]'>$row[1]</option>";
        }

        $sql = "SELECT * FROM `".$name_table."` WHERE ".$name_id_table." != ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $branch_selected);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            echo "<option value='0'>لاشيء</option>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                echo "<option value='$row[0]'>$row[1]</option>";
            }
        }
    } else {
       
        $sql = "SELECT * FROM ".$name_table." WHERE ".$name_id_table." != ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $main_value);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            echo "<option value='0'>لاشيء</option>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                echo "<option value='$row[0]'>$row[1]</option>";
            }
        }
    }
    ?>
    </select>
</div>
<?php }









































?>