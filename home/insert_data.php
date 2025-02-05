<?php
include "../db.php";

session_start();


$user_id_use_the_web = osamah_decrypt_inser($_SESSION['id_user']);
$branch_id_use_the_web = osamah_decrypt_inser($_SESSION['publi_fk_id_branch']);
$dates = date('Y-m-d');



function osamah_decrypt_inser($ciphertext)
{
    $key = 'Osamah_qader_NajeAbdullahShahrah';
    // فك تشفير البيانات
    $ivlen = openssl_cipher_iv_length('AES-256-CBC');
    $decoded = base64_decode($ciphertext);
    $iv = substr($decoded, 0, $ivlen);
    $ciphertext = substr($decoded, $ivlen);
    $originalData = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

    // تحويل البيانات المشفرة إلى JSON
    $data = json_decode($originalData, true);

    return $data;
}

// Function to decrypt data
function decrypt_id_inser($encoded_id)
{
    return base64_decode($encoded_id);
}

function upload_image($path, $button_name)
{
    //$pic="1.png";
    if (isset($_POST[$button_name])) {
        //picture coding for git data about the pictuer
        $picture_name = $_FILES['picture']['name']; //اضافة صورة للمنتج هنا يتم حفظ الاسم
        $picture_type = $_FILES['picture']['type']; //نوع الصورة
        $picture_tmp_name = $_FILES['picture']['tmp_name']; //ملف مؤقت خاص بالصورة
        $picture_size = $_FILES['picture']['size']; //حجم الصورة
        if ($picture_name != "" & $picture_type != "") {
            if ($picture_size < 500000) {
                //code take name file and search . and tak after that
                $type = strrchr($picture_name, '.');
                $pic_name =  uniqid() . "_" . time() . $picture_type; //rename the file for dont replucation the data and rename use id_naem_time.data type 
                move_uploaded_file($picture_tmp_name, $path . $pic_name); //upload the image for the folder
                return $pic_name;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
//cod fun to get random number by the number send it
function generateRandomNumber($length = 10)
{
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= rand(0, 9); // توليد رقم عشوائي بين 0 و 9
    }
    return $result;
}





//this code to add or updata user used in page mange_user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user_or_updata'])) {
        $id_user = mysqli_real_escape_string($con,$_POST['id_user']);
        $name = mysqli_real_escape_string($con,$_POST['name']);
        $Email = mysqli_real_escape_string($con,$_POST['Email']);
        $password_user = password_hash(mysqli_real_escape_string($con, $_POST['password_user']), PASSWORD_DEFAULT);
        if($branch_id_use_the_web ==4){
        $branch = mysqli_real_escape_string($con,$_POST['branch_user']);
        }
        else{
            $branch = $branch_id_use_the_web ;
        }
        $user_phone =mysqli_real_escape_string($con, $_POST['user_phone']);
        $job_type = mysqli_real_escape_string($con,$_POST['job_type']);
        $user_note = mysqli_real_escape_string($con,$_POST['user_note']);
        $details_job = mysqli_real_escape_string($con,$_POST['details_job']);


        $path = "../img/img_user/";
        $button_name = "add_user_or_updata";
        //$picture_name = upload_image($path, $button_name);

        $pic = '1.png';



        if ($id_user > 0) {
            // Update existing user
            $sql = "UPDATE `users` SET 
                    `name` = ?,
                    `email_user` = ?,
                    `password_user` = ?,
                    `fk_branch` = ?,
                    `user_phone` = ?,
                    `user_job` = ?,
                    `user_note` = ?,
            `details_job` = ?";



            $sql .= " WHERE `id_user` = ?";

            $stmt = mysqli_prepare($con, $sql);


            mysqli_stmt_bind_param($stmt, "sssisissi", $name, $Email, $password_user, $branch, $user_phone, $job_type, $user_note, $details_job, $id_user);



            if (mysqli_stmt_execute($stmt)) {
                header("location:kiji");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        } else {
            $sql = "INSERT INTO `users` (`name`, `user_phone`, `email_user`, `password_user`, `user_job`, `details_job`, `user_note`, `fk_branch`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $sql);

            // Assuming you have appropriate variables for each field
            mysqli_stmt_bind_param($stmt, "ssssissi", $name, $user_phone, $Email, $password_user, $job_type, $details_job, $user_note, $branch);
            if (mysqli_stmt_execute($stmt)) {
                header("location:kiji");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        }
    }
}



//this code to  updata user profail in page my_profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['chang_data'])) {
        $id_user = osamah_decrypt_inser($_SESSION['id_user']);
        $Email = mysqli_real_escape_string($con,$_POST['Email']);
        $password_user = password_hash(mysqli_real_escape_string($con, $_POST['password_user']), PASSWORD_DEFAULT);
        $user_phone =mysqli_real_escape_string($con, $_POST['user_phone']);
        if ($id_user > 0) {
            if (empty($_FILES['picture']['name'])) {
                // Update user without picture change
                $sql = "UPDATE `users` SET 
                    `email_user` = ?,
                    `password_user` = ?,
                    `user_phone` = ?
                  WHERE `id_user` = ?";

                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "sssi", $Email, $password_user, $user_phone, $id_user);
            } else {
                // Validate image (adjust limits and allowed types as needed)
                $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
                if (in_array($_FILES['picture']['type'], $allowed_types) && $_FILES['picture']['size'] <= 5000000) {
                    $type = substr($_FILES['picture']['name'], strrpos($_FILES['picture']['name'], '.'));
                    $pic_name = $id_user . "_" . time() . $type;
                    $upload_path = "../img/img_user/" . $pic_name;

                    // Upload image
                    if (move_uploaded_file($_FILES['picture']['tmp_name'], $upload_path)) {

                        $sql = "UPDATE `users` SET 
                        `email_user` = ?,
                        `password_user` = ?,
                        `img_user` = ?,
                        `user_phone` = ?
                      WHERE `id_user` = ?";

                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($stmt, "ssssi", $Email, $password_user, $pic_name, $user_phone, $id_user);
                    } else {
                        // Handle upload error
                        echo "Error uploading image.";
                    }
                } else {
                    // Handle invalid image type or size
                    echo "Invalid image type or size. Please upload a JPEG, JPG, PNG, or GIF image less than 5MB.";
                }
            }

            // Execute and handle query execution
            if ($stmt) {
                if (mysqli_stmt_execute($stmt)) {
                    header("location:my");
                } else {
                    echo "Error updating user: " . mysqli_error($con);
                }
            } else {
                echo "Error preparing statement.";
            }

            mysqli_stmt_close($stmt); // Close prepared statement (if used)
        } // End if ($id_user > 0)


    }
}



