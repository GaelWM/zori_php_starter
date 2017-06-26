<?php
	/**
	* By Gael Musikingala 20160919 //20161115 -- GAEL [Code Reviewed]
	*/
	include_once ("systems.php");
	include_once ("_framework/_zori.control.cls.php");

	class ZoriBasic
	{
		private $HEADER;
		public $Content;
		private $FOOTER;

		public $controls;
   	public $db;
		public $SystemSettings = array();
		public $Message;

		function __construct()
      {
         //ini
			global $SystemSettings;

      		$this->SystemSettings = $SystemSettings;
      		$this->db = new ZoriDatabase("");

      		if(is_array($_SESSION))
	      	{//extend the $session into the SysSettings
	         	foreach($_SESSION as $key => $value)
	         	{
	            	$this->SystemSettings[$key] = $value;
	         	}
	      	}

			$this->getHeader();
			$this->getMessage();
			$this->Content;
			$this->getFooter();

			$this->controls = new ZoriControl();
		}

		public function getHeader()
		{
			// //ini
			// global $SystemSettings;

			// $this->HEADER =
			// "
			// 	<nav class='navbar-default pull-left'>
			// 		<button type='button' class='navbar-toggle collapsed' data-toggle='offcanvas' data-target='#sidenav' aria-expanded='false'>
			//         <span class='sr-only'>Toggle navigation</span>
			//         <span class='icon-bar'></span>
			//         <span class='icon-bar'></span>
			//         <span class='icon-bar'></span>
			// 	   </button>
			// 	</nav>
			// 	<div class='col-md-7'>
			// 		<ul class='pull-left'>
			// 			<li id='' class='' ><img src='' /></li>
			// 			<li id='welcome' class='' ><h4>".$SystemSettings[ProjectName]."</h4></li>
			// 		</ul>
			// 	</div>
			// ";
			// return $this->HEADER;
         $db = "";
         if($this->SystemSettings[SERVER_NAME] == "localhost"){
            global $DATABASE_SETTINGS;
            $db = ": ". $DATABASE_SETTINGS[localhost]->database;
         }

         return "
         <h1 style='font-size:26px; margin;10px !important;'>". $this->getBrand() ." $db </h1>";
		}

		public function Content($html){
			$this->CONTENT .= $html;
			return $this->CONTENT;
		}
		protected function ContentBox()
	   	{
	      return "
	      	<div class='panel panel-default'>
				<div class='panel-body zoriTableDiv'>
					$this->Content
				</div>
			</div>";
	   	}

		public function getFooter()
		{
      	//ini
      	global $SystemSettings;

			$this->FOOTER =
			"
				<footer id='admin-footer' class='clearfix'>
					<div class='pull-left'><b>".$SystemSettings[MadeBy]."</b></div>
					<div class='pull-right'><b>".$SystemSettings[Copyright]."</b>
               ".$SystemSettings[CopyrightSymbolYear]."</div>
				</footer>
			";
			return $this->FOOTER;
		}

		public function Display($index=""){
      	if(empty($index)){
         	include "layouts/layout.basic.incl.php";
      	}else{
            include " ".$index.".php ";
         }
		}

      public function Message($text=null)
      {
         if($text)
            $this->Message->Text = $text;

         switch($this->Message->class)
         {
            case "warning":
            case "restricted":
               $this->Message->class = "alert alert-warning alert-dismissible fade in";
               break;
            case "error":
               $this->Message->class = "alert alert-danger alert-dismissible fade in";
               break;
            case "success":
            case "good":
               $this->Message->class = "alert alert-success alert-dismissible fade in";
               break;
            case "":
               $this->Message->class = "alert alert-info alert-dismissible fade in";
               break;
         }

         if($this->Message->Text != "")
         return "
   <div class='".$this->Message->class."' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='position:relative; float:right; width: 40px;'><span aria-hidden='true'>×</span>
                </button>
                <strong >". $this->Message->Text ."</strong>
               </div>
         ";
      }

   	protected function getMessage()// Types => (success,warning,info,error) GAEL
   	{
   		$JS ="
         <script>
            var interval;
            var codetmpl = '<code>%codeobj%</code><br><code>%codestr%</code>';
            var message = '".$this->Message->Text."';
            var priority = '".$this->Message->Class."';
            var title = '".$this->Message->Title."';

            $(document).ready(function ()
            {
               if(priority == ''){
                  priority = 'warning';
               }
               if(title == ''){
                  title= 'Message: ';
               }
               if(message != ''){
                  maketoast(title,priority,message);
               }
            });

            function start ()
            {
               if (!interval)
               {
                  interval = setInterval(function ()
                  {
                     randomToast();
                  }, 1500);
               }
               this.blur();
            }

            function stop ()
            {
               if (interval)
               {
                  clearInterval(interval);
                  interval = false;
               }
               this.blur();
            }

            function randomToast ()
            {
               var priority = 'success';
               var title    = 'Success';
               var message  = 'It worked!';

               $.toaster({ priority : priority, title : title, message : message });
            }

            function maketoast (title,priority,message)
            {
               //evt.preventDefault();

               var options =
               {
                  priority : priority,
                  title    : title || null,
                  message  : message || 'A message is required'
               };

               if (options.priority === '<use default>')
               {
                  options.priority = null;
               }

               var codeobj = [];
               var codestr = [];

               var labels = ['message', 'title', 'priority'];
               for (var i = 0, l = labels.length; i < l; i += 1)
               {
                  if (options[labels[i]] !== null)
                  {
                     codeobj.push([labels[i], \"'\" + options[labels[i]] + \"'\"].join(' : '));
                  }

                  codestr.push((options[labels[i]] !== null) ? \"'\" + options[labels[i]] + \"'\" : 'null');
               }

               if (codestr[2] === 'null')
               {
                  codestr.pop();
                  if (codestr[1] === 'null')
                  {
                     codestr.pop();
                  }
               }

               codeobj = '$.toaster({ ' + codeobj.join(', ') + ' });'
               codestr = '$.toaster(' + codestr.join(', ') + ');'

               $('#toastCode').html(codetmpl.replace('%codeobj%', codeobj).replace('%codestr%', codestr));
               $.toaster(options);
            }
            </script>
         ";

        return $JS;
   	}

      function getBrand(){
         global $SystemSettings;
         return $SystemSettings[Brand];
      }

	}
?>