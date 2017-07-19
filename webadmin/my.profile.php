<?php
   include_once("_framework/_zori.cls.php");
   include_once("_framework/_zori.details2.cls.php");
   include_once("includes/user.cls.php");

   $page = new Zori();
//events
   switch($Action){
      case "Save":
         //$page->fields
         $Message = User::SaveMyProfile($_SESSION[USER]->ID);
         break;
   }

   $page = new ZoriDetails();
   $page->AssimulateTable("sysUser", $_SESSION[USER]->ID, "strUser");

   $page->Fields["refSecurityGroupID"]->Control->html->readonly="true";
   $page->Fields["strUser"]->Control->html->readonly = "readonly";
   $page->Fields["strEmail"]->Control->html->readonly = "readonly";
   $profilePic = "<img src = '". $page->SystemSettings[ProfileImageDirAdmin].$page->Fields["Profile:PicturePath"]->VALUE ."' title='". $page->Fields["strDisplayName"]->VALUE ."' target=_blank />
      ";

   $page->ToolBar->Buttons[btnSave]->Control->onclick = "return jsValidateCustom();";
   $page->ToolBar->Buttons[btnExport]->blnShow = 0;
   $page->ToolBar->Buttons[btnReload]->blnShow = 0;
   $page->ToolBar->Buttons[btnClose]->blnShow = 0;

   unset($page->Fields["strPasswordMD5"]);
   unset($page->Fields["Profile:PicturePath"]);
   unset($page->Fields["strFirstUser"]);
   unset($page->Fields["dtFirstEdit"]);
   unset($page->Fields["strSetting:Language"]);

   $page->renderControls();
   $page->ContentBootstrap[0]["col-md-6"] = $JS.$page->renderForm($page->ToolBar->Label);
   $page->ContentBootstrap[1]["col-md-2"] = $profilePic;
   $page->Message->Text = $Message;
   $page->Display();
?>
