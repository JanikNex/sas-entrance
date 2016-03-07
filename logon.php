<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 07.03.2016
 * Time: 00:41
 */

require_once 'classes/PDO_MYSQL.class.php'; //DB Anbindung
require_once 'lib/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
$pdo = new PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$usrname  = $_POST['usrname'];
$password = $_POST['password'];
$logout   = $_GET['logout'];
$ses      = $_GET['badsession'];

if(isset($usrname)) {
    if(\ICMS\User::doesUserNameExist($usrname)) {

        $user = \ICMS\User::fromUName($usrname);
        if($user->comparePWHash(md5($password))) {
            session_start();
            $_SESSION['uID'] = $user->getUID();
            forwardTo("users.php");
        } else {
            $dwoo->output("tpl/logon.tpl", ["err" => "2","usrname" => $usrname]);
        }
    } else {
        $dwoo->output("tpl/logon.tpl", ["err" => "1", "usrname" => $usrname]);
    }
} elseif($logout == 1) {
    session_start();
    session_destroy();
    $dwoo->output("tpl/logon.tpl");
} else {
    $dwoo->output("tpl/logon.tpl", ["ses" => $ses]);
}