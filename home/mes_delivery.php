<?php

include 'check.php';


$page_id = 17;
if (chec_use_permission($page_id)) {
    static $id_ord = 0;




    if (isset($_GET['mfnounYGWTFVWB'])) {


        $id_ord = decrypt_id($_GET['mfnounYGWTFVWB']);

        static $img_ord_send;
        static $custom_id_recipient;
        static $money_received;
        static $count_item;
        static $the_cost;
        static $remaining;
        static $order_note;
        static $order_not_recipient;

        static $cus_name;
        static $cus_phone;
        static $cus_card_img;
        static $cus_id_card;
        static $cus_whatsapp;
        static $cus_address;
        static $cus_note;

        $result = "SELECT DISTINCT `id_order`,`custom_id_recipient`,`money_received`,`receive_image_sender`,COUNT(DISTINCT oi.id_item_order)AS 'count_item' 
        , SUM(DISTINCT oi.cost_message) AS 'the_cost' ,SUM(DISTINCT oi.cost_message)-`money_received` as 'remaining',order_note,`order_not_recipient`
        FROM `order` o JOIN order_item oi ON o.id_order=oi.fk_order 
        WHERE `fk_id_branch_recipient`=? AND `id_order`=? ;";


        $stmt_mess_sho = mysqli_prepare($con, $result);
        mysqli_stmt_bind_param($stmt_mess_sho, "ii", $publi_fk_id_branch, $id_ord);
        mysqli_stmt_execute($stmt_mess_sho);

        $result_mess_data = mysqli_stmt_get_result($stmt_mess_sho);
        while ($array_mess = mysqli_fetch_assoc($result_mess_data)) {

            $img_ord_send = $array_mess['receive_image_sender'];
            $custom_id_recipient = $array_mess['custom_id_recipient'];
            $money_received = $array_mess['money_received'];
            $count_item = $array_mess['count_item'];
            $the_cost = $array_mess['the_cost'];
            $remaining = $array_mess['remaining'];
            $order_note = $array_mess['order_note'];
            $order_not_recipient = $array_mess['order_not_recipient'];
            $cust_sel = "SELECT * FROM `customer` WHERE id_customer= ? ;";


            $stmt_cust_sho = mysqli_prepare($con, $cust_sel);
            mysqli_stmt_bind_param($stmt_cust_sho, "i", $custom_id_recipient);
            mysqli_stmt_execute($stmt_cust_sho);

            $result_cust_data = mysqli_stmt_get_result($stmt_cust_sho);
            while ($array_cust = mysqli_fetch_assoc($result_cust_data)) {

                $cus_name = $array_cust['cus_name'];
                $cus_phone = $array_cust['cus_phone'];
                $cus_card_img = $array_cust['cus_card_img'];
                $cus_id_card = $array_cust['cus_id_card'];
                $cus_whatsapp = $array_cust['cus_whatsapp'];
                $cus_address = $array_cust['cus_address'];
                $cus_note = $array_cust['cus_note'];
            }
        }
    }


?>


<?php
    content_header('تسليم الرسائل')
    ?>




<section class="content" dir="rtl" align="right">
    <div class="container-fluid">
        <!--destination  -->

        <!--table statue order  -->
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h4>جدول الرسائل</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="all_check_order" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>QR</th>
                                <th>من</th>
                                <th>المرسل</th>
                                <th>رقم المرسل</th>
                                <th>المستلم</th>
                                <th>رقم المستلم</th>
                                <th>حالة الرسالة</th>
                                <th>#</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count_row = 0;
                                $result = "SELECT o.id_order,o.QR,o.custom_id_recipient,o.id_order,c1.cus_name as 'sender_nsame',c1.cus_phone as 'sender_phone',c2.cus_name as 'receive_name',c2.cus_phone as 'recip_phone'
                            ,`date_of_receipt_sender`,`status_order`,br1.name_branch as 'branch_sender' ,o.`fk_level_mess`
                            FROM `order` o 
                            JOIN customer c1 ON o.custom_id_sender=c1.id_customer 
                            JOIN customer c2 ON o.custom_id_recipient=c2.id_customer 
                            JOIN branch br1 ON o.fk_id_branch_sender=br1.id_branch 
                            WHERE o.check_receipt_sender=1  AND o.check_receipt_recipient=0 AND o.fk_id_branch_recipient =?  
                            ORDER BY `o`.`fk_level_mess` DESC ;";


                                $stmt_mess_sho = mysqli_prepare($con, $result);
                                mysqli_stmt_bind_param($stmt_mess_sho, "i", $publi_fk_id_branch);
                                mysqli_stmt_execute($stmt_mess_sho);

                                $result_mess_data = mysqli_stmt_get_result($stmt_mess_sho);
                                while ($array_mess = mysqli_fetch_assoc($result_mess_data)) {

                                ?>


                            <tr>
                                <td class="sorting_1"><?php echo htmlspecialchars($count_row += 1);  ?></td>
                                <td class="sorting_1"><?php echo htmlspecialchars($array_mess['QR']); ?></td>
                                <td><?php echo htmlspecialchars($array_mess['branch_sender']); ?></td>

                                <td><?php echo htmlspecialchars($array_mess['sender_nsame']); ?></td>
                                <td><?php echo htmlspecialchars($array_mess['sender_phone']); ?></td>
                                <td><?php echo htmlspecialchars($array_mess['receive_name']); ?></td>
                                <td><?php echo htmlspecialchars($array_mess['recip_phone']); ?></td>
                                <td>


                                    <?php
                                            if ($array_mess['status_order'] == 1) {
                                                $result = "SELECT * FROM `level_mess` WHERE `id_level_mess`=? ;";


                                                $stmt_mess_leval = mysqli_prepare($con, $result);
                                                mysqli_stmt_bind_param($stmt_mess_leval, "i", $array_mess['fk_level_mess']);
                                                mysqli_stmt_execute($stmt_mess_leval);

                                                $result_mess_level = mysqli_stmt_get_result($stmt_mess_leval);
                                                while ($array_level = mysqli_fetch_assoc($result_mess_level)) {

                                                    echo ($array_level['icon_status']);
                                                    echo ($array_level['small_class']);
                                                    echo ($array_level['name_level_mess']);
                                                    echo ($array_level['close_small']);
                                                    echo ($array_level['close_icon']);
                                                }
                                            } else if ($array_mess['status_order'] == 2) {
                                                echo "<small class='badge badge-danger'> مسترجعة </small>";
                                            } else if ($array_mess['status_order'] == 3) {
                                                echo "<small class='badge badge-danger'> ملغية </small>";
                                            }
                                            ?>
                                </td>


                                <td>
                                    <?php if ($array_mess['fk_level_mess'] == 5) { ?>
                                    <a title="استلام" class="btn btn-info btn-sm "
                                        href="nnjnmmnh?mfnounYGWTFVWB=<?php echo htmlspecialchars(encrypt_id($array_mess['id_order'])); ?> "
                                        role=" button">
                                        <i class="fas fa-eye"></i></a>
                                    <?php } ?>
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






        <?php if ($id_ord > 0) { ?>
        <div class="card card-warning card-outline">

            <div class="card-header">
                <h4>بيانات المستلم</h4>
            </div>
            <div align='center'>
                <img id="proimg" src="<?php if ($id_ord > 0) {
                                                    echo "../img/order/$img_ord_send";
                                                } ?>" width='100px' height='100px'>
            </div>
            <form action="IIihjndiuh" method="POST" type="form" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="recipient_name">اسم المستلم</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" name="recipient_name" id="recipient_name"
                                        required disabled placeholder="اسامه__ " value="<?php if ($id_ord > 0) {
                                                                                                    echo htmlspecialchars($cus_name);
                                                                                                } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-text">@</i></span>
                                    </div>

                                </div>
                            </div>



                            <div class="form-group">
                                <label for="recipient_phone">رقم الهاتف</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" name="recipient_phone"
                                        id="recipient_phone" disabled placeholder="(_,_,_)___" required value="<?php if ($id_ord > 0) {
                                                            echo htmlspecialchars($cus_phone);
                                                        } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="recipient_id_c">رقم البطاقة</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" name="recipient_id_c" id="recipient_id_c"
                                        required value="<?php if ($id_ord > 0) {
                                                            echo htmlspecialchars($cus_id_card);
                                                        } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="recipient_whatsapp">رقم الواتس اب</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" name="recipient_whatsapp"
                                        id="recipient_whatsapp" value="<?php if ($id_ord > 0) {
                                                            echo htmlspecialchars($cus_whatsapp);
                                                        } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-text">💬</i></span>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recipient_address">العنوان</label>
                                <input type="text" name="recipient_address" id="recipient_address" class="form-control"
                                    value="<?php if ($id_ord > 0) {
                                                        echo htmlspecialchars($cus_address);
                                                    } ?>">
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-3">
                                    <label for="count_item">عدد القطع</label>
                                    <div class="input-group">

                                        <input type="number" class="form-control" name="count_item" id="count_item"
                                            disabled value="<?php if ($id_ord > 0) {
                                                                echo htmlspecialchars($count_item);
                                                            } ?>">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label for="the_cost">إجمالي السعر</label>
                                    <div class="input-group">

                                        <input type="number" class="form-control" name="the_cost" id="the_cost" disabled
                                            value="<?php if ($id_ord > 0) {
                                                                echo htmlspecialchars($the_cost);
                                                            } ?>">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label for="money_received">المدفوع</label>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" name="hhuji" value="<?php if ($id_ord > 0) {
                                                                echo osamah_encrypt($id_ord);
                                                            } ?>">
                                        <input type="number" class="form-control" name="money_received"
                                            id="money_received" disabled value="<?php if ($id_ord > 0) {
                                                                echo htmlspecialchars($money_received);
                                                            } ?>">
                                    </div>

                                </div>




                                <div class="col-3">
                                    <label for="remaining">المتبقي</label>
                                    <div class="input-group">

                                        <input type="number" class="form-control" name="remaining" id="remaining"
                                            disabled value="<?php if ($id_ord > 0) {
                                                                echo htmlspecialchars($remaining);
                                                            } ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="paid">المبلغ المتبقي</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" name="paid" id="paid" required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>

                                </div>
                                <p>تنبيه <code>المبلغ يتم إدخاله بالعمله السعودي فقط.</code></p>
                            </div>
                            <div class="form-group">
                                <label for="1121ik7">قيمة الامانة</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" name="1121ik7" id="1121ik7" required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>

                                </div>
                                <p>تنبيه <code>المبلغ يتم إدخاله بالعمله السعودي فقط.</code></p>
                            </div>
                            <div class="form-group">
                                <label for="img_recipient_id_c">صورة البطاقة</label>
                                <div class="input-group">
                                    <input type="file" name="img_recipient_id_c" id="img_recipient_id_c"
                                        accept=".png, .jpg,.gif,.jpeg,jpe,.ico" required>


                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recipient_note">ملاحظات عن العميل</label>
                                <input type="text" name="recipient_note" id="recipient_note" class="form-control"
                                    tabindex="11" value="<?php if ($id_ord > 0) {
                                                                        echo htmlspecialchars($cus_note);
                                                                    } ?>">
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="recipient_note">ملاحظات الرساله من المرسل</label>
                        <input type="text" name="recipient_note" id="recipient_note" class="form-control" tabindex="11"
                            disabled value="<?php if ($id_ord > 0) {
                                                        echo htmlspecialchars($order_note);
                                                    } ?>">
                    </div>
                    <div class="form-group">
                        <label for="receive_image_recipient">صورة الرسالة</label>
                        <div class="input-group">
                            <input type="file" name="receive_image_recipient" accept=".png, .jpg,.gif,.jpeg,jpe,.ico">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order_not_recipient"> ملاحظات على الرساله</label>
                        <input type="text" name="order_not_recipient" id="order_not_recipient" class="form-control"
                            tabindex="12" value="<?php if ($id_ord > 0) {
                                                                echo htmlspecialchars($order_not_recipient);
                                                            } ?>">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" id="btn_save_order" name="btn_save_order" tabindex="18"
                        class="btn btn-block btn-danger  btn-lg">تسليم</button>

                </div>
            </form>
            <?php } ?>




        </div>




        <div class="card card-default" align="right">

            <div class="card-header">
                <h5>الرسائل المستلمة اليوم</h5>
            </div>

            <!-- /.card-header -->

            <div class="card-body">
                <div class="table-responsive">

                    <table id="show_all_order_complait_recev" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>QR</th>
                                <th>من</th>
                                <th>اسم المرسل</th>
                                <th>رقم المرسل</th>
                                <th>اسم المستلم</th>
                                <th>رقم المستلم</th>
                                <th>تاريخ التسليم</th>
                                <th>حالة الرسالة</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $count_row = 0;
                                    $sql = "SELECT o.`fk_level_mess`, o.`id_order`, c1.cus_name AS 'sender_name', c1.cus_phone AS 'sender_phone', c2.cus_name AS 'recipient_name',
                                    c2.cus_phone AS 'recipient_phone', o.`date_of_receipt_sender`, o.`date_of_receipt_recipient`,
                                    o.`status_order`, br1.name_branch AS 'branch_sender', br2.name_branch AS 'branch_recipient',o.QR
                                    FROM `order` o
                                    JOIN customer c1 ON o.custom_id_sender = c1.id_customer
                                    JOIN customer c2 ON o.custom_id_recipient = c2.id_customer
                                    JOIN branch br1 ON o.fk_id_branch_sender = br1.id_branch
                                    JOIN branch br2 ON o.fk_id_branch_recipient = br2.id_branch
                                    WHERE o.`user_id__receipt_recipient`=? AND o.`fk_id_branch_recipient` = ? AND o.`date_of_receipt_recipient`=? 
                                    AND `check_import`=1 AND check_receipt_recipient=1 AND fk_level_mess=6 AND `status_order`=1";

                                    $stmt = mysqli_prepare($con, $sql);
                                    if (!$stmt) {
                                        die('Prepare failed: ' . mysqli_error($con));
                                    }



                                    mysqli_stmt_bind_param($stmt, 'iis', $id_user_head, $publi_fk_id_branch, $dates);

                                    if (mysqli_stmt_execute($stmt)) {
                                        $result = mysqli_stmt_get_result($stmt);

                                        if (mysqli_num_rows($result) == 0) {
                                            echo "<td colspan='11'><h6 class='text-center'> لا يوجد بيانات</h6></td>";
                                        } else {
                                            while ($row = mysqli_fetch_assoc($result)) {

                                                $fk_level_mess = $row['fk_level_mess'];

                                    ?>

                            <tr>
                                <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                <td class="sorting_1"><?php echo htmlspecialchars($row['QR']); ?></td>
                                <td><?php echo htmlspecialchars($row['branch_sender']); ?></td>
                                <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['sender_phone']); ?></td>
                                <td><?php echo htmlspecialchars($row['recipient_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['recipient_phone']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_of_receipt_recipient']); ?></td>
                                <td>



                                    <?php
                                                        // Prepare the SQL statement to prevent SQL injection
                                                        $stmt = mysqli_prepare($con, "SELECT * FROM `level_mess` WHERE `id_level_mess`=?");
                                                        mysqli_stmt_bind_param($stmt, 'i', $fk_level_mess);
                                                        mysqli_stmt_execute($stmt);
                                                        $result_t = mysqli_stmt_get_result($stmt);

                                                        if (mysqli_num_rows($result_t) > 0) {
                                                            $r_u = mysqli_fetch_assoc($result_t);
                                                            $name_level_mess = $r_u['name_level_mess'];
                                                            $small_class = $r_u['small_class'];
                                                            $icon_status = $r_u['icon_status'];

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









    </div>
</section>

<?php

    include "footer.php";
} else {
    include "Error404.php";
}
?>