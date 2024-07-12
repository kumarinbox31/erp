<?php 
function loadEnv($path)
{
    $file = fopen($path, 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if (!empty($line) && strpos($line, '=') !== false && substr($line, 0, 1) !== '#') {
                list($key, $value) = explode('=', $line, 2);
                $_ENV[$key] = $value;
            }
        }
        fclose($file);
    } else {
        throw new Exception('.env file not found or cannot be read.');
    }
}

// Load .env file (assuming it's in the same directory as this script)
$dotenvPath = dirname(__DIR__) . '/htdocs/.env';
echo $dotenvPath;exit;
try {
    loadEnv($dotenvPath);
} catch (Exception $e) {
    die($e->getMessage());
}
class WEB_API{
    private $url,$fresh_url,$w;
    protected $table = 'pb_company';
    public $get = [];
    protected $db;
    function __construct($w){
        $this->w = $w;
        // print_r($w);exit;
        $this->url = $w['url'];
        $this->fresh_url = str_ireplace(['http://', 'https://'], '', trim($this->url));
        $this->fresh_url = rtrim($this->fresh_url,'/');
    }
    // function find_by_url(){
    //     $sql = "SELECT * FROM $this->table WHERE url = '$this->fresh_url'";
    //     $result = $this->db->query($sql);
    //     $count = $result->num_rows;
    //     if($count){
    //         $this->get = $result->fetch_assoc();
    //         if($this->get['status']){
    //             $expiry_date = strtotime($this->get['expire_date']);
    //             if($expiry_date < time()){
    //                 $this->display_error('Expired',403);
    //             }
    //         }else{
    //             $this->display_error('Your account is suspended',402);
    //         }
    //     }else{
    //         $this->display_error('Your account not found or something went wrong.',401);
    //     }
    //     // exit;
    // }
    
    function get() {
        // die($this->w['main_site_url'].'api/v1/company/getDetails?url='.$this->fresh_url);
        // $this->find_by_url();
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->w['main_site_url'].'api/v1/company/getDetails?url='.$this->fresh_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
    
        $res = curl_exec($curl);
        $curlError = curl_error($curl);
        curl_close($curl);
    
        if ($res === false) {
            // display error for curl execution failure
            $this->display_error('Failed to connect to the main site: ' . $curlError, 500);
            return;
        }
    
        $res = json_decode($res, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            // display error for invalid JSON response
            $this->display_error('Invalid response from main site', 500);
            return;
        }
    
        if (empty($res)) {
            // display error for blank response from main site
            $this->display_error('Your account not found or something went wrong.', 401);
            return;
        }
    
        if (isset($res['result']) && $res['result'] == 1) {
            $this->get = $res['data'];
            if (isset($this->get['status']) && $this->get['status']) {
                $expiry_date = strtotime($this->get['expire_date']);
                if ($expiry_date < time()) {
                    $this->display_error('Expired', 403);
                    return;
                }
            } else {
                // display error to show account is suspended
                $this->display_error('Your account is suspended', 402);
                return;
            }
        } else {
            // display error to show user not found or some other issue
            $this->display_error('Your account not found or something went wrong.', 401);
            return;
        }
    }
    function licence() {
        // $this->find_by_url();
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->w['main_site_url'].'api/v1/licence/findByCompany/'.PB_COMP_ID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
    
        $res = curl_exec($curl);
        $curlError = curl_error($curl);
        curl_close($curl);
    
        if ($res === false) {
            // display error for curl execution failure
            $this->display_error('Failed to connect to the main site: ' . $curlError, 500);
            return;
        }
    
        $res = json_decode($res, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // display error for invalid JSON response
            $this->display_error('Invalid response from main site', 500);
            return;
        }
    
        if (empty($res)) {
            // display error for blank response from main site
            $this->display_error('Your account not found or something went wrong.', 401);
            return;
        }    
        return $res;
    }

    function useLicence($licenceid) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->w['main_site_url'].'api/v1/licence/use/'.$licenceid,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
    
        $res = curl_exec($curl);
        $curlError = curl_error($curl);
        curl_close($curl);
    
        if ($res === false) {
            // display error for curl execution failure
            $this->display_error('Failed to connect to the main site: ' . $curlError, 500);
            return;
        }
    
        $res = json_decode($res, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // display error for invalid JSON response
            $this->display_error('Invalid response from main site', 500);
            return;
        }
    
