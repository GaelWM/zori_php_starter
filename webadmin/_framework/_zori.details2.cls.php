<?php
include_once("_framework/_zori.cls.php");
include_once("_framework/_zori.database2.cls.php");
include_once("_framework/_zori.control2.cls.php");

/* notes:
  setting up foreign key contraints:
   ADD CONSTRAINT `tblBooking.strDriver` FOREIGN KEY (`refDriverID`) REFERENCES `tblDriver` (`DriverID`) ON DELETE CASCADE ON UPDATE CASCADE,
   ADD CONSTRAINT `tblBooking.strClient` FOREIGN KEY (`refClientID`) REFERENCES `tblClient` (`ClientID`) ON DELETE CASCADE ON UPDATE CASCADE;

* 20150112 - v2 added tab controller - 
//20170118 - removed fields from js + new modal popup
//20170118 - added required attribute non-nullable fields
//20170125 - added sqlGrouping @ render() + select controls
//20170130 - changed format of caption
//20170202 - added encrypted field
//20170227 - added tab heading variable which includes spaces

*/
class ZoriDetails extends Zori
{
   //public $SystemSettings = array();
   public $ContentLeft;
   public $ContentRight;
   public $ContentBootstrap = array();

   public $Fields = array();
   //public $Layout = "layout.back.details.incl.php";
   private $dbInfo;

   private $jsValidate = "";
   private $jsComponent = ""; // holds custom javascript functions of the styled html components -- Gael 20170112

   public $Tabs = array(); //20170116 - built-in tab controller
   public $arrTabs = array(); //20170116 - built-in tab controller

   public function __construct($arrTabs = null)
   {
      parent::__construct();

      if($arrTabs != null)
      {//20170116 - built-in tab controller - pj/jac

         foreach($arrTabs AS $key)
         {
            $this->Tabs[$key] = "";
         }
      }


      $this->ToolBar->Buttons[btnSave]->blnShow = $this->Security->blnSave;
      $this->ToolBar->Buttons[btnClose]->blnShow = 1;
      $this->ToolBar->Buttons[btnReload]->blnShow = 1;
      $this->ToolBar->Label = $this->ToolBar->Label ." Details";

//print_rr($_REQUEST);
      if($_REQUEST[RETURN_URL] != "")
      {//20140717 - added RETURN_URL - maanie
         $this->Fields[RETURN_URL]->ID =
         $this->Fields[RETURN_URL]->Name = "RETURN_URL";
         $this->Fields[RETURN_URL]->Type = "hidden";
         $this->Fields[RETURN_URL]->VALUE =
         $this->Fields[RETURN_URL]->Control->value = $_REQUEST[RETURN_URL];
         $this->Fields[RETURN_URL]->Tab = "FOOTER"; ## JACQUES ADDED 17 JAN 2017 ## DEFAULT TAB SECTION (SO BY DEFAULT NOW TABS -  ALL WILL BE IN FOOTER BY DEFAULT)

         $this->Fields[RETURN_VAR]->ID =
         $this->Fields[RETURN_VAR]->Name = "RETURN_VAR";
         $this->Fields[RETURN_VAR]->Type = "hidden";
         $this->Fields[RETURN_VAR]->VALUE =
         $this->Fields[RETURN_VAR]->Control->value = $_REQUEST[RETURN_VAR];
         $this->Fields[RETURN_VAR]->Tab = "FOOTER"; ## JACQUES ADDED 17 JAN 2017 ## DEFAULT TAB SECTION (SO BY DEFAULT NOW TABS -  ALL WILL BE IN FOOTER BY DEFAULT)

         $this->Fields[$_REQUEST[RETURN_VAR]]->ID =
         $this->Fields[$_REQUEST[RETURN_VAR]]->Name = $_REQUEST[RETURN_VAR];
         $this->Fields[$_REQUEST[RETURN_VAR]]->Type = "hidden";
         $this->Fields[$_REQUEST[RETURN_VAR]]->VALUE =
         $this->Fields[$_REQUEST[RETURN_VAR]]->Control->value = $_REQUEST[$_REQUEST[RETURN_VAR]]; //20160224 - pj
         $this->Fields[$_REQUEST[RETURN_VAR]]->Tab = "FOOTER"; ## JACQUES ADDED 17 JAN 2017 ## DEFAULT TAB SECTION (SO BY DEFAULT NOW TABS -  ALL WILL BE IN FOOTER BY DEFAULT)
      }

   }

   private function __autoload()
   {// only applies to zend

   }

