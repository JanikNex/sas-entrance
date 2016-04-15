<?php
/**
 * Created by PhpStorm.
 * User: Janik Rapp
 * Date: 15.04.2016
 * Time: 18:10
 */

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';
require_once 'classes/Citizen.php';
require_once 'classes/Error.php';
require_once 'classes/TracingEntry.php';
require_once 'classes/LogEntry.php';

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

if($action == "closeState") {
    if ($user->isActionAllowed(PERM_ADMIN_STATE_CLOSE)) {
        \Entrance\Util::closeState();
        \Entrance\Util::forwardTo("dashboard.php");
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Dashboard", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "openState") {
    if ($user->isActionAllowed(PERM_ADMIN_STATE_OPEN)) {
        \Entrance\Util::openState();
        \Entrance\Util::forwardTo("dashboard.php");
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Dashboard", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}

if($user->isActionAllowed(PERM_ADMIN_STATE_DASHBOARD)) {
    $dwoo->output("tpl/dashboard.tpl", \Entrance\Util::getEditorPageDataStub("Dashboard", $user));
} else {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Person", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}
