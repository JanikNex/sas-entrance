<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 09.03.2016
 * Time: 23:01
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once 'classes/Util.php';
require_once 'classes/Citizen.php';
require_once 'classes/LogEntry.php';
require_once 'classes/Error.php';
$user = \Entrance\Util::checkSession();
$pdo = new \Entrance\PDO_MYSQL();
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
if(\Entrance\Util::isStateOpen()) {
    if ($action == "checkInScan") {
        if ($user->isActionAllowed(PERM_CITIZEN_LOGIN)) {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Einbuchen", $user);
            $pgdata["header"]["switchmode"] = 1;
            $pgdata["header"]["switchmodeTo"] = "check.php?action=checkOut";
            if (\Entrance\Citizen::doesBarcodeExist($_POST["barcode"])) {
                $citizen = \Entrance\Citizen::fromBarcode($_POST["barcode"]);
                if ($citizen->tryCheckIn($user)) {
                    $pgdata["page"]["scan"]["success"] = 1;
                    $pgdata["page"]["citizen"] = $citizen->asArray();
                    $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
                    for ($i = 0; $i < sizeof($itsLogs); $i++) {
                        $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
                        if ($i >= 1) break;
                    }
                } else {
                    goto cError;
                }
            } else {
                \Entrance\Error::createError(0, 8);
                $citizen = \Entrance\Citizen::fromCID(0);
                goto cError;
            }
            goto output;
            cError: {
                $pgdata["page"]["scan"]["success"] = 2;
                $pgdata["page"]["citizen"] = $citizen->asArray();
                $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
                for ($i = 0; $i < sizeof($itsLogs); $i++) {
                    $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
                    if ($i >= 1) break;
                }
                $pgdata["page"]["error"] = $citizen->getLastError()->asArray();
            }

            output: {
                $dwoo->output("tpl/checkIn.tpl", $pgdata);
            }
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Einbuchen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        }
    } elseif ($action == "checkOutScan") {
        if ($user->isActionAllowed(PERM_CITIZEN_LOGOUT)) {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Ausbuchen", $user);
            $pgdata["header"]["switchmode"] = 1;
            $pgdata["header"]["switchmodeTo"] = "check.php?action=checkIn";

            if (\Entrance\Citizen::doesBarcodeExist($_POST["barcode"])) {
                $citizen = \Entrance\Citizen::fromBarcode($_POST["barcode"]);
                if ($citizen->hasCitizenEnoughTime() or $_POST["force"] == "true") {
                    if ($citizen->tryCheckOut($user)) {
                        $pgdata["page"]["scan"]["success"] = 1;
                        $pgdata["page"]["citizen"] = $citizen->asArray();
                        $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
                        for ($i = 0; $i < sizeof($itsLogs); $i++) {
                            $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
                            if ($i >= 1) break;
                        }
                    } else goto cError;
                } else {
                    $pgdata["page"]["barcode"] = $_POST["barcode"];
                    $pgdata["page"]["citizen"] = $citizen->asArray();
                    $dwoo->output("tpl/checkOutConfirm.tpl", $pgdata);
                    exit;
                }
            } else {
                \Entrance\Error::createError(0, 9);
                $citizen = \Entrance\Citizen::fromCID(0);
                goto cErroor;
            }
            goto outpuut;
            cErroor: {
                $pgdata["page"]["scan"]["success"] = 2;
                $pgdata["page"]["citizen"] = $citizen->asArray();
                $itsLogs = \Entrance\LogEntry::getAllLogsPerCID($citizen->getCID());
                for ($i = 0; $i < sizeof($itsLogs); $i++) {
                    $pgdata["page"]["logs"][$i] = $itsLogs[$i]->asArray();
                    if ($i >= 1) break;
                }
                $pgdata["page"]["error"] = $citizen->getLastError()->asArray();
            }

            outpuut: {
                $dwoo->output("tpl/checkOut.tpl", $pgdata);
            }
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Ausbuchen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        }

        // -------------------------------------------------------------------------

    } elseif ($action == "checkIn") {
        if ($user->isActionAllowed(PERM_CITIZEN_LOGIN)) {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Einbuchen", $user);
            $pgdata["header"]["switchmode"] = 1;
            $pgdata["header"]["switchmodeTo"] = "check.php?action=checkOut";

            $dwoo->output("tpl/checkIn.tpl", $pgdata);
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Einbuchen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        }
    } elseif ($action == "checkOut") {
        if ($user->isActionAllowed(PERM_CITIZEN_LOGOUT)) {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Ausbuchen", $user);
            $pgdata["header"]["switchmode"] = 1;
            $pgdata["header"]["switchmodeTo"] = "check.php?action=checkIn";

            $dwoo->output("tpl/checkOut.tpl", $pgdata);
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Ausbuchen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        }
    }
} else{
    if($action == "checkIn" or $action == "checkInScan"){
        $pgdata = \Entrance\Util::getEditorPageDataStub("Einbuchen", $user);
        $pgdata["page"]["scan"]["success"] = 3;
        $dwoo->output("tpl/checkIn.tpl", $pgdata);
    } else {
        $pgdata = \Entrance\Util::getEditorPageDataStub("Ausbuchen", $user);
        $pgdata["page"]["scan"]["success"] = 3;
        $dwoo->output("tpl/checkOut.tpl", $pgdata);
    }
}
