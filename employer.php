<?php
/**
 * Created by PhpStorm.
 * User: Janik Rapp
 * Date: 27.06.2016
 * Time: 15:59
 */

error_reporting(E_ALL & ~E_NOTICE);
ini_set("diplay_errors", "on");

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';
require_once 'classes/Error.php';
require_once 'classes/Citizen.php';
require_once 'classes/LogEntry.php';
require_once 'classes/TracingEntry.php';
require_once 'classes/Employer.php';

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$emID    = $_GET['emID'];

if($action == "info" and is_numeric($emID)) {
    if ($user->isActionAllowed(PERM_EMPLOYER_INFO)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Betriebsinfo", $user);
        $employerToView = \Entrance\Employer::fromEMID($emID);
        $pgdata["page"]["employer"] = $employerToView->asArray();

        $dwoo->output("tpl/employerInfo.tpl", $pgdata);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Betriebsinfo", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}

if($user->isActionAllowed(PERM_EMPLOYER_LIST)) {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Betriebsliste", $user);

    $dwoo->output("tpl/employerList.tpl", $pgdata);
} else {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Betriebsliste", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}