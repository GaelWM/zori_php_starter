<?php
//include_once("_Zori.basic.cls.php");
/*
 * 20110621 - refined anchor tag click 
 * 20110621 - added field-type data-transforms
 * 20140205 - add ->Data[$i][html] in order to render attributes in the data TR on renderList() 
  *20160511 - Inspect Column type and set list's styling based on that (much like in Zori.database) 
 */

include_once("_framework/_zori.cls.php");

class ZoriListBasic extends Zori
{
   public $Data;
   public $Columns;
   public $sql;
   public $sql2;

   public $isSortable = 1;
   public $isSelectable = 1;
   public $isPageable = 1;

   public $intRecords = 0;

   public $DataKey = array();
   public $eval = "";

   private $arrEvalTinyint = array(0 => "No", 1 => "Yes");

   //ok, all this class should do is pick up the sql statement and generate a data array and make a list view of it. no security-able interaction!
   public function __construct()
   {
      parent::__construct();
   }

   public function ListSQL($sql, $Debug = 0)
   {
      $xdb = new ZoriDatabase("",null,null,0);

      if($this->isPageable == 1 && $this->SystemSettings["PageSize"] > 0)
      {
         /*
          * check for existing limits, get last (might have limit inside sub Q)
          * remove existing limit
          * count number of rows
          * apply new limit
          *
          */

         $intLengthSQL = strlen($sql);
         $idxLimit = strrpos(strtolower($sql), "limit");

         $limitStart = @round($this->SystemSettings["PageSize"] * $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->PageNumber - $this->SystemSettings["PageSize"],0);

         if($idxLimit > 0 && ($intLengthSQL - $idxLimit) < 20)
         {//remove existing limits and implement new limit
            $sql = substr($sql, 0, $idxLimit);
         }

         $row = $xdb->getRowSQL("SELECT COUNT(*) as intRecords FROM ($sql) AS tblCount ",0);
         $this->intRecords = $row->intRecords;

         $sql .= "
               LIMIT $limitStart, ". $this->SystemSettings["PageSize"];
      }

      $this->sql = nCopy($sql);
      $rst = $xdb->doQuery($sql,$Debug);
      $this->sql2 = $sql;

      //reset
      unset($this->Data, $this->Columns);
      //build columns
      $i = 0;
      while($column = $xdb->fetch_field($rst))
      {//20110621 - added field-type data-transforms - pj
         //by db
         //print_rr($column);
         if($column->table != "" && $column->type == MYSQLI_TYPE_TINY)
         {
            //$rstTable = $xdb->doQuery("DESCRIBE `$column->table`",0);
            // if($rstTable){
            // while($rowT = $xdb->fetch_object($rstTable))
            // {//echo "<BR> stripos($rowT->Field, $column->name) : ". stripos($rowT->Field, $column->name);
               // if(stripos($rowT->Type, "tinyint") > -1 && stripos(str_replace($column->name," ",""), $rowT->Field) > -1 || true)
               // {//print_rr($rowT);print_rr($column);
                  $column->eval .= "\$row[\$idxCol] = \$this->arrEvalTinyint[\$row[\$idxCol]];"; //note: can happen only once
                  $column->type = "tinyint";
                  //break;
               //}
            //}}
         }
         //override
         switch($row->type)
            {
               default:
                  $this->Fields[$row->name] = "";
                  $this->FieldList[$i]->type = "text";
                  break;
            }

         //20160511 - Inspect Column type and set list's styling based on that (much like in Zori.database) - christiaan/PJ
         switch($column->type)
         {
            //case MYSQLI_TYPE_TINY:
            case "tinyint":
               $column->html->align = "center";
               $column->excel->align = "center";
               break;

            //numerics
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 5:
            case 8:
            case 9:
            case 16:
            case 246:
               $column->html->align = "right";
               $column->excel->align = "right";
               break;
            case "string":
            case 253:  //20150803 - Fixed issue with primary keys's being strings not saving correctly / fixed by adding string to the switch to check field types- christiaan
               $column->html->align = "left";
               $column->excel->align = "left";
               if($column->decimals != 0)
                  $column->html->align = "right"; // could be a FORMAT()ed number
                  $column->excel->align = "right";
               break;
            case "timestamp":
            case 7: //
               $column->html->align = "right";
               $column->excel->align = "right";
               break;
            case "date":
            case 10:
            case 12:
               $column->html->align = "center";
               $column->excel->align = "center";
               break;
         }
         //print_rr($column);

         //default
         // if($column->html->align == "")
         // {
         //    if($column->numeric == 1)
         //       $column->html->align = "right";
         //    else
         //       $column->html->align = "left";
         // }

         $column->idx = $i;

         $this->Columns[$column->name] = nCopy($column);

         $i++;
      }
      //print_rr($this->Columns);

      //mysql_data_seek($rst,0);
      while($row = $xdb->fetch_array($rst))
      {
         $this->Data[count($this->Data)] = $row;
      }

      //$this->isSortable = 1;
   }