//this code to  or updata user used in page myaccount
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn_save_data_profile'])) {


        $id_system = 1;
        $name_system = mysqli_real_escape_string($con,$_POST['name_system']);
        $Email = mysqli_real_escape_string($con,$_POST['Email']);
        $phon_number = mysqli_real_escape_string($con,$_POST['phon_number']);
        $address = mysqli_real_escape_string($con,$_POST['address']);
        $whatsapp = mysqli_real_escape_string($con,$_POST['whatsapp']);
        $telegram = mysqli_real_escape_string($con,$_POST['telegram']);
        $website_system = mysqli_real_escape_string($con,$_POST['website_system']);
        $instagram = mysqli_real_escape_string($con,$_POST['instagram']);
        $facebook = mysqli_real_escape_string($con,$_POST['facebook']);
        $twitter = mysqli_real_escape_string($con,$_POST['twitter']);
        $linkedin = mysqli_real_escape_string($con,$_POST['linkedin']);
        $about_system = mysqli_real_escape_string($con,$_POST['about_system']);
        $updata_date = date("Y-m-d H:i:s");
        $fk_user_chang = osamah_decrypt_inser($_SESSION['id_user']);


        $picture_name = $_FILES['picture']['name'];
        $picture_type = $_FILES['picture']['type'];
        $picture_tmp_name = $_FILES['picture']['tmp_name'];
        $picture_size = $_FILES['picture']['size'];


        if (empty($_FILES['picture']['name'])) {
            // Update user without picture change
            $sql = "UPDATE `system_info` SET 
                    `name_system` = ?,
                    `Email` = ?,
                    `phon_number` = ?,
                    `address` = ?,
                    `whatsapp` = ?,
                    `telegram` = ?,
                    `website_system` = ?,
                    `instagram` = ?,
                    `facebook` = ?,
                    `twitter` = ?,
                    `linkedin` = ?,
                    `about_system` = ?,
                    `updata_date` = ?,
                    `fk_user_chang` = ?
                    
                  WHERE `id_system` = ?";

            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                "sssssssssssssii",
                $name_system,
                $Email,
                $phon_number,
                $address,
                $whatsapp,
                $telegram,
                $website_system,
                $instagram,
                $facebook,
                $twitter,
                $linkedin,
                $about_system,
                $updata_date,
                $fk_user_chang,
                $id_system
            );
        } else {
            // Validate image (adjust limits and allowed types as needed)
            $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
            if (in_array($_FILES['picture']['type'], $allowed_types) && $_FILES['picture']['size'] <= 5000000) {
                $type = substr($_FILES['picture']['name'], strrpos($_FILES['picture']['name'], '.'));
                $pic_name = $id_system . "_" . time() . $type;
                $upload_path = "../img/web_img/" . $pic_name;

                // Upload image
                if (move_uploaded_file($_FILES['picture']['tmp_name'], $upload_path)) {

                    $sql = "UPDATE `system_info` SET 
                    `name_system` = ?,
                    `Email` = ?,
                    `phon_number` = ?,
                    `address` = ?,
                    `icon_system` = ?,
                    `whatsapp` = ?,
                    `telegram` = ?,
                    `website_system` = ?,
                    `instagram` = ?,
                    `facebook` = ?,
                    `twitter` = ?,
                    `linkedin` = ?,
                    `about_system` = ?,
                    `updata_date` = ?,
                    `fk_user_chang` = ?
                    
                  WHERE `id_system` = ?";

                    $stmt = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param(
                        $stmt,
                        "ssssssssssssssii",
                        $name_system,
                        $Email,
                        $phon_number,
                        $address,
                        $pic_name,
                        $whatsapp,
                        $telegram,
                        $website_system,
                        $instagram,
                        $facebook,
                        $twitter,
                        $linkedin,
                        $about_system,
                        $updata_date,
                        $fk_user_chang,
                        $id_system
                    );
                } else {
                    // Handle upload error
                    echo "Error uploading image.";
                }
            } else {
                // Handle invalid image type or size
                echo "Invalid image type or size. Please upload a JPEG, JPG, PNG, or GIF image less than 5MB.";
            }
        }

        // Execute and handle query execution
        if ($stmt) {
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                echo "Error updating user: " . mysqli_error($con);
            }
        } else {
            echo "Error preparing statement.";
        }

        mysqli_stmt_close($stmt);
    }
}