   public function AssimulateTable($table, $ID, $altEntityHeadingField="")
   {
      global $db, $DATABASE_SETTINGS, $idxTest; //from system.php
$idxTest = "xxxrefUserID"; //vd($idxTest);
      //ini
      $currentDB = $DATABASE_SETTINGS[$this->SystemSettings[SERVER_NAME]]->database;
      $xdb = new ZoriDatabase($table, $ID, null, 0);

      if($ID != 0)
         $this->ToolBar->Label .=": <span class='textColour'>$ID</span>";
      else
         $this->ToolBar->Label .=": <span class='textColour'>New Record</span>";
      //print_rr($xdb->Fields);


      mysqli_select_db($db, "information_schema");

      $this->dbInfo = new ZoriDatabase("");

      $rst = $this->dbInfo->doQuery("SELECT COLUMNS.COLUMN_NAME, COLUMNS.ORDINAL_POSITION, COLUMNS.COLUMN_DEFAULT, COLUMNS.IS_NULLABLE, COLUMNS.DATA_TYPE, COLUMNS.COLUMN_TYPE, COLUMNS.CHARACTER_MAXIMUM_LENGTH, COLUMNS.EXTRA, COLUMNS.COLUMN_COMMENT, COLUMNS.COLUMN_KEY, KEY_COLUMN_USAGE.CONSTRAINT_NAME, KEY_COLUMN_USAGE.REFERENCED_TABLE_NAME, KEY_COLUMN_USAGE.REFERENCED_COLUMN_NAME
         FROM KEY_COLUMN_USAGE RIGHT JOIN COLUMNS ON (KEY_COLUMN_USAGE.TABLE_NAME = COLUMNS.TABLE_NAME) AND (KEY_COLUMN_USAGE.TABLE_SCHEMA = COLUMNS.TABLE_SCHEMA) AND (KEY_COLUMN_USAGE.COLUMN_NAME = COLUMNS.COLUMN_NAME)
         WHERE (((COLUMNS.TABLE_SCHEMA)='$currentDB') AND ((COLUMNS.TABLE_NAME)='$table'))
         ORDER BY COLUMNS.ORDINAL_POSITION ASC

         ", 0);
      while($row = $this->dbInfo->fetch())
      {
if($row->COLUMN_NAME == $idxTest){ print_rr($row); }
         //INI
         $blnContinue = 0;
         $arrValues = null;
         $this->Fields[$row->COLUMN_NAME]->DB = $row;
         if($xdb->Fields[$row->COLUMN_NAME] != "")
            $this->Fields[$row->COLUMN_NAME]->VALUE = $xdb->Fields[$row->COLUMN_NAME];
         else
            $this->Fields[$row->COLUMN_NAME]->VALUE = $row->COLUMN_DEFAULT;
         //default html control def
         $this->Fields[$row->COLUMN_NAME]->ID =
         $this->Fields[$row->COLUMN_NAME]->Name = $row->COLUMN_NAME;
         $this->Fields[$row->COLUMN_NAME]->Label = self::cleanColumnName($row->COLUMN_NAME);
         $this->Fields[$row->COLUMN_NAME]->Comment = $row->COLUMN_COMMENT;

         $this->Fields[$row->COLUMN_NAME]->Type = $row->DATA_TYPE;
         $this->Fields[$row->COLUMN_NAME]->Tab = "FOOTER"; ## JACQUES ADDED 17 JAN 2017 ## DEFAULT TAB SECTION (SO BY DEFAULT NOW TABS -  ALL WILL BE IN FOOTER BY DEFAULT)

         $this->Fields[$row->COLUMN_NAME]->isRequired = ($row->IS_NULLABLE == "NO" ? 1 : 0);
         $this->Fields[$row->COLUMN_NAME]->Order = $row->ORDINAL_POSITION;
//print_rr($this->Fields); die;

         //PK
         if($row->COLUMN_KEY == "PRI")
         {
//$this->Fields[$row->COLUMN_NAME]->Type = "varchar";
            $this->Fields[$row->COLUMN_NAME]->Type = "hidden"; //override Type

            //$this->Fields[$row->COLUMN_NAME]->Control->tag = "input";
            //$this->Fields[$row->COLUMN_NAME]->Control->type = "text"; //"hidden"
            $this->Fields[$row->COLUMN_NAME]->Control->html->readonly = "readonly";
            //$this->Fields[$row->COLUMN_NAME]->Control->class = "form-control";
            //$this->Fields[$row->COLUMN_NAME]->Control->value = "PRIMARY ID";
            continue;// next record
         }

         //FK
         if($row->COLUMN_KEY == "MUL" && $row->REFERENCED_TABLE_NAME != "")
         {//print_rr($row); die;
            if($row->IS_NULLABLE == "NO"){
               $text = "-  Select  -";
            }
            else{
               $text = "-  None  -";
            }

            $controlText = str_replace($table .".", $row->REFERENCED_TABLE_NAME .".", $row->CONSTRAINT_NAME);
            $sqlDDL = "SELECT 0 AS ControlValue, '$text' AS ControlText
                        UNION ALL
                        SELECT `$row->REFERENCED_COLUMN_NAME` AS ControlValue, $controlText AS ControlText
                        FROM `$row->REFERENCED_TABLE_NAME`
                        WHERE blnActive = 1 OR `$row->REFERENCED_COLUMN_NAME` = '". $xdb->Fields[$row->COLUMN_NAME] ."'
                        ORDER BY ControlText ASC";
            $this->Fields[$row->COLUMN_NAME]->Type = "select";
            $this->Fields[$row->COLUMN_NAME]->sql = $sqlDDL;
            //$this->Fields[$row->COLUMN_NAME]->sqlGrouping = "LEFT($controlText,1)";

            $this->Fields[$row->COLUMN_NAME]->jsValidate = "
                  $('#$row->COLUMN_NAME').change(function(){
                     $('div.item_$row->COLUMN_NAME').removeClass('bad_select');
                  });

                  if( (trim($('#$row->COLUMN_NAME').val()) == '' ) || (trim($('#$row->COLUMN_NAME').val()) == 0) )
                  {
                     state = false;
                     $('div.item_$row->COLUMN_NAME').addClass('bad_select');
                     $('#messageDiv').hide()
                     $('#messageID').show();
                     $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                     $('#messageID').find('strong').text('Please fill in the required fields./ In all the tabs if exist');
                  }
               ";
            $row->DATA_TYPE = "select";

            //continue;// next record
         }

         //named columns 1
         switch($row->COLUMN_NAME)
         {
            case "dtLastEdit":
            case "dtFirstEdit":
               if($xdb->Fields[$row->COLUMN_NAME] == "") $this->Fields[$row->COLUMN_NAME]->Control->value = date("Y-m-d h:i:s");
               break;
            case "strLastUser":
            case "strFirstUser":
               if($xdb->Fields[$row->COLUMN_NAME] == "") $this->Fields[$row->COLUMN_NAME]->Control->value = $this->SystemSettings[USER]->USERNAME;
               break;
         }
         //named columns 2
         switch($row->COLUMN_NAME)
         {
            case "dtFirstEdit":
            case "dtLastEdit":
            case "strFirstUser":
            case "strLastUser":

               $this->Fields[$row->COLUMN_NAME]->Type = "label";
               //$this->Fields[$row->COLUMN_NAME]->Control->html->readonly = "readonly";
               //$this->Fields[$row->COLUMN_NAME]->Control->value = "ajlfbasf";
               //do not add to jsValidate
               $this->Fields[$row->COLUMN_NAME]->isRequired = 0;
               $blnContinue = 1;

         }//note: using continue inside a switch does not effect the outer loop/while

         if($blnContinue) continue;

         if(strpos($row->COLUMN_NAME,"lst") === 0) // || (strpos($row->COLUMN_NAME,'_lst') !== false
         {//20150317 - added datalist control type- pj/jj
            //print_rr($row); //die("knsdbn");
            $this->Fields[$row->COLUMN_NAME]->Type = "datalist";
            $this->Fields[$row->COLUMN_NAME]->sql = "
               SELECT $row->COLUMN_NAME AS ControlValue, $row->COLUMN_NAME AS ControlText
               FROM $table
               WHERE $row->COLUMN_NAME IS NOT NULL OR $row->COLUMN_NAME != ''
               GROUP BY ControlText
               ORDER BY ControlText";

            $this->Fields[$row->COLUMN_NAME]->sqlGrouping = "LEFT(ControlText,1)";

            $htmlOption = null;

            $htmlOption->value = "";

            if($row->IS_NULLABLE == "NO"){
               $placeholder = "Select";
               $htmlOption->innerHTML = "-  Select  -";

               $this->Fields[$row->COLUMN_NAME]->jsValidate = "
                  $('#$row->COLUMN_NAME').change(function(){
                     $('div.item_$row->COLUMN_NAME').removeClass('bad_select');
                  });

                  if( (trim($('#$row->COLUMN_NAME').val()) == '' ) || (trim($('#$row->COLUMN_NAME').val()) == 0) )
                  {
                     state = false;
                     $('div.item_$row->COLUMN_NAME').addClass('bad_select');
                     $('#messageDiv').hide()
                     $('#messageID').show();
                     $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                     $('#messageID').find('strong').text('Please fill in the required fields./ In all the tabs if exist');
                  }
               ";
            }else{
               $placeholder = "None";
               $htmlOption->innerHTML = "-  None  -";
            }


            //print_rr($this->Fields[$row->COLUMN_NAME]->sql);
            mysqli_select_db($db, $currentDB);
            $listDB = new ZoriDatabase($table, $ID, null, 0);
            $rstList = $listDB->doQuery($this->Fields[$row->COLUMN_NAME]->sql, 0);
            while( $row = $xdb->fetch_array($rstList)){
               $arrValues[] = $row;
            }//print_rr($arrValues); die("klmnsdfj");


            foreach($arrValues as $text){
               $htmlOption = null;// Skips the first value of the object htmlOption -- Gael

               $htmlOption->value =
               $htmlOption->innerHTML = $text;
               $arrOptions[""][] = $htmlOption;

               $htmlOption = null; // reset the object htmlOption. allows the last option to have a text value
            }
            // print_rr($arrOptions); die("klmnsdfj");
            $this->Fields[$row->COLUMN_NAME]->Control->Options = $arrOptions;
            $this->Fields[$row->COLUMN_NAME]->Control->html->placeholder = $placeholder;
            $arrOptions = null; // reset array options -- Gael

            // note: No "- Select/None -" option.s
            //$this->Fields[$row->COLUMN_NAME]->Control->autoconplete = "off";
            //print_rr($this->Fields[$row->COLUMN_NAME]);
            //continue;
         }

//          if(strpos($row->COLUMN_NAME,"tag") === 0) // || (strpos($row->COLUMN_NAME,'_lst') !== false
//          {//tag Comment added on 19/01/2017
//             //print_rr($row);
//             $this->Fields[$row->COLUMN_NAME]->Control->tag = "input";
//             $this->Fields[$row->COLUMN_NAME]->Control->type = "tag"; //"hidden"
//             $this->Fields[$row->COLUMN_NAME]->Control->class = "tags form-control";
//             //print_rr($this->Fields[$row->COLUMN_NAME]);
//             continue;
//          }

         if(strpos($row->COLUMN_NAME,"enc") === 0)
         {//20170202 - added encrypted field - pj

            if($row->CHARACTER_MAXIMUM_LENGTH > 116){
               $row->DATA_TYPE = "text";
               $this->Fields[$row->COLUMN_NAME]->Type = "text";
            }

            mysqli_select_db($db, $currentDB);

            $this->Fields[$row->COLUMN_NAME]->VALUE = $xdb->decrypt($row->COLUMN_NAME);
            mysqli_select_db($db, "information_schema");

            //print_rr($this->Fields[$row->COLUMN_NAME]);
            //continue; // must go to "text"
         }

         if(strpos($row->COLUMN_NAME,"sl") === 0)
         {//20170522 - added time range field - Gael.
            $this->Fields[$row->COLUMN_NAME]->Type = "slider";
         }

         //all other
         switch($row->DATA_TYPE)
         {
            case "varbinary":
            case "varchar":
               //textboxswitch($row->COLUMN_NAME)
               //$this->Fields[$row->COLUMN_NAME]->Control->tag = "input";
               // $this->Fields[$row->COLUMN_NAME]->Type = "text";
               // $this->Fields[$row->COLUMN_NAME]->Control->class = "form-control";
               $this->Fields[$row->COLUMN_NAME]->Control->html->maxlength = $row->CHARACTER_MAXIMUM_LENGTH;
               if(strpos($row->COLUMN_NAME,"enc") === 0)
               {//20170202 - added encrypted field - pj
                  $this->Fields[$row->COLUMN_NAME]->Control->html->maxlength = $row->CHARACTER_MAXIMUM_LENGTH-16;
               }

               $this->Fields[$row->COLUMN_NAME]->jsValidate = "
                  $('#$row->COLUMN_NAME').change(function(){
                     $('div.item_$row->COLUMN_NAME').removeClass('bad');
                  });

                  if( trim($('#$row->COLUMN_NAME').val()) == '' )
                  {
                     state = false;
                     $('div.item_$row->COLUMN_NAME').addClass('bad');
                     $('#$row->COLUMN_NAME').val('');
                     $('#messageDiv').hide()
                     $('#messageID').show();
                     $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                     $('#messageID').find('strong').text('Please fill in the required fields./ In all the tabs if exist');
                  }
               ";
               //print_rr($this->Fields[$row->COLUMN_NAME]);
               break;


            case "text":
               //textarea

               //$this->Fields[$row->COLUMN_NAME]->Control->tag = "textarea";
               //$this->Fields[$row->COLUMN_NAME]->Control->style = "display";
               //$this->Fields[$row->COLUMN_NAME]->Control->class = "";//controlText controlWideMax
               //$this->Fields[$row->COLUMN_NAME]->Control->innerHTML = $this->Fields[$row->COLUMN_NAME]->Control->value;
               $this->Fields[$row->COLUMN_NAME]->Control->html->maxlength = $row->CHARACTER_MAXIMUM_LENGTH;
               if(strpos($row->COLUMN_NAME,"enc") === 0)
               {//20170202 - added encrypted field - pj
                  $this->Fields[$row->COLUMN_NAME]->Control->html->maxlength = $row->CHARACTER_MAXIMUM_LENGTH-16;
               }

               $this->Fields[$row->COLUMN_NAME]->jsValidate = "
                  $('#$row->COLUMN_NAME').change(function(){
                     $('#$row->COLUMN_NAME').removeClass('bad');
                  });

                  $('div.item_$row->COLUMN_NAME').change(function(){
                     $('div.item_$row->COLUMN_NAME').removeClass('bad_select');
                  });

                  if(trim($('#$row->COLUMN_NAME').val()) == '')
                  {
                     state = false;
                     $('div.item_$row->COLUMN_NAME').addClass('bad_select');
                     $('#$row->COLUMN_NAME').val('');
                     $('#messageDiv').hide()
                     $('#messageID').show();
                     $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                     $('#messageID').find('strong').text('Please fill in the required fields/In all the tabs if exist');
                  }
                  ";
               // $this->Fields[$row->COLUMN_NAME]->jsComponent =
               // "
               //    function getText(){
               //       var editorValue = document.getElementById('editor').innerHTML;
               //       $('#".$this->Fields[$row->COLUMN_NAME]->Control->id."').val(editorValue);
               //       //alert($('#".$this->Fields[$row->COLUMN_NAME]->Control->id."').val());
               //    }
               // ";
               break;

            case "double":
            case "int":
               // $this->Fields[$row->COLUMN_NAME]->Control->tag = "input";
               // $this->Fields[$row->COLUMN_NAME]->Control->type = "text";
               // $this->Fields[$row->COLUMN_NAME]->Control->class = "form-control";
               //$this->Fields[$row->COLUMN_NAME]->Control->html->onblur = "removeAlpha(this);";
               $this->Fields[$row->COLUMN_NAME]->jsValidate = "
                  $('#$row->COLUMN_NAME').change(function(){
                     $('div.item_$row->COLUMN_NAME').removeClass('bad');
                  });

                  if($.isNumeric( trim($('#$row->COLUMN_NAME').val()) ) == false )
                  {
                     state = false;
                     $('div.item_$row->COLUMN_NAME').addClass('bad');
                     $('#$row->COLUMN_NAME').val('');
                     $('#messageDiv').hide()
                     $('#messageID').show();
                     $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                     $('#messageID').find('strong').text('Please fill in the required fields./ In all the tabs if exist');
                  }
                  ";

               break;

            case "tinyint": //print_rr($row); vd($xdb->Fields[$row->COLUMN_NAME]);
               //chk
               // $this->Fields[$row->COLUMN_NAME]->Control->tag = "input";
               // $this->Fields[$row->COLUMN_NAME]->Control->type = "checkbox";
               // $this->Fields[$row->COLUMN_NAME]->Control->class = "js-switch";

               //var_dump($xdb->Fields[$row->COLUMN_NAME]);
               // if($xdb->Fields[$row->COLUMN_NAME] == 1)
               // {
               //    $this->Fields[$row->COLUMN_NAME]->Control->html->checked = "checked";
               // }
               // else

               if($xdb->Fields[$row->COLUMN_NAME] === "0")
               {//$xdb->Fields[] > string(1) "0" if no record is loaded, but blnX = 0
                  unset($this->Fields[$row->COLUMN_NAME]->Control->html->checked);
               }
               elseif($this->Fields[$row->COLUMN_NAME]->VALUE)
               {//$xdb->Fields[] > int(0) if no record is loaded
                  $this->Fields[$row->COLUMN_NAME]->Control->html->checked = "checked";
               }
               //print_rr($this->Fields[$row->COLUMN_NAME]->Control->html); die;
               $this->Fields[$row->COLUMN_NAME]->jsValidate = "
                  $('#$row->COLUMN_NAME').change(function(){
                     $('div.item_$row->COLUMN_NAME').removeClass('bad_select');
                  });

                  if( $('#$row->COLUMN_NAME').val() == ''){
                     state = false;
                     $('div.item_$row->COLUMN_NAME').addClass('bad_select');
                     $('#messageDiv').hide()
                     $('#messageID').show();
                     $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                     $('#messageID').find('strong').text('Please fill in the required fields./ In all the tabs if exist');
                  }
                  ";
               break;


            case "select":
            case "enum":
               //ddl values = $row->COLUMN_TYPE, eg. COLUMN_TYPE: enum('Test Value1','Test Value 2')
               //vd($row->DATA_TYPE);
               if($row->DATA_TYPE == "enum"){
                  eval("\$arrValues = ". str_replace("enum", "array", $row->COLUMN_TYPE).";");
               }else{

               }
               //print_rr($arrValues);

               $htmlOption = null;
               if($row->IS_NULLABLE == "NO"){
                  $placeholder = "Select";
                  $htmlOption->value = 0;
                  $htmlOption->innerHTML = "-  Select  -";

                  $this->Fields[$row->COLUMN_NAME]->jsValidate = "

                     $('#$row->COLUMN_NAME').change(function(){
                        $('div.item_$row->COLUMN_NAME').removeClass('bad_select');
                     });

                     if( (trim($('#$row->COLUMN_NAME').val()) == '' ) || (trim($('#$row->COLUMN_NAME').val()) == 0) )
                     {
                        state = false;
                        $('div.item_$row->COLUMN_NAME').addClass('bad_select');
                        $('#messageDiv').hide()
                        $('#messageID').show();
                        $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                        $('#messageID').find('strong').text('Please fill in the required fields./ In all the tabs if exist');
                     }
                     ";
               }
               else{
                  $placeholder = "None";
                  $htmlOption->value = 0;
                  //$htmlOption->innerHTML = "-  None  -";
               }

               $arrOptions[""][0] = $htmlOption;
               //print_rr($arrOptions);

               foreach($arrValues as $text){
                  $htmlOption = null;// Skips the first value of the object htmlOption -- Gael

                  $htmlOption->value =
                  $htmlOption->innerHTML = $text;
                  $arrOptions[""][] = $htmlOption;

                  $htmlOption = null; // reset the object htmlOption. allows the last option to have a text value
               }

               $this->Fields[$row->COLUMN_NAME]->Control->Options = $arrOptions;
               $this->Fields[$row->COLUMN_NAME]->Control->html->placeholder = $placeholder;
               $arrOptions = null; // reset array options -- Gael
               break;

            case "datetime":
               if($row->IS_NULLABLE == "NO"){
                  if($this->Fields[$row->COLUMN_NAME]->VALUE == "" || $this->Fields[$row->COLUMN_NAME]->VALUE == "0000-00-00 00:00:00")
                     $this->Fields[$row->COLUMN_NAME]->VALUE = date("Y-m-d HH:mm:ss");
               }elseif($this->Fields[$row->COLUMN_NAME]->VALUE == "0000-00-00 00:00:00")
                  $this->Fields[$row->COLUMN_NAME]->VALUE = "";

               $this->Fields[$row->COLUMN_NAME]->jsValidate = "
                  $('#$row->COLUMN_NAME').change(function(){
                     $('div.item_$row->COLUMN_NAME').removeClass('bad');
                  });

                  if( (trim($('#$row->COLUMN_NAME').val()) == '') || (trim($('#$row->COLUMN_NAME').val()) == '0000-00-00 00:00:00') )
                  {
                     state = false;
                     $('div.item_$row->COLUMN_NAME').addClass('bad');
                     $('#messageID').show();
                     $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                     $('#messageID').find('strong').text('Please fill in the required fields./ In all the tabs if exist');
                  }
                  ";
               break;
            case "date":
               //date box
               // $this->Fields[$row->COLUMN_NAME]->Control->tag = "input";
               // $this->Fields[$row->COLUMN_NAME]->Control->type = "date";
               // $this->Fields[$row->COLUMN_NAME]->Control->class = "form-control";
               // $this->Fields[$row->COLUMN_NAME]->Control->required = "required";

               //$nDate = ZoriProtoControl::__new("date", $ID="$row->COLUMN_NAME", $Value="", $attr="", $blnRequired=1);
               if($row->IS_NULLABLE == "NO"){
                  if($this->Fields[$row->COLUMN_NAME]->VALUE == "" || $this->Fields[$row->COLUMN_NAME]->VALUE == "0000-00-00")
                     $this->Fields[$row->COLUMN_NAME]->VALUE = date("Y-m-d");
               }elseif($this->Fields[$row->COLUMN_NAME]->VALUE == "0000-00-00")
                  $this->Fields[$row->COLUMN_NAME]->VALUE = "";

               $this->Fields[$row->COLUMN_NAME]->jsValidate = "
                  $('#$row->COLUMN_NAME').change(function(){
                     $('div.item_$row->COLUMN_NAME').removeClass('bad');
                  });

                  if( (trim($('#$row->COLUMN_NAME').val()) == '') || (trim($('#$row->COLUMN_NAME').val()) == '0000-00-00') )
                  {
                     state = false;
                     $('div.item_$row->COLUMN_NAME').addClass('bad');
                     $('#messageID').show();
                     $('#messageID').addClass('alert alert-danger alert-dismissible fade in');
                     $('#messageID').find('strong').text('Please fill in the required fields./ In all the tabs if exist');
                  }
                  ";

               break;


            case "timestamp":
               //label
               $this->Fields[$row->COLUMN_NAME]->Type = "label"; //"hidden"
               $this->Fields[$row->COLUMN_NAME]->isRequired = false;
               break;
          }//eoSwitch

      }
      //post
      //print_rr($this->Fields);
      //die;

      mysqli_select_db($db, $currentDB);
      $this->renderControls();
         //vd($ID);
      if($ID == null){
//TODO: change so doesn't render New x2
$this->ToolBar->Label .=": <span class='textColour'>New Record</span>";
      }else{
         if($altEntityHeadingField == ""){
            $altEntityHeadingField = $ID;
         }
         else{
            $altEntityHeadingField = $this->Fields[$altEntityHeadingField]->VALUE;
         }
         $this->ToolBar->Label .=": <span class='textColour'>$altEntityHeadingField</span>";
      }
   }

   public function renderControls()
   {
      global $idxTest;

      foreach($this->Fields as $idxCol => $column)
      {//print_rr($column);
//vd($column->DB->COLUMN_NAME);
if($column->DB->COLUMN_NAME == $idxTest){ print_rr($this->Fields[$idxCol]); }
         //vd($column->Type);
         switch($column->Type)
         {
            case "enum":
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $column->isRequired, $isSelected=null, $column->Control->Options);
               $this->Fields[$idxCol]->Control->Comment = $this->Fields[$idxCol]->Comment;
               $this->Fields[$idxCol]->Control->CommentTitle = $this->Fields[$idxCol]->CommentTitle;
               $this->Fields[$idxCol]->Control->render();

               //print_rr($this->Fields[$idxCol]->Control);
               break;

            case "file":
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $blnRequired=1);
               $this->Fields[$idxCol]->Control->ajaxFunction = $this->Fields[$idxCol]->ajaxFunction;
               $this->Fields[$idxCol]->Control->ajaxParams = $this->Fields[$idxCol]->ajaxParams;
               $this->Fields[$idxCol]->Control->strPath = $this->Fields[$idxCol]->strPath;
               $this->Fields[$idxCol]->Control->uploadType = $this->Fields[$idxCol]->uploadType;
               $this->Fields[$idxCol]->Control->render();
               break;

            case "submit":
                $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $blnRequired=1);
                //print_rr($this->Fields[$idxCol]->Control);
               break;

            case "slider":
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $blnRequired=1);
               $this->Fields[$idxCol]->Control->VarType = $this->Fields[$idxCol]->VarType;
               $this->Fields[$idxCol]->Control->minValue = $this->Fields[$idxCol]->minValue;
               $this->Fields[$idxCol]->Control->maxValue = $this->Fields[$idxCol]->maxValue;
               $this->Fields[$idxCol]->Control->minRange = $this->Fields[$idxCol]->minRange;
               $this->Fields[$idxCol]->Control->maxRange = $this->Fields[$idxCol]->maxRange;
               $this->Fields[$idxCol]->Control->stepValue = $this->Fields[$idxCol]->stepValue;
               $this->Fields[$idxCol]->Control->grid = $this->Fields[$idxCol]->grid;
               $this->Fields[$idxCol]->Control->from_fixed = $this->Fields[$idxCol]->from_fixed;
               $this->Fields[$idxCol]->Control->max_interval = $this->Fields[$idxCol]->max_interval;
               $this->Fields[$idxCol]->Control->grid_snap = $this->Fields[$idxCol]->grid_snap;
               $this->Fields[$idxCol]->Control->hide_min_max = $this->Fields[$idxCol]->hide_min_max;
               $this->Fields[$idxCol]->Control->force_edges = $this->Fields[$idxCol]->force_edges;
               $this->Fields[$idxCol]->Control->keyboard = $this->Fields[$idxCol]->keyboard;
               $this->Fields[$idxCol]->Control->prettify = $this->Fields[$idxCol]->prettify;
               $this->Fields[$idxCol]->Control->predefinedValuesArr = $this->Fields[$idxCol]->predefinedValuesArr;
               $this->Fields[$idxCol]->Control->keyboard_step = $this->Fields[$idxCol]->keyboard_step;
               $this->Fields[$idxCol]->Control->render();
               break;

