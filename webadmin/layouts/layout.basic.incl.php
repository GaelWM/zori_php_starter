<?php
	 /*---------------- ADMIN MAIN LAYOUT --------------------------*/
	 
	include_once("layouts/header.incl.php");
	// global $SystemSettings;
	// print_rr($this->SystemSettings);die("dfgdysy");

	echo "
		<body>
			<form name='frmZori' enctype='multipart/form-data' action='".$SystemSettings[FULL_PATH]."' method='post'>
				<div class='container-fluid display-table' style='background-color:#2f4050' >
					<div class='row display-table-row'>
						<div class='col-md-12 col-sm-6 display-table-cell ZoriBasic'>
							<div class='row'>
								<header id='nav-header' class='clearfix'>$this->HEADER</header>
							</div>
							<div class='success-message'>
								<div id='' class='login-div col-lg-3'>
									".$this->ContentBox()."
								</div>
							</div>
							
							<div class='row'>
								$this->FOOTER
							</div>
						</div>
					<div>
				</div>
			</form>
		</body>
	</html>";

?>