<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 05.03.2016
 * Time: 21:37
 */

require_once "classes/Util.php";

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';

$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$dwoo->output("tpl/index.tpl", \Entrance\Util::getEditorPageDataStub("Startseite", $user));