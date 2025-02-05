<?php
include "../db.php";

// تحقق من صحة الاتصال بقاعدة البيانات
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}




//for add product for the department and cato

if (isset($_POST['pro_depart'])) {
  //for add product for the department and cato

  // استخراج الرقم المدخل من قبل المستخدم

  $id_depart = mysqli_real_escape_string($con, $_POST['pro_depart']);

  $cat;
  $id_cat;

  // استخدام prepared statements لتجنب هجمات SQL injection
  $sql_cat_depart = mysqli_prepare($con, "SELECT `cat_id`,`cat_title` FROM `categories` WHERE `depart_id`=?");
  mysqli_stmt_bind_param($sql_cat_depart, "i", $id_depart);
  mysqli_stmt_execute($sql_cat_depart);
  $run_sql_cat_depart = mysqli_stmt_get_result($sql_cat_depart);

  // تحقق من وجود بيانات المنتج وإرجاعها في صيغة JSON
  if (mysqli_num_rows($run_sql_cat_depart) > 0) {
    while (list($id_cat_m, $cat_m) = mysqli_fetch_array($run_sql_cat_depart)) {
      $id_cat[] = $id_cat_m;
      $cat[] = $cat_m;
    }
  } else {
    $id_cat = array('0');
    $cat = array('لايوجد اصناف');
  }

  $data = array(
    "cat_id" => implode(',', $id_cat),
    "cat_n" => implode(',', $cat)
  );
  echo json_encode($data);


  // إغلاق الاتصال بقاعدة البيانات
  mysqli_stmt_close($sql_cat_depart);
  mysqli_close($con);
}



//for add product for the  cat and size and items

if (isset($_POST['pro_cat'])) {
  //for add product for the department and cato

  // استخراج الرقم المدخل من قبل المستخدم

  $pro_cat = mysqli_real_escape_string($con, $_POST['pro_cat']);


  $id_size;
  $size_name;

  $id_items;
  $name_items;


  // استخدام prepared statements لتجنب هجمات SQL injection
  $sql_size_cat = mysqli_prepare($con, "SELECT `id_form`,`size` FROM `form_size` WHERE  `cat_fk_id`=?");
  mysqli_stmt_bind_param($sql_size_cat, "i", $pro_cat);
  mysqli_stmt_execute($sql_size_cat);
  $run_sql_size_cat = mysqli_stmt_get_result($sql_size_cat);

  // تحقق من وجود بيانات المنتج وإرجاعها في صيغة JSON
  if (mysqli_num_rows($run_sql_size_cat) > 0) {
    while (list($id_size_m, $size_m) = mysqli_fetch_array($run_sql_size_cat)) {
      $id_size[] = $id_size_m;
      $size_name[] = $size_m;
    }
  } else {
    $id_size = array('0');
    $size_name = array('لايوجد احجام');
  }






  //for add product for the  cat and items 
  // استخدام prepared statements لتجنب هجمات SQL injection
  $sql_item_cat = mysqli_prepare($con, "SELECT `id_ite_for`,`na_ite_fo` FROM `form_items_pro` WHERE `fk_cat_ite_for`=?");
  mysqli_stmt_bind_param($sql_item_cat, "i", $pro_cat);
  mysqli_stmt_execute($sql_item_cat);
  $run_sql_item_cat = mysqli_stmt_get_result($sql_item_cat);

  // تحقق من وجود بيانات المنتج وإرجاعها في صيغة JSON
  if (mysqli_num_rows($run_sql_item_cat) > 0) {
    while (list($id_item_m, $item_m) = mysqli_fetch_array($run_sql_item_cat)) {
      $id_items[] = $id_item_m;
      $name_items[] = $item_m;
    }
  } else {
    $id_items = array('0');
    $name_items = array('لايوجد فئات');
  }


  $data = array(
    "id_size" => implode(',', $id_size),
    "size_name" => implode(',', $size_name),
    "id_items" => implode(',', $id_items),
    "name_items" => implode(',', $name_items)
  );
  echo json_encode($data);


  // إغلاق الاتصال بقاعدة البيانات
  mysqli_stmt_close($sql_size_cat);
  mysqli_close($con);
}





