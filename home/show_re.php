<?php

include "../db.php";
include "check.php";




$page_id = 21;
if (chec_use_permission($page_id)) {

    static $title1 = 0;

    static $coun_order = 0;
    static $coun_wait_export = 0;
    static $coun_recev_driver_export = 0;
    static $coun_export = 0;
    static $coun_wait_import = 0;
    static $coun_import = 0;
    static $coun_complait = 0;
    static $count_stop = 0;

    static $stmt_bra = 0;

    static $user_id = 0;
    static $user_driver_id = 0;
    static $user_name = 0;
    static $user_user_phone = 0;
    static $user_email_user = 0;
    static $user_img_user = 0;
    static $user_user_job = 0;

    if (isset($_GET['efgbnmkoiuygbn'])) {

        $user_id = decrypt_id($_GET['efgbnmkoiuygbn']);

        $stmt_user = mysqli_prepare($con, "SELECT `id_user`, `name`, `user_phone`, `email_user`,`img_user`,jo.job_name
        FROM `users` u JOIN jobs_table jo ON u.user_job=jo.job_id WHERE `id_user`=? ;");
        mysqli_stmt_bind_param($stmt_user, "i", $user_id);
        mysqli_stmt_execute($stmt_user);

        $result_user_number = mysqli_stmt_get_result($stmt_user);
        while ($array_user = mysqli_fetch_assoc($result_user_number)) {

            $user_id = $array_user['id_user'];
            $title1 = $array_user['name'];
            $user_user_phone = $array_user['user_phone'];
            $user_email_user = $array_user['email_user'];
            $user_img_user = $array_user['img_user'];
            $user_user_job = $array_user['job_name'];
        }

        $coun_order = get_user_coun_order($user_id);
        $coun_wait_export = get_user_coun_wait_export($user_id);
        $coun_recev_driver_export = get_user_coun_recvev_driver_export($user_id);
        $coun_export = get_user_coun_export($user_id);
        $coun_wait_import = get_user_coun_wait_import($user_id);
        $coun_import = get_user_coun_import($user_id);
        $coun_complait = get_user_coun_complait($user_id);
        $count_stop = get_user_count_stop($user_id);



        $sql = "SELECT o.`fk_level_mess`,o.QR,`id_order`,c1.cus_name as 'sender_nsame',c1.cus_phone as 'sender_phone',c2.cus_name as 'receive_name',c2.cus_phone as 'recip_phone'
        ,`date_of_receipt_sender`,`status_order`,br1.name_branch as 'branch_sender',br2.name_branch as 'branch_recipe'  
        FROM `order` o 
        JOIN customer c1 ON o.custom_id_sender=c1.id_customer 
        JOIN customer c2 ON o.custom_id_recipient=c2.id_customer 
        JOIN branch br1 ON o.fk_id_branch_sender=br1.id_branch 
        JOIN branch br2 ON o.fk_id_branch_recipient=br2.id_branch
         WHERE `user_id_receipt_sender`= ? OR `user_id__export`=? OR `user_id__import`=? OR `user_id__receipt_recipient` =? OR `fk_id_driver`=? ;   
         ";
        $stmt_bra = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_bra, "iiiii", $user_id, $user_id, $user_id, $user_id, $user_id);
    }

    static $driver_id = 0;
    static $driver_name = 0;
    static $driver_user_phone = 0;
    static $driver_email_user = 0;
    static $driver_img_user = 0;
    static $driver_user_job = 0;
    if (isset($_GET['jhsdhkfgisdu'])) {

        $driver_id = decrypt_id($_GET['jhsdhkfgisdu']);
        $sql_quer_drivers = "SELECT `id_user`, `name`, `user_phone`, `email_user`, `img_user`,jo.job_name
        FROM `users` u JOIN jobs_table jo ON u.user_job=jo.job_id
        WHERE jo.`job_id`='3' AND `id_user`=? ;";
        $stmt_dri = mysqli_prepare($con, $sql_quer_drivers);
        mysqli_stmt_bind_param($stmt_dri, "i", $driver_id);
        mysqli_stmt_execute($stmt_dri);

        $result_drivers = mysqli_stmt_get_result($stmt_dri);

        while ($array_drivers = mysqli_fetch_assoc($result_drivers)) {
            $driver_id = $array_drivers['id_user'];
            $title1 = $array_drivers['name'];
            $driver_user_phone = $array_drivers['user_phone'];
            $driver_email_user = $array_drivers['email_user'];
            $driver_img_user = $array_drivers['img_user'];
            $driver_user_job = $array_drivers['job_name'];
        }

        $coun_order = get_user_coun_order($driver_id);
        $coun_wait_export = get_user_coun_wait_export($driver_id);
        $coun_recev_driver_export = get_user_coun_recvev_driver_export($driver_id);
        $coun_export = get_user_coun_export($driver_id);
        $coun_wait_import = get_user_coun_wait_import($driver_id);
        $coun_import = get_user_coun_import($driver_id);
        $coun_complait = get_user_coun_complait($driver_id);
        $count_stop = get_user_count_stop($driver_id);





        $sql = "SELECT o.`fk_level_mess`,o.QR,`id_order`,c1.cus_name as 'sender_nsame',c1.cus_phone as 'sender_phone',c2.cus_name as 'receive_name',c2.cus_phone as 'recip_phone'
        ,`date_of_receipt_sender`,`status_order`,br1.name_branch as 'branch_sender',br2.name_branch as 'branch_recipe'  
        FROM `order` o 
        JOIN customer c1 ON o.custom_id_sender=c1.id_customer 
        JOIN customer c2 ON o.custom_id_recipient=c2.id_customer 
        JOIN branch br1 ON o.fk_id_branch_sender=br1.id_branch 
        JOIN branch br2 ON o.fk_id_branch_recipient=br2.id_branch
         WHERE  `user_id_receipt_sender`= ? OR `user_id__export`=? OR `user_id__import`=? OR `user_id__receipt_recipient` =? OR `fk_id_driver`=? ;   
         ";
        $stmt_bra = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_bra, "iiiii", $driver_id, $driver_id, $driver_id, $driver_id, $driver_id);
    }

    static $id_branch = 0;
    static $name_branch = 0;
    if (isset($_GET['iusfyw87fgknk'])) {

        $id_branch = decrypt_id($_GET['iusfyw87fgknk']);
        $stmt_bra = mysqli_prepare($con, "SELECT `id_branch`, `name_branch`
        FROM `branch` 
        WHERE `id_branch`=? ;");
        mysqli_stmt_bind_param($stmt_bra, "i", $id_branch);
        mysqli_stmt_execute($stmt_bra);

        $result_branch_number = mysqli_stmt_get_result($stmt_bra);
        while ($array_branch = mysqli_fetch_assoc($result_branch_number)) {
            $id_branch = $array_branch['id_branch'];
            $title1 = $array_branch['name_branch'];
        }


        $coun_order = get_branch_coun_order($id_branch);
        $coun_wait_export = get_branch_coun_wait_export($id_branch);
        $coun_recev_driver_export = get_branch_coun_recev_driver_export($id_branch);
        $coun_export = get_branch_coun_export($id_branch);
        $coun_wait_import = get_branch_coun_wait_import($id_branch);
        $coun_import = get_branch_coun_import($id_branch);
        $coun_complait = get_branch_coun_complait($id_branch);
        $count_stop = get_branch_count_stop($id_branch);





        $sql = "SELECT o.`fk_level_mess`,o.QR,`id_order`,c1.cus_name as 'sender_nsame',c1.cus_phone as 'sender_phone',c2.cus_name as 'receive_name',c2.cus_phone as 'recip_phone'
        ,`date_of_receipt_sender`,`status_order`,br1.name_branch as 'branch_sender',br2.name_branch as 'branch_recipe'  
        FROM `order` o 
        JOIN customer c1 ON o.custom_id_sender=c1.id_customer 
        JOIN customer c2 ON o.custom_id_recipient=c2.id_customer 
        JOIN branch br1 ON o.fk_id_branch_sender=br1.id_branch 
        JOIN branch br2 ON o.fk_id_branch_recipient=br2.id_branch
         WHERE  (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?)  OR   (o.`fk_id_branch_sender` = ? AND o.fk_id_branch_recipient=?) ;
         ";
        $stmt_bra = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_bra, "iiii",$publi_fk_id_branch,$id_branch,$id_branch,$publi_fk_id_branch);
    }




    $title=' التقارير الخاصة بي '.$title1;
    content_header( $title)
