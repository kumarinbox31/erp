<?php
// Load Dolibarr environment
require '../../main.inc.php';

// Load API class
dol_include_once('/core/lib/admin.lib.php');
dol_include_once('/custom/my_module/class/myclass.class.php');

// Load REST API classes
use Luracast\Restler\RestException;
use Luracast\Restler\Format\JsonFormat;

// Add your API class
class MyApi
{
    /**
     * @url GET /hello
     */
    public function sayHello()
    {
        return array('message' => 'Hello, world!');
    }

    /**
     * @url GET /greet/$name
     */
    public function greet($name)
    {
        return array('message' => 'Hello, ' . $name . '!');
    }
}

// Register your API class
$api = new Restler();
$api->addAPIClass('MyApi');
$api->handle();
