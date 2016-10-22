<?
include_once("includes/rest.php");

class NemoAPI extends REST {


   //error messages & recordings
   public static $INVALID_CALL = "INVALID CALL";
   public static $INVALID_VENDOR_KEY = "INVALID VENDOR KEY";
   //public static $INVALID_SESSION_TOKEN = "INVALID SESSION TOKEN";
   //public static $INVALID_MEMBER = "INVALID MEMBER DETAILS";
   //public static $INVALID_FARM_MEMBER = "FARM NOT LINKED TO THIS MEMBER";
   //public static $INVALID_VENDOR_MEMBER = "MEMBER NOT LINKED TO THIS VENDOR";
   //public static $NO_FARM_BLOCKS = "NO VINYARD BLOCKS LINKED TO THIS FARM";
   //public static $NO_MEMBER_FARMS = "NO FARMS LINKED TO THIS MEMBER";
   //public static $INVALID_FIELD = "INVALID FIELD SUPPLIED";
   public static $VALID_CALL = "Great Success!";
   public static $HTTP_ERROR_CODE = "202";
   //20160512
   public static $INVALID_STRUCTURE = "INVALID STRUCTURE";


   private $VendorKey = null;
   private $blnVendorKeyCheck = false;
   private $blnIgnoreVendorKey = false;

   private $Call = null;
   private $blnMethodExist = false;

   private $SessionToken = null;
   private $SessionData = null;
   private $blnIgnoreSessionToken = true;

   private $ReturnType = "xml";

   private $xmlData = "";


   // how long per hour must a session last
   private $SessionExpire = "1";
   private $pagination = array();

   public $args;

   private $Page = null;
   private $limit = "";

   //public function __construct($VendorKey, $Call, $Page, $SessionToken=null)
   public function __construct($VendorKey, $Call, $Page=1, $xmlData=null, $SessionToken=null)
   {
      global $xdb, $SystemSettings;

      $this->VendorKey = qs($VendorKey);
      $this->Call = qs($Call);
      $this->Page = $Page;
      $this->SessionToken = qs($SessionToken);
      $this->xmlData = $xmlData;

      $this->args = $_GET;

      if($this->args[type] == "json"){
         $this->ReturnType = "json";
      }


      $this->blnVendorKeyCheck = $this->checkVendor();

      $this->limit = "LIMIT " . ($this->Page - 1) * $SystemSettings["PageSize"] . "," . $SystemSettings["PageSize"];

      parent::__construct(); // Init parent contructor
   }

   private function checkVendor()
   {
      global $xdb, $SystemSettings;

      if($this->blnIgnoreVendorKey == true)
      {
         $this->VendorKey = "PON135";
         return true;
      }
      //check sysVendor if key exists
      $row = $xdb->getRowSQL("SELECT * FROM apiVendor WHERE VendorKey=\"$this->VendorKey\"");
      if($row)
         return true;
      else{

         //record call
         $this->record(self::$INVALID_VENDOR_KEY);

         $this->_content_type = "text/html";
         $this->response(self::$INVALID_VENDOR_KEY, self::$HTTP_ERROR_CODE);
         die;
         return false;
      }
   }

   public function record($strLog, $strLogType=null)
   {
      global $xdb, $SystemSettings;

      //insert into api log()
      if($strLogType == null){
         switch($strLog)
         {
            case self::$VALID_CALL:
               $strLogType = "info";
               break;

            default:
               $strLogType = "warning";
               break;
         }
      }

      $ldb = new NemoDatabase("apiLog", null, null, 0);

      $ldb->Fields[strVendorKey] = $this->VendorKey;
      $ldb->Fields[strLogType] = $strLogType;
      $ldb->Fields[strLog] = $strLog;
      $ldb->Fields[strRequest] = $this->Call;
      //$ldb->Fields[strSessionToken] = $this->SessionToken; //ph2 tokens
      $ldb->Fields[ip] = $_SERVER['REMOTE_ADDR'];
      $ldb->Fields[srlArgs] = serialize($this->args);

      $ldb->Save(0,0);

      return true;
   }


