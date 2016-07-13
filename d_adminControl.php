<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 13.07.2016
     * Time: 21:58
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

    if ($action != "counter") $user = \Entrance\Util::checkSession();
    $pdo = new \Entrance\PDO_MYSQL();
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();

    if ($action == "getInfo") {
        $students = \Entrance\Citizen::getAllCitizenInStateSimple("ascID", "Schüler");
        $visa = \Entrance\Citizen::getAllVisitorsInState();
        $courriers = \Entrance\Citizen::getAllCourriersOutOfState();
        $countToday = \Entrance\LogEntry::getCountLogsToday();
        $toEncode = [
            "students" => $students,
            "visum"    => $visa,
            "courrier" => $courriers,
            "countToday" => $countToday
        ];
        echo json_encode($toEncode);
    } else if($action == "getLogsFiltered") {
        $logs = \Entrance\LogEntry::getLogsFiltered($_GET["filtertext"]);
        $toEncode = [
            "logs" => []
        ];
        foreach($logs as $log) {
            array_push($toEncode["logs"], $log->asArray());
        }
        echo json_encode($toEncode);
    } else {
        if ($user->isActionAllowed(PERM_CITIZEN_VIEW)) {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Einzelne Person", $user);
            $pgdata["page"]["type"] = "";

            $dwoo->output("tpl/adminControl.tpl", $pgdata);
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Person", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        }
    }