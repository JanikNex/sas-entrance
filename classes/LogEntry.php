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
     * Creates a new LogEntry object from data from the db, using the provided lID
     *
     * @param int $lID
     * @return LogEntry | bool
     */
    public static function fromLID($lID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_logs WHERE lID = :lid", [":lid" => $lID]);
        if(isset($res->cID))
            return new LogEntry($lID, $res -> cID, $res->uID, $res -> timestamp, $res -> action, $res -> success);
        else return false;
    }

    /**
     * Returns all logs found in the db
     * Attention: This function will destroy everything!
     * Todo Sorting options / filtering options
     *
     * @return LogEntry[]
     */
    public static function getAllLogs() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs ORDER BY lID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\LogEntry::fromLID");
    }

    /**
     * Returns the last $limit logs
     * @param $limit
     * @return LogEntry[]
     */
    public static function getNumLogs($limit) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM `entrance_logs` ORDER BY `lID` DESC LIMIT :limit", [":limit" => $limit]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\LogEntry::fromLID");
    }

    /**
     * @see getAllLogs(), but for a specifc cID only
     *
     * @param int $cID
     * @return LogEntry[]
     */
    public static function getAllLogsPerCID($cID) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs WHERE cID = :cid ORDER BY lID DESC", [":cid" => $cID]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\LogEntry::fromLID");
    }


    /**
     * Creates a new LogEntry in the db, by the data provided
     *
     * @param Citizen $citizen
     * @param User $user
     * @param int $action
     * @return bool
     */
    public static function createLogEntry($citizen, $user, $action) {
        if(!$citizen->isCitizenLocked()) {
            if (!$citizen -> isCourrier()) {
                return self::createLogEntryNormal($citizen, $user, $action);
            } else {
                return self::createLogEntryCourrier($citizen, $user, $action);
            }
        } else return false;
    }

    /**
     * @see createLogEntry()
     *
     * @param $citizen Citizen
     * @param $user User
     * @param $action int
     * @return bool
     */
    private static function createLogEntryCourrier($citizen, $user, $action) {
        $pdo = new PDO_MYSQL();
        $date = date("Y-m-d H:i:s");

        if ($citizen->isCitizenInState() == 1) {
            if ($action == 0) { //Ignoriert
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 1)",
                    [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                $citizen->updateCitizenState();
                return true;
            } elseif ($action == 1) { //Ignoriert -> Error
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 0)",
                    [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                Error::createError($citizen->getCID(), 1);
                $citizen->updateCitizenState();
                return false;
            }
        } else {
            if ($action == 1) { //Ignoriert
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 1)",
                    [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                $citizen->updateCitizenState();
                return true;
            } elseif ($action == 0) { //Ignoriert -> Error
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 0)",
                    [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                Error::createError($citizen->getCID(), 1);
                $citizen->updateCitizenState();
                return false;
            }
        }
    }

    /**
     * @see createLogEntry()
     *
     * @param $citizen Citizen
     * @param $user User
     * @param $action int
     * @return bool
     */
    private static function createLogEntryNormal($citizen, $user, $action) {
        $pdo = new PDO_MYSQL();
        $date = date("Y-m-d H:i:s");

        if ($citizen->isCitizenInState() == 0) {
            if ($action == 1) { //Schueler ist im Staat und verlaesst ihn
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 1)",
                    [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                $citizen->updateCitizenState();
                return true;
            } elseif ($action == 0) { //Schueler ist im Staat und betritt ihn -> Error
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 0)",
                    [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                Error::createError($citizen->getCID(), 1);
                $citizen->updateCitizenState();
                return false;
            }
        } else {
            if ($action == 0) { //Schueler ist nicht im Staat und betritt ihn
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 1)",
                    [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                $citizen->updateCitizenState();
                return true;
            } elseif ($action == 1) { //Schueler ist nicht im Staat und verlaesst ihn -> Error
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, :action, 0)",
                    [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date, ":action" => $action]);
                Error::createError($citizen->getCID(), 2);
                $citizen->updateCitizenState();
                return false;
            }
        }
    }

    /**
     * nicht mehr Janik's Baustelle
     */
    public function invalidateLogEntryBeforeEntry(){
        $pdo = new PDO_MYSQL();
        $toUpdate = $pdo -> query("SELECT * FROM entrance_logs WHERE cID = :cID AND success = 1 AND lID < :lID ORDER BY lID DESC LIMIT 1",
                [":cID" => $this->cID, ":lID" => $this->lID]) -> lID;
        $pdo -> query("UPDATE entrance_logs SET success = 0, `timestamp` = `timestamp` WHERE lID = :lID", [":lID" => $toUpdate]);
    }

    public function validateLogEntryBeforeEntry(){
        $pdo = new PDO_MYSQL();
        $toUpdate = $pdo -> query("SELECT * FROM entrance_logs WHERE cID = :cID AND success = 0 AND lID < :lID ORDER BY lID DESC LIMIT 1",
            [":cID" => $this->cID, ":lID" => $this->lID]) -> lID;
        $pdo -> query("UPDATE entrance_logs SET success = 1, `timestamp` = `timestamp` WHERE lID = :lID", [":lID" => $toUpdate]);
    }

    /**
     * Validates this LogEntry
     */
    public function validateLogEntry(){
        $pdo = new PDO_MYSQL();
        $pdo -> query("UPDATE entrance_logs SET success = 1, `timestamp` = `timestamp` WHERE lID = :lID", [":lID" => $this -> lID]);
    }
    /**
     * Sets Action = 2 which means that the Entry before will be ignored
     * @param $citizen Citizen
     * @param $user User
     */
    public static function ignoreLastLogEntry($citizen, $user){
        $pdo = new PDO_MYSQL();
        $toUpdate = $citizen -> getLastEntry();
        $pdo->query("UPDATE entrance_logs SET `action` = 2, uID = :uID, `timestamp` = `timestamp` WHERE lID = :lID", [":lID" => $toUpdate->getLID(), ":uID" => $user -> getUID()]);
        $citizen->updateCitizenState();
    }
    /**
     * Returns true if the last entry was a success
     *
     * @return bool
     */
    public function getEntrySuccessStatus(){
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_logs WHERE lID = :lID ", [":lID" => $this->lID])->success;
        if ($res == 1) return true;
        elseif ($res == 0) return false;
        else return true;
    }

    /**
     * Returns true if the last TWO Entries are a success
     *
     * @return bool
     */
    public function getLastTwoEntrySuccessStatus(){
        $pdo = new PDO_MYSQL();
        $stmt = $pdo -> queryMulti("SELECT * FROM entrance_logs WHERE cID = :cID AND lID <= :lID AND action != 2 ORDER BY lID DESC LIMIT 2",
            [":cID" => $this->cID, ":lID" => $this->lID]);
        $entries = $stmt -> fetchAll(PDO::FETCH_FUNC, "\\Entrance\\LogEntry::fromLID");
        if(sizeof($entries) == 2){
            return $entries[0]->getEntrySuccessStatus() or $entries[1]->getEntrySuccessStatus();
        }else{
            return false;
        }

    }
    /**
     * Returns the time between two entries in seconds
     *
     * @return int
     */
    public function timeBetweenTwoEntries(){
        $pdo = new PDO_MYSQL();
        $timeOld = $pdo -> query("SELECT * FROM entrance_logs WHERE cID = :cID AND success = 1 AND action != 2 AND lID < :lID ORDER BY lID DESC LIMIT 1",
            [":cID" => $this -> cID, ":lID" => $this -> lID]) -> timestamp;
        return strtotime($this -> timestamp) - strtotime($timeOld);
    }


    /**
     * Returns all logs on a day, for a specific Citizen
     *
     * @param $cID int
     * @param $date timestamp
     * @return LogEntry[]
     */
    public static function allLogsPerDay($cID, $date){
        $pdo = new PDO_MYSQL();
        if(Citizen::fromCID($cID) -> isCourrier()){
            $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs WHERE cID = :cid AND success = 1 AND action = 0 AND DATE(`timestamp`)= :date", [":cid" => $cID, ":date" => $date]);
        }else{
            $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs WHERE cID = :cid AND success = 1 AND action = 1 AND DATE(`timestamp`)= :date", [":cid" => $cID, ":date" => $date]);
        }
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\LogEntry::fromLID");
    }

    /**
     * Returns all days our project is on
     *
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
     * Checks out all Citizens in State!
     * @see kickCitizenOutOfState()
     *
     * @param User $user
     */
    public static function kickAllCitizensOutOfState($user){
        $citizens = Citizen::getAllCitizenInState();
        $courriers = Citizen::getAllCourriersOutOfState();

        foreach($citizens as $citizen){
            $citizen->kickCitizenOutOfState($user);
        }
        foreach($courriers as $courrier) {
            $courrier->kickCitizenOutOfState($user);
        }
    }

    public function asArray() {
        return [
            "action" => $this->action,
            "scanner" => User::fromUID($this->uID)->getPrefixAsHtml().User::fromUID($this->uID)->getUName(),
            "uID" => $this->uID,
            "cID" => $this->cID,
            "lID" => $this->lID,
            "timeSinceLast" => $this->timeBetweenTwoEntries() != 0 ? gmdate("H\h i\m s\s", $this->timeBetweenTwoEntries()) : "Nicht anwesend",
            "timestamp" => date("d. M Y - H:i:s", strtotime($this->timestamp)),
            "success" => $this->success
        ];
    }

    /**
     * @return int
     */
    public function getLID() {
        return $this->lID;
    }

    /**
     * @return int
     */
    public function getCID() {
        return $this->cID;
    }

    /**
     * @param int $cID
     */
    public function setCID($cID) {
        $this->cID = $cID;
    }

    /**
     * @return int
     */
    public function getUID() {
        return $this->uID;
    }

    /**
     * @param int $uID
     */
    public function setUID($uID) {
        $this->uID = $uID;
    }

    /**
     * @return timestamp
     */
    public function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * @param timestamp $timestamp
     */
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    /**
     * @return int
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * @param int $action
     */
    public function setAction($action) {
        $this->action = $action;
    }

    /**
     * @return int
     */
    public function getSuccess() {
        return $this->success;
    }

    /**
     * @param int $success
     */
    public function setSuccess($success) {
        $this->success = $success;
    }
}