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

if($action == "exportClasslist") {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $pgdata["page"]["type"] = "waiting";
        $dwoo->output("tpl/export.tpl", $pgdata);
        \Entrance\Citizen::createClasslistAsCSV();
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $pgdata["page"]["type"] = "classlist";
        $dwoo->output("tpl/export.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "printAllPassports") {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $pgdata["page"]["type"] = "waiting";
        //$dwoo->output("tpl/export.tpl", $pgdata);
        \Entrance\Citizen::printAllCitizenPassports();
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $pgdata["page"]["type"] = "printAllPassports";
        //$dwoo->output("tpl/export.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}elseif($action == "printThisPassport" and is_numeric($cID)) {
    if ($user->isActionAllowed(PERM_ADMIN_EXPORT)) {
        $citizen= \Entrance\Citizen::fromCID($cID);
        $pgdata = \Entrance\Util::getEditorPageDataStub("Export", $user);
        $pgdata["page"]["type"] = "waiting";
        //$dwoo->output("tpl/export.tpl", $pgdata);
        $citizen->printThisCitizenPassport();
        //\Entrance\Util::forwardTo("citizen.php?action=citizeninfo&cID=".$cID);
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