//this code  change  user state stop or turn on used in page mange_user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['stop_user'])) {
        $id_user_stop_stat =mysqli_real_escape_string($con, $_POST['id_user_stop_stat']);
        $stop_user_stat =mysqli_real_escape_string($con, $_POST['stop_user_stat']);



        $sql_updata_user_stope = "UPDATE `users` SET `status`=? WHERE `id_user`=?  ;";
        $stmt_updata_user_stope = mysqli_prepare($con, $sql_updata_user_stope);
        mysqli_stmt_bind_param($stmt_updata_user_stope, "ii", $stop_user_stat, $id_user_stop_stat);

        if (mysqli_stmt_execute($stmt_updata_user_stope)) {
            header("Location:kiji");

    }
}
}





//this code  change  user permissoin for pages state stop or turn on used in page mange_permission

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_per_file'])) {
        // Sanitize input
        $stop_pre_stat = mysqli_real_escape_string($con, $_POST['stop_pre_stat']);
        $id_page_per = mysqli_real_escape_string($con, $_POST['id_page_stat']);
        $id_user_stat = mysqli_real_escape_string($con, $_POST['id_user_stat']);
        // Check if the user permission already exists
        $sql_search_user_per_file = "SELECT * FROM `pages_permission` WHERE `fk_user_id` = ? AND `fk_page_id` = ?";
        $stmt_search_user_per_file = mysqli_prepare($con, $sql_search_user_per_file);
        mysqli_stmt_bind_param($stmt_search_user_per_file, "ii", $id_user_stat, $id_page_per);

        if (mysqli_stmt_execute($stmt_search_user_per_file)) {
            $result = mysqli_stmt_get_result($stmt_search_user_per_file);

            if (mysqli_num_rows($result) > 0) {
                // Update existing permission
                $sql_update_user_per_file = "UPDATE `pages_permission` SET `user_pages_status` = ? WHERE `fk_user_id` = ? AND `fk_page_id` = ?";
                $stmt_update_user_per_file = mysqli_prepare($con, $sql_update_user_per_file);
                mysqli_stmt_bind_param($stmt_update_user_per_file, "iii", $stop_pre_stat, $id_user_stat, $id_page_per);

                if (mysqli_stmt_execute($stmt_update_user_per_file)) {
                    header("Location:llokikl");
                    exit;
                } else {
                    echo "Error updating user permission: " . mysqli_error($con);
                }
            } else {
                // Insert new permission
                $sql_insert_user_per_file = "INSERT INTO `pages_permission`(`fk_user_id`, `fk_page_id`, `user_pages_status`) VALUES (?, ?, '1')";
                $stmt_insert_user_per_file = mysqli_prepare($con, $sql_insert_user_per_file);
                mysqli_stmt_bind_param($stmt_insert_user_per_file, "ii", $id_user_stat, $id_page_per);

                if (mysqli_stmt_execute($stmt_insert_user_per_file)) {
                    header("Location:llokikl");
                    exit;
                } else {
                    echo "Error inserting user permission: " . mysqli_error($con);
                }
            }
        } else {
            echo "Error searching for user permission: " . mysqli_error($con);
        }
    } else {
        echo "Required data missing.";
    }
} else {
    echo "Invalid request method.";
}



//this code to add or updata currency in page myaccount
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_updata_currency'])) {
        //$id_currency=0;
        $id_currency = mysqli_real_escape_string($con, $_POST['id_currency_tab']);
        $name_currency = mysqli_real_escape_string($con, $_POST['name_currency_tab']);
        $nic_currency = mysqli_real_escape_string($con, $_POST['detil_currency_tab']);
        if ($id_currency > 0) {
            // Update existing user 
            $sql = "UPDATE `currency_tab` SET 
                    `name_currency` = ?,
                    `nic_currency` = ?  WHERE `id_currency` = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $name_currency, $nic_currency, $id_currency);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        } else {
            $sql = "INSERT INTO `currency_tab` (`name_currency`, `nic_currency`) 
        VALUES (?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            // Assuming you have appropriate variables for each field
            mysqli_stmt_bind_param($stmt, "ss", $name_currency, $nic_currency);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        }
    }
}

//this code to add or updata jobs_table in page myaccount
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_updata_jobs_table'])) {
        $job_id = mysqli_real_escape_string($con, $_POST['id_jobs_table']);
        $job_name = mysqli_real_escape_string($con, $_POST['name_jobs_table']);
        $job_details = mysqli_real_escape_string($con, $_POST['detil_jobs_table']);
        if ($job_id > 0) {
            // Update existing user
            $sql = "UPDATE `jobs_table` SET 
                    `job_name` = ?,
                    `job_details` = ? 
                     WHERE `job_id` = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $job_name, $job_details, $job_id);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        } else {
            $sql = "INSERT INTO `jobs_table` (`job_name`, `job_details`) 
        VALUES (?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            // Assuming you have appropriate variables for each field
            mysqli_stmt_bind_param($stmt, "ss", $job_name, $job_details);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        }
    }
}


//this code to add or updata mess_type in page myaccount
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_updata_mess_type'])) {
        $id_mess = mysqli_real_escape_string($con, $_POST['id_mess_type']);
        $name_mess = mysqli_real_escape_string($con, $_POST['name_mess_type']);
        $mess_type_details = mysqli_real_escape_string($con, $_POST['detil_mess_type']);
        if ($id_mess > 0) {
            // Update existing user
            $sql = "UPDATE `mess_type` SET 
                    `name_mess` = ?,
                    `mess_type_details` = ? 
                     WHERE `id_mess` = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $name_mess, $mess_type_details, $id_mess);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        } else {
            $sql = "INSERT INTO `mess_type` (`name_mess`, `mess_type_details`) 
        VALUES (?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            // Assuming you have appropriate variables for each field
            mysqli_stmt_bind_param($stmt, "ss", $name_mess, $mess_type_details);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        }
    }
}


