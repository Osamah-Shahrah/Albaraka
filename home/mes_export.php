<?php
include "../db.php";
include "check.php";





$page_id = 16;
if (chec_use_permission($page_id)) {


    static $id_driver_select;
    static $id_branch_select;

    static $name_branch_sel;

    static $name;
    static $email_user;
    static $img_user;
    static $user_phone;




    if (isset($_GET['opolQWS'])) {
        $id_branch_select = decrypt_id($_GET['opolQWS']);






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



    if (isset($_GET['KKLkdone'])) {



        $id_driver_select = decrypt_id($_GET['KKLkdone']);


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
    content_header('تصدير الرسائل')
    ?>



<section class="content" dir="rtl" align="right">
<div class="container-fluid" >

    <!-- branch table -->

    <div class="card card-warning card-outline">
        <div class="card-header">

        <i class="far fa-building"></i>
            الرسائل التي لم ترسل بحسب الفروع


        </div>

        <!-- /.card-header -->

        <div class="card-body">
            <div class="table-responsive">

                <table id="mes_export_branch_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># </th>
                            <th>اسم الفرع </th>
                            <th>عدد الرسائل الموجوده</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $count_row = 0;

                            // $sql_quer_branch = ;
                            $stmt_bra = mysqli_prepare($con, "SELECT  br.id_branch,br.name_branch,COUNT(DISTINCT o.id_order) AS 'number_mess'
                             FROM branch br 
                             JOIN `order` o ON br.id_branch=o.fk_id_branch_recipient 
                             JOIN order_item oi ON o.id_order=oi.fk_order 
                             WHERE o.check_receipt_sender=1 AND o.status_order=1 AND o.fk_level_mess=1 
                             AND o.check_export=0 AND o.fk_id_branch_sender= ? 
                             AND o.fk_id_branch_recipient!=? AND o.fk_id_driver=0 
                             GROUP BY br.name_branch ;");
                            mysqli_stmt_bind_param($stmt_bra, "ii", $publi_fk_id_branch, $publi_fk_id_branch);
                            mysqli_stmt_execute($stmt_bra);

                            $result_branch_number = mysqli_stmt_get_result($stmt_bra);
                            while ($array_branch = mysqli_fetch_assoc($result_branch_number)) {

                            ?>

                        <tr>
                            <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                            <td><?php echo htmlspecialchars($array_branch['name_branch']); ?></td>
                            <td><?php echo htmlspecialchars($array_branch['number_mess']); ?></td>



                            <td>
                                <a title="Edit data" class="btn btn-info btn-sm "
                                    href="mklkj?opolQWS=<?php echo encrypt_id($array_branch['id_branch']); ?>"
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










    <?php if ($id_branch_select) {



        ?>

    <!-- user table -->

    <div class="card card-warning card-outline">
        <div class="card-header">

        <i class="fas fa-truck"></i>
            اختيار سائق


        </div>

        <!-- /.card-header -->

        <div class="card-body">
            <div class="table-responsive">

                <table id="mes_export_driver_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># </th>
                            <th>بيانات السائق</th>
                            <th>رقم الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th>نوع الوظيفة</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $count_row = 0;



                                $sql_quer_drivers = "SELECT u.id_user,u.name,u.user_phone,u.email_user,j.job_name,u.img_user FROM `users` u JOIN jobs_table j ON u.user_job=j.job_id WHERE j.`job_id`='3' AND u.status=1 ;";
                                $stmt_dri = mysqli_prepare($con, $sql_quer_drivers);
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

                                <input type="hidden" name="id_driver_select" id='id_driver_select'
                                    value=" <?php echo htmlspecialchars($array_drivers['id_user']); ?>"></input>
                            </td>
                            <td><?php echo htmlspecialchars($array_drivers['user_phone']); ?></td>
                            <td><?php echo htmlspecialchars($array_drivers['email_user']); ?></td>
                            <td><?php echo htmlspecialchars($array_drivers['job_name']); ?></td>



                            <td>
                                <a title="Edit data" class="btn btn-info btn-sm "
                                    href="mklkj?opolQWS=<?php echo  encrypt_id($id_branch_select); ?>&KKLkdone=<?php echo encrypt_id($array_drivers['id_user']); ?>"
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


    <?php
        }
        ?>



    <div class="row">

        <?php if ($id_branch_select) {


            ?>


        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch" dir="ltr" align="right">
            <div class="card bg-light">

                <div class="card-body pt-0">
                    <div class="row">

                        <h2 class="lead"><b><?php echo htmlspecialchars($name_branch_sel); ?></b></h2>


                    </div>
                </div>

            </div>
        </div>


        <?php
            }
           if ($id_driver_select) {
?>

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


        <?php
            }
            ?>

    </div>


    <?php if ($id_driver_select) {


        ?>

    <!-- pages table -->

    <div class="card card-warning card-outline">
        <div class="card-header">

        <i class="far fa-envelope">
            الرسائل
        </i>


        </div>

        <!-- /.card-header -->

        <div class="card-body">
            <div class="table-responsive ">

                <table id="export_mes_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># </th>
                            <th>QR</th>
                            <th>إلى</th>
                            <th>عدد القطع </th>
                            <th>#</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $count_row = 0;


                                $sql_quer_mess = "SELECT o.id_order,o.QR,j2.name_branch as 'name_des', COUNT(DISTINCT oi.id_item_order) AS 'number_item'
                                 FROM `order` o JOIN `branch` j2 ON o.fk_id_branch_recipient=j2.id_branch JOIN order_item oi ON o.id_order=oi.fk_order
                                  WHERE `check_receipt_sender`=1 AND o.fk_level_mess=1  AND `status_order`=1 AND o.check_export=0 AND o.fk_id_branch_sender= ? 
                                  AND o.fk_id_branch_recipient= ? AND o.fk_id_driver=0 GROUP BY o.QR;";
                                $stmt_mess_sho = mysqli_prepare($con, $sql_quer_mess);
                                mysqli_stmt_bind_param($stmt_mess_sho, "ii", $publi_fk_id_branch, $id_branch_select);
                                mysqli_stmt_execute($stmt_mess_sho);

                                $result_mess_data = mysqli_stmt_get_result($stmt_mess_sho);
                                while ($array_mess = mysqli_fetch_assoc($result_mess_data)) {
                                ?>

                        <tr>
                            <td><?php echo htmlspecialchars($count_row += 1); ?></td>


                            <td><?php echo htmlspecialchars($array_mess['QR']); ?></td>
                            <td><?php echo htmlspecialchars($array_mess['name_des']); ?></td>
                            <td><?php echo htmlspecialchars($array_mess['number_item']); ?></td>

                            <td>



                                <input type="hidden" type="text" name="driver_id_select" id="driver_id_select"
                                    value="<?php echo  htmlspecialchars($id_driver_select); ?>">


                                        <button type="button" class="btn btn-block btn-outline-success btn-sm" 
                                        id="mess_<?php echo  htmlspecialchars($array_mess['id_order']); ?>"
                                            name="driver_mess_status"
                                            value="<?php echo  htmlspecialchars($array_mess['id_order']); ?>">تصدير</button>



                                
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
    <div class="card card-default" align="right">

        <div class="card-header">
            <h5>الرسائل المصدرة اليوم</h5>
        </div>

        <!-- /.card-header -->

        <div class="card-body">
            <div class="table-responsive">

                <table id="show_order_giv_the_driver" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            
                            <th>إلى</th>
                            <th>اسم السائق</th>
                            <th>عدد الرسائل</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $count_row = 0;
                                $sql = "SELECT  o.`status_order`, br2.name_branch AS 'branch_recipient',us.name,COUNT(o.id_order) AS 'number_mess' FROM `order` o


                        JOIN branch br2 ON o.fk_id_branch_recipient = br2.id_branch
                        JOIN users us ON o.fk_id_driver=us.id_user
                        WHERE o.`fk_id_branch_sender` = ? AND o.date_export=? 
                        AND o.ch_ex_us_fri=1 AND o.user_id__export=? GROUP BY us.name ;";

                                $stmt = mysqli_prepare($con, $sql);
                                if (!$stmt) {
                                    die('Prepare failed: ' . mysqli_error($con));
                                }
                                mysqli_stmt_bind_param($stmt, 'isi',$publi_fk_id_branch, $dates,$id_user_head);

                                if (mysqli_stmt_execute($stmt)) {
                                    $result = mysqli_stmt_get_result($stmt);

                                    if (mysqli_num_rows($result) == 0) {
                                        echo "<td colspan='11'><h6 class='text-center'> لا يوجد بيانات</h6></td>";
                                    } else {
                                        while ($row = mysqli_fetch_assoc($result)) {



                                ?>

                        <tr>
                            <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                            <td><?php echo htmlspecialchars($row['branch_recipient']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['number_mess']); ?></td>




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


</div>
</section>



<?php

    include "footer.php";
} else {
    include "Error404.php";
}
?>