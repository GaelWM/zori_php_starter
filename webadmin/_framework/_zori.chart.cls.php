<?php
	/**
	* By Gael Musikingala 20161121 
	*/
	include_once ("systems.php");
	include_once ("_framework/_zori.control.cls.php");

	class ZoriChart
	{
		public $width;
		public $height;
		public $chartType; // Line,Donut,pie.
		public $context; // 2D or 3D

		public $controls;
   		public $db;
		public $SystemSettings = array();
		public $Message;

		function __construct($width=0,$heigh=0,$type,$context)
      	{
      		$this->width = $width;
      		$this->height = $height;
      		$this->chartType = $type;
		}

      	function renderChart($id,$class="",$custom="")
      	{
	       $strContent = "<canvas id='$id' width='$this->width' height='$this->height' class='$class' $custom ></canvas>";
	       	switch ($this->chartType) {
		       	case "Line":
		       		$type = "Line";
		       		break;
		       	case "Donut":
		       		$type = "Donut";
		       		break;
		       	case "Pie":
		       		$type = "Pie";
		       		break;
	       	}

	       $JS .="
	       		<script>
		       		var ctx = $('#$id').get(0).getContext('$this->context');
					new Chart(ctx).$type(data,options);
				</script>
       		";

       		return $strContent.$JS;

	    }

		

	}
?>