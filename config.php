<?php
ob_start();
ini_set('date.timezone','Asia/Manila');
date_default_timezone_set('Asia/Manila');
session_start();

require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

// Set up PDO connection
$host = 'localhost'; // Database host (change if necessary)
$dbname = 'smart_med'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password (change if necessary)

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error handling
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}// Set up PDO connection
$host = 'acela.proxy.rlwy.net';
$dbname = 'smart_med';
$username = 'root';
$password = 'oCZnrPaBlUHwYSSosvPTWAFRnKiSwQJI';
$port = 58509;
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$db = new DBConnection;
$conn = $db->conn;

function redirect($url=''){
    if(!empty($url))
        echo '<script>location.href="'.base_url .$url.'"</script>';
}

function validate_image($file){
    if(!empty($file)){
        $ex = explode('?',$file);
        $file = $ex[0];
        $param =  isset($ex[1]) ? '?'.$ex[1]  : '';
        if(is_file(base_app.$file)){
            return base_url.$file.$param;
        }else{
            return base_url.'dist/img/no-image-available.png';
        }
    }else{
        return base_url.'dist/img/no-image-available.png';
    }
}

function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    return false;
}

ob_end_flush();
?>
