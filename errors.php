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
require_once 'classes/TracingEntry.php';
require_once 'classes/Employer.php';

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$eID    = $_GET['eID'];

if($action == "correctThis" and is_numeric($eID)) {
    if ($user->isActionAllowed(PERM_ADMIN_ERRORS)) {

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
        if ($user->isActionAllowed(PERM_ADMIN_ERRORS)) {

            $errorToCorrect = \Entrance\Error::fromEID($eID);
            \Entrance\Error::correctError($errorToCorrect->getCID());

            \Entrance\Util::forwardTo("errors.php");
            exit; //To not show the list
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beim Fehler", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
} elseif($action == "autoCorrect") {
    if($user->isActionAllowed(PERM_CITIZEN_CORRECT_ERRORS) or $user->isActionAllowed(PERM_ADMIN_ERRORS)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beheben", $user);
        $citizen = \Entrance\Citizen::fromBarcode($_POST["barcode"]);

        if($citizen->forceErrorCorrect($user)) {
            $pgdata["page"]["scan"]["success"] = 1;
            $pgdata["page"]["citizen"] = $citizen->asArray();
            $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
            for ($i = 0; $i < sizeof($itsLogs); $i++) {
                $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
                if($i >= 1) break;
            }
        } else {
            $pgdata["page"]["scan"]["success"] = 2;
            $pgdata["page"]["citizen"] = $citizen->asArray();
            $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
            for ($i = 0; $i < sizeof($itsLogs); $i++) {
                $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
                if ($i >= 1) break;
            }
        }
        $dwoo->output("tpl/errorCorrect.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beim Fehler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }

} elseif($action == "correct") {
    if($user->isActionAllowed(PERM_CITIZEN_CORRECT_ERRORS) or $user->isActionAllowed(PERM_ADMIN_ERRORS)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beheben", $user);

        $dwoo->output("tpl/errorCorrect.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beim Fehler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "ignore") {
    if($user->isActionAllowed(PERM_CITIZEN_IGNORE_ERRORS) or $user->isActionAllowed(PERM_ADMIN_ERRORS)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler ignorieren", $user);

        $dwoo->output("tpl/errorIgnore.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beim Fehler ignorieren", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "autoIgnore") {
    if($user->isActionAllowed(PERM_CITIZEN_IGNORE_ERRORS) or $user->isActionAllowed(PERM_ADMIN_ERRORS)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler ignorieren", $user);
        $citizen = \Entrance\Citizen::fromBarcode($_POST["barcode"]);

        if($citizen->forceErrorCorrectIgnore($user)) {
            $pgdata["page"]["scan"]["success"] = 1;
            $pgdata["page"]["citizen"] = $citizen->asArray();
            $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
            for ($i = 0; $i < sizeof($itsLogs); $i++) {
                $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
                if($i >= 1) break;
            }
        } else {
            $pgdata["page"]["scan"]["success"] = 2;
            $pgdata["page"]["citizen"] = $citizen->asArray();
            $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
            for ($i = 0; $i < sizeof($itsLogs); $i++) {
                $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
                if ($i >= 1) break;
            }
        }
        $dwoo->output("tpl/errorIgnore.tpl", $pgdata);

        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler beim Fehler ignorieren", $user);
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
    $errors = \Entrance\Error::getAllErrors($_GET["sort"], $_GET["filter"]);
    for ($i = 0; $i < sizeof($errors); $i++) {
        $pgdata["page"]["items"][$i] = $errors[$i]->asArray();
    }
    if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "ascName";
    if(isset($_GET["filter"])) $pgdata["page"]["filter"] = $_GET["filter"]; else $pgdata["page"]["filter"] = "Alle";


    $dwoo->output("tpl/errorList.tpl", $pgdata);
} else {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Fehler", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}