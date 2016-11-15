<?php

/*
 * 20160921 - New -
 * 20160922 - Implemented functions
 * 20161027 - added interval check for reset password link expiry
 NOTE strPassword = clear text password
       salt = random salt value
       hash = sha( salt + strPW)
 */

class ZoriPassword
{
   private static $SETTING_ENABLED = "PASSWORD_Enable_Policy";
   private $PASSWORD_Enable_Policy;
   private $PASSWORD_Strength_Check;
   private $PASSWORD_Strength_Check_MinLength;
   private $PASSWORD_Strength_Check_Description;
   private $PASSWORD_MaxAge;
   private $PASSWORD_MaxHistory;
   private $PASSWORD_Restricted_Words;
   private $PASSWORD_Reset_Interval;
   private $arrPasswords = array();
   private $rowPassword;

   public static $PASSWORD_Password_Mismatch_Error = "Password not saved. The old password does not match the current password in the database. ";
   public static $PASSWORD_Invalid_Login_Details = "Login Details are invalid.";
   public static $PASSWORD_User_Inactive = "User account is inactive. ";
   public static $PASSWORD_User_Account_Locked = "User account is locked. ";
   public static $PASSWORD_Check_Fail = "Username or Password incorrect. ";
   public static $PASSWORD_Check_Pass = "Username and Password correct. ";
   public static $PASSWORD_Reset_Success = "Password has been reset. Please login with your new password. ";
   public static $PASSWORD_Expired = "Your password has expired and needs to be reset. ";
   public static $PASSWORD_Already_Used = "Password not saved. Your password has already been used. ";
   public static $PASSWORD_Reset_Error = "Password reset Failed. Error resetting the Password. ";
   public static $PASSWORD_Saved = "Your password has been updated. ";
   public $salt = "";
   public $hash = "";

