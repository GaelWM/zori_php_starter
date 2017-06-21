<?php
	/**
	* 	Date: 16/01/2017
		File Name: _nemo.control.slider.cls.php
		Class Name: NemoSlider
		Author: Gael Musikingala
      Modify By: Gael Musikingala 10/02/2017
	*/

class NemoSliderControl extends NemoControl2
{
   // ini
   public $jsControl;
   public $htmlControl;

   public $VarType;// String e.g. "double"
   public $minRange;//int:
   public $maxRange; //int:
   public $stepValue;//int:
   public $minValue;//int:
   public $maxValue;//int:

   public $grid;// boolean: true or false
   public $from_fixed;// boolean: true or false
   public $max_interval;//int:
   public $prettify;// function: e.g.function(num) {var m = moment(num, "X");return m.format("Do MMMM, HH:mm");}
   public $keyboard;// boolean: true or false
   public $keyboard_step;// double: eg. 0.5
   public $grid_snap;// boolean: true or false
   public $prefix;// String: $, R, FC, Euro 
   public $hide_min_max;// boolean: true or false
   public $force_edges;// boolean: true or false
   public $predefinedValuesArr;

   public function __construct($proto){
      foreach($proto as $key => &$value){
         $this->{$key} = $value;
      }
      self::loadJSControl();
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;

      $attr = self::renderAttributes($this->html, $enqoute);
      $attrJS .= self::renderSliderAttributes();

      if($this->VALUE == "" || $this->VALUE == NULL ){ // if time is empty, select the current hour and current hour + 1
         $this->VALUE =
         $this->html->value = date('H', time()).":00;".date('H', strtotime('+1 hour')).":00";
      }

      $js = " 
      <script>
         $(document).ready(function() {
            var i = 0;
            var hours = ['6:00', '6:30', '7:00', '7:30','8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30','13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00','19:30','20:00'];
            $('#$this->ID').ionRangeSlider({
               $attrJS
            });   
         });
      </script>";
      $this->HTML = "<div class='item_$this->ID'><input $attr >".$this->htmlControl->innerHTML."</input></div>".$js;
   }

   function loadJSControl()
   {
      $this->jsControl->type = $this->VarType;
      $this->jsControl->min = $this->minValue;
      $this->jsControl->max = $this->maxValue;
      $this->jsControl->step = $this->stepValue;
      $this->jsControl->from = $this->minRange;

      $this->jsControl->to = $this->maxRange;
      $this->jsControl->force_edges = $this->force_edges; 
      $this->jsControl->hide_min_max = $this->hide_min_max;
      $this->jsControl->grid = $this->grid;
      $this->jsControl->prefix = $this->prefix;
      $this->jsControl->from_fixed = $this->from_fixed;
      $this->jsControl->max_interval = $this->max_interval;
      $this->jsControl->prettify = $this->prettify;
      $this->jsControl->grid_snap = $this->grid_snap;
      $this->jsControl->keyboard = $this->keyboard;
      $this->jsControl->values = $this->predefinedValuesArr;
      $this->jsControl->keyboard_step = $this->keyboard_step;
   }


   public function renderSliderAttributes()
   {
      //ini
      $jsAttr = "";
      $comma = "";
      //$jsControl= self::renderJsControl();
      self::loadJSControl();
      if(count($this->jsControl) > 0){

      foreach($this->jsControl as $attr => $value)
      {  
         if($value != ""){
            $jsAttr .= $comma.$this->renderSliderAttribute($attr, $value);
            $comma = ",";
         }
      }}
      return $jsAttr;
   }

   public function renderSliderAttribute($attr, $value)
   {
      switch ($attr) 
      {
         case "type":
         case "prefix":
            return " $attr : \"". qs($value) ."\"";
            break;

         default:
            return " $attr : ". qs($value) ."";
            break;
      }
   }

   public function getPostMinMaxValue($post)
   {//ini
      if(!isset($post)){
         $sliderValues = explode(";", $post);
         $this->minRange = $sliderValues[0];
         $this->maxRange = $sliderValues[1];
         $this->loadJSControl();// render controls after getting slider values from post.
      }
   }

}//eoNemoSlider


?>