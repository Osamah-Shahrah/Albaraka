<?php

include 'check.php';

$page_id = 8;

if (chec_use_permission($page_id)) {

    static $edit_id_order = 0;
    $edit_stat = 0;
    static $edit_fk_id_branch_recipient = 0;
    static $edit_verify_message = 0;


    if (isset($_GET['QQAcmdnhjk'])) {


        $edit_id_order = decrypt_id($_GET['QQAcmdnhjk']);
        static $edit_sender_name;
        static $edit_sender_phone;
        static $edit_sender_imag_card;
        static $edit_cus_sen_id_card;
        static $edit_sen_note;

        static $edit_rec_note;
        static $edit_cus_send_whatsapp;
        static $edit_recipient_name;
        static $edit_cus_rec_address;
        static $edit_recipient_phone;
        static $edit_receive_image_sender;

        static $edit_money_received;
        static $edit_verify_message;
        static $edit_fk_id_branch_recipient;
        static $edit_gov;
        static $edit_order_note;
        //data order
        $edit_sql_quer_order = "SELECT  receive_image_sender,`gov`,money_received,o.verify_message,o.fk_id_branch_recipient,o.order_note,`custom_id_sender`,`custom_id_recipient`
                FROM `order` o
                WHERE  o.id_order= ?";
        $edit_stmt_order = mysqli_prepare($con, $edit_sql_quer_order);
        mysqli_stmt_bind_param($edit_stmt_order, "i",$edit_id_order);
        mysqli_stmt_execute($edit_stmt_order);

        $edit_result_order = mysqli_stmt_get_result($edit_stmt_order);
        if (mysqli_num_rows($edit_result_order) > 0) {
            $edit_array_order = mysqli_fetch_assoc($edit_result_order);


            $edit_money_received = $edit_array_order['money_received'];
            $edit_verify_message = $edit_array_order['verify_message'];
            $edit_fk_id_branch_recipient = $edit_array_order['fk_id_branch_recipient'];
            $edit_gov = $edit_array_order['gov'];
            $edit_order_note = $edit_array_order['order_note'];
            $edit_receive_image_sender = $edit_array_order['receive_image_sender'];
        }

        //data sender
        $edit_sql_quer_sender = "SELECT  c1.cus_name AS 'sender_name', c1.cus_phone AS 'sender_phone',c1.cus_card_img As 'sender_imag_card',c1.cus_id_card As 'cus_sen_id_card',c1.cus_note AS 'sen_note'
        ,c1.cus_whatsapp AS 'cus_send_whatsapp'
        
                FROM `order` o
                JOIN customer c1 ON o.custom_id_sender = c1.id_customer
                
                WHERE  o.id_order= ?";
        $edit_stmt_sender = mysqli_prepare($con, $edit_sql_quer_sender);
        mysqli_stmt_bind_param($edit_stmt_sender, "i", $edit_id_order);
        mysqli_stmt_execute($edit_stmt_sender);

        $edit_result_sender = mysqli_stmt_get_result($edit_stmt_sender);
        if (mysqli_num_rows($edit_result_sender) > 0) {
            $edit_array_sender = mysqli_fetch_assoc($edit_result_sender);


            $edit_sender_name = $edit_array_sender['sender_name'];
            $edit_sender_phone = $edit_array_sender['sender_phone'];
            $edit_sender_imag_card = $edit_array_sender['sender_imag_card'];
            $edit_cus_sen_id_c = $edit_array_sender['cus_sen_id_card'];
            $edit_sen_note = $edit_array_sender['sen_note'];


        }






        //data recev
        $edit_sql_quer_recev = "SELECT  c2.cus_note AS 'rec_note',c2.cus_name AS 'recipient_name',c2.cus_address As 'cus_rec_address', c2.cus_phone AS 'recipient_phone'
                FROM `order` o
                JOIN customer c2 ON o.custom_id_recipient = c2.id_customer
                WHERE  o.id_order= ?";
        $edit_stmt_recev = mysqli_prepare($con, $edit_sql_quer_recev);
        mysqli_stmt_bind_param($edit_stmt_recev, "i", $edit_id_order);
        mysqli_stmt_execute($edit_stmt_recev);

       $edit_result_recev = mysqli_stmt_get_result($edit_stmt_recev);
        if (mysqli_num_rows($edit_result_recev) > 0) {
            
            $edit_array_recev = mysqli_fetch_assoc($edit_result_recev);

            $edit_rec_note = $edit_array_recev['rec_note'];
            $edit_recipient_name = $edit_array_recev['recipient_name'];
            $edit_cus_rec_address = $edit_array_recev['cus_rec_address'];
            $edit_recipient_phone = $edit_array_recev['recipient_phone'];



        }
    }
    else {
        include "Error404.php";
    }
?>

    <?php
    content_header('تعديل بيانات الرسالة');
    ?>


    <section class="content" dir="rtl" align="right">
        <div class="container-fluid">
        
            <div class="row">

                <div class="card card-warning card-outline col-md-6">
                    <div class="card-header">
                        <h4>بيانات الرسالة</h4>
                    </div>
                    <div class="card-body">
                        <form id="edit_messageForm" method="post">
                            <?php get_select("نوع الرسالة", "edit_name_mess_type", "0", "0", "id_mess", "mess_type"); ?>

                            <?php get_select("الحجم", "edit_weight_item", "0", "0", "id_size_items", "size_items"); ?>

                            <div class="form-group">
                                <label for="edit_item_details">محتوى الرسالة</label>
                                <div class="input-group">
                                <input type="hidden" class="form-control" name="operation_name" id="operation_name"
                                value="1">
                                    <input type="text" class="form-control" name="edit_item_details" id="edit_item_details">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="edit_cost_message">التكلفة</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="edit_cost_message"
                                        id="edit_cost_message" step="0.01">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                </div>
                                <p>تنبيه <code>المبلغ يتم إدخاله بالعمله السعودي فقط.</code></p>
                            </div>

                            <button type="button" class="btn btn-primary" id="edit_qw" name="edit_qw">إضافة العنصر</button>

                    </div>
                </div>



                <div class="card card-warning card-outline col-md-6">
                    <div class="card-header">
                        <h4>جدول أجزاء الرسالة</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="edit_item_table_order" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>النوع</th>
                                    <th>الحجم</th>
                                    <th>التكلفة</th>
                                    <th>محتوى الرسالة</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($edit_id_order) {


                                    $edit_count_row = 0;
                                    $edit_price = 0;
                                    $edit_wight = 0;

                                    static $edit_id_item_order;
                                    static $edit_name_mess;
                                    static $edit_weight_item;
                                    static $edit_cost_message;
                                    static $edit_item_details;






                                    $edit_sql_quer = "SELECT * FROM `order_item` ord JOIN mess_type mety ON ord.item_type=mety.id_mess WHERE `fk_order`= ?";
                                    $edit_stmt = mysqli_prepare($con, $edit_sql_quer);
                                    mysqli_stmt_bind_param($edit_stmt, "s", $edit_id_order);
                                    mysqli_stmt_execute($edit_stmt);

                                    $edit_result2 = mysqli_stmt_get_result($edit_stmt);
                                    
                                    if (mysqli_num_rows($edit_result2) > 0) {
                                        while ($edit_array_item = mysqli_fetch_assoc($edit_result2)) {
                                            $edit_id_item_order = $edit_array_item['id_item_order'];
                                            $edit_name_mess = $edit_array_item['name_mess'];
                                            $edit_weight_item = $edit_array_item['weight_item'];
                                            $edit_cost_message = $edit_array_item['cost_message'];
                                            $edit_item_details = $edit_array_item['item_details'];

                                            $edit_price += $edit_array_item['cost_message'];
                                            $edit_wight += $edit_array_item['weight_item'];


                                ?>

                                            <tr>
                                                <td><?php echo htmlspecialchars($edit_count_row += 1); ?></td>
                                                <td><?php echo htmlspecialchars($edit_name_mess); ?></td>
                                                <td><?php echo htmlspecialchars($edit_weight_item); ?></td>
                                                <td><?php echo htmlspecialchars($edit_cost_message); ?></td>
                                                <td><?php echo htmlspecialchars($edit_item_details); ?></td>

                                                <td class="align-middle text-center text-sm"> <a
                                                        class="badge badge-sm bg-gradient-danger"
                                                        href='IIihjndiuh?ppernrmfnb=<?php echo encrypt_id($edit_id_item_order); ?>'>إزالة</a>
                                                </td>


                                            </tr>


                                <?php }
                                    }
                                }  ?>
                            </tbody>

                        </table>
                    </div>
                    <?php
                    if ($edit_id_order) {
                    ?>
                        <div class="card-footer">
                            <span class="right badge badge-info"><b class="h6"> العدد:<?php if ($edit_id_order) {
                                                                                            echo htmlspecialchars($edit_count_row);
                                                                                        } ?>

                                </b></span> 
                            <span class="right badge badge-danger">
                                <b class="h6">إجمالي السعر:<?php if ($edit_id_order) {
                                                                echo htmlspecialchars($edit_price);
                                                            } ?>

                                </b></span>
                            <a class="btn btn-block-sm  btn-danger" href='IIihjndiuh?UjsnBBneu=<?php if ($edit_id_order) {
                                                                                                            echo encrypt_id($edit_id_order);
                                                                                                        } ?>'
                                >إزالة
                                الكل
                            </a>
                        </div>
                    <?php } ?>
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


                            <input type="hidden" name="edit_id_order" id="edit_id_order" value="<?php if ($edit_id_order) {
                                                                                                    echo osamah_encrypt($edit_id_order);
                                                                                                } ?>">

                            <input type="text" class="form-control" name="sender_name" id="sender_name" disabled
                                placeholder="اسامه__ " required value="<?php if ($edit_id_order) {
                                                                            echo htmlspecialchars($edit_sender_name);
                                                                        } ?>">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-text">@</i></span>
                            </div>

                        </div>
                    </div>



                    <div class="form-group">
                        <label for="sender_phone">رقم الهاتف</label>
                        <div class="input-group">

                            <input type="number" class="form-control" name="sender_phone" id="sender_phone" disabled
                                placeholder="(_,_,_)___" required value="<?php if ($edit_id_order) {
                                                                                echo htmlspecialchars($edit_sender_phone);
                                                                            } ?>">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cus_sen_id_card">رقم البطاقة</label>
                        <div class="input-group">

                            <input type="number" class="form-control" name="cus_sen_id_card" id="cus_sen_id_card" disabled
                                value="<?php if ($edit_id_order) {
                                            echo htmlspecialchars($edit_cus_sen_id_card);
                                        } ?>">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="imgpro">صورة البطاقة</label>
                        <div class="input-group">
                            <input type="file" name="sender_imag_card" id="sender_imag_card" disabled
                                accept=".png, .jpg,.gif,.jpeg,jpe,.ico">
                            <?php if ($edit_id_order > 0) { ?>
                                <img id="edit_imag_sender_imag_card" class='img-fluid rounded' src="<?php if ($edit_id_order > 0) {
                                                                                                        echo "../img/id_card/$edit_sender_imag_card";
                                                                                                    } ?>" width="100"
                                    height="100">
                            <?php } ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cus_send_whatsapp">رقم الواتس اب</label>
                        <div class="input-group">

                            <input type="text" class="form-control" name="cus_send_whatsapp" disabled
                                id="cus_send_whatsapp"
                                <?php if ($edit_id_order) {
                                    echo htmlspecialchars($edit_cus_send_whatsapp);
                                } ?>>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-text">*</i></span>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cus_note">ملاحظات</label>
                        <input type="text" name="sen_note" id="sen_note" class="form-control" disabled  value="<?php if ($edit_id_order) {
                                                                                                                                    echo htmlspecialchars($edit_sen_note);
                                                                                                                                } ?>">
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

                                <input type="text" class="form-control" name="recipient_name" id="recipient_name"
                                    required placeholder="اسامه__ " value="<?php if ($edit_id_order) {
                                                                                echo htmlspecialchars($edit_recipient_name);
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
                                    id="recipient_phone" placeholder="(_,_,_)___" required value="<?php if ($edit_id_order) {
                                                                                                            echo htmlspecialchars($edit_recipient_phone);
                                                                                                        } ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cus_rec_address">العنوان</label>
                            <input type="text" name="cus_rec_address" id="cus_rec_address" class="form-control"
                                value="<?php if ($edit_id_order) {
                                            echo htmlspecialchars($edit_cus_rec_address);
                                        } ?>">
                        </div>
                        <div class="form-group">
                            <label for="rec_note">ملاحظات</label>
                            <input type="text" name="rec_note" id="rec_note" class="form-control"
                                value="<?php if ($edit_id_order) {
                                            echo htmlspecialchars($edit_rec_note);
                                        } ?>">
                        </div>





                    </div>





                </div>
                <!--delivery  -->
                <div class="card card-warning card-outline col-md-6">

                    <div class="card-header">
                        <h4>بيانات التوصيل</h4>
                    </div>

                    
                        <div class="card-body">


                            <div class="form-group">
                                <label for="gov">المحافظة</label>
                                <input type="text" name="gov" id="gov" class="form-control" value="<?php if ($edit_id_order) {
                                                                                                                    echo htmlspecialchars($edit_gov);
                                                                                                                } ?>">
                            </div>


                            <?php get_select_2("الفرع", "id_branch_rec", $edit_id_order, $edit_fk_id_branch_recipient, "id_branch", "branch", $publi_fk_id_branch); ?>




                            <div class="form-group">
                                <label for="verify_message">التأكد من محتويات الرسالة</label>
                                <?php if ($edit_verify_message) {
                                    $edit_stat = 'checked';
                                } ?>
                                <input type="checkbox" name="verify_message" id="verify_message"
                                    class="form-control" required <?php if ($edit_id_order) {
                                                                        echo htmlspecialchars($edit_stat);
                                                                    } ?>>
                            </div>



                            <div class="form-group">
                                <label for="money_received">المبلغ المستلم</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" name="money_received"
                                        id="money_received" required  step="0.01" value="<?php if ($edit_id_order) {
                                                                                        echo htmlspecialchars($edit_money_received);
                                                                                    } ?>">
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
                                        accept=".png, .jpg,.gif,.jpeg,jpe,.ico" >
                                    <?php if ($edit_id_order > 0) { ?>
                                        <img id="edit_imag_receive_image_sender" class='img-fluid rounded' src="<?php if ($edit_id_order > 0) {
                                                                                                                    echo "../img/order/$edit_receive_image_sender";
                                                                                                                } ?>"
                                            width="100" height="100">
                                    <?php } ?>

                                </div>
                            </div>


                            <div class="form-floating">
                                <textarea name="order_note" id="order_note" class="form-control" 
                                    placeholder="الملاحظات"><?php if ($edit_id_order) {
                                                                echo htmlspecialchars($edit_order_note);
                                                            } ?></textarea>
                                <label for="order_note">يرجاء كتابة اي ملاحضات هنا</label>
                            </div>

                        </div>





                </div>

            </div>






            <div class="card-footer">

                <button type="submit" id="edit_btn_save_or_updata_order" name="edit_btn_save_or_updata_order" 
                    class="btn btn-block btn-<?php if ($edit_id_order) {
                                                    echo htmlspecialchars("danger");
                                                } else {
                                                    echo htmlspecialchars("success");
                                                } ?> btn-lg"><?php if ($edit_id_order) {
                                                                    echo htmlspecialchars("تعديل");
                                                                } else {
                                                                    echo htmlspecialchars("إضافة");
                                                                } ?> </button>

            </div>

            </form>
        </div>
    </section>



<?php
    include "footer.php";
} else {
    include "Error404.php";
}
?>





