<?php
   include_once("_framework/_zori.cls.php");
   include_once("_framework/_zori.details.translator.cls.php");
   include_once("includes/faq.cls.php");



//events
   switch($Action){
      case "Reload":
         windowLocation("?Action=Edit&FAQID=$FAQID");
         break;
      case "Save":
         $Message = FAQ::Save($FAQID, $page);
         break;
      case "Delete":
         $Message = FAQ::Delete($_POST[chkSelect]);
         break;
   }
//nav

   switch($Action){
      case "Save":
      case "Edit":
      case "New":
         $page = new ZoriDetailsTranslator();

         $page->AssimulateTable("tblFAQ", $FAQID, $_SESSION["USER"]->LANGUAGE ."_strTitle");

         $page->Fields["FAQID"]->Control->type = "hidden";
         //$page->Fields["blnActive"]->Label = $_TRANSLATION[$_SESSION["USER"]->LANGUAGE]["blnActive"];

         $page->renderControls();
         $page->ContentLeft = $page->renderTable($page->ToolBar->Label) . $page->getJsNemoValidateSave();
         break;
      default:

         $page = new FAQ(array("FAQID"));
         //$page->Content = $page->getList();
         $page->Content = "Work in progress";
         break;
   }

   $page->Message->Text = $Message;
   $page->Display();
?>
