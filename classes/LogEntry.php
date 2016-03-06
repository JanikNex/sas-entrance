<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 06.03.2016
 * Time: 18:50
 */

namespace Entrance;


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

    }

    public static function fromLID($lID) {

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