//**************/ cod php for page user_data to even in chang or add user  \\**************\

if (isset($_POST['user_id_p'])) {
  // استخراج الرقم المدخل من قبل المستخدم

  $user_id_p = mysqli_real_escape_string($con, $_POST['user_id_p']);
  $messg_rutern = "0";


  // استخدام prepared statements لتجنب هجمات SQL injection
  $stmt = mysqli_prepare($con, "UPDATE `user` SET `user_state`='0' WHERE `user_id`= ?");
  mysqli_stmt_bind_param($stmt, "i", $user_id_p);
  // تحقق من وجود بيانات المنتج وإرجاعها في صيغة JSON
  if (mysqli_stmt_execute($stmt)) {
    $messg_rutern = "1";
    $data = array(
      "messg" => $messg_rutern
    );
    echo json_encode($data);

    // إغلاق الاتصال بقاعدة البيانات
    mysqli_stmt_close($stmt);
    mysqli_close($con);
  } else {
    $data = array(
      "messg" => $messg_rutern
    );
    echo json_encode($data);
    // إغلاق الاتصال بقاعدة البيانات
    mysqli_stmt_close($stmt);
    mysqli_close($con);
  }
}

if (isset($_POST['id_pro'])) {
  // استخراج الرقم المدخل من قبل المستخدم

  $studentu = mysqli_real_escape_string($con, $_POST['id_pro']);
  $comid = mysqli_real_escape_string($con, $_POST['comid']);
  $product;
  $price;
  $size;
  $id_size;

  // استخدام prepared statements لتجنب هجمات SQL injection
  $stmt = mysqli_prepare($con, "SELECT `product_title`,price-opponent as fin_price FROM `product` WHERE `status_pro`!=0 AND `product_id` = ? AND `com_id`= ?  ;");
  mysqli_stmt_bind_param($stmt, "ii", $studentu,$comid);
  //  mysqli_stmt_bind_param($stmt, "i", $comid);
  mysqli_stmt_execute($stmt);
  $sel_pro_pric = mysqli_stmt_get_result($stmt);
  if (mysqli_num_rows($sel_pro_pric) > 0) {
    $sel_pri = mysqli_fetch_array($sel_pro_pric);
    $product = $sel_pri['product_title'];
    $price = $sel_pri['fin_price'];
  } else {
    $product = array('لايوجد منتج بهاذا الرقم');
    $price = array('0');
  }
  // استخدام prepared statements لتجنب هجمات SQL injection
  $size_p = mysqli_prepare($con, "SELECT `id_size_pro`,`name_size`,product.product_id FROM product LEFT JOIN size_product ON product.product_id=size_product.fk_id_pro  WHERE size_product.size_status!=0 AND  size_product.fk_id_pro =?");
  mysqli_stmt_bind_param($size_p, "i", $studentu);
  mysqli_stmt_execute($size_p);
  $sel_pro_size = mysqli_stmt_get_result($size_p);

  // تحقق من وجود بيانات المنتج وإرجاعها في صيغة JSON
  if (mysqli_num_rows($sel_pro_size) > 0) {
    while (list($id_size_m, $size_m) = mysqli_fetch_array($sel_pro_size)) {
      $id_size[] = $id_size_m;
      $size[] = $size_m;
    }
  } else {
    $id_size = array('0');
    $size = array('لايوجد قياسات');
  }
  // تحقق من وجود بيانات المنتج وإرجاعها في صيغة JSON
  if (mysqli_num_rows($sel_pro_pric) > 0) {

    $data = array(
      "product" => $product,
      "price" => $price,
      "size_id" => implode(',', $id_size),
      "size_n" => implode(',', $size)
    );
    echo json_encode($data);

    // إغلاق الاتصال بقاعدة البيانات
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($size_p);
    mysqli_close($con);
  } else {
    echo "product not found";
    // إغلاق الاتصال بقاعدة البيانات
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($size_p);
    mysqli_close($con);
  }
}



