<?php
   // ini_set('display_errors', '1');
   // error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);
   
   include_once("_framework/_zori.cls.php");
   include_once("_framework/_zori.details2.cls.php");
   include_once("includes/user.cls.php");

   $page = new Zori();
   //print_rr($_REQUEST);//die("uigyrfui");
//events
   switch($Action)
   {
      case "Reload":
         windowLocation("?Action=Edit&UserID=$UserID");
         break;

      case "Save":
         $Message = User::Save($UserID);
         break;

      case "Delete":
         $Message = User::Delete($_POST[chkSelect]);
         break;
   }
//nav

   switch($Action)
   {
      case "Save":
      case "Edit":
      case "New":
         $page = new ZoriDetails(array("Details","Security","Profile Picture"));
         $page->AssimulateTable("sysUser", $UserID, "strUser");
         //print_rr($page->Fields);

         $page->Fields["UserID"]->Control->type = "hidden";
         
         //Build strPassword Element
         $page->Fields["strPassword"] = nCopy($page->Fields["strPasswordMD5"]);
         $page->Fields["strPassword"]->Label = "New Password";
         $page->Fields["strPassword"]->html->name = "strPassword";
         $page->Fields["strPassword"]->html->id = "strPassword";
         $page->Fields["strPassword"]->html->value = "";
         $page->Fields["strPassword"]->Type = "password";
         $page->Fields["strPassword"]->html->autocomplete = "off";
         $page->Fields["strPassword"]->html->onchange = "if($('#strPassword').val() != $('#strPasswordConfirm').val() && $('#strPasswordConfirm').val() != ''){ alert('Passwords do not match.');}";
         $page->Fields["strPassword"]->Order = 1;
         $page->Fields["strPassword"]->Tab ="Security";

         //Build strPasswordConfirm Element
         $page->Fields["strPasswordConfirm"] = nCopy($page->Fields["strPassword"]);
         $page->Fields["strPasswordConfirm"]->Label = "Confirm Password";
         $page->Fields["strPasswordConfirm"]->COLUMN_NAME = "strPasswordConfirm";
         $page->Fields["strPasswordConfirm"]->html->name = "strPasswordConfirm";
         $page->Fields["strPasswordConfirm"]->html->id = "strPasswordConfirm";
         $page->Fields["strPasswordConfirm"]->html->onchange = "if($('#strPassword').val() != $('#strPasswordConfirm').val() && $('#strPassword').val() != ''){ alert('Passwords do not match.');}";
         $page->Fields["strPasswordConfirm"]->Order = 2;
         $page->Fields["strPasswordConfirm"]->Tab ="Security";

         $page->Fields["refSecurityGroupID"]->Tab =
         $page->Fields["strUser"]->Tab =
         $page->Fields["strEmail"]->Tab =
         $page->Fields["blnActive"]->Tab =
         $page->Fields["strTel"]->Tab =
         $page->Fields["strFirstUser"]->Tab =
         $page->Fields["dtFirstEdit"]->Tab ="Details";

         ## ALL THE FIELDS UNDER Profile Picture TAB
         $page->Fields["Profile:PicturePath"]->Label = "Profile Picture";
         $page->Fields["Profile:PicturePath"]->Type="file";
         $page->Fields["Profile:PicturePath"]->ID =
         $page->Fields["Profile:PicturePath"]->Name = $UserID;
         $page->Fields["Profile:PicturePath"]->ajaxFunction = "UploadProfilePicture";
         $page->Fields["Profile:PicturePath"]->strPath = $page->SystemSettings["ProfileImageDirAdmin"];
         $page->Fields["Profile:PicturePath"]->ajaxParams = "&UserID=". $UserID;
         $page->Fields["Profile:PicturePath"]->Tab = "Profile Picture";

         $page->Fields["strPasswordMD5"]->Type = "hidden";
         unset($page->Fields["dtFirstEdit"]);
         unset($page->Fields["strFirstUser"]);
         unset($page->Fields["strPasswordMD5"]);
         unset($page->Fields["strSetting:Language"]);

         $page->renderControls();
         $page->ContentBootstrap[0]["col-md-6"] = $page->renderTabs($page->ToolBar->Label) . $page->getJsZoriValidateSave($JS);
      break;

      case "Export":
         $page = new User("");
         $page->isPageable = 0;
         $page->Content = $page->getList();
         $page->renderExcel($page->Entity->Name);
      break;

      default:
         $page = new User(array("UserID"));
         $page->isPageable = 1;
         $page->isSortable = 0;
         $page->ContentBootstrap[0]["col-md-10"] = $page->getList();
         break;
   }

   $page->Message->Text = $Message;
   $page->Display();
?>

 