<?php
include "../db.php";
include "check.php";





$page_id = 5;

if (chec_use_permission($page_id)) {


    static $id_user = 0;


    if (isset($_GET['XXCaqwsderfffijnd'])) {


        $id_user = decrypt_id($_GET['XXCaqwsderfffijnd']);

        static $name;
        static $email_user;
        static $user_phone;
        static $img_user;
        static $status;

        $sql_quer_usert = "SELECT * FROM `users` WHERE `id_user`='" . $id_user . "';";



        $execution_query_user = mysqli_query($con, $sql_quer_usert) or die(mysqli_error($con));
        if (mysqli_num_rows($execution_query_user) > 0) {
            while ($array_user = mysqli_fetch_array($execution_query_user)) {


                $id_user = $array_user['id_user'];
                $name = $array_user['name'];
                $email_user = $array_user['email_user'];
                $user_phone = $array_user['user_phone'];
                $img_user = $array_user['img_user'];
                if ($array_user['status'] == 1) {
                    $status_sc_user = "checked";
                } else {
                    $status_sc_user = "check";
                }
            }
        }
    }







    content_header('إدارة الصلاحيات');
?>
<section class="content" dir="rtl" align="right">
    <div class="container-fluid" >


        <?php

            get_users("llokikl", "XXCaqwsderfffijnd", "info", "تحديد",false,"users_table_perm");
            ?>

        <?php if ($id_user) {


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
                            <img src="../img/img_user/<?php echo htmlspecialchars($img_user); ?>" alt="<?php echo htmlspecialchars($name); ?>"
                                class="img-circle img-fluid">
                        </div>
                    </div>
                </div>

            </div>
        </div>














        <?php
            }
            ?>


        <div class="card card-warning card-outline">
            <div class="card-header">

                <i class="far fa-chart-bar"></i>
                الصفحات


            </div>

            <!-- /.card-header -->

            <div class="card-body">
                <div class="col-sm-12 table-responsive p-0">

                    <table id="page_prem" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>الاسم</th>
                                <th>البيات</th>
                                <?php if ($id_user) { ?>
                                <th>#</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count_row = 0;
                                $sql = "SELECT * FROM `pages` WHERE `page_status`=1;";

                                if ($id_user) {
                                    $sql = "SELECT * FROM `pages` LEFT OUTER JOIN `pages_permission` ON pages.id_page=pages_permission.fk_page_id AND pages_permission.fk_user_id= '" . $id_user . "' WHERE `page_status`=1 ; ";
                                }


                                $result = mysqli_query($con, $sql) or die(mysqli_error($con));

                                while ($r = mysqli_fetch_array($result)) {
                                ?>

                            <tr>
                                <td><?php echo htmlspecialchars($count_row += 1); ?></td>
                                <td>

                                    <?php echo htmlspecialchars($r['name_page']); ?>

                                    <input type="hidden" name="id_page_per" id='id_page_per'
                                        value=" <?php echo htmlspecialchars($r['id_page']); ?>"></input>
                                    <input type="hidden" name="id_user_page_per" id='id_user_page_per'
                                        value=" <?php echo htmlspecialchars($id_user); ?>"></input>
                                </td>
                                <td><?php echo htmlspecialchars($r['page_details']); ?></td>


                                <?php if ($id_user) { ?>
                                <td>
                                    <?php
                                                if ($r['user_pages_status'] == 1) {
                                                    $status_sc = "checked";
                                                } else {
                                                    $status_sc = "check";
                                                }
                                                ?>



                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input"
                                                id="page_<?php echo htmlspecialchars($r['id_page']); ?>" name="user_pages_status_per"
                                                value="<?php echo htmlspecialchars($r['user_pages_status']); ?>"
                                                <?php echo htmlspecialchars($status_sc); ?>>
                                            <label class="custom-control-label" for="page_<?php echo htmlspecialchars($r['id_page']); ?>">
                                                <?php
                                                            if ($r['user_pages_status'] == 1) {
                                                                echo "<small class='badge badge-warning'> مفعل </small>";
                                                            } else {
                                                                echo "<small class='badge badge-danger'> غبرمفعل </small>";
                                                            }
                                                            ?></label>
                                        </div>
                                    </div>
                                </td>
                                <?php } ?>

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

    </div>
</section>



<?php

    include "footer.php";
} else {
    include "Error404.php";
}
?>