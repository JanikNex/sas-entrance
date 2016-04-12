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
require_once 'classes/Error.php';
require_once 'classes/Citizen.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';
require_once 'classes/TracingEntry.php';
require_once 'classes/LogEntry.php';

$error = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET["action"];
$sort = $_GET["sort"];
$filter = $_GET["filter"];
$pageSize = 10;

if($action == "users") {
    $toEncode = ["users" => []];
    $users = \Entrance\User::getAllUsers($sort, $filter);
    foreach($users as $user) {
        if(isset($_GET["search"]) and $_GET["search"] != null) {
            if (strpos(strtolower($user->asString()), strtolower($_GET["search"])) !== FALSE)
                array_push($toEncode["users"], $user->asArray());
        } else
            array_push($toEncode["users"], $user->asArray());
    }
    if(!isset($_GET["page"])) {
        $toEncode["page"] = 1;
        $toEncode["maxpage"] = ceil(sizeof($toEncode["users"]) / $pageSize);
        $startElem = 0;
        $toEncode["users"] = array_slice($toEncode["users"], $startElem, $pageSize);
    } else {
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = ceil(sizeof($toEncode["users"]) / $pageSize);
        $startElem = ($toEncode["page"]-1) * $pageSize;
        $toEncode["users"] = array_slice($toEncode["users"], $startElem, $pageSize);
    }
    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;
} elseif($action == "errors") {
    $toEncode = ["errors" => []];
    $errors = \Entrance\Error::getAllErrors($sort, $filter);
    foreach($errors as $error) {
        if(isset($_GET["search"]) and $_GET["search"] != null) {
            if (strpos(strtolower($error->asString()), strtolower($_GET["search"])) !== FALSE)
                array_push($toEncode["errors"], $error->asArray());
        } else
            array_push($toEncode["errors"], $error->asArray());
    }
    if(!isset($_GET["page"])) {
        $toEncode["page"] = 1;
        $toEncode["maxpage"] = ceil(sizeof($toEncode["errors"]) / $pageSize);
        $startElem = 0;
        $toEncode["errors"] = array_slice($toEncode["errors"], $startElem, $pageSize);
    } else {
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = ceil(sizeof($toEncode["errors"]) / $pageSize);
        $startElem = ($toEncode["page"]-1) * $pageSize;
        $toEncode["errors"] = array_slice($toEncode["errors"], $startElem, $pageSize);
    }
    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;
} elseif($action == "citizen" or $action == "citizenInState" or $action == "citizenBad" or $action == "citizenWanted") {
    $toEncode = ["citizens" => []];
    if($action == "citizenInState") $citizens = \Entrance\Citizen::getAllCitizenInState($sort, $filter);
    elseif($action == "citizenBad") $citizens = \Entrance\Citizen::getAllBadCitizen($sort, $filter);
    elseif($action == "citizenWanted") $citizens = \Entrance\Citizen::getAllWantedCitizens($sort, $filter);
    elseif($action == "citizen") $citizens = \Entrance\Citizen::getAllCitizen($sort, $filter);
    foreach($citizens as $citizen) {
        if(isset($_GET["search"]) and $_GET["search"] != null) {
            if (strpos(strtolower($citizen->asString()), strtolower($_GET["search"])) !== FALSE)
                array_push($toEncode["citizens"], $citizen->asArray());
        } else
            array_push($toEncode["citizens"], $citizen->asArray());
    }
    if(!isset($_GET["page"])) {
        $toEncode["page"] = 1;
        $toEncode["maxpage"] = ceil(sizeof($toEncode["citizens"]) / $pageSize);
        $startElem = 0;
        $toEncode["citizens"] = array_slice($toEncode["citizens"], $startElem, $pageSize);
    } else {
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = ceil(sizeof($toEncode["citizens"]) / $pageSize);
        $startElem = ($toEncode["page"]-1) * $pageSize;
        $toEncode["citizens"] = array_slice($toEncode["citizens"], $startElem, $pageSize);
    }
    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;
}