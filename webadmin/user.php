<?php
   ini_set('display_errors', '1');
   error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);

   
   include_once("_framework/_zori.cls.php");
   include_once("_framework/_zori.control2.php");
   include_once("_framework/_zori.details2.cls.php");
   include_once("includes/user.cls.php");

   $page = new Zori();

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
         $page = new ZoriDetails();
         $page->AssimulateTable("sysUser", $UserID, "strUser");
         //print_rr($page->Fields);

         $page->Fields["UserID"]->Control->type = "hidden";
         $page->Fields["UserID"]->Control->comment = "";
         
         //Build strPassword Element
         $page->Fields["strPassword"] = nCopy($page->Fields["strPasswordMD5"]);
         $page->Fields["strPassword"]->Label = "New Password";
         $page->Fields["strPassword"]->COLUMN_NAME = "strPassword";
         $page->Fields["strPassword"]->Control->name = "strPassword";
         $page->Fields["strPassword"]->Control->id = "strPassword";
         $page->Fields["strPassword"]->Control->value = "";
         $page->Fields["strPassword"]->jsValidate = "";
         $page->Fields["strPassword"]->Control->tag = "input";
         $page->Fields["strPassword"]->Control->type = "password";
         $page->Fields["strPassword"]->Control->autocomplete = "off";
         $page->Fields["strPassword"]->Control->class = "form-control input-sm";
         $page->Fields["strPassword"]->Control->onchange = "if($('#strPassword').val() != $('#strPasswordConfirm').val() && $('#strPasswordConfirm').val() != ''){ alert('Passwords do not match.');}";
         $page->Fields["strPassword"]->ControlHTML = "";
         $page->Fields["strPassword"]->ORDINAL_POSITION = $page->Fields["strEmail"]->ORDINAL_POSITION +0.1;

         //Build strPasswordConfirm Element
         $page->Fields["strPasswordConfirm"] = nCopy($page->Fields["strPassword"]);
         $page->Fields["strPasswordConfirm"]->Label = "Confirm Password";
         $page->Fields["strPasswordConfirm"]->COLUMN_NAME = "strPasswordConfirm";
         $page->Fields["strPasswordConfirm"]->Control->name = "strPasswordConfirm";
         $page->Fields["strPasswordConfirm"]->Control->id = "strPasswordConfirm";
         $page->Fields["strPasswordConfirm"]->Control->onchange = "if($('#strPassword').val() != $('#strPasswordConfirm').val() && $('#strPassword').val() != ''){ alert('Passwords do not match.');}";
         $page->Fields["strPasswordConfirm"]->ORDINAL_POSITION = $page->Fields["strEmail"]->ORDINAL_POSITION +0.2;

         $page->Fields["strPasswordMD5"]->jsValidate = "";
         $page->Fields["strPasswordMD5"]->Control->type = "hidden";
  
         $page->Fields["Profile:PicturePath"]->Control->type = "file";
         $page->Fields["Profile:PicturePath"]->Control->class = "btn btn-default btn-file";
         $page->Fields["Profile:PicturePath"]->jsValidate = "";

         $profilePic = "
         <div class = 'thumbnail ' style='width:350px; height:250px;'>
            <img src = '". $page->SystemSettings[ProfileImageDirAdmin].$page->Fields["Profile:PicturePath"]->VALUE ."' title='". $page->Fields["strDisplayName"]->VALUE ."' target=_blank onLoad='positionProfilePic(this);' />
         </div>";

         $JS =  "if( $('#strPassword').val() != $('#strPasswordConfirm').val())
                  { 
                     msg += '\\nNew password and confirm password (do not match)'; 
                  }
               " ;
         //print_rr($page->ToolBar->Buttons);
         $page->renderControls();
         $page->ContentBootstrap[0]["col-md-6"] = $page->renderForm($page->ToolBar->Label) . $page->getJsZoriValidateSave($JS);
      break;

      default:
         $page = new User(array("UserID"));
         $page->isPageable = 1;
         $page->Content = $page->getList();
         break;
   }

   $page->Message->Text = $Message;
   $page->Display();
?>

 