            case "select":
            case "ddl":
               //$column->Control->innerHTML = $this->db->ListOptions($column->sql, $column->Control->value, $column->sqlGrouping); //20170125 - added sqlGrouping @ render() + select controls - pj
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $column->isRequired, $isSelected=null, $column->Control->Options, $column->sql, $column->sqlGrouping);
               $this->Fields[$idxCol]->Control->Comment = $this->Fields[$idxCol]->Comment;
               $this->Fields[$idxCol]->Control->CommentTitle = $this->Fields[$idxCol]->CommentTitle;
               $this->Fields[$idxCol]->Control->render();
               break;

            case "datalist":
            case "lst":
            case "selectMultiple":
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $column->isRequired, $isSelected=null, $column->Control->Options, $column->sql, $column->sqlGrouping);
               $this->Fields[$idxCol]->Control->Comment = $this->Fields[$idxCol]->Comment;
               $this->Fields[$idxCol]->Control->CommentTitle = $this->Fields[$idxCol]->CommentTitle;
               $this->Fields[$idxCol]->Control->reRender();
               break;

            case "custom":
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $column->isRequired);
               $this->Fields[$idxCol]->Control->Comment = $this->Fields[$idxCol]->Comment;
               $this->Fields[$idxCol]->Control->CommentTitle = $this->Fields[$idxCol]->CommentTitle;
               $this->Fields[$idxCol]->Control->render($this->Fields[$idxCol]->HTML);
               break;

            case "time":
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $column->isRequired);
               $this->Fields[$idxCol]->Control->Comment = $this->Fields[$idxCol]->Comment;
               $this->Fields[$idxCol]->Control->CommentTitle = $this->Fields[$idxCol]->CommentTitle;
               $this->Fields[$idxCol]->Control->render();
               break;

            case "link":
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $column->isRequired);
               $this->Fields[$idxCol]->Control->Comment = $this->Fields[$idxCol]->Comment;
               $this->Fields[$idxCol]->Control->CommentTitle = $this->Fields[$idxCol]->CommentTitle;
               $this->Fields[$idxCol]->Control->render();
               break;

            default:
               $this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control->html, $column->isRequired);
               $this->Fields[$idxCol]->Control->Comment = $this->Fields[$idxCol]->Comment;
               $this->Fields[$idxCol]->Control->CommentTitle = $this->Fields[$idxCol]->CommentTitle;
               $this->Fields[$idxCol]->Control->render();
               break;
         }

         // switch ($this->Fields[$idxCol]->Control->type) {
         //    case "tag":
         //       $this->Fields[$idxCol]->HTML = ZoriControl::renderTagControl($column->Control);
         //       break;

         //    default:
         //       $this->Fields[$idxCol]->HTML = ZoriControl::renderControl($column->Control->tag, $column->Control);
         //       break;
         // }
         //$this->Fields[$idxCol]->HTML = ZoriControl::renderTagControl($column->Control);


         //$this->Fields[$idxCol]->Control = ZoriProtoControl::__new($column->Type, $column->ID, $column->VALUE, $column->Control, $column->Control->IS_NULLABLE);
         //$this->Fields[$idxCol]->HTML = $control->HTML;

