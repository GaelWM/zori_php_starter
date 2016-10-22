<?php
	 /*---------------- ADMIN MAIN LAYOUT --------------------------*/
	 
	include_once("layouts/header.incl.php");
	//include_once("project.functions.php");

	//ini
	$HEADER = getHeader();
	$SIDENAV = getSideNav();
	$FOOTER = getFooter();
	$PAGETITLE = getPageTitle("Articles");

	echo "
		<body>
			<div class='container-fluid display-table'>
				<div class='row display-table-row'>
					<div class='col-md-2 col-sm-1 hidden-xs display-table-cell valign-top' id='sidenav'>
						$SIDENAV
					</div>

					<div class='col-md-10 col-sm-11 display-table-cell valign-top'>
						<div class='row'>
							<header id='nav-header' class='clearfix'>$HEADER</header>
						</div>
						<div id='content'>
							<header>
								$PAGETITLE
							</header>
							<div id='content-inner'>
								<div class='form-wrapper'>
									<form>
										<div class='form-group'>
											<label class='sr-only'>Title</label>
											<input type='text' class='form-control' id='title' placeholder='Title'/>
										</div>
										<div class='form-group'>
											<label class='sr-only'>Tags</label>
											<select data-placeholder='Select Tags' name='tags' multiple class='form-control'>
												<option><option>
												<option>HTML<option>
												<option>CSS<option>
												<option>PHP<option>
											</select>
										</div>
										<div class='form-group'>
											<label class='sr-only'>Articles</label>
											<textarea type='text' class='form-control' id='article' placeholder='Artitle' ></textarea>
										</div>

										<div class='checkbox'>
											<label>
												<input type='checkbox'> publish when i click on save
											</label>
										</div>
										<div class='clearfix' >
											<button type='submit' class='btn btn-primary pull-right'>Save/ Publish</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						
						<div class='row'>
							$FOOTER
						</div>
					</div>
				<div>
			</div>
		</body>
	</html>";

	function getSideNav()
	{
		$sidenav = 
		"
			<h1 class='hidden-sm hidden-xs' >Navigation</h1>
			<ul>
				<li class='link active' >
					<a href='index.php'>
						<span class='glyphicon glyphicon-th' aria-hidden='true'></span>
						<span class='hidden-sm hidden-xs' >Dashboard</span>
					</a>
				</li>

				<li class='link'>
					<a href='#collapse-post' data-toggle='collapse' aria-controls='collapse-post'>
						<span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span>
						<span class='hidden-sm hidden-xs' >Articles</span>
						<span class='label label-success pull-right hidden-sm hidden-xs'>20</span>
					</a>

					<ul class='collapse collapseable' id='collapse-post'>
						<li><a href='new-article.php'>Create New</a></li>
						<li><a href='article.php'>View Articles</a></li>
					</ul>
				</li>

				<li class='link'>
					<a href='#collapse-comment' data-toggle='collapse' aria-controls='collapse-comment'>
						<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
						<span class='hidden-sm hidden-xs' >Comments</span>
					</a>

					<ul class='collapse collapseable' id='collapse-comment'>
						<li>
							<a href='approved.php'>Approved
								<span class='label label-success pull-right hidden-sm hidden-xs'>20</span>
							</a>
						</li>
						<li>
							<a href='approved.php'>Unapproved
								<span class='label label-warning pull-right hidden-sm hidden-xs'>20</span>
							</a>
						</li>
					</ul>
				</li>

				<li class='link' >
					<a href='comment.php'>
					<span class='glyphicon glyphicon-user' aria-hidden='true'></span>
					<span class='hidden-sm hidden-xs' >Commenters</span></a>
				</li>
				<li class='link' >
					<a href='tags.php'>
					<span class='glyphicon glyphicon-tags' aria-hidden='true'></span>
					<span class='hidden-sm hidden-xs' >Tags</span></a>
				</li>

				<li class='link settings-btn' >
					<a href='settings.php'>
					<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
					<span class='hidden-sm hidden-xs' >Settings</span></a>
				</li>
			</ul>
		";
		return $sidenav;
	}

	function  getHeader(){
		$header =
		"	
			<nav class='navbar-default pull-left'>
				<button type='button' class='navbar-toggle collapsed' data-toggle='offcanvas' data-target='#sidenav' aria-expanded='false'>
		        <span class='sr-only'>Toggle navigation</span>
		        <span class='icon-bar'></span>
		        <span class='icon-bar'></span>
		        <span class='icon-bar'></span>
			   </button>
			</nav>
			<div class='col-md-5'>
				<input type='text' class='hidden-sm hidden-xs' id='header-search-field' name='search' 
				placeholder='Search for something ...'/>
			</div>
			<div class='col-md-7'>
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
					<li>
						<a href='#' class='logout'>
						<span class='glyphicon glyphicon-log-out' aria-hidden='true'></span> Log out</a>
					</li>
				</ul>
			</div>
		";
		return $header;
	}

	function getFooter()
	{
		$footer =
		"
			<footer id='admin-footer' class='clearfix'>
				<div class='pull-left'><b>Made by Gael Musikingala</b></div>
				<div class='pull-right'><b>Copyright Doudjiem Corporation </b>&copy 2016</div>
			</footer>
		";
		return $footer;
	}

	function getPageTitle($PageTitle){
		$pagetitle =
		"
			<h3 class='page-title'>$PageTitle</h3>
		";
		return $pagetitle;
	}
?>