<?php
include_once("_framework/_zori.details2.cls.php");
include_once("_framework/_zori.list.cls.php");

/*
ALTER TABLE `tblGLAccountName` drop FOREIGN KEY `tblGLAccountName.strCompany`;
ALTER TABLE `tblGLAccountName` ADD CONSTRAINT `tblGLAccountName.strCompany` FOREIGN KEY (`refCompanyID`) REFERENCES `tblCompany` (`CompanyID`) ON UPDATE CASCADE ON DELETE CASCADE 
*/

//Additional / page specific translations
$_TRANSLATION["EN"]["strTitle"] = "Title";
$_TRANSLATION["AF"]["strTitle"] = "Titel";
$_TRANSLATION["EN"]["txtFAQ"] = "FAQ";
$_TRANSLATION["AF"]["txtFAQ"] = "AF: FAQ";

//print_rr($_SESSION);die;


class FAQ extends ZoriList
{
   private $ID = 0;

   public function __construct($DataKey)
   {
      $Language = "EN"; 
      if(!$this->Filters){
         $this->Filters[frSearch]->label = "lblSearch"; //20150310 - translating filter labels [note: can code lblSearch or just use the translations for frSearch as a default]
         $this->Filters[frSearch]->tag = "input";
         $this->Filters[frSearch]->html->value = "";
         $this->Filters[frSearch]->html->class = "controlText";

         $this->Filters[frTopic]->tag = "select";
         $this->Filters[frTopic]->html->value = "";
         $this->Filters[frTopic]->html->class = "comboBox";
         $this->Filters[frTopic]->sql = "SELECT 0 AS ControlValue, '- All -' AS ControlText
                        UNION ALL 
                           SELECT lstTopic AS 'ControlValue', lstTopic AS 'ControlText'
                           FROM vieFAQ_$Language
                           WHERE blnActive = 1
                           GROUP BY lstTopic
                        ORDER BY ControlText";
      }
      
      parent::__construct($DataKey);

   } 

   // public function __construct(){

   //    parent::__construct($DataKey);
   // }

   public function getList()
   {
      global $xdb;

      if($this->Filters[frSearch]->html->value != "")
      {
         $like = "LIKE(". $this->db->qs("%".$this->Filters[frSearch]->html->value."%") .")";
         $Where .= " AND (Tags $like OR FAQ $like)";
      } 
//sysFAQ.FAQID, sysFAQ.strTitle AS 'Title' , sysFAQ.strTags AS 'Tags', sysFAQ.strLastUser AS 'Last User', sysFAQ.dtLastEdit AS 'Last Edit'
      $this->ListSQL("
         SELECT FAQID, EN_lstTopic AS Topic, EN_strTitle AS Title, AF_strTitle AS Titel, strTags AS Tags, intOrder AS 'Order', blnActive AS Active, strLastUser AS 'Last User', dtLastEdit AS 'Last Edit'
         FROM sysFAQ
         WHERE 1=1 $Where
         ORDER BY EN_lstTopic, intOrder",0);


      return $this->renderTable("FAQ List");

      die;
   }

   public static function Save(&$FAQID, $nemo)
   {
      global $xdb, $arrSys, $TR, $SP, $HR, $PHP_SELF, $DATABASE_SETTINGS, $SystemSettings;
      $db = new ZoriDatabase("sysFAQ", $FAQID, null, 0);

      $db->SetValues($_POST);
    
      $db->Fields[strLastUser] = $_SESSION['USER']->USERNAME;

      $result = $db->Save();
      
      if($FAQID == 0) 
      {
         $FAQID = $db->ID[FAQID];
      }
      //print_rr($result);
      if($result->Error == 1){
         return $result->Message;
      }else{
         return "Details Saved.";
      }
   }

   public static function Delete($chkSelect)
   {
      global $xdb;
      //print_rr($chkSelect);
      if(count($chkSelect) > 0){
      foreach($chkSelect as $key => $value)
      {
         $xdb->doQuery("DELETE FROM sysFAQ WHERE FAQID = ". $xdb->qs($key));
         //$xdb->doQuery("UPDATE tblGLAccountName SET blnActive = 0 WHERE GLAccountNameID = ". $xdb->qs($key));
      }
         return "Records Deleted.";
      }
   }
   
}
?>