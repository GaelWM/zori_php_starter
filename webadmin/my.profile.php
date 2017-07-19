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

   $page->Fields["refSecurityGroupID"]->Control->value = $xdb->getRowSQL("SELECT strSecurityGroup FROM sysSecurityGroup WHERE SecurityGroupID = '". $page->Fields["refSecurityGroupID"]->VALUE ."'")->strSecurityGroup;
   $page->Fields["refSecurityGroupID"]->Control->tag = "label";
   $page->Fields["refSecurityGroupID"]->Control->class = "controlText controlLabel";

   $page->Fields["strUser"]->Control->readonly = "readonly";
   $page->Fields["strUser"]->Control->class = "controlText controlLabel";

   $page->Fields["strEmail"]->Control->readonly = "readonly";
   $page->Fields["strEmail"]->Control->class = "controlText controlLabel";

   //change strPassword to type=password
   $page->Fields["strPassword"]->Control->tag = "input";
   $page->Fields["strPassword"]->Control->type = "password";
   $page->Fields["strPassword"]->ORDINAL_POSITION = $page->Fields["strEmail"]->ORDINAL_POSITION +0.1;
   $page->Fields["strOldPassword"] = nCopy($page->Fields["strPassword"]);

   $page->Fields["strOldPassword"]->Control->name = "strOldPassword";
   $page->Fields["strOldPassword"]->Control->id = "strOldPassword";
   $page->Fields["strOldPassword"]->Control->value = "";
   $page->Fields["strOldPassword"]->jsValidate = "";
   $page->Fields["strOldPassword"]->ControlHTML = "";
   $page->Fields["strOldPassword"]->COLUMN_NAME = "strOldPassword";
   $page->Fields["strOldPassword"]->Label = "Old Password";
   $page->Fields["strOldPassword"]->Control->autocomplete = "off";

   $page->Fields["strPassword"]->Control->value = "";
   $page->Fields["strPassword"]->Label = "New Password";
   $page->Fields["strPassword"]->ControlHTML = "";
   $page->Fields["strPassword"]->ORDINAL_POSITION += 0.1;
   $page->Fields["strPassword"]->Control->autocomplete = "off";

   //add strConfirmPassword
   $page->Fields["strPasswordConfirm"] = nCopy($page->Fields["strPassword"]);
   $page->Fields["strPassword"]->Control->onchange = "d('strPasswordConfirm').value = '';";

   $page->Fields["strPasswordConfirm"]->Label = "Confirm Password";
   $page->Fields["strPasswordConfirm"]->Control->name = "strPasswordConfirm";
   $page->Fields["strPasswordConfirm"]->Control->id = "strPasswordConfirm";
   $page->Fields["strPasswordConfirm"]->jsValidate = "if(d('strPassword').value != d('strPasswordConfirm').value){ msg += '\\nPasswords do not match.'; d('strPassword').value = d('strPasswordConfirm').value = '';}";
   $page->Fields["strPasswordConfirm"]->ORDINAL_POSITION += 0.1;

   $page->Fields["strPasswordMD5"]->jsValidate = "";
   $page->Fields["strPasswordMD5"]->Control->type = "hidden";

   $page->Fields["Profile:PicturePath"]->Control->type = "file";
   $page->Fields["Profile:PicturePath"]->Control->class = "controlText controlFile";
   $page->Fields["Profile:PicturePath"]->jsValidate = "";

   $profilePic = "<img src = '". $page->SystemSettings[ProfileImageDirAdmin].$page->Fields["Profile:PicturePath"]->VALUE ."' title='". $page->Fields["strDisplayName"]->VALUE ."' target=_blank />
      ";//onLoad='positionProfilePic(this)';

   $JS = js("
      function jsValidateCustom()
      {

         var msg = '';
         var error = 0;

         if( d('strOldPassword').value == '' )
         {
            msg += '\\n Please enter your old password and try again.';
            d('strPassword').value = d('strPasswordConfirm').value = '';
            error = 1;
         }

         if(d('strPassword').value != d('strPasswordConfirm').value)
         {
            msg += '\\n The new password and confirm password do not match each other. Please try again.';
            d('strPassword').value = d('strPasswordConfirm').value = '';
            error = 1;
         }
         else if(d('strPassword').value == '')
         {
            msg += '\\n Password field cannot be empty.';
            d('strPassword').value = d('strPasswordConfirm').value = '';
            error = 1;
         }

         if(error == 1)
         {
            alert(msg);
            return false;
         }
         else
         {
            return true;
         }

      }
         ");

   $page->ToolBar->Buttons[btnSave]->Control->onclick = "return jsValidateCustom();";
   $page->ToolBar->Buttons[btnExport]->blnShow = 0;
   $page->ToolBar->Buttons[btnReload]->blnShow = 0;
   $page->ToolBar->Buttons[btnClose]->blnShow = 0;

   $page->intColumns = 1;
   //Hide unnecessary fields
   //unset($page->Fields["UserID"],$page->Fields["refSecurityGroupID"],$page->Fields["blnActive"]);

   $page->renderControls();

   $page->ContentBootstrap[0]["col-md-6"] = $JS.$page->renderForm($page->ToolBar->Label);
   $page->ContentBootstrap[1]["col-md-2"] = $profilePic;
   // $page->ContentLeft = $page->renderTable($page->ToolBar->Label) . $page->getJsZoriValidateSave()
   //    ."<i>*Note that updating your email address or password will update your details in the celestis webadmin where the email address is an exact match!</i>";

   $page->Message->Text = $Message;

   $page->Display();
?>
