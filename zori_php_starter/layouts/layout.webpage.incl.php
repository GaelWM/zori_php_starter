<?php
	ini_set('display_errors', '1');
   error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);

	$Footer = getFooter();
	$Menu = getNavbar();
	$LOGO = getLogo();
	include("layouts/header.webpage.incl.php");
	echo "
		<nav class='navbar navbar-inverse'>
	      <div class='container-fluid'>
	        	<div class='navbar-header'>
		         <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
		            <span class='icon-bar'></span>
		            <span class='icon-bar'></span>
		            <span class='icon-bar'></span>                        
		         </button>
		         <a class='navbar-brand' href='#'>$LOGO</a>
	        	</div>
	        	<div class='collapse navbar-collapse' id='myNavbar'>
	          	$Menu
	          	$Login
	        	</div>
	      </div>
	   </nav>
    	<div class='container-fluid text-center'>    
		  	<div class='row content'>
			   <div class='col-sm-2 sidenav'>
			      $LeftSideNav
			   </div>
		    	<div class='col-sm-8 text-left'>
		    		$Content
		    	</div>
		    	<div class='col-sm-2 sidenav'>
			     $RightSideNav
		    	</div>
		  	</div>
		</div>
		$Footer
	";

	include("layouts/footer.webpage.incl.php");

	function getNavbar()
	{
    	return "
	      <ul class='nav navbar-nav'>
	         <li class='active'><a href='#'>Home</a></li>
	         <li><a href='#'>About</a></li>
	         <li><a href='#'>Projects</a></li>
	         <li><a href='contact.us.php'>Contact</a></li>
	      </ul>
	   ";
  	}

  	function getFooter(){
  		return "
  		<footer class='container-fluid text-center'>
		  <p>Footer Text</p>
		</footer>
		</body>
		</html>";
  	}

  	function getSideNav(){
  		return "
  			<div class='container-fluid text-center'>    
			  <div class='row content'>
			    <div class='col-sm-2 sidenav'>
			      <p><a href='#'>Link</a></p>
			      <p><a href='#'>Link</a></p>
			      <p><a href='#'>Link</a></p>
			    </div>
			    
			    <div class='col-sm-2 sidenav'>
			      <div class='well'>
			        <p>ADS</p>
			      </div>
			      <div class='well'>
			        <p>ADS</p>
			      </div>
			    </div>
			  </div>
			</div>
  		";
  	}

  	function getLogo()
  	{
  		if($SystemSettings[LOGO])
  			return $SystemSettings[LOGO];
  		else
  			return "Zori Framework";
  	}

  	function getLoginIcon()
  	{
  		if($SystemSettings[LoginIcon])
  			return "<ul class='nav navbar-nav navbar-right'> <li><a href='#'>".$SystemSettings[LoginIcon]."</a></li> </ul>"; 
  		else
  			return "<ul class='nav navbar-nav navbar-right'> <li><a href='#'><span class='glyphicon glyphicon-log-in'></span> Login</a></li> </ul>";
  	}
?>




