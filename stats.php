<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 22.06.2016
     * Time: 21:04
     */
    require_once "classes/PDO_MYSQL.php";
    require_once "classes/Citizen.php";
    require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    require_once 'classes/Permissions.php';
    require_once 'classes/Util.php';
    require_once 'classes/User.php';

    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();
    $pdo = new \Entrance\PDO_MYSQL();
    $action = $_GET["action"];

    if($action == "savedatapoint") {
        $time = date("Y-m-d H:i:s");
        $currInState = \Entrance\Citizen::getCurrentCitizenCount();
        $currStudents = \Entrance\Citizen::getCurrentStudentCount();
        $currVisitors = \Entrance\Citizen::getCurrentVisitorCount();

        //$pdo->query("INSERT INTO entrance_statistics(timestamp, countAll, countStudents, countVisitors) VALUES (:date, :countAll, :countStudents, :countVisitors)", [":date"          => $time,
        //                                                                                                                                                             ":countAll"      => $currInState,
        //                                                                                                                                                            ":countStudents" => $currStudents,
        //                                                                                                                                                             ":countVisitors" => $currVisitors]);
    } else if($action == "getData") {
        $user = \Entrance\Util::checkSession();
        $query = "SELECT * FROM entrance_statistics";
        $stmt = $pdo->queryMulti($query);
        $toEncode = ["all" => [], "students" => [], "visitors" => []];
        while($row = $stmt->fetch()) {
            array_push($toEncode["all"], [substr(date(DATE_W3C, strtotime($row["timestamp"])), 0, 16), intval($row["countAll"])]);
            array_push($toEncode["students"], [substr(date(DATE_W3C, strtotime($row["timestamp"])), 0, 16), intval($row["countStudents"])]);
            array_push($toEncode["visitors"], [substr(date(DATE_W3C, strtotime($row["timestamp"])), 0, 16), intval($row["countVisitors"])]);
        }
        echo json_encode($toEncode);
    } else if($action == "getDataLogsPerMinute") {
        $user = \Entrance\Util::checkSession();
        $query = "SELECT (unix_timestamp(`timestamp`) - unix_timestamp(`timestamp`)%240) groupTime, count(*) as count FROM entrance_logs GROUP BY groupTime";
        $stmt = $pdo->queryMulti($query);
        $toEncode = ["all" => []];
        while($row = $stmt->fetch()) {
            array_push($toEncode["all"], [substr(date(DATE_W3C, $row["groupTime"]), 0, 16), intval($row["count"])/4]);
        }
        echo json_encode($toEncode);
    } else {
        $user = \Entrance\Util::checkSession();
        $pgdata = \Entrance\Util::getEditorPageDataStub("Statistik", $user, false, false);
        $dwoo->output("tpl/stats.tpl", $pgdata);
    }