   /*
   * Dynmically call the method based on the query string
   1.1 - IF TOKEN, CHECK TOKEN()
   1.2 -    CLEAR TOKENS()
   3 - CALL()
   */
   public function processApi()
   {
      global $xdb, $SystemSettings;

      //ph2 tokens
      // if($this->blnIgnoreSessionToken == true)
      // {
      //    $this->SessionToken = "PON135";
      // }else{

      //      $this->clearTokenCache();

      //    switch($this->Call)
      //    {
      //       case "getMemberDetails":
      //       case "getFarmList":
      //       case "getFarmDetails":
      //       case "getVineyardBlockList":
      //       case "getVineyardBlockDetails":

      //          //check session token
      //          if(!$this->checkToken($this->SessionToken))
      //          {
      //             //record
      //             $this->record(self::$INVALID_SESSION_TOKEN);

      //             //response
      //             $this->_content_type = "text/html";
      //             $this->response(self::$INVALID_SESSION_TOKEN, self::$HTTP_ERROR_CODE);
      //             return false;
      //          }
      //          break;
      //    }
      // }

      //check method exist
      $func = trim(str_replace("/","",$this->Call));
      if(($this->blnMethodExist = method_exists($this,$func) ) === true){
         //record vendor-access to call
         $this->record(self::$VALID_CALL);

         //make the call
         $rst = $this->$func($this->args);
         switch($this->ReturnType)
         {
            case "xml":
               $this->_content_type = "application/xml";
               $this->response(NemoAPI::xml($rst));
               break;
            case "json":
               $this->_content_type = "application/json";
               $this->response(NemoAPI::json($rst));
               break;
         }
         return true;
      }else{

         //record call
         $this->record(self::$INVALID_CALL);

         //response
         $this->_content_type = "text/html";

         $this->response(self::$INVALID_CALL, self::$HTTP_ERROR_CODE); // If the method not exist with in this class "Page not found".
         return false;
      }
   }


//*********PUBLIC CAllS START*************************************************
   private function getListPages() 
   {
      global $xdb, $SystemSettings;

      //loop through each call and get the number of pages



   }

   private function getCultivarList($args)
   {
      global $xdb, $SystemSettings;

      $rst = $xdb->doQuery("SELECT * FROM tblCultivar WHERE 1=1 ORDER BY CultivarID $this->limit", 0);

      return $rst;
   }


