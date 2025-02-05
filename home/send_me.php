<?php

include 'check.php';

$page_id = 8;

if (chec_use_permission($page_id)) {

    content_header('إضافة رسالة');
?>


    <section class="content" dir="rtl" align="right">
        <div class="container-fluid">

            <div class="row">

                <div class="card card-warning card-outline col-md-6">
                    <div class="card-header">
                        <h4>بيانات الرسالة</h4>
                    </div>
                    <div class="card-body">
                        <form id="messageForm" method="post">
                            <?php get_select("نوع الرسالة", "name_mess_type", "0", "0", "id_mess", "mess_type"); ?>

                            <?php get_select("الحجم", "weight_item", "0", "0", "id_size_items", "size_items"); ?>


                            <div class="form-group">
                                <label for="item_details">المحتوى</label>
                                <div class="input-group">
                                    <input type="hidden" class="form-control" name="operation_name" id="operation_name"
                                        value="1">
                                    <input type="text" class="form-control" name="item_details" id="item_details">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="cost_message">التكلفة</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="cost_message" id="cost_message"
                                        step="0.01">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                </div>
                                <p>تنبيه <code>المبلغ يتم إدخاله بالعمله السعودي فقط.</code></p>
                            </div>

                            <button type="button" class="btn btn-primary" id="qw" name="qw">إضافة العنصر</button>

                    </div>
                </div>



                <div class="card card-warning card-outline col-md-6">
                    <div class="card-header">
                        <h4>جدول أجزاء الرسالة</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="item_table_order" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>النوع</th>
                                    <th>الحجم</th>
                                    <th>التكلفة</th>
                                    <th>اجزاء الرسالة</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>

                </div>


            </div>


            <div class="card card-warning card-outline">

                <div class="card-header">
                    <h4>بيانات المرسل</h4>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <label for="sender_name">اسم المرسل</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sender_name" id="sender_name"
                                placeholder="اسامه__ " required>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-text">@</i></span>
                            </div>

                        </div>
                    </div>



                    <div class="form-group">
                        <label for="sender_phone">رقم الهاتف</label>
                        <div class="input-group">

                            <input type="number" class="form-control" name="sender_phone" id="sender_phone"
                                placeholder="(_,_,_)___" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cus_sen_id_card">رقم البطاقة</label>
                        <div class="input-group">

                            <input type="number" class="form-control" name="cus_sen_id_card" id="cus_sen_id_card">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="imgpro">صورة البطاقة</label>
                        <div class="input-group">
                            <input type="file" name="sender_imag_card" id="sender_imag_card"
                                accept=".png, .jpg,.gif,.jpeg,jpe,.ico">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cus_send_whatsapp">رقم الواتس اب</label>
                        <div class="input-group">

                            <input type="text" class="form-control" name="cus_send_whatsapp" id="cus_send_whatsapp">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-text">*</i></span>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cus_note">ملاحظات</label>
                        <input type="text" name="sen_note" id="sen_note" class="form-control">
                    </div>


                </div>

            </div>

            <div class="row">
                <!--destination  -->
                <div class="card card-warning card-outline col-md-6">

                    <div class="card-header">
                        <h4>بيانات المستلم</h4>
                    </div>


                    <div class="card-body">
                        <div class="form-group">
                            <label for="recipient_name">اسم المستلم</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="recipient_name" id="recipient_name" required
                                    placeholder="اسامه__ ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-text">@</i></span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="recipient_phone">رقم الهاتف</label>
                            <div class="input-group">

                                <input type="number" class="form-control" name="recipient_phone" id="recipient_phone"
                                    placeholder="(_,_,_)___" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cus_rec_address">العنوان</label>
                            <input type="text" name="cus_rec_address" id="cus_rec_address" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="rec_note">ملاحظات</label>
                            <input type="text" name="rec_note" id="rec_note" class="form-control">
                        </div>
                    </div>





                </div>
                <!--delivery  -->
                <div class="card card-warning card-outline col-md-6">

                    <div class="card-header">
                        <h4>بيانات التوصيل</h4>
                    </div>

                    <form action="IIihjndiuh" method="POST" type="form" enctype="multipart/form-data">
                        <div class="card-body">


                            <div class="form-group">
                                <label for="gov">المحافظة</label>
                                <input type="text" name="gov" id="gov" class="form-control">
                            </div>


                            <?php get_select_2("الفرع", "id_branch_rec", 0, 0, "id_branch", "branch"); ?>




                            <div class="form-group">
                                <label for="verify_message">التأكد من محتويات الرسالة</label>

                                <input type="checkbox" name="verify_message" id="verify_message" class="form-control"
                                    required>
                            </div>



                            <div class="form-group">
                                <label for="money_received">المبلغ المستلم</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" name="money_received" id="money_received"
                                        step="0.01" required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-money">💰</i></span>
                                    </div>

                                </div>
                                <p>تنبيه <code>المبلغ يتم إدخاله بالعمله السعودي فقط.</code></p>
                            </div>



                            <div class="form-group">
                                <label for="receive_image_sender">صورة الرسالة</label>
                                <div class="input-group">
                                    <input type="file" name="receive_image_sender" id="receive_image_sender"
                                        accept=".png, .jpg,.gif,.jpeg,jpe,.ico" required>


                                </div>
                            </div>


                            <div class="form-floating">
                                <textarea name="order_note" id="order_note" class="form-control"
                                    placeholder="الملاحظات"></textarea>
                                <label for="order_note">يرجاء كتابة اي ملاحضات هنا</label>
                            </div>

                        </div>





                </div>

            </div>

            <div class="card-footer">

                <button type="submit" id="btn_save_or_updata_order" name="btn_save_or_updata_order"
                    class="btn btn-block btn-success btn-lg">إضافة </button>

            </div>

            </form>

            <div class="card card-default" align="right">

                <div class="card-header">
                    <h5>الرسائل الغيرمكتملة</h5>
                </div>

                <!-- /.card-header -->

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="show_all_order_not_complait" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الرسالة</th>
                                    <th>اسم المرسل</th>
                                    <th>رقم المرسل</th>
                                    <th>تاريخ الارسال</th>
                                    <th>#</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count_row = 0;
                                $sql = "SELECT o.`id_order`,o.QR, o.`date_of_receipt_sender`, c1.cus_name AS 'sender_name', c1.cus_phone AS 'sender_phone'
                                FROM `order` o  
                                JOIN customer c1 ON o.custom_id_sender = c1.id_customer
                                WHERE o.`user_id_receipt_sender`= ? AND (`verify_message`=0 OR `custom_id_recipient`=0 OR `check_receipt_sender`=0 OR 	fk_id_branch_recipient=0)";

                                $stmt = mysqli_prepare($con, $sql);
                                if (!$stmt) {
                                    die('Prepare failed: ' . mysqli_error($con));
                                }


                                mysqli_stmt_bind_param($stmt, 'i', $id_user_head);

                                if (mysqli_stmt_execute($stmt)) {
                                    $result = mysqli_stmt_get_result($stmt);
                                    while ($row = mysqli_fetch_assoc($result)) {



                                ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                            <td class="sorting_1"><?php echo htmlspecialchars($row['QR']); ?></td>

                                            <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['sender_phone']); ?></td>
                                            <td><?php echo htmlspecialchars($row['date_of_receipt_sender']); ?></td>

                                            <td> <a title="😉" class="btn btn-info btn-sm"
                                                    href="vbnjuhjk?QQAcmdnhjk=<?php echo encrypt_id($row['id_order']); ?>"
                                                    role="button">
                                                    تعديل
                                                </a>
                                            </td>
                                        </tr>
                                <?php

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


            <div class="card card-default" align="right">

                <div class="card-header">
                    <h5>الرسائل المكتملة</h5>
                </div>

                <!-- /.card-header -->

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="show_all_order_complait_send" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الرسالة</th>
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
                                $sql = "SELECT o.`fk_level_mess`, o.`id_order`, c1.cus_name AS 'sender_name', c1.cus_phone AS 'sender_phone', c2.cus_name AS 'recipient_name',
                                 c2.cus_phone AS 'recipient_phone', o.`date_of_receipt_sender`, o.`date_of_receipt_recipient`,
                                 o.`status_order`, br1.name_branch AS 'branch_sender', br2.name_branch AS 'branch_recipient',o.QR
                FROM `order` o
                JOIN customer c1 ON o.custom_id_sender = c1.id_customer
                JOIN customer c2 ON o.custom_id_recipient = c2.id_customer
                JOIN branch br1 ON o.fk_id_branch_sender = br1.id_branch
                JOIN branch br2 ON o.fk_id_branch_recipient = br2.id_branch
                WHERE o.`user_id_receipt_sender`=? AND o.`fk_id_branch_sender` = ? AND o.`date_of_receipt_sender`=? 
                AND `check_receipt_sender`=1";

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
                                                <td><?php echo htmlspecialchars($row['branch_recipient']); ?></td>
                                                <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['sender_phone']); ?></td>
                                                <td><?php echo htmlspecialchars($row['date_of_receipt_sender']); ?></td>
                                                <td><?php echo htmlspecialchars($row['recipient_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['recipient_phone']); ?></td>
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