//this code to add or updata size_items in page myaccount
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_updata_size_items'])) {
        $add_updata_size_items = mysqli_real_escape_string($con, $_POST['id_size_items']);
        $name_size_items = mysqli_real_escape_string($con, $_POST['name_size_items']);
        $detil_size_items = mysqli_real_escape_string($con, $_POST['detil_size_items']);
        if ($add_updata_size_items > 0) {
            // Update existing user
            $sql = "UPDATE `size_items` SET 
                    `name_size` = ?,
                    `detiles_size` = ? 
                     WHERE `id_size_items` = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $name_size_items, $detil_size_items, $add_updata_size_items);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        } else {
            $sql = "INSERT INTO `size_items` (`name_size`, `detiles_size`) 
        VALUES (?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            // Assuming you have appropriate variables for each field
            mysqli_stmt_bind_param($stmt, "ss", $name_size_items, $detil_size_items);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        }
    }
}



//this code to add or updata branch in page myaccount
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_updata_branch'])) {
        $id_branch = mysqli_real_escape_string($con, $_POST['id_branch']);
        $name_branch = mysqli_real_escape_string($con, $_POST['name_branch']);
        $address_branch = mysqli_real_escape_string($con, $_POST['detil_branch']);
        if ($id_branch > 0) {
            // Update existing user
            $sql = "UPDATE `branch` SET 
                    `name_branch` = ?,
                    `address_branch` = ? 
                     WHERE `id_branch` = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $name_branch, $address_branch, $id_branch);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        } else {
            $sql = "INSERT INTO `branch` (`name_branch`, `address_branch`) 
        VALUES (?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            // Assuming you have appropriate variables for each field
            mysqli_stmt_bind_param($stmt, "ss", $name_branch, $address_branch);
            if (mysqli_stmt_execute($stmt)) {
                header("location:nnnnnkug");
            } else {
                // Handle error (e.g., log error, display error message)
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        }
    }
}








function customer($name, $pho, $card_id, $card_imag, $whatsapp, $note, $cus_type, $cus_add)
{
    include '../db.php';

    // Securely prepare and bind parameters
    $sql = "SELECT id_customer FROM customer WHERE cus_name = ? AND cus_phone = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $name, $pho);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if customer exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['id_customer'];
    } else {
        // Prepare and bind parameters for the INSERT query

        $sql = "INSERT INTO customer (cus_name, cus_phone, cus_id_card, cus_card_img, cus_whatsapp, cus_type, cus_address, cus_note) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssississ", $name, $pho, $card_id, $card_imag, $whatsapp, $cus_type, $cus_add, $note);

        // Execute the INSERT query and handle errors
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($con); // Return the inserted ID
        } else {
            // Log the error for debugging
            error_log("Error inserting customer: " . mysqli_error($con));
            return false;
        }
    }
}

function customer_updata($card_id, $card_imag, $whatsapp, $note, $cus_type, $cus_add, $id_customer)
{
    include '../db.php';




    // Prepare and bind parameters for the INSERT query

    $sql = "UPDATE `customer` SET `cus_id_card`=?,`cus_card_img`=?,`cus_whatsapp`=?,`cus_type`=?,`cus_address`=?,`cus_note`=? WHERE `id_customer`=?  ;";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $card_id, $card_imag, $whatsapp, $cus_type, $cus_add, $note, $id_customer);

    // Execute the INSERT query and handle errors
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        // Log the error for debugging
        error_log("Error inserting customer: " . mysqli_error($con));
        return false;
    }
}









