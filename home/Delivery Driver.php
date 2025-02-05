<?php
include "../db.php";
include "check.php";





$page_id = 20;
if (chec_use_permission($page_id)) {

    static $id_branch_select;

    if (isset($_GET['PLmeawughnsi'])) {
        $id_branch_select = decrypt_id($_GET['PLmeawughnsi']);

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




?>


    <?php
    content_header('تسليم الرسائل-سائق')
    ?>



<section class="content" dir="rtl" align="right">
<div class="container-fluid" >

    <!-- branch table -->

    <div class="card card-warning card-outline">
        <div class="card-header">

        <i class="far fa-building"></i>
            ألفروع وعدد الرسائل الموجوده معي


        </div>

        <!-- /.card-header -->

        <div class="card-body">
            <div class="table-responsive">

                <table id="Delivery_Driver_branch_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># </th>
                            <th>من</th>
                            <th>الى</th>
                            <th>عدد الرسائل </th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $count_row = 0;

                            // $sql_quer_branch = ;
                            $stmt_bra_driv = mysqli_prepare($con, "SELECT  br1.id_branch,o.fk_id_branch_recipient,br1.name_branch 'br_sender' ,br2.name_branch 'br_recev',COUNT(DISTINCT o.id_order) AS 'number_mess'
                             FROM branch br1 JOIN `order` o ON br1.id_branch=o.fk_id_branch_sender JOIN branch br2 ON br2.id_branch=o.fk_id_branch_recipient JOIN order_item oi ON o.id_order=oi.fk_order 
                             WHERE o.check_receipt_sender=1 AND o.status_order=1 AND o.fk_level_mess=3 AND o.check_export=1 AND `check_import`=0   AND o.fk_id_driver= ? 
                              GROUP BY br1.name_branch ;");
                            mysqli_stmt_bind_param($stmt_bra_driv, "i", $id_user_head);
                            mysqli_stmt_execute($stmt_bra_driv);

                            $result_branch_count = mysqli_stmt_get_result($stmt_bra_driv);
                            while ($array_branch = mysqli_fetch_assoc($result_branch_count)) {

                            ?>

                        <tr>
                            <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                            <td><?php echo htmlspecialchars($array_branch['br_sender']); ?></td>
                            <td><?php echo htmlspecialchars($array_branch['br_recev']); ?></td>
                            <td><?php echo htmlspecialchars($array_branch['number_mess']); ?></td>



                            <td>
                                <a title="Edit data" class="btn btn-info btn-sm "
                                    href="llkmkj?PLmeawughnsi=<?php echo encrypt_id($array_branch['fk_id_branch_recipient']); ?>"
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
            ?>




    </div>


    <?php if ($id_branch_select) {


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
            <div class="table-responsive">

                <table id="check_Delivery_Driver_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>QR</th>
                            <th>إلى</th>
                            <th>عدد القطع </th>
                            <th>تصدير</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $count_row = 0;
                                $sql_quer_mess = "SELECT o.id_order,o.QR,j2.name_branch as 'name_des', COUNT(DISTINCT oi.id_item_order) AS 'number_item',`date_export`
                                 FROM `order` o JOIN `branch` j2 ON o.fk_id_branch_recipient=j2.id_branch JOIN order_item oi ON o.id_order=oi.fk_order
                                  WHERE `check_receipt_sender`=1 AND o.fk_level_mess=3  AND `status_order`=1 AND o.check_export=1
                                  AND o.fk_id_branch_recipient= ? AND o.fk_id_driver=? GROUP BY o.QR;";
                                $stmt_mess_sho = mysqli_prepare($con, $sql_quer_mess);
                                mysqli_stmt_bind_param($stmt_mess_sho, "ii", $id_branch_select, $id_user_head);
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
                                        <button type="button" class="btn btn-block btn-outline-success btn-sm" 
                                        id="export_<?php echo  htmlspecialchars($array_mess['id_order']); ?>"  name="export_mess_to_bra" 
                                        value="<?php echo  htmlspecialchars($array_mess['id_order']); ?>">تصدير</button>
                            </td>
                        </tr>
                        <?php

                                }

                                ?>

                    </tbody>

                </table>
            </div>
            
                <div class="col-12">
                  <button type="button" class="btn btn-info float-left" id="id_export_all_mess_to_br_<?php echo  htmlspecialchars($array_mess['id_order']); ?>"  name="export_all_mess_to_br" 
                  value="<?php echo  htmlspecialchars($id_branch_select); ?>">
                    <i class="fas fa-upload"></i> تسليم جميع الرسائل
                  </button>
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