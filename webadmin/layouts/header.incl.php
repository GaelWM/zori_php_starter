<?php
    /*---------------- ADMIN HEADER --------------------------*/

    // global $SystemSettings;

    // echo
    // "
    //     <!DOCTYPE html>
    //     <html lang='en'>
    //         <head>
    //             <meta charset='utf-8'>
    //             <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    //             <meta name='description' content=''>
    //             <meta name='author' content=''>
                
    //             <title>".$SystemSettings[Title]."</title> <!--  Name pulled from database -->

    //             <!-- Bootstrap core CSS -->

    //             <link href='css/bootstrap.min.css' rel='stylesheet'>
    //             <link href='css/ie10-viewport-bug-workaround.css' rel='stylesheet'>
    //             <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    //             <link rel='stylesheet' href='https://limonte.github.io/sweetalert2/dist/sweetalert2.css'>

    //             <!-- Optional theme -->
    //             <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css'>

    //             <link href='css/default.css' rel='stylesheet'>
    //             <!-- <link href='css/zori.css' rel='stylesheet'> -->
    //             <link href='css/articles.css' rel='stylesheet'>

    //             <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>

    //             <!-- Latest compiled and minified JavaScript -->
    //             <script src='js/tinyscrollbar/jquery.tinyscrollbar.js'></script>
    //            <script src='js/jQuery-File-Upload-9.11.2/extras/jquery.min.js'></script>
    //            <script type='text/javascript' src='js/passwordstrength.js'></script>
    //            <script type='text/javascript' src='js/spin.js'></script>
    //            <script type='text/javascript' src='js/jquery.inputmask.js'></script>
    //            <script type='text/javascript' src='js/jquery-ui-1.8.6.custom.min.js'></script>
    //            <script type='text/javascript' src='js/scripts.js'></script>
    //            <!--<script type='text/javascript' src='js/maxlength.js'></script>-->
    //            <script type='text/javascript' src='js/jquery.touchSwipe.min.js'></script>
    //             <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>
    //             <script src='js/default.js'></script>


    //             <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
    //             <script src='js/jquery.toaster.js'></script>
               
               
    //         </head>   
    // ";

## 20161222 - nemo3 revamp
## LAYOUT FILE FOR INCLUDES AND OPEN HTML TAGS 
## ---------------------------------------------------------------------------------------


$dod = "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Frameset//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd'>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>"; ## ALTERNATE NOT USED

echo "
<!DOCTYPE html>

<html lang='en'>
   <head>

      <!-- Meta, title, CSS, favicons, etc. -----------------------------------------------------------------------------------------> 
      <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>    
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>

      <title>". $SystemSettings[Title] ."</title>

      <!-- Bootstrap ---------------------------------------------------------------------------------------------------------------->
      <link href='../vendors/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'>

      <!-- Font Awesome ------------------------------------------------------------------------------------------------------------->
      <link href='../vendors/font-awesome/css/font-awesome.min.css' rel='stylesheet'>

      <!-- NProgress ---------------------------------------------------------------------------------------------------------------->
      <link href='../vendors/nprogress/nprogress.css' rel='stylesheet'>

      <!-- iCheck ------------------------------------------------------------------------------------------------------------------->
      <link href='../vendors/iCheck/skins/flat/green.css' rel='stylesheet'>

      <!-- bootstrap-progressbar ---------------------------------------------------------------------------------------------------->
      <link href='../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css' rel='stylesheet'>

      <!-- JQVMap ------------------------------------------------------------------------------------------------------------------->
      <link href='../vendors/jqvmap/dist/jqvmap.min.css' rel='stylesheet'/>

      <!-- Switchery -->
      <link href='../vendors/switchery/dist/switchery.min.css' rel='stylesheet'>

      <!-- bootstrap-daterangepicker ------------------------------------------------------------------------------------------------>
      <link href='../vendors/bootstrap-daterangepicker/daterangepicker.css' rel='stylesheet'> 
      

      <link href='../vendors/bootstrap-wysiwyg/css/style.css' rel='stylesheet'> 

      <script src='js/jquery-ui-min/jquery-ui.min.js'></script>
      <script src='js/jquery-1.10.2.min.js'></script>

      <!-- selectize -->
      <link rel='stylesheet' type='text/css' src='https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js' />
      

      <!-- Datatables -->
      <link href='../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css' rel='stylesheet'>
      <link href='../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css' rel='stylesheet'>
      <link href='../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css' rel='stylesheet'>
      <link href='../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css' rel='stylesheet'>
      <link href='../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css' rel='stylesheet'>

      <!-- PNotify -->
      <link href='../vendors/pnotify/dist/pnotify.css' rel='stylesheet'>
      <link href='../vendors/pnotify/dist/pnotify.buttons.css' rel='stylesheet'>
      <link href='../vendors/pnotify/dist/pnotify.nonblock.css' rel='stylesheet'>

      <!-- Animate.css -------------------------------------------------------------------------------------------------------------->
      <link href='../vendors/animate.css/animate.min.css' rel='stylesheet'>


      <!-- Slider ------------>
      <link href='../vendors/normalize-css/normalize.css' rel='stylesheet'>
      <link href='../vendors/ion.rangeSlider/css/ion.rangeSlider.css' rel='stylesheet'>
      <link href='../vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css' rel='stylesheet'>


      <!-- Select controls 
      -------------------------------------------------------------------------------------------------------------------------------> 
      <link href='../vendors/select2/dist/css/select2.min.css' rel='stylesheet'>
      <link href='../vendors/select2/dist/css/select2.css' rel='stylesheet'>
      <link rel='stylesheet' href='css/toolbar.css' type='text/css' />

      
 
      <!-- starrr -->
      <link href='../vendors/starrr/dist/starrr.css' rel='stylesheet'>

      <!-- default -->
      <link href='css/default.css' rel='stylesheet'>

      <!-- ALWAYS LAST ############################################################################################## -->
      <!-- Custom Theme Style ------------------------------------------------------------------------------------------------------->
      <link href='../build/css/custom.min.css' rel='stylesheet'>
      <link href='../build/css/custom.css' rel='stylesheet'> 
      <script type='text/javascript' src='js/scripts.js'></script>
       ". js(getJSRemoveAlpha()) ."
       
   </head>
";
  ?>