<?php
   include_once("_framework/_zori.report.cls.php");
   
   $page = new ZoriReport();
   
   //clear session if action clear is in the post
   if($_POST[Action] == "Clear")
   {
      unset($_SESSION[PAGES]->Entity["report.php"]->Filters[radReport]);
   }

   //Check if the Session's report filter is empty, then set the default
   if(!isset($_SESSION[PAGES]->Entity["report.php"]->Filters[radReport]))
   {
      $_SESSION[PAGES]->Entity["report.php"]->Filters[radReport] = "timesheet.rpt";
      $_POST[radReport] =  $_SESSION[PAGES]->Entity["report.php"]->Filters[radReport];
   }

   //Check if the $_POST report filter is empty, then copy the sessions report filter into the $_POST
   if($_POST[radReport] == "" && $_SESSION[PAGES]->Entity["report.php"]->Filters[radReport] != "" && $Action != "Clear")
   {
     // echo "here";
      $_POST[radReport] = $_SESSION[PAGES]->Entity["report.php"]->Filters[radReport];
      $Action = "Run Report";
   }

   //setup Filters 1

   //print_rr($_SESSION[PAGES]->Entity["report.php"]);
   //print_rr($_POST);

   // $page->Filters[frClient]->tag = "select";
   // $page->Filters[frClient]->html->value = "0";
   // $page->Filters[frClient]->html->onchange = "jsUpdateProjects(); jsGetTickets();";
   // $page->Filters[frClient]->html->class = "controlText";
   // $page->Filters[frClient]->sql = "
   //    SELECT 0 AS ControlValue, '- All -' AS ControlText
   //    UNION ALL
   //       SELECT ClientID AS ControlValue, strClient AS ControlText
   //       FROM tblClient
   //       WHERE blnActive = 1 
   //       ORDER BY ControlText ASC";
   // //$page->Filters[frClient]->html->innerHTML = getClientsDDL($_POST[frClient]);  
  
  
   // $page->Filters[frProject]->tag = "select";
   // $page->Filters[frProject]->html->value = "0";
   // $page->Filters[frProject]->html->onchange = "jsUpdateProjectItems()";
   // $page->Filters[frProject]->html->class = "controlText";
   // $page->Filters[frProject]->sql = "
   //    SELECT 0 AS ControlValue, '- All -' AS ControlText
   //    UNION ALL
   //       SELECT ProjectID AS ControlValue, strProject AS ControlText
   //       FROM tblProject
   //       WHERE blnActive = 1 AND 1=0
   //       ORDER BY ControlText ASC"; 

   // $page->Filters[frProjectItem]->tag = "select";
   // $page->Filters[frProjectItem]->html->value = "0";
   // $page->Filters[frProjectItem]->html->class = "controlText";
   // $page->Filters[frProjectItem]->sql = "
   //    SELECT 0 AS ControlValue, '- All -' AS ControlText
   //    UNION ALL
   //       SELECT ProjectID AS ControlValue, strProject AS ControlText
   //       FROM tblProject
   //       WHERE blnActive = 1 AND 1=0
   //       ORDER BY ControlText ASC"; 

   $page->Filters[frStartDate]->tag = "input";
   $page->Filters[frStartDate]->html->value = date("Y-m-01");
   $page->Filters[frStartDate]->html->type = "text";
   $page->Filters[frStartDate]->html->class = "controlText controlNumeric datePicker";
   //$page->Filters[frStartDate]->html->readonly = "readonly";

   $page->Filters[frEndDate]->tag = "input";
   $page->Filters[frEndDate]->html->value = date("Y-m-t");
   $page->Filters[frEndDate]->html->type = "text";
   $page->Filters[frEndDate]->html->class = "controlText controlNumeric datePicker";
   //$page->Filters[frEndDate]->html->readonly = "readonly";

   $page->Filters[frAllDates]->tag = "input";
   $page->Filters[frAllDates]->html->value = "checked"; //value must be checked!
   //$page->Filters[frAllDates]->html->checked = "checked";
   $page->Filters[frAllDates]->html->type = "checkbox";
   //$page->Filters[frAllDates]->html->onclick = "d('frStartDate').disabled=this.checked;d('frEndDate').disabled=this.checked;";
//print_rr($_SESSION[PAGES]->Entity[$page->SystemSettings[SCRIPT_NAME]]);
   if($_SESSION[PAGES]->Entity[$page->SystemSettings[SCRIPT_NAME]]->Filters[frAllDates])
   {// ignore was set, disable date filters
      $page->Filters[frStartDate]->html->disabled = "disabled";
      $page->Filters[frEndDate]->html->disabled = "disabled";
   }   

