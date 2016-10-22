<?php
	include_once ("_framework/_zori.basic.cls.php");

	$Action = $_POST["Action"];// Override the Action on the session.
	unset($_SESSION[USER]);
	$page = new ZoriBasic();

	if($Action == "Redirect"){
	  	$row = $xdb->getRowSQL("
	   SELECT sysUser.*
	   FROM sysUser INNER JOIN sysSecurityGroup ON sysSecurityGroup.SecurityGroupID = sysUser.refSecurityGroupID
	   WHERE strEmail = '".qs($strUsername)."' AND strPasswordMD5 = '".qs($strPasswordMD5)."'
	   ",0);

	  	$strPassword = $row->strPassword;
	  	$Action = "Login";
	}

	if($Action == "Login")
	{
	   session_start();

	   $row = $xdb->getRowSQL("
	     	SELECT sysUser.*
	     	FROM sysUser INNER JOIN sysSecurityGroup ON sysSecurityGroup.SecurityGroupID = sysUser.refSecurityGroupID
	     	WHERE strEmail = '".qs($strUsername)."' AND sysSecurityGroup.blnActive = 1",
	     0);

	   if($row)
	   {
	      if($row->blnActive == 1){
	         if($row->strPasswordMD5 == md5($strPassword)){

	           	$_SESSION[USER]->ID = $row->UserID;
	           	$_SESSION[USER]->USERNAME = $row->strUser;
	           	$_SESSION[USER]->EMAIL = $row->strEmail;
	           	$_SESSION[USER]->SECURITYGROUPID = $row->refSecurityGroupID;

	           	tblLoginInsert("Login successful");
	           	require ("messages/success.php");
	        	}
	        	else{
		         tblLoginInsert("Login failed: Incorrect password");
		         require ("messages/warning-1.php");
		         $M = "Username or Password is incorrect.";
		         $T = "warning";
	      	}
	   	}
		   else{
		      tblLoginInsert("Login failed: Inactive User");
		      require ("messages/warning-2.php");
		      $M = "User account is inactive.";
		      $T = "warning";
		   }
		}
		else{
		   tblLoginInsert("Login failed: User not found or SG not active");
		   require ("messages/error.php");
		   $M = "Login Details are invalid.";
		   $T = "error";
		}
	}

	//page start

	//$page->getMessage($M,$T);
	$page->Content= "
	   <div class='panel-heading'>
	      <div class='panel-title'>Sign In</div>
	      <div style='float:right; font-size: 80%; position: relative; top:-10px'>
	         <a href='#'>Forgot password?</a>
	      </div>
	   </div>

	   <div style='border-bottom: 1px solid #2f4050'></div>   
	   <div style='padding-top:30px' class='panel-body' >           
	      <div id='loginform' class='form-horizontal' role='form'>       
	         <div style='margin-bottom: 25px' class='input-group'>
	            <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
	            <input id='strUsername' type='text' class='form-control' name='strUsername' placeholder='Email Address'>                                        
	         </div>
	         <div style='margin-bottom: 25px' class='input-group'>
	            <span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>
	            <input id='strPassword' type='password' class='form-control' name='strPassword' placeholder='Password'>
	         </div> 
	         <div class='input-group'>
	          <div class='checkbox'>
	           <label>
	            <input id='login-remember' type='checkbox' name='remember' value='1'> Remember me
	         </label>
	      </div>
	   </div>
	   <div style='margin-top:10px' class='form-group'>
	      <div class='col-sm-12 controls'>
	       	<input type='submit' id='btnLogin' name='Action' value='Login' class='btn btn-success' />
	    	</div>
	 	</div>
	</div>
	</div>

	".js("

		if(d('strUsername').value == ''){
         d('strUsername').focus();
      }else{
         d('strPassword').focus();
      }

		");

	$page->Display();
?>