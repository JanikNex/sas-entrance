<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 12.07.2016
     * Time: 22:31
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

    if($action == "getInfo") {
        $students = \Entrance\Citizen::getAllCitizenInStateSimple("ascID", "Schüler");
        $visa = \Entrance\Citizen::getAllVisitorsInState();
        $courriers = \Entrance\Citizen::getAllCourriersOutOfState();
        $toEncode = [
            "students" => $students,
            "visum"    => $visa,
            "courrier" => $courriers
        ];
        echo json_encode($toEncode);
    } else if($action == "doKick") {
        if($user->isActionAllowed(PERM_ADMIN_KICKALL)) {
            $cID = intval($_GET["cID"]);
            $citizen = \Entrance\Citizen::fromCID($cID);
            $citizen->kickCitizenOutOfState($user);
            echo json_encode(["success" => true]);
        }
    } else {
        if($user->isActionAllowed(PERM_ADMIN_KICKALL)) {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Alle ausbuchen", $user);
            $pgdata["page"]["type"] = "";

            $dwoo->output("tpl/kickAll.tpl", $pgdata);
        } else {
            $pgdata = \Entrance\Util::getEditorPageDataStub("Person", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
        }
    }