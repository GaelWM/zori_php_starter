<?php
   ini_set('display_errors', '1');
   error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);

   
   include_once("_framework/_zori.cls.php");
   include_once("_framework/_zori.details.cls.php");
   include_once("includes/usage.log.cls.php");

   $page = new Zori();

//events
   switch($Action)
   {
      case "Reload":
         windowLocation("?Action=Edit&LoginID=$LoginID");
         break;

      case "Delete":
         $Message = UsageLog::Delete($_POST[chkSelect]);
         break;
   }
//nav
   switch($Action)
   {
      case "Save":
      case "Edit":
      case "New":
         $page = new ZoriDetails();
         $page->AssimulateTable("sysLogin", $LoginID, "strUsername");
         print_rr($page->Fields);
         $page->renderControls();
         $page->ContentLeft = $page->renderTable($page->ToolBar->Label) . $page->getJsNemoValidateSave($JS);
      break;

      default:
         $page = new UsageLog(array("LoginID"));

         $page->isPageable = 1;
         $page->Content = $page->getList();
         break;
   }

   $page->Message->Text = $Message;
   $page->Display();
?>

 