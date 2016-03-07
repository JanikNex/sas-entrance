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
    private $lID, $uID, $timestamp, $action, $success;

    /**
     * LogEntry constructor.
     * @param $lID
     * @param $uID
     * @param $timestamp
     * @param $action
     * @param $success
     */
    public function __construct($lID, $uID, $timestamp, $action, $success) {
        $this->lID = $lID;
        $this->uID = $uID;
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
        return new LogEntry($res -> uID, $res -> timestamp, $res -> action, $res -> success);
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
                $pdo->query("INSERT INTO entrance_error(cID,`timestamp`, error) VALUES (:cID, :timestamp, 1)",
                    [":cID" => $citizen -> getCID(), ":timestamp" => $date]);
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
                $pdo->query("INSERT INTO entrance_error(cID,`timestamp`, error) VALUES (:cID, :timestamp, 2)",
                    [":cID" => $citizen -> getCID(), ":timestamp" => $date]);
            }
        }

    }

    /**
     * @return mixed
     */
    public function getUID() {
        return $this->uID;
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