//this code to insert or updata order used in page send_me
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['operation_name'])) {





        $id_order = 0;
        $id_order = osamah_decrypt_inser($_POST['edit_id_order']);
        $pic_name = '1.png';
        static $pic_name_ords = '';


        $fk_id_branch_sender = osamah_decrypt_inser($_SESSION['publi_fk_id_branch']);
        $id_user = osamah_decrypt_inser($_SESSION['id_user']);

        //data sender
        $sender_name = isset($_POST['sender_name']);
        $sender_phone = isset($_POST['sender_phone']);
        $cus_sen_id_c = isset($_POST['cus_sen_id_card']);

        $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
        if (isset($_FILES['sender_imag_card']['name'])) {
            if (in_array($_FILES['sender_imag_card']['type'], $allowed_types) && $_FILES['sender_imag_card']['size'] <= 5000000) {
                $type = substr($_FILES['sender_imag_card']['name'], strrpos($_FILES['sender_imag_card']['name'], '.'));
                $pic_name = $sender_phone . "_" . time() . $type;
                $upload_path = "../img/id_card/" . $pic_name;


                move_uploaded_file($_FILES['sender_imag_card']['tmp_name'], $upload_path);
            }
        }


        $cus_send_whatsapp = isset($_POST['cus_send_whatsapp']);
        $sen_note = isset($_POST['sen_note']);
        $cust_type1 = 1;


        if (isset($_POST['sender_name'])) {
            $id_sender = customer($sender_name, $sender_phone, $cus_sen_id_c, $pic_name, $cus_send_whatsapp, $sen_note, $cust_type1, '');
            //end data sender and take id customer
        }
        // data recev data 
        $cust_type2 = 2;
        $recipient_name = mysqli_real_escape_string($con, $_POST['recipient_name']);
        $recipient_phone = mysqli_real_escape_string($con, $_POST['recipient_phone']);
        $cus_rec_address = mysqli_real_escape_string($con, $_POST['cus_rec_address']);
        $cus_rec_note = mysqli_real_escape_string($con, $_POST['rec_note']);
        $id_recev = customer($recipient_name, $recipient_phone, '', '', '', $cus_rec_note, $cust_type2, $cus_rec_address);

        //end

        //data transport 
        $gov = mysqli_real_escape_string($con, $_POST['gov']);
        $fk_id_branch_recipient = mysqli_real_escape_string($con, $_POST['id_branch_rec']);
        $verify_message = mysqli_real_escape_string($con, $_POST['verify_message']);
        $money_received = mysqli_real_escape_string($con, $_POST['money_received']);


        if (isset($_FILES['receive_image_sender']['name'])) {
            if (in_array($_FILES['receive_image_sender']['type'], $allowed_types) && $_FILES['receive_image_sender']['size'] <= 5000000) {
                $type = substr($_FILES['receive_image_sender']['name'], strrpos($_FILES['receive_image_sender']['name'], '.'));
                $pic_name_ord = $recipient_phone . "_" . time() . $type;

                // تنظيف اسم الملف
                $pic_name_ord = preg_replace('/[^A-Za-z0-9_\-.]/', '', $pic_name_ord);

                $upload_path = "../img/order/" . $pic_name_ord;

                // التحقق من الأخطاء أثناء الرفع
                if ($_FILES['receive_image_sender']['error'] === UPLOAD_ERR_OK) {
                    move_uploaded_file($_FILES['receive_image_sender']['tmp_name'], $upload_path);
                }
            }
        }
        $order_note = mysqli_real_escape_string($con, $_POST['order_note']);



        if ($verify_message == 'on') {
            $verify_message = 1;
        } else {
            $verify_message = 0;
        }

        //end

        //data items for the message
        $items = json_decode($_POST['items'], true);







        if ($id_order > 0) {

            if (isset($_FILES['receive_image_sender']['size'])) {

                $sql_updata_order = "UPDATE `order` SET `gov`=?,
                    `custom_id_recipient`=?,
                    `money_received`=?,
                    `verify_message`=?,
                    `fk_id_branch_recipient`=?,
                    `order_note`=?,
                    `receive_image_sender`=?
                     WHERE `id_order`=?";

                $stmt = mysqli_prepare($con, $sql_updata_order);
                mysqli_stmt_bind_param($stmt, "sidiissi", $gov, $id_recev, $money_received, $verify_message, $fk_id_branch_recipient, $order_note, $pic_name_ord, $id_order);

                if (!mysqli_stmt_execute($stmt)) {
                    die("Error in INSERT order_item: " . mysqli_error($con));
                }
            } else {
                $sql_updata_order = "UPDATE `order` SET `gov`=?,
            `custom_id_recipient`=?,
            `money_received`=?,
            `verify_message`=?,
            `fk_id_branch_recipient`=?,
            `order_note`=?
            
             WHERE `id_order`=?";

                $stmt = mysqli_prepare($con, $sql_updata_order);
                mysqli_stmt_bind_param($stmt, "sidiisi", $gov, $id_recev, $money_received, $verify_message, $fk_id_branch_recipient, $order_note, $id_order);

                if (!mysqli_stmt_execute($stmt)) {
                    die("Error in INSERT order_item: " . mysqli_error($con));
                }
            }

            $stmt_items = mysqli_prepare($con, "INSERT INTO `order_item`(`fk_order`, `item_type`, `weight_item`, `cost_message`, `item_details`) VALUES (?,?,?,?,?)");
            foreach ($items as $item) {
                $name_mess_types = $item['name_mess_types'];
                $weight_items = $item['weight_items'];
                $cost_messages = $item['cost_messages'];
                $item_detailss = $item['item_detailss'];
                mysqli_stmt_bind_param($stmt_items, "iiids", $id_order, $name_mess_types, $weight_items, $cost_messages, $item_detailss);

                if (!mysqli_stmt_execute($stmt_items)) {
                    die("Error in INSERT order_item: " . mysqli_error($con));
                }
            }

            $sql_quer_usert = "SELECT `id_order` FROM `order` o JOIN `order_item` it ON o.id_order=it.fk_order WHERE o.custom_id_sender!=0 AND o.custom_id_recipient!=0 AND o.verify_message=1   AND o.fk_id_branch_recipient!=0  AND o.fk_id_branch_recipient !=? AND o.id_order= ? ;";
            $stmt_select = mysqli_prepare($con, $sql_quer_usert);
            mysqli_stmt_bind_param($stmt_select, "ii", $fk_id_branch_sender, $id_order);
            mysqli_stmt_execute($stmt_select);

            $result_select = mysqli_stmt_get_result($stmt_select);
            if (mysqli_num_rows($result_select) > 0) {

                $sql = " UPDATE `order` SET  `check_receipt_sender`='1' WHERE `id_order`= ? ";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id_order);
                mysqli_stmt_execute($stmt);
                header("location:llop");
            } else {
                // Handle error (e.g., log error, display error message)
                echo mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
        } else {

            // إدخال بيانات الرسالة
            $stmt_inse_ord = mysqli_prepare($con, "INSERT INTO `order`(`gov`, `custom_id_sender`, `custom_id_recipient`, `money_received`, `user_id_receipt_sender`,`verify_message`, `fk_id_branch_sender`, `fk_id_branch_recipient`, `order_note`, `receive_image_sender`) VALUES (?,?,?,?,?,?,?,?,?,?)");
            mysqli_stmt_bind_param($stmt_inse_ord, "siidiiiiss", $gov, $id_sender, $id_recev, $money_received, $id_user, $verify_message, $fk_id_branch_sender, $fk_id_branch_recipient, $order_note, $pic_name_ord);



            if (!mysqli_stmt_execute($stmt_inse_ord)) {
                die("Error in INSERT order: " . mysqli_error($con));
            }


            // الحصول على رقم الرسالة (رقم الإضافة التلقائي)
            $message_number = mysqli_insert_id($con);
            // mysqli_stmt_close($stmt_inse_ord);
            // إدخال عناصر الرسالة
            $stmt_items = mysqli_prepare($con, "INSERT INTO `order_item`(`fk_order`, `item_type`, `weight_item`, `cost_message`, `item_details`) VALUES (?,?,?,?,?)");
            foreach ($items as $item) {
                $name_mess_types = $item['name_mess_types'];
                $weight_items = $item['weight_items'];
                $cost_messages = $item['cost_messages'];
                $item_detailss = $item['item_detailss'];
                mysqli_stmt_bind_param($stmt_items, "iiids", $message_number, $name_mess_types, $weight_items, $cost_messages, $item_detailss);
                if (!mysqli_stmt_execute($stmt_items)) {
                    die("Error in INSERT order_item: " . mysqli_error($con));
                }
                //mysqli_stmt_close($stmt_items);
            }



            //$sql_quer_usert = "SELECT `id_order` FROM `order` o JOIN `order_item` it ON o.id_order=it.fk_order 
            //WHERE o.custom_id_sender!=0 AND o.custom_id_recipient!=0 AND o.verify_message=1   
            //AND o.fk_id_branch_recipient!=0 AND o.check_receipt_sender=0 AND o.fk_id_branch_recipient!=? AND o.id_order= ? ;";
            //$stmt_qu_or = mysqli_prepare($con, $sql_quer_usert);
            //mysqli_stmt_bind_param($stmt_qu_or, "ii",$fk_id_branch_sender, $message_number);
            //mysqli_stmt_execute($stmt_qu_or);

            $randomString = generateRandomNumber(10);
            $QR = $message_number . "0" . $randomString;

            //echo "message_number".$message_number;
            //echo "fk_id_branch_sender".$fk_id_branch_sender;
            //echo "randomString".$randomString;
            //echo "QR".$QR;
            $sql_check = " UPDATE `order` SET  `check_receipt_sender`=1,`QR`=? WHERE `id_order`=? ";
            $stmt_check = mysqli_prepare($con, $sql_check);
            mysqli_stmt_bind_param($stmt_check, "si", $QR, $message_number);
            if (!mysqli_stmt_execute($stmt_check)) {
                die("Error in UPDATE order: " . mysqli_error($con));
            }
            echo "1";



            mysqli_stmt_close($stmt_inse_ord);
            //mysqli_stmt_close($stmt_qu_or);
            mysqli_stmt_close($stmt_check);
        }
    }
}



