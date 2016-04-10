<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 06.03.2016
 * Time: 18:49
 */

namespace Entrance;

use PDO;

const USORTING = [
    "ascName"  => " ORDER BY username ASC",
    "ascID"    => " ORDER BY uID ASC",
    "descName" => " ORDER BY username DESC",
    "descID"   => " ORDER BY uID DESC",
    "" => ""
];

const UFILTERING = [
    "" => "",
    "Alle" => "",
    "Admin"  => " WHERE lvl = 2 ",
    "Orga"   => " WHERE lvl = 1 ",
    "User"   => " WHERE lvl = 0 "
];

class User {
    private $uID;
    private $uName;
    private $uEmail;
    private $uPassHash;
    private $uPrefix;

    /**
     *
     *
     * @param $uID int User ID
     * @param $uName string Username
     * @param $uEmail string Users Email
     * @param $uPassHash string Users md5-hash
     * @param $level int User Level
     */
    private function __construct($uID, $uName, $uEmail, $uPassHash, $level) {
        $this->uID = $uID;
        $this->uName = $uName;
        $this->uEmail = $uEmail;
        $this->uPassHash = $uPassHash;
        $this->uPrefix = $level;
    } // 0- Schleuser | 1- Orga | 2-Admin


    /**
     * Creates a new User Object from a give user ID
     *
     * @param $uID int User ID
     * @return User
     */
    public static function fromUID($uID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_user WHERE uID = :uid", [":uid" => $uID]);
        return new User($res->uID, $res->username, $res->email, $res->passwd, $res->lvl);
    }

