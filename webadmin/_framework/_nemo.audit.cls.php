<?php
//20170305 - new - pj
//20170313 - update - Gael

class NemoAudit Extends NemoDatabase
{
   public $FieldList = array();
   public $ini_unique_key = array();
   public $iniFields = array();
   public $newFields = array();
   public $CriticalFields = array(); //STRUCT: $CriticalFields[$key/column name]->Message, ->eval
   public $EntityType;
   public $EntityID;
   public $intRevision;
   public $strEntity;

   public function __construct($EntityType, $iniDB, $Debug=0)
   {
      global $MYSQLI, $xdb, $BR;

      parent::__construct("sysAuditLog", null, null, $Debug);

      $this->EntityType = $EntityType;
      $this->FieldList = $iniDB->FieldList;
      $this->ini_unique_key = $iniDB->unique_key;
      $this->iniFields = $iniDB->Fields;
   }

   public function Audit($EntityID, $newDB, $strEntity="", $Debug=0)
   {
      global $MYSQLI, $xdb, $BR;

      //set Entity ID
      $this->EntityID = $EntityID;
      //set newFields
      $this->newFields = $newDB->Fields;

      //strEntity: if strEntity=="", foreach ini_unique_key key: strEntity .= newField[key]. e.g. if UK on Contact Record is Client + ContactEmail: strEnity = $refClientID."-".$strEmail
      if($strEntity == "")
      {
         $dash = "";
         foreach ($this->ini_unique_key as $key ) {
            $strEntity .= $dash.$this->newFields[$key];
            $dash = "-";
         }
      }

      //set strEntity
      $this->strEntity = $strEntity;

      //get intRevision = sql: SELECT COUNT(ID) FROM sysAudit WHERE EType = this->EType & EID = $this->EID
      $row = $xdb->getRowSQL("SELECT COUNT(AuditLogID) AS 'intRevision', strLogType FROM sysAuditLog WHERE strEntityType = '$this->EntityType' AND EntityID = '$this->EntityID'");
      $this->intRevision = $row->intRevision;

      foreach ($this->FieldList as $idx => $Fields ) {
         $key = $Fields->name;

         if(strpos($key,"enc") !== 0){
            if($this->iniFields[$key] != $this->newFields[$key]){
               $db = new NemoDatabase("sysAuditLog", null, null, 0);
               $db->Fields[strField] = $key;
               $db->Fields[strLogType] = ($this->intRevision == 0 ) ? "New" : "Edit";
               $db->Fields[strEntityType] = $this->EntityType;
               $db->Fields[intRevision] = $this->intRevision;
               $db->Fields[strEntity] = $this->strEntity;
               $db->Fields[txtValueOld] = $this->iniFields[$key];
               $db->Fields[txtValueNew] = $this->newFields[$key];
               $db->Fields[strLastUser] = $_SESSION[USER]->USERNAME;
               $result = $db->Save(0,0);

               //if save & field is in the CriticalFields collection: exe eval; write into CommunicationsLog
               if(isset($this->CriticalFields[$key]))
               {
                  if($this->CriticalFields[$key]->eval != "")
                     eval($this->CriticalFields[$key]->eval);

                  //write to comms log
                  $db = new NemoDatabase("sysCommsLog", null, null, 0);

                  $db->Fields[strLogType] = "Audit Log";
                  $db->Fields[strEntityType] = ($this->intRevision == 0 ) ? "New" : "Edit";
                  $db->Fields[strEntity] = $this->strEntity;
                  $db->Fields[txtLog] = $this->CriticalFields[$key]->txtMessage;
                  $db->Fields[strLastUser] = $_SESSION[USER]->USERNAME;

                  $result = $db->Save(0,0);
               }
            }
         }
      }//eoFE

      //foreach FieldList key: if iniFields[key] != newFields[key]
         //set $this->ID = null (always insert)
         //build this->Fields
         //$this->save(,,,$Debug)
   }

   //load EntityType important fields from the db
   public function getCriticalFields()
   {
      global $MYSQLI, $xdb, $BR;
      $i=0;

      $rst = $xdb->doQuery("SELECT * FROM sysAuditCriticalFields WHERE strEntityType='$this->EntityType'");
      while ($row = $db->fetch_object($rst))
      {
         $this->CriticalFields[$row->strField] = $row;
      }
   }

   //writes record into sysCommLog
   public static function writeCommsLog()
   {
      global $MYSQLI, $xdb, $BR;

      $db = new NemoDatabase("sysCommsLog", null, null, 0);
      $db->Fields[strLogType] = "Audit Log";
      $db->Fields[EntityID] = $this->EntityID;
      $db->Fields[strEntityType] = $this->EntityType;
      $db->Fields[strEntity] = $this->strEntity;
      $db->Fields[txtLog] = "Status Changed to In Production";
      $db->Fields[strLastUser] = $_SESSION[USER]->USERNAME;
      $result = $db->Save(0,0);
   }

   //delete from auditlog where dtAudit > 12months
   public static function cleanUpLog()
   {
      global $MYSQLI, $xdb, $BR;
      $xdb->doQuery("DELETE FROM sysAuditLog WHERE dtLog > date_sub(now(), interval 12 month)");
   }
}

?>
