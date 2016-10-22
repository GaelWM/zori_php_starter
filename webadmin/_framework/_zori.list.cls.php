<?php
include_once("_framework/_zori.list.basic.cls.php");

class ZoriList extends ZoriListBasic
{
   /* notes
     : if you want to override the onclick of the td to change navigation you need to change the column's .eval: eg, $this->Columns[$key]->eval = "\$column->html->onclick = \"window.location='". $this->SystemSettings[FULL_PATH] ."?Action=Edit&\$evalkey'\";";

   public $Data;
   public $Columns;
   public $sql;
   public $sql2;
   public $DataKey = array();
   */

   private $srtArg;
   public $isSortable = 1;
   public $isPageable = 0;



   //extends list basic, adding chks, # numbers, etc
   public function __construct($DataKey)
   {//note: DATAKEY has to be pressent in the query
      parent::__construct();

      if($DataKey!= ""){
         if(is_array($DataKey)){
            $this->DataKey = array_flip($DataKey);
            foreach($this->DataKey as $key => $value)
               $this->DataKey[$key] = -1;
         }else{
            $this->DataKey[$DataKey] = -1;
         }
      }else{
         unset($this->DataKey);
      }
      $this->ToolBar->Buttons[btnNew]->blnShow = $this->Security->blnNew;
      $this->ToolBar->Buttons[btnDelete]->blnShow = $this->Security->blnDelete;
      $this->ToolBar->Buttons[btnExport]->blnShow = 1;

      //$this->ToolBar->Buttons[btnExport]->blnShow = 1;

      //print_rr($this->ToolBar->Buttons);
   }


   public function ListSQL($sql,$Debug=0, $path="", $action="")
   {//print_rr($this->isSortable);
      if(isset($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Sort) && $this->isSortable == 1)
      {//replace ORDER BY with new Order by
         //echo $sql ."<BR><BR>";
         $srtArg = $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Sort;
         //print_rr($this);
         if($srtArg[srtCurrent] == $srtArg[srtNew])
         {
            if($srtArg[srtDir] == "DESC")
               $srtArg[srtDir] = "ASC";
            else
               $srtArg[srtDir] = "DESC";

         }else{
            $srtArg[srtCurrent] = $srtArg[srtNew];
            $srtArg[srtDir] = false;
         }

         //apply new ORDER BY
         $idxOrder = strripos($sql, "ORDER BY");
         if($idxOrder >> 0)
            $sql = substr($sql, 0, $idxOrder);
         $sql .= "ORDER BY `". $srtArg[srtCurrent] ."` ". $srtArg[srtDir];
         //echo $idxOrder.$sql;
      }
      $this->srtArg = $srtArg;
      //print_rr($srtArg);

      parent::ListSQL($sql, $Debug);

//print_rr($this->SystemSettings);
      if(isset($this->DataKey)){
      foreach($this->DataKey as $key => $value)
      {//print_rr($this->Columns);
         //set datakey column idxs
         $this->DataKey[$key] = $this->Columns[$key]->idx;
         //hide PK
         $this->Columns[$key]->Header->html->class =
         $this->Columns[$key]->html->class = "tdPK";
      }
      }
      if($action == "")
      {
         $action = "Edit";
      }
      if($path == "")
      {
         $path = $this->SystemSettings[FULL_PATH];
      }
      if(isset($this->DataKey)){
         $this->eval = "\$column->html->onclick = \"window.location='$path?Action=$action&\$evalkey'\";";
      }
   }

   public function renderList()
   {
      return parent::renderList($this->srtArg);
   }

//delete

   public function renderTable($strCaption="", $tableHTML=null)
   {
      global $BR;

      $strList = $this->renderList();

      $htmlAttr = ZoriControl::renderAttributes($tableHTML);
      if($strCaption != "")
         $strCaption = "<caption class='text-left'>$strCaption</caption>";

      if($this->isPageable == 1 && $this->SystemSettings["PageSize"] > 0)
      {
         $Pager = $this->renderPager();
      }
      return "
      <table border='0' cellpadding='2' cellspacing='1' width='100%' class='table table-sm table-hover table-responsive' $htmlAttr>
         $strCaption
         $strList
         $Pager
      </table>
      ";
   }

   protected function renderPager()
   {
      global $SP;
      $intPages = ceil($this->intRecords/$this->SystemSettings["PageSize"]);

      for($i = 1; $i <= $intPages; $i++)
      {
         $strPager .= "$SP$SP<a style='' ". ($i == $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->PageNumber ? "class='aCurrent'":"href='?pagPageNumber=$i'") .">$i</a>$SP$SP";
      }

      if($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->PageNumber != 1)
         $strFirst = "$SP$SP<<$SP$SP<a href='?pagPageNumber=1'>First</a>$SP$SP<$SP$SP<a href='?pagPageNumber=".($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->PageNumber-1)."'>Previous</a>$SP";
      else
         $strFirst = "$SP$SP<<$SP$SP<a class='aCurrent'>First</a>$SP$SP<$SP$SP<a class='aCurrent'>Previous</a>$SP";

      if($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->PageNumber != $intPages)
         $strLast = "$SP<a href='?pagPageNumber=".($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->PageNumber+1)."'>Next</a>$SP$SP>$SP$SP<a href='?pagPageNumber=$intPages'>Last</a>$SP$SP>>";
      else
         $strLast = "$SP<a class='aCurrent'>Next</a>$SP$SP>$SP$SP<a class='aCurrent'>Last</a>$SP$SP>>";

      return "
         <tr id='trPager'>
            <th colspan='50%' align='left' style=''>
               $strFirst
               |$SP$SP Page: $strPager|$SP
               $strLast
            </th>
         </tr>";

      // return "
      //    <nav aria-label='...'>
      //      <ul class='pagination'>
      //        <li class='page-item disabled'>
      //          <a class='page-link' href='#' tabindex='-1' aria-label='Previous'>
      //            <span aria-hidden='true'>&laquo;</span>
      //            <span class='sr-only'>Previous</span>
      //          </a>
      //        </li>
      //        <li class='page-item active'>
      //          <a class='page-link' href='#'>1 <span class='sr-only'>(current)</span></a>
      //        </li>
      //        <li class='page-item'><a class='page-link' href='#'>2</a></li>
      //        <li class='page-item'><a class='page-link' href='#'>3</a></li>
      //        <li class='page-item'><a class='page-link' href='#'>4</a></li>
      //        <li class='page-item'><a class='page-link' href='#'>5</a></li>
      //        <li class='page-item'>
      //          <a class='page-link' href='#' aria-label='Next'>
      //            <span aria-hidden='true'>&raquo;</span>
      //            <span class='sr-only'>Next</span>
      //          </a>
      //        </li>
      //      </ul>
      //    </nav>
      // ";
   }

}


?>
