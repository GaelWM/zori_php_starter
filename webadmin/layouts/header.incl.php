<?php
    /*---------------- ADMIN HEADER --------------------------*/

    global $SystemSettings;

    echo
    "
        <!DOCTYPE html>
        <html lang='en'>
            <head>
                <meta charset='utf-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='description' content=''>
                <meta name='author' content=''>
                
                <title>".$SystemSettings[Title]."</title> <!--  Name pulled from database -->

                <!-- Bootstrap core CSS -->

                <link href='css/bootstrap.min.css' rel='stylesheet'>
                <link href='css/ie10-viewport-bug-workaround.css' rel='stylesheet'>
                <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                <link rel='stylesheet' href='https://limonte.github.io/sweetalert2/dist/sweetalert2.css'>

                <!-- Optional theme -->
                <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css'>

                <link href='css/default.css' rel='stylesheet'>
                <!-- <link href='css/zori.css' rel='stylesheet'> -->
                <link href='css/articles.css' rel='stylesheet'>

                <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>

                <!-- Latest compiled and minified JavaScript -->
                <script src='js/tinyscrollbar/jquery.tinyscrollbar.js'></script>
               <script src='js/jQuery-File-Upload-9.11.2/extras/jquery.min.js'></script>
               <script type='text/javascript' src='js/passwordstrength.js'></script>
               <script type='text/javascript' src='js/spin.js'></script>
               <script type='text/javascript' src='js/jquery.inputmask.js'></script>
               <script type='text/javascript' src='js/jquery-ui-1.8.6.custom.min.js'></script>
               <script type='text/javascript' src='js/scripts.js'></script>
               <!--<script type='text/javascript' src='js/maxlength.js'></script>-->
               <script type='text/javascript' src='js/jquery.touchSwipe.min.js'></script>
                <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>
                <script src='js/default.js'></script>


                <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
                <script src='js/jquery.toaster.js'></script>
               
            </head>   
    ";


  ?>