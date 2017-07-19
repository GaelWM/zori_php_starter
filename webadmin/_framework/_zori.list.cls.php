<?php
//20160815 - added renderExcel
//20170124 - add new and delete buttons if list is a sub list
//20170526 - take out the customHTML parameter in renderTable function -- Gael

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
      }//echo $sql; vd($this->DataKey);
      if(isset($this->DataKey)){
         $this->eval = "\$column->html->onclick = \"window.location='$path?Action=$action&\$evalkey'\";";
      }
   }

   public function renderList()
   {
      return parent::renderList($this->srtArg);
   }

//delete

   // public function renderTable($strCaption="", $tableHTML=null)
   // {
   //    global $BR;

   //    $strList = $this->renderList();

   //    $htmlAttr = ZoriControl::renderAttributes($tableHTML);
   //    if($strCaption != "")
   //       $strCaption = "<caption>$strCaption</caption>";

   //    if($this->isPageable == 1 && $this->SystemSettings["PageSize"] > 0)
   //    {
   //       $Pager = $this->renderPager();
   //    }
   //    return "
   //    <table class='tblZoriList' border='0' cellpadding='3' cellspacing='0' width='100%' $htmlAttr>
   //       $strCaption
   //       $strList
   //       $Pager
   //    </table>
   //    ";
   //    // I REMOVED THE BREAK TO DECREASE SPACING - JACQUES - 20130923
   // }

   ## NEW RENDERTABLE FUNCTION TO WORK WITH Zori 3 ############################################################ 12 JANUARY 2017 ## JACQUES
   //20170526 - take out the customHTML parameter in renderTable function -- Gael
   public function renderTable($strCaption="", $tableHTML=null, $export=1, $subList = 0)
   {
      global $BR;

      $strList = $this->renderList();

      $htmlAttr = ZoriControl::renderAttributes($tableHTML);

      if($export == 1)
      {
         $exportHTML = "<div id='datatable-buttons_wrapper' class='dataTables_wrapper form-inline dt-bootstrap no-footer'>
                           <div class='dt-buttons btn-group'>
                              <a class='btn btn-default buttons-copy buttons-html5 btn-sm' tabindex='0' aria-controls='datatable-buttons' href='#'> <span>Copy</span> </a>
                              <a class='btn btn-default buttons-csv buttons-html5 btn-sm' tabindex='0' aria-controls='datatable-buttons' href='#''> <span>CSV</span> </a>
                              <a class='btn btn-default buttons-excel buttons-flash btn-sm' tabindex='0' aria-controls='datatable-buttons' href='#''>
                                 <span>Excel</span>
                                 <div style='position: absolute; left: 0px; top: 0px; width: 51px; height: 30px; z-index: 99;'>
                                    <embed id='ZeroClipboard_TableToolsMovie_1' src='//cdn.datatables.net/buttons/1.2.0/swf/flashExport.swf' loop='false' menu='false' quality='best' bgcolor='#ffffff' name='ZeroClipboard_TableToolsMovie_1' allowscriptaccess='always' allowfullscreen='false' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' flashvars='id=1&width=51&height=30' wmode='transparent' width='51' height='30' align='middle'>
                                 </div>
                              </a>
                              <a class='btn btn-default buttons-print btn-sm' tabindex='0' aria-controls='datatable-buttons' href='#''> <span>Print</span> </a>
                           </div>
                        </div> ";
      }

      if($this->isPageable == 1 && $this->SystemSettings["PageSize"] > 0)
      {
         $Pager = $this->renderPager();
      }

      //20170124 - add new and delete buttons if list is a sub list - maanie
      if ($subList == 1)
      {
         $strCaption = substr($strCaption, 0, strpos($strCaption, ' '));

         $buttonSubListHTML = "<div style='position:relative;float:left;'>
                                 <div style='position:absolute; color:#fff; top:10px; left:10px;' class='fa fa-plus'></div>
                                    <input style='padding:6px 12px 6px 30px;' class='linkbutton btn btn-success btn-xs' value='New $strCaption' id='btnNew$strCaption' name='Action' tag='input' type='submit'>
                                 </div>
                               <div style='position:relative;float:right;'>
                                  <div style='position:absolute; color:#fff; top:10px; left:10px;' class='fa fa-remove'></div>
                                  <input style='padding:6px 12px 6px 30px;' class='linkbutton btn btn-danger btn-xs' value='Delete $strCaption' onclick='return confirm('Are you sure you want to delete $strCaption(s)?');' id='btnDelete$strCaption' name='Action' tag='input' type='submit'>
                               </div>";

         $padding = "style='padding-bottom: 2px;'";
         $strCaption = "";
      }

      return "
            <div class='x_title'>
               <h2>$strCaption<small><!-- ABILITY TO ADD SMALLER TEXT NEXT TO TITLE --></small></h2>
               <ul class='nav navbar-right panel_toolbox'>
                  <li>$buttonSubListHTML</li>
                  <li>$exportHTML</li>

                  <!-- COMMMENTED OUT - NOT NEEDED AT THIS STAGE -->
                  <!--<li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a> </li>
                  <li class='dropdown'>
                     <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><i class='fa fa-filter'></i></a>
                     <ul class='dropdown-menu' role='menu'>
                        <li><a href='#'>Settings 1</a> </li>
                        <li><a href='#'>Settings 2</a> </li>
                     </ul>
                  </li>-->
               </ul>
               <div class='clearfix'></div>
            </div>

            <div class='x_content'>
               <p class='text-muted font-13 m-b-30'> <!-- ABILITY TO ADD EXPLANATION BELOW --></p>

               <div id='datatable-buttons' class=' '> </div>
               <div class='table-responsive' $padding>
                  <table id='datatable-checkbox' class='table jambo_table table-striped table-bordered bulk_action Zori3Table' $htmlAttr>
                     $strList
                  </table>
               </div>
               $Pager
            </div><div class='clearfix'></div> ";
   }

   protected function renderPager()
   {
      global $SP;
      $intPages = ceil($this->intRecords/$this->SystemSettings["PageSize"]);
      //print_rr($this->intRecords); die;
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
            <th colspan='100%' align='left' valign='middle' style='padding: 10px;'>
               $strFirst
               |$SP$SP Page: $strPager|$SP
               $strLast
            </th>
         </tr>";
   }
