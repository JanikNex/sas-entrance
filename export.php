<?php
/**
 * Created by PhpStorm.
 * User: Janik
 * Date: 01.05.2016
 * Time: 15:58
 */

error_reporting(E_ALL & ~E_NOTICE);

require_once "classes/Citizen.php";
require_once "classes/Util.php";
require_once "classes/User.php";
require_once "classes/LogEntry.php";
require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'libs/html2pdf-4.5.1/html2pdf.class.php';
require_once "classes/Permissions.php";

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$cID    = $_GET['cID'];
$group    = $_GET['group'];
$mode  =$_GET['mode'];

if($action == "exportClasslist") {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        \Entrance\Citizen::createClasslistAsCSV();
        echo json_encode(["success" => true]);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}elseif($action == "exportBadCitizenToday") {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        \Entrance\Citizen::createBadCitizenListAsCSV();
        echo json_encode(["success" => true]);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}elseif($action == "exportPassportGroup" and is_numeric($group)) {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        $link = \Entrance\Citizen::printPassportGroup($group);
        echo json_encode(["success" => true, "link" => str_replace("/var/www/html/", "/", $link)]);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}elseif($action == "printThisPassport" and is_numeric($cID)) {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        $citizen= \Entrance\Citizen::fromCID($cID);
        $link = $citizen->printThisCitizenPassport();
        \Entrance\Util::forwardTo(str_replace("/var/www/html/", "/", $link));
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "printPassportWorkers") {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        $link = \Entrance\Citizen::printPassportWorkers();
        \Entrance\Util::forwardTo(str_replace("/var/www/html/", "/", $link));
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "printPassportTest") {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        $link = \Entrance\Citizen::printTestPassportPage($mode);
        \Entrance\Util::forwardTo(str_replace("/var/www/html/", "/", $link));
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "printPassportSpecial") {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        $link = \Entrance\Citizen::printPassportSpecials($group);
        \Entrance\Util::forwardTo(str_replace("/var/www/html/", "/", $link));
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}

if($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
    $dwoo->output("tpl/export.tpl", $pgdata);
} else {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}