if($column->DB->COLUMN_NAME == $idxTest){print_rr($this->Fields[$idxCol]); }//die("kjbsdghvhgh");

//die();
      }//eoFor
   }

   public function renderDetails($mode="Form")
   {
      global $BR, $TR;

      $currentTab = "";
      $arrDetail = array();

      foreach($this->Fields as $idxCol => $column)
      {
         $arrPosition[$idxCol] = $column->Order;
      }
      array_multisort($arrPosition);

      foreach($arrPosition as $idxCol => $intOrd)
      {
         //ini
         $column = $this->Fields[$idxCol];
         //print_rr($column);
         if($mode == "Form")
         {
            $idxTab = 0;
         }else{
            $idxTab = $column->Tab;
         }


//TODO: style "heading"
         if($mode == "Form" && $currentTab != $column->Tab && $currentTab != "")
         {//print heading
            $arrDetail[$idxTab] .= "<tr><td colspan='100%'>$column->Tab</td></tr>";
         }



         //go
         $this->jsComponent .= $column->jsComponent;
//print_rr($column);
         if($column->isRequired == 1)
         {
            //20170118 - added required attribute non-nullable fields - maanie
            //$column->Control->required = "required";

            $required = $this->SystemSettings[imgRequired];
            $this->jsValidate .= $column->jsValidate;//vd($idxCol);
         }else{
            $required = "";
         }
//print_rr($column);
         //$control = ZoriControl::renderControl($column->Control->tag, $column->Control);
         //$column->Control->render();

         if($column->Type == "hidden")
         {
            $arrDetail[$idxTab] .= $column->Control->HTML;
         }else{
            $arrDetail[$idxTab] .= "
            <div class='form-group' id='group_$column->ID'>
               <label for = '$column->ID' class='control-label col-md-3 col-sm-3 col-xs-12'>$column->Label:$required</label>
               <div class='col-md-9 col-sm-9 col-xs-12'> ". $column->Control->HTML ." </div>
            </div>";
         }

         //post
         $currentTab = $column->Tab;

      }

      return $arrDetail;
   }

   public function renderTabs($strCaption="", $tableHTML=null, $ControlsOnly=0)
   {
      global $BR;
      //gen arrTabs
      $arrTabs = $this->renderDetails("Tab");

      //print_rr($arrTabs);

      //print_rr($strCaption);
      //set tab.content
      $tabs = "";
      $tabContent = "";
      $expanded = "true";
      $expandedClass = "active";
      $expandedContentClass = "active in";

      foreach ($this->Tabs as $idx => $tab)
      {
         $this->Tabs[$idx] .= $arrTabs[$idx];
      }
      //print_rr($this->Tabs[Info]);
      foreach ($this->Tabs as $idx => $tab)
      {  //print_rr($tab);

         //20170227 - added tab heading variable which includes spaces - maanie
         $tabHeading =  $idx;

         $idx = str_replace(' ', '', $idx);

         $tabs .= "<li role='presentation' class='$expandedClass'><a href='#tab_content_$idx' id='$idx-tab' role='tab' data-toggle='tab' aria-expanded='$expanded'> $tabHeading $SP<span id='errorTab_$idx' class='label label-danger' style='display:none;'>x</span></a></li>";
         $tabContent .= " <div role='tabpanel' class='tab-pane fade $expandedContentClass' id='tab_content_$idx' aria-labelledby='$idx-tab'> ". $tab ."</div>";

         $expanded = "false";
         $expandedClass = "";
         $expandedContentClass = "";
      }

      //print_rr($tabContent);

      ## IF NO TABS LISTED THEN DONT SHOW TAB BAR
      $tabBar = "";
      $footerStyle = "";
      if($this->Tabs != null)
      {
         $tabBar = "<ul id='myTab' class='nav nav-tabs bar_tabs' role='tablist'> $tabs </ul>";
         $footerStyle = "border-top: solid #ccc 1px; padding-top:20px";
      }

      $htmlAttr = ZoriControl::renderAttributes($tableHTML);
      if($strCaption != "")
      {
         //20170130 - changed format of caption - maanie
         if( strpos( $strCaption, "New" ) !== false )
         {
             $strCaption = "<caption>New Record</caption>";
         }
         else
         {
            $strCaption = explode(":", $strCaption);
            $strCaption = "<caption>" . $strCaption[2] . " (#".$strCaption[1].")</caption>";
         }
         //$strCaption = "<caption>$strCaption</caption>";
      }

      if($ControlsOnly == 1)
      {
         return "<div class='form-horizontal form-label-left'><div id='FooterContent' style='$footerStyle'>".$arrTabs["FOOTER"]."</div></div>";
      }
      return "
      <div class='x_title'>
         <h2>$strCaption<small> </small></h2>
         <ul class='nav navbar-right panel_toolbox'>
            <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a> </li>
            <!-- COMMENTED OUT. NOT NEEDED. -->
            <!--<li class='dropdown'>
               <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><i class='fa fa-wrench'></i></a>
               <ul class='dropdown-menu' role='menu'>
                  <li><a href='#'>Settings 1</a> </li>
                  <li><a href='#'>Settings 2</a> </li>
               </ul>
            </li>
            <li><a class='close-link'><i class='fa fa-close'></i></a> </li>-->
         </ul>
         <div class='clearfix'></div>
      </div>
      <div class='x_content'>

         <div class='form-horizontal form-label-left'>

            <div class='' role='tabpanel' data-example-id='togglable-tabs'>
               $tabBar
               <div id='myTabContent' class='tab-content'> $tabContent </div>
               <div id='FooterContent' style='$footerStyle'>".$arrTabs["FOOTER"]."</div>
            </div>

         </div>
      </div>
      ";
   }

   public function renderForm($strCaption="", $tableHTML=null)
   {
      global $BR;

      $arrTabs = $this->renderDetails("Tab");

      //set tab.content
      $AccordianItem = "";
      $expanded = "true";
      $collapseClassHeading = "";
      $collapseClassContent = "collapse in";

      foreach ($this->Tabs as $idx => $tab)
      {
         $this->Tabs[$idx] .= $arrTabs[$idx];
      }
      foreach ($this->Tabs as $idx => $tab)
      {
         if($tab != "")
         {

            $AccordianItem .= "  <div class='panel'>
                                    <a class='panel-heading $collapseClassHeading' role='tab' id='heading_$idx' data-toggle='collapse' data-parent='#accordion' href='#collapse_$idx' aria-expanded='$expanded' aria-controls='collapseOne'>
                                       <h4 class='panel-title'>$idx</h4>
                                    </a>
                                    <div id='collapse_$idx' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_$idx'>
                                       <div class='panel-body'> ". $tab ." </div>
                                    </div>
                                 </div>";

            $expanded = "false";
            $collapseClassHeading = "collapsed";
            $collapseClassContent = "collapse";
         }

      }




      $htmlAttr = ZoriControl::renderAttributes($tableHTML);
      if($strCaption != "")
      {
         //20170130 - changed format of caption - maanie
         if( strpos( $strCaption, "New" ) !== false )
         {
             $strCaption = "<caption>New Record</caption>";
         }
         else
         {
            $strCaption = explode(":", $strCaption);
            $strCaption = "<caption>" . $strCaption[2] . " (#".$strCaption[1].")</caption>";
         }
         //$strCaption = "<caption>$strCaption</caption>";
      }

      return "
      <div class='x_title'>
         <h2>$strCaption<small> </small></h2>
         <ul class='nav navbar-right panel_toolbox'>
            <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a> </li>
            <!-- COMMENTED OUT. NOT NEEDED. -->
            <!--<li class='dropdown'>
               <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><i class='fa fa-wrench'></i></a>
               <ul class='dropdown-menu' role='menu'>
                  <li><a href='#'>Settings 1</a> </li>
                  <li><a href='#'>Settings 2</a> </li>
               </ul>
            </li>
            <li><a class='close-link'><i class='fa fa-close'></i></a> </li>-->
         </ul>
         <div class='clearfix'></div>
      </div>
      <div class='x_content'>

         <div class='form-horizontal form-label-left' novalidate>

            <div class='accordion' id='accordion' role='tablist' aria-multiselectable='true'>

               $AccordianItem

            </div>
            <div id='FooterContent'>".$arrTabs["FOOTER"]."</div>

         </div>
      </div>
      ";
   }

   public function renderTable($strCaption="", $tableHTML=null, $ControlsOnly=0)
   {
      global $BR;
      $strDetail = $this->renderDetails("Form")[0];

      $htmlAttr = ZoriControl::renderAttributes($tableHTML);
      if($strCaption != "")
         $strCaption = "<caption>$strCaption</caption>";

      if($ControlsOnly == 1)
      {
         return "<div class='form-horizontal form-label-left'><div id='FooterContent' style='$footerStyle'>".$strDetail."</div></div>";
      }

      return "
      <div class='x_title'>
         <h2>$strCaption<small> </small></h2>
         <ul class='nav navbar-right panel_toolbox'>
            <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a> </li>
            <!-- COMMENTED OUT. NOT NEEDED. -->
            <!--<li class='dropdown'>
               <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><i class='fa fa-wrench'></i></a>
               <ul class='dropdown-menu' role='menu'>
                  <li><a href='#'>Settings 1</a> </li>
                  <li><a href='#'>Settings 2</a> </li>
               </ul>
            </li>
            <li><a class='close-link'><i class='fa fa-close'></i></a> </li>-->
         </ul>
         <div class='clearfix'></div>
      </div>
      <div class='x_content'>
         <br />
         <form class='form-horizontal form-label-left'>
         $strDetail
         </form>
      </div>
      ";
   }

   /*public function getJsZoriValidateSave($jsExtra="", $jsFuctionName="jsZoriValidateSave")
   {//vd($this->jsValidate);

      return "<script>
            function $jsFuctionName()
            {
               var msg = '';
               $this->jsValidate

               $jsExtra

               if(msg == '')
               {
                  return true;
               }else
               {
                  alert('Please complete all the required fields: \\n'+ msg);
                  return false;
               }
            }
            </script>";
   }*/

   //NB: You may create another saving function if you want the form to save on reload, close actions but by default the form validation only works when saving -- Gael.
   public function getJsZoriValidateSave($jsExtra="", $jsFuctionName="jsZoriValidateSave")
   {//vd($this->jsValidate);

      return "
      <script>
         function $jsFuctionName()
         {
            var state = true;

               $this->jsValidate
               $jsExtra

            setTimeout(function() {
               $('#messageID').fadeOut().empty();
            }, 5000);

            if(state)
               return true;

            return false;
         }
      </script>";
   }

   public function getJsZoriValidateSaveTabs($jsExtra="", $jsFuctionName="jsZoriValidateSave")
   {//vd($this->jsValidate);

      return "
      <script>
         function $jsFuctionName()
         {
            var state = true;

               $this->jsValidate
               $jsExtra

            setTimeout(function() {
               $('#messageID').fadeOut().empty();
            }, 5000);

            if(state)
               return true;

            return false;
         }
      </script>
             ";
   }

   // 20170112 javascript function for custom styled input components -- Gael
   public function getJsZoriComponent($jsExtra="")
   {//vd($this->jsComponent);

      return "
         <script>
            $(document).ready(function()
            {
               $this->jsComponent
               $jsExtra
            });
         </script>";
   }

   protected function ContentBox()
   {

      foreach($this->ContentBootstrap AS $Order => $arrVal)
      {
         foreach($arrVal AS $ColSize => $strContent)
         {
            $content .= "<div class='$ColSize'><div class='x_panel'>$strContent</div></div>";
         }
      }

      return $content;

      // return "
      // <table border='0' cellpadding='2' cellspacing='1' width='100%' id='tblContent'>
      //    <tr>
      //       <td align='left' valign='top' id='tdContentLeft'>
      //          <div id='divContentx'>
      //          ". $this->ContentLeft ."
      //          </div>
      //       </td>
      //       <td align='left' valign='top' id='tdContentRight'>
      //          <div id='divContentx'>
      //          ". $this->ContentRight ."
      //          </div>

      //       </td>
      //    </tr>
      //    <tr><td colspan='100%' style='background: transparent; padding: 0px;'>". $this->Content ."</td></tr>
      // </table>
      // ";
   }

   public static function cleanColumnName($ColumnName)
   {//remove the "str" and add spaces for every "word"
      //$translateTable = array("["=>"`",
      //                        "]"=>"`");//"funny chars" => "new chars". just add into the array
      //$sql = strtr($sql, $translateTable);
      //ini_set('display_errors', '0');
      $count = strlen($ColumnName);
      $i = 0;
      $ii = 0;
      $boolCap = false;
      $intCap = 0;
      $Output = "";

      //loop through characters
      while($i < $count)
      {
         $char = $ColumnName{$i};
         if($intCap > 1 && preg_match("/[a-z]/", $char)){
            $strings[$ii] .= "*".$char;
            $boolCap=false;
            $intCap=0;
         }
         //check if character is a capital letter and capital letter not done twice
         elseif(preg_match("/[A-Z]/", $char) && $boolCap == false ){
            $ii++;
            $strings[$ii] .= $char;
            $boolCap=true;
         }
         //otherwise not capital letter
         elseif(preg_match("/[a-z, 1-9\:]/", $char) ){//[a-z, 1-9\:] include numbers
            $strings[$ii] .= $char;
            $boolCap=false;
         }
         //check if capital letter was done twice
         elseif($boolCap == true){
            $strings[$ii] .= $char;
            $intCap++;
         }
         $i++;
      }//print_rr($strings);

      foreach($strings as $index => $value)
      {
         $string = $strings[$index];

         //if(ereg("[A-Z]", $string[0]))
         if(preg_match("/[A-Z]/", $string[0]))
         {
            $pos = strpos($string, "*");
            if($pos!="")
            {
               $cleanedstr = substr_replace($string, "", $pos-1);
               $cleanedstr2 = substr_replace($string, "",0, $pos-1 );
               $cleanedstr2=str_replace("*", "", $cleanedstr2);
               $Output .= $cleanedstr." ".$cleanedstr2;
            }
            else
            {
               $Output .= $string." ";
            }
         }
      }

      //echo "<BR>$Output: ". strpos($Output, " ID") ." _ ". (strlen($Output)-4);
      if(strpos($Output, " ID") === (strlen($Output)-4))
      {//20111031 - removed extra " ID" if last 3 chars of the lable, eg. "Region ID" => "Region"
         $Output = substr($Output, 0, strlen($Output)-4);
      }
      //ini_set('display_errors', '1');
      return $Output;
   }

}

?>