//20160815 - added renderExcel - shorouq
   public function renderExcel($EntityName, $arrData=null)
   {


      global $BR;
      //check if class PHPExcel exists, if not include it from ??
      if (!class_exists("PHPExcel")){
            require_once "PHPExcel/Classes/PHPExcel.php";
         }

      //check if class PHPExcel_Worksheet_PageSetup exists, if not include it from ??
      if (!class_exists("PHPExcel_Worksheet_PageSetup")){
            require_once "PHPExcel/Classes/PHPExcel/Worksheet/PageSetup.php";
         }

      //check if class PHPExcel_IOFactory exists, if not include it from ??
      if (!class_exists("PHPExcel_IOFactory")){
            require_once "PHPExcel/Classes/PHPExcel/IOFactory.php";
         }

      //check if class PHPExcel_Calculation_Exception exists, if not include it from ??
        if (!class_exists("PHPExcel_Calculation_Exception")){
              require_once "PHPExcel/Classes/PHPExcel/Calculation/Exception.php";
         }

      //ini
         $objPHPExcel = new PHPExcel(); //set up excel object
         $objPHPExcel->setActiveSheetIndex(0);
           //ORIENTATION
         $objPHPExcel->setActiveSheetIndex(0)->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
         $objPHPExcel->setActiveSheetIndex(0)->getPageSetup()->setFitToPage(true);
         $objPHPExcel->setActiveSheetIndex(0)->getPageSetup()->setFitToWidth(1);
         $objPHPExcel->setActiveSheetIndex(0)->getPageSetup()->setFitToHeight(0);
             //PAPER SIZE
         $objPHPExcel->setActiveSheetIndex(0)->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
           //MARGING SETTING
         $objPHPExcel->setActiveSheetIndex(0)->getPageMargins()->setTop(0.25);   //0.75
         $objPHPExcel->setActiveSheetIndex(0)->setTitle($EntityName);


      //format columns (foreach colum)
      $idxAlpha ="A";

      foreach($this->Columns as $idxCol => &$column)
      {
        //print_rr($column);
         //ini
         $column->idxAlpha = $idxAlpha;
         //echo "$BR$idxCol:$idxAlpha";
         //process
         $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($idxAlpha)->setWidth(20); //set col width

         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($idxAlpha."1", $idxCol); //set headings

        //post: get max column name
         $idxAlphaMax = $idxAlpha;
         $idxAlpha++;

      }

      $objPHPExcel->getActiveSheet()->getStyle("A1:".$idxAlphaMax."1")->getFont()->setSize(11)->setBold(true);
      //$objPHPExcel->getActiveSheet()->getStyle("A1:".$idxAlphaMax."1")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
      $objPHPExcel->getActiveSheet()->getStyle("A1:".$idxAlphaMax."1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle("A1:".$idxAlphaMax."1")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);//set row height
      //print_rr($this->Data);
      //process: load data

      foreach($this->Data as $idxRow => &$row)
      {//L1
      //echo $BR."idxRow: $idxRow :: ";

         foreach($this->Columns as $idxCol => &$column)
         {//L2
            //default styling:
            //print_rr($column);
            switch($column->type)
            {
               case "string":

                  if (preg_match("/^[0-9]+$/", $row[$idxCol]))
                  {
                     $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getNumberFormat()->setFormatCode("0");

                  }
                  else
                  {
                     $objPHPExcel->getActiveSheet()->setCellValueExplicit($column->idxAlpha.($idxRow+2), PHPExcel_Cell_DataType::TYPE_STRING);
                  }
                  break;

               case "int":
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                  break;
               case "date":
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                  break;
               case "timestamp":
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                  break;
                   /*$objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getFont()->setName("Arial");
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE)*/;
            }


               //additional styling:
               if($column->excel->align == "left")
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
               if($column->excel->align == "right")
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
               if($column->excel->align == "center")
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
               if ($column->excel->type == "currency")
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getNumberFormat()->setFormatCode("R #,##0.00");
               if (strpos($row[$idxCol], "<b>")!==false)
                  $objPHPExcel->getActiveSheet()->getStyle($column->idxAlpha.($idxRow+2))->getFont()->setBold(true);
               //SET VALUES
               $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column->idxAlpha.($idxRow+2), strip_tags($row[$idxCol])) ;
              //->setCellValue("A2", $row["Sales Person"]);
              //print_rr($column);
              //echo "$column->idxAlpha:". ($idxRow+2) ." = '". $row[$idxCol] ."'";
         }//eo FE col /L2

         //die("ljnsd872w");
      }//eo FE Row / L1

     //post

      try{

         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
         header("Content-Type: application/vnd.ms-excel");
         header("Content-Disposition: attachment; filename=". str_replace(" ","",$EntityName) ."_".date("YmdHis").".xls");
         $objWriter->save("php://output");
         $objPHPExcel->disconnectWorksheets();
         unset($objWriter, $objPHPExcel);
         die();

      }catch (PHPExcel_Calculation_Exception $e){
         return("Error while exporting to Excle sheet "+$e);

      }

   }

}


?>
