<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 09.04.2016
 * Time: 22:50
 */

require_once "classes/Util.php";

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET["action"];
$sort = $_GET["sort"];
$filter = $_GET["filter"];

if($action == "users") {
    $toEncode = ["users" => []];
    if(!isset($_GET["page"]))
        $users = \Entrance\User::getAllUsers($sort, $filter);
    else {
        $users = \Entrance\User::getAllUsers($sort, $filter);
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = 5;
    }
    foreach($users as $user) {
        array_push($toEncode["users"], $user->asArray());
    }
    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;
}