<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 07.03.2016
 * Time: 02:01
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$uID    = $_GET['uID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_USER_CREATE)) {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user, false, true, "users.php");
        $dwoo->output("tpl/usersNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "edit" and is_numeric($uID)) {
    if ($user->isActionAllowed(PERM_USER_EDIT) or $uID == $user->getUID()) {
        $userToEdit = \Entrance\User::fromUID($uID);
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user, false, true, "users.php");
        $pgdata["edit"] = $userToEdit->asArray();
        $pgdata["perm"] = $userToEdit->getPermAsArray();
        $pgdata["permU"] = $user->getPermAsArray();
        $dwoo->output("tpl/usersEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_USER_CREATE)) {
        $userToEdit = \Entrance\User::createUser($_POST['usrname'], $_POST['email'], $_POST['passwd']);
        \Entrance\Util::forwardTo("users.php");
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "postEdit" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_EDIT) or $uID == $user->getUID()) {
        $userToEdit = \Entrance\User::fromUID($uID);
        switch($_GET['field']) {
            case "all":
                if($_POST['usrname'] != null)$userToEdit->setUName($_POST['usrname']);
                if($_POST['email'] != null)$userToEdit->setUEmail($_POST['email']);
                $userToEdit->setUPrefix($_POST['lvl']);
                break;
            case "passwd":
                if($_POST['passwd'] == $_POST['passwd2'])
                    $userToEdit->setUPassHash($_POST['passwd']);
                else {
                    echo "Passwörter stimmen nicht überein!";
                    exit;
                }
                break;
        }

        $userToEdit->saveChanges();
        \Entrance\Util::forwardTo("users.php?action=edit&uID=".$uID);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "del" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_DELETE)) {
        $userToDelete = \Entrance\User::fromUID($uID);
        $userToDelete->delete();
        \Entrance\Util::forwardTo("users.php");
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "updatePerms" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_EDIT_PERMISSIONS)) {
        $userToEdit = \Entrance\User::fromUID($uID);
        foreach($_POST as $key => $value) {
            $userToEdit->setPermission(str_replace("_", ".", $key), $value);
        }
        \Entrance\Util::forwardTo("users.php?action=edit&uID".$uID);
        exit;
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
} elseif($action == "postPreset" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_EDIT_PERMISSIONS or PERM_USER_GUARDCONTROL)) {
        $userToEdit = \Entrance\User::fromUID($uID);
        switch($_POST["preset"]) {
            case 0:
                $userToEdit->setPermission(PERM_DB_LOGIN, 0);
                $userToEdit->setPermission(PERM_ADMIN_ERRORS, 0);
                $userToEdit->setPermission(PERM_ADMIN_NOTIFY, 0);
                $userToEdit->setPermission(PERM_ADMIN_KICKALL, 0);
                $userToEdit->setPermission(PERM_ADMIN_EXPORT, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_CLOSE, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_OPEN, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_DASHBOARD, 0);

                $userToEdit->setPermission(PERM_USER_DELETE, 0);
                $userToEdit->setPermission(PERM_USER_EDIT, 0);
                $userToEdit->setPermission(PERM_USER_CREATE, 0);
                $userToEdit->setPermission(PERM_USER_VIEW, 0);
                $userToEdit->setPermission(PERM_USER_EDIT_PERMISSIONS, 0);
                $userToEdit->setPermission(PERM_USER_GUARDCONTROL, 0);

                $userToEdit->setPermission(PERM_CITIZEN_LOGIN, 0);
                $userToEdit->setPermission(PERM_CITIZEN_LOGOUT, 0);
                $userToEdit->setPermission(PERM_CITIZEN_CORRECT_ERRORS, 0);
                $userToEdit->setPermission(PERM_CITIZEN_IGNORE_ERRORS, 0);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_NUMBER, 0);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_LIST, 0);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_SPECIFIC, 0);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_DIFFERENCE, 0);

                $userToEdit->setPermission(PERM_CITIZEN_DELETE, 0);
                $userToEdit->setPermission(PERM_CITIZEN_EDIT, 0);
                $userToEdit->setPermission(PERM_CITIZEN_CREATE, 0);
                $userToEdit->setPermission(PERM_CITIZEN_VIEW, 0);

                $userToEdit->setPermission(PERM_TRACING_ADD, 0);
                $userToEdit->setPermission(PERM_TRACING_REMOVE, 0);
                $userToEdit->setPermission(PERM_TRACING_LIST, 0);
                break;
            case 1:
                $userToEdit->setPermission(PERM_DB_LOGIN, 0);
                $userToEdit->setPermission(PERM_ADMIN_ERRORS, 0);
                $userToEdit->setPermission(PERM_ADMIN_NOTIFY, 0);
                $userToEdit->setPermission(PERM_ADMIN_KICKALL, 0);
                $userToEdit->setPermission(PERM_ADMIN_EXPORT, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_CLOSE, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_OPEN, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_DASHBOARD, 0);

                $userToEdit->setPermission(PERM_USER_DELETE, 0);
                $userToEdit->setPermission(PERM_USER_EDIT, 0);
                $userToEdit->setPermission(PERM_USER_CREATE, 0);
                $userToEdit->setPermission(PERM_USER_VIEW, 0);
                $userToEdit->setPermission(PERM_USER_EDIT_PERMISSIONS, 0);
                $userToEdit->setPermission(PERM_USER_GUARDCONTROL, 0);

                $userToEdit->setPermission(PERM_CITIZEN_LOGIN, 1);
                $userToEdit->setPermission(PERM_CITIZEN_LOGOUT, 1);
                $userToEdit->setPermission(PERM_CITIZEN_CORRECT_ERRORS, 0);
                $userToEdit->setPermission(PERM_CITIZEN_IGNORE_ERRORS, 0);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_NUMBER, 0);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_LIST, 0);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_SPECIFIC, 0);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_DIFFERENCE, 0);

                $userToEdit->setPermission(PERM_CITIZEN_DELETE, 0);
                $userToEdit->setPermission(PERM_CITIZEN_EDIT, 0);
                $userToEdit->setPermission(PERM_CITIZEN_CREATE, 0);
                $userToEdit->setPermission(PERM_CITIZEN_VIEW, 0);

                $userToEdit->setPermission(PERM_TRACING_ADD, 0);
                $userToEdit->setPermission(PERM_TRACING_REMOVE, 0);
                $userToEdit->setPermission(PERM_TRACING_LIST, 0);
                break;
            case 2:
                $userToEdit->setPermission(PERM_DB_LOGIN, 0);
                $userToEdit->setPermission(PERM_ADMIN_ERRORS, 0);
                $userToEdit->setPermission(PERM_ADMIN_NOTIFY, 0);
                $userToEdit->setPermission(PERM_ADMIN_KICKALL, 0);
                $userToEdit->setPermission(PERM_ADMIN_EXPORT, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_CLOSE, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_OPEN, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_DASHBOARD, 0);

                $userToEdit->setPermission(PERM_USER_DELETE, 0);
                $userToEdit->setPermission(PERM_USER_EDIT, 0);
                $userToEdit->setPermission(PERM_USER_CREATE, 0);
                $userToEdit->setPermission(PERM_USER_VIEW, 0);
                $userToEdit->setPermission(PERM_USER_EDIT_PERMISSIONS, 0);
                $userToEdit->setPermission(PERM_USER_GUARDCONTROL, 0);

                $userToEdit->setPermission(PERM_CITIZEN_LOGIN, 0);
                $userToEdit->setPermission(PERM_CITIZEN_LOGOUT, 0);
                $userToEdit->setPermission(PERM_CITIZEN_CORRECT_ERRORS, 0);
                $userToEdit->setPermission(PERM_CITIZEN_IGNORE_ERRORS, 0);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_NUMBER, 0);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_LIST, 1);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_SPECIFIC, 1);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_DIFFERENCE, 0);

                $userToEdit->setPermission(PERM_CITIZEN_DELETE, 0);
                $userToEdit->setPermission(PERM_CITIZEN_EDIT, 0);
                $userToEdit->setPermission(PERM_CITIZEN_CREATE, 0);
                $userToEdit->setPermission(PERM_CITIZEN_VIEW, 1);

                $userToEdit->setPermission(PERM_TRACING_ADD, 1);
                $userToEdit->setPermission(PERM_TRACING_REMOVE, 1);
                $userToEdit->setPermission(PERM_TRACING_LIST, 1);
                break;
            case 3:
                $userToEdit->setPermission(PERM_DB_LOGIN, 0);
                $userToEdit->setPermission(PERM_ADMIN_ERRORS, 0);
                $userToEdit->setPermission(PERM_ADMIN_NOTIFY, 0);
                $userToEdit->setPermission(PERM_ADMIN_KICKALL, 0);
                $userToEdit->setPermission(PERM_ADMIN_EXPORT, 0);
                $userToEdit->setPermission(PERM_ADMIN_STATE_CLOSE, 1);
                $userToEdit->setPermission(PERM_ADMIN_STATE_OPEN, 1);
                $userToEdit->setPermission(PERM_ADMIN_STATE_DASHBOARD, 1);

                $userToEdit->setPermission(PERM_USER_DELETE, 0);
                $userToEdit->setPermission(PERM_USER_EDIT, 1);
                $userToEdit->setPermission(PERM_USER_CREATE, 0);
                $userToEdit->setPermission(PERM_USER_VIEW, 1);
                $userToEdit->setPermission(PERM_USER_EDIT_PERMISSIONS, 0);
                $userToEdit->setPermission(PERM_USER_GUARDCONTROL, 1);

                $userToEdit->setPermission(PERM_CITIZEN_LOGIN, 0);
                $userToEdit->setPermission(PERM_CITIZEN_LOGOUT, 0);
                $userToEdit->setPermission(PERM_CITIZEN_CORRECT_ERRORS, 0);
                $userToEdit->setPermission(PERM_CITIZEN_IGNORE_ERRORS, 0);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_NUMBER, 1);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_LIST, 1);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_SPECIFIC, 1);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_DIFFERENCE, 1);

                $userToEdit->setPermission(PERM_CITIZEN_DELETE, 0);
                $userToEdit->setPermission(PERM_CITIZEN_EDIT, 1);
                $userToEdit->setPermission(PERM_CITIZEN_CREATE, 1);
                $userToEdit->setPermission(PERM_CITIZEN_VIEW, 1);

                $userToEdit->setPermission(PERM_TRACING_ADD, 0);
                $userToEdit->setPermission(PERM_TRACING_REMOVE, 0);
                $userToEdit->setPermission(PERM_TRACING_LIST, 1);
                break;
            case 4:
                $userToEdit->setPermission(PERM_DB_LOGIN, 1);
                $userToEdit->setPermission(PERM_ADMIN_ERRORS, 1);
                $userToEdit->setPermission(PERM_ADMIN_NOTIFY, 1);
                $userToEdit->setPermission(PERM_ADMIN_KICKALL, 1);
                $userToEdit->setPermission(PERM_ADMIN_EXPORT, 1);
                $userToEdit->setPermission(PERM_ADMIN_STATE_CLOSE, 1);
                $userToEdit->setPermission(PERM_ADMIN_STATE_OPEN, 1);
                $userToEdit->setPermission(PERM_ADMIN_STATE_DASHBOARD, 1);

                $userToEdit->setPermission(PERM_USER_DELETE, 1);
                $userToEdit->setPermission(PERM_USER_EDIT, 1);
                $userToEdit->setPermission(PERM_USER_CREATE, 1);
                $userToEdit->setPermission(PERM_USER_VIEW, 1);
                $userToEdit->setPermission(PERM_USER_EDIT_PERMISSIONS, 1);
                $userToEdit->setPermission(PERM_USER_GUARDCONTROL, 1);

                $userToEdit->setPermission(PERM_CITIZEN_LOGIN, 1);
                $userToEdit->setPermission(PERM_CITIZEN_LOGOUT, 1);
                $userToEdit->setPermission(PERM_CITIZEN_CORRECT_ERRORS, 1);
                $userToEdit->setPermission(PERM_CITIZEN_IGNORE_ERRORS, 1);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_NUMBER, 1);
                $userToEdit->setPermission(PERM_CITIZEN_PRESENT_LIST, 1);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_SPECIFIC, 1);
                $userToEdit->setPermission(PERM_CITIZEN_INFO_DIFFERENCE, 1);

                $userToEdit->setPermission(PERM_CITIZEN_DELETE, 1);
                $userToEdit->setPermission(PERM_CITIZEN_EDIT, 1);
                $userToEdit->setPermission(PERM_CITIZEN_CREATE, 1);
                $userToEdit->setPermission(PERM_CITIZEN_VIEW, 1);

                $userToEdit->setPermission(PERM_TRACING_ADD, 1);
                $userToEdit->setPermission(PERM_TRACING_REMOVE, 1);
                $userToEdit->setPermission(PERM_TRACING_LIST, 1);
                break;
            default:
                breaK;
        }
        \Entrance\Util::forwardTo("users.php?action=edit&uID=".$userToEdit->getUID());
        exit;

    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        exit;
    }
}

if($user->isActionAllowed(PERM_USER_VIEW)) {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
    $users = \Entrance\User::getAllUsers($_GET["sort"], $_GET["filter"]);
    for ($i = 0; $i < sizeof($users); $i++) {
        $pgdata["page"]["items"][$i] = $users[$i]->asArray();
    }
    if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "ascName";
    if(isset($_GET["filter"])) $pgdata["page"]["filter"] = $_GET["filter"]; else $pgdata["page"]["filter"] = "Alle";

    $dwoo->output("tpl/users.tpl", $pgdata);
} else {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}
