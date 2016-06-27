<?php
/**
 * Created by PhpStorm.
 * User: Janik Rapp
 * Date: 27.06.2016
 * Time: 14:42
 */

namespace Entrance;

use PDO;


class Employer {

    private $emID, $kind, $name, $room;

    /**
     * Employer constructor.
     * @param $emID
     * @param $kind
     * @param $name
     * @param $room
     */
    public function __construct($emID, $kind, $name, $room) {
        $this->emID = $emID;
        $this->kind = $kind;
        $this->name = $name;
        $this->room = $room;
    }

    public static function fromEMID($emid) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_employer WHERE emID = :emid", [":emid" => $emid]);
        return new Employer($res->emID, $res->kind, $res->name, $res->room);
    }

    /**
     * Array with all informations
     * @return array
     */
    public function asArray(){
        return[
            "emID" => $this->emID,
            "kind" => $this->kind,
            "name" => $this->name,
            "room" => $this->room,
            "staffCount" => $this->getStaffCount(),
            "activeStaffCount" => $this->getActiveStaffCount()
        ];
    }

    /**
     * Optimized array with only the important informations
     * @return array
     */
    public function asArrayOptimized(){
        return[
            "emID" => $this->emID,
            "kind" => $this->kind,
            "name" => $this->name,
            "room" => $this->room
        ];
    }

    /**
     * @param int $page
     * @param int $pagesize
     * @param string $search
     * @return Employer[]
     */
    public static function getAllEmployers($page = 1, $pagesize = 999999, $search = ""){
        $pdo = new PDO_MYSQL();
        if($search != "") {
            $startElem = ($page-1) * $pagesize;
            $endElem = $pagesize;
            $query = "SELECT emID, kind, name, room FROM entrance_employer WHERE LOWER(CONCAT(name,' ', kind,' ',room)) LIKE LOWER('%".$search."%') LIMIT ".$startElem.','.$endElem;
            $stmt = $pdo->queryMulti($query);
            $hits = [];
            while($row = $stmt->fetch()) {
                $keys["id"] = $row["emID"];
                $keys["kind"] = utf8_encode($row["kind"]);
                $keys["name"] = utf8_encode($row["name"]);
                $keys["room"] = utf8_encode($row["room"]);
                $keys["check"] = md5($keys["id"]+$keys["kind"]+$keys["name"]+$keys["room"]);
                array_push($hits, $keys);
            }
            return $hits;
        } else {
            $startElem = ($page-1) * $pagesize;
            $endElem = $pagesize;
            $stmt = $pdo->queryMulti("SELECT emID, kind, name, room FROM entrance_employer LIMIT ".$startElem.','.$endElem);
            $hits = [];
            while($row = $stmt->fetch()) {
                $keys["id"] = $row["emID"];
                $keys["kind"] = utf8_encode($row["kind"]);
                $keys["name"] = utf8_encode($row["name"]);
                $keys["room"] = utf8_encode($row["room"]);
                $keys["check"] = md5($keys["id"]+$keys["kind"]+$keys["name"]+$keys["room"]);
                array_push($hits, $keys);
            }
            return $hits;
        }
    }

    /**
     * Returns the total count of employers
     * @param string $search
     * @return int
     */
    public static function getTotalEmployerCount($search = ""){
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT COUNT(*) as count FROM entrance_employer WHERE LOWER(CONCAT(name,' ', kind,' ',room)) LIKE LOWER('%".$search."%')");
        return $res->count;
    }

    /**
     * Returns the count of staff members
     * @return int
     */
    public function getStaffCount(){
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT COUNT(*) as count FROM entrance_employee WHERE emID = :emid", [":emid" => $this->emID]);
        return $res->count;
    }

    /**
     * Returns the count of active staff members
     * @return int
     */
    public function getActiveStaffCount(){
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("select COUNT(*) as count from entrance_employee WHERE (select state from entrance_citizen where entrance_citizen.cID = entrance_employee.cID) = 1 and emID = :emID", [":emid" => $this->emID]);
        return $res->count;
    }

    /**
     * Returns all staff members
     * @return Citizen[]
     */
    public function getStaff(){
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE (select emID from entrance_employee where entrance_employee.cID = entrance_citizen.cID) = :emid", [":emid" => $this->emID]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
    }

    /**
     * Returns all active staff members
     * @return Citizen[]
     */
    public function getActiveStaff(){
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE emID = :emid AND state = 0", [":emid" => $this->emID]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
    }

    /**
     * @return mixed
     */
    public function getKind() {
        return $this->kind;
    }

    /**
     * @param mixed $kind
     */
    public function setKind($kind) {
        $this->kind = $kind;
    }


    /**
     * @return mixed
     */
    public function getEmID() {
        return $this->emID;
    }

    /**
     * @param mixed $emID
     */
    public function setEmID($emID) {
        $this->emID = $emID;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRoom() {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room) {
        $this->room = $room;
    }
}