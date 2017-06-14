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

                    // var data = 
                    // {
                    //     labels : ['January','February','March','April','May','June','July','August','September','October','November','December'],
                        
                    //     datasets : 
                    //         [
                    //             {
                    //                 fillColor : 'rgba(252,233,79,0.5)',
                    //                 strokeColor : 'rgba(82,75,25,1)',
                    //                 pointColor : 'rgba(166,152,51,1)',
                    //                 pointStrokeColor : '#fff',
                    //                 data : [65,68,75,
                    //                         81,95,105,
                    //                         130,120,105,
                    //                         90,75,70]
                    //             }
                    //         ]
                    // }
                
                
                    // var options=
                    // {					
                    //     //Boolean - If we show the scale above the chart data			
                    //     scaleOverlay : false,
                        
                    //     //Boolean - If we want to override with a hard coded scale
                    //     scaleOverride : true,
                        
                    //     //Required if scaleOverride is true 
                    //     //Number - The number of steps in a hard coded scale
                    //     scaleSteps : 16,
                    //     //Number - The value jump in the hard coded scale
                    //     scaleStepWidth : 5,
                    //     //Number - The scale starting value
                    //     scaleStartValue : 55,
                    //     //String - Colour of the scale line	
                    //     scaleLineColor : 'rgba(20,20,20,.7)',
                        
                    //     //Number - Pixel width of the scale line	
                    //     scaleLineWidth : 1,
                
                    //     //Boolean - Whether to show labels on the scale	
                    //     scaleShowLabels : true,
                        
                    //     //Interpolated JS string - can access value
                    //     scaleLabel : '<%=value%>',
                        
                    //     //String - Scale label font declaration for the scale label
                    //     scaleFontFamily : 'Arial',
                        
                    //     //Number - Scale label font size in pixels	
                    //     scaleFontSize : 12,
                        
                    //     //String - Scale label font weight style	
                    //     scaleFontStyle : 'normal',
                        
                    //     //String - Scale label font colour	
                    //     scaleFontColor : '#666',	
                        
                    //     ///Boolean - Whether grid lines are shown across the chart
                    //     scaleShowGridLines : true,
                        
                    //     //String - Colour of the grid lines
                    //     scaleGridLineColor : 'rgba(0,0,0,.3)',
                        
                    //     //Number - Width of the grid lines
                    //     scaleGridLineWidth : 1,	
                        
                    //     //Boolean - Whether the line is curved between points
                    //     bezierCurve : true,
                        
                    //     //Boolean - Whether to show a dot for each point
                    //     pointDot : true,
                        
                    //     //Number - Radius of each point dot in pixels
                    //     pointDotRadius : 5,
                        
                    //     //Number - Pixel width of point dot stroke
                    //     pointDotStrokeWidth : 1,
                        
                    //     //Boolean - Whether to show a stroke for datasets
                    //     datasetStroke : true,
                        
                    //     //Number - Pixel width of dataset stroke
                    //     datasetStrokeWidth : 2,
                        
                    //     //Boolean - Whether to fill the dataset with a colour
                    //     datasetFill : true,
                        
                    //     //Boolean - Whether to animate the chart
                    //     animation : false,
                
                    //     //Number - Number of animation steps
                    //     animationSteps : 60,
                        
                    //     //String - Animation easing effect
                    //     animationEasing : 'easeOutQuart',
                
                    //     //Function - Fires when the animation is complete
                    //     onAnimationComplete : null
                    // };                
                    
                    
		       		var ctx = $('#$this->chartID').get(0).getContext('$this->context');
                    var myChart = new Chart(ctx, data,options);
					
				</script>
       		";

       		return $strContent.$JS;

	    }

		

	}
?>