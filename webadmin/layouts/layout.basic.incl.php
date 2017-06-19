<?php
	 /*---------------- ADMIN MAIN LAYOUT --------------------------*/
	 
	include_once("header.incl.php");
	// global $SystemSettings;
	// print_rr($this->SystemSettings);die("dfgdysy");
	echo "
	<body>
      <form name='frmNemo' enctype='multipart/form-data' action='". $this->SystemSettings[FULL_PATH] ."' method='post'>

      	<!-- Header section -->        
        <div class='top_nav'><div class='nav_menu' style='padding-left:10px;'> ". $this->HEADER ."</div> " . $this->Message() . " </div> 
        <div style='clear:both;'></div>


      	<!-- Content section -->           
        ".$this->ContentBox()."

      	<!-- Footer section -->                 
        $this->FOOTER
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
	</html>
	";

	include_once("footer.incl.php");
?>