<?php
	include_once("layouts/header.incl.php");
	include_once("project.functions.php");

	//ini
	$HEADER = getHeader();
	$MENU = getMenu();
	$FOOTER = getFooter();
	$TOOLBAR = getToolbar();
	$SIDENAV = getSideNav();
	echo "
		<body>
			<form name='frmZori' enctype='multipart/form-data' action='' method='post'>
				<section id='MENU'>
					<div class='container'>".$MENU."<div>
				</section>
				<section id='HEADER'>
					<div class='container'>".$HEADER."</div>
				</section>
				<section id='TOOLBAR'>
					<div class='container'><div>".$TOOLBAR."</div></div>
				</section>
				<section id='CONTENT'>
					<div id='sidenav'>".$SIDENAV."</div>
					<div class='container'>".$CONTENT."</div>
				</section>
				<section>
					<div class='container'>".$CONTENT_LEFT."</div>
				</section>
				<section>
					<div class='container'>".$CONTENT_RIGHT."</div>
				</section>
				<section id='FOOTER'>
					<div class='container'></div>
					".$FOOTER."
				</section>
			</form>
		</body>
		</html>";

		function getMenu()
		{
			//ini
			$menu ="";

			//display
			$menu =
			"
				<div id='menu_wrapper'>
					<div id='menu_logo'>
						<img src='project_images/logo_starter.png' width='220' height='70'  alt='project_images/logo_starter.png' />
					</div>
					<div id='menu_two'>
						<a class='' href=''>Home</a>
					</div>
					<div id='menu_three'>
						<a href=''>Zori History</a>
					</div>
					<div id='menu_four'>
						<a href='symposium2015.php'>Zori Examples</a>
						<div id='menu_four_content'>
							<a style='display:none; visibility:hidden;' href='symposium2016.php'>▶ Symposium 2016</a>
							<a href='symposium2015.php'>▶ Zori Example 1</a>
							<br>
							<a href='symposium2014.php'>▶ Zori Example 2</a>
							<br>
							<a href='symposium2013.php'>▶ Zori Example 3</a>
							<br>
							<a href='symposium2012.php'>▶ Zori Example 4</a>
						</div>
					</div>
					<div id='menu_five'>
						<a class='' href=''>FAQs</a>
					</div>
					<div id='menu_six'>
						<a class='' href=''>About Us</a>
					</div>
					<div id='menu_seven'>
						<a class='' href=''>Contact Us</a>
					</div>
				</div>
			";
			return $menu;
		}// end function

		function getHeader()// builds the Header 
		{
			//ini
			$headerContent = "";

			$headerContent = "
			<div id=''>
			</div>
			";
			return $headerContent;
		}//end function

		function getFooter()// builds the Footer 
		{
			//ini
			$footer = "";

			$footer = 
			"
			<div id='divFooter'>
				<h6 style='float:left; color: #ffffff; padding:5px;'>Copyright DouDjiEm Corporation</h6>
				<h6 style='float:right; color: #ffffff; padding:5px;'>Developed by Dou Dji Em Corporation Entreprise</h6>
			</div>
			";

			return $footer;
		}//end function

		function getToolbar()// builds the Info 
		{
			//ini
			$toolbar = "";

			$toolbar = "
				<div class=''>
					<input type='text' class='search_box' name='keywords' placeholder='Search...' />
					<input type='button' class='toolbarButton' name='' value='Filter'  />
					<input type='button' class='toolbarButton' name='' value='Clear' />
					<div style=' width:30px; height:30px; float:right; margin:10px;' data-toggle='tooltip' title='Download'>
						<input type='image' class='toolbarDownloadButton' name='' src='project_images/download_icon.png' value='' />
					</div>
					<div style='width:30px; height:30px; float:right; margin:10px;' data-toggle='tooltip' title='Upload'>
						<input type='image' class='toolbarUploadButton' name='' src='project_images/upload_icon.png' value='' />
					</div>
					<div style='width:30px; height:30px; float:right; margin:10px;' data-toggle='tooltip' title='Export'>
						<input type='image' class='toolbarExportButton' name='' src='project_images/export_icon.png' value='' />
					</div>
				</div>
			";
			return $toolbar;
		}//end function

		function getLogin() // builds the Login 
		{
			$login = "";

			$login = 
			"
				<div id='loginDiv'>
				</div>
			";
			return $login;
		}//end function

		function getSideNav()
		{
			$sidenav = "
				<div style='background-color:#282f36; width:16%; height:100%;'>
				</div>";
			return $sidenav;
		}

?>