   public function ListDATA($arrData=null)
   {
      if($arrData != null)
         $this->Data = $arrData;

      //if null then reassimulate columns
         $i=0;

      foreach($this->Data[0] as $idx => $value)
      {//reduild columns

         $this->Columns[$idx]->name = $idx;
         $this->Columns[$idx]->idx = round($i/2.0000001,0);

         $i++;
      }

      foreach($this->Columns as $idx => $column)
      {//checks the data in the first row to determine html->align if columns were not set
         //print_rr($this->Data[0]);

         //print_rr($column);
         //echo is_numeric($this->Data[0][$idx]);
         if(!isset($column->numeric)){
            if(is_numeric($this->Data[0][$idx])){
               $this->Columns[$idx]->numeric = 1;
            }
            else{
               $this->Columns[$idx]->numeric = 0;
            }
         }
         if($this->Columns[$idx]->numeric == 1)
         {
            $this->Columns[$idx]->html->align = "right";
            $this->Columns[$idx]->excel->align = "right";
         }
         else
         {
            $this->Columns[$idx]->html->align = "left";
            $this->Columns[$idx]->excel->align = "left";
         }
      }
   }

   public function renderList($srtArg=null)
   {
      global $SP;

      if(is_array($_REQUEST[chkSelect]))
      {
         $arrSelect = $_REQUEST[chkSelect];
      }
      //print_rr($_REQUEST);

      $strList .= "<tr><th width='1%'>#</th>";
      foreach($this->Columns as $idxCol => $column)
      {
         $htmlAttr = ZoriControl::renderAttributes($column->Header->html);
         if($this->isSortable)
            $strSort = "class='linkbutton2 textColour sorting' onclick=\"window.location.href='?srtNew=$column->name&srtCurrent=".$srtArg[srtCurrent]."&srtDir=".$srtArg[srtDir]."'\"";
         $strList .= "<th $htmlAttr $strSort>$column->name</th>";
      }
      if(count($this->DataKey)>0 && $this->isSelectable == 1) $strList .= "<th width='1%' class='linkbutton2 textColour' ><input type='checkbox' id='check-all' class='flat'></th>";
      $strList .= "</tr>";

      if($this->isPageable == 1 && $this->SystemSettings["PageSize"] > 0)
         $i = $this->SystemSettings["PageSize"] * $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->PageNumber - $this->SystemSettings["PageSize"] + 1;
      else
         $i = 1;


      if(count($this->Data)>0){
      foreach($this->Data as $idxRow => $row)
      {
//print_rr($row); die;
         if(count($this->DataKey)>0)
         {//print_rr($this->DataKey);
            $evalkey = $selectKey = $checked = "";
            foreach($this->DataKey as $key => $value)
            {
               $evalkey .= "&$key=". $row[$value];
               $selectKey .= "[". $row[$value] ."]";

            }
            //echo "<BR>$id: $select = ";
            //eval ("echo \$$select;");
            $select = "arrSelect".$selectKey;
            if($selectKey != "[]")//failsafe
               eval("\$checked = \$$select;");

            $chkSelect = "<input type='checkbox' class='flat' name='chkSelect$selectKey' value='checked' > ";
            //var_dump($evalkey);die;
         }
         if(count($this->DataKey)>0)
         {//20110621 - refined anchor tag click - pj
            $a1 = "<a id='a[$i]' href=\"?Action=Edit$evalkey\" target=_blank>";
            $a2 = "</a>";
         }
         $strList .= "<tr ". ZoriControl::renderAttributes($row[html]) ."><td style='' align='right' class='tdCount textColour'>$a1$i$a2</td>"; //20140205 - add ->Data[$i][html] in order to render attributes in the data TR on renderList() - pj

         foreach($this->Columns as $idxCol => $column)
         {
//print_rr($column);
            if($this->eval != "") eval($this->eval); // used in ZoriList
            if($column->eval != "") eval($column->eval); // used in ZoriList
            //print_rr($column);die;
            $htmlAttr = ZoriControl::renderAttributes($column->html);
            $strList .= "<td $htmlAttr >". $row[$idxCol] ."</td>";
         }

         if(count($this->DataKey)>0 && $this->isSelectable == 1)
         {
            $strList .= "<td align=center>$chkSelect</td>";
         }
         $strList .= "</tr>";
         $i++;
//break;
      }}
      //print_rr($this);die;
      return $strList;
   }

   public function renderTable($strCaption="", $tableHTML=null)
   {
      global $BR;

      $strList = $this->renderList();

      $htmlAttr = ZoriControl::renderAttributes($tableHTML);
      if($strCaption != "")
         $strCaption = "<caption>$strCaption</caption>";

      return "
      <table border='0' cellpadding='2' cellspacing='1' width='100%' $htmlAttr>
         $strCaption
         $strList
      </table>
      $BR";
   }

   public function setEvalTinyint($key, $value)
   {//20110621 - added field-type data-transforms - pj
      $this->arrEvalTinyint[$key] = $value;
   }

}


?>
