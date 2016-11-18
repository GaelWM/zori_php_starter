<?php
include_once("_framework/_zori.list.cls.php");

class UsageLog extends ZoriList
{
   private $ID = 0;

   public function __construct($DataKey)
   {
      $this->Filters[frSearch]->tag = "input";
      $this->Filters[frSearch]->html->value = "";
      $this->Filters[frSearch]->html->class = "form-control input-sm";

      parent::__construct($DataKey);
   }

   public function getList()
   {
      if($this->Filters[frSearch]->html->value != "")
      {
         $like = "LIKE(". $this->db->qs("%".$this->Filters[frSearch]->html->value."%") .")";
         $Where .= " AND (sysLogin.LoginID $like OR sysLogin.strUsername $like )";
      }

      $this->ListSQL("
         SELECT strIP AS 'IP Address', strResult AS 'Result', strUsername AS 'Username'
         , strPassword AS 'Password', strDateTime AS 'Login Date And Time'
         FROM sysLogin 
         WHERE 1=1 $Where
         ORDER BY sysLogin.strDateTime DESC",0);

      return $this->renderTable("Usage Login List");
   }

   
   public static function Delete($chkSelect)
   {
      global $xdb;

      if(count($chkSelect) > 0){
      foreach($chkSelect as $key => $value)
      {
         $xdb->doQuery("DELETE FROM sysLogin WHERE LoginID = ". $xdb->qs($key));
      }
         return "Records Deleted. ";
      }
   }
}
?>