   private function getWineTypeList()
   {
      global $xdb, $SystemSettings;

      $rst = $xdb->doQuery("SELECT WineTypeID,WineTypeCode,strCategoryCode,EN_strCategory,AF_strCategory,strSubCategoryCode,EN_strSubCategory,AF_strSubCategory,strAlcoholContentCode,
                     EN_strAlcoholContent,AF_strAlcoholContent,strDescriptionCode,EN_strDescription,AF_strDescription,TypeCode,EN_strType,AF_strType,strSubTypeCode,
                     EN_strSubType,AF_strSubType,strSubDescriptionCode,EN_strSubDescription,AF_strSubDescription,txtNotes,blnCertification,blnActive,strLastUser,dtLastEdit
                     FROM tblWineType WHERE 1=1 ORDER BY WineTypeID $this->limit", 0);

      return $rst;
   }

   private function getIrrigationList(){
      global $xdb, $SystemSettings;

      $rst = $xdb->doQuery("SELECT * FROM tblIrrigation WHERE 1=1 ORDER BY IrrigationID $this->limit");

      return $rst;

   }

   private function getTrellisList(){
      global $xdb, $SystemSettings;

      $rst = $xdb->doQuery("SELECT * FROM tblTrellis WHERE 1=1 ORDER BY TrellisID $this->limit");

      return $rst;

   }

   private function getLocationList(){
      global $xdb, $SystemSettings;

      $rst = $xdb->doQuery("SELECT LocationID,WOCode,GeoCode,strGeo,EN_strGeo,AF_strGeo,RegionCode,strRegion,EN_strRegion,AF_strRegion,DistrictCode,strDistrict,
                     EN_strDistrict,AF_strDistrict,WardCode,strWard,EN_strWard,AF_strWard,strCertifyBlendAs,EN_strCertifyBlendAs,AF_strCertifyBlendAs,
                     intStartVintage,intEndVintage,txtNotes,blnLockLocationID,blnActive,strLastUser,dtLastEdit
                     FROM dwdLocation WHERE 1=1 ORDER BY LocationID $this->limit");
      return $rst;

   }

   private function getMemberTypeList(){
      global $xdb, $SystemSettings;
      $rst = $xdb->doQuery("SELECT * FROM tblMemberType WHERE 1=1 ORDER BY MemberTypeID $this->limit");

      return $rst;

   }

   private function getMemberList(){
      global $xdb, $SystemSettings;
      $rst = $xdb->doQuery("SELECT * FROM tblMember WHERE 1=1 ORDER BY MemberID $this->limit");

      return $rst;

   }

   private function getMemberAddressList(){
      global $xdb, $SystemSettings;
      $rst = $xdb->doQuery("SELECT * FROM tblMember_Address WHERE 1=1 ORDER BY MemberID $this->limit");

      return $rst;

   }

   private function getMemberContactList(){
      global $xdb, $SystemSettings;
      $rst = $xdb->doQuery("SELECT * FROM tblMember_Contact WHERE 1=1 ORDER BY MemberID $this->limit");

      return $rst;

   }

   private function getVineyardBlockList(){
      global $xdb, $SystemSettings;

         $sql = "SELECT * FROM tblBlock
                  WHERE tblBlock.refFarmID=".qs($this->args['FarmID'])."
                  ORDER BY strBlock $this->limit";
         $rst = $xdb->doQuery($sql);

         return $rst;

   }


   private function getFarmList(){
      global $xdb, $SystemSettings;

      // $rst = $xdb->doQuery("SELECT mr.refMemberID,mr.refMemberTypeID,f.FarmID,f.strFarm,f.strRegisteredBusinessName,f.strRegistrationNumber,f.strVATRegistrationNumber,f.refLocationID,f.strContact,f.strTitle,f.strName,f.strSurname,
      //                f.strTel,f.strCell,f.strFax,f.strEmail,f.strWebsiteURL,f.strNearestTown,f.txtPhysicalAddress,f.txtPostalAddress,f.dblArea,f.arrActNumbers,f.arrActDescription,f.blnEstate,
      //                f.strVineStatus,f.strStatus,f.txtRegistrationNotes,f.txtNotes, f.RegistrationStatus, f.RegistrationType, f.RegistrationArgs, f.dtRegistered, f.strLastUser, f.dtLastEdit
      //                 FROM tblFarm as f
      //                LEFT JOIN tblMemberRelationship as mr ON (f.FarmID = mr.refEntityID)
      //                WHERE mr.strType = 'Farm to Member'
      //                 AND mr.refMemberTypeID IN (19,15,18)
      //                 GROUP BY FarmID
      //                 ORDER BY FarmID");

      ## 14 JUNE 2016 ## REWROTE THE GET FARM LIST QUERY ## JACQUES
      $rst = $xdb->doQuery("  SELECT tblFarm.*, tblMemberRelationship.refMemberID, tblMemberRelationship.refMemberTypeID
                              FROM tblFarm
                              LEFT JOIN tblMemberRelationship  ON tblFarm.FarmID = tblMemberRelationship.refEntityID
                              LEFT JOIN tblMemberType  ON tblMemberRelationship.refMemberTypeID = tblMemberType.MemberTypeID
                              WHERE tblMemberRelationship.strType = 'Farm to Member' AND tblMemberType.strMemberTypeCode IN ('FRM000','FRMEST','FRMOWN')
                              GROUP BY tblFarm.FarmID
                              ORDER BY tblFarm.FarmID 
                              $this->limit");

      return $rst;
   }

   private function setVinProMembers(){
      global $xdb, $SystemSettings;

      //check data
      $xml = simplexml_load_string($this->xmlData);// or die("Error: Cannot create object");
      if($this->xmlData == null || $xml == null){
         $this->record(self::$INVALID_STRUCTURE);
         $this->response(self::$INVALID_STRUCTURE, self::$HTTP_ERROR_CODE);
         return false;
      }
print_rr($xml);


      $arrColumns = array("MemberID","blnVinPro");
      //check data structure: read data.rows.row.foreach()
      $arrDataColumns = (array) $xml->rows->row[0];
      print_rr($xml->rows->row[0]);
      print_rr($arrDataColumns);

      foreach($arrColumns as $i => $key)
      {//vd($key); vd(array_key_exists($key, $arrDataColumns));
         $keys .= "$key;";
         if(!array_key_exists($key, $arrDataColumns)){
            $this->record(self::$INVALID_STRUCTURE ."[$keys]");
            $this->response(self::$INVALID_STRUCTURE ."[$keys]", self::$HTTP_ERROR_CODE);
            return false;
         }
      }

      //import records into tmp table
      $xdb->doQuery("TRUNCATE TABEL tmpVinPro");
      foreach ($xml->rows->row as $i => $row)
      {//print_rr($row);
         $xdb->doQuery("INSERT INTO tmpVinPro(MemberID,blnVinPro) VALUE (". $xdb->qs($row->MemberID) .",". $xdb->qs($row->blnVinPro) .")");
      }

      //update tblMember.blnVinPro = tmpVinPro.blnVinPro
      $xdb->doQuery("UPDATE tblMember INNER JOIN tmpVinPro ON tmpVinPro.MemberID = tblMember.MemberID SET tblMember.blnVinPro = tmpVinPro.blnVinPro");

      return true;


   }


//*********MEMBER CAllS START*************************************************

   //wip
   // private function authenticate($args)
   // {
   //    global $xdb, $SystemSettings;

   //    //print_rr($args);die;
   //    //still need to check vendor key;

   //    $this->SessionData->MemberID = qs($args[MemberID]);
   //    $sql = "SELECT * FROM vieMember INNER JOIN apiVendorMember ON vieMember.MemberID = apiVendorMember.MemberID
   //          WHERE vieMember.MemberID =\"". $this->SessionData->MemberID ."\" AND  apiVendorMember.VendorKey = \"". qs($this->VendorKey) ."\"";
 //      $objMember = $xdb->getRowSQL($sql);

   //    $this->_content_type = "text/html";
   //    if($objMember){
   //       //


   //       //create token
   //       $this->SessionToken =  $this->generateToken();
   //       $this->response($this->SessionToken, 200);
   //    }else{
   //       $this->response($this::$INVALID_MEMBER, self::$HTTP_ERROR_CODE);
   //    }

   //    //save token
   // }




//*********Extras************************


//*********TOKENS***********************************************************
   private function generateToken()
   {
      global $xdb, $SystemSettings;

      $this->SessionData->MemberID = $this->$MemberID;
      $this->SessionData->VendorKey = $this->VendorKey;

      $sql = "SELECT UUID() as Token";
      $Token = $xdb->getRowSQL($sql)->Token;

      $xdb->doQuery("
         INSERT INTO apiToken
            SET strToken = \"$Token\"
            , data = '".serialize($this->SessionData)."'
            , VendorKey = \"$this->VendorKey\"",0);
      return $Token;
   }


   private function checkToken()
   {
      global $xdb, $SystemSettings;

      $Token = $xdb->getRowSQL("SELECT * FROM apiToken WHERE strToken =\"$this->SessionToken\"");
      if($Token){

         $this->SessionData = unserialize($Token->data);
         return true;
      }else{
         return false;
      }
   }

   private function clearTokenCache(){
      global $xdb, $SystemSettings;

      $xdb->doQuery("DELETE FROM apiToken WHERE dtToken < Now()-INTERVAL $this->SessionExpire HOUR;");
   }

//*********ENCODING***************************************************************

   public static function json($rst)
   {
      global $xdb, $SystemSettings;

      $result[data] = array();
      $result[data][rows] = array();
      //echo count($result[data][rows]);
      //return json_encode($result);
      while($row = $xdb->fetch_object($rst))
      {
         if(isset($row->refInspectorID)) unset($row->refInspectorID);

         $result[data][rows][] = $row;

      }
      //echo count($result[data][rows]);
      return json_encode($result);

   }

   /*
   * Encode array into XML
   */
   public static function xml($rst)
   {
      global $xdb, $SystemSettings;

      while($row = $xdb->fetch_object($rst))
      {
         $xml .= "<row>";
         foreach($row as $key => $value)
         {
            //if(strpos($key,":") >>= 0)
               $key = str_replace(":", "_", $key);

            if($key == "refInspectorID") continue;

            $value = htmlentities($value, ENT_QUOTES,'UTF-8');

            $xml .= "<$key>$value</$key>"; //xml rncode $key & $value
         }
         $xml .= "</row>";

      }

      return "<data><rows>$xml</rows></data>";
   }
}
?>