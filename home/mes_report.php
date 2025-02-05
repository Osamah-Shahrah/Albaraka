<?php

include "../db.php";
include "check.php";




$page_id = 21;
if (chec_use_permission($page_id)) {


    content_header('التقارير بحسب')
?>




    <section class="content" dir="rtl" align="right">
        <div class="container-fluid">



            <?php

            get_users("mwedweoisfhkujn", "efgbnmkoiuygbn", "info", "تحديد", false, "users_table_perm");
            ?>






            <div class="card card-warning card-outline">
                <div class="card-header">

                    <i class="fas fa-truck"></i>
                     السائقين


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



                                $sql_quer_drivers = "SELECT u.id_user,u.name,u.user_phone,u.email_user,j.job_name,u.img_user 
                                FROM `users` u JOIN jobs_table j ON u.user_job=j.job_id 
                                WHERE j.`job_id`='3' AND u.status=1 ;";
                                $stmt_dri = mysqli_prepare($con, $sql_quer_drivers);
                                mysqli_stmt_execute($stmt_dri);

                                $result_drivers = mysqli_stmt_get_result($stmt_dri);

                                while ($array_drivers = mysqli_fetch_assoc($result_drivers)) {




                                ?>

                                    <tr>
                                        <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                        <td>
                                            <img width='50px' height='50px' class='img-fluid rounded'
                                                src="../img/img_user/<?php echo htmlspecialchars($array_drivers['img_user']); ?>"
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
                                                href="mwedweoisfhkujn?jhsdhkfgisdu=<?php echo  encrypt_id($array_drivers['id_user']); ?>&KKLkdone=<?php echo encrypt_id($array_drivers['id_user']); ?>"
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















            <!-- branch table -->

            <div class="card card-warning card-outline">
                <div class="card-header">

                    <i class="far fa-building"></i>
                    الفروع


                </div>

                <!-- /.card-header -->

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="mes_export_branch_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th># </th>
                                    <th>اسم الفرع </th>
                                    
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $count_row = 0;

                                // $sql_quer_branch = ;
                                $stmt_bra = mysqli_prepare($con, "SELECT  br.id_branch,br.name_branch
                             FROM branch br 
                             WHERE br.id_branch!=4 AND br.id_branch!=? ");
                                mysqli_stmt_bind_param($stmt_bra, "i", $publi_fk_id_branch);
                                mysqli_stmt_execute($stmt_bra);

                                $result_branch_number = mysqli_stmt_get_result($stmt_bra);
                                while ($array_branch = mysqli_fetch_assoc($result_branch_number)) {

                                ?>

                                    <tr>
                                        <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                        <td><?php echo htmlspecialchars($array_branch['name_branch']); ?></td>
                                        



                                        <td>
                                            <a title="Edit data" class="btn btn-info btn-sm "
                                                href="mwedweoisfhkujn?iusfyw87fgknk=<?php echo encrypt_id($array_branch['id_branch']); ?>"
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



        </div>
    </section>



<?php

    include "footer.php";
} else {
    include "Error404.php";
}
?>