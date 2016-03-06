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

    public static function createCitizen($cID, $firstname, $lastname, $classlevel, $birthday, $barcode) {

    }

    public static function getAllCitizen() {

    }

    public static function getAllCitizenInState() {

    }

    public static function getCurrentCitizenCount() {

    }

    public static function getAllBadCitizen() {

    }

    public function asArray() {

    }

    public function delete() {

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