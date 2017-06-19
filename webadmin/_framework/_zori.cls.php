<?php
	/**
	* By Gael Musikingala 20160919 //20161115 -- GAEL [Code Reviewed]
	*/
	include_once ("systems.php");
   include_once("_framework/_zori.basic.cls.php");
	include_once("_framework/_zori.menu.cls.php");

	class Zori extends ZoriBasic
	{
      public $SystemSettings = array();
		private $MENU;
		private $HEADER;
		private $FOOTER;

		public $ToolBar;
      public $Title;
      public $Content;
		public $Entity;
		public $LastVisited = array();
		public $db;
      public $controls;

      protected $Buttons = array();

		function __construct($title="")
      {
         //ini
         global $SystemSettings;

         parent::__construct();

         // SETTING THE TITLE OF THE PAGE gael 20161004
         foreach ($SystemSettings as $key => $value) {
            $this->SystemSettings[$key] = $value;
         }

         $this->Title = $title;
			if(!isset($_SESSION[USER] )){
		    	windowLocation('login.php');
            exit();
		   }

   	   $this->setDB();
   	   
		   $this->iniSecurity(); //must be after $_SESSION load
      	$this->iniSort();
      	$this->iniFilters();
      	$this->iniLastVisited();
      	$this->iniToolbar();
      	$this->iniPaging();

         $this->controls = new ZoriControl();
		}

		public function setDB(){
			$this->db = new ZoriDatabase("",null,null,0);
		}

		public function getMenu()
      {
			$this->MENU = new ZoriMenu();
			$this->MENU->BuildMenu();

         return $this->MENU->getControl();
		}

		public function  getHeader()
      {
         global $_LANGUAGE, $_TRANSLATION, $BR, $xdb;

         $db = "";
         if($this->SystemSettings[SERVER_NAME] == "localhost"){
            global $DATABASE_SETTINGS;
            $db = ": ". $DATABASE_SETTINGS["localhost"]->database;
         }

         if(is_array($_LANGUAGE) && $_TRANSLATION[$_SESSION[USER]->LANGUAGE]["lblLogout"] != ""){
            $lblLogout = $_TRANSLATION[$_SESSION[USER]->LANGUAGE]["lblLogout"];
         }else{
            $lblLogout = "Log out";
         }

         if(is_array($_LANGUAGE))
         {
            $header .= "<div style='position:relative; float:right; padding-left:20px; margin-top:8px;' align='right'>";
            foreach ($_LANGUAGE as $Lang => $obj) {
               if($obj->IconHTML)
               {
                  $lang = "<img ". ZoriControl::renderAttributes($obj->IconHTML) ." />";
               }else{
                  $lang = $obj->strLanguage;
               }
               $header .= "<a href='#' onclick=\"setLanguage('". $this->SystemSettings[FULL_URL] ."','$obj->strLanguage')\">
                              <div class='langBtn'>  $lang $BR $obj->strLanguage</div>
                           </a>";
            }
            $header .= " <div style='clear:both;'></div></div>";

         }

         if(isset($_SESSION[USER]->ID))
         {
            $row = $xdb->getRowSQL("SELECT `Profile:PicturePath` AS ProfilePicture, strUser FROM sysUser WHERE UserID = " . $_SESSION[USER]->ID, 0);
            $profilePicture = ($row->ProfilePicture == "" ? "blank.jpg" : $row->ProfilePicture);
            $userName = $row->strUser;
         }
         else
         {
           $profilePicture = "blank.jpg";
           $userName = "Guest";
         }
         
			$header .=
			"	
				<nav class='navbar-default pull-left'>
					<div style='position:relative; float:left; width:40px !important; padding-top:10px;' class='nav toggle'> <a id='menu_toggle' onClick='jsHideMenu();'><i class='fa fa-bars'></i></a>  </div>
               <div style='position:relative; float:left; width:100px !important; padding-top:10px;' class='nav toggle'> <a id='menu_toggle' onClick='jsHideFilters();'><i style='font-size:20px; padding:2px;' class='fa fa-filter'></i>Filters</a> </div>
				</nav>
				
				<div class='col-md-10'>
               <input type='text' class='hidden-sm hidden-xs' id='header-search-field' name='search' 
               placeholder='Search for something ...'/>
					<ul class='pull-right'>
						<li id='welcome' class='hidden-xs' >Welcome to your administration area</li>
						<li class='fixed-width'>
							<a href='#'>
							<span class='glyphicon glyphicon-bell' aria-hidden='true'></span></a>
							<span class='label label-warning' >3</span>
						</li>
						<li class='fixed-width'> 
							<a href='#'>
							<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span></a>
							<span class='label label-message'>3</span>
						</li>
                  <li style='height:20px;' class='dropdown'>
                     <a href='#' class='user-profile dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
                       <img src='profilepictures/" . $profilePicture . "' alt=''>" . $userName . "
                       <span class=' fa fa-angle-down'></span>
                     </a>
                     <ul class='dropdown-menu dropdown-usermenu pull-right'>
                       <li><a href='my.profile.php'> Profile</a></li>
                       <li><a href='faq.console.php'>Help</a></li>
                       <li><a href='login.php'><i class='fa fa-sign-out pull-right'></i> Log Out</a></li>
                     </ul>
                  </li>
					</ul>
               <script>
                  $(document).ready(function() {
                     FilterStatus = localStorage.getItem('filter');
                     MenuStatus = localStorage.getItem('menu');

                     if(FilterStatus == '') { localStorage.setItem('filter', 'show'); }
                     if(MenuStatus == '') { localStorage.setItem('menu', 'show'); }

                     $('.side-menu').find('active').find('.child_menu').css( 'background-color', 'red' );

                     if(FilterStatus == 'show'){
                        $('#pageFilters').parent().parent().show(1);
                        $('.col-md-12').addClass('col-md-10');
                        $('.col-md-12').removeClass('col-md-12');
                     }
                     else if(FilterStatus == 'hidden'){
                        $('#pageFilters').parent().parent().hide(1);
                        $('.col-md-10').addClass('col-md-12');
                        $('.col-md-10').removeClass('col-md-10');
                     }
                  });

                  function jsHideMenu()
                  {
                     bodyClass = $('body').attr('class');
                     if(bodyClass == 'nav-md')
                     {
                        localStorage.setItem('menu', 'hidden');
                     }
                     else if(bodyClass == 'nav-sm')
                     {
                        localStorage.setItem('menu', 'show');
                     }
                  }

                  function jsHideFilters()
                  {
                     if($('#pageFilters').is(':visible') ){
                        $('#pageFilters').parent().parent().hide(1);
                        $('.col-md-10').addClass('col-md-12');
                        $('.col-md-10').removeClass('col-md-10');
                        localStorage.setItem('filter', 'hidden');
                     }
                     else{
                        $('#pageFilters').parent().parent().show(1);
                        $('.col-md-12').addClass('col-md-10');
                        $('.col-md-12').removeClass('col-md-12');
                        localStorage.setItem('filter', 'show');
                     }
                  }
                </script>

				</div>
			";
         $this->HEADER = $header;
			return $this->HEADER;
		}

      protected function MenuProfileInfo()
      {
         global $xdb;

         if(isset($_SESSION[USER]->ID))
         {
           $row = $xdb->getRowSQL("SELECT `Profile:PicturePath` AS ProfilePicture, strUser FROM sysUser WHERE UserID = " . $_SESSION[USER]->ID, 0);
           $profilePicture = ($row->ProfilePicture == "" ? "blank.jpg" : $row->ProfilePicture);
           $userName = $row->strUser;
         }
         else
         {
           $profilePicture = "blank.jpg";
           $userName = "Guest";
         }

         return "<div class='profile_pic'> <img src='profilepictures/" . $profilePicture . "' alt='...' class='img-circle profile_img'> </div>
               <div class='profile_info'> <span>Welcome,</span> <h2>" . $userName . "</h2></div>";
      }

		public function Content($html)
      {
			$this->CONTENT .= $html;
			return $this->CONTENT;
		}

		public function getFooter()
		{
         //ini
         global $SystemSettings;

			$this->FOOTER =
			"
				<footer class='clearfix footer_fixed' style='position:absolute; bottom:0px; left:0px; width:100%; margin-left:0px;'>
					<div class='pull-left'><b>".$SystemSettings[MadeBy]."</b></div>
					<div class='pull-right'><b>".$SystemSettings[Copyright]."</b>
               ".$SystemSettings[CopyrightSymbolYear]."</div>
				</footer>
			";
			return $this->FOOTER;
		}

		public function Display($index=""){
      	if(empty($index)){
         	include "layouts/layout.incl.php";
      	}else{
            include " ".$index.".php ";
         }
   	}


		protected function iniToolbar()
   	{
      	$this->Buttons[btnPreview]->Control->class = "btn btn-default";
      	$this->Buttons[btnPreview]->Control->value = "Preview";
      	$this->Buttons[btnPreview]->Icon->class= ""; 

     	
	      $this->Buttons[btnReload]->Control->class = "btn btn-default";
	      $this->Buttons[btnReload]->Control->value = "Reload";
	      $this->Buttons[btnReload]->Icon->class= "glyphicon glyphicon-refresh"; 

      	$this->Buttons[btnNew2]->Control->class = "btn btn-success";
      	$this->Buttons[btnNew2]->Control->value = "New";
      	$this->Buttons[btnNew2]->Icon->class= "glyphicon glyphicon-plus"; 

      	$this->Buttons[btnNew]->Control->class = "btn btn-primary";
      	$this->Buttons[btnNew]->Control->value = "New";
      	$this->Buttons[btnNew]->Icon->class= "glyphicon glyphicon-plus"; 

      	$this->Buttons[btnDelete]->Control->class = "btn btn-danger";
	      $this->Buttons[btnDelete]->Control->value = "Delete";
	      $this->Buttons[btnDelete]->Control->onclick = "return confirm(\"Are you sure you want to delete ". $this->Entity->Name ."(s) and related entities?\");";
	      $this->Buttons[btnDelete]->Icon->class = "glyphicon glyphicon-trash"; 

	      $this->Buttons[btnRevert]->Control->class = "btn btn-default";
	      $this->Buttons[btnRevert]->Control->value = "Revert";
	      $this->Buttons[btnRevert]->Control->onclick = "";
	      $this->Buttons[btnRevert]->Icon->class = "glyphicon glyphicon-arrow-left"; 

	      $this->Buttons[btnRevert2]->Control->class = "btn btn-default";
	      $this->Buttons[btnRevert2]->Control->value = "Revert2";
	      $this->Buttons[btnRevert2]->Control->onclick = "";
	      $this->Buttons[btnRevert2]->Icon->class = "glyphicon glyphicon-arrow-left"; 

	      $this->Buttons[btnSend]->Control->class = "btn btn-default";
	      $this->Buttons[btnSend]->Control->value = "Send";
	      $this->Buttons[btnSend]->Icon->class = "glyphicon glyphicon-send"; 

       	$this->Buttons[btnSave]->Control->class = "btn btn-default";
      	$this->Buttons[btnSave]->Control->value = "Save";
      	$this->Buttons[btnSave]->Control->onclick = "return jsNemoValidateSave();";
      	$this->Buttons[btnSave]->Icon->class = "glyphicon glyphicon-floppy-save"; 


      	$this->Buttons[btnClose]->Control->class = "btn btn-default";
      	$this->Buttons[btnClose]->Control->value = "Close";
      	$this->Buttons[btnClose]->Icon->class = "glyphicon glyphicon-remove";    

      	$this->Buttons[btnExport]->Control->class = "btn btn-default";
      	$this->Buttons[btnExport]->Control->value = "Export";
      	$this->Buttons[btnExport]->Icon->class = "glyphicon glyphicon-circle-arrow-up"; 

      	//extra
      	$this->Buttons[btnNext]->Control->class = "btn btn-default";
      	$this->Buttons[btnNext]->Control->value = "Next";
      	$this->Buttons[btnNext]->Icon->class = "glyphicon glyphicon-forward"; 

      	$this->Buttons[btnBack]->Control->class = "btn btn-default";
      	$this->Buttons[btnBack]->Control->value = "Back";
      	$this->Buttons[btnBack]->Icon->class = "glyphicon glyphicon-backward"; 

      	$this->Buttons[btnHelp]->Control->class = "btn btn-default";
      	$this->Buttons[btnHelp]->Control->value = "Help";
      	$this->Buttons[btnHelp]->Icon->class = "glyphicon glyphicon-question-sign"; 

      	$this->Buttons[btnFinalize]->Control->class = "btn btn-default";
      	$this->Buttons[btnFinalize]->Control->value = "Finalize";
      	$this->Buttons[btnFinalize]->Icon->class = "glyphicon glyphicon-thumbs-up"; 

      	$counter = 1;
	      foreach($this->Buttons as $id => $control)
	      {
         	$this->ToolBar->Buttons[$id]->Control = nCopy($control->Control);
         	$this->ToolBar->Buttons[$id]->Control->id = $id;
         	$this->ToolBar->Buttons[$id]->Control->name = "Action";
         	$this->ToolBar->Buttons[$id]->Control->type = "submit";
         	$this->ToolBar->Buttons[$id]->Control->tag = "input";

         	$this->ToolBar->Buttons[$id]->Span = nCopy($control->Span);
        	   $this->ToolBar->Buttons[$id]->Span->tag = "span";
         	$this->ToolBar->Buttons[$id]->Span->title = $control->Control->value;

         	$this->ToolBar->Buttons[$id]->blnShow = $control->blnShow;
         	$this->ToolBar->Buttons[$id]->intOrder = $counter;

         	$counter++;
      	}
         //print_rr($this->ToolBar->Buttons);
         $this->ToolBar->Label = $this->Entity->Name;
	   }

	   protected function LastVisited()
	   {//gets called from layout
	      	$pipe = "";
	      	if(count($this->LastVisited) > 0){
		     	foreach($this->LastVisited as $idx => $Entity)
		      	{
		         	$strLastVisited .= "$pipe<a href='$Entity->URL'>$Entity->Name</a>";
		         	$pipe = " | ";
		      	}
	      	}
	      	return "
		      	<div id=divLastVisited>
		         	Last Visited: ". $strLastVisited ."
		      	</div class=Logout>";
	   }

      // protected function ToolBar()
      // {
      //    $strToolBar= "
	     //  	<div id='div-toolbar'>
	     //     	<div class='pull-left'>
		    //         <table style='margin-bottom:0px;'>
		    //            <tr> 
	     //              	<td align='center' style='border-right: 2px groove #1ab394; padding: 35px 100px 19px 15px;'>
	     //              		<span class='text-muted'>".$this->ToolBar->Label."</span>
	     //              	</td>
	     //              	<td style='position: relative; border: 0px dashed orange; padding: 0px;'>
	     //              		". $this->ToolBar->Block . $this->renderFilters() ."
	     //              	</td>
		    //            </tr>
		    //         </table>
	     //     	</div>
	     //     	<div class='pull-right'>
	     //        	". $this->renderToolbarButtons() ."
	     //     	</div>
	     //     	<div style='clear:both'></div>
	     //  	</div>
      // 	";
      //    $this->ToolBar = $strToolBar;

      //    return $this->ToolBar;
      // }

      protected function ToolBar()
      {
         //20170130 - removed ID and name from Tool bar heading label.
         $strToolBarHeading = strtok($this->ToolBar->Label, ":");

         return " <div class='page-title'>
                     <div class='title_left'>
                        <h3 style='margin:10px 0px 0px 0px;'>".  $strToolBarHeading ."<small> </small></h3><br>
                     </div>
                     <div class='title_right'>
                        <div class='col-md-5 col-sm-5 col-xs-12' style='float:right;'>
                           <div class='input-group' style='float:right;'>
                               ". $this->renderToolbarButtons() ."
                           </div>
                           <div style='clear:both;'></div>
                        </div>
                        <div style='clear:both;'></div>
                     </div>
                  </div>";
      }
      

      private function iniSecurity()
      {
   		global $SystemSettings, $xdb;
   	   $db = new ZoriDatabase("",null,null,0);

      	$rst = $db->doQuery("
      		SELECT sysMenuLevel2.strEntity AS Entity, sysMenuLevel2.strUrl AS Url, sysSecurity.blnView
            , sysSecurity.blnDelete, sysSecurity.blnSave, sysSecurity.blnNew, sysSecurity.blnSpecial
            FROM sysSecurity INNER JOIN sysMenuLevel2 ON sysSecurity.refMenulevel2ID = sysMenuLevel2.MenuLevel2ID
            WHERE sysSecurity.refSecurityGroupID=". $_SESSION[USER]->SECURITYGROUPID ."",0);

      	while($row = $db->fetch())
      	{
         	$this->Pages[$row->Url]->Security = $row;
         	$this->Pages[$row->Url]->Entity = $row->Entity;
      	}
         $this->Security = $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Security;

         //print_rr($this->SystemSettings);
         if($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Security->blnView != 1){
            if($_SESSION[intAttempt] > 5){
               $this->getMessage($this->SystemSettings[SCRIPT_NAME], "success");
            }
            else{
               $this->getMessage($this->SystemSettings[SCRIPT_NAME], "warning");
            }

            $_SESSION[intAttempt] += 1;
            //print_rr($this->Pages);
         }else{
            $_SESSION[intAttempt] = 0;
         }

         //set Entity
         $this->Entity->Name = $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Entity;
         $this->Entity->URL = $this->SystemSettings[FULL_URL];
      }

      private function iniSort()
      {
         //set sort
         if($_GET[exeClearSort] || $_REQUEST[Action] == "Clear")
         {
            unset($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Sort);
         }
         if($_GET[srtNew] != "")
         {
            $_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Sort[srtNew] = $_GET[srtNew];
            $_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Sort[srtCurrent] = $_GET[srtCurrent];
            $_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Sort[srtDir] = $_GET[srtDir];
         }

         //load sort
         if(count($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Sort) > 0){
         foreach($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Sort as $key => $value)
         {//? Do we care about other pages' filters at this point? no
            $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Sort[$key] = $value;
         }}
      }

      protected function iniFilters()
      {  /*notes: filters have 2 stages. stage 1, iniFilters, executes onConstruct of the Zori. stage 2, renderFilters(), executes onDisplay() of Zori
         *     : $this->Filters referst to the public Filters collection in the Child-Class, eg. Client->Filters
         *
         *
         */

         //save || delete session filters
         if(($_REQUEST[Action] == "Filter" || $_POST[Action] == "Run Report") && count($this->Filters) >0 )
         {//&& because $this->Filters doesn't have an ini value when $page = new Zori(), but has in $page = new Client() [extends Zori]
            foreach($this->Filters as $key => &$filter)
            {
               $_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Filters[$key] = $_REQUEST[$key];
            }//20110916 - changed post to request - pj
         }
         //print_rr($_SESSION[PAGES]);
         //print_rr($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Filters);
         if($_REQUEST[Action] == "Clear")
         {
            unset($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Filters);
         }

         //load filter values from session
         if(count($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Filters) > 0){
         foreach($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Filters as $key => $value)
         {//? Do we care about other pages' filters at this point? no
            $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Filters[$key] = $value;
         }}

         //build filter controls
         if(count($this->Filters)>0){
         foreach($this->Filters as $key => &$filter)
         {
            $filter->html->name = $filter->html->id = $key;
            if($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Filters[$key] != ""){//load filter value from session
               $filter->html->value = $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Filters[$key];
               if($filter->html->type == "checkbox")
                  $filter->html->checked = "checked";
            }

            if($filter->tag == "select"){//load options from sql
               $filter->html->innerHTML = $this->db->ListOptions($filter->sql, $filter->html->value);
            }

            //print_rr($this->Filters[$key]);
         }}
      }

      private function iniPaging()
      {//new 20111010
         if($_REQUEST[Action] == "Filter" || $_GET[exeClearSort] || $_REQUEST[Action] == "Clear" || $_GET[srtNew] != "")
         {//if new sorting, restart paging
            unset($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Paging);
         }

         if($_GET[pagPageNumber] != "")
         {
            $_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Paging[PageNumber] = $_GET[pagPageNumber];
         }

         if($_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Paging[PageNumber] < 1)
            $_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Paging[PageNumber] = 1;

         $this->Pages[$this->SystemSettings[SCRIPT_NAME]]->PageNumber = $_SESSION[PAGES]->Entity[$this->SystemSettings[SCRIPT_NAME]]->Paging[PageNumber];
      }

      // protected function renderFilters()
      // {//note $this->Filters referst to the public Filters collection in the Child-Class, eg. Client->Filters
      //    //print_rr($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Filters);
      //    global $SP, $BR;
      //    $strFilterControls = ""; 

      //    	if(count($this->Filters)>0){
      //       	$i = 0;
      //       	foreach($this->Filters as $key => &$filter){
      //          	$filter->ControlHTML = ZoriControl::renderControl($filter->tag, $filter->html);

   	  //           if($filter->tag == "hidden")
   	  //           {//20121204 - hiding hidden filter vars - pj
   	  //              $strFilterControls .= $filter->ControlHTML;
   	  //           }else{
   	  //              if($i % 3 == 0 && $i != 0)
   	  //              {
   	  //                 $strFilterControls .= "</tr><tr>";
   	  //              }
   	  //              $strFilterControls .= "
      //                   <td align=''>
      //                      <label style='color:#000;' for=\"$key\" class='label'>$SP$SP". ZoriDetails::cleanColumnName($key) .":</label>
      //                   </td>
      //                   <td align=''>". $filter->ControlHTML ."</td>
      //                ";
   	  //              $i++;
   	  //           }
      //       	}

      //       	$strFilterControls .= "
      //          	<td rowspan=2 valign=middle align=center ></td>";

   	  //        return "
   	  //        	<table class='tblBlank' style='margin-bottom: 0px; padding-top:0px;'>
   	  //        		<tr>$strFilterControls</tr>
   	  //        	</table>
      //         		</td>
      //          	<td nowrap>$SP$SP<input style='background:#fff;' type=submit name='Action' id='btnFilter' class='btn btn-default' value='Filter'>
      //           	$SP<input style='background:#fff;' type=submit name='Action' id='btnClear' class='btn btn-default' value='Clear'>"; //</td> ends outside in the calling function
      //    	}
      // }

      protected function renderFilters()
      {//note $this->Filters referst to the public Filters collection in the Child-Class, eg. Client->Filters
         //print_rr($this->Pages[$this->SystemSettings[SCRIPT_NAME]]->Filters);
         include_once("_zori.details.cls.php");
         include_once("_framework/_zori.control2.cls.php");

         global $SP, $BR, $_LANGUAGE, $_TRANSLATION;
   //INI
         $strFilterControls = "";
   //go:
         if(count($this->Filters)>0){//
            $i = 0;
            foreach($this->Filters as $key => &$filter)
            {

               $zc = ZoriProtoControl::__new($filter->Type, $key, $filter->VALUE, $filter->html, $blnRequired=0, $isSelected=$filter->VALUE, $arrOptions=null, $filter->sql, $filter->sqlGrouping);

               if($zc->Type == "hidden")
               {//20121204 - hiding hidden filter vars - pj
                  $strFilterControls .= $zc->HTML;
               }else{

                  if($filter->label != "" && $_TRANSLATION[$_SESSION[USER]->LANGUAGE][$key] != "")
                     $filter->label = $_TRANSLATION[$_SESSION[USER]->LANGUAGE][$key];

                  if($filter->label != "" && $_TRANSLATION[$_SESSION[USER]->LANGUAGE][$filter->label] != "")
                     $filter->label = $_TRANSLATION[$_SESSION[USER]->LANGUAGE][$filter->label];

                  if($filter->label == "")
                     $filter->label = $key;

            include_once("_framework/_zori.details2.cls.php");
                  $strFilterControls .= "
                     <div class='form-group'>
                        <label for=\"$key\" class='control-label col-xs-12'>". ZoriDetails::cleanColumnName($filter->label) .":<b class='textColour' style='font-size: 20px;'></b></label>
                        <div class='col-xs-12'>". $zc->HTML ."</div>
                     </div> ";
                  $i++;
               }
            }
         }
      }

      private function iniLastVisited()
      {

         if(count($_SESSION[LASTVISITED]) > 0){
         foreach($_SESSION[LASTVISITED] as $idx => $value){
            array_push($this->LastVisited, $value);
         }
         }

         if($this->Entity->Name != "")
         {
            $this->pushLastVisited($this->Entity);
         }

         if(count($this->LastVisited) > $this->SystemSettings[LastVisited])
         {
            while(count($this->LastVisited) > $this->SystemSettings[LastVisited])
            {
               array_pop($this->LastVisited);
            }
         }



      $_SESSION[LASTVISITED] = $this->LastVisited;

      //print_rr($_SESSION[LASTVISITED]);
      //print_rr($this->LastVisited);
      }

      protected function pushLastVisited($Entity)
      {
         $this->LastVisited = array_reverse($this->LastVisited);
         array_push($this->LastVisited, $Entity);
         $this->LastVisited = array_reverse($this->LastVisited);

         $_SESSION[LASTVISITED] = $this->LastVisited;
      }

      public function overrideLastVisited($Entity)
      {
         $this->LastVisited = array_reverse($this->LastVisited);
         array_pop($this->LastVisited);
         array_push($this->LastVisited, $Entity);
         $this->LastVisited = array_reverse($this->LastVisited);

         $_SESSION[LASTVISITED] = $this->LastVisited;

      }

      protected function renderToolbarButtons()
      {
         $ArrPageToolbar = array();
         foreach($this->ToolBar->Buttons as $id => $control)
         {

            if($control->blnShow == 1)
            {
               $ArrPageToolbar[$control->intOrder] = $control;
            }
         }
         ksort($ArrPageToolbar); 
         foreach($ArrPageToolbar AS $intOrder => $ToolbarItem)
         {
            $ToolbarItem->Control->class = $ToolbarItem->Control->class . " " . $ToolbarItem->Span->class;
            $button = ZoriControl::renderControlToolbar($ToolbarItem->Control->tag, $ToolbarItem->Control);
            //$span = NemoControl::renderControlToolbar($ToolbarItem->Span->tag, $ToolbarItem->Span);
             
            $toolbar .= "
            <td style='padding:3px;'> 
               $button
            </td >
            ";
         }

         return "
         <table>
            <tr>
               $toolbar
            </tr>
         </table>
         ";
      }

      public function getBrand()
      {
         global $_LANGUAGE, $_TRANSLATION;
         if(is_array($_LANGUAGE) && $_TRANSLATION[$_SESSION[USER]->LANGUAGE]["Brand"] != "")
            return $this->SystemSettings["Brand"] = $_TRANSLATION[$_SESSION[USER]->LANGUAGE]["Brand"];
         else
            return $this->SystemSettings["Brand"];
      }

      public function getTitle()
      {
         global $_LANGUAGE, $_TRANSLATION;
      
         if(is_array($_LANGUAGE) && $_TRANSLATION[$_SESSION[USER]->LANGUAGE]["Brand"] != "")
            return $this->SystemSettings["Brand"] = $_TRANSLATION[$_SESSION[USER]->LANGUAGE]["Brand"];
         else
            return $this->SystemSettings["Brand"]; 
      }

	}
?>