        if (empty($res)) {
            // display error for blank response from main site
            $this->display_error('Your account not found or something went wrong.', 401);
            return;
        }  
        return $res; 
    }
    function set(){
        define('PB_CUST_NAME',$this->get['name']);
        define('PB_FRESH_URL',$this->get['url']);
        define('PB_URL',$this->url);
        define('PB_COMP_DB',$this->get['dbname']);
        // define('PB_MAIN_HOST',$this->w['host']);
        // define('PB_MAIN_USER',$this->w['user']);
        // define('PB_MAIN_PASS',$this->w['pass']);
        define('PB_COMP_ID',$this->get['id']);
        // define('PB_MAIN_DOC_ROOT',$this->w['document_root']);
        // define('PB_MAIN_DATA_ROOT',$this->w['data_root'].'/'.PB_COMP_ID);
    }
    // function connect(){
    //     $this->db = mysqli_connect($this->w['host'],$this->w['user'],$this->w['pass'],$this->w['dbname']);
    // }
    function runApp(){
        $this->chkDBPrepared();
        $this->chkDIRPrepared();
        $this->completeInstallation();
    }
    
    function completeInstallation(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->w['main_site_url'].'api/v1/company/update',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('name' => $this->get['name'],'email' => $this->get['email'],'mobile' => $this->get['mobile'],
        'url' => $this->get['url'],'plan_id' => $this->get['plan_id'],'start_date' => $this->get['start_date'],
        'expire_date' => $this->get['expire_date'],'dbname' => $this->get['dbname'],'is_installed' => '1','id' => $this->get['id']),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
        // print_r($response);exit;
    }
    function chkDBPrepared() {
        $conn = mysqli_connect($this->w['host'], $this->w['user'], $this->w['pass']);
        if (!$conn) {
            $this->display_error('Unable to connect to the database server. Contact the developer.', 500);
            return;
        }
        $db_name = PB_COMP_DB;
        $result = mysqli_query($conn, "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
        if (mysqli_num_rows($result) == 0) {
            $this->prepareDB($conn, $db_name);
            // $this->display_error('DB not prepared for this account. Contact the developer.', 402);
            // mysqli_close($conn);
            // return;
        }
        mysqli_close($conn);
    }

    function prepareDB($conn, $db_name) {
        // Create database
        $create_db_query = "CREATE DATABASE `$db_name`";
        if (mysqli_query($conn, $create_db_query)) {
            mysqli_select_db($conn, $db_name);
    
            // Directory containing SQL files
            $sql_files_dir = $this->w['sql_files_dir'];
            $sql_files = glob("$sql_files_dir/*.sql");
    
            // Loop through each SQL file and execute its contents
            foreach ($sql_files as $file) {
                $sql = file_get_contents($file);
                if (mysqli_multi_query($conn, $sql)) {
                    do {
                        // This block is necessary to flush multi_query results
                        if ($result = mysqli_store_result($conn)) {
                            mysqli_free_result($result);
                        }
                    } while (mysqli_next_result($conn));
    
                    // Check for errors in the current batch of queries
                    if (mysqli_errno($conn)) {
                        // Log or display the error and continue with the next file
                        error_log('Error executing SQL file ' . $file . ': ' . mysqli_error($conn));
                        continue; // Skip to the next SQL file
                    }
                } else {
                    // Log or display the error and continue with the next file
                    error_log('Error executing SQL file ' . $file . ': ' . mysqli_error($conn));
                    continue; // Skip to the next SQL file
                }
            }
        } else {
            $this->display_error('Error creating database: ' . mysqli_error($conn), 500);
        }
    }
    
    

    function chkDIRPrepared() {
        $dir = dirname(__DIR__).'/documents/'.PB_COMP_ID ;
        if (!is_dir($dir)) {
            $this->prepareDIR($dir);
            // $this->display_error('Directory not prepared for this account. Contact the developer.', 404);
        }
    }
    function prepareDIR($receiverDIR) {
        $sender = $this->w['data_dir'];
    
        // Create receiver directory if it doesn't exist
        if (!is_dir($receiverDIR)) {
            mkdir($receiverDIR, 0755, true);
        }
    
        // Function to recursively copy files and directories
        function recursiveCopy($source, $dest) {
            $dir = opendir($source);
            @mkdir($dest);
            while (($file = readdir($dir)) !== false) {
                if ($file != '.' && $file != '..') {
                    $sourcePath = $source . DIRECTORY_SEPARATOR . $file;
                    $destPath = $dest . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($sourcePath)) {
                        recursiveCopy($sourcePath, $destPath);
                    } else {
                        copy($sourcePath, $destPath);
                    }
                }
            }
            closedir($dir);
        }
    
        // Start copying files and directories
        recursiveCopy($sender, $receiverDIR);
    }
    
    function __init(){
        // $this->connect();
        $this->get();
        $this->set();
        if($this->get['is_installed'] == '0'){
            // $this->runApp();
        }
        // mysqli_close($this->db);
    }
    function display_error($msg, $code) {
        $code = intval($code);
        http_response_code($code);
        header("Status: $code $msg"); // Set the status header
    
        // Display the error message in the body
        echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>$code Error</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f8f9fa;
                            color: #333;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                        }
                        .container {
                            text-align: center;
                        }
                        h1 {
                            font-size: 48px;
                            margin-bottom: 20px;
                        }
                        p {
                            font-size: 24px;
                            margin-bottom: 10px;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h1>$code Error</h1>
                        <p>$msg</p>
                    </div>
                </body>
                </html>";
            exit;
    }

}
function isLocalServer() {
    $serverName = $_SERVER['SERVER_NAME'];
    $localServers = ['localhost', '127.0.0.1'];

    return in_array($serverName, $localServers);
}
if(isset($_ENV['APP_URL'])){
    $url = $_ENV['APP_URL'];
}else{
    $ip = $_SERVER["REMOTE_ADDR"];
    $url = gethostbyaddr($ip);
}
$pbAPI = new WEB_API(
    [
        // 'main_site_url' => $_ENV['LICENSE_APP'],
        'main_site_url' => 'https://license.pb18.in/',
        'url' => $url,
    ]
);


// initalizing web api
$pbAPI->__init();
