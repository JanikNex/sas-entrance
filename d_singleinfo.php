<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 11.07.2016
     * Time: 19:48
     */

    error_reporting(E_ALL && ~E_NOTICE);
    ini_set("diplay_errors", "on");

    require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
    require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    require_once 'classes/User.php';
    require_once 'classes/Permissions.php';
    require_once 'classes/Util.php';
    require_once 'classes/Citizen.php';
    require_once 'classes/Error.php';
    require_once 'classes/TracingEntry.php';
    require_once 'classes/Employer.php';
    require_once 'classes/LogEntry.php';

    $action = $_GET['action'];

    if($action != "counter") $user = \Entrance\Util::checkSession();
    $pdo = new \Entrance\PDO_MYSQL();
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();

    if($action == "barcodeInfo"){
        $barcode = $_GET["barcode"];
        $citizen = \Entrance\Citizen::fromBarcode($barcode);
        if($citizen->getCID() != null)$toEncode["success"] = true;
        else $toEncode["success"] = false;
        $toEncode["citizen"] = $citizen->asArray();
        $toEncode["log"] = [];
        $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
        for ($i = 0; $i < sizeof($itsLogs); $i++) {
            $toEncode["log"][$i] = $itsLogs[$i]->asArray();
        }
        echo json_encode($toEncode);
    } else {
        if($user->isActionAllowed(PERM_CITIZEN_VIEW)) {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Einzelne Person", $user);
            $pgdata["page"]["type"] = "";

            $dwoo->output("tpl/singleInfo.tpl", $pgdata);
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Person", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        }
    }