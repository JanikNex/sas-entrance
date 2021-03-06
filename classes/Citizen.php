<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 06.03.2016
 * Time: 18:50
 */

namespace Entrance;

use PDO;

const CSORTING = [
    "ascName"      => " ORDER BY lastname ASC",
    "ascID"        => " ORDER BY cID ASC",
    "descName"     => " ORDER BY lastname DESC",
    "descID"       => " ORDER BY cID DESC",
    "ascBarcode"   => " ORDER BY barcode ASC",
    "ascClassD"    => " ORDER BY classLevel, classDetail ASC",
    "" => ""
];

const CFILTERING = [
    ""          => " AND cID != 0 AND classLevel != 17",
    "Alle"      => " AND cID != 0 AND classLevel != 13 AND classLevel != 17",
    "Stufe5"    => " AND cID != 0 AND classLevel = 5 ",
    "Stufe6"    => " AND cID != 0 AND classLevel = 6 ",
    "Stufe7"    => " AND cID != 0 AND classLevel = 7 ",
    "Stufe8"    => " AND cID != 0 AND classLevel = 8 ",
    "Stufe9"    => " AND cID != 0 AND classLevel = 9 ",
    "Stufe05"   => " AND cID != 0 AND classLevel = 5 ",
    "Stufe06"   => " AND cID != 0 AND classLevel = 6 ",
    "Stufe07"   => " AND cID != 0 AND classLevel = 7 ",
    "Stufe08"   => " AND cID != 0 AND classLevel = 8 ",
    "Stufe09"   => " AND cID != 0 AND classLevel = 9 ",
    "Stufe10"   => " AND cID != 0 AND classLevel = 10 ",
    "Stufe11"   => " AND cID != 0 AND classLevel = 11 ",
    "Stufe12"   => " AND cID != 0 AND classLevel = 12 ",
    "Stufe13"   => " AND cID != 0 AND classLevel = 13 ",
    "Stufe14"   => " AND cID != 0 AND classLevel = 14 ",
    "Stufe15"   => " AND cID != 0 AND classLevel = 15 ",
    "Stufe16"   => " AND cID != 0 AND classLevel = 16 ",
    "Schüler"   => " AND cID != 0 AND classLevel < 13 ",
    "ohneVisumK"=> " AND cID != 0 AND classLevel < 15 ",
    "Visum"     => " AND cID != 0 AND classLevel = 15 ",
    "Lehrer"    => " AND cID != 0 AND classLevel = 14 ",
    "Kurier"    => " AND cID != 0 AND classLevel = 16 ",
    "ohneKurier"=> " AND cID != 0 AND classLevel < 16"
];


class Citizen {
    private $cID, $firstname, $lastname, $classlevel, $classdetail, $birthday, $barcode;

    /**
     * Citizen constructor.
     * @param $cID
     * @param $firstname
     * @param $lastname
     * @param $classlevel
     * @param $birthday
     * @param $barcode
     */
    public function __construct($cID, $firstname, $lastname, $classlevel,$classdetail, $birthday, $barcode) {
        $this->cID = $cID;
        $this->firstname = utf8_encode($firstname);
        $this->lastname = utf8_encode($lastname);
        $this->classlevel = $classlevel;
        $this->classdetail = $classdetail;
        $this->birthday = $birthday;
        $this->barcode = $barcode;
    }

    /**
     * Creates a new Citizen Object from data from the db, using the provided cID
     *
     * @param int $cID
     * @return Citizen
     */
    public static function fromCID($cID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_citizen WHERE cID = :cid", [":cid" => $cID]);
        return new Citizen($res->cID, $res->firstname, $res->lastname, $res->classLevel, $res->classDetail, $res->birthday, $res -> barcode);
    }

