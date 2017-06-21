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
        public $chartID;
		public $context; // 2D or 3D

		public $controls;
   		public $db;
		public $SystemSettings = array();
		public $Message;

		function __construct($width=0,$height=0,$type,$context)
      	{
      		$this->width = $width;
      		$this->height = $height;
      		$this->chartType = $type;
      		$this->context = $context;
		}

      	function renderChart($id,$class="",$custom="")
      	{
      	   $this->chartID = $id;
	       $strContent = "<canvas id='$this->chartID' width='$this->width' height='$this->height' class='$class' $custom ></canvas>";
	       	switch ($this->chartType) {
		       	case "Line":
                    $this->chartType = "Line";
		       		break;
		       	case "Donut":
                    $this->chartType = "Donut";
		       		break;
		       	case "Pie":
                    $this->chartType = "Pie";
		       		break;
                case "Bar":
                    $this->chartType = "bar";
                    break;
	       	}


	       $JS .="
                <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
	            <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js'></script>
                <script>

                    var data = 
                    {
                        type: '$this->chartType',
                        data: {
                            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                            datasets: [{
                                label: '# of Votes',
                                data: [12, 19, 3, 5, 2, 3],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        }
                    }

                    var options =
                    {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }

		       		var ctx = $('#$this->chartID').get(0).getContext('$this->context');
                    var myChart = new Chart(ctx, data,options);
					
				</script>
       		";

       		return $strContent.$JS;

	    }

		

	}
?>