//    $page->Filters[frUser]->tag = "select";
//    $page->Filters[frUser]->html->value = "0";
//    $page->Filters[frUser]->html->class = "controlText";
//    $page->Filters[frUser]->sql = "
//       SELECT 0 AS ControlValue, '- All -' AS ControlText
//       UNION ALL
//          SELECT UserID AS ControlValue, strUser AS ControlText
//          FROM sysUser
//          WHERE blnActive = 1
//          ORDER BY ControlText ASC"; 

//    $page->Filters[frInvoiced]->tag = "select";
//    $page->Filters[frInvoiced]->html->value = "-1";
//    $page->Filters[frInvoiced]->html->class = "controlText";
//    $page->Filters[frInvoiced]->sql = "
//       SELECT -1 AS ControlValue, '- All -' AS ControlText
//          UNION ALL
//       SELECT 1 AS ControlValue, 'Invoiced' AS ControlText    
//          UNION ALL
//       SELECT 0 AS ControlValue, 'Not Invoiced' AS ControlText
//          "; 

//    if($_POST[frClient] != 0)
//    {
//       $strTicketWhere = "AND tblTicket.refClientID = ". $_POST[frClient] ;
//    }

//    $page->Filters[frTicket]->tag = "select";
//    $page->Filters[frTicket]->html->value = "0";
//    $page->Filters[frTicket]->html->class = "controlText";
//    $page->Filters[frTicket]->sql = "
//          SELECT 0 AS ControlValue, '- All -' AS ControlText
//       UNION ALL
//          SELECT -1 AS ControlValue, '- None -' AS ControlText
//       UNION ALL
//          SELECT tblTicketItem.TicketItemID AS ControlValue, CONCAT(tblTicket.strTicket, ' - ', tblTicketItem.strTicketItem) AS ControlText
//          FROM tblTicketItem INNER JOIN tblTicket ON tblTicketItem.refTicketID = tblTicket.TicketID
//          WHERE tblTicketItem.blnActive = 1  $strTicketWhere
//          ORDER BY ControlText ASC;
//          "; 
   

   $page->ToolBar->Columns = 2;

   $page->iniFilters();

   //setup Reports 2
   $page->addReport("Timesheet Totals Report", "timesheet.totals.rpt", array("frClient", "frProject", "frAllDates","frStartDate","frEndDate", "frUser","frTicket"));
   $page->addReport("Timesheet Report with Notes", "timesheet.rpt", array("frClient", "frProject", "frProjectItem","frAllDates","frStartDate","frEndDate", "frUser", "frInvoiced","frTicket"));
   $page->addReport("Timesheet Ticket Report", "ticket.rpt", array("frClient", "frProject", "frProjectItem","frAllDates","frStartDate","frEndDate", "frUser", "frInvoiced","frTicket"));
   

   $page->iniReports();
   //print_rr($page->Reports);

   //addition buttons:
   // $page->ToolBar->Buttons["btnInvoice"] = nCopy($page->ToolBar->Buttons["btnRevert"]);
   // $page->ToolBar->Buttons["btnInvoice"]->Control->value = $page->MARKASINVOICED;
   // $page->ToolBar->Buttons["btnInvoice"]->blnShow = 0;
   // $page->ToolBar->Buttons["btnInvoice"]->Span->class = "icon-32-revert";

   // $page->ToolBar->Buttons["btnExportIIF"] = nCopy($page->ToolBar->Buttons["btnExport"]);
   // $page->ToolBar->Buttons["btnExportIIF"]->Control->value = $page->IIFEXPORT;   
   // $page->ToolBar->Buttons["btnExportIIF"]->blnShow = 0;

//events
   switch($Action)
   {
      

   }

//event LOAD Report 
   
   include_once("reports/". $_POST[radReport] .".php");
   

//nav
   switch($Action)
   {
      case "Export":

         $strFilename = str_replace(" ", "_", $strFilename);
         header("Content-type: application/x-msdownload");
         header("Content-Disposition: attachment; filename=". $strFilename .".xls"); //gets set inside the report.rpt.php
         header("Pragma: no-cache");
         header("Expires: 0");

         echo $Output;
         die;

         break;
         
      case "Clear":

      default:

         $page->Content .= $Output             
            . js("
               
               ");
   }
   
   $page->Message->Text = $Message;
   $page->Display();

   //set timesheet report session object to have the currently selected report
   $_SESSION[PAGES]->Entity["report.php"]->Filters[radReport] = $_POST[radReport];
           

?>