?>

<section class="content" dir="rtl" align="right">
    <div class="container-fluid">







        <div class="row" align="right">

            <?php info_box_one('info', 'envelope', 'كافة الرسائل', $coun_order) ?>
            <?php info_box_one('secondary', 'icon fas fa-home', 'بمكتب الإرسال', $coun_wait_export) ?>
            <?php info_box_one('dark', 'ambulance', 'مسلم للسائق', $coun_recev_driver_export) ?>
            <?php info_box_one('primary', 'truck', 'في الطريق', $coun_export) ?>


        </div>

        <div class="row" align="right">

           
            <?php info_box_one('warning', 'copy', 'مسلم لموظف التسلم',$coun_wait_import) ?>
            <?php info_box_one('info', 'building', 'في مكتب التسليم',  $coun_import) ?>
            <?php info_box_one('success', 'check', 'مكتمل', $coun_complait) ?>
            <?php info_box_one('danger', 'x', 'الرسائل الملغية', $count_stop) ?>

        </div>



        <!-- get all messge-->

        <div class="card card-warning card-outline">

            <div class="card-header">
                <h5>الرسائل</h5>
            </div>

            <!-- /.card-header -->

            <div class="card-body">
                <div class="col-sm-12 table-responsive p-0">

                    <table id="show_order_for_report" class="table table-bordered table-striped">
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
                                <th>حالة الرسالة</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count_row = 0;

                                mysqli_stmt_execute($stmt_bra);

                                $result_branch_number = mysqli_stmt_get_result($stmt_bra);
                                while ($array_messages = mysqli_fetch_assoc($result_branch_number)) {


                                ?>

                            <tr>
                                <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                <td class="sorting_1"><?php echo htmlspecialchars($array_messages['QR']); ?></td>
                                <td><?php echo htmlspecialchars($array_messages['branch_sender']); ?></td>
                                <td><?php echo htmlspecialchars($array_messages['branch_recipe']); ?></td>

                                <td><?php echo htmlspecialchars($array_messages['sender_nsame']); ?></td>
                                <td><?php echo htmlspecialchars($array_messages['sender_phone']); ?></td>
                                <td><?php echo htmlspecialchars($array_messages['date_of_receipt_sender']); ?></td>

                                <td><?php echo htmlspecialchars($array_messages['receive_name']); ?></td>
                                <td><?php echo htmlspecialchars($array_messages['recip_phone']); ?></td>



                                <td>



                                    <?php
                                            // Prepare the SQL statement to prevent SQL injection
                                            $stmt = mysqli_prepare($con, "SELECT * FROM `level_mess` WHERE `id_level_mess`=?");
                                            mysqli_stmt_bind_param($stmt, 'i', $array_messages['fk_level_mess']);
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
                                            if ($array_messages['status_order'] == 2) {
                                                echo "<small class='badge badge-danger'> مسترجعة </small>";
                                            } elseif ($array_messages['status_order'] == 3) {
                                                echo "<small class='badge badge-danger'> ملغية </small>";
                                            }
                                            ?>
                                </td>





                            </tr>
                            <?php

                                }

                                ?>

                        </tbody>

                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
</section>
<?php

    include "footer.php";
} else {
    include "Error404.php";
}
?>