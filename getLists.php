<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 09.04.2016
 * Time: 22:50
 */
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set("diplay_errors", "on");

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
require_once 'classes/Employer.php';

$error = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET["action"];
$sort = $_GET["sort"];
$filter = $_GET["filter"];
$pageSize = 75;

if($action == "users") {
    $toEncode = ["users" => []];
    $users = \Entrance\User::getAllUsers($sort, $filter);
    foreach($users as $user) {
        if(isset($_GET["search"]) and $_GET["search"] != null) {
            if (strpos(strtolower($user->toString()), strtolower($_GET["search"])) !== FALSE)
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
} elseif($action == "citizenSimple" or $action == "citizenInStateSimple" or $action == "citizenBadSimple" or $action == "citizenWantedSimple") {
    $toEncode = ["citizens" => []];
    if ($action == "citizenInStateSimple") {
        $citizens = \Entrance\Citizen::getAllCitizenInStateSimple($sort, $filter, $_GET["page"], $pageSize, $_GET["search"]);
        $toEncode["citizens"] = $citizens;
        $currCount = \Entrance\Citizen::getCurrentCitizenCount($sort, $filter, $_GET["search"]);
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = ceil($currCount / $pageSize);
        $toEncode["size"] = $currCount;
    } elseif ($action == "citizenBadSimple") {
        $citizens = \Entrance\Citizen::getAllBadCitizenSimple($sort, $filter, $_GET["page"], $pageSize, $_GET["search"]);
        $toEncode["citizens"] = $citizens;
        $currCount = \Entrance\Citizen::getCurrentBadCitizenCount($sort, $filter, $_GET["search"]);
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = ceil($currCount / $pageSize);
        $toEncode["size"] = $currCount;
    } elseif ($action == "citizenWantedSimple") {
        $citizens = \Entrance\Citizen::getAllWantedCitizensSimple($_GET["page"], $pageSize, $_GET["search"]);
        $toEncode["citizens"] = $citizens;
        $currCount = \Entrance\Citizen::getCurrentWantedCount($_GET["search"]);
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = ceil($currCount / $pageSize);
        $toEncode["size"] = $currCount;
    } elseif($action == "citizenSimple") {
        $citizens = \Entrance\Citizen::getAllCitizenSimple($sort, $filter, $_GET["page"], $pageSize, $_GET["search"]);
        $toEncode["citizens"] = $citizens;
        $currCount = \Entrance\Citizen::getTotalCitizenCount($sort, $filter, $_GET["search"]);
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = ceil($currCount / $pageSize);
        $toEncode["size"] = $currCount;
    }

    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;
} elseif($action == "tracings") {
    $toEncode = ["tracings" => []];
    $tracings = \Entrance\TracingEntry::getAllTracings($sort, $filter);
    foreach($tracings as $tracing) {
        if(isset($_GET["search"]) and $_GET["search"] != null) {
            if (strpos(strtolower($tracing->toString()), strtolower($_GET["search"])) !== FALSE)
                array_push($toEncode["tracings"], $tracing->asArray());
        } else
            array_push($toEncode["tracings"], $tracing->asArray());
    }
    if(!isset($_GET["page"])) {
        $toEncode["page"] = 1;
        $toEncode["maxpage"] = ceil(sizeof($toEncode["tracings"]) / $pageSize);
        $startElem = 0;
        $toEncode["tracings"] = array_slice($toEncode["tracings"], $startElem, $pageSize);
    } else {
        $toEncode["page"] = $_GET["page"];
        $toEncode["maxpage"] = ceil(sizeof($toEncode["tracings"]) / $pageSize);
        $startElem = ($toEncode["page"]-1) * $pageSize;
        $toEncode["tracings"] = array_slice($toEncode["tracings"], $startElem, $pageSize);
    }
    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;
} elseif($action == "dashboard") {
    $toEncode = [];
    $toEncode["stateState"] = \Entrance\Util::isStateOpen();
    $toEncode["all"] = \Entrance\Citizen::getCurrentCitizenCount("", "ohneKurier", "");
    $toEncode["visitors"] = \Entrance\Citizen::getCurrentVisitorCount();
    $toEncode["students"] = \Entrance\Citizen::getCurrentStudentCount();
    $toEncode["courriers"] = \Entrance\Citizen::getCurrentCourrierCount();
    $toEncode["badCitizens"] = \Entrance\Citizen::getCurrentBadCitizenCount();
    $toEncode["errors"] = \Entrance\Error::getSizeOfActiveErrors();
    $toEncode["tracings"] = \Entrance\TracingEntry::getSizeOfActiveTracings();
    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;
} elseif($action == "latestLogs") {
    $toEncode = ["logs" => []];
    $logs = \Entrance\LogEntry::getNumLogs(5);
    foreach($logs as $log) {
        array_push($toEncode["logs"], $log->asArray());
    }
    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;

} elseif($action == "employer") {
    $toEncode = ["citizens" => []];
    $citizens = \Entrance\Employer::getAllEmployers($_GET["page"], $pageSize, $_GET["search"]);
    $toEncode["citizens"] = $citizens;
    $currCount = \Entrance\Employer::getTotalEmployerCount($_GET["search"]);
    $toEncode["page"] = $_GET["page"];
    $toEncode["maxpage"] = ceil($currCount / $pageSize);
    $toEncode["size"] = $currCount;

    $jsoncode = json_encode($toEncode);
    echo $jsoncode;
    exit;
}