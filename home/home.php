<?php
include "check.php";



?>





<?php
content_header('الرئيسية');


?>


<section class="content">
    <div class="container-fluid" dir="rtl">


        <div class="row" align="right">

            <?php info_box_one('info', 'envelope', 'كافة الرسائل', get_coun_order()) ?>
            <?php info_box_one('secondary', 'icon fas fa-home', 'بمكتب الإرسال', get_coun_wait_export()) ?>
            <?php info_box_one('dark', 'ambulance', 'مسلم للسائق', get_coun_recev_driver_export()) ?>
            <?php info_box_one('primary', 'truck', 'في الطريق', get_coun_export()) ?>


        </div>

        <div class="row" align="right">

           
            <?php info_box_one('warning', 'copy', 'مسلم لموظف التسلم', get_coun_wait_import()) ?>
            <?php info_box_one('info', 'building', 'في مكتب التسليم', get_coun_import()) ?>
            <?php info_box_one('success', 'check', 'مكتمل', get_coun_compliat()) ?>
            <?php info_box_one('danger', 'x', 'الرسائل الملغية', get_count_stop()) ?>

        </div>
        
            <!-- get all messge-->
            <?php
                get_mess_info();

                ?>
       



        <!-- /.row -->


    </div>

</section>
<!-- /.content -->



<?php
include "footer.php";
?>