<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 07.03.2016
 * Time: 15:30
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

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

$action = $_GET['action'];
$cID    = $_GET['cID'];
$roll   = $_GET['roll'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_CITIZEN_CREATE)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user, false, true, "citizen.php");
        $dwoo->output("tpl/citizenNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "edit" and is_numeric($cID)) {
    if ($user->isActionAllowed(PERM_CITIZEN_EDIT)) {
        $citizenToEdit = \Entrance\Citizen::fromCID($cID);
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user, false, true, "citizen.php");
        $pgdata["edit"] = $citizenToEdit->asArray();
        $dwoo->output("tpl/citizenEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_CITIZEN_CREATE)) {
        $citizenToEdit = \Entrance\Citizen::createCitizen($_POST['firstname'], $_POST['lastname'], $_POST['classlevel'], $_POST['birthday'], $_POST['barcode']);
        \Entrance\Util::forwardTo("citizen.php");
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "postEdit" and is_numeric($cID)) {
    if($user->isActionAllowed(PERM_CITIZEN_EDIT)) {
        $citizenToEdit = \Entrance\Citizen::fromCID($cID);
        $citizenToEdit->setBarcode($_POST['barcode']);
        $citizenToEdit->setFirstname($_POST['firstname']);
        $citizenToEdit->setLastname($_POST['lastname']);
        $citizenToEdit->setBirthday($_POST['birthday']);
        $citizenToEdit->setClasslevel($_POST['classlevel']);

        $citizenToEdit->saveChanges();
        \Entrance\Util::forwardTo("citizen.php?action=edit&cID=".$cID);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "del" and is_numeric($cID)) {
    if($user->isActionAllowed(PERM_CITIZEN_DELETE)) {
        $userToDelete = \Entrance\User::fromUID($cID);
        $userToDelete->delete();
        \Entrance\Util::forwardTo("citizen.php");
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "badcitizen") {
    if($user->isActionAllowed(PERM_CITIZEN_INFO_DIFFERENCE)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Böse Schüler", $user);
        $pgdata["page"]["type"] = "bad";

        $dwoo->output("tpl/citizenList.tpl", $pgdata);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "wantedcitizen") {
    if($user->isActionAllowed(PERM_TRACING_LIST)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fahndungsliste", $user);
        $pgdata["page"]["type"] = "Wanted";

        $dwoo->output("tpl/citizenList.tpl", $pgdata);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "allTracings") {
    if($user->isActionAllowed(PERM_ADMIN_TRACING)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Alle Fahndungen", $user);
        $pgdata["page"]["type"] = "Tracing";

        $dwoo->output("tpl/citizenList.tpl", $pgdata);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Alle Fahndungen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "citizeninfo") {
    if($user->isActionAllowed(PERM_CITIZEN_INFO_SPECIFIC) and is_numeric($cID)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schülerinfo", $user, true, false, "citizen.php");
        $citizenToView = \Entrance\Citizen::fromCID($cID);
        $pgdata["page"]["citizen"] = $citizenToView->asArray();

        $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($cID);
        for ($i = 0; $i < sizeof($itsLogs); $i++) {
            $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
        }

        $days = \Entrance\LogEntry::getProjectDays();
        for($i = 0; $i < sizeof($days); $i++) {
            $pgdata["page"]["times"][$i]["date"] = $days[$i];
            $pgdata["page"]["times"][$i]["time"] = $citizenToView->getTimePerDay($days[$i]) != 0 ? gmdate("H\h i\m s\s",$citizenToView->getTimePerDay($days[$i])) : "<i>Nicht anwesend</i>";
        }

        $pgdata["page"]["timeTotal"] = $citizenToView->getTimePerProject() != 0 ? \Entrance\Util::seconds_to_time($citizenToView->getTimePerProject()) : "<i>Nicht anwesend</i>";

        $dwoo->output("tpl/citizenInfo.tpl", $pgdata);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Personen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "listInState") {
    if($user->isActionAllowed(PERM_CITIZEN_PRESENT_LIST)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Personen im Staat", $user);
        $pgdata["page"]["type"] = "InState";

        $dwoo->output("tpl/citizenList.tpl", $pgdata);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Schüler", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "counter") {
    if($user->isActionAllowed(PERM_CITIZEN_PRESENT_NUMBER)) {
        header('Content-Type: text/html; charset=utf-8'); // sorgt für die korrekte Kodierung
        header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0'); // ist mal wieder wichtig wegen IE
        switch($_GET['type']) {
            case "all":
                echo \Entrance\Citizen::getCurrentCitizenCount("","","");
                break;
            case "visit":
                echo \Entrance\Citizen::getCurrentVisitorCount();
                break;
            case "student":
                echo \Entrance\Citizen::getCurrentStudentCount();
                break;
            default:
                echo \Entrance\Citizen::getCurrentCitizenCount("","","");
        }
        exit;
    } else {
        echo "NO!";
        exit();
    }
} elseif($action == "kickall") {
    if($user->isActionAllowed(PERM_ADMIN_KICKALL)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Alle rausschmeißen", $user);
        $dwoo->output("tpl/kickAllConfirm.tpl", $pgdata);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Alle rausschmeißen", $user);
        $dwoo->output("tpl/noPrivilegesSpecial.tpl", $pgdata);
        exit();
    }
} elseif($action == "confirmKickAll") {
    if($user->isActionAllowed(PERM_ADMIN_KICKALL)) {

        if($_POST["security1"] == "iScH bIn MiR wIrKlIsCh sIsChAaAa!!" && $_POST["security2"] == "ok") {
            \Entrance\LogEntry::kickAllCitizensOutOfState($user);
        }
        \Entrance\Util::forwardTo("citizen.php");

        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Alle rausschmeißen", $user);
        $dwoo->output("tpl/noPrivilegesSpecial.tpl", $pgdata);
        exit();
    }
} elseif($action == "addTracing" and is_numeric($cID)) {
    if($user->isActionAllowed(PERM_TRACING_ADD)) {
        \Entrance\TracingEntry::createTracingEntry(\Entrance\Citizen::fromCID($cID),$user);
        \Entrance\Util::forwardTo("citizen.php?action=citizeninfo&cID=".$cID);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fahndung hinzufügen", $user);
        $dwoo->output("tpl/noPrivilegesSpecial.tpl", $pgdata);
        exit();
    }
} elseif($action == "removeTracing" and is_numeric($cID)) {
    if($user->isActionAllowed(PERM_TRACING_REMOVE)) {
        \Entrance\TracingEntry::removeTracing(\Entrance\Citizen::fromCID($cID));
        \Entrance\Util::forwardTo("citizen.php?action=citizeninfo&cID=".$cID);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Fahndung entfernen", $user);
        $dwoo->output("tpl/noPrivilegesSpecial.tpl", $pgdata);
        exit();
    }
} elseif($action == "addRoll" and is_numeric($cID)) {
    if($user->isActionAllowed(PERM_USER_EDIT)) {
        \Entrance\Citizen::fromCID($cID)->addRoll($roll);
        \Entrance\Util::forwardTo("citizen.php?action=citizeninfo&cID=".$cID);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Rolle hinzufügen", $user);
        $dwoo->output("tpl/noPrivilegesSpecial.tpl", $pgdata);
        exit();
    }
} elseif($action == "removeRoll" and is_numeric($cID)) {
    if($user->isActionAllowed(PERM_USER_EDIT)) {
        \Entrance\Citizen::fromCID($cID)->removeRoll($roll);
        \Entrance\Util::forwardTo("citizen.php?action=citizeninfo&cID=".$cID);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Rolle entfernen", $user);
        $dwoo->output("tpl/noPrivilegesSpecial.tpl", $pgdata);
        exit();
    }
}


if($user->isActionAllowed(PERM_CITIZEN_VIEW)) {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Person", $user);
    $pgdata["page"]["type"] = "";

    $dwoo->output("tpl/citizenList.tpl", $pgdata);
} else {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Person", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}