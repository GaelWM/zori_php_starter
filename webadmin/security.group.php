<?php
    include_once ("_framework/_zori.cls.php");
    include_once ("_framework/_zori.details2.cls.php");
    include_once ("includes/security.group.cls.php");
    
  	$page = new Zori("SECURITY GROUP");

  	switch($Action)
   	{
      case "Reload":
         windowLocation("?Action=Edit&SecurityGroupID=$SecurityGroupID");
         break;
      case "Save":
         $Message = SecurityGroup::Save($SecurityGroupID);
         break;
      case "Delete":
         $Message = SecurityGroup::Delete($_POST[chkSelect]);
         break;
   }
	//nav
   switch($Action)
   {
      case "Save":
      case "Edit":
      case "New":
        $page = new ZoriDetails();
        $page->Message->Text = $Message;
        $page->AssimulateTable("sysSecurityGroup", $SecurityGroupID);
        //$page->Fields["SecurityGroupID"]->Control->type = "hidden";

        $page->renderControls();
        $page->ContentBootstrap[0]["col-md-3"] = $page->renderForm($page->ToolBar->Label) . $page->getJsZoriValidateSave();

        if($Action != "New")
          $page->ContentBootstrap[1]["col-md-9"] = SecurityGroup::getSecurityEntities($SecurityGroupID);

        break;
      default:
	    $page = new SecurityGroup(array("SecurityGroupID"));
	    $page->ContentBootstrap[0]["col-md-14"] = $page->getList($SecurityGroupID);
   }

   $page->Display();
   
?>