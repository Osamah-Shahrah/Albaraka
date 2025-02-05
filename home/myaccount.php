<?php
include 'check.php';

$page_id = 14;
if (chec_use_permission($page_id)) {

    $status_currency='status_currency';
    $job_statues='status';
    $mess_type='status_mess';
    $branch_status='branch_status';
    $size_statues='size_statues';


    $id_currency = 0;
    if (isset($_GET['id_currency'])) {
        $id_currency = decrypt_id($_GET['id_currency']);
    }

    $job_id = 0;
    if (isset($_GET['job_id'])) {
        $job_id = decrypt_id($_GET['job_id']);
    }

    $id_mess = 0;
    if (isset($_GET['id_mess'])) {
        $id_mess =decrypt_id($_GET['id_mess']);
    }

    $id_branch = 0;
    if (isset($_GET['id_branch'])) {
        $id_branch = decrypt_id($_GET['id_branch']);
    }

    $id_size = 0;
    if (isset($_GET['id_size_items'])) {
        $id_size = decrypt_id($_GET['id_size_items']);
    }


    
    $name_system;$Email;$phon_number;$address;$icon_system;$whatsapp;$telegram;$website_system;$instagram;$facebook;$twitter;$linkedin;$about_system;
    $sql = "SELECT * FROM `system_info`";
    $stmt = mysqli_prepare($con, $sql);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $name_system = $row['name_system'];
            $Email = $row['Email'];
            $phon_number = $row['phon_number'];
            $address = $row['address'];
            $icon_system = $row['icon_system'];
            $whatsapp = $row['whatsapp'];
            $telegram = $row['telegram'];
            $website_system = $row['website_system'];
            $instagram = $row['instagram'];
            $facebook = $row['facebook'];
            $twitter = $row['twitter'];
            $linkedin = $row['linkedin'];
            $about_system = $row['about_system'];
        }
    } else {
        // Handle error (e.g., log error, display error message)
        echo "Error fetching system information: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);

    content_header('بيانات الشركة');
?>


<!-- Main content -->
<section class="content"  dir="rtl" align="right">
    <div class="container-fluid" >


        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="../img/web_img/<?php echo htmlspecialchars($icon_system); ?>"
                    alt="<?php echo htmlspecialchars($name_system); ?>">
            </div>

            <h3 class="profile-username text-center"><?php echo htmlspecialchars($name_system); ?></h3>

            <p class="text-muted text-center"><?php echo  htmlspecialchars($address); ?></p>

        </div>

        <!-- About Me Box -->
        <div class="card card-outline card-warning">

            <!-- /.card-header -->
            <div class="card-body">

                <strong><i class="fas fa-lg fa-building"></i>
                    <?php echo htmlspecialchars($name_system); ?>
                </strong>


                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> العنوان</strong>

                <p class="text-muted">
                    <?php echo  htmlspecialchars($address); ?>
                </p>

                <hr>

                <strong><i class="fas fa-lg fa-phon_number"></i>تواصل</strong>

                <p class="text-muted">
                    <?php echo "<span class='tag tag-danger'> <i class='fas fa-sm fa-phon_number '>:" . $phon_number . "</i> </span>, <span class='tag tag-danger'> <i class='fas fa-sm fa-envelope'>:" . $Email . "</i> </span>,<span class='tag tag-danger'> <i class='fab fa-whatsapp fa-sm'>:" . $whatsapp . "</i> </span>,<span class='tag tag-danger'> <i class='fab fa-telegram-plane fa-sm'>:" . $telegram . "</i> </span>"; ?>
                </p>

                <hr>

                <strong><i class="fab fa-lg fa-facebook-f "></i>وسائل التواصل</strong>

                <p class="text-muted">
                    <?php echo "<span class='tag tag-danger'> <i class='fab fa-facebook-f fa-sm '>:" . $facebook . "</i> </span>, <span class='tag tag-danger'> <i class='fab fa-instagram fa-sm'>:" . $instagram . "</i> </span>,<span class='tag tag-danger'> <i class='fab fa-twitter fa-sm '>:" . $twitter . "</i> </span>,<span class='tag tag-danger'> <i class='fab fa-linkedin fa-sm'>:" . $linkedin . "</i> </span>"; ?>
                </p>

                <hr>


                <strong><i class="fas fa-link"></i>رابط الموقع</strong>

                <p class="text-muted">
                    <?php echo htmlspecialchars($website_system); ?>
                </p>


                <strong><i class="far fa-file-alt mr-1"></i> وصف الشركة</strong>

                <p class="text-muted">
                    <?php echo htmlspecialchars($about_system); ?>
                </p>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

            <!--card data change the company -->
        <div class="card card-outline card-warning collapsed-card">
            <div class="card-header" data-card-widget="collapse">

                 <h4 >تعديل البيانات</h4>
                <div class="card-tools" >
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                </div>
                
            </div>
            <!-- /.card-header -->
            <div class="card-body" >




                <form action="IIihjndiuh" id="form_chang_myaccount" class="text-start g-3 needs-validation row"
                    method="post" type="form" name="form_chang_myaccount" enctype="multipart/form-data">

                    <div class="row">


                        <div class="col-md-6">
                            <h5>البيانات الرائيسية</h5>



                            <div class="form-group">
                                <label for="name_system"> أسم الشركة</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name_system" id="name_system"
                                        placeholder="الاسم" value="<?php echo htmlspecialchars($name_system); ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-text">@</i></span>
                                    </div>

                                </div>
                            </div>



                            <div class="form-group">
                                <label for="phon_number">رقم الهاتف</label>

                                <div class="input-group">
                                    <input type="text" id="phon_number" name="phon_number" type="text" value="<?php
                                                                                                                    echo htmlspecialchars($phon_number);
                                                                                                                    ?>"
                                        class="form-control" data-inputmask='"mask": "999 999 999"' data-mask>

                                    <div class="input-group-prepend">
                                        <span class="input-group-text">📞<i class="fas fa-phon_number"></i></span>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>


                            <div class="form-group">
                                <label for="picture">شعار المركز</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="picture" name="picture"
                                            accept=".png, .jpg,.gif,.jpeg,jpe,.ico">
                                        <label class="custom-file-label" for="picture">إخترالصورة</label>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    </div>

                                </div>
                            </div>



                        </div>


                        <div class="col-md-6">
                            <h5>العناوين</h5>

                            <div class="form-group">
                                <label for="Email"> البريد الالكتروني</label>

                                <div class="input-group">
                                    <input type="Email" class="form-control" name="Email" id="Email" placeholder="Email"
                                        value="<?php echo htmlspecialchars($Email); ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address"> العنوان</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="الموقع" value="<?php echo htmlspecialchars($address); ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt mr-1"></i></span>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="about_system">وصف الشركة</label>

                                <div class="input-group">
                                    <textarea class="form-control" rows="2" name="about_system" id="about_system"
                                        placeholder="وصف المتجر"><?php echo htmlspecialchars($about_system); ?></textarea>
                                    

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    </div>


                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <h5>بيانات التواصل</h5>

                            <div class="form-group">
                                <label for="whatsapp"> وتس اب</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="whatsapp" id="whatsapp"
                                        placeholder="وتس اب" value="<?php
                                                    echo htmlspecialchars($whatsapp);
                                                    ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-whatsapp fa-lg"></i></span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="telegram"> تلجرام</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="telegram" id="telegram"
                                        placeholder="تلجرام" value="<?php echo htmlspecialchars($telegram); ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text" for="telegram"><i
                                                class="fab fa-telegram-plane fa-lg" for="telegram"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="website_system"> رابط الموقع</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="website_system" id="website_system"
                                        placeholder="رابط الموقع" value="<?php echo htmlspecialchars($website_system); ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    </div>
                                </div>

                            </div>








                        </div>


                        <div class="col-md-6">
                            <h5> التواصل الإجتماعي</h5>

                            <div class="form-group">
                                <label for="instagram"> إنستجرام</label>

                                <div class="input-group">
                                    <input type="text" class="form-control" name="instagram" id="instagram"
                                        placeholder="إنستجرام" value="<?php
                                                    echo htmlspecialchars($instagram);
                                                    ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                class="fab fa-instagram fa-lg fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="facebook">فيسبوك</label>

                                <div class="input-group">
                                    <input type="text" class="form-control" name="facebook" id="facebook"
                                        placeholder="فيسبوك" value="<?php echo htmlspecialchars($facebook); ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                class="fab fa-facebook-f fa-lg fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="twitter">X</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="twitter" id="twitter"
                                        placeholder="تويتر" value="<?php echo htmlspecialchars($twitter); ?>">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-twitter fa-lg fa-fw"></i></span>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group">
                                <label for="linkedin">لينكد ان</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="linkedin" id="linkedin"
                                        placeholder="لينكد ان" value="<?php echo htmlspecialchars($linkedin); ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                class="fab fa-linkedin fa-lg fa-fw"></i></span>
                                    </div>

                                </div>
                            </div>


                        </div>


                    </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button class="btn btn-block btn-danger" id="sub" type="submit" name="btn_save_data_profile">تعديل
                    <span data-feather="save"></span>
                </button>

                </form>


            </div>

        </div>
        <!-- /.card -->


        <!-- card the tables  for data public in the comapny-->

            <!-- /.card-header -->
            
                <div class="row">
                    <?php get_service("currency_tab", "id_currency", "warning", "العملات", "add_updata_currency", $id_currency, "العملة",$status_currency); ?>
                    <?php get_service("jobs_table", "job_id", "warning", "الوظائف", "add_updata_jobs_table", $job_id, "الوظيفة", $job_statues); ?>
                </div>
                <div class="row">
                    <?php get_service("mess_type", "id_mess", "warning", "انواع الرسائل", "add_updata_mess_type", $id_mess, "الرسالة", $mess_type); ?>
                    <?php get_service("branch", "id_branch", "warning", "الفروع", "add_updata_branch", $id_branch, "الفرع",$branch_status); ?>
                </div>
                <div class="row">
                    <?php get_service("size_items", "id_size_items", "warning", "احجام الرسائل", "add_updata_size_items", $id_size, "حجم الرسالة",$size_statues); ?>
                </div>


        

    </div>
</section>
<!-- /.content -->


<?php
    include 'footer.php';
} else {
    include "Error404.php";
}
?>