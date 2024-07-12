<?php
if (!defined('NOCSRFCHECK')) {
	define('NOCSRFCHECK', '1'); // Do not check anti CSRF attack test
}
if (!defined('NOTOKENRENEWAL')) {
	define('NOTOKENRENEWAL', '1'); // Do not check anti POST attack test
}
if (!defined('NOREQUIREMENU')) {
	define('NOREQUIREMENU', '1'); // If there is no need to load and show top and left menu
}
if (!defined('NOREQUIREHTML')) {
	define('NOREQUIREHTML', '1'); // If we don't need to load the html.form.class.php
}
if (!defined('NOREQUIREAJAX')) {
	define('NOREQUIREAJAX', '1'); // Do not load ajax.lib.php library
}
if (!defined("NOLOGIN")) {
	define("NOLOGIN", '1'); // If this page is public (can be called outside logged session)
}
if (!defined("NOSESSION")) {
	define("NOSESSION", '1');
}
if (!defined("NODEFAULTVALUES")) {
	define("NODEFAULTVALUES", '1');
}

// Response for preflight requests (used by browser when into a CORS context)
if (!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS' && !empty($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: Content-Type, Authorization, api_key, DOLAPIKEY');
	http_response_code(204);
	exit;
}

// When we request url to get the json file, we accept Cross site so we can include the descriptor into an external tool.
if (preg_match('/\/explorer\/swagger\.json/', $_SERVER["PHP_SELF"])) {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: Content-Type, Authorization, api_key, DOLAPIKEY');
}
// When we request url to get an API, we accept Cross site so we can make js API call inside another website
if (preg_match('/\/api\/index\.php/', $_SERVER["PHP_SELF"])) {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: Content-Type, Authorization, api_key, DOLAPIKEY');
}
header('X-Frame-Options: SAMEORIGIN');



require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/custom/attendance/models/AttendanceModel.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/admin.lib.php';



$md = new AttendanceModel($db);
header('Content-Type: application/json; charset=utf-8');

// Check the request method
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['date']) && isset($_GET['userid'])){
        $date = $_GET['date'];
        $userid = $_GET['userid'];
        Response("success","Fetched successfully",$md->find_by_user_date($userid,$date));
    }elseif(isset($_GET['date'])){
        $date = $_GET['date'];
        Response("success", "Fetched successfully.",$md->find_by_date($date));
    }elseif(isset($_GET['userid'])){
        $userid = $_GET['userid'];
        Response("success", "Fetched successfully.",$md->find_by_user($userid));
    }else{
        Response("success", "Fetched successfully.",$md->fetch());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $date = date('Y-m-d');
    $time = date('h:i A');
    $ins = $md->create($userid,$date, $time);
    $data  = $md->find_by_user_date($userid,$date);
    if($ins){
        Response("success", "Checked in successfully.",$data);
    }else{
        Response("error", "Already checked in or something went wrong.",$data,401);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $userid = $_REQUEST['userid'];
    $date = date('Y-m-d');
    $checkout = date('h:i A');
    $ins = $md->update($userid,$date, $checkout);
    $data  = $md->find_by_user_date($userid,$date);
    if($ins){
        Response("success", "Checked in successfully.",$data);
    }else{
        Response("error", "Already checked out or not checked in yet.",$data,401);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Call your function to handle DELETE request
    Response("error", "Not Active",[],400);
} else {
    // If the request method is not recognized
    Response("error", "Invalid request method", [], 400);
}

function Response($status, $msg, $data = [], $code = 200)
{
    http_response_code($code);
    // Your JSON response
    $response = array(
        "status" => $status,
        "message" => $msg,
        "data" => $data,
    );
    echo json_encode($response);
    // Terminate script execution
    exit();
}
?>