//this code use to give the mess for driver  used in page mes_export
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['driver_mess'])) {

        $id_mess_stat = mysqli_real_escape_string($con,$_POST['id_mess_stat']);
        $id_user_stat = mysqli_real_escape_string($con,$_POST['id_user_stat']);
        $user_id__export = osamah_decrypt_inser($_SESSION['id_user']);





        // Update user without picture change
        $sql = "UPDATE `order` SET `ch_ex_us_fri`=1,
            `user_id__export`=?,
            `fk_level_mess`=2,
            `fk_id_driver`=?,
             `date_export`=?
            WHERE `id_order`=?";



        $stmt_up_driv = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_up_driv, "iisi", $user_id__export, $id_user_stat, $dates, $id_mess_stat);


        if (mysqli_stmt_execute($stmt_up_driv)) {
            echo "success";
            
        } else {
            echo "Error updating user: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt_up_driv);
    }
}


//this code use to reject the mess from the driver  used in page Driver Receives
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reject_driver_mess'])) {
        $id_mess_stat = mysqli_real_escape_string($con,$_POST['id_mess_stat']);


        // Update user without picture change
        $sql = "UPDATE `order` SET `ch_ex_us_fri`=0,
            `check_export`=0,
            `user_id__export`=0,
            `fk_level_mess`=1,
            `fk_id_driver`=0
             WHERE `id_order`=? AND `fk_id_driver`=?";

        $stmt_up_driv = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_up_driv, "ii", $id_mess_stat, $user_id_use_the_web);


        if (mysqli_stmt_execute($stmt_up_driv)) {
            echo "success";
        } else {
            echo "Error updating : " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt_up_driv);
    }
}



