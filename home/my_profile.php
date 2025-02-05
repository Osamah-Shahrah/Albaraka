<?php

include "check.php";










$id_user = osamah_decrypt($_SESSION['id_user']);

if (isset($id_user)) {


    static $name;
    static $email_user;
    static $img_user;
    static $password_user;
    static $user_phone;


    $sql_quer_usert = "SELECT * FROM `users` WHERE id_user='" . $id_user . "';";



    $execution_query_user = mysqli_query($con, $sql_quer_usert) or die(mysqli_error($con));
    if (mysqli_num_rows($execution_query_user) > 0) {
        while ($array_user = mysqli_fetch_array($execution_query_user)) {


            $id_user = $array_user['id_user'];
            $name = $array_user['name'];
            $email_user = $array_user['email_user'];
            $img_user = $array_user['img_user'];
            $password_user = $array_user['password_user'];
            $user_phone = $array_user['user_phone'];

        }
    }

?>



<?php
content_header('الملف الشخصي')
?>



<section class="content"  dir="rtl" align="right">
    <div class="container-fluid" >





            <div class="card card-warning card-outline col-md-12">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="<?php if ($id_user > 0) {
                                                                                    echo "../img/img_user/$img_user";
                                                                                } ?>" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center"><?php if ($id_user > 0) {
                                                                    echo htmlspecialchars($name);
                                                                } ?></h3>





                </div>
                <div class="card-body">
                    <form action="IIihjndiuh" id="" class="text-start g-3 needs-validation row" method="POST"
                        type="form" name="" enctype="multipart/form-data">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">اسم المستخدم</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" name="name" id="name" required
                                        placeholder="Osamah___ "
                                        value="<?php if ($id_user > 0) {
                                                    echo htmlspecialchars($name);
                                                } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-text">@</i></span>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_phone">رقم الهاتف</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" name="user_phone" id="user_phone"
                                        placeholder="(_,_,_)___"
                                        value="<?php if ($id_user > 0) {
                                                    echo htmlspecialchars($user_phone);
                                                } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-text">7</i></span>
                                    </div>

                                </div>
                            </div>




                            <div class="form-group">
                                <label for="Email">البريد الإلكتروني</label>
                                <div class="input-group">

                                    <input type="Email" class="form-control" name="Email" id="Email" required
                                        placeholder="name@example.com"
                                        value="<?php if ($id_user > 0) {
                                                    echo htmlspecialchars($email_user);
                                                } ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-text">@</i></span>
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
                        <div class="col-md-6">




                            <div class="form-group">
                                <label for="imgpro">الصورة الشخصية</label>
                                <div class="input-group">
                                    <input type="file" name="picture" id="imgpro"
                                        accept=".png, .jpg,.gif,.jpeg,jpe,.ico">
                                    <img id="proimg" src="<?php if ($id_user > 0) {
                                                                echo "../img/img_user/$img_user";
                                                            } ?>" width='100px' height='100px'
                                        class='img-fluid rounded'
                                        <?php if ($id_user == 0) {
                                            echo "style='display: none;'";
                                        } ?>>

                                    <script>
                                        function openfile() {
                                            document.getElementById('imgpro').click();
                                        }
                                        $(document).ready(function() {
                                            var proimg = $("#proimg");

                                            $("#imgpro").change(function(e) {
                                                var tmppath = URL.createObjectURL(e.target.files[0]);

                                                proimg.fadeIn("fast").attr('src', tmppath)

                                            })
                                        })
                                    </script>

                                </div>
                            </div>

                        </div>






                        <button class="btn btn-block btn-warning" id="chang_data" type="submit" name="chang_data">تعديل
                            <span data-feather="save"></span>
                    </form>
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