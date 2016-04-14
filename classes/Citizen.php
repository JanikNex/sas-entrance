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
    "ascName"  => " ORDER BY lastname ASC",
    "ascID"    => " ORDER BY cID ASC",
    "descName" => " ORDER BY lastname DESC",
    "descID"   => " ORDER BY cID DESC",
    "" => ""
];

const CFILTERING = [
    ""          => "",
    "Alle"      => "",
    "Stufe05"   => " WHERE classLevel = 5 ",
    "Stufe06"   => " WHERE classLevel = 6 ",
    "Stufe07"   => " WHERE classLevel = 7 ",
    "Stufe08"   => " WHERE classLevel = 8 ",
    "Stufe09"   => " WHERE classLevel = 9 ",
    "Stufe10"   => " WHERE classLevel = 10 ",
    "Stufe11"   => " WHERE classLevel = 11 ",
    "Stufe12"   => " WHERE classLevel = 12 ",
    "Visum"     => " WHERE classLevel = 15 ",
    "Lehrer"    => " WHERE classLevel = 14 ",
    "Kurier"    => " WHERE classLevel = 16 "
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
        $this->firstname = $firstname;
        $this->lastname = $lastname;
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
     * Returns all Citizen in the db
     * Todo provide Sorting by
     *
     * @param string $sort
     * @param string $filter
     * @return Citizen[]
     */
    public static function getAllCitizen($sort = "", $filter = "") {
        $pdo = new PDO_MYSQL();
        if($filter != "Gesperrt") {
            $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen " . CFILTERING[$filter] . CSORTING[$sort]);
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
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
     * Returns all Citizen in the db; Filter: Students
     * Todo provide Sorting by
     *
     * @param $sort
     * @param $filter
     * @return Citizen[]
     */
    public static function getAllStudents($sort, $filter) {
        $pdo = new PDO_MYSQL();
        if($filter != "Gesperrt") {
            $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen " . CFILTERING[$filter] . CSORTING[$sort]);
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
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
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen WHERE classlevel < 14 ORDER BY cID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
    }

    /**
     * Returns all Citizen, which are currently in the State
     *
     * @return Citizen[]
     */
    public static function getAllCitizenInState($sort, $filter) {
        $citizens = self::getAllCitizen($sort, $filter);
        $citizenInState = [];
        foreach($citizens as $citizen){
            if($citizen -> isCitizenInState() == 0 && !$citizen -> isCourrier())
                array_push($citizenInState, $citizen);
        }
        return $citizenInState;
    }

    /**
     * Returns all Visitors currently in the State
     *
     * @return Citizen[]
     */
    public static function getAllVisitorsInState() {
        $citizens = self::getAllCitizen();
        $citizenInState = [];
        foreach($citizens as $citizen){
            if($citizen -> isCitizenInState() == 0 && $citizen -> getClasslevel() == 15)
                array_push($citizenInState, $citizen);
        }
        return $citizenInState;
    }

    /**
     * Returns all Students currently in the state
     *
     * @return Citizen[]
     */
    public static function getAllStudentsInState() {
        $citizens = self::getAllCitizen();
        $citizenInState = [];
        foreach($citizens as $citizen){
            if($citizen -> isCitizenInState() == 0 && $citizen -> getClasslevel() < 14)
                array_push($citizenInState, $citizen);
        }
        return $citizenInState;
    }

    /**
     * Returns all Courriers, which are on a tour
     *
     * @return Citizen[]
     */
    public static function getAllCourriersOutOfState(){
        $citizens = self::getAllCitizen();
        $courrierOutOfState = [];
        foreach($citizens as $citizen){
            if($citizen -> isCitizenInState() == 1 && $citizen -> isCourrier())
                array_push($courrierOutOfState, $citizen);
        }
        return $courrierOutOfState;
    }

    /**
     * Returns all wanted citizens
     *
     * @return Citizen[]
     */
    public static function getAllWantedCitizens() {
        $citizens = self::getAllCitizen();
        $wantedCitizens = [];
        foreach($citizens as $citizen){
            if($citizen -> isCitizenWanted())
                array_push($wantedCitizens, $citizen);
        }
        return $wantedCitizens;
    }
    
    /**
     * Count of @see getAllCitizenInState()
     *
     * @return int
     */
    public static function getCurrentCitizenCount() {
        return sizeof(self::getAllCitizenInState());
    }

    /**
     * Count of @see getAllStudentsInState()
     *
     * @return int
     */
    public static function getCurrentStudentCount() {
        return sizeof(self::getAllStudentsInState());
    }

    /**
     * Count of @see getAllVisitorsInState()
     *
     * @return int
     */
    public static function getCurrentVisitorCount() {
        return sizeof(self::getAllVisitorsInState());
    }

    /**
     * Count of @see getAllCourrierOutOfState()
     *
     * @return int
     */
    public static function getCurrentCourrierCount(){
        return sizeof(self::getAllCourriersOutOfState());
    }

    /**
     * Count of @see getAllBadCitizens()
     *
     * @return int
     */
    public static function getCurrentBadCitizenCount(){
        return sizeof(self::getAllBadCitizen());
    }

    /**
     * Returns all "bad" citizen
     *
     * @param $sort
     * @param $filter
     * @return Citizen[]
     */
    public static function getAllBadCitizen($sort, $filter) {
        $citizens = self::getAllStudents($sort, $filter);
        $days = LogEntry::getProjectDays();
        $badCitizens = [];
        foreach($citizens as $citizen){
            foreach($days as $day){
                if(($citizen -> getTimePerDay($day) <= 21600) && ($citizen->getClasslevel()<13)){
                    array_push($badCitizens, $citizen);
                    break;
                }
            }
        }
        return $badCitizens;
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
                return true;
            }
        } elseif ($this->isCourrier()) {
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 0, 0)",
                [":cID" => $this->cID, ":uID" => $user->getUID(), ":timestamp" => $date]);
            Error::createError($this->cID, 3);
            $this->getLastEntry()->invalidateLogEntryBeforeEntry();
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
            return true;
        }
        elseif($this -> isCitizenInState() == 0){
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 1, 0)",
                [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => $date]);
            $this->getLastEntry()->invalidateLogEntryBeforeEntry();
            Error::correctError($this->cID);
            $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 0, 1)",
                [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => $date]);
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
                return true;
            }
            return false;
        }elseif($this -> isCourrier()){
            if ($this->isCitizenInState() != 1) {
                Error::correctError($this->getCID());
                $pdo->query("INSERT INTO entrance_logs(cID, uID,`timestamp`, `action`, success) VALUES (:cID,:uID, :timestamp, 1, 1)",
                    [":cID" => $this->cID, ":uID" => $user -> getUID(), ":timestamp" => date("Y-m-d H:i:s")]);
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
                return true;
            }else{
                LogEntry::ignoreLastLogEntry($this, $user);
                $this -> getLastEntry() -> validateLogEntry();
                Error::correctError($this->cID);
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