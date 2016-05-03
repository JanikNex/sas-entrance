<?php
/**
 * Created by PhpStorm.
 * User: yannick
 * Date: 06.03.2016
 * Time: 18:17
 *
 * Hier kommt alles an schönen Funktionen rein, die nicht in eine Klasse passen
 * Alle Funktionen bitte static machen
 */
namespace Entrance;

 use DateTime;
 use DateTimeZone;

 class Util {

     /**
      * @return bool|\Entrance\User
      */
     public static function checkSession() {
         session_start();
         if(!isset($_SESSION["uID"])) {
             self::forwardTo("logon.php?badsession=1");
             exit;
         } else {
             $user = User::fromUID($_SESSION["uID"]);
             if($_GET["m"] == "debug") {
                 echo "<pre style='display: block; position: absolute'>\n";
                 echo "[0] Perm Array Information:\n";
                 var_dump($user->getPermAsArray());
                 echo "\n[1] Permission Information:\n";
                 self::printPermission($user);
                 echo "\n[2] User Information:\n";
                 echo $user->toString();
                 echo "\n[3] Client Information:\n";
                 echo "    Arguments: ".$_SERVER["REQUEST_URI"]."\n";
                 echo "    Req Time : ".$_SERVER["REQUEST_TIME"]."ns\n";
                 echo "    Remote IP: ".$_SERVER["REMOTE_ADDR"]."\n";
                 echo "    Usr Agent: ".$_SERVER["HTTP_USER_AGENT"]."\n";
                 echo "</pre>\n";
             }

             return $user;
         }
     }

     /**
      * @param $user \Entrance\User
      */
     public static function printPermission($user) {
         $consts = self::returnConstants("PERM");
         foreach ($consts as $const) {
             echo "    ".$const.": ".(($user->isActionAllowed($const)) ? 'on' : 'off')."\n";
         }
     }

     /**
      * @param $prefix
      * @return array
      */
     public static function returnConstants($prefix) {
         foreach (get_defined_constants() as $key=>$value)
             if (substr($key,0,strlen($prefix))==$prefix)  $dump[$key] = $value;
         if(empty($dump)) { return "Error: No Constants found with prefix '".$prefix."'"; }
         else { return $dump; }
     }

     /**
      * Forwards the user to a specific url
      *
      * @param $url
      */
     public static function forwardTo($url) {
         echo "<meta http-equiv=\"refresh\" content=\"0; url=$url\" />";
     }

     /**
      * @param $title String
      * @param $user \Entrance\User
      * @param bool $backable
      * @param bool $editor
      * @param string $undoUrl
      * @return array
      */
     public static function getEditorPageDataStub($title, $user, $backable = false, $editor = false, $undoUrl = "") {
         return [
             "header" => [
                 "title" => $title,
                 "usrname" => $user->getUName(),
                 "usrchar" => substr($user->getUName(), 0, 1),
                 "uID" => $user->getUID(),
                 "level" => $user->getUPrefix(),
                 "perm" => $user->getPermAsArray(),
                 "editor" => $editor ? 1:0,
                 "undoUrl" => $undoUrl,
                 "backable" => $backable ? 1:0
             ],
             "perm" => $user->getPermAsArray()
         ];
     }

     /**
      * @param $bithdayDate timestamp
      * @return int
      */
     public static function getAge($bithdayDate) {
         $date = new DateTime($bithdayDate);
         $now = new DateTime();
         $interval = $now->diff($date);
         return $interval->y;
     }

     /**
      * @param $secs int
      * @return string
      */
     public static function seconds_to_time($secs) {
         $dt = new DateTime('@' . $secs, new DateTimeZone('UTC'));
         $array = array('days'    => $dt->format('z'),
             'hours'   => $dt->format('G'),
             'minutes' => $dt->format('i'),
             'seconds' => $dt->format('s'));

         return $array["days"]." Tage ".$array["hours"]."h ".$array["minutes"]."m ".$array["seconds"]."s";
     }

     /**
      * Returns the global key value
      * @param $key
      * @return bool
      */
     public static function getGlobal($key){
         $pdo = new PDO_MYSQL();
         $res = $pdo->query("SELECT * FROM `global` WHERE `key` = :key", [":key" => $key]);
         return $res->value;
     }

     /**
      * Sets a global Key on a Value
      * @param $key
      * @param $value
      */
     public static function setGlobal($key, $value) {
         $pdo = new PDO_MYSQL();
         $pdo->query("UPDATE `global` SET `value` = :state WHERE `key` = :key", [":state" => $value, ":key" => $key]);
     }

     /**
      *Opens the state
      */
     public static function openState() {
        self::setGlobal("state.opened", 1);
     }

     /**
      *Closes the state
      */
     public static function closeState() {
        self::setGlobal("state.opened", 0);
     }

     /**
      * Returns wether the state is opened or not
      * @return bool
      */
     public static function isStateOpen() {
         if(self::getGlobal("state.opened") == 1) return true;
         else return false;
     }

     /**
      * Sends a mail to all Admins
      * @param string $topic
      * @param $msg
      */
     public static function mailToAdmins($msg, $topic = "SaSEntrance - Notification"){
         $admins = User::getAllAdmins();
         $header = 'From: SaSEntrance <fakemail657@gmail.com>' . "\r\n";
         foreach ($admins as $admin){
             if($admin -> isActionAllowed(PERM_ADMIN_NOTIFY_RECEIVE)) {
                 mail($admin->getUEmail(), $topic, $msg, $header);
             }
         }
     }

     /**
      * Writes the given list as CSV in a specific file
      * @param $list
      * @param $filename
      */
     public static function writeCSV($list, $filename){
         $fp = fopen($filename, 'w') or die("Error");
         foreach ($list as $fields) {
             fputcsv($fp, $fields);
         }
         fclose($fp);
     }

     /**
      * Creates a downloadable pdf document from HTML code using TCPDF
      * http://wiki.spipu.net/doku.php?id=html2pdf:de:v4:5_page
      * @param $html
      * @param $filename
      */
     public static function writePDF($html, $filename){
         $html2pdf = new \HTML2PDF('P','A4','de', true, 'UTF-8', array(10,10,10,10));
         //$html2pdf->setModeDebug();
         $html2pdf->setDefaultFont('Arial');
         $html2pdf->pdf->SetAuthor('SaSEntrance 2016');
         $html2pdf->pdf->SetTitle('SaSEntrance Export'.date("Y-m-d_H-i"));
         $html2pdf->pdf->SetSubject('SaSEntrance 2016');

         $html2pdf->writeHTML($html, false);
         $html2pdf->Output($filename,"F");
     }
 }