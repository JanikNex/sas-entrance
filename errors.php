<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 11.03.2016
 * Time: 17:16
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';
require_once 'classes/Error.php';
require_once 'classes/Citizen.php';
require_once 'classes/LogEntry.php';

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$eID    = $_GET['eID'];

if($action == "correctThis" and is_numeric($eID)) {
    if ($user->isActionAllowed(PERM_CITIZEN_CORRECT_ERRORS) or $user->isActionAllowed(PERM_ADMIN_ERRORS)) {

        $errorToCorrect = \Entrance\Error::fromEID($eID);
        $errorToCorrect->correctThisError();

        \Entrance\Util::forwardTo("errors.php");
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beim Fehler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "correctAll" and is_numeric($eID)) {
        if ($user->isActionAllowed(PERM_CITIZEN_CORRECT_ERRORS) or $user->isActionAllowed(PERM_ADMIN_ERRORS)) {

            $errorToCorrect = \Entrance\Error::fromEID($eID);
            \Entrance\Error::correctError($errorToCorrect->getCID());

            \Entrance\Util::forwardTo("errors.php");
            exit; //To not show the list
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beim Fehler", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
} elseif($action == "del" and is_numeric($eID)) {
    if($user->isActionAllowed(PERM_ADMIN_ERRORS)) {
        $errorToDelete = \Entrance\Error::fromEID($eID);
        $errorToDelete->delete();
        \Entrance\Util::forwardTo("errors.php");
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beim Fehler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}

if($user->isActionAllowed(PERM_ADMIN_ERRORS)) {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler", $user);
    $errors = \Entrance\Error::getAllErrors();
    for ($i = 0; $i < sizeof($errors); $i++) {
        $pgdata["page"]["items"][$i] = $errors[$i]->asArray();
    }

    $dwoo->output("tpl/errorList.tpl", $pgdata);
} else {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}