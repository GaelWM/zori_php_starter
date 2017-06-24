<?php
   ini_set('display_errors', '1');
   error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);

//DEV REPO
   $DATABASE_SETTINGS["localhost"]->hostname = "localhost";
   $DATABASE_SETTINGS["localhost"]->port = "5432";
   $DATABASE_SETTINGS["localhost"]->username = "root";
   $DATABASE_SETTINGS["localhost"]->password = "";
   $DATABASE_SETTINGS["localhost"]->database = "zori_db.sql";
   $DATABASE_SETTINGS["localhost"]->sessionpath = $_SERVER['DOCUMENT_ROOT']."/zori_php_starter/webadmin/SESSION/";

//DEV QA
   $DATABASE_SETTINGS["localhost"]->hostname = "localhost";
   $DATABASE_SETTINGS["localhost"]->username = "root";
   $DATABASE_SETTINGS["localhost"]->password = "";
   $DATABASE_SETTINGS["localhost"]->database = "zori_db.sql";
   $DATABASE_SETTINGS["localhost"]->sessionpath = $_SERVER['DOCUMENT_ROOT']."/zori_php_starter/webadmin/SESSION/";


//LIVE PROD
   // $DATABASE_SETTINGS["www.live.co.za?/"]->hostname = "???";
   // $DATABASE_SETTINGS["www.live.co.za?/"]->username = "???";
   // $DATABASE_SETTINGS["www.live.co.za?/"]->password = "???";
   // $DATABASE_SETTINGS["www.live.co.za?/"]->database = "???";
   // $DATABASE_SETTINGS["www.live.co.za?/"]->sessionpath = $_SERVER['DOCUMENT_ROOT']."/zori_php_starter/webadmin/SESSION/";

   if($_SERVER[SERVER_NAME] == "localhost") $_SERVER[SERVER_NAME] = "localhost";


   $SystemSettings[SERVER_NAME] = $_SERVER[SERVER_NAME];
   $strTemp = explode("/", $_SERVER[SERVER_PROTOCOL]);
   $SystemSettings[SERVER_PROTOCOL] = strtolower($strTemp[0]);
   $strTemp = array_reverse(explode("/", $_SERVER[SCRIPT_NAME]));
   $SystemSettings[SCRIPT_NAME] = $strTemp[0];
   $SystemSettings[REQUEST_URI] = $_SERVER[REQUEST_URI];

   $SystemSettings[FULL_URL] = $SystemSettings[SERVER_PROTOCOL] ."://". $SystemSettings[SERVER_NAME] . $_SERVER[REQUEST_URI];
   $SystemSettings[FULL_PATH] = $SystemSettings[SERVER_PROTOCOL] ."://". $SystemSettings[SERVER_NAME] . $_SERVER[SCRIPT_NAME];
   $SystemSettings[BASE_URL] = $SystemSettings[SERVER_PROTOCOL] ."://". $SystemSettings[SERVER_NAME] . str_replace($SystemSettings[SCRIPT_NAME], "", $_SERVER[SCRIPT_NAME]);
   $SystemSettings[argv] = $_SERVER[argv];

   $SystemSettings[BASE_URL] = $_SERVER[REQUEST_URI];
   $SystemSettings[FULL_URL] = $_SERVER[REQUEST_URI];
   $SystemSettings[FULL_PATH] = $_SERVER[REQUEST_URI];

   ini_set("session.gc_maxlifetime","7200");
   ini_set("session.save_path", $DATABASE_SETTINGS[$SystemSettings[SERVER_NAME]]->sessionpath);
   session_cache_limiter('private');
   session_cache_expire(1);    
   session_start();

   include_once "_framework/system.functions.php";

   global $xdb, $HTTP, $POSTGRESQL, $db, $DATABASE_SETTINGS,$SystemSettings;
   $HTTP = $SystemSettings[SERVER_PROTOCOL]; //might not work, set manually // = "http://";

   //20141126 - new mysqli class - http://php.net/manual/en/mysqlinfo.api.choosing.php 

   //print_rr($DATABASE_SETTINGS[$SystemSettings[SERVER_NAME]]);
   $db =
   $xdb =
   $POSTGRESQL = pg_connect(
         "host=".$DATABASE_SETTINGS[$SystemSettings[SERVER_NAME]]->hostname.
         " port=".$DATABASE_SETTINGS[$SystemSettings[SERVER_NAME]]->port.
         " dbname=".$DATABASE_SETTINGS[$SystemSettings[SERVER_NAME]]->database.
         " user=".$DATABASE_SETTINGS[$SystemSettings[SERVER_NAME]]->username.
         " password=".$DATABASE_SETTINGS[$SystemSettings[SERVER_NAME]]->password);

   if(!$POSTGRESQL)
   {
      $SystemMessage->Message = "Database Connection has Failed! [". mysqli_connect_error() ."]";
      $SystemMessage->Type = "Critical Error";
      //print_rr($DATABASE_SETTINGS);
      //print_rr($SystemSettings);
      print_rr($SystemMessage);

   }else{
      $xdb = new ZoriDatabase("sysSettings");
      //$row = $xdb->getRowSQL("SELECT * FROM sysSettings WHERE strSetting = 'Rows per Page'");
      //$arrSys["Rows per Page"] = $row->strValue;
      $xdb->getList();
      while($row = $xdb->fetch())
      {
         $strSetting = $row->strSetting;
         $SystemSettings[$strSetting] = $row->strValue;
      }
   }
   //print_rr($_SERVER['DOCUMENT_ROOT']);
   // include_once "_framework/_nemo.translations.inc.php";
   // include_once("_framework/_nemo.menu.cls.php");
   // include_once("_framework/_nemo.menu.translator.cls.php");
   //include_once "project.functions.inc.php";

?>