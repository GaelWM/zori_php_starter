<?php
include_once("_framework/_zori.details2.cls.php");

//20161115 -- GAEL [Code Reviewed]

/*
ALTER TABLE `tblGLAccountName` drop FOREIGN KEY `tblGLAccountName.strCompany`;
ALTER TABLE `tblGLAccountName` ADD CONSTRAINT `tblGLAccountName.strCompany` FOREIGN KEY (`refCompanyID`) REFERENCES `tblCompany` (`CompanyID`) ON UPDATE CASCADE ON DELETE CASCADE 
*/

//Additional / page specific translations
$_TRANSLATION["EN"]["strTitle"] = "Title";
$_TRANSLATION["AF"]["strTitle"] = "Titel";
$_TRANSLATION["EN"]["txtFAQ"] = "FAQ";
$_TRANSLATION["AF"]["txtFAQ"] = "AF: FAQ";

class FAQ extends ZoriDetails
{
   private $ID = 0;

   public function __construct($DataKey)
   {
      if(!$this->Filters){
         $this->Filters[frSearch]->label = "lblSearch"; //20150310 - translating filter labels [note: can code lblSearch or just use the translations for frSearch as a default]
         $this->Filters[frSearch]->tag = "input";
         $this->Filters[frSearch]->html->value = "";
         $this->Filters[frSearch]->html->class = "controlText";

         $this->Filters[frTopic]->label = "lblTopic";
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

   public function getList()
   {
      global $xdb;

      if($this->Filters[frSearch]->html->value != "")
      {
         $like = "LIKE(". $this->db->qs("%".$this->Filters[frSearch]->html->value."%") .")";
         $Where .= " AND (Tags $like OR FAQ $like)";
      } 

      $this->ListSQL("
         SELECT FAQID, EN_lstTopic AS Topic, EN_strTitle AS Title, AF_strTitle AS Titel, strTags AS Tags, intOrder AS 'Order'
         , blnActive AS Active, strLastUser AS 'Last User', dtLastEdit AS 'Last Edit'
         FROM sysFAQ
         WHERE 1=1 $Where
         ORDER BY EN_lstTopic, intOrder",0);


      return $this->renderTable("FAQ List");
      //die;
   }

   public static function Save(&$FAQID)
   {
      //ini
      global $xdb, $arrSys, $TR, $SP, $HR, $PHP_SELF, $DATABASE_SETTINGS, $SystemSettings;

      $db = new NemoDatabase("sysFAQ", $FAQID, null, 0);
      $db->SetValues($_POST);
      $db->Fields[strLastUser] = $_SESSION['USER']->USERNAME;
      $result = $db->Save();
      
      if($FAQID == 0) 
         $FAQID = $db->ID[FAQID];
   
      if($result->Error == 1){
         return $result->Message;
      }else{
         return "Details Saved.";
      }
   }

   public static function Delete($chkSelect)
   {
      //ini
      global $xdb;

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