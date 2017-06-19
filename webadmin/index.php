<?php
    include_once ("_framework/_zori.cls.php");
    include_once("_framework/_zori.list.basic.cls.php");
    include_once("_framework/_zori.chart.cls.php");
    
  	$page = new Zori();
    // $chart = new ZoriChart(500,300,"Line","2d");
    // //$rstChart = $chart->renderChart("myChart","");

    // $chartContent = "
    //     <div class=''>
    //         <h3 style='text-align: center;'> Annual Zori Chart</h3>
    //         $rstChart
    //     </div>";
    // $page->ContentBootstrap[0]["col-md-10"] = $chartContent;
    $page->Display();
   
?>