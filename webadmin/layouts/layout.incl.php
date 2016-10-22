<?php
	 /*---------------- ADMIN MAIN LAYOUT --------------------------*/
	 
	include_once("layouts/header.incl.php");
	// global $SystemSettings;
	// print_rr($this->SystemSettings);die("ICI");

	echo "
		<body>
			<form name='frmZori' enctype='multipart/form-data' action='".$this->SystemSettings[FULL_PATH]."' method='post' style='height:100%;'>
			<div class='container-fluid display-table'>
				<div class='row display-table-row'>
					<div class='col-md-2 col-sm-1 hidden-xs display-table-cell valign-top' id='sidenav'>
						".$this->getMenu()."
					</div>
					<div class='col-md-10 col-sm-11 display-table-cell valign-top'>
						<div class='row'>
							<header id='nav-header' class='clearfix'>".$this->getHeader()."</header>
						</div>
						<div id='toolbar' class=''>
							".$this->Toolbar()."
						</div>
						<div style='padding-top:10px;'>
							".$this->getMessage()."
						</div>
						<div> ".$this->ContentBox()."</div>
						<div style='padding-top:30px;'></div>
						<div class='row'>
							".$this->getFooter()."
						</div>
					</div>
				<div>
			</div>
		</form>
	</body>
	</html>";

?>