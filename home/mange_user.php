<?php

include "../db.php";
include "check.php";


$page_id = 1;

if (chec_use_permission($page_id)) {

    static $id_user = 0;
    static $fk_branch = 0;
    static $user_job = 0;
    if (isset($_GET['MMnsinedyuhjkbegdh'])) {
        $id_user = decrypt_id($_GET['MMnsinedyuhjkbegdh']);
        static $name;
        static $email_user;
        static $img_user;
        static $user_phone;
        static $user_job;
        static $details_job;
        static $user_note;
        static $fk_branch;

        $sql_quer_usert = "SELECT * FROM `users` WHERE `id_user` = ?";
        $stmt = mysqli_prepare($con, $sql_quer_usert);
        mysqli_stmt_bind_param($stmt, "i", $id_user);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $array_user = mysqli_fetch_assoc($result);
            $name = $array_user['name'];
            $email_user = $array_user['email_user'];
            $img_user = $array_user['img_user'];
            $user_phone = $array_user['user_phone'];
            $user_job = $array_user['user_job'];
            $details_job = $array_user['details_job'];
            $user_note = $array_user['user_note'];
            $fk_branch = $array_user['fk_branch'];
        }
    }




?>


    <?php
    content_header('إدارة الموظفين');
    ?>



    <section class="content" dir="rtl" align="right">
        <div class="container-fluid">



            <div class="card card-warning card-outline">
                <div class="card-header">
                    <?php if ($id_user > 0) {
                    ?>
                        <h5> تعديل بيانات موظف</h5>
                    <?php } else {
                    ?>
                        <h5> إضافة موظف</h5>

                    <?php
                    }
                    ?>
                </div>
                <div class="card-body">
                    <form action="IIihjndiuh" class="text-start g-3 needs-validation row" method="POST" type="form"
                        enctype="multipart/form-data">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">اسم الموظف</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" name="name" id="name" required
                                        placeholder="اسامه__ " value="<?php if ($id_user > 0) {
                                                                            echo htmlspecialchars($name);
                                                                        } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-text">@</i></span>
                                    </div>

                                </div>

                                <!-- input disble for send id_company if this oprition ubdate or null that is new company to insert  -->
                                <input type="hidden" name="id_user" id="id_user" value="<?php if ($id_user > 0) {
                                                                                            echo htmlspecialchars($id_user);
                                                                                        } ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_phone">رقم الهاتف</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" name="user_phone" id="user_phone"
                                        placeholder="(_,_,_)___" value="<?php if ($id_user > 0) {
                                                                            echo htmlspecialchars($user_phone);
                                                                        } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Email">البريد الإلكتروني</label>
                                <div class="input-group">

                                    <input type="email" class="form-control" name="Email" id="Email" required
                                        placeholder="name@example.com" value="<?php if ($id_user > 0) {
                                                                                    echo htmlspecialchars($email_user);
                                                                                } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_user">كلمة المرور</label>
                                <div class="input-group">

                                    <input type="password" class="form-control" name="password_user" id="password_user"
                                        required placeholder="***">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-text">*</i></span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">

                            <?php 
                                                            if($publi_fk_id_branch===4)
                                                            {
                            get_select("الفرع", "branch_user", $id_user, $fk_branch, "id_branch", "branch"); 
                        }
                            get_select("نوع الوظيفة", "job_type", $id_user, $user_job, "job_id", "jobs_table"); 
                                
                                ?>
                            <div class="form-group">
                                <label for="imgpro">الصوره</label>
                                <div class="input-group">
                                    <input type="file" name="picture" id="imgpro" accept=".png, .jpg,.gif,.jpeg,jpe,.ico">
                                    <?php if ($id_user > 0) {
                                        echo "<img  src='../img/img_user/$img_user'
                                        class='img-fluid rounded' width='100' height='100'>";
                                    } ?>



                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="details_job">التعليقات على الموظف</label>
                                <div class="input-group">

                                    <textarea class="form-control" name="details_job" id="details_job"
                                        placeholder="____"><?php if ($id_user > 0) {
                                                                echo htmlspecialchars($details_job);
                                                            } ?></textarea>


                                </div>
                            </div>



                            <div class="form-group">
                                <label for="user_note">الملاحظات</label>
                                <div class="input-group">

                                    <textarea class="form-control" name="user_note" id="user_note"
                                        placeholder="____"><?php if ($id_user > 0) {
                                                                echo htmlspecialchars($user_note);
                                                            } ?></textarea>


                                </div>
                            </div>
                        </div>




                        <?php if ($id_user > 0) {
                        ?>
                            <button class="btn btn-block btn-danger" id="add_user_or_updata" type="submit"
                                name="add_user_or_updata">تعديل
                                <span data-feather="save"></span>
                            </button>
                        <?php } else {
                        ?>
                            <button class="btn btn-block btn-info" id="add_user_or_updata" type="submit"
                                name="add_user_or_updata">إضافة
                                <span data-feather="save"></span>
                            </button>

                        <?php
                        }
                        ?>

                    </form>
                </div>
            </div>



            <?php

            get_users("kiji", "MMnsinedyuhjkbegdh", "info", "تعديل", true, "users_table");
            ?>




        </div>
    </section>



<?php

    include "footer.php";
} else {
    include "Error404.php";
}
?>