    /**
     * Creates a new User Object from a give username
     *
     * @param $uName string Username
     * @return User
     */
    public static function fromUName($uName) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_user WHERE username = :uname", [":uname" => $uName]);
        return new User($res->uID, $res->username, $res->email, $res->passwd, $res->lvl);
    }

    /**
     * @param int $uID
     */
    public function setUID($uID) {
        $this->uID = $uID;
    }

    /**
     * @param string $uName
     */
    public function setUName($uName) {
        $this->uName = $uName;
    }

    /**
     * @param string $uEmail
     */
    public function setUEmail($uEmail) {
        $this->uEmail = $uEmail;
    }
    
    /**
     * @param string $uPassHash
     */
    public function setUPassHash($uPassHash) {
        $this->uPassHash = md5($uPassHash);
    }

    /**
     * @param int $uPrefix
     */
    public function setUPrefix($uPrefix) {
        $this->uPrefix = $uPrefix;
    }


    /**
     * @return int User ID
     */
    public function getUID() {
        return $this->uID;
    }


    /**
     * @return int User Level
     */
    public function getUPrefix() {
        return $this->uPrefix;
    }

    /**
     * @return string Username
     */
    public function getUName() {
        return $this->uName;
    }

    /**
     * Compares a md5() hash with the given Hash from db
     *
     * @param $hash string md5-hash
     * @return bool
     */
    public function comparePWHash($hash) {
        if($hash == $this->uPassHash) {
            echo $hash . "<br/>" . $this->uPassHash;
            return true;
        } else {
            echo $hash . "<br/>" . $this->uPassHash;
            return false;
        }
    }

    /**
     * Every user has a nominal Level. This will return the prefix shown everywhere before the username
     *
     * @return string htmlnotated prefix
     */
    public function getPrefixAsHtml() {
        switch($this->uPrefix) {
            case 0:
                return '<span>[User]</span>';
                break;
            case 1:
                return '<span class="green-text">[Grenzer]</span>';
                break;
            case 2:
                return '<span class="blue-text">[Polizei]</span>';
                break;
            case 3:
                return '<span class="orange-text">[Orga]</span>';
                break;
            case 4:
                return '<span class="red-text">[Admin]</span>';
                break;
            default:
                return '<span>[User]</span>';
        }
    }

    /**
     * Checks if the user is permitted to do sth.
     *
     * @param $permission String for Permission
     * @return bool
     */
    public function isActionAllowed($permission) {
        if($this->uPrefix != 4) {
            $pdo = new PDO_MYSQL();
            $res = $pdo->query("SELECT * FROM entrance_user_rights WHERE uID = :uid AND permission = :key", [":uid" => $this->uID, ":key" => $permission]);
            if($res->active == 1) return true;
            else return false;
        } else return true;
    }


    /**
     * Tests if a permission action key is already present in the DB
     *
     * @param $permission string
     * @return bool
     */
    public function isActionInDB($permission) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_user_rights WHERE uID = :uid AND permission = :key", [":uid" => $this->uID, ":key" => $permission]);
        return isset($res->active);
    }

    /**
     * Updates a value for a specific action key or creates a new entry in the DB
     *
     * @param $actionKey string
     * @param $state int
     */
    public function setPermission($actionKey, $state) {
        $pdo = new PDO_MYSQL();
        if($this->isActionInDB($actionKey))
            $pdo->query("UPDATE entrance_user_rights SET active = :state WHERE uID = :uid and permission = :key", [":uid" => $this->uID, ":key" => $actionKey, ":state" => $state]);
        else
            $pdo->query("INSERT INTO entrance_user_rights(active, uID, permission) VALUES (:state, :uid, :key)", [":uid" => $this->uID, ":key" => $actionKey, ":state" => $state]);
    }

    /**
     * Makes this class as an array to use for tables etc.
     *
     * @return array
     */
    public function asArray() {
        return [
            "id" => $this->uID,
            "usrname" => $this->uName,
            "usrchar" => $this->uName[0],
            "email" => $this->uEmail,
            "lvl" => $this->uPrefix,
            "prefix" => $this->getPrefixAsHtml()
        ];
    }


    /**
     * Makes this class as an string to use for debug only
     *
     * @return string
     */
    public function toString() {
        return
            "id:        ".$this->uID."\n".
            "usrname:   ".$this->uName."\n".
            "usrchar:   ".$this->uName[0]."\n".
            "email:     ".$this->uEmail."\n".
            "lvl:       ".$this->uPrefix."\n".
            "prefix:    ".$this->getPrefixAsHtml()."\n";
    }

    /**
     * Returns all permission for this user as an use-ready array
     *
     * @return array
     */
    public function getPermAsArray() {
        $array = [];
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT * FROM entrance_user_rights WHERE uID = :uid", [":uid" => $this->uID]);
        while($row = $stmt->fetchObject()) {
            $array[str_replace(".", "_", $row->permission)] = (int) $this->isActionAllowed($row->permission);
        }
        return $array;
    }

    /**
     * checks if a username is in the user db
     *
     * @param $uName string Username
     * @return bool
     */
    public static function doesUserNameExist($uName) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM entrance_user WHERE username = :uname", [":uname" => $uName]);
        if(isset($res->uID)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns all users as a array of Userobjects from db
     *
     * @param string $sort
     * @param string $filter
     * @return User[]
     */
    public static function getAllUsers($sort = "", $filter = "") {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti('SELECT uID FROM entrance_user '.UFILTERING[$filter].' '.USORTING[$sort]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\User::fromUID");
    }

    /**
     * Returns all Admins
     * @return array
     */
    public static function getAllAdmins() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT uID FROM entrance_user WHERE lvl = 4 ORDER BY uID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\Entrance\\User::fromUID");
    }

    /**
     * Deletes a user
     *
     * @return bool
     */
    public function delete() {
        $pdo = new PDO_MYSQL();
        return $pdo->query("DELETE FROM entrance_user WHERE uID = :uid", [":uid" => $this->uID]);
    }

    /**
     * Saves the Changes made to this object to the db
     */
    public function saveChanges() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE entrance_user SET email = :Email, passwd = :Passwd, username = :Username, lvl = :lvl WHERE uID = :uID LIMIT 1",
            [":Email" => $this->uEmail, ":Passwd" => $this->uPassHash, ":Username" => $this->uName, ":uID" => $this->uID, ":lvl" => $this->uPrefix]);
    }

    /**
     * Creates a new user from the give attribs
     *
     * @param $username string Username
     * @param $email string Email Adress
     * @param $passwdhash string md5 Hash of Password
     * @return User The new User as an Object
     */
    public static function createUser($username, $email, $passwdhash) {
        $pdo = new PDO_MYSQL();
        $pdo->query("INSERT INTO entrance_user(username, email, passwd) VALUES (:Username, :Email, :Passwd)",
            [":Username" => $username, ":Email" => $email, ":Passwd" => md5($passwdhash)]);
        return self::fromUName($username);
    }
}