//this code use to accept the mess from the driver  used in page Driver Receives
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept_driver_mess'])) {

        $id_mess_stat = mysqli_real_escape_string($con,$_POST['id_mess_stat']);



        $coast = 0;
        // Update user without picture change
        $sql = "UPDATE `order` SET `ch_ex_dri_sec`=1,
            `fk_level_mess`=3,
            `check_export`=1
             WHERE `id_order`=? AND `fk_id_driver`=?";

        $stmt_up_driv = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_up_driv, "ii", $id_mess_stat, $user_id_use_the_web);

        if (mysqli_stmt_execute($stmt_up_driv)) {
            $sql_quer_mess = "SELECT SUM(oi.cost_message)AS 'coast'
                                 FROM `order` o JOIN order_item oi ON o.id_order=oi.fk_order
                                  WHERE o.id_order=? AND o.fk_id_driver=? ";
            $stmt_mess_sho = mysqli_prepare($con, $sql_quer_mess);
            mysqli_stmt_bind_param($stmt_mess_sho, "ii", $id_mess_stat, $user_id_use_the_web);
            mysqli_stmt_execute($stmt_mess_sho);

            $result_mess_data = mysqli_stmt_get_result($stmt_mess_sho);
            while ($array_mess = mysqli_fetch_assoc($result_mess_data)) {

                $coast = $array_mess['coast'];
            }


            $sql_insert_data_shipping = "INSERT INTO `shipping`( `fk_order`, `fk_user`, `cost_ship`) VALUES (?,?,?) ;";

            $stmt_insert_shipping = mysqli_prepare($con, $sql_insert_data_shipping);
            mysqli_stmt_bind_param($stmt_insert_shipping, "iid", $id_mess_stat, $user_id_use_the_web, $coast);



            if (mysqli_stmt_execute($stmt_insert_shipping)) {
                echo "success";
            } else {
                echo "Error updating : " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt_insert_shipping);
        } else {
            echo "Error updating : " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt_up_driv);
    }
}





//this code use to export the mess from the driver to the branch used in page Delivery Driver
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['export_mess_to_bra'])) {

        $id_mess_stat = mysqli_real_escape_string($con,$_POST['id_mess_stat']);



        $sql = "UPDATE `order` SET `ch_imp_dri_fri`=1,
            `fk_level_mess`=4
            
             WHERE `id_order`=? AND `fk_id_driver`=?";

        $stmt_up_driv = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_up_driv, "ii", $id_mess_stat, $user_id_use_the_web);

        if (mysqli_stmt_execute($stmt_up_driv)) {
            echo "success";
        } else {
            echo "Error updating : " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt_up_driv);
    }
}



//this code use to export all the mess from the driver to the branch used in page Delivery Driver
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['export_all_mess_to_br'])) {

        $id_branch_select_for_all = mysqli_real_escape_string($con,$_POST['id_branch_select_for_all']);



        $sql_quer_mess = "SELECT o.id_order
                                 FROM `order` o JOIN `branch` j2 ON o.fk_id_branch_recipient=j2.id_branch JOIN order_item oi ON o.id_order=oi.fk_order
                                  WHERE `check_receipt_sender`=1 AND o.fk_level_mess=3  AND `status_order`=1 AND o.check_export=1
                                  AND o.fk_id_branch_recipient= ? AND o.fk_id_driver=?";
        $stmt_mess_sho = mysqli_prepare($con, $sql_quer_mess);
        mysqli_stmt_bind_param($stmt_mess_sho, "ii", $id_branch_select_for_all, $user_id_use_the_web);
        mysqli_stmt_execute($stmt_mess_sho);

        $result_mess_data = mysqli_stmt_get_result($stmt_mess_sho);
        while ($array_mess = mysqli_fetch_assoc($result_mess_data)) {




            $sql = "UPDATE `order` SET `ch_imp_dri_fri`=1,
            `fk_level_mess`=4
            
             WHERE `id_order`=? AND `fk_id_driver`=?";

            $stmt_up_driv = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt_up_driv, "ii", $array_mess['id_order'], $user_id_use_the_web);

            mysqli_stmt_execute($stmt_up_driv);
        }

        if (mysqli_stmt_execute($stmt_mess_sho)) {
            echo "success";
        } else {
            echo "Error updating : " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt_mess_sho);
    }
}





//this code use to reject the mess from the driver to the branch  used in page mes_import
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reject_branch_mess'])) {
        $id_mess_stat = mysqli_real_escape_string($con,$_POST['id_mess_stat']);


        // Update user without picture change
        $sql = "UPDATE `order` SET `ch_imp_dri_fri`=0,
            `ch_imp_us_sec`=0,
            `check_import`=0,
            `fk_level_mess`=3
             WHERE `id_order`=? AND `fk_id_branch_recipient`=?";

        $stmt_up_driv = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_up_driv, "ii", $id_mess_stat, $branch_id_use_the_web);


        if (mysqli_stmt_execute($stmt_up_driv)) {
            echo "success";
        } else {
            echo "Error updating : " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt_up_driv);
    }
}



//this code use to accept the mess from the driver to the branch used in page mes_import
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept_branch_mess'])) {

        $id_mess_stat = mysqli_real_escape_string($con,$_POST['id_mess_stat']);




        // Update user without picture change
        $sql = "UPDATE `order` SET `ch_imp_us_sec`=1,
            `check_import`=1,
            `user_id__import`=?,
            `fk_level_mess`=5,
            `date_import`=?
             WHERE `id_order`=? AND `fk_id_branch_recipient`=?";

        $stmt_up_driv = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt_up_driv, "isii", $user_id_use_the_web, $dates, $id_mess_stat, $branch_id_use_the_web);

        if (mysqli_stmt_execute($stmt_up_driv)) {

            echo "success";
        } else {
            echo "Error updating : " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt_up_driv);
    }
}





//this code  for delet item order for one item  used in page edit_send_me
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['ppernrmfnb'])) {
        $id_item = decrypt_id_inser($_GET['ppernrmfnb']);

        $sql_delet_item = "DELETE FROM `order_item` WHERE `id_item_order`= ? ;";
        $stmt1 = mysqli_prepare($con, $sql_delet_item);


        mysqli_stmt_bind_param($stmt1, 'i', $id_item);


        if ($stmt1) {

            if (mysqli_stmt_execute($stmt1)) {
                header("location:vbnjuhjk");
            } else {
                echo "Error delet item : " . mysqli_error($con);
            }
        } else {
            echo "Error preparing statement.";
        }

        mysqli_stmt_close($stmt1);
    }
}



