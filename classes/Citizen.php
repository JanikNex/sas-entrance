<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 06.03.2016
 * Time: 18:50
 */

namespace Entrance;

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

    public static function fromCID($cID) {

    }

    public static function fromBarcode($barcode) {

    }

    /**
     * @param $cID
     * @param $firstname
     * @param $lastname
     * @param $classlevel
     * @param $birthday
     * @param $barcode
     */
    public static function createCitizen($cID, $firstname, $lastname, $classlevel, $birthday, $barcode) {
        $pdo = new PDO_MYSQL();
        $pdo->query("INSERT INTO entrance_citizen(firstname, lastname, classlevel, birthday, barcode) VALUES (:firstname, :lastname, :classlevel, birthday, barcode)",
            [":firstname" => $firstname, ":lastname" => $lastname, ":classlevel" => $classlevel, ":birthday" => $birthday, ":barcode" => $barcode]);
    }

    /**
     * @return Citizen[]
     */
    public static function getAllCitizen() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT cID FROM entrance_citizen ORDER BY cID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\Citizen::fromCID");
    }

    /**
     * @return Citizen[]
     */
    public static function getAllCitizenInState() {
        $citizens = self::getAllCitizen();
        $citizenInState = [];
        foreach($citizens as $citizen){
            if($citizen -> isCitizenInState())
                array_push($citizenInState, $citizen);
        }
        return $citizenInState;
    }

    /**
     * @return int
     */
    public static function getCurrentCitizenCount() {
        return sizeof(self::getAllCitizenInState());
    }

    public static function getAllBadCitizen() {

    }

    /**
     * @return array
     */
    public function asArray() {
        return [
            "id" => $this->cID,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "classlevel" => $this->classlevel,
            "birthday" => $this->birthday,
            "barcode" => $this->barcode
        ];
    }

    /**
     * @return bool
     */
    public function delete() {
        $pdo = new PDO_MYSQL();
        return $pdo->query("DELETE FROM entrance_citizen WHERE cID = :cid", [":cid" => $this->cID]);
    }

    public function isCitizenInState() {

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