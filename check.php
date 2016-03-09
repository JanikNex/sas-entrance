<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 09.03.2016
 * Time: 23:01
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';
require_once 'classes/Citizen.php';
require_once 'classes/LogEntry.php';

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];

if($action == "checkInScan") {
    if($user->isActionAllowed(PERM_CITIZEN_LOGIN )) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Einbuchen", $user);

        // Space for some magic

        $dwoo->output("tpl/checkIn.tpl", $pgdata);
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Einbuchen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "checkOutScan") {
    if($user->isActionAllowed(PERM_CITIZEN_LOGOUT)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Ausbuchen", $user);

        // Space for some magic

        $dwoo->output("tpl/checkIn.tpl", $pgdata);
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Ausbuchen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }

    // -------------------------------------------------------------------------

} elseif($action == "checkIn") {
    if($user->isActionAllowed(PERM_CITIZEN_LOGIN )) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Scannen", $user);

        $dwoo->output("tpl/checkIn.tpl", $pgdata);
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Scannen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "checkOut") {
    if($user->isActionAllowed(PERM_CITIZEN_LOGOUT)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Scannen", $user);

        $dwoo->output("tpl/checkOut.tpl", $pgdata);
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Scannen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