//this code for delet items order for all items and order  used in page edit_send_me
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['UjsnBBneu'])) {
        $id_order = decrypt_id_inser($_GET['UjsnBBneu']);



        $sql_delete_order = "DELETE FROM `order` WHERE `id_order`= ? ;";

        $sql_delete_order_item = "DELETE FROM `order_item` WHERE `fk_order`= ? ;";


        $stmt1 = mysqli_prepare($con, $sql_delete_order);
        $stmt2 = mysqli_prepare($con, $sql_delete_order_item);
        mysqli_stmt_bind_param($stmt1, 'i', $id_order);
        mysqli_stmt_bind_param($stmt2, 'i', $id_order);

        if ($stmt1) {
            if (mysqli_stmt_execute($stmt1)) {
                if (mysqli_stmt_execute($stmt2)) {
                    header("location:vbnjuhjk");
                } else {
                    echo "Error delet item: " . mysqli_error($con);
                }
            } else {
                echo "Error delet order: " . mysqli_error($con);
            }
        } else {
            echo "Error preparing statement.";
        }

        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
    }
}






//this code to copmlite recev the mess & updata order and customer  used in page mes_delivery
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn_save_order'])) {


        $id_order = osamah_decrypt_inser($_POST['hhuji']);
        $pic_name = '1.png';
        $pic_name_ord = '1.png';


        // data recev data 
        $cust_type2 = 2;

        $recipient_id_c = mysqli_real_escape_string($con, $_POST['recipient_id_c']);
        $recipient_whatsapp = mysqli_real_escape_string($con, $_POST['recipient_whatsapp']);
        $recipient_address = mysqli_real_escape_string($con, $_POST['recipient_address']);
        $recipient_note = mysqli_real_escape_string($con, $_POST['recipient_note']);

        $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
        if (in_array($_FILES['img_recipient_id_c']['type'], $allowed_types) && $_FILES['img_recipient_id_c']['size'] <= 5000000) {
            $type = substr($_FILES['img_recipient_id_c']['name'], strrpos($_FILES['img_recipient_id_c']['name'], '.'));
            $pic_name = $recipient_phone . "_" . time() . $type;
            $upload_path = "../img/id_card/" . $pic_name;


            move_uploaded_file($_FILES['img_recipient_id_c']['tmp_name'], $upload_path);
        }
        $money_received = mysqli_real_escape_string($con, $_POST['paid']);
        $money_honesty = mysqli_real_escape_string($con, $_POST['1121ik7']);
        $order_not_recipient = mysqli_real_escape_string($con, $_POST['order_not_recipient']);

        if (in_array($_FILES['receive_image_recipient']['type'], $allowed_types) && $_FILES['receive_image_recipient']['size'] <= 5000000) {
            $type = substr($_FILES['receive_image_recipient']['name'], strrpos($_FILES['receive_image_recipient']['name'], '.'));
            $pic_name_ord = $id_order . "_" . time() . $type;

            // تنظيف اسم الملف
            $pic_name_ord = preg_replace('/[^A-Za-z0-9_\-.]/', '', $pic_name_ord);

            $upload_path = "../img/order/" . $pic_name_ord;

            // التحقق من الأخطاء أثناء الرفع
            if ($_FILES['receive_image_recipient']['error'] === UPLOAD_ERR_OK) {
                move_uploaded_file($_FILES['receive_image_recipient']['tmp_name'], $upload_path);
            }
        }


        $stmt_find_order = mysqli_prepare($con, "SELECT `custom_id_recipient`,`money_received` FROM `order` WHERE `id_order`= ? ;");
        mysqli_stmt_bind_param($stmt_find_order, "i", $id_order);
        mysqli_stmt_execute($stmt_find_order);
        $result_find_order = mysqli_stmt_get_result($stmt_find_order);
        $row_find_order = mysqli_fetch_assoc($result_find_order);


        if (customer_updata($recipient_id_c, $pic_name, $recipient_whatsapp, $recipient_note, $cust_type2, $recipient_address, $row_find_order['custom_id_recipient'])) {
            // بدء المعاملة
            $con->begin_transaction();
            $money = $row_find_order['money_received'];
            $money += $money_received;
            try {

                $sql_updata_order = "UPDATE `order` SET `check_receipt_recipient`=1,
                `user_id__receipt_recipient`=?,
                `order_not_recipient`=?,
                `receive_image_recipient`=?,
                `fk_level_mess`=6,
                `date_of_receipt_recipient`=?,
                `money_received`=?,
                `money_honesty`=?
                 WHERE `id_order`=? ;";

                $stmt = mysqli_prepare($con, $sql_updata_order);
                mysqli_stmt_bind_param($stmt, "isssddi", $user_id_use_the_web, $order_not_recipient, $pic_name_ord, $dates, $money, $money_honesty, $id_order);
                mysqli_stmt_execute($stmt);

                // تأكيد العملية
                $con->commit();
                mysqli_stmt_close($stmt);
                header("location:nnjnmmnh");
            } catch (Exception $e) {
                // إلغاء العملية عند حدوث خطأ
                $con->rollback();
                echo "فشل إدخال البيانات: " . $e->getMessage();
                header("location:nnjnmmnh");
            }


            // إغلاق الاتصال
            $con->close();
            header("location:nnjnmmnh");
        }
    }
}
