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
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
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
        $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
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
}

if($user->isActionAllowed(PERM_USER_VIEW)) {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
    $users = \Entrance\User::getAllUsers();
    for ($i = 0; $i < sizeof($users); $i++) {
        $pgdata["page"]["items"][$i] = $users[$i]->asArray();
    }

    $dwoo->output("tpl/users.tpl", $pgdata);
} else {
    $pgdata = \Entrance\Util::getEditorPageDataStub("Benutzer", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}