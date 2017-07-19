<?php
include_once("_framework/_zori.list.cls.php");
/*
ALTER TABLE `sysUser` drop FOREIGN KEY `sysUser.strSecurityGroup`;
ALTER TABLE `sysUser` ADD CONSTRAINT `sysUser.strSecurityGroup` FOREIGN KEY (`refSecurityGroupID`) REFERENCES `sysSecurityGroup` (`SecurityGroupID`) ON UPDATE CASCADE ON DELETE CASCADE;
*/
class User extends ZoriList
{
   private $ID = 0;

   public function __construct($DataKey)
   {
      $this->Filters[frSearch]->Type = "varchar";
      $this->Filters[frSearch]->VALUE = "";
      $this->Filters[frSearch]->html->placeholder = "User ID, User, Email";
      $this->Filters[frSearch]->html->title = "Search on:User ID, User, Email";

      $this->Filters[frStatus]->Type = "select";
      $this->Filters[frStatus]->VALUE = -1;
      $this->Filters[frStatus]->Control->html->class = "form-control input-sm";
      $this->Filters[frStatus]->sql = "SELECT -1 AS ControlValue, '- All -' AS ControlText
                           UNION ALL
                        SELECT 1 AS ControlValue, 'Active' AS ControlText
                           UNION ALL
                        SELECT 0 AS ControlValue, 'Inactive' AS ControlText
                        ORDER BY ControlText ASC";

      parent::__construct($DataKey);
   }

   public function getList()
   {
      if($this->Filters[frSearch]->VALUE != "")
      {
         $like = "LIKE(". $this->db->qs("%".$this->Filters[frSearch]->html->value."%") .")";
         $Where .= " AND (sysUser.UserID $like OR sysUser.strUser $like OR sysUser.strEmail $like)";
      }

      if($this->Filters[frStatus]->VALUE != -1)
      {
         $Where .= " AND sysUser.blnActive = ". $this->Filters[frStatus]->html->value;
      }

      $this->ListSQL("
         SELECT sysUser.UserID, sysUser.strUser AS User, sysSecurityGroup.strSecurityGroup AS 'Security Group'
         , sysUser.strEmail AS Email, MAX(sysLogin.strDateTime) AS 'Date Last Logged In', sysUser.blnActive AS Active
         , sysUser.strLastUser AS 'Last User', sysUser.dtLastEdit AS 'Last Edit'
         FROM sysUser INNER JOIN sysSecurityGroup ON sysUser.refSecurityGroupID = sysSecurityGroup.SecurityGroupID LEFT JOIN sysLogin ON sysUser.strEmail = sysLogin.strUsername
         WHERE 1=1 $Where
         GROUP BY sysUser.strUser
         ORDER BY sysUser.strUser",0);

      return $this->renderTable("User List");
   }

   public static function Save(&$UserID)
   {
      global $xdb, $SystemSettings;
      $db = new ZoriDatabase("sysUser", $UserID, null, 0);

      $xdb = nCopy($db);

      $db->SetValues($_POST);
      $db->Fields[strPasswordMD5] = md5($_POST[strPassword]);
      $db->Fields[strLastUser] = $_SESSION['USER']->USERNAME;

      //print_rr($db->Fields);die("dfuihu");

      if($UserID == 0){
         $db->Fields[strFirstUser] = $nemo->SystemSettings[USER]->USERNAME;
         $db->Fields[dtFirstEdit] = date("Y-m-d H:i:s");
      }

      $result = $db->Save();
      if($UserID == 0) $UserID = $db->ID[UserID];

      //print_rr($result);
      if($result->Error == 1){
         return $result->Message;
      }else{
         return "Details Saved.";
      }
   }

   public static function SaveMyProfile(&$UserID)
   {
      global $xdb, $SystemSettings;

      $db = new ZoriDatabase("sysUser", $UserID, null, 0);

      if($_POST[strPasswordMD5] == md5($_POST[strOldPassword]))
      {
         $db->Fields["strPasswordMD5"] = md5($_POST[strOldPassword]);
      }
      else
      {
         $result->Error = 1;
         $result->Message = "<b class=textRed>The old password does not match the current password in the database.</b> ";
         return $result->Message;
      }

      if($_FILES['Profile:PicturePath']['name'] != "" && $UserID != 0)
      {//current: cel_a/wa/_ need to go to cel_a/training/profilepictures/
         chmod($_FILES['Profile:PicturePath']['tmp_name'] , 0777);
         $strFileName = str_pad($UserID, 5,"0", STR_PAD_LEFT) ."_". $_FILES["Profile:PicturePath"]["name"];

         $strPath = $SystemSettings[ProfileImageDirAdmin]; //$strPath = "../../profliepictures/";
         //print_rr($strPath);

         $db->Fields["Profile:PicturePath"] = $strFileName;

         move_uploaded_file($_FILES['Profile:PicturePath']['tmp_name'], $strPath . $strFileName);

      }

      $db->Fields["strTel"] = $_POST[strTel];
      $db->Fields["strSetting:Language"] = $_POST["strSetting:Language"];
      $db->Fields["strLastUser"] = $_SESSION[USER]->USERNAME;

      $result = $db->Save(0,1);
      //print_rr($result);
      if($result->Error == 1){
         return $result->Message;
      }else{
         return "Details Saved. ";
      }
   }

   public static function Delete($chkSelect)
   {
      global $xdb;
      //print_rr($chkSelect);
      if(count($chkSelect) > 0){
          foreach($chkSelect as $key => $value)
          {
             //$xdb->doQuery("DELETE FROM sysUser WHERE UserID = ". $xdb->qs($key));
             $xdb->doQuery("UPDATE sysUser SET blnActive = 0 WHERE UserID = ". $xdb->qs($key));
          }
         return "Records Deleted. ";
      }
   }
}
?>