<?php

include "../db.php";
include "check.php";




$page_id = 18;
if (chec_use_permission($page_id)) {

    static $id_order = 0;
    if (isset($_GET['pplZZndhnAAqaswe'])) {

        $id_order = decrypt_id($_GET['pplZZndhnAAqaswe']);

        $sql_quer_usert = "UPDATE `order` SET `status_order`='3' WHERE `id_order`='" . $id_order . "'";
        $execution_query_user = mysqli_query($con, $sql_quer_usert) or die(mysqli_error($con));
    }

    static $id_order_comeback = 0;
    if (isset($_GET['oQQsflnfaed'])) {

        $id_order_comeback =decrypt_id($_GET['oQQsflnfaed']);

        $sql_quer_usert = "UPDATE `order` SET `status_order`='2' WHERE `id_order`='" . $id_order_comeback . "'";



        $execution_query_user = mysqli_query($con, $sql_quer_usert) or die(mysqli_error($con));
    }


?>


<?php
    content_header('إدارة الرسائل')
    ?>



<section class="content" dir="rtl" align="right">
    <div class="container-fluid">





        <div class="card card-warning card-outline">

            <div class="card-header">
                <h5>الرسائل</h5>
            </div>

            <!-- /.card-header -->

            <div class="card-body">
                <div class="col-sm-12 table-responsive p-0">

                    <table id="cancel_or_back_order" class="table table-bordered table-striped">
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
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count_row = 0;
                                $sql = "SELECT o.`fk_level_mess`,o.QR,`id_order`,c1.cus_name as 'sender_nsame',c1.cus_phone as 'sender_phone',c2.cus_name as 'receive_name',c2.cus_phone as 'recip_phone'
                                    ,`date_of_receipt_sender`,`status_order`,br1.name_branch as 'branch_sender',br2.name_branch as 'branch_recipe'  
                                    FROM `order` o 
                                    JOIN customer c1 ON o.custom_id_sender=c1.id_customer 
                                    JOIN customer c2 ON o.custom_id_recipient=c2.id_customer 
                                    JOIN branch br1 ON o.fk_id_branch_sender=br1.id_branch 
                                    JOIN branch br2 ON o.fk_id_branch_recipient=br2.id_branch
                                     WHERE  o.`status_order`=1 and o.`fk_id_branch_sender` = ? OR o.fk_id_branch_recipient=?   
                                    ORDER BY `o`.`date_of_receipt_sender` DESC ";
                                $stmt_bra = mysqli_prepare($con, $sql);
                                mysqli_stmt_bind_param($stmt_bra, "ii", $publi_fk_id_branch, $publi_fk_id_branch);
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


                                <td>
                                    <?php if ($array_messages['fk_level_mess'] <= 2) { ?>
                                    <a title="إلغاء" class="btn btn-danger btn-sm "
                                        href="kkiji?pplZZndhnAAqaswe=<?php echo encrypt_id($array_messages['id_order']); ?> role="
                                        button">
                                        <i class="fas fa-times"></i></a>
                                    <?php }
                                            if ($array_messages['fk_level_mess'] >= 3) {

                                            ?>
                                    <a title="استرجاع" class="btn btn-info btn-sm "
                                        href="kkiji?oQQsflnfaed=<?php echo encrypt_id($array_messages['id_order']); ?> role="
                                        button">
                                        <i class="fas fa-sync"></i></a>
                                    <?php  } ?>
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


        <!-- table compet order -->
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h4> الرسائل المكتملة</h4>
            </div>

            <div class="card-body">
                <div class="col-sm-12 table-responsive p-0">
                    <table id="check_order_compang" class="table table-bordered table-striped">
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
                                $result = mysqli_query($con, "SELECT o.`fk_level_mess`,o.QR,
                                `id_order`,c1.cus_name as 'sender_nsame',c1.cus_phone as 'sender_phone',c2.cus_name as 'receive_name',c2.cus_phone as 'recip_phone'
                                ,`date_of_receipt_sender`,`status_order`,br1.name_branch as 'branch_sender',br2.name_branch as 'branch_recipe'  
                                FROM `order` o 
                                JOIN customer c1 ON o.custom_id_sender=c1.id_customer 
                                JOIN customer c2 ON o.custom_id_recipient=c2.id_customer 
                                JOIN branch br1 ON o.fk_id_branch_sender=br1.id_branch 
                                JOIN branch br2 ON o.fk_id_branch_recipient=br2.id_branch 
                                WHERE o.`fk_level_mess`=6 AND o.`status_order`=1;");

                                if (mysqli_num_rows($result) == 0) {
                                    echo "<td colspan='11'><h6 class='text-center'>لا يوجد </h6></td>";
                                } else {
                                    while ($r = mysqli_fetch_array($result)) {

                                ?>


                            <tr>
                                <td class="sorting_1"><?php echo htmlspecialchars($count_row += 1);  ?></td>
                                <td class="sorting_1"><?php echo htmlspecialchars($r['QR']); ?></td>
                                <td><?php echo htmlspecialchars($r['branch_sender']); ?></td>
                                <td><?php echo htmlspecialchars($r['branch_recipe']); ?></td>

                                <td><?php echo htmlspecialchars($r['sender_nsame']); ?></td>
                                <td><?php echo htmlspecialchars($r['sender_phone']); ?></td>
                                <td><?php echo htmlspecialchars($r['date_of_receipt_sender']); ?></td>

                                <td><?php echo htmlspecialchars($r['receive_name']); ?></td>
                                <td><?php echo htmlspecialchars($r['recip_phone']); ?></td>
                                <td><?php echo htmlspecialchars($r['date_of_receipt_recipient']); ?></td>
                                <td>

                                    <i class="icon fas fa-check"></i>


                                </td>

                            </tr>



                            <?php


                                    }
                                }
                                ?>

                        </tbody>

                    </table>
                </div>
            </div>


        </div>



        <!-- table cancel order -->
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h4> الرسائل الملغية</h4>
            </div>

            <div class="card-body">
                <div class="col-sm-12 table-responsive p-0">
                    <table id="check_order_cancel" class="table table-bordered table-striped">
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
                                $result = mysqli_query($con, "SELECT o.QR,`id_order`,c1.cus_name as 'sender_nsame'
                                ,c1.cus_phone as 'sender_phone',c2.cus_name as 'receive_name',c2.cus_phone as 'recip_phone',`date_of_receipt_sender`,
                                `status_order`,br1.name_branch as 'branch_sender',br2.name_branch as 'branch_recipe'  
                                FROM `order` o 
                                JOIN customer c1 ON o.custom_id_sender=c1.id_customer 
                                JOIN customer c2 ON o.custom_id_recipient=c2.id_customer 
                                JOIN branch br1 ON o.fk_id_branch_sender=br1.id_branch 
                                JOIN branch br2 ON o.fk_id_branch_recipient=br2.id_branch 
                                WHERE o.status_order=3;") or die(mysqli_error($con));
                                if (mysqli_num_rows($result) == 0) {
                                    echo "<td colspan='10'><h6 class='text-center'>لا يوجد </h6></td>";
                                } else {
                                    while ($r = mysqli_fetch_array($result)) {

                                ?>


                            <tr>
                                <td class="sorting_1"><?php echo htmlspecialchars($count_row += 1);  ?></td>
                                <td class="sorting_1"><?php echo htmlspecialchars($r['QR']); ?></td>

                                <td><?php echo htmlspecialchars($r['branch_sender']); ?></td>
                                <td><?php echo htmlspecialchars($r['branch_recipe']); ?></td>

                                <td><?php echo htmlspecialchars($r['sender_nsame']); ?></td>
                                <td><?php echo htmlspecialchars($r['sender_phone']); ?></td>
                                <td><?php echo htmlspecialchars($r['date_of_receipt_sender']); ?></td>

                                <td><?php echo htmlspecialchars($r['receive_name']); ?></td>
                                <td><?php echo htmlspecialchars($r['recip_phone']); ?></td>


                                <td>

                                    <i class="icon fas fa-times"></i>


                                </td>

                            </tr>



                            <?php


                                    }
                                }
                                ?>

                        </tbody>

                    </table>
                </div>
            </div>


        </div>


        <!-- table cancel order -->
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h4> الرسائل المسترجعة</h4>
            </div>

            <div class="card-body">
                <div class="col-sm-12 table-responsive p-0">
                    <table id="check_order_back" class="table table-bordered table-striped">
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
                                $result = mysqli_query($con, "SELECT o.QR,`id_order`,c1.cus_name as 'sender_nsame',c1.cus_phone as 'sender_phone',c2.cus_name as 'receive_name',c2.cus_phone as 'recip_phone',
                                `date_of_receipt_sender`,`status_order`,br1.name_branch as 'branch_sender',br2.name_branch as 'branch_recipe'  
                                FROM `order` o 
                                JOIN customer c1 ON o.custom_id_sender=c1.id_customer 
                                JOIN customer c2 ON o.custom_id_recipient=c2.id_customer 
                                JOIN branch br1 ON o.fk_id_branch_sender=br1.id_branch 
                                JOIN branch br2 ON o.fk_id_branch_recipient=br2.id_branch 
                                WHERE o.status_order=2;") or die(mysqli_error($con));
                                if (mysqli_num_rows($result) == 0) {
                                    echo "<td colspan='10'><h6 class='text-center'>لا يوجد </h6></td>";
                                } else {
                                    while ($r = mysqli_fetch_array($result)) {

                                ?>


                            <tr>
                                <td class="sorting_1"><?php echo htmlspecialchars($count_row += 1);  ?></td>
                                <td class="sorting_1"><?php echo htmlspecialchars($r['QR']); ?></td>

                                <td><?php echo htmlspecialchars($r['branch_sender']); ?></td>
                                <td><?php echo htmlspecialchars($r['branch_recipe']); ?></td>

                                <td><?php echo htmlspecialchars($r['sender_nsame']); ?></td>
                                <td><?php echo htmlspecialchars($r['sender_phone']); ?></td>
                                <td><?php echo htmlspecialchars($r['date_of_receipt_sender']); ?></td>

                                <td><?php echo htmlspecialchars($r['receive_name']); ?></td>
                                <td><?php echo htmlspecialchars($r['recip_phone']); ?></td>


                                <td>

                                    <i class="icon fas fa-times"></i>


                                </td>

                            </tr>



                            <?php


                                    }
                                }
                                ?>

                        </tbody>

                    </table>
                </div>
            </div>


        </div>







    </div>
</section>



<?php

    include "footer.php";
} else {
    include "Error404.php";
}
?>