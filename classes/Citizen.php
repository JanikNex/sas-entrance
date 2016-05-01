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
    "" => ""
];

const CFILTERING = [
    ""          => "",
    "Alle"      => "",
    "Stufe5"   => " AND classLevel = 5 ",
    "Stufe6"   => " AND classLevel = 6 ",
    "Stufe7"   => " AND classLevel = 7 ",
    "Stufe8"   => " AND classLevel = 8 ",
    "Stufe9"   => " AND classLevel = 9 ",
    "Stufe05"   => " AND classLevel = 5 ",
    "Stufe06"   => " AND classLevel = 6 ",
    "Stufe07"   => " AND classLevel = 7 ",
    "Stufe08"   => " AND classLevel = 8 ",
    "Stufe09"   => " AND classLevel = 9 ",
    "Stufe10"   => " AND classLevel = 10 ",
    "Stufe11"   => " AND classLevel = 11 ",
    "Stufe12"   => " AND classLevel = 12 ",
    "Stufe13"   => " AND classLevel = 13 ",
    "Stufe14"   => " AND classLevel = 14 ",
    "Stufe15"   => " AND classLevel = 15 ",
    "Stufe16"   => " AND classLevel = 16 ",
    "Schüler"   => " AND classLevel < 14 ",
    "ohneVisumK"=> " AND classLevel < 15 ",
    "Visum"     => " AND classLevel = 15 ",
    "Lehrer"    => " AND classLevel = 14 ",
    "Kurier"    => " AND classLevel = 16 ",
    "ohneKurier"=> " AND classLevel < 16"
];


class Citizen {
    private $cID, $firstname, $lastname, $classlevel, $birthday, $barcode;

    /**
     * Citizen constructor.
     * @param $cID
     * @param $firstname
     * @param $lastname
     * @param $classlevel
     * @param $birthday
     * @param $barcode
     */
    public function __construct($cID, $firstname, $lastname, $classlevel, $birthday, $barcode) {
        $this->cID = $cID;
        $this->firstname = utf8_encode($firstname);
        $this->lastname = utf8_encode($lastname);
        $this->classlevel = $classlevel;
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
        return new Citizen($res->cID, $res->firstname, $res->lastname, $res->classLevel, $res->birthday, $res -> barcode);
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
        return new Citizen($res->cID, $res->firstname, $res->lastname, $res->classLevel, $res->birthday, $res -> barcode);
    }

