<?php
$request = $_SERVER['REQUEST_URI'];

// إزالة معاملات GET من الرابط
$basePath = strtok($request, '?');

// إزالة اسم المجلد الفرعي ("/Albaraka") من بداية الرابط
$basePath = str_replace('/Albaraka', '', $basePath);

// التعامل مع المسارات
switch ($basePath) {
    case '/home': // الصفحة الرئيسية
    case '/home/olo': // مع علامة "/" الإضافية
        require 'home.php';
        break;

    case '/home/llop': // إضافة رسالة
        require 'send_me.php';
        break;
    case '/home/mklkj':
        $id_branch_select = $queryParams['opol'] ?? null;
        $id_driver_select = $queryParams['id_driver_select'] ?? null;
        require 'mes_export.php';
        break;

    case '/home/mnjghhhg':
        $id_branch_select = $queryParams['opol'] ?? null;
        $id_driver_select = $queryParams['id_driver_select'] ?? null;
        require 'mes_import.php';
        break;

    case '/home/nnjnmmnh':
        $mfnounYGWTFVWB = $queryParams['mfnounYGWTFVWB'] ?? null;
        require 'mes_delivery.php';
        break;

    case '/home/kjhksje':
        $JJSNwewyhjnbgh = $queryParams['JJSNwewyhjnbgh'] ?? null;
        require 'Driver Receives.php';
        break;

    case '/home/llkmkj':
        $PLmeawughnsi = $queryParams['PLmeawughnsi'] ?? null;
        require 'Delivery Driver.php';
        break;

    case '/home/kkiji':
        $pplZZndhnAAqaswe = $queryParams['pplZZndhnAAqaswe'] ?? null;
        $oQQsflnfaed = $queryParams['oQQsflnfaed'] ?? null;
        require 'mange_me.php';
        break;

    case '/home/kiji':
        $MMnsinedyuhjkbegdh = $queryParams['MMnsinedyuhjkbegdh'] ?? null;
        require 'mange_user.php';
        break;

    case '/home/llokikl':
        $XXCaqwsderfffijnd = $queryParams['XXCaqwsderfffijnd'] ?? null;
        require 'mange_permission.php';
        break;

    case '/home/nnnnnkug':
        require 'myaccount.php';
        break;

    case '/home/my':
        require 'my_profile.php';
        break;

    case '/home/out':
        require 'logout.php';
        break;

        case '/home/ljkhsfew7uh':
            require 'mes_report.php';
            break;

            case '/home/mwedweoisfhkujn':
                $efgbnmkoiuygbn = $queryParams['efgbnmkoiuygbn'] ?? null;
                $jhsdhkfgisdu = $queryParams['jhsdhkfgisdu'] ?? null;
                $iusfyw87fgknk = $queryParams['iusfyw87fgknk'] ?? null;
                require 'show_re.php';
                break;
    

//the hid page 


case '/home/vbnjuhjk':
    $QQAcmdnhjk = $queryParams['QQAcmdnhjk'] ?? null;
    require 'edit_send_me.php';
    break;



    case '/home/IIihjndiuh':
        $ppernrmfnb = $queryParams['ppernrmfnb'] ?? null;
        require 'insert_data.php';
        break;






    case '/اتصل-بنا':
        require 'contact.php';
        break;


}
?>
