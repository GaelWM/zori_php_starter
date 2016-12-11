<?php
	/**
	* By Gael Musikingala 20161121 
	*/
	include_once ("systems.php");
	include_once ("_framework/_zori.control.cls.php");

	class ZoriChart
	{
		private $HEADER;
		public $Content;
		private $FOOTER;

		public $controls;
   		public $db;
		public $SystemSettings = array();
		public $Message;

		function __construct($id="myChart",$width=100,$height=100,$class="",$custom="")
      	{
         	$JS = "
	         	<script>
	            	<canvas id='$id' width='$width' height='$height' class='$class' $custom ></canvas>
	        ";
		}

      	function setChartData(){
	       
	    }

		

	}
?>