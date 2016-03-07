<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 06.03.2016
 * Time: 18:50
 */

namespace Entrance;
use PDO;

class LogEntry {
    private $lID, $cID, $timestamp, $action, $success;

    /**
     * LogEntry constructor.
     * @param $lID
     * @param $cID
     * @param $timestamp
     * @param $action
     * @param $success
     */
    public function __construct($lID, $cID, $timestamp, $action, $success) {
        $this->lID = $lID;
        $this->cID = $cID;
        $this->timestamp = $timestamp;
        $this->action = $action;
        $this->success = $success;
    }

    /**
     * @param int $limit
     * @return LogEntry[]
     */
    public static function getAllLogs($limit = 18446744073709551610) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs ORDER BY lID LIMIT :limit");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Logs::fromLID");
    }

    /**
     * @param $lID
     * @return LogEntry
     */
    public static function fromLID($lID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_logs WHERE lID = :lid", [":lid" => $lID]);
        return new LogEntry($res -> cID, $res -> timestamp, $res -> action, $res -> success);
    }

    /**
     * @param $citizen Citizen
     * @param $action
     */
    public static function createLogEntry($citizen, $action) {
        $pdo = new PDO_MYSQL();
        $date = time();
        if ($citizen -> isCitizenInState()){
            if ($action == 1){ //Schueler ist im Staat und verlaesst ihn
                $pdo = new PDO_MYSQL();
                $pdo->query("INSERT INTO entrance_logs(cID,`timestamp`, `action`, success) VALUES (:cID, :timestamp, :action, 1)",
                    [":cID" => $citizen -> getCID(), ":timestamp" => $date, ":action" => $action]);
            }
            if ($action == 0){ //Schueler ist im Staat und betritt ihn -> Error
                $pdo = new PDO_MYSQL();
                $pdo->query("INSERT INTO entrance_logs(cID,`timestamp`, `action`, success) VALUES (:cID, :timestamp, :action, 0)",
                    [":cID" => $citizen -> getCID(), ":timestamp" => $date, ":action" => $action]);
                Error::createError($citizen -> getCID(), 1);
            }
        }
        else{
            if ($action == 0){ //Schueler ist nicht im Staat und betritt ihn
                $pdo = new PDO_MYSQL();
                $pdo->query("INSERT INTO entrance_logs(cID,`timestamp`, `action`, success) VALUES (:cID, :timestamp, :action, 1)",
                    [":cID" => $citizen -> getCID(), ":timestamp" => $date, ":action" => $action]);
            }
            if ($action == 1){ //Schueler ist nicht im Staat und verlaesst ihn -> Error
                $pdo = new PDO_MYSQL();
                $pdo->query("INSERT INTO entrance_logs(cID,`timestamp`, `action`, success) VALUES (:cID, :timestamp, :action, 0)",
                    [":cID" => $citizen -> getCID(), ":timestamp" => $date, ":action" => $action]);
                Error::createError($citizen -> getCID(), 2);
            }
        }

    }

    /**
     * @return int
     */
    public function timeBetweenTwoEntries(){
        $pdo = new PDO_MYSQL();
        $timeOld = $pdo -> query("SELECT * FROM entrance_logs WHERE cID = :cID AND success = 1 AND lID < :lID ORDER BY lID DESC LIMIT 1",
            [":cID" => $this -> cID, ":lID" => $this -> lID]) -> timestamp;
        return $this -> timestamp - $timeOld;
    }

    /**
     * @param $cID int
     * @param $date timestamp
     * @return LogEntry[]
     */
    public static function allLogsPerDay($cID, $date){
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs WHERE cID = :cid AND succes = 1 AND action = 1 AND DATE(`timestamp`)= :date", [":cid" => $cID, ":date" => $date]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Logs::fromLID");
    }

    /**
     * @return String[]
     */
    public static function getProjectDays(){
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT DATE(timestamp) AS dates FROM entrance_logs GROUP BY DATE(timestamp) ORDER BY dates");
        $dates = [];
        while($res = $stmt->fetchObject()) {
            array_push($dates, $res->dates);
        }
        return $dates;
    }

    /**
     * @return mixed
     */
    public function getUID() {
        return $this->cID;
    }

    /**
     * @return mixed
     */
    public function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getSuccess() {
        return $this->success;
    }
}