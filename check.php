<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 18.06.2016
     * Time: 01:02
     */

    error_reporting(E_ERROR);
    ini_set("diplay_errors", "on");

    require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
    require_once 'classes/User.php';
    require_once 'classes/Permissions.php';
    require_once 'classes/Util.php';
    require_once 'classes/Citizen.php';
    require_once 'classes/TracingEntry.php';
    require_once 'classes/LogEntry.php';
    require_once 'classes/Error.php';
    $user = \Entrance\Util::checkSession();
    $pdo = new \Entrance\PDO_MYSQL();

    $action = $_GET['action'];

    if($action == "barcodeInfo") {
        $barcode = $_GET["barcode"];
        $toEncode["success"] = false;

        if(is_numeric($barcode)) {
            if(\Entrance\Citizen::doesBarcodeExist($barcode)) {
                $citizen = \Entrance\Citizen::fromBarcode($barcode);
                if ($citizen instanceof \Entrance\Citizen) {
                    $toEncode["success"] = true;
                    $toEncode["cID"] = $citizen->getCID();
                    $toEncode["fname"] = $citizen->getFirstname();
                    $toEncode["lname"] = $citizen->getLastname();
                    $toEncode["classlvl"] = $citizen->getClasslevel();
                    $toEncode["enoughTime"] = $citizen->hasCitizenEnoughTime();
                    $toEncode["timeToday"] = $citizen->getTimePerDay(date("Y-m-d")) != 0 ? gmdate("H\h i\m s\s",$citizen->getTimePerDay(date("Y-m-d"))) : "<i>Nicht anwesend</i>";
                    $toEncode["locked"] = $citizen->isCitizenLocked();
                    $toEncode["wanted"] = $citizen->isCitizenWanted();
                    $toEncode["inState"] = $citizen->isCitizenInState();
                    $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
                    for ($i = 0; $i < sizeof($itsLogs); $i++) {
                        $toEncode["log"][$i] = $itsLogs[$i]->asArray();
                        if ($i >= 1) break;
                    }
                } else $toEncode["error"] = "UnknownBarcode";
            } else $toEncode["error"] = "UnknownBarcode";
        } else $toEncode["error"] = "WrongBarcodeFormat";
        echo json_encode($toEncode);
        exit;
    } elseif($action == "confirmCheckIn") {
        $cID = $_GET["cID"];
        $toEncode["success"] = false;

        if ($user->isActionAllowed(PERM_CITIZEN_LOGIN)) {
            if (is_numeric($cID)) {
                $citizen = \Entrance\Citizen::fromCID($cID);
                if($citizen instanceof \Entrance\Citizen) {
                    if($citizen->tryCheckIn($user)) {
                        $toEncode["success"] = true;
                    } else {
                        $toEncode["error"] = $citizen->getLastError()->asArray();
                    }
                } else $toEncode["error"] = "UnknownCitizenID";
            } else $toEncode["error"] = "WrongCIDFormat";
        } else $toEncode["error"] = "NoPermission";

        echo json_encode($toEncode);
        exit;
    } elseif($action == "confirmCheckOut") {
        $cID = $_GET["cID"];
        $toEncode["success"] = false;

        if ($user->isActionAllowed(PERM_CITIZEN_LOGOUT)) {
            if (is_numeric($cID)) {
                $citizen = \Entrance\Citizen::fromCID($cID);
                if($citizen instanceof \Entrance\Citizen) {
                    if($citizen->tryCheckOut($user)) {
                        $toEncode["success"] = true;
                    } else {
                        $toEncode["success"] = false;
                        $toEncode["error"] = $citizen->getLastError()->asArray();
                    }
                } else $toEncode["error"] = "UnknownCitizenID";
            } else $toEncode["error"] = "WrongCIDFormat";
        } else $toEncode["error"] = "NoPermission";

        echo json_encode($toEncode);
        exit;
    } elseif($action == "stateInfo") {
        $toEncode["stateState"] = \Entrance\Util::isStateOpen();
        echo json_encode($toEncode);
        exit;
    }