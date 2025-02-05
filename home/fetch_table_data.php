<?php
// تضمين الاتصال بقاعدة البيانات
include "../db.php";
include "Myfun_albraka.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['table_name'])&& isset($_GET['id'])) {
    $table_name = $_GET['table_name'];
    $id = $_GET['id'];
    // تأمين اسم الجدول لتجنب الحقن
    $allowed_tables = ['order', 'orders_table', 'users_table']; // أضف أسماء الجداول المسموح بها
    if (!in_array($table_name, $allowed_tables)) {
        http_response_code(400); // رد خطأ
        echo "Invalid table name.";
        exit;
    }

    // استدعاء الدالة المناسبة بناءً على اسم الجدول
    switch ($table_name) {
        case 'order':
            fetchMessagesTable($con);
            break;
        case 'orders_table':
            fetchOrdersTable($con);
            break;
        case 'users_table':
            fetchUsersTable($con);
            break;
        default:
            http_response_code(400);
            echo "Unknown table.";
            break;
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
    exit;
}

// دالة لإعادة بيانات جدول الرسائل
function fetchMessagesTable($con) {
    $my_bra2 = osamah_decrypt($_SESSION['publi_fk_id_branch']);

    $sql = "SELECT o.id_order, o.QR, j2.name_branch AS 'name_des', COUNT(oi.id_item_order) AS 'number_item'
            FROM `order` o
            JOIN `branch` j2 ON o.fk_id_branch_recipient = j2.id_branch
            JOIN `order_item` oi ON o.id_order = oi.fk_order
            WHERE o.check_receipt_sender = 1 AND o.fk_level_mess = 1 
                  AND o.check_export = 0 AND o.fk_id_branch_sender = ? 
                  AND o.status_order = 1 AND o.fk_id_branch_recipient = ? 
                  AND o.fk_id_driver = 0
            GROUP BY o.QR";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $my_bra2,$id); // ضع المتغيرات المناسبة هنا
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id_order']}</td>
                <td>{$row['QR']}</td>
                <td>{$row['name_des']}</td>
                <td>{$row['number_item']}</td>
                <td>
                    <div class='custom-control custom-switch custom-switch-off-danger custom-switch-on-success'>
                        <input type='checkbox' class='custom-control-input' id='page_{$row['id_order']}' name='driver_mess_status' value='{$row['id_order']}'>
                        <label class='custom-control-label' for='page_{$row['id_order']}'>
                            <small class='badge badge-danger'> غير مفعل </small>
                        </label>
                    </div>
                </td>
            </tr>";
    }
}

// دالة لإعادة بيانات جدول الطلبات
function fetchOrdersTable($con) {
    $sql = "SELECT id_order, QR, fk_id_branch_recipient FROM `order` WHERE `status_order` = 1";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id_order']}</td>
                <td>{$row['QR']}</td>
                <td>{$row['fk_id_branch_recipient']}</td>
              </tr>";
    }
}

// دالة لإعادة بيانات جدول المستخدمين
function fetchUsersTable($con) {
    $sql = "SELECT id_user, username, email FROM `users`";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id_user']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
              </tr>";
    }
}
?>
