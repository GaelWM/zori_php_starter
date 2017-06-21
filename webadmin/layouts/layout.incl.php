<?php
	//  /*---------------- ADMIN MAIN LAYOUT --------------------------*/
	 
	// include_once("layouts/header.incl.php");
	// // global $SystemSettings;
	// // print_rr($this->SystemSettings);die("ICI");

	// echo "
	// 	<body>
	// 		<form name='frmZori' enctype='multipart/form-data' action='".$this->SystemSettings[FULL_PATH]."' method='post' style='height:100%;'>
	// 		<div class='container-fluid display-table'>
	// 			<div class='row display-table-row'>
	// 				<div class='col-md-2 col-sm-1 hidden-xs display-table-cell valign-top' id='sidenav'>
	// 					".$this->getMenu()."
	// 				</div>
	// 				<div class='col-md-10 col-sm-11 display-table-cell valign-top'>
	// 					<div class='row'>
	// 						<header id='nav-header' class='clearfix'>".$this->getHeader()."</header>
	// 					</div>
	// 					<div id='toolbar' class=''>
	// 						".$this->Toolbar()."
	// 					</div>
	// 					<div style='padding-top:10px;'>
	// 						".$this->getMessage()."
	// 					</div>
	// 					<div> ".$this->ContentBox()."</div>
	// 					<div style='padding-top:30px;'></div>
	// 					<div class='row'>
	// 						".$this->getFooter()."
	// 					</div>
	// 				</div>
	// 			<div>
	// 		</div>
	// 	</form>
	// </body>
	// </html>";

## HEADER (CONTAINS CSS AND JAVASCRIP INCLUDES)
include_once("header.incl.php");

echo "
   <body class='nav-md'>
      <div class='container body'>
         <div class='main_container'>
            <div class='col-md-3 left_col'> 
               <div class='left_col scroll-view'>                
				<!-- logo section -->
                  <div class='navbar nav_title' style='border: 0;'> <a href='index.html' class='site_title'><i class='fa fa-paw'></i> <span>Gentellela Alela!</span></a> </div> 
                  <div class='clearfix'></div>

				<!-- menu profile quick info -->
                  <div class='profile clearfix'>
                     " . $this->MenuProfileInfo() . " 
                  </div> 
                  <br />

				<!-- sidebar menu -->
                  <div id='sidebar-menu' class='main_menu_side hidden-print main_menu'> ". $this->getMenu() ." </div>
 
				<!-- sidebar footer buttons -->             
                  <!-- <div class='sidebar-footer hidden-small'>
                  <a data-toggle='tooltip' data-placement='top' title='Settings'> <span class='glyphicon glyphicon-cog' aria-hidden='true'></span> </a>
                  <a data-toggle='tooltip' data-placement='top' title='FullScreen'> <span class='glyphicon glyphicon-fullscreen' aria-hidden='true'></span> </a>
                  <a data-toggle='tooltip' data-placement='top' title='Lock'> <span class='glyphicon glyphicon-eye-close' aria-hidden='true'></span> </a>
                  <a data-toggle='tooltip' data-placement='top' title='Logout'> <span class='glyphicon glyphicon-off' aria-hidden='true'></span> </a>
                  </div> -->
               </div> 
            </div> 

			<!-- top header bar -->
            <div class='top_nav' style=''> ". $this->getHeader() ." </div>

			<!-- message section -->
            <div class='right_col' role='main' style=''>
               <form name='frmNemo' enctype='multipart/form-data' action='". $this->SystemSettings[FULL_PATH] ."' method='post' novalidate> 
                  <div class=''> 

				<!-- Toolbar Section -------------->         
	            <div id='messageDiv' style='margin-left:-20px;'>".$this->getMessage()."</div>
	            <div class='' role='alert' id='messageID' style='display:none; margin-left:-20px;'>
	                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='position:relative; float:right; width: 40px;'><span aria-hidden='true'>×</span>
	                </button>
	                <strong></strong>
	            </div>
	            ".$this->ToolBar()."
	            <div class='clearfix'></div> 

				<!-- site content area -->
                     <div class='row'> ".$this->ContentBox()." </div>
                  </div>
               </form>
            </div>

			<!-- footer section -->
            <footer class='clearfix footer_fixed'>
               <div class='pull-left'><p style='margin:8px 0px 0px 0px;'>©2016 All Rights Reserved | Silicon Overdrive | Privacy and Terms</p></div>
               <div class='pull-right'> <img src='images/siliconLogo.png' height='35px;' />  </div>
               <div class='clearfix'></div>
            </footer>
         </div>
      </div>";

      ## FOOTER (CONTAINS CSS AND JAVASCRIP INCLUDES)
include_once("footer.incl.php");
   echo "</body> 
</html>";

?>