    /**
     * Creates a new Citizen in the db with the provided data
     *
     * @param string $firstname
     * @param string $lastname
     * @param int $classlevel
     * @param date $birthday
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
        if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE MATCH(firstname, lastname) AGAINST('".$search."' IN BOOLEAN MODE) ".CFILTERING[$filter].CSORTING[$sort];
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
                $query = "SELECT cID FROM entrance_citizen WHERE MATCH(firstname, lastname) AGAINST('".$_GET["search"]."' IN BOOLEAN MODE) ".CFILTERING[$filter].CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
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
     * Returns all Citizen, which are currently in the State
     *
     * @param string $sort
     * @param string $filter
     * @param int $page
     * @param int $pagesize
     * @param string $search
     * @return Citizen[]
     */
    public static function getAllCitizenInState($sort = "", $filter = "", $page = 1, $pagesize = 999999, $search = "") {
        $pdo = new PDO_MYSQL();
        if($filter != "Gesperrt") {
            if($search != "") {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $query = "SELECT cID FROM entrance_citizen WHERE MATCH(firstname, lastname) AGAINST('".$_GET["search"]."' IN BOOLEAN MODE) AND state = 0".CFILTERING[$filter].CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
                $stmt = $pdo->queryMulti($query);
                return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            } else {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE state = 0" . CFILTERING[$filter] . CSORTING[$sort]." LIMIT ".$startElem.','.$endElem);
                return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            }
        } else {
            $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen state = 0" . CSORTING[$sort]);
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
     * Count of @see getAllCitizenInState()
     *
     * @param string $sort
     * @param string $filter
     * @param string $search
     * @return int
     */
    public static function getCurrentCitizenCount($sort, $filter, $search) {
        $pdo = new PDO_MYSQL();
        if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE MATCH(firstname, lastname) AGAINST('".$search."' IN BOOLEAN MODE) AND state = 0".CFILTERING[$filter].CSORTING[$sort];
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
    public static function getAllWantedCitizens($page = 1, $pagesize = 999999, $search = "") {
        $pdo = new PDO_MYSQL();
        if($search != "") {
            $startElem = ($page-1) * $pagesize;
            $endElem = $startElem + $pagesize;
            $query = "SELECT cID FROM entrance_tracing WHERE MATCH(firstname, lastname) AGAINST('".$_GET["search"]."' IN BOOLEAN MODE) WHERE active = 1 LIMIT ".$startElem.','.$endElem;
            $stmt = $pdo->queryMulti($query);
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
        } else {
            $startElem = ($page-1) * $pagesize;
            $endElem = $startElem + $pagesize;
            $stmt = $pdo->queryMulti("SELECT cID FROM entrance_tracing WHERE active = 1 LIMIT ".$startElem.','.$endElem);
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
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
        if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_tracing WHERE MATCH(firstname, lastname) AGAINST('".$search."' IN BOOLEAN MODE) AND active = 1";
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
    public static function getAllBadCitizen($sort = "", $filter = "Schüler", $page = 1, $pagesize = 9999999, $search = "") {
        $pdo = new PDO_MYSQL();
        if($filter != "Gesperrt") {
            if($search != "") {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $query = "SELECT cID FROM entrance_citizen WHERE MATCH(firstname, lastname) AGAINST('".$_GET["search"]."' IN BOOLEAN MODE) AND isBad = 1".CFILTERING[$filter].CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
                $stmt = $pdo->queryMulti($query);
                return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            } else {
                $startElem = ($page-1) * $pagesize;
                $endElem = $startElem + $pagesize;
                $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE isBad = 1". CFILTERING[$filter] . CSORTING[$sort]." LIMIT ".$startElem.','.$endElem);
                return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
            }
        } else {
            $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE isBad = 1" . CSORTING[$sort]);
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
     * Count of @see getAllBadCitizens()
     *
     * @param string $sort
     * @param string $filter
     * @param string $search
     * @return int
     */
    public static function getCurrentBadCitizenCount($sort = "", $filter = "Schüler", $search = ""){
        $pdo = new PDO_MYSQL();
        if($search != "") $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE MATCH(firstname, lastname) AGAINST('".$search."' IN BOOLEAN MODE) AND isBad = 1 ".CFILTERING[$filter].CSORTING[$sort];
        else $query = "SELECT COUNT(*) as count FROM entrance_citizen WHERE isBad = 1".CFILTERING[$filter].CSORTING[$sort];

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
     * Returns all Students currently in the state
     *
     * @param string $sort
     * @param string $filter
     * @param string $search
     * @return Citizen[]
     */
    public static function getAllStudentsInState($sort = "", $filter = "Schüler", $search = "") {
        return self::getAllCitizenInState($sort, $filter, $search);
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
        return self::getAllCitizen($sort, "Schüler", $page, $pagesize, $search);
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
        $pdo = new PDO_MYSQL();
        if($search != "") {
            $startElem = ($page-1) * $pagesize;
            $endElem = $startElem + $pagesize;
            $query = "SELECT cID FROM entrance_citizen WHERE MATCH(firstname, lastname) AGAINST('".$_GET["search"]."' IN BOOLEAN MODE) AND classlevel = 16 AND state = 1  ".CSORTING[$sort]." LIMIT ".$startElem.','.$endElem;
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
            "birthday" => $this->birthday,
            "birthdayNice" => date("d. M Y", strtotime($this->birthday))." (".Util::getAge($this->birthday).")",
            "age" => Util::getAge($this->birthday),
            "barcode" => $this->barcode,
            "roll" => $this->getRoll(),
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
        $days = LogEntry::getProjectDays();
        $isBad = 0;
        foreach($days as $day){
            if(($this -> getTimePerDay($day) <= 21600) && ($this->getClasslevel()<13)){
                $isBad = 1;
                break;
            }
        }
        $pdo->query("UPDATE entrance_citizen SET isBad = :isBad WHERE cID = :cID", [":cID" => $this->getCID(), ":isBad" => $isBad]);
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
     * @param date $date
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
     * Returns true if the citizen was over 6 hours in state today
     *
     * @return bool
     */
    public function hasCitizenEnoughTime(){
        $date = date("Y-m-d");
        if ($this -> getClasslevel() < 13){
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
        $students = Citizen::getAllStudents($sort="ascBarcode");
        $list = [];
        $currentClass = [0,0];
        $label = ["cID", "Vorname", "Nachname", "Klassenstufe", "Barcode"];
        foreach (LogEntry::getProjectDays() as $day){
            array_push($label, $day);
        }
        array_push($label, "Gesamtzeit");
        array_push($list, $label);
        foreach ($students as $student){
            if($student->getClasslevel()<= 10){
                if(!((substr($student->getBarcode(), 8, 2) == $currentClass[0]) && (substr($student->getBarcode(), 10, 1) == $currentClass[1]))){
                    $currentClass = [substr($student->getBarcode(), 8, 2), substr($student->getBarcode(), 10, 1)];
                    array_push($list, ["Klasse", $currentClass[0], $currentClass[1]]);
                }
            } else{
                if(!((substr($student->getBarcode(), 8, 2) == $currentClass[0]))){
                    $currentClass = [substr($student->getBarcode(), 8, 2), 0];
                    array_push($list, ["Klasse", $currentClass[0]]);
                }
            }
            array_push($list, $student->timeAsArray());
        }

        return $list;
    }


    /**
     *Sends the Classlist as Array to the CSV creator
     */
    public static function createClasslistAsCSV(){
        $array = self::createClassListsAsArray();
        Util::writeCSV($array, "/var/customers/webs/Chaos234/yannick9906/csv/classlist".date("Y-m-d_H-i").".csv");
        Util::writeCSV($array, "/var/customers/webs/Chaos234/yannick9906/janik/csv/classlist".date("Y-m-d_H-i").".csv");
    }

    /**
     * Returns the citizens passport data
     * @return array
     */
    public function getCitizenPassportData(){
        if($this->getClasslevel() != 15){
            $data = [[
                "name" => $this->lastname,
                "firstname" => $this->firstname,
                "barcode" => $this->barcode,
                "roll" => $this->getRoll()
            ]];
        }elseif($this->getClasslevel() == 15){
            $data = [[
                "name" => $this->firstname,
                "firstname" => $this->lastname,
                "barcode" => $this->barcode,
                "roll" => $this->getRoll()
            ]];
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

    public static function printPassportGroup($group){
        $citizens = self::getAllCitizen("", "Stufe".$group);
        $data = [];
        foreach ($citizens as $citizen){
            array_push($data, $citizen->getCitizenPassportData());
        }
        return self::printPassport($data, $group);
    }

    /**
     * Prints passport(s) from given citizenpassportdata
     * @param array[] $data
     */
    public static function printPassport($data, $group = 0){
        $size = sizeof($data);
        $pages = ceil($size/10);
        $dwoo = new \Dwoo\Core();
        $tpl = new \Dwoo\Template\File('tpl/passport.tpl');
        if($size> 10){
            $html = "";
            for ($i=0; $i<$pages;$i++){
                $page = [];
                for ($e=$i*10; $e<=10;$e++) {
                    array_push($page, $data[$e]);
                }
                if($i == $pages-1){
                    $count = 10-(($pages*10)-$size);
                }else{
                    $count = 10;
                }
                $pgdata = [
                    "size" => $count,
                    "data" => $page
                ];
                $html .= $dwoo->get($tpl, $pgdata);
            }
        }else{
            $pgdata = [
                "size" => $size,
                "data" => $data[0]
            ];
            $html = $dwoo->get($tpl, $pgdata);
        }
        $html = "<page>".$html."</page>";
        $link = "/var/customers/webs/Chaos234/yannick9906/pdf/passports-".$group."-".date("Y-m-d_H-i-s").".pdf";
        Util::writePDF($html, $link);
        return $link;
    }

    /**
     * Returns an array with all important student informations and his times per day
     * @return array
     */
    public function timeAsArray(){
        $studentData = [
            "id" => $this->cID,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "classlevel" => $this->classlevel,
            "barcode" => $this->barcode
        ];
        foreach (LogEntry::getProjectDays() as $day){
            array_push($studentData, Util::seconds_to_time($this->getTimePerDay($day)));
        }
        array_push($studentData, Util::seconds_to_time($this->getTimePerProject()));
        return $studentData;
    }

    public function getRoll(){
        $roll = "";
        $array = [];
        if ($this->isOrga()){
            array_push($array, "Orga-Team");
        }
        if ($this->isPolizei()){
            array_push($array, "Polizei");
        }
        if ($this->isParlament()){
            array_push($array, "Parlament");
        }
        if ($this->isCourrier()){
            array_push($array, "Kurier");
        }
        $roll = $array[0];
        foreach ($array as $part) {
            if($part != $array[0]) $roll .=", ".$part;
        }
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
        elseif ($roll == "police" && !$this->isPolizei()){
            $array = json_decode(Util::getGlobal("roll.police"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.police", json_encode($array));
        }
        elseif ($roll == "parliament" && !$this->isParlament()){
            $array = json_decode(Util::getGlobal("roll.parliament"));
            array_push($array, $this->getCID());
            Util::setGlobal("roll.parliament", json_encode($array));
        }
    }

    /**
     * Removes a specific roll from this citizen
     * @param $roll
     */
    public function removeRoll($roll){
        if ($roll == "orga"){
            $array = json_decode(Util::getGlobal("roll.orga"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.orga", json_encode($array));
        }
        elseif ($roll == "police"){
            $array = json_decode(Util::getGlobal("roll.police"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.police", json_encode($array));
        }
        elseif ($roll == "parliament"){
            $array = json_decode(Util::getGlobal("roll.parliament"));
            $array = self::array_remove($array, $this->getCID());
            Util::setGlobal("roll.parliament", json_encode($array));
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
    public function isPolizei(){
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
}