   public function __construct()
   {
      global $MYSQLI, $_LANGUAGE, $_TRANSLATION, $SystemSettings, $xdb, $BR, $SP, $TR;

      //first time run:
      $row = $xdb->getRowSQL("SHOW TABLES LIKE 'sysPassword'",0);
      if(!$row)
      {
         //run ini:
         $xdb->doQuery("CREATE TABLE `sysPassword` (
            `ID` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `Type` ENUM( 'User', 'Supplier' ) NOT NULL DEFAULT 'User',
            `UserID` INT( 11 ) NOT NULL ,
            `salt` VARCHAR( 64 ) NOT NULL ,
            `hash` VARCHAR( 64 ) NOT NULL COMMENT '= hash(protocol, salt + password)',
            `dtPassword` DATE NOT NULL ,
            `strLastUser` VARCHAR( 100 ) NOT NULL DEFAULT 'System',
            `dtLastEdit` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            INDEX ( `Type` , `UserID` , `dtPassword` )
            ) ENGINE = InnoDB;", 0);


         $xdb->doQuery("ALTER TABLE `sysSettings` ADD UNIQUE (`strSetting`)",0); //just in case
         $xdb->doQuery("
            INSERT INTO sysSettings(`strSetting`, `strValue`, `strComment`, `strLastUser`)
            VALUES ('PASSWORD_Enable_Policy', '1', '1 = use sysPassword', 'SYSTEM')
            , ('PASSWORD_Strength_Check', 'true', 'js expression', 'SYSTEM')
            , ('PASSWORD_Strength_Check_MinLength', '8', 'minimum length of password', 'SYSTEM' )
            , ('PASSWORD_Strength_Check_Description', '???', 'message', 'SYSTEM')
            , ('PASSWORD_MaxAge', 'false', 'php strtotime() check. false = n/a, else 30 days/60 days', 'SYSTEM')
            , ('PASSWORD_MaxHistory', '8', 'php password limit. used with PASSWORD_Expire_Date_Check', 'SYSTEM')
            , ('PASSWORD_Restricted_Words', 'password|123', 'js expression', 'SYSTEM')
            , ('PASSWORD_Reset_Interval', '60 MINUTE', 'reset password link expiry', 'SYSTEM')", 1);
         die("PASSWORD SYSTEM INITIATED. REFRESH TO CONTINUE");
      }else{
         $this->PASSWORD_Enable_Policy = $SystemSettings["PASSWORD_Enable_Policy"];
         $this->PASSWORD_Strength_Check = $SystemSettings["PASSWORD_Strength_Check"];
         $this->PASSWORD_Strength_Check_MinLength = $SystemSettings["PASSWORD_Strength_Check_MinLength"];
         $this->PASSWORD_Strength_Check_Description = $SystemSettings["PASSWORD_Strength_Check_Description"];
         $this->PASSWORD_MaxAge = $SystemSettings["PASSWORD_MaxAge"];
         $this->PASSWORD_MaxHistory = $SystemSettings["PASSWORD_MaxHistory"];
         $this->PASSWORD_Restricted_Words = explode("|", $SystemSettings["PASSWORD_Restricted_Words"]);
         $this->PASSWORD_Reset_Interval = $SystemSettings["PASSWORD_Reset_Interval"];
      }

   }

   public function createPassword($strPassword)
   {
      global $MYSQLI, $_LANGUAGE, $_TRANSLATION, $SystemSettings, $xdb, $BR, $SP, $TR;

      //generate salt
      $bytes = openssl_random_pseudo_bytes(32, $cstrong); //NOTE: cstrong is an optional var that is populated by the openssl_random_pseudo_bytes function. It returns a bool, true if salt is strong and false otherwise
      $this->salt = bin2hex($bytes);

      //hash = sha(salt + strPW)
      $hash = hash("sha256", $this->salt . $strPassword);
      $this->hash = $hash;

   }

   public function savePassword($Type, $UserID, $dtPassword, $blnOverrideDebug=0)
   {
      global $MYSQLI, $_LANGUAGE, $_TRANSLATION, $SystemSettings, $xdb, $BR, $SP, $TR;

      //save Type, UserID, salt, hash, dtPW to sysPassword
      $xdb->doQuery("INSERT INTO sysPassword(Type, UserID, salt, hash, dtPassword) VALUES(". $xdb->qs($Type) .", ". $xdb->qs($UserID) .", ". $xdb->qs($this->salt) .", ". $xdb->qs($this->hash) .", '$dtPassword')", $blnOverrideDebug);
   }

   public function checkPassword($Type, $UserID, $strPassword, $blnOverrideDebug=0)
   {
      global $MYSQLI, $_LANGUAGE, $_TRANSLATION, $SystemSettings, $xdb, $BR, $SP, $TR;

      //get max Type,UserID
      $row = self::getLastPassword($Type, $UserID, 0, $blnOverrideDebug);
//print_rr($this);
      //if row, compare hash == sha(salt + password)
      if($row)
      {
         $hash = hash("sha256", trim($this->salt) . trim($strPassword));

       /* print_rr("hash:: " . $hash . "<BR>");
         print_rr("row hash:: " . $row->hash . "<BR>");
         print_rr("salt:: " . $this->salt . "<BR>");
         print_rr("password:: " . $strPassword);*/

         //if($blnOverrideDebug == 1){ echo "ID: $row->ID :: $row->hash vs. $hash $BR";}
         if ($row->hash == $hash)
         {
            return true;
         }
         else
            return false;
      }
      else
         return false;
   }

   public function validatePasswordJS($strControlName="strPassword")
   {
      global $MYSQLI, $_LANGUAGE, $_TRANSLATION, $SystemSettings, $xdb, $BR, $SP, $TR;

      //regex jsPasswordStrength
      if($this->PASSWORD_Strength_Check == true)
      {
          /*
            (/^
            (?=.*\d)          //should contain at least one digit
            (?=.*[a-z])       //should contain at least one lower case
            (?=.*[A-Z])       //should contain at least one upper case
            (?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}   //should contain at least 8 from the mentioned characters - removed
            $this->PASSWORD_Strength_Check_MinLength  //minimum password length allowed
            $/)
            */

         $jsPasswordStrength = "/^(?=.{". $this->PASSWORD_Strength_Check_MinLength . ",})(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test($('#$strControlName').val()) == false";
      }

      //build up restricted words
      $OR = "";
      foreach($this->PASSWORD_Restricted_Words as $restricted_word)
      {
         //$jsRestricted .= $OR ." $('#$strControlName').val() contains js_regex(\"$restricted_word\") ";
         $jsRestricted .= $OR ." $('#$strControlName').val().toLowerCase().indexOf(\"$restricted_word\") >= 0 ";
         $OR = "||";
      }

      //MADE GENERIC: ONLY RETURN CONDITION, AS RETURNS ARE HANDLED DIFFERENTLY
      return $jsRestricted . " || " . $jsPasswordStrength;
   }

   //check to see if current pw is older than PASSWORD_MaxAge
   public function checkExpiry($Type, $UserID)
   {
      global $MYSQLI, $_LANGUAGE, $_TRANSLATION, $SystemSettings, $xdb, $BR, $SP, $TR;

      if($this->PASSWORD_MaxAge != "false")
      {
         //Calculate the difference.
         //date(format,strtotime())
         //$days = (strtotime("today") - strtotime($this->rowPassword->dtPassword));  // (60 * 60 * 24); //noooo!

         $dtExpiry = (strtotime("today") - strtotime($this->dtPassword)) / (60 * 60 * 24);

         if($dtExpiry > $this->PASSWORD_MaxAge) //test these values and clean this up
            return false;
         else
            return true;
      }else{
         return true;
      }
   }


   public function getLastPassword($Type, $UserID, $PasswordToken = 0, $blnOverrideDebug=0)
   {
      global $MYSQLI, $_LANGUAGE, $_TRANSLATION, $SystemSettings, $xdb, $BR, $SP, $TR;

      //get max ID
      $row = $xdb->getRowSQL("SELECT MAX(ID) AS ID FROM sysPassword WHERE UserID =". $xdb->qs($UserID) ."", 0);

      //get user details for last login
      //$row = $xdb->getRowSQL("SELECT ID, salt, hash, dtPassword, dtLastEdit FROM sysPassword WHERE ID = '$row->ID'", $blnOverrideDebug);

 //20161027 - added interval check for reset password link expiry - maanie
      $PasswordTokenExpiry = '';
      if ($PasswordToken == 1) {
         $PasswordTokenExpiry = " AND dtLastEdit > NOW() - INTERVAL ". $this->PASSWORD_Reset_Interval;
      }

      $row = $xdb->getRowSQL("SELECT ID, salt, hash, dtPassword, dtLastEdit
                              FROM sysPassword
                              WHERE ID = '$row->ID' $PasswordTokenExpiry", $blnOverrideDebug);  

      $this->ID = $row->ID;
      $this->hash = $row->hash;
      $this->salt = $row->salt;
      $this->dtPassword = $row->dtPassword;

      return $row;
   }

   public function getLastPasswords($Type, $UserID, $blnOverrideDebug=1)
   {
      global $MYSQLI, $_LANGUAGE, $_TRANSLATION, $SystemSettings, $xdb, $BR, $SP, $TR;

      //get max X Type,UserID records {X = $this->PASSWORD_MaxHistory}
      $limit = " LIMIT 0";
      if($this->PASSWORD_MaxHistory != "")
      {
         $limit = " LIMIT $this->PASSWORD_MaxHistory";
      }

      $rst = $xdb->doQuery("SELECT ID, salt, hash, dtPassword
         FROM sysPassword
         WHERE UserID = ". $xdb->qs($UserID) ." AND Type = ". $xdb->qs($Type) ." AND dtPassword != '2010-01-01'
         ORDER BY ID DESC
         $limit", $blnOverrideDebug);

      while($row = $xdb->fetch())
      {
         $this->arrPasswords[] = $row;
      }
      /*if($blnOverrideDebug == 1)
         print_rr($this->arrPasswords);*/
   }

   public function checkLastPasswords($strPassword)
   {
      //check previous Passwords
      //print_rr($this->arrPasswords); die;
      //vd($strPassword); echo "<BR>";
      foreach($this->arrPasswords as $Password)
      {
         $hash = hash("sha256", $Password->salt . $strPassword);
//echo "ID: $Password->ID :: $hash vs. $Password->hash<BR>";
         if($hash == $Password->hash)
         {
            return false;
         }
      }

      return true;
   }
}

?>