<?php
   include_once("_framework/_zori.cls.php");
   include_once("_framework/_zori.details2.cls.php");
   include_once("includes/settings.cls.php");

   ini_set('display_errors', '1');
   error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);
   
   $page = new Zori();
//events
   switch($Action)
   {
      case "Save":
         $page->Message->Text = $Message = Settings::Save($SettingID);
         break;
      case "Create Views":
         $Message = Settings::CreateViews();
         break;
   }
//nav
   switch($Action)
   {
      case "Save":
      case "Edit":
         $page = new ZoriDetails();
         $page->ToolBar->Buttons[btnReload]->blnShow = 0;

         $page->Message->Text = $Message;
         $page->AssimulateTable("sysSettings", $SettingID);
         $page->Fields["SettingID"]->Control->type = "hidden";
         $page->Fields["strSetting"]->Control->class = "controlText controlLabel";
         $page->Fields["strSetting"]->Control->readonly = "readonly";

         $page->ToolBar->Label = $page->ToolBar->Label .": ". $page->Fields["strSetting"]->Control->value;
         $page->renderControls();
         $page->ContentBootstrap[0]["col-md-4"] = $page->renderForm($page->ToolBar->Label) . $page->getJsZoriValidateSave();
         break;
      default:
         $securitygroup = new Settings(array("SettingID"));

         $page->ToolBar->Buttons["btnNew"]->Control->value = "Create Views";
         $page->ToolBar->Buttons["btnNew"]->blnShow = 1;

         $page->ContentBootstrap[0]["col-md-14"] = $securitygroup->getList();
   }
   $page->Message->Text = $Message;
   $page->Display();
?>
