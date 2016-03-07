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
     * @param $uID
     * @param $timestamp
     * @param $action
     * @param $success
     */
    public function __construct($uID, $timestamp, $action, $success) {
        $this->uID = $uID;
        $this->timestamp = $timestamp;
        $this->action = $action;
        $this->success = $success;
    }

    public static function getAllLogs($limit = 0) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT lID FROM entrance_logs ORDER BY lID LIMIT :limit");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Logs::fromLID");
    }

    public static function fromLID($lID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_logs WHERE lID = :lid", [":lid" => $lID]);
        return new LogEntry($res -> uID, $res -> timestamp, $res -> action, $res -> success);
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