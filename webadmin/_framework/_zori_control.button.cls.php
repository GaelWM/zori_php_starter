<?php
	/**
	* 	Date: 25/01/2017
		File Name: _Zori.control.button.cls.php
		Class Name: ZoriSlider
		Author: Gael Musikingala
	*/
	class ZoriControlButton extends ZoriControl2
	{
      public function __construct($proto)
	   {//ini
	      foreach($proto as $key => &$value){
	        $this->{$key} = $value;
	      }
	   }


	   public function render()
	   {
	      $this->html->id = $this->ID;
	      $this->html->name = $this->Name;
	      switch ($this->ID)
	     {
	         case "btnSave":
	            $this->html->class = " btn btn-success col-md-3 col-sm-6 col-xs-12";
	            break;

	         case "btnDelete":
	            $this->html->class = " btn btn-danger col-md-3 col-sm-6 col-xs-12";
	            break;

	         case "btnInfo":
	            $this->html->class = " btn btn-info col-md-3 col-sm-6 col-xs-12";
	            break;

	         case "btnWarning":
	            $this->html->class = " btn btn-warning col-md-3 col-sm-6 col-xs-12";
	            break;

	         case "btnLink":
	            $this->html->class = " btn btn-link  col-md-3 col-sm-6 col-xs-12";
	            break;

	         case "btnResetPassword":
	            $this->html->class = " btn btn-primary col-md-3 col-sm-6 col-xs-12";
	            break;
	      
	         default:
	            $this->html->class .= " btn btn-default col-md-3 col-sm-6 col-xs-12";
	            break;
	      }

	      $attr = self::renderAttributes($this->html, $enqoute);
	      $this->HTML = "<input type='submit' $attr />";
	   }
	}

?>