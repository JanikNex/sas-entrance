<?php
/**
 * Created by PhpStorm.
 * User: Janik Rapp
 * Date: 10.04.2016
 * Time: 18:47
 */

namespace Entrance;
use PDO;

class TracingEntry {
    private $tID, $cID, $uID,  $timestamp, $active;

    /**
     * TracingEntry constructor.
     * @param $tID
     * @param $cID
     * @param $uID
     * @param $timestamp
     * @param $active
     */
    public function __construct($tID, $cID, $uID, $timestamp, $active) {
        $this->tID = $tID;
        $this->cID = $cID;
        $this->uID = $uID;
        $this->timestamp = $timestamp;
        $this->active = $active;
    }

    /**
     * Creates a new TracingEntry object from data from the db, using the provided tID
     *
     * @param int $tID
     * @return TracingEntry | bool
     */
    public static function fromTID($tID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_tracing WHERE tID = :tid", [":tid" => $tID]);
        if(isset($res->cID))
            return new TracingEntry($tID, $res -> cID, $res->uID, $res -> timestamp, $res -> active);
        else return false;
    }

    /**
     * Returns all logs found in the db
     *
     * @return TracingEntry[]
     */
    public static function getAllLogs() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_tracing ORDER BY tID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\TracingEntry::fromTID");
    }

    /**
     * @see getAllLogs(), but for a specifc cID only
     *
     * @param int $cID
     * @return TracingEntry[]
     */
    public static function getAllLogsPerCID($cID) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT tID FROM entrance_tracing WHERE cID = :cid ORDER BY tID DESC", [":cid" => $cID]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\TracingEntry::fromTID");
    }

    /**
     * Creates a new TracingEntry and returns the success as bool
     * @param $citizen Citizen
     * @param $user User
     * @return bool
     */
    public static function createTracingEntry($citizen, $user) {
        if(!$citizen -> isCitizenWanted()) {
            $pdo = new PDO_MYSQL();
            $date = date("Y-m-d H:i:s");
            $pdo->query("INSERT INTO entrance_tracing(cID, uID,`timestamp`, `active`) VALUES (:cID,:uID, :timestamp, 1)",
                [":cID" => $citizen->getCID(), ":uID" => $user->getUID(), ":timestamp" => $date]);
            return true;
        }else return false;
    }

    /**
     * @param $citizen Citizen
     * @return bool
     */
    public static function removeTracing($citizen) {
        if($citizen -> isCitizenWanted()) {
            $pdo = new PDO_MYSQL();
            $pdo -> query("UPDATE entrance_tracing SET active = 0 WHERE cID = :cID", [":cID" => $citizen->getCID()]);
            return true;
        }else return false;
    }
    /**
     * @return mixed
     */
    public function getTID() {
        return $this->tID;
    }

    /**
     * @return mixed
     */
    public function getCID() {
        return $this->cID;
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
    public function getActive() {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function isActive() {
        if($this->getActive()==1) return true;
        else return false;
    }
}