<?php
include "../db.php";
include "check.php";





$page_id = 15;
if (chec_use_permission($page_id)) {



    static $id_branch_select;
    static $id_driver_select;
    
    if (isset($_GET['pplASqZZqwQZ'])) {
        $id_branch_select = decrypt_id($_GET['pplASqZZqwQZ']);

        $sql_quer_bra_select = "SELECT * FROM `branch` WHERE `branch_status`=1 AND `id_branch`= ?  ; ";
        $stmt_br_sel = mysqli_prepare($con, $sql_quer_bra_select);
        mysqli_stmt_bind_param($stmt_br_sel, "i", $id_branch_select);
        mysqli_stmt_execute($stmt_br_sel);

        $result_bra_data = mysqli_stmt_get_result($stmt_br_sel);
        while ($array_bra_selected = mysqli_fetch_assoc($result_bra_data)) {

            $id_branch_select = $array_bra_selected['id_branch'];
            $name_branch_sel = $array_bra_selected['name_branch'];
        }
    }

    if (isset($_GET['OOlnfirneoimnr'])) {



        $id_driver_select = decrypt_id($_GET['OOlnfirneoimnr']);


        $sql_quer_driver_select = "SELECT * FROM `users` WHERE `id_user`= ? ; ";
        $stmt_driver_sel = mysqli_prepare($con, $sql_quer_driver_select);
        mysqli_stmt_bind_param($stmt_driver_sel, "i", $id_driver_select);
        mysqli_stmt_execute($stmt_driver_sel);

        $result_driver_data = mysqli_stmt_get_result($stmt_driver_sel);
        while ($array_driver_selected = mysqli_fetch_assoc($result_driver_data)) {

            $id_driver_select = $array_driver_selected['id_user'];
            $name = $array_driver_selected['name'];
            $email_user = $array_driver_selected['email_user'];
            $img_user = $array_driver_selected['img_user'];
            $user_phone = $array_driver_selected['user_phone'];
        }
    }



?>


    <?php
    content_header('استلام الرسائل - الفروع')
    ?>



    <section class="content" dir="rtl" align="right">
    <div class="container-fluid" >

        <!-- branch table -->

        <div class="card card-warning card-outline">
            <div class="card-header">
                <i class="far fa-building"></i>
                ألفروع المرسله وعدد الرسائل
            </div>

            <!-- /.card-header -->

            <div class="card-body">
                <div class="table-responsive">

                    <table id="mes_import_branch_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>من</th>
                                <th>عدد الرسائل </th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $count_row = 0;

                            // $sql_quer_branch = ;
                            $stmt_bra_driv = mysqli_prepare($con, "SELECT  br1.id_branch,o.fk_id_branch_sender,br1.name_branch 'br_sender' ,br2.name_branch 'br_recev',COUNT(DISTINCT o.id_order) AS 'number_mess'
                             FROM branch br1 JOIN `order` o ON br1.id_branch=o.fk_id_branch_sender JOIN branch br2 ON br2.id_branch=o.fk_id_branch_recipient JOIN order_item oi ON o.id_order=oi.fk_order 
                             WHERE o.check_receipt_sender=1 AND o.status_order=1 AND o.fk_level_mess=4 AND o.check_export=1 AND o.ch_imp_dri_fri=1 AND o.ch_imp_us_sec=0  AND `check_import`=0 AND o.fk_id_branch_recipient= ? 
                             GROUP BY br1.name_branch ;");
                            mysqli_stmt_bind_param($stmt_bra_driv, "i", $publi_fk_id_branch);
                            mysqli_stmt_execute($stmt_bra_driv);

                            $result_branch_count = mysqli_stmt_get_result($stmt_bra_driv);
                            while ($array_branch = mysqli_fetch_assoc($result_branch_count)) {

                            ?>

                                <tr>
                                    <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                    <td><?php echo htmlspecialchars($array_branch['br_sender']); ?></td>
                                    <td><?php echo htmlspecialchars($array_branch['number_mess']); ?></td>



                                    <td>
                                        <a title="Edit data" class="btn btn-info btn-sm "
                                            href="mnjghhhg?pplASqZZqwQZ=<?php echo encrypt_id($array_branch['fk_id_branch_sender']); ?>"
                                            role=" button">
                                            تحديد

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
            <!-- /.card-body -->

        </div>




        <?php if ($id_branch_select) { ?>

            <!-- user table -->

            <div class="card card-warning card-outline">
                <div class="card-header">

                    <i class="fas fa-truck"></i>
                    تحديد سائق


                </div>

                <!-- /.card-header -->

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="mes_import_driver_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th># </th>
                                    <th>بيانات السائق</th>
                                    <th>رقم الهاتف</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>عدد الرسائل</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count_row = 0;



                                $sql_quer_drivers = "SELECT u.id_user,u.name,u.user_phone,u.email_user,u.img_user,COUNT(DISTINCT o.id_order) as 'count_or' 
                                FROM `users` u JOIN `order` o ON u.id_user=o.fk_id_driver 
                                WHERE o.check_receipt_sender=1 AND o.status_order=1 AND o.fk_level_mess=4 AND o.check_export=1 AND o.ch_imp_dri_fri=1  AND o.ch_imp_us_sec=0
                                AND `check_import`=0 AND o.fk_id_branch_recipient= ? AND o.fk_id_branch_sender=? GROUP BY u.name;";
                                $stmt_dri = mysqli_prepare($con, $sql_quer_drivers);
                                mysqli_stmt_bind_param($stmt_dri, "ii", $publi_fk_id_branch, $id_branch_select);
                                mysqli_stmt_execute($stmt_dri);

                                $result_drivers = mysqli_stmt_get_result($stmt_dri);

                                while ($array_drivers = mysqli_fetch_assoc($result_drivers)) {




                                ?>

                                    <tr>
                                        <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                        <td>
                                            <img width='50px' height='50px' class='img-fluid rounded'
                                                src="../img/img_user/<?php echo $array_drivers['img_user']; ?>"
                                                alt="<?php echo htmlspecialchars($array_drivers['name']); ?>">



                                            <?php echo htmlspecialchars($array_drivers['name']); ?>


                                        </td>
                                        <td><?php echo htmlspecialchars($array_drivers['user_phone']); ?></td>
                                        <td><?php echo htmlspecialchars($array_drivers['email_user']); ?></td>
                                        <td><?php echo htmlspecialchars($array_drivers['count_or']); ?></td>



                                        <td>
                                            <a title="Edit data" class="btn btn-info btn-sm "
                                                href="mnjghhhg?pplASqZZqwQZ=<?php echo  encrypt_id($id_branch_select); ?>&OOlnfirneoimnr=<?php echo encrypt_id($array_drivers['id_user']); ?>"
                                                role=" button">
                                                تحديد

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
                <!-- /.card-body -->

            </div>

            <!-- /.card -->


        <?php } ?>





        <div class="row">

            <?php if ($id_branch_select) { ?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch" dir="ltr" align="right">
                    <div class="card bg-light">

                        <div class="card-body pt-0">
                            <div class="row">

                                <h2 class="lead"><b><?php echo htmlspecialchars($name_branch_sel); ?></b></h2>


                            </div>
                        </div>

                    </div>
                </div>


            <?php }
            if ($id_driver_select) { ?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch" dir="ltr" align="right">
                    <div class="card bg-light">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b><?php echo htmlspecialchars($name); ?></b></h2>
                                    <h3 class="lead"><b><?php echo htmlspecialchars($email_user); ?></b></h3>
                                    <h3 class="lead"><b><?php echo htmlspecialchars($user_phone); ?></b></h3>
                                </div>
                                <div class="col-4 text-center">
                                    <img src="../img/img_user/<?php echo htmlspecialchars($img_user); ?>"
                                        alt="<?php echo htmlspecialchars($name); ?>" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php } ?>

        </div>


        <?php if ($id_driver_select) { ?>
            <!-- pages table -->
            <div class="card card-warning card-outline">
                <div class="card-header">

                    <i class="far fa-envelope"> الرسائل </i>

                </div>

                <!-- /.card-header -->

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="check_Delivery_Driver_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>QR</th>
                                    <th>من</th>
                                    <th>عدد القطع </th>
                                    <th>رفض</th>
                                    <th>قبول</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count_row = 0;
                                $sql_quer_mess = "SELECT o.id_order,o.QR,j2.name_branch as 'name_sende', COUNT(DISTINCT oi.id_item_order) AS 'number_item'
                                 FROM `order` o JOIN `branch` j2 ON o.fk_id_branch_sender=j2.id_branch JOIN order_item oi ON o.id_order=oi.fk_order
                                 WHERE `check_receipt_sender`=1 AND o.fk_level_mess=4  AND `status_order`=1 AND o.check_export=1 AND o.ch_imp_dri_fri=1 AND o.ch_imp_us_sec=0 AND `check_import`=0
                                 AND o.fk_id_driver=? AND o.fk_id_branch_recipient= ? AND o.fk_id_branch_sender=? GROUP BY o.QR;";
                                $stmt_mess_sho = mysqli_prepare($con, $sql_quer_mess);
                                mysqli_stmt_bind_param($stmt_mess_sho, "iii", $id_driver_select, $publi_fk_id_branch, $id_branch_select);
                                mysqli_stmt_execute($stmt_mess_sho);

                                $result_mess_data = mysqli_stmt_get_result($stmt_mess_sho);
                                while ($array_mess = mysqli_fetch_assoc($result_mess_data)) {
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                        <td><?php echo htmlspecialchars($array_mess['QR']); ?></td>
                                        <td><?php echo htmlspecialchars($array_mess['name_sende']); ?></td>
                                        <td><?php echo htmlspecialchars($array_mess['number_item']); ?></td>

                                        <td>
                                            <button type="button" class="btn btn-block btn-outline-danger btn-sm"
                                                id="reject_mes_import<?php echo  htmlspecialchars($array_mess['id_order']); ?>"
                                                name="reject_the_mess_mes_import"
                                                value="<?php echo  htmlspecialchars($array_mess['id_order']); ?>">رفض</button>
                                        </td>

                                        <td>

                                            <button type="button" class="btn btn-block btn-outline-success btn-sm"
                                                id="accept_mes_import<?php echo  htmlspecialchars($array_mess['id_order']); ?>"
                                                name="accept_the_mess_mes_import"
                                                value="<?php echo  htmlspecialchars($array_mess['id_order']); ?>">قبول</button>

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

        <?php } ?>

        <div class="card card-default" align="right">

            <div class="card-header">
                <i class="fas fa-download"> الرسائل المستلمة اليوم </i>
            </div>

            <!-- /.card-header -->

            <div class="card-body">
                <div class="table-responsive">

                    <table id="mes_import_show_order_giv_the_driver" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>من</th>
                                <th>اسم السائق</th>
                                <th>عدد الرسائل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $dates = date('Y-m-d');
                            $count_row = 0;
                            $sql = "SELECT us.name,br1.name_branch AS 'branch_sender',us.name,COUNT(o.id_order) AS 'number_mess'
                             FROM `order` o
                            JOIN branch br1 ON o.fk_id_branch_sender = br1.id_branch
                            JOIN branch br2 ON o.fk_id_branch_recipient = br2.id_branch
                            JOIN users us ON o.fk_id_driver=us.id_user
                            WHERE  `check_receipt_sender`=1 AND o.fk_level_mess=5  AND `status_order`=1 AND o.check_export=1 
                            AND `check_import`=1 AND o.fk_id_branch_recipient=? AND o.user_id__import=? AND o.date_import=? GROUP BY us.name ;";
                            $stmt_mess_sho = mysqli_prepare($con, $sql);
                            mysqli_stmt_bind_param($stmt_mess_sho, "iis", $publi_fk_id_branch,$id_user_head, $dates);
                            mysqli_stmt_execute($stmt_mess_sho);

                            $result_mess_data = mysqli_stmt_get_result($stmt_mess_sho);
                            while ($array_mess = mysqli_fetch_assoc($result_mess_data)) {
                            ?>

                                <tr>
                                    <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                    <td><?php echo htmlspecialchars($array_mess['branch_sender']); ?></td>
                                    <td><?php echo htmlspecialchars($array_mess['name']); ?></td>
                                    <td><?php echo htmlspecialchars($array_mess['number_mess']); ?></td>




                                </tr>
                            <?php

                            }


                            mysqli_stmt_close($stmt_mess_sho);

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