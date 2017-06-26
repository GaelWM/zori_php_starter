<?php
	 /*---------------- ADMIN MAIN LAYOUT --------------------------*/
	 
	include_once("layouts/header.incl.php");
	// global $SystemSettings;
	// print_rr($this->SystemSettings);die("dfgdysy");

	// echo "
	// 	<body>
	// 		<form name='frmZori' enctype='multipart/form-data' action='".$SystemSettings[FULL_PATH]."' method='post'>
	// 			<div class='container-fluid display-table' style='background-color:#2f4050' >
	// 				<div class='row display-table-row'>
	// 					<div class='col-md-12 col-sm-6 display-table-cell ZoriBasic'>
	// 						<div class='row'>
	// 							<header id='nav-header' class='clearfix'>$this->HEADER</header>
	// 						</div>
	// 						<div class='success-message'>
	// 							<div id='' class='login-div col-lg-3'>
	// 								".$this->ContentBox()."
	// 							</div>
	// 						</div>
							
	// 						<div class='row'>
	// 							$this->FOOTER
	// 						</div>
	// 					</div>
	// 				<div>
	// 			</div>
	// 		</form>
	// 	</body>
	// </html>";

	echo "<body class='login'>
      <form name='frmNemo' enctype='multipart/form-data' action='". $this->SystemSettings[FULL_PATH] ."' method='post'>
      <!-- Header section ----------------------------------------------------------------------------------------------------------->        
         <div class='top_nav'>
            <div class='nav_menu' style='padding-left:10px;'> ". $this->getHeader() ."</div> 
            " . $this->Message() . "
         </div> 
         <div style='clear:both;'></div>
      <!-- Content section ---------------------------------------------------------------------------------------------------------->                 
         ".$this->ContentBox()."

      <!-- Footer section ----------------------------------------------------------------------------------------------------------->                 
         <footer class='clearfix footer_fixed' style='position:absolute; bottom:0px; left:0px; width:100%; margin-left:0px;'> 
            <div class='pull-left'><p style='margin:8px 0px 0px 0px;'>©2016 All Rights Reserved | Silicon Overdrive | Privacy and Terms</p></div>
            <div class='pull-right'> <img src='images/siliconLogo.png' height='35px;' />  </div>
            <div class='clearfix'></div>
         </footer>
         <!--<button class='btn btn-default source' onclick='jsPNotify(\"success\", \"test\");'>Success</button> -->
      </body> 

      <!-- PNotify -->
         <script>
            function jsPNotify(type, msg)
            {
               new PNotify({
                  title: 'Regular Success',
                  text: msg,
                  type: type,
                  styling: 'bootstrap3'
               });
            } 
         </script> 
      </form>
   </body>
</html>";

## FOOTER (CONTAINS CSS AND JAVASCRIP INCLUDES)
include_once("footer.incl.php");

?>