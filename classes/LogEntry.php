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
    private $lID, $cID, $uID,  $timestamp, $action, $success;

    /**
     * LogEntry constructor.
     * @param $lID
     * @param $cID
     * @param $uID
     * @param $timestamp
     * @param $action
     * @param $success
     */
    public function __construct($lID, $cID, $uID, $timestamp, $action, $success) {
        $this->lID = $lID;
        $this->cID = $cID;
        $this->uID = $uID;
        $this->timestamp = $timestamp;
        $this->action = $action;
        $this->success = $success;
    }

    /**
     * @return LogEntry[]
     */
    public static function getAllLogs() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs ORDER BY lID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\LogEntry::fromLID");
    }

        /**
         * @param int $cID
         * @return LogEntry[]
         */
    public static function getAllLogsPerCID($cID) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs WHERE cID = :cid ORDER BY lID DESC", [":cid" => $cID]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\LogEntry::fromLID");
    }

    /**
     * @param int $lID
     * @return LogEntry
     */
    public static function fromLID($lID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_logs WHERE lID = :lid", [":lid" => $lID]);
        return new LogEntry($lID, $res -> cID, $res->uID, $res -> timestamp, $res -> action, $res -> success);
    }


    /**
     * @param $citizen Citizen
     * @param $user User
     * @param $action int
     * @return bool
     */
    public static function createLogEntry($citizen,$user, $action) {
        $pdo = new PDO_MYSQL();
        $date = time();
        if ($citizen -> isCitizenInState() == 0){ // Schueler ist im Staat
            if($citizen -> getClasslevel() != 16) { //Person ist kein Kurier
                if ($action == 1) { //Schueler ist im Staat und verlaesst ihn
                    $pdo = new PDO_MYSQL();
                    $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 1)",
                        [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                    return true;
                }
                if ($action == 0) { //Schueler ist im Staat und betritt ihn -> Error
                    $pdo = new PDO_MYSQL();
                    $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 0)",
                        [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                    Error::createError($citizen->getCID(), 1);
                    return false;
                }
            }else{ //Person ist Kurier
                if ($action == 0) { //Schueler ist im Staat und verlaesst ihn
                    $pdo = new PDO_MYSQL();
                    $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 1)",
                        [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                    return true;
                }
                if ($action == 1) { //Schueler ist im Staat und betritt ihn -> Error
                    $pdo = new PDO_MYSQL();
                    $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 0)",
                        [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                    Error::createError($citizen->getCID(), 1);
                    return false;
                }
            }
        }
        else{ //Schueler ist nicht im Staat
            if($citizen -> getClasslevel() == 16) {
                if ($action == 0) { //Schueler ist nicht im Staat und betritt ihn
                    $pdo = new PDO_MYSQL();
                    $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 1)",
                        [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                    return true;
                }
                if ($action == 1) { //Schueler ist nicht im Staat und verlaesst ihn -> Error
                    $pdo = new PDO_MYSQL();
                    $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 0)",
                        [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                    Error::createError($citizen->getCID(), 2);
                    return false;
                }
            }else{
                if ($action == 1) { //Schueler ist nicht im Staat und betritt ihn
                    $pdo = new PDO_MYSQL();
                    $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 1)",
                        [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                    return true;
                }
                if ($action == 0) { //Schueler ist nicht im Staat und verlaesst ihn -> Error
                    $pdo = new PDO_MYSQL();
                    $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 0)",
                        [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                    Error::createError($citizen->getCID(), 2);
                    return false;
                }
            }
        }

    }

    /**
     * @param $citizen Citizen
     * @param $user User
     * @return bool
     */
    public static function forceErrorCorrect($citizen, $user){
        $pdo = new PDO_MYSQL();
        $date = time();
        if ($citizen -> isCitizenInState() == 1){
            $pdo = new PDO_MYSQL();
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 0, 0)",
                [":cID" => $citizen -> getCID(), ":uID" => $user -> getUID(), ":timestamp" => $date]);
            self::invalidateLogEntryBeforeEntry($citizen -> getCID(), self::getLastEntry($citizen -> getCID()));
            Error::correctError($citizen -> getCID());
            self::createLogEntry($citizen, $user, 1);
            return true;
        }
        elseif($citizen -> isCitizenInState() == 0){
            $pdo = new PDO_MYSQL();
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 1, 0)",
                [":cID" => $citizen -> getCID(), ":uID" => $user -> getUID(), ":timestamp" => $date]);
            self::invalidateLogEntryBeforeEntry($citizen -> getCID(), self::getLastEntry($citizen -> getCID()));
            Error::correctError($citizen -> getCID());
            self::createLogEntry($citizen, $user, 0);
            return true;
        }
    }

    public static function invalidateLogEntryBeforeEntry($cID, $lID){
        $pdo = new PDO_MYSQL();
        $toUpdate = $pdo -> query("SELECT * FROM entrance_logs WHERE cID = :cID AND success = 1 AND lID < :lID ORDER BY lID DESC LIMIT 1",
                [":cID" => $cID, ":lID" => $lID]) -> lID;
        $pdo -> query("UPDATE entrance_logs SET success = 0 WHERE lID = :lID", [":lID" => $toUpdate]);
    }

    public static function getLastEntry($cID){
        $pdo = new PDO_MYSQL();
        return $pdo -> query("SELECT * FROM entrance_logs WHERE cID = :cID ORDER BY lID DESC LIMIT 1",
            [":cID" => $cID]) -> lID;
    }
    /**
     * @return int
     */
    public function timeBetweenTwoEntries(){
        $pdo = new PDO_MYSQL();
        $timeOld = $pdo -> query("SELECT * FROM entrance_logs WHERE cID = :cID AND success = 1 AND lID < :lID ORDER BY lID DESC LIMIT 1",
            [":cID" => $this -> cID, ":lID" => $this -> lID]) -> timestamp;
        return strtotime($this -> timestamp) - strtotime($timeOld);
    }

    /**
     * @param $cID int
     * @param $date timestamp
     * @return LogEntry[]
     */
    public static function allLogsPerDay($cID, $date){
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs WHERE cID = :cid AND success = 1 AND action = 1 AND DATE(`timestamp`)= :date", [":cid" => $cID, ":date" => $date]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\LogEntry::fromLID");
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

    public function asArray() {
        return [
            "action" => $this->action,
            "scanner" => User::fromUID($this->uID)->getPrefixAsHtml().User::fromUID($this->uID)->getUName(),
            "uID" => $this->uID,
            "cID" => $this->cID,
            "lID" => $this->lID,
            "timeSinceLast" => $this->timeBetweenTwoEntries() != 0 ? gmdate("H\h i\m s\s", $this->timeBetweenTwoEntries()) : "Nicht anwesend",
            "timestamp" => date("d. M Y - H:i", strtotime($this->timestamp)),
            "success" => $this->success
        ];
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