    /**
     *
     * Creates a new Citizen Object from data from the db, using the provided barcode
     *
     * @param string $barcode
     * @return Citizen
     */
    public static function fromBarcode($barcode) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_citizen WHERE barcode = :barcode", [":barcode" => $barcode]);
        return new Citizen($res->cID, $res->firstname, $res->lastname, $res->classLevel, $res->classDetail, $res->birthday, $res -> barcode);
    }

    /**
     * Creates a new Citizen in the db with the provided data
     *
     * @param string $firstname
     * @param string $lastname
     * @param int $classlevel
     * @param int $birthday
     * @param string $barcode
     */
    public static function createCitizen($firstname, $lastname, $classlevel, $birthday, $barcode) {
        $pdo = new PDO_MYSQL();
        $pdo->query("INSERT INTO entrance_citizen(firstname, lastname, classlevel, birthday, barcode) VALUES (:firstname, :lastname, :classlevel, :birthday, :barcode)",
            [":firstname" => $firstname, ":lastname" => $lastname, ":classlevel" => $classlevel, ":birthday" => $birthday, ":barcode" => $barcode]);
    }

    /**
     * @param string $barcode
     * @return bool
     */
    public static function doesBarcodeExist($barcode) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_citizen WHERE barcode = :bc", [":bc" => $barcode]);
        return isset($res->firstname);
    }

    /**
     * @param int $cID
     * @return bool
     */
    public static function doesCitizenExist($cID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_citizen WHERE cID = :cid", [":cid" => $cID]);
        return isset($res->firstname);
    }


    /**
     * Returns the Count of all Citizens in the db
     *
     * @param string $sort
     * @param string $filter
     * @param string $search
     * @return int
     */
    public static function getTotalCitizenCount($sort, $filter, $search) {
        $pdo = new PDO_MYSQL();
        if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%')".CFILTERING[$filter].CSORTING[$sort];
        else $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE cID != 0".CFILTERING[$filter].CSORTING[$sort];

        $res = $pdo->query($query);
        return $res->count;
    }

    /**
     * Returns all Citizen in the db
     *
     * @param string $sort
     * @param string $filter
     * @param int $page
     * @param int $pagesize
     * @param string $search
     * @return Citizen[]
     */
    public static function getAllCitizen($sort = "", $filter = "", $page = 1, $pagesize = 999999, $search = "") {
        $pdo = new PDO_MYSQL();
        if($filter != "Gesperrt") {
            if($search != "") {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $query = "SELECT cID FROM entrance_citizen WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%')".CFILTERING[$filter].CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
                $stmt = $pdo->queryMulti($query);
                return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            } else {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE cID != 0 " . CFILTERING[$filter] . CSORTING[$sort]." LIMIT ".$startElem.','.$endElem);
                return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            }
        } else {
            $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen " . CSORTING[$sort]);
            $array = $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            $r_citizen = [];
            foreach($array as $citizen) {
                if($citizen->isCitizenLocked())
                    array_push($r_citizen, $citizen);
            }
            return $r_citizen;
        }
    }

    /**
     * Returns all Citizen in the db
     *
     * @param string $sort
     * @param string $filter
     * @param int $page
     * @param int $pagesize
     * @param string $search
     * @return Citizen[]
     */
    public static function getAllCitizenSimple($sort = "", $filter = "", $page = 1, $pagesize = 999999, $search = "") {
        $pdo = new PDO_MYSQL();
        if($filter != "Gesperrt") {
            if($search != "") {
                $startElem = ($page-1) * $pagesize;
                $endElem = $pagesize;
                $query = "SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%') ".CFILTERING[$filter].CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
                $stmt = $pdo->queryMulti($query);
                $hits = [];
                while($row = $stmt->fetch()) {
                    $keys["id"] = $row["cID"];
                    $keys["fname"] = utf8_encode($row["firstname"]);
                    $keys["lname"] = utf8_encode($row["lastname"]);
                    $keys["st"] = utf8_encode($row["state"]);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
                return $hits;
            } else {
                $startElem = ($page-1) * $pagesize;
                $endElem = $pagesize;
                $stmt = $pdo->queryMulti("SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE cID != 0 " . CFILTERING[$filter] . CSORTING[$sort]." LIMIT ".$startElem.','.$endElem);
                $hits = [];
                while($row = $stmt->fetch()) {
                    $keys["id"] = $row["cID"];
                    $keys["fname"] = utf8_encode($row["firstname"]);
                    $keys["lname"] = utf8_encode($row["lastname"]);
                    $keys["st"] = utf8_encode($row["state"]);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
                return $hits;
            }
        } else {
            $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen " . CSORTING[$sort]);
            $array = $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            $hits = [];
            foreach($array as $citizen) {
                if($citizen->isCitizenLocked()) {
                    $keys["id"] = $citizen->getCID();
                    $keys["fname"] = utf8_encode($citizen->getFirstname());
                    $keys["lname"] = utf8_encode($citizen->getLastname());
                    $keys["st"] = utf8_encode($citizen->isCitizenInState() ? 1 : 0);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
            }
            return $hits;
        }
    }

    /**
     * Returns all Citizen, which are currently in the State
     *
     * @param string $sort
     * @param string $filter
     * @param int $page
     * @param int $pagesize
     * @param string $search
     * @return Citizen[]
     */
    public static function getAllCitizenInStateSimple($sort = "", $filter = "", $page = 1, $pagesize = 999999, $search = "") {
        $pdo = new PDO_MYSQL();
        if($filter != "Gesperrt") {
            if($search != "") {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $query = "SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%') AND state = 0".CFILTERING[$filter].CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
                $stmt = $pdo->queryMulti($query);
                $hits = [];
                while($row = $stmt->fetch()) {
                    $keys["id"] = $row["cID"];
                    $keys["fname"] = utf8_encode($row["firstname"]);
                    $keys["lname"] = utf8_encode($row["lastname"]);
                    $keys["st"] = utf8_encode($row["state"]);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
                return $hits;            } else {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $stmt = $pdo->queryMulti("SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE state = 0" . CFILTERING[$filter] . CSORTING[$sort]." LIMIT ".$startElem.','.$endElem);
                $hits = [];
                while($row = $stmt->fetch()) {
                    $keys["id"] = $row["cID"];
                    $keys["fname"] = utf8_encode($row["firstname"]);
                    $keys["lname"] = utf8_encode($row["lastname"]);
                    $keys["st"] = utf8_encode($row["state"]);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
                return $hits;            }
        } else {
            $stmt = $pdo->queryMulti("SELECT cID, firstname, lastname, state FROM entrance_citizen state = 0" . CSORTING[$sort]);
            $array = $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            $hits = [];
            foreach($array as $citizen) {
                if($citizen->isCitizenLocked()) {
                    $keys["id"] = $row["cID"];
                    $keys["fname"] = utf8_encode($citizen->getFirstname());
                    $keys["lname"] = utf8_encode($citizen->getLastname());
                    $keys["st"] = utf8_encode($citizen->isCitizenInState() ? 1 : 0);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
            }
            return $hits;
        }
    }

    /**
     * Count of @see getAllCitizenInState()
     *
     * @param string $sort
     * @param string $filter
     * @param string $search
     * @return int
     */
    public static function getCurrentCitizenCount($sort = "ascName", $filter = "Alle", $search = "") {
        $pdo = new PDO_MYSQL();
        if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%') AND state = 0".CFILTERING[$filter].CSORTING[$sort];
        else $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE state = 0".CFILTERING[$filter].CSORTING[$sort];

        $res = $pdo->query($query);
        return $res->count;
    }

    /**
     * Returns all wanted citizens
     *
     * @param int $page
     * @param int $pagesize
     * @param string $search
     * @return Citizen[]
     */
    public static function getAllWantedCitizensSimple($page = 1, $pagesize = 999999, $search = "") {
        $pdo = new PDO_MYSQL();
        if($search != "") {
            $startElem = ($page-1) * $pagesize;
            $endElem = $startElem + $pagesize;
            $query = "SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE cID in (select cID from entrance_tracing where active = 1) and LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%') LIMIT ".$startElem.','.$endElem;
            $stmt = $pdo->queryMulti($query);
            $hits = [];
            while($row = $stmt->fetch()) {
                $keys["id"] = $row["cID"];
                $keys["fname"] = utf8_encode($row["firstname"]);
                $keys["lname"] = utf8_encode($row["lastname"]);
                $keys["st"] = utf8_encode($row["state"]);
                $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                array_push($hits, $keys);
            }
            return $hits;
        } else {
            $startElem = ($page-1) * $pagesize;
            $endElem = $startElem + $pagesize;
            $stmt = $pdo->queryMulti("SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE cID in (select cID from entrance_tracing where active = 1) LIMIT ".$startElem.','.$endElem);
            $hits = [];
            while($row = $stmt->fetch()) {
                $keys["id"] = $row["cID"];
                $keys["fname"] = utf8_encode($row["firstname"]);
                $keys["lname"] = utf8_encode($row["lastname"]);
                $keys["st"] = utf8_encode($row["state"]);
                $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                array_push($hits, $keys);
            }
            return $hits;
        }
    }

    /**
     * Returns the count of all citizen
     *
     * @param string $search
     * @return int
     */
    public static function getCurrentWantedCount($search = "") {
        $pdo = new PDO_MYSQL();
        if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_tracing WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%') AND active = 1";
        else $query = "SELECT COUNT(*) as count FROM entrance_tracing WHERE active = 1";

        $res = $pdo->query($query);
        return $res->count;
    }

    /**
     * Returns all "bad" citizen
     *
     * @param string $sort
     * @param string $filter
     * @param int    $page
     * @param int    $pagesize
     * @param string $search
     * @return Citizen[]
     */
    public static function getAllBadCitizenSimple($sort = "", $filter = "Schüler", $page = 1, $pagesize = 9999999, $search = "") {
        $pdo = new PDO_MYSQL();
        if($filter != "Gesperrt") {
            if($search != "") {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $query = "SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%') AND isBad = 1 AND classlevel < 13".CFILTERING[$filter].CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
                $stmt = $pdo->queryMulti($query);
                $hits = [];
                while($row = $stmt->fetch()) {
                    $keys["id"] = $row["cID"];
                    $keys["fname"] = utf8_encode($row["firstname"]);
                    $keys["lname"] = utf8_encode($row["lastname"]);
                    $keys["st"] = utf8_encode($row["state"]);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
                return $hits;
            } else {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $stmt = $pdo->queryMulti("SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE isBad = 1 AND classlevel < 13". CFILTERING[$filter] . CSORTING[$sort]." LIMIT ".$startElem.','.$endElem);
                $hits = [];
                while($row = $stmt->fetch()) {
                    $keys["id"] = $row["cID"];
                    $keys["fname"] = utf8_encode($row["firstname"]);
                    $keys["lname"] = utf8_encode($row["lastname"]);
                    $keys["st"] = utf8_encode($row["state"]);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
                return $hits;
            }
        } else {
            $stmt = $pdo->queryMulti("SELECT cID, firstname, lastname, state FROM entrance_citizen WHERE isBad = 1 AND classlevel < 13" . CSORTING[$sort]);
            $array = $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            $hits = [];
            foreach($array as $citizen) {
                if($citizen->isCitizenLocked()) {
                    $keys["id"] = $row["cID"];
                    $keys["fname"] = utf8_encode($citizen->getFirstname());
                    $keys["lname"] = utf8_encode($citizen->getLastname());
                    $keys["st"] = utf8_encode($citizen->isCitizenInState() ? 0 : 1);
                    $keys["check"] = md5($keys["id"]+$keys["fname"]+$keys["lname"]+$keys["st"]);
                    array_push($hits, $keys);
                }
            }
            return $hits;
        }
    }

    /**
     * Count of @see getAllBadCitizens()
     *
     * @param string $sort
     * @param string $filter
     * @param string $search
     * @return int
     */
    public static function getCurrentBadCitizenCount($sort = "", $filter = "Schüler", $search = ""){
        $pdo = new PDO_MYSQL();
        if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%') AND isBad = 1 AND classlevel < 13".CFILTERING[$filter].CSORTING[$sort];
        else $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE isBad = 1 AND classlevel < 13".CFILTERING[$filter].CSORTING[$sort];

        $res = $pdo->query($query);
        return $res->count;
    }

    /**
     * Returns all Citizen in the db; Filter: Students
     *
     * @param string $sort
     * @param string $filter
     * @param int    $page
     * @param int    $pagesize
     * @param string $search
     * @return Citizen[]
     */
    public static function getAllStudents($sort = "", $filter = "Schüler", $page = 1, $pagesize = 9999999, $search = "") {
        return self::getAllCitizen($sort, $filter, $page, $pagesize, $search);
    }

    /**
     * Count of @see getAllStudentsInState()
     *
     * @return int
     */
    public static function getCurrentStudentCount($sort = "", $search = "") {
        return self::getCurrentCitizenCount($sort, "Schüler", $search);
    }

    /**
     * Returns all Visitors currently in the State
     *
     * @return Citizen[]
     */
    public static function getAllVisitorsInState($sort = "", $page = 1, $pagesize = 9999999, $search = "") {
        return self::getAllCitizenInStateSimple($sort, "Visum", $page, $pagesize, $search);
    }

    /**
     * Count of @see getAllVisitorsInState()
     *
     * @return int
     */
    public static function getCurrentVisitorCount($sort = "", $search = "") {
        return self::getCurrentCitizenCount($sort, "Visum", $search);
    }

    /**
     * Returns all Courriers, which are on a tour
     *
     * @param $sort
     * @param $page
     * @param $pagesize
     * @param $search
     * @return Citizen[]
     */
    public static function getAllCourriersOutOfState($sort, $page, $pagesize, $search){
        return self::getAllCitizenInStateSimple("descID","Kurier");
    }

    /**
     * Returns all Courriers, which are on a tour
     *
     * @param $sort
     * @param $page
     * @param $pagesize
     * @param $search
     * @return Citizen[]
     */
    public static function getAllCourriersOutOfStateSimple($sort, $page, $pagesize, $search){
        $pdo = new PDO_MYSQL();
        if($search != "") {
            $startElem = ($page-1) * $pagesize;
            $endElem = $startElem + $pagesize;
            $query = "SELECT cID FROM entrance_citizen WHERE LOWER(CONCAT(firstname,' ', lastname,' ',barcode)) LIKE LOWER('%".$_GET["search"]."%') AND classlevel = 16 AND state = 1  ".CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
            $stmt = $pdo->queryMulti($query);
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
        } else {
            $startElem = ($page-1) * $pagesize;
            $endElem = $startElem + $pagesize;
            $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE classlevel = 16 AND state = 1 " . CSORTING[$sort]." LIMIT ".$startElem.','.$endElem);
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
        }
    }

    /**
     * Count of @see getAllCourrierOutOfState()
     *
     * @return int
     */
    public static function getCurrentCourrierCount($sort = "", $search = "") {
            $pdo = new PDO_MYSQL();
            if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE MATCH(firstname, lastname) AGAINST('".$search."' IN BOOLEAN MODE) AND classlevel = 16 AND state = 1 ".CSORTING[$sort];
            else $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE classlevel = 16 AND state = 1".CSORTING[$sort];

            $res = $pdo->query($query);
            return $res->count;
        }



    /**
     * Saves all changes made to this object into the db
     */
    public function saveChanges() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE entrance_citizen SET firstname = :firstname, lastname = :lastname, classlevel = :classlevel, birthday = :birthday, barcode = :barcode WHERE cID = :cid",
            [":firstname" => $this->firstname, ":lastname" => $this->lastname, ":classlevel" => $this->classlevel, ":birthday" => $this->birthday, ":barcode" => $this->barcode, ":cid" => $this->cID]);
    }

    /**
     * Converts the object into an array
     *
     * @return array
     */
    public function asArray() {
        return [
            "id" => $this->cID,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "classlevel" => $this->classlevel,
            "barcode" => $this->barcode,
            "roll" => $this->getRoll('work'),
            "employer" => $this->getEmployerData(),
            "inState" => $this->isCitizenInState(),
            "isWanted" => $this->isCitizenWanted() ? 1:0,
            "locked" => $this->isCitizenLocked() ? 1:0,
            "timeToday" => $this->getTimePerDay(date("Y-m-d")) != 0 ? gmdate("H\h i\m s\s",$this->getTimePerDay(date("Y-m-d"))) : "<i>Nicht anwesend</i>",
            "timeProject" =>$this->getTimePerProject() != 0 ? Util::seconds_to_time($this->getTimePerProject()) : "<i>Nicht anwesend</i>"
        ];
    }

    /**
     * Converts the object into an optimised array
     *
     * @return array
     */
    public function asArrayOptimized() {
        return [
            "id" => $this->cID,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "classlevel" => $this->classlevel,
            "employer" => $this->getEmployerData(),
            "inState" => $this->isCitizenInState(),
            "isWanted" => $this->isCitizenWanted() ? 1:0,
            "locked" => $this->isCitizenLocked() ? 1:0,
            "timeToday" => $this->getTimePerDay(date("Y-m-d")) != 0 ? gmdate("H\h i\m s\s",$this->getTimePerDay(date("Y-m-d"))) : "<i>Nicht anwesend</i>",
            "timeProject" =>$this->getTimePerProject() != 0 ? Util::seconds_to_time($this->getTimePerProject()) : "<i>Nicht anwesend</i>"
        ];
    }

    public function asString() {
        return json_encode($this->asArray());
    }

    /**
     * Tries to check the citizen in, returns true on success, false on failure
     *
     * @param $user User
     * @return bool
     */
    public function tryCheckIn($user) {
        return LogEntry::createLogEntry($this, $user, 0);
    }

    /**
     * Tries to check the citizen out, returns true on success, false on failure
     *
     * @param $user User
     * @return bool
     */
    public function tryCheckOut($user) {
        return LogEntry::createLogEntry($this, $user, 1);
    }


    /**
     * Removes the citizen from the db
     *
     * @return bool
     */
    public function delete() {
        $pdo = new PDO_MYSQL();
        return $pdo->query("DELETE FROM entrance_citizen WHERE cID = :cid", [":cid" => $this->cID]);
    }

    /**
     * Returns 0 if the citizin is in the state, 1 if it is out of the state and 2 if the status is invalid(no log Entry found)
     *
     * @return int
     */
    public function isCitizenInState() {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_logs WHERE cID = :cid AND success = 1 AND `action` != 2 ORDER BY `timestamp` DESC LIMIT 1", [":cid" => $this->cID]);
        if(!isset($res->action)) return 2; //noch nie im Staat gewesen bzw. kein LogEintrag vorhanden
        elseif($res -> action == 0) return 0; //Schueler ist drin
        elseif($res -> action == 1) return 1; //Schueler ist nicht drin
    }

    /**
     *Updates the citizen state
     */
    public function updateCitizenState() {
        $pdo = new PDO_MYSQL();
        if($this->isCitizenInState() == 0) {
            $pdo->query("UPDATE entrance_citizen SET state = 0 WHERE cID = :cID", [":cID" => $this->getCID()]);
        }
        elseif ($this->isCitizenInState() == 1) {
            $pdo->query("UPDATE entrance_citizen SET state = 1 WHERE cID = :cID", [":cID" => $this->getCID()]);
        }
        elseif ($this->isCitizenInState() == 2) {
            $pdo->query("UPDATE entrance_citizen SET state = 2 WHERE cID = :cID", [":cID" => $this->getCID()]);
        }

        $isBad = $this->isBad() ? 1:0;
        $pdo->query("UPDATE entrance_citizen SET isBad = :isBad WHERE cID = :cID", [":cID" => $this->getCID(), ":isBad" => $isBad]);
    }

    public function isBad() {
        $days = LogEntry::getProjectDays();
        foreach($days as $day){
            if(($this->getClasslevel()<13) && ($this -> getTimePerDay($day) <= 20640)){
                return true;
            }
        }
        return false;
    }

    /**
     * Returns true if the citizen is in a locked state
     *
     * @return bool
     */
    public function isCitizenLocked() {
        $last = $this->getLastEntry();
        if($last instanceof LogEntry) {
            return !$last->getEntrySuccessStatus();
        } else return false;
    }

    /**
     * Returns wether this Citizen is Wanted
     * @return bool
     */
    public function isCitizenWanted() {
        $logs = TracingEntry::getAllLogsPerCID($this->getCID());
        foreach ($logs as $entry){
            if($entry->isActive()) return true;
        }
        return false;
    }
    /**
     * Returns the time this citizen spend in state for a specific date in seconds
     *
     * @param string $date
     * @return int
     */
    public function getTimePerDay($date){
        $pdo = new PDO_MYSQL();
        $entries = LogEntry::allLogsPerDay($this->cID, $date);
        $time = 0;
        foreach($entries as $entry){
            $time += $entry -> timeBetweenTwoEntries();
        }
        if(!$this -> isCourrier()){
            if($this -> isCitizenInState() == 0 && $date == date("Y-m-d")) {
                $res = $pdo->query("SELECT * FROM entrance_logs WHERE cID = :cid AND action = 0 AND success = 1 ORDER BY `timestamp` DESC LIMIT 1", [":cid" => $this->cID]);
                $time += time() - strtotime($res->timestamp);
            }
        }elseif($this -> isCourrier()){
            if($this -> isCitizenInState() == 1 && $date == date("Y-m-d")) {
                $res = $pdo->query("SELECT * FROM entrance_logs WHERE cID = :cid AND action = 1 AND success = 1 ORDER BY `timestamp` DESC LIMIT 1", [":cid" => $this->cID]);
                $time += time() - strtotime($res->timestamp);
            }
        }
        return $time;
    }

    /**
     * Returns the latest Entry on record for this citizen
     *
     * @return LogEntry
     */
    public function getLastEntry(){
        $pdo = new PDO_MYSQL();
        return LogEntry::fromLID($pdo -> query("SELECT * FROM entrance_logs WHERE cID = :cID AND `action` != 2 ORDER BY lID DESC LIMIT 1",
            [":cID" => $this->cID]) -> lID);
    }

    /**
     * @see kickAllCitizensOutOfState()
     *
     * @param $user User
     * @return bool
     */
    public function kickCitizenOutOfState($user){
        $pdo = new PDO_MYSQL();
        $date = date("Y-m-d H:i:s");
        if (!$this->isCourrier()) {
            if ($this->isCitizenInState() == 0) {
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 1, 0)",
                    [":cID" => $this->cID, ":uID" => $user->getUID(), ":timestamp" => $date]);
                Error::createError($this->cID, 3);
                $this->getLastEntry()->invalidateLogEntryBeforeEntry();
                $this->updateCitizenState();
                return true;
            }
        } elseif ($this->isCourrier()) {
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 0, 0)",
                [":cID" => $this->cID, ":uID" => $user->getUID(), ":timestamp" => $date]);
            Error::createError($this->cID, 3);
            $this->getLastEntry()->invalidateLogEntryBeforeEntry();
            $this->updateCitizenState();
            return true;
        }
    }


    /**
     * (nie) mehr Janik's Baustelle
     *
     * @param $user User
     * @return bool
     */
    public function forceErrorCorrect($user){
        if($this->isCitizenLocked()) {
            if (!$this->getLastEntry()->getLastTwoEntrySuccessStatus()){
                return self::forceErrorCorrectAfterKick($user);
            }else{
                return self::forceErrorCorrectNormal($user);
            }
        } else return false;
    }

    /**
     * @see forceErrorCorrect()
     *
     * @param $user User
     * @return bool
     */
    private function forceErrorCorrectNormal($user){
        $pdo = new PDO_MYSQL();
        $date = date("Y-m-d H:i:s");
        if ($this -> isCitizenInState() >= 1){
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 0, 0)",
                [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => $date]);
            $this->getLastEntry()->invalidateLogEntryBeforeEntry();
            Error::correctError($this->cID);
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 1, 1)",
                [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => $date]);
            $this->updateCitizenState();
            return true;
        }
        elseif($this -> isCitizenInState() == 0){
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 1, 0)",
                [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => $date]);
            $this->getLastEntry()->invalidateLogEntryBeforeEntry();
            Error::correctError($this->cID);
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 0, 1)",
                [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => $date]);
            $this->updateCitizenState();
            return true;
        }
    }


    /**
     * @see forceErrorCorrect()
     *
     * @param $user
     * @return bool
     */
    private function forceErrorCorrectAfterKick($user){
        $pdo = new PDO_MYSQL();
        if(!$this->isCourrier()) {
            if ($this->isCitizenInState() == 1) {
                Error::correctError($this->getCID());
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 0, 1)",
                    [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => date("Y-m-d H:i:s")]);
                $this->updateCitizenState();
                return true;
            }
            return false;
        }elseif($this -> isCourrier()){
            if ($this->isCitizenInState() != 1) {
                Error::correctError($this->getCID());
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 1, 1)",
                    [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => date("Y-m-d H:i:s")]);
                $this->updateCitizenState();
                return true;
            }
            return false;
        }
    }

    /**
     * @param $user User
     * @return bool
     */
    public function forceErrorCorrectIgnore($user){
        if($this -> isCitizenLocked()) {
            if($this -> getLastEntry() -> getLastTwoEntrySuccessStatus()) {
                LogEntry::ignoreLastLogEntry($this, $user);
                Error::correctError($this->cID);
                $this->updateCitizenState();
                return true;
            }else{
                LogEntry::ignoreLastLogEntry($this, $user);
                $this -> getLastEntry() -> validateLogEntry();
                Error::correctError($this->cID);
                $this->updateCitizenState();
                return true;
            }
        }
        return false;
    }
    /**
     * Returns true if the citizen is a courrier
     *
     * @return bool
     */
    public function isCourrier() {
        if($this->getClasslevel() == 16) return true;
        else return false;
    }

    /**
     * Retur1ns true if the citizen was over 6 hours in state today
     *
     * @return bool
     */
    public function hasCitizenEnoughTime(){
        $date = date("Y-m-d");
        if ($this -> getClasslevel() < 11){
            return ($this -> getTimePerDay($date)) >= 21600;
        }else{
            return true;
        }
    }

    /**
     * Returns the time the citizen spend in state for the whole project in seconds
     *
     * @return int
     */
    public function getTimePerProject(){
        $time = 0;
        foreach(LogEntry::getProjectDays() as $day)
            $time += $this->getTimePerDay($day);
        return $time;
    }

    /**
     * Creates an array with all students and their time informations
     * @return array
     */
    public static function createClassListsAsArray(){
        $CLASS = ["a","b","c","d","e","f"];
        $students = Citizen::getAllStudents($sort="ascClassD");
        $list = [];
        $currentClass = [0,0];
        $label = ["cID", "Vorname", "Nachname", "Klassenstufe", "Barcode", "BetriebsID", "Betriebsname"];
        foreach (LogEntry::getProjectDays() as $day){
            array_push($label, $day);
        }
        array_push($label, "Gesamtzeit");
        array_push($list, $label);
        foreach ($students as $student){
            if($student->isBad()) {
                if($student->getClasslevel() <= 10) {
                    if(!((substr($student->getBarcode(), 8, 2) == $currentClass[0]) && (substr($student->getBarcode(), 10, 1) == $currentClass[1]))) {
                        $currentClass = [substr($student->getBarcode(), 8, 2), substr($student->getBarcode(), 10, 1)];
                        array_push($list, ["Klasse", $currentClass[0], $CLASS[$currentClass[1] - 1]]);
                    }
                } else {
                    if(!((substr($student->getBarcode(), 8, 2) == $currentClass[0]) && (substr($student->getClassdetail(), 2) == $currentClass[1]))) {
                        $currentClass = [substr($student->getClassdetail(), 0, 2), substr($student->getClassdetail(), 2)];
                        array_push($list, ["Kurs", $currentClass[0], $currentClass[1]]);
                    }
                }
                array_push($list, $student->timeAsArray());
            }
        }

        return $list;
    }

    /**
     * Creates an array with all bad students today
     * @return array
     */
    public static function createBadCitizenListsAsArray(){
        $CLASS = ["a","b","c","d","e","f"];
        $students = Citizen::getAllStudents($sort="ascClassD");
        $list = [["Stand: ".date("H:i_d.m.Y")]];
        $currentClass = [0,0];
        $label = ["cID", "Vorname", "Nachname", "Klassenstufe", "Barcode", "BetriebsID", "Betriebsname", date("d.m.Y")];
        array_push($list, $label);
        foreach ($students as $student){
            if(!$student->wasInStateToday()) {
                if ($student->getClasslevel() <= 10) {
                    if (!((substr($student->getBarcode(), 8, 2) == $currentClass[0]) && (substr($student->getBarcode(), 10, 1) == $currentClass[1]))) {
                        $currentClass = [substr($student->getBarcode(), 8, 2), substr($student->getBarcode(), 10, 1)];
                        array_push($list, ["Klasse", $currentClass[0], $CLASS[$currentClass[1]-1]]);
                    }
                } else {
                    if (!((substr($student->getBarcode(), 8, 2) == $currentClass[0]) && (substr($student->getClassdetail(), 2) == $currentClass[1]))) {
                        $currentClass = [substr($student->getClassdetail(), 0, 2), substr($student->getClassdetail(), 2)];
                        array_push($list, ["Kurs", $currentClass[0], $currentClass[1]]);
                    }
                }
                array_push($list, $student->badTimeAsArray());
            }
        }

        return $list;
    }


    /**
     *Sends the Classlist as Array to the CSV creator
     */
    public static function createClasslistAsCSV(){
        $array = self::createClassListsAsArray();
        Util::writeCSV($array, "/var/www/html/entrance/csv/classlist".date("Y-m-d_H-i").".csv");
        return "/var/www/html/entrance/csv/classlist".date("Y-m-d_H-i").".csv";
    }

    /**
     *Sends the bad citizen list as Array to the CSV creator
     */
    public static function createBadCitizenListAsCSV(){
        $array = self::createBadCitizenListsAsArray();
        Util::writeCSV($array, "/var/www/html/entrance/csv/badcitizenlist".date("Y-m-d_H-i").".csv");
        return "/var/www/html/entrance/csv/badcitizenlist".date("Y-m-d_H-i").".csv";
    }

    /**
     * Returns if this citizen was already in state today
     * @return bool
     */
    public function wasInStateToday(){
        if(($this->getTimePerDay(date("Y-m-d")) > 0) or ($this->isCitizenInState() == 0)) return true;
        else return false;
    }

    /**
     * Returns the citizens passport data
     * @param string $mode
     * @return array
     */
    public function getCitizenPassportData($mode = "normal"){
        if($this->getClasslevel() != 15){
            $data = [
                "name" => explode(" ", $this->lastname)[0]." ".explode(" ", $this->lastname)[1],
                "firstname" => explode(" ", $this->firstname)[0],
                "barcode" => $this->barcode,
                "roll" => $this->getRoll($mode),
                "classlevel" => $this->classlevel
            ];
            if($this->lastname == "Borroni Meyenschein"){
                $data = [
                    "name" => explode(" ", $this->lastname)[0],
                    "firstname" => explode(" ", $this->firstname)[0],
                    "barcode" => $this->barcode,
                    "roll" => $this->getRoll($mode),
                    "classlevel" => $this->classlevel
                ];
            }
        }elseif($this->getClasslevel() == 15){
            $data = [
                "name" => $this->firstname,
                "firstname" => $this->lastname,
                "barcode" => $this->barcode,
                "roll" => $this->getRoll($mode),
                "classlevel" => $this->classlevel
            ];
        }
        return $data;
    }

    /**
     *Prints the passport of this citizen
     */
    public function printThisCitizenPassport(){
        return self::printPassport([$this->getCitizenPassportData()]);
    }

    /**
     *Prints the passport of all Citizens
     */
    public static function printAllCitizenPassports(){
        $citizens = self::getAllCitizen("", "ohneVisumK");
        $data = [];
            foreach ($citizens as $citizen){
                array_push($data, $citizen->getCitizenPassportData());
            }
        return self::printPassport($data);
    }

    /**
     * Print all passports for a specific group of citizens
     * @param $group
     * @return string
     */
    public static function printPassportGroup($group){
        $citizens = self::getAllCitizen("", "Stufe".$group);
        $data = [];
        foreach ($citizens as $citizen){
            if($citizen->getsWhitePassport()) {
                array_push($data, $citizen->getCitizenPassportData());
            }
        }
        return self::printPassport($data, $group);
    }

    /**
     * Print special passworts for a specific group
     * @return string
     */
    public static function printPassportSpecials($group){
        $citizens = self::getAllSpecials($group);
        $data = [];
        $mode = 'work';
        foreach ($citizens as $citizen){
            $citizenobject = self::fromCID($citizen);
            if ($group == 'courrier') {
                if ($citizenobject->isCourrier())
                    $mode = 'normal';
                    array_push($data, $citizenobject->getCitizenPassportData($mode));
            }elseif ($group == 'orga') {
                if($citizenobject->isOrga())
                    $mode = 'work';
                    array_push($data, $citizenobject->getCitizenPassportData($mode));
            }elseif ($group == 'police') {
                if($citizenobject->isPolice())
                    $mode = 'work';
                    array_push($data, $citizenobject->getCitizenPassportData($mode));
            }elseif ($group == 'parliament') {
                if($citizenobject->isParlament())
                    $mode = 'normal';
                    array_push($data, $citizenobject->getCitizenPassportData($mode));
            }elseif ($group == 'administrator') {
                $mode = 'normal';
                array_push($data, $citizenobject->getCitizenPassportData($mode));
            }
            elseif ($group == 'centralbank') {
                $mode = 'work';
                array_push($data, $citizenobject->getCitizenPassportData($mode));
            }
            elseif ($group == 'borderguards') {
                $mode = 'work';
                array_push($data, $citizenobject->getCitizenPassportData($mode));
            }
            elseif ($group == 'factoryinspectorate') {
                $mode = 'work';
                array_push($data, $citizenobject->getCitizenPassportData($mode));
            }
            elseif ($group == 'government') {
                $mode = 'normal';
                array_push($data, $citizenobject->getCitizenPassportData($mode));
            }
            elseif ($group == 'monarch') {
                $mode = 'normal';
                array_push($data, $citizenobject->getCitizenPassportData($mode));
            }
            elseif ($group == 'justice') {
                $mode = 'normal';
                array_push($data, $citizenobject->getCitizenPassportData($mode));
            }
            elseif ($group == 'warehouse') {
                $mode = 'work';
                array_push($data, $citizenobject->getCitizenPassportData($mode));
            }
        }
        return self::printPassport($data, 'S', $mode);
    }
    /**
     * Print special passworts for all official workers
     * @return string
     */
    public static function printPassportWorkers(){
        $citizens = self::getAllOfficial();
        $data = [];
        foreach ($citizens as $citizen){
            array_push($data, self::fromCID($citizen)->getCitizenPassportData("work"));
        }
        return self::printPassport($data, 'W', 'work');
    }

    public static function printTestPassportPage($mode){
        $data = [];
        array_push($data, [
            "name" => "Rapp",
            "firstname" => "Janik",
            "barcode" => 2016041311164,
            "roll" => ["", ""]
        ]);
        array_push($data, [
            "name" => "Rapp",
            "firstname" => "Janik",
            "barcode" => 2016041311164,
            "roll" => ["System-Administrator", ""]
        ]);
        array_push($data, [
            "name" => "Rapp",
            "firstname" => "Janik",
            "barcode" => 2016041311164,
            "roll" => ["System-Administrator", "Technik"]
        ]);
        return self::printPassport($data, 'T', $mode);
    }

    /**
     * Prints passport(s) from given citizenpassportdata
     * @param array[] $data
     * @param int $group
     * @param string $mode
     * @return string URL of saved PDF
     */
    public static function printPassport($data, $group = 0, $mode = 'normal'){
        $size = sizeof($data);
        $pages = ceil($size/14);
        $dwoo = new \Dwoo\Core();
        $tpl = new \Dwoo\Template\File('tpl/passport.tpl');
        if($size> 14){
            $html = "";
            $pgsdata = array_chunk($data, 14);
            foreach($pgsdata as $page) {
                $pgdata = [
                    "size" => sizeof($page),
                    "data" => $page,
                    "mode" => $mode,
                    "IP" => SERVER_IP
                ];
                $html .= $dwoo->get($tpl, $pgdata);
            }
        }else{
            $pgdata = [
                "size" => $size,
                "data" => $data,
                "mode" => $mode,
                "IP" => SERVER_IP
            ];
            $html = $dwoo->get($tpl, $pgdata);
        }
        $link = "/var/www/html/entrance/pdf/passports-".$group."-".date("Y-m-d_H-i-s").".pdf";
        Util::writePDF($html, $link);
        return $link;
    }

    /**
     * Prints passport(s) from given citizenpassportdata | passport mode can be specified in dataarray
     * @param array[] $data [["work", []],["normal", []]]
     * @param int $group
     * @return string URL of saved PDF
     */
    public static function printPassportModechanger($data, $group = 0){
        $html = "";
        if ($data[0][1] != []) {
            $size = sizeof($data[0][1]);
            $pages = ceil($size / 14);
            $dwoo = new \Dwoo\Core();
            $tpl = new \Dwoo\Template\File('tpl/passport.tpl');
            if ($size > 14) {

                $pgsdata = array_chunk($data[0][1], 14);
                foreach ($pgsdata as $page) {
                    $pgdata = [
                        "size" => sizeof($page),
                        "data" => $page,
                        "mode" => $data[0][0],
                        "IP" => SERVER_IP
                    ];
                    $html .= $dwoo->get($tpl, $pgdata);
                }
            } else {
                $pgdata = [
                    "size" => $size,
                    "data" => $data[0][1],
                    "mode" => $data[0][0],
                    "IP" => SERVER_IP
                ];
                $html .= $dwoo->get($tpl, $pgdata);
            }
        }
        if ($data[1][1] != []) {
            $size = sizeof($data[1][1]);
            $pages = ceil($size / 14);
            if ($size > 14) {

                $pgsdata = array_chunk($data[1][1], 14);
                foreach ($pgsdata as $page) {
                    $pgdata = [
                        "size" => sizeof($page),
                        "data" => $page,
                        "mode" => $data[1][0],
                        "IP" => SERVER_IP
                    ];
                    $html .= $dwoo->get($tpl, $pgdata);
                }
            } else {
                $pgdata = [
                    "size" => $size,
                    "data" => $data[1][1],
                    "mode" => $data[1][0],
                    "IP" => SERVER_IP
                ];
                $html .= $dwoo->get($tpl, $pgdata);
            }
        }
        $link = "/var/www/html/entrance/pdf/passports-".$group."-".date("Y-m-d_H-i-s").".pdf";
        Util::writePDF($html, $link);
        return $link;
    }


    public static function printPassportColor($color){
        if ($color == "red"){
            $citizens = [];
            $data = [];
            $citizens = array_merge($citizens, self::getAllSpecials("monarch"));
            $citizens = array_merge($citizens, self::getAllSpecials("constitutional"));
            $citizens = array_merge($citizens, self::getAllSpecials("government"));
            $citizens = array_unique($citizens);
            foreach ($citizens as $citizen){
                array_push($data, self::fromCID($citizen)->getCitizenPassportData("normal"));
            }
            return self::printPassport($data, $color, "normal");
        }elseif ($color == "yellow"){
            $citizens = self::getAllSpecials("justice");
            $data = [];
            foreach ($citizens as $citizen){
                array_push($data, self::fromCID($citizen)->getCitizenPassportData("normal"));
            }
            return self::printPassport($data, $color, "normal");
        }elseif ($color == "blue"){
            $citizens = self::getAllSpecials("police");
            $data = [["work", []],["normal", []]];
            foreach ($citizens as $citizen){
                $currentCitizen = self::fromCID($citizen);
                if ($currentCitizen->isChief())
                    array_push($data[1][1], $currentCitizen->getCitizenPassportData("work"));
                elseif (!$currentCitizen->isChief()) {
                    array_push($data[0][1], $currentCitizen->getCitizenPassportData("work"));
                }
            }
            return self::printPassportModechanger($data, $color);
        }elseif ($color == "lightblue"){
            $citizens = self::getAllSpecials("borderguard");
            $data = [["work", []],["normal", []]];
            foreach ($citizens as $citizen){
                $currentCitizen = self::fromCID($citizen);
                if ($currentCitizen->isChief())
                    array_push($data[1][1], $currentCitizen->getCitizenPassportData("work"));
                elseif (!$currentCitizen->isChief()) {
                    array_push($data[0][1], $currentCitizen->getCitizenPassportData("work"));
                }
            }
            return self::printPassportModechanger($data, $color);
        }elseif ($color == "green"){
            $citizens = self::getAllSpecials("centralbank");
            $data = [["work", []],["normal", []]];
            foreach ($citizens as $citizen){
                $currentCitizen = self::fromCID($citizen);
                if ($currentCitizen->isChief())
                    array_push($data[1][1], $currentCitizen->getCitizenPassportData("work"));
                elseif (!$currentCitizen->isChief()) {
                    array_push($data[0][1], $currentCitizen->getCitizenPassportData("work"));
                }
            }
            return self::printPassportModechanger($data, $color);
        }elseif ($color == "cyan"){
            $citizens = self::getAllSpecials("warehouse");
            $data = [["work", []],["normal", []]];
            foreach ($citizens as $citizen){
                $currentCitizen = self::fromCID($citizen);
                if ($currentCitizen->isChief())
                    array_push($data[1][1], $currentCitizen->getCitizenPassportData("work"));
                elseif (!$currentCitizen->isChief()) {
                    array_push($data[0][1], $currentCitizen->getCitizenPassportData("work"));
                }
            }
            return self::printPassportModechanger($data, $color);
        }elseif ($color == "orange"){
            $citizens = self::getAllSpecials("parliament");
            $data = [];
            foreach ($citizens as $citizen){
                array_push($data, self::fromCID($citizen)->getCitizenPassportData("normal"));
            }
            return self::printPassport($data, $color, "normal");
        }elseif ($color == "press"){
            $citizens = Employer::fromEMID(70)->getStaff();
            $citizens = array_merge($citizens, Employer::fromEMID(91)->getStaff());
            $citizens = array_merge($citizens, Employer::fromEMID(116)->getStaff());
            $citizens = array_merge($citizens, Employer::fromEMID(221)->getStaff());
            $data = [];
            foreach ($citizens as $citizen){
                array_push($data, $citizen->getCitizenPassportData($mode="work"));
            }
            return self::printPassport($data, $color, "work");
        }elseif ($color == "pink"){
            $citizens = self::getAllSpecials("factoryinspectorare");
            $data = [["work", []],["normal", []]];
            foreach ($citizens as $citizen){
                $currentCitizen = self::fromCID($citizen);
                if ($currentCitizen->isChief())
                    array_push($data[1][1], $currentCitizen->getCitizenPassportData("work"));
                elseif (!$currentCitizen->isChief()) {
                    array_push($data[0][1], $currentCitizen->getCitizenPassportData("work"));
                }
            }
            return self::printPassportModechanger($data, $color);
        }elseif ($color == "courrier"){
            $citizens = self::getAllCitizen("", "Kurier");
            $data = [];
            foreach ($citizens as $citizen){
                array_push($data, $citizen->getCitizenPassportData($mode="normal"));
            }
            return self::printPassport($data, $color, "normal");
        }
    }

    /**
     * Print passports for all guests of honor (classlevel 17)
     * @return string link
     */
    public static function printHonorGuestPassports(){
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE classLevel = 17");
        $citizens = $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
        $data = [];
        foreach ($citizens as $citizen){
            array_push($data, $citizen->getCitizenPassportData("normal"));
        }
        return self::printPassport($data, "honor", "normal");
    }

    /**
     * Returns an array with all important student informations and his times per day
     * @return array
     */
    public function timeAsArray(){
        $employerID = [];
        $employerName = [];
        foreach ($this->getEmployer() as $employer){
            array_push($employerID, $employer->getEmID());
            array_push($employerName, $employer->getName());
        }
        $employerIDString = implode(", ", $employerID);
        $employerNameString = implode(", ", $employerName);
        $studentData = [
            "id" => $this->cID,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "classlevel" => $this->classlevel,
            "barcode" => $this->barcode,
            "employerID" => $employerIDString,
            "employerName" => $employerNameString
        ];
        foreach (LogEntry::getProjectDays() as $day){
            array_push($studentData, Util::seconds_to_time($this->getTimePerDay($day)));
        }
        array_push($studentData, Util::seconds_to_time($this->getTimePerProject()));
        return $studentData;
    }

    /**
     * Returns an array with all important student informations and his times for this day
     * @return array
     */
    public function badTimeAsArray(){
        $employerID = [];
        $employerName = [];
        foreach ($this->getEmployer() as $employer){
            array_push($employerID, $employer->getEmID());
            array_push($employerName, $employer->getName());
        }
        $employerIDString = implode(", ", $employerID);
        $employerNameString = implode(", ", $employerName);
        $studentData = [
            "id" => $this->cID,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "classlevel" => $this->classlevel,
            "barcode" => $this->barcode,
            "employerID" => $employerIDString,
            "employerName" => $employerNameString,
            "time" => "Nicht anwesend"
        ];
        return $studentData;
    }

    public function getRoll($mode){
        $roll = "";
        $array = [];
        $permissions = "";
        // Es werden jeweils die Befugnisse der höchsten Rolle genommen -> daher ifs nach Rollenwichtigkeit sortieren
        //Ränge, die immer sichtbar sein sollen

        if ($this->isMonarch()) {
            array_push($array, "Monarch");
        }
        if ($this->isParlament()) {
            array_push($array, "Parlament");
            if ($permissions == "" and $this->isChief()) {
                $permissions = "Parlament";
            }else{
                $permissions = "";
            }
        }
        if ($this->isGovernment()) {
            array_push($array, "Minister");
            if ($permissions == "") {
                $permissions = "Alles";
            }
        }
        if ($this->isAdministrator()) {
            array_push($array, "Administrator");
            if ($permissions == "") {
                $permissions = "IT";
            }
        }
        if ($this->isJustice()) {
            foreach ($this->getEmployer() as $employer){
                if ($employer->getEmID() == 211){
                    array_push($array, "Staatsanwalt");
                    if ($this->isChief()) {
                        $permissions = "Staatsanwaltschaft";
                    }else{
                        $permissions = "";
                    }
                } elseif ($employer->getEmID() == 212){
                    array_push($array, "Schriftführer d. Gerichte");
                    if ($this->isChief()) {
                        $permissions = "Schriftführer Gerichte";
                    }else{
                        $permissions = "";
                    }
                } elseif ($employer->getEmID() == 213){
                    array_push($array, "Justizsekretär");
                    if ($this->isChief()) {
                        $permissions = "Justizsekretäre";
                    }else{
                        $permissions = "";
                    }
                } elseif ($employer->getEmID() == 210){
                    array_push($array, "Richter");
                }
            }
        }
        foreach ($this->getEmployer() as $employer) {
            if ($employer->getEmID() == 206) {
                if ($this->isChief()) {
                    $permissions = "Staatskanzlei, R020, Aula";
                    array_push($array, "Staatskanzlei");
                }
            }
        }
        if ($this->isConstitutional()) {
            array_push($array, "Verfassungsrat");
            if ($permissions == "") {
                $permissions = "";
            }
        }
        if ($mode == "work") {  //Dienstausweise bzw. Ränge, welche nur auf Dienstausweisen sichtbar sein sollen
            if ($this->isPolice()) {
                array_push($array, "Polizei");
                if ($permissions == "" and $this->isChief()) {
                    $permissions = "Polizei";
                }else{
                    $permissions = "";
                }
            }
            if ($this->isOrga()) {
                array_push($array, "Orga-Team");
                $permissions = "Alles";
            }
            if ($this->isCentralBank()) {
                array_push($array, "Zentralbank");
                if ($permissions == "" and $this->isChief()) {
                    $permissions = "Zentralbank";
                }else{
                    $permissions = "";
                }
            }
            if ($this->isBorderGuard()) {
                array_push($array, "Grenzschutz");
                if ($this->isChief()) {
                    $permissions = $permissions.", Grenzschutz";
                }else{
                    $permissions = "";
                }
            }
            if ($this->isWarehouse()) {
                array_push($array, "Warenlager");
                if ($permissions == "" and $this->isChief()) {
                    $permissions = "Warenlager";
                }else{
                    $permissions = "";
                }
            }
            if ($this->isFactoryInspectorare()) {
                array_push($array, "Gewerbeaufsicht");
                if ($permissions == "" and $this->isChief()) {
                    $permissions = "Gewerbeaufsicht";
                }else{
                    $permissions = "";
                }
            }
            foreach ($this->getEmployer() as $employer) {
                if ($employer->getEmID() == 70) {
                    array_push($array, "Presse");
                    $permissions = "";
                }
                elseif ($employer->getEmID() == 91) {
                    array_push($array, "Presse");
                    $permissions = "";
                }
                elseif ($employer->getEmID() == 116) {
                    array_push($array, "Presse");
                    $permissions = "";
                }
                elseif ($employer->getEmID() == 221) {
                    array_push($array, "Presse");
                    $permissions = "";
                }
            }

        }
        if ($this->isCourrier()){
            array_push($array, "Kurier");
        }
        if ($this->getClasslevel() == 17){
            array_push($array, "Ehrengast");
        }
        $roll = $array[0];
        foreach ($array as $part) {
            if($part != $array[0]) $roll .=", ".$part;
        }
        $roll = [$roll, $permissions];
        return $roll;
    }

    /**
     * Adds a specific roll to this citizen
     * @param $roll
     */
    public function addRoll($roll){
        if ($roll == "orga" && !$this->isOrga()){
            $array = json_decode(Util::getGlobal("roll.orga"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.orga", json_encode($array));
        }
        elseif ($roll == "police" && !$this->isPolice()){
            $array = json_decode(Util::getGlobal("roll.police"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.police", json_encode($array));
        }
        elseif ($roll == "parliament" && !$this->isParlament()){
            $array = json_decode(Util::getGlobal("roll.parliament"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.parliament", json_encode($array));
        }
        elseif ($roll == "monarch" && !$this->isMonarch()){
            $array = json_decode(Util::getGlobal("roll.monarch"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.monarch", json_encode($array));
        }
        elseif ($roll == "government" && !$this->isGovernment()){
            $array = json_decode(Util::getGlobal("roll.government"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.government", json_encode($array));
        }
        elseif ($roll == "centralbank" && !$this->isCentralBank()){
            $array = json_decode(Util::getGlobal("roll.centralbank"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.centralbank", json_encode($array));
        }
        elseif ($roll == "factoryinspectorare" && !$this->isFactoryInspectorare()){
            $array = json_decode(Util::getGlobal("roll.factoryinspectorare"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.factoryinspectorare", json_encode($array));
        }
        elseif ($roll == "warehouse" && !$this->isWarehouse()){
            $array = json_decode(Util::getGlobal("roll.warehouse"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.warehouse", json_encode($array));
        }
        elseif ($roll == "constitutional" && !$this->isConstitutional()){
            $array = json_decode(Util::getGlobal("roll.constitutional"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.constitutional", json_encode($array));
        }
        elseif ($roll == "justice" && !$this->isJustice()){
            $array = json_decode(Util::getGlobal("roll.justice"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.justice", json_encode($array));
        }
        elseif ($roll == "borderguard" && !$this->isBorderGuard()){
            $array = json_decode(Util::getGlobal("roll.borderguard"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.borderguard", json_encode($array));
        }
    }

    /**
     * Removes a specific roll from this citizen
     * @param $roll
     */
    public function removeRoll($roll){
        if ($roll == "orga" && $this->isOrga()){
            $array = json_decode(Util::getGlobal("roll.orga"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.orga", json_encode($array));
        }
        elseif ($roll == "police" && $this->isPolice()){
            $array = json_decode(Util::getGlobal("roll.police"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.police", json_encode($array));
        }
        elseif ($roll == "parliament" && $this->isParlament()){
            $array = json_decode(Util::getGlobal("roll.parliament"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.parliament", json_encode($array));
        }
        elseif ($roll == "monarch" && $this->isMonarch()){
            $array = json_decode(Util::getGlobal("roll.monarch"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.monarch", json_encode($array));
        }
        elseif ($roll == "government" && $this->isGovernment()){
            $array = json_decode(Util::getGlobal("roll.government"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.government", json_encode($array));
        }
        elseif ($roll == "centralbank" && $this->isCentralBank()){
            $array = json_decode(Util::getGlobal("roll.centralbank"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.centralbank", json_encode($array));
        }
        elseif ($roll == "factoryinspectorare" && $this->isFactoryInspectorare()){
            $array = json_decode(Util::getGlobal("roll.factoryinspectorare"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.factoryinspectorare", json_encode($array));
        }
        elseif ($roll == "warehouse" && $this->isWarehouse()){
            $array = json_decode(Util::getGlobal("roll.warehouse"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.warehouse", json_encode($array));
        }
        elseif ($roll == "constitutional" && $this->isConstitutional()){
            $array = json_decode(Util::getGlobal("roll.constitutional"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.constitutional", json_encode($array));
        }
        elseif ($roll == "justice" && $this->isJustice()){
            $array = json_decode(Util::getGlobal("roll.justice"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.justice", json_encode($array));
        }
        elseif ($roll == "borderguard" && $this->isBorderGuard()){
            $array = json_decode(Util::getGlobal("roll.borderguard"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.borderguard", json_encode($array));
        }
    }

    private function array_remove($array, $elem) {
        if(($key = array_search($elem, $array)) !== false) {
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * Returns wether this citizen is in orga
     * @return bool
     */
    public function isOrga(){
        $array = json_decode(Util::getGlobal("roll.orga"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is in Police
     * @return bool
     */
    public function isPolice(){
        $array = json_decode(Util::getGlobal("roll.police"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is in Parlament
     * @return bool
     */
    public function isParlament(){
        $array = json_decode(Util::getGlobal("roll.parliament"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is an Administrator
     * @return bool
     */
    public function isAdministrator(){
        $array = json_decode(Util::getGlobal("roll.administrator"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is the monarch
     * @return bool
     */
    public function isMonarch(){
        $array = json_decode(Util::getGlobal("roll.monarch"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is in government
     * @return bool
     */
    public function isGovernment(){
        $array = json_decode(Util::getGlobal("roll.government"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is in central bank
     * @return bool
     */
    public function isCentralBank(){
        $array = json_decode(Util::getGlobal("roll.centralbank"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is in government
     * @return bool
     */
    public function isFactoryInspectorare(){
        $array = json_decode(Util::getGlobal("roll.factoryinspectorare"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is in warehouse
     * @return bool
     */
    public function isWarehouse(){
        $array = json_decode(Util::getGlobal("roll.warehouse"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is an constitutional
     * @return bool
     */
    public function isConstitutional(){
        $array = json_decode(Util::getGlobal("roll.constitutional"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is in Justice
     * @return bool
     */
    public function isJustice(){
        $array = json_decode(Util::getGlobal("roll.justice"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns wether this citizen is an BorderGuard
     * @return bool
     */
    public function isBorderGuard(){
        $array = json_decode(Util::getGlobal("roll.borderguard"));
        if(!is_array($array)) $array = [];
        return in_array($this->getCID(), $array);
    }

    /**
     * Returns the cIDs of all official state workers
     * @return mixed
     */
    public static function getAllOfficial(){
        $citizens = [];
        foreach(json_decode(Util::getGlobal("roll.orga")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.parliament")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.police")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.administrator")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.monarch")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.government")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.centralbank")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.factoryinspectorare")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.warehouse")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.constitutional")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.justice")) as $item)
            array_push($citizens, intval($item));
        foreach(json_decode(Util::getGlobal("roll.borderguard")) as $item)
            array_push($citizens, intval($item));
        return array_unique($citizens);
    }


    public static function getAllSpecials($group = 'all'){
        $citizens = [];
        if($group == 'all' or $group == 'orga') {
            foreach (json_decode(Util::getGlobal("roll.orga")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'parliament') {
            foreach (json_decode(Util::getGlobal("roll.parliament")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'police') {
            foreach (json_decode(Util::getGlobal("roll.police")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'administrator') {
            foreach (json_decode(Util::getGlobal("roll.administrator")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'monarch') {
            foreach (json_decode(Util::getGlobal("roll.monarch")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'government') {
            foreach (json_decode(Util::getGlobal("roll.government")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'centralbank') {
            foreach (json_decode(Util::getGlobal("roll.centralbank")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'factoryinspectorare') {
            foreach (json_decode(Util::getGlobal("roll.factoryinspectorare")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'warehouse') {
            foreach (json_decode(Util::getGlobal("roll.warehouse")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'constitutional') {
            foreach (json_decode(Util::getGlobal("roll.constitutional")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'justice') {
            foreach (json_decode(Util::getGlobal("roll.justice")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'borderguard') {
            foreach (json_decode(Util::getGlobal("roll.borderguard")) as $item)
                array_push($citizens, intval($item));
        }
        if($group == 'all' or $group == 'courrier') {
            array_push($citizens, self::getAllCitizen($filter = 'Kurier'));
        }
        return array_unique($citizens);
    }

    /**
     * Return if this citizen gets an white passport
     * @return bool
     */
    public function getsWhitePassport(){
        if ($this->isAdministrator()) return false;
        if ($this->isParlament()) return false;
        if ($this->isMonarch()) return false;
        if ($this->isGovernment()) return false;
        if ($this->isJustice()) return false;
        if ($this->isConstitutional()) return false;
        if ($this->isCentralBank() or $this->isPolice() or $this->isBorderGuard() or $this->isWarehouse() or $this->isFactoryInspectorare()){
            if ($this->isChief()) return false;
        }
        return true;
    }

    /**
     * Returns the Employer of this citizen
     * @return Employer[]
     */
    public function getEmployer(){
        return Employer::forCID($this->cID);
    }

    /**
     * Return if this citizen in chief in one of his employers
     * @return bool
     */
    public function isChief(){
        foreach ($this->getEmployer() as $employer){
            if (in_array($this, $employer->getChief())){
                return true;
            }
        }
        return false;
    }

    public function getEmployerData(){
        $array = [];
        foreach ($this->getEmployer() as $employer){
            array_push($array, $employer->asArrayOptimized());
        }
        return $array;
    }

    /**
     * @return Error
     */
    public function getLastError() {
        return end(Error::getErrorsByCitizen($this->cID));
    }

    /**
     * @return string
     */
    public function getBarcode() {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     */
    public function setBarcode($barcode) {
        $this->barcode = $barcode;
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
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    /**
     * @return int
     */
    public function getClasslevel() {
        return $this->classlevel;
    }

    /**
     * @param int $classlevel
     */
    public function setClasslevel($classlevel) {
        $this->classlevel = $classlevel;
    }

    /**
     * @return date
     */
    public function getBirthday() {
        return $this->birthday;
    }

    /**
     * @param date $birthday
     */
    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getClassdetail() {
        return $this->classdetail;
    }

    /**
     * @param mixed $classdetail
     */
    public function setClassdetail($classdetail) {
        $this->classdetail = $classdetail;
    }
}