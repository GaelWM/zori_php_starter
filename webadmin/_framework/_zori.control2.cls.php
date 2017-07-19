<?php

//20170121 - new - pj
//20170710: Added this to stop the Zoriprocontrol to override the name on the details. Gael.
//201700711 Removed the initial value on post. - Gael

include ("_framework/_zori.control.slider.cls.php");
include ("_framework/_zori.file.control.cls.php");
include ("_framework/_zori_control.button.cls.php");

abstract class ZoriControl2
{
   public $Type;
   public $ID;
   public $Name;
   public $VALUE;

   public $html;

   public $Comment;
   public $CommentTitle;

   public $isRequired;
   public $isSelected;
   public $jsValidate;

   public $db;
   public $sqlGrouping;
   public $sql;

   public $HTML = "";

   public $Label;

   //bootstrap / framework @render

//***********ABSTRACT******************
   protected abstract function render(); // proto function! this must defined in child classes

//***********INHERITT******************
   public function __construct($Type, $ID, $Value, $attr, $blnRequired, $isSelected, $Options= null, $sql=null, $sqlGrouping=null,$Comment,$CommentTitle)
   {
      $this->Type = $Type;
      $this->ID =
      $this->Name = $ID;

      //20170710: Added this to stop the Zoriprocontrol to override the name on the details. Gael.
      if($Type == "selectMultiple"){
         $this->Name = $ID."[]";
      }

      $this->VALUE = $Value;

      $this->sql = $sql;
      $this->sqlGrouping = $sqlGrouping;

      $this->html = $attr;

      $this->isRequired = $blnRequired;
      $this->isSelected = $isSelected;

      $this->Options = $Options;

//todo:
      $this->Label = $ID;
      $this->Comment = $Comment;
      $this->CommentTitle = $CommentTitle;
   }

   public static function ini($proto)
   {//print_rr($proto); //die("kldskok");
      $proto->html->required = ($proto->isRequired == 1) ? "required" : "" ;

      switch($proto->Type)
      {
         // case ?:
         //    $control = new Zori_?_Control($proto);
         //    break;
         case "tinyint":
         case "checkbox":
         case "switch":

            $proto->html->value = "checked";

            if($proto->Type == "switch"){
               //$proto->html->value = ""; 201700711 Removed the initial value on post. - Gael
               $proto->html->class = str_replace(" js-switch ", "", $proto->html->class). " js-switch ";
            }
            else{
               $proto->html->class = str_replace(" flat ", "", $proto->html->class). " flat ";
            }

            if($proto->isSelected == 1 )
               $proto->html->checked = "checked";

            $control = new ZoriCheckboxControl($proto);
            break;

         case "radio":
            $proto->html->value = $proto->VALUE;
            $proto->html->class .= " flat";
            $proto->html->class = str_replace(" flat ", "", $proto->html->class). " flat ";

            if($proto->isSelected == 1)
               $proto->html->checked = "checked";

            $control = new ZoriRadioControl($proto);
            break;

         case "file":
            $control = new ZoriFileUploadControl($proto);
            break;

         case "date":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriDateControl($proto);
            break;

         case "dateRange":
         case "dtRange":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriDateRangeControl($proto);
            break;

         case "dateTimeRange":
         case "dtDateTime":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriDateTimeRangeControl($proto);
            break;

         case "datetime":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriDateTimeControl($proto);
            break;

         case "enum":
         case "select":
         case "ddl":

            $proto->html->value = $proto->VALUE;

            $proto->html->class = str_replace(" select2_single form-control ", "", $proto->html->class). " select2_single form-control ";
            $proto->html->tabindex = "-1";

            if($proto->isRequired == 1) {$proto->html->allowClear = "false"; }else{$proto->html->allowClear = "true";} // if ddl is required, removes clear button on the select control -- Gael

            $control = new ZoriSelectControl($proto);

            if($control->sql != "") $control->iniSQL($control->sql, $control->sqlGrouping);

            $control->renderOptions($control->Options);

            break;

         case "datalist":
         case "lst":
            $proto->html->value = $proto->VALUE;

            $proto->html->class = str_replace(" select2_single form-control ", "", $proto->html->class). " select2_single form-control ";
            $proto->html->tabindex = "-1";

            if($proto->html->allowClear == null) $proto->html->allowClear = "true";

            $control = new ZoriDatalistControl($proto);

            if($control->sql != "") $control->iniSQL($control->sql, $control->sqlGrouping);

            $control->renderOptions($control->Options);
         break;

         case "selectMultiple":
            $proto->html->value = $proto->VALUE;
            $proto->html->multiple = "multiple";

            $proto->html->class = str_replace(" select2_multiple form-control ", "", $proto->html->class). " select2_multiple form-control ";

            $control = new ZoriDatalistControl($proto);

            if($control->sql != "") $control->iniSQL($control->sql, $control->sqlGrouping);

            $control->renderOptions($control->Options);

            $control = new ZoriSelectMultipleControl($proto);
            break;

         case "text":
         case "textarea":
            $proto->html->innerHTML = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";

            $control = new ZoriTextAreaControl($proto);
            break;

         case "richtext":
            $proto->html->innerHTML = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $proto->html->style = "display:none;";

            $control = new ZoriRichTextControl($proto);
            break;

         case "slider":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriSliderControl($proto);
            break;

         case "hidden":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $proto->html->readonly ="readonly";
            $control = new ZoriInputControl($proto);
            break;

         case "label":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $proto->html->readonly ="readonly";
            $control = new ZoriInputControl($proto);
            break;

         case "tag":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriInputControl($proto);
            break;

         case "mask":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriInputControl($proto);
            break;

         case "varchar":
         case "int":
         case "double":
         case "readonly":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriInputControl($proto);
            break;

         case "password":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriPasswordControl($proto);
            break;

         case "time":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriTimeControl($proto);
            break;


          case "submit":
            $proto->html->value = $proto->VALUE;
            $proto->Name = "Action";
            $control = new ZoriControlButton($proto);
            break;

         case "custom":
            $proto->html->value = $proto->VALUE;
            $proto->html->class = str_replace(" form-control ", "", $proto->html->class). " form-control ";
            $control = new ZoriCustomControl($proto);
            break;

         case "link":
            $proto->html->value = $proto->VALUE;
            $control = new ZoriLinkButtonControl($proto);
            break;

         default:
            $proto->html->value = $proto->VALUE;

            $control = $proto;
            break;
      }

      $control->render();

      return $control;
   }

//***********STATIC******************
   public static function renderAttributes($arrAttr, $enqoute="\""){

      $htmlAttr = "";

      if(count($arrAttr) > 0){
      foreach($arrAttr as $attr => $value)
      {
         switch($attr)
         {
            case "innerHTML": //dont render innerHTML inside a control
            case "maximumSelectionLength": //dont render maximumSelectionLength inside a control
            case "allowClear": //dont render allowClear inside a control
            case "delimiter": //dont render delimiter inside a control
            // case "comment":
            // case "isRequired":
            // case "isSelected":
            // case "jsValidate":
            // case "db":
            // case "sqlGrouping":
            // case "sql":
            // case "html":
               break;
            //case "placeholder": //dont render placeholder inside a control

            default:
            $htmlAttr .= " $attr = \"".qs($value)."\"";
         }
      }}
      return $htmlAttr;
   }
}//eoNC2



//****PROTO CLASS****************************
class ZoriProtoControl extends ZoriControl2{

   public static function __new($Type, $ID, $Value, $attr, $blnRequired, $isSelected, $Options= null, $sql=null, $sqlGrouping=null){

      $proto = new ZoriProtoControl($Type, $ID, $Value, $attr, $blnRequired, $isSelected, $Options, $sql, $sqlGrouping);

      $control = $proto->ini($proto);
      return $control;
   }

   public function render(){
      if($this->Type != null){

         echo "CONTROL CHILD-CLASS MISSING: $this->Type: $this->ID<BR />";
      }else{
         return false;
      }

      //die(debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
   }

   public static function __render($Type, $ID, $Value, $attr, $blnRequired, $isSelected){
      $control = self::__new($Type, $ID, $Value, $attr, $blnRequired, $isSelected);
      //print_rr($control);

      return $control->render();
   }
}

//****IMPLEMENTATION CLASSES*****************
class ZoriInputControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render($enqoute="\"")
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;
      $this->html->delimiter = "" ? ";": $this->html->delimiter;//set default if empty else use custom delimiter
      $Controltype = "text";

      switch ($this->Type) {
         case "hidden":
            $Controltype = "hidden";
            break;

         case "label":
            break;

         case "readonly":
            $this->html->readonly = "readonly";
            break;

         case "tag":
            $js = "
              <script>
                  $(document).ready(function() {
                     $('#$this->ID').tagsInput({
                       width: 'auto',
                       delimiter:'".$this->html->delimiter."'
                     });
                  });
              </script>";
            break;
         case "int":
         case "double":
            $this->html->onblur = "removeAlpha(this);";
            break;

         default:
            break;
      }
      //$this->Comment ="ALLO";
      
      $attr = self::renderAttributes($this->html, $enqoute);
      if($this->Comment != "" ) // && $this->Type != "readonly"
      {
         $this->HTML = "
         <div class='item_$this->ID'>
            <div class='input-group'>
               <input type='$Controltype' $attr />
               <span class='input-group-addon' tabindex='0' data-toggle='popover' title='$this->CommentTitle' data-html='true'
               data-content=\"$this->Comment\" data-trigger='focus' id='info_$this->ID'><i class='glyphicon glyphicon-info-sign'></i></span>
            </div>
         </div>".$js;
      }
      else{
         $this->HTML = "<div class='item_$this->ID'><input type='$Controltype' $attr /></div>".$js;
      }

//vd($this->HTML); die;
   }

}//eoNIC


class ZoriPasswordControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render($enqoute="\"")
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;

      $Controltype = "password";

      switch ($this->Type) {
         case "hidden":
            $Controltype = "hidden";
            break;

         case "label":
            break;
         case "tag":
            $js = "
              <script>
                  $(document).ready(function() {
                     $('#$this->ID').tagsInput({
                       width: 'auto'
                     });
                  });
              </script>";
            break;
         case "int":
         case "double":
            $this->html->onblur = "removeAlpha(this);";
            break;

         default:
            break;
      }
      //$this->Comment ="ALLO";
      $attr = self::renderAttributes($this->html, $enqoute);

      if($this->Comment != "")
      {
         $this->HTML = "
         <div class='item_$this->ID'>
            <div class='input-group'>
               <input type='$Controltype' $attr />
               <span class='input-group-addon' tabindex='0' data-toggle='popover' title='$this->CommentTitle' data-html='true'
               data-content='$this->Comment' data-trigger='focus' id='info_$this->ID'><i class='glyphicon glyphicon-info-sign'></i></span>
            </div>
         </div>".$js;
      }
      else{
         $this->HTML = "<div class='item_$this->ID'><input type='$Controltype' $attr /></div>".$js;
      }
//vd($this->HTML); die;
   }

}//eoNIC


class ZoriCheckboxControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;

      $checked = ($this->VALUE == "checked" || $this->VALUE == "on") ? "checked='checked'" : "" ;
      //print_rr($this);

      $attr = self::renderAttributes($this->html, $enqoute);
      $this->HTML = "<div class='item_$this->ID'><input type='checkbox' $attr $checked/>$this->Comment</div>";
   }

}//eoNCbC

class ZoriRadioControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;

      $attr = self::renderAttributes($this->html, $enqoute);

      if($this->Comment != "")
         $this->HTML = "<div class='item_$this->ID'><input type='radio' $attr $checked/> $this->Comment</div>";
      else
         $this->HTML = "<div class='item_$this->ID'><input type='radio' $attr $checked/></div>";
   }

}//eoNRaC



class ZoriTextAreaControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;

      $attr = self::renderAttributes($this->html, $enqoute);

      if($this->Comment != "")
      {
         $this->HTML = "
         <div class='item_$this->ID'>
            <div class='input-group'>
               <textarea $attr>".$this->html->innerHTML."</textarea>
               <span class='input-group-addon' tabindex='0' data-toggle='popover' title='$this->CommentTitle' data-html='true'
               data-content='$this->Comment' data-trigger='focus' id='info_$this->ID'><i class='glyphicon glyphicon-info-sign'></i></span>
            </div>
         </div>".$js;
      }
      else{
         $this->HTML = "<div class='item_$this->ID'><textarea $attr>".$this->html->innerHTML."</textarea></div>";
      }
   }

}//eoNTxC


class ZoriRichTextControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;


      $attr = self::renderAttributes($this->html, $enqoute);
      $js = "
         <script>
            $(document).ready(function() {
               function initToolbarBootstrapBindings() {
                  var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                         'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                         'Times New Roman', 'Verdana'
                     ],
                     fontTarget = $('[title=Font]').siblings('.dropdown-menu');

                     $.each(fonts, function(idx, fontName) {
                        fontTarget.append($('<li><a data-edit=\"fontName ' + fontName + '\" style=\"font-family:\'' + fontName + '\'\">' + fontName + '</a></li>'));
                     });

                     $('a[title]').tooltip({
                        container: 'body'
                     });
                     $('.dropdown-menu input').click(function() {
                        return false;
                     })
                     .change(function() {
                         $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                     })
                     .keydown('esc', function() {
                        this.value = '';
                        $(this).change();
                     });

                  $('[data-role=magic-overlay]').each(function() {
                     var overlay = $(this),
                        target = $(overlay.data('target'));
                     overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                  });

                  if ('onwebkitspeechchange' in document.createElement('input')) {
                     var editorOffset = $('#editor_$this->ID').offset();

                     $('.voiceBtn').css('position', 'absolute').offset({
                         top: editorOffset.top,
                         left: editorOffset.left + $('#editor_$this->ID').innerWidth() - 35
                     });
                  } else {
                     $('.voiceBtn').hide();
                  }
               }

               function showErrorAlert(reason, detail) {
                  var msg = '';
                  if (reason === 'unsupported-file-type') {
                     msg = 'Unsupported format ' + detail;
                  } else {
                     console.log('error uploading file', reason, detail);
                  }
                  $('<div class=\"alert\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>' +
                     '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
               }

               initToolbarBootstrapBindings();

               $('#editor_$this->ID').wysiwyg({
                  fileUploadError: showErrorAlert
               });

               window.prettyPrint;
               prettyPrint();

               //copies whatever in the editor into the textarea before submitting the form -- Gael
               $('form[name=\"frmZori\"]').submit(function() {
                  getText_$this->ID();
               });

            });
            function getText_$this->ID(){
               var editorValue_$this->ID = document.getElementById('editor_$this->ID').innerHTML;
               $('#$this->ID').text(editorValue_$this->ID);
            }
         </script>
      ";

      $this->HTML = "
      <div class=''>
         <div class='x_panel'>
          <div class='x_content'>
            <div class='btn-toolbar editor' data-role='editor-toolbar' data-target='#editor_$this->ID'>
              <div class='btn-group'>
                <a class='btn dropdown-toggle' data-toggle='dropdown' title='Font'><i class='fa fa-font'></i><b class='caret'></b></a>
                <ul class='dropdown-menu'>
                </ul>
              </div>

               <div class='btn-group'>
                  <a class='btn dropdown-toggle' data-toggle='dropdown' title='Font Size'><i class='fa fa-text-height'></i>&nbsp;<b class='caret'></b></a>
                  <ul class='dropdown-menu'>
                     <li>
                       <a data-edit='fontSize 5'>
                         <p style='font-size:17px'>Huge</p>
                       </a>
                     </li>
                  <li>
                    <a data-edit='fontSize 3'>
                      <p style='font-size:14px'>Normal</p>
                    </a>
                  </li>
                  <li>
                    <a data-edit='fontSize 1'>
                      <p style='font-size:11px'>Small</p>
                    </a>
                  </li>
                </ul>
               </div>

               <div class='btn-group'>
                  <a class='btn' data-edit='bold' title='Bold (Ctrl/Cmd+B)'><i class='fa fa-bold'></i></a>
                  <a class='btn' data-edit='italic' title='Italic (Ctrl/Cmd+I)'><i class='fa fa-italic'></i></a>
                  <a class='btn' data-edit='strikethrough' title='Strikethrough'><i class='fa fa-strikethrough'></i></a>
                  <a class='btn' data-edit='underline' title='Underline (Ctrl/Cmd+U)'><i class='fa fa-underline'></i></a>
               </div>

               <div class='btn-group'>
                  <a class='btn' data-edit='insertunorderedlist' title='Bullet list'><i class='fa fa-list-ul'></i></a>
                  <a class='btn' data-edit='insertorderedlist' title='Number list'><i class='fa fa-list-ol'></i></a>
                  <a class='btn' data-edit='outdent' title='Reduce indent (Shift+Tab)'><i class='fa fa-dedent'></i></a>
                  <a class='btn' data-edit='indent' title='Indent (Tab)'><i class='fa fa-indent'></i></a>
               </div>

               <div class='btn-group'>
                  <a class='btn' data-edit='justifyleft' title='Align Left (Ctrl/Cmd+L)'><i class='fa fa-align-left'></i></a>
                  <a class='btn' data-edit='justifycenter' title='Center (Ctrl/Cmd+E)'><i class='fa fa-align-center'></i></a>
                  <a class='btn' data-edit='justifyright' title='Align Right (Ctrl/Cmd+R)'><i class='fa fa-align-right'></i></a>
                  <a class='btn' data-edit='justifyfull' title='Justify (Ctrl/Cmd+J)'><i class='fa fa-align-justify'></i></a>
               </div>

               <div class='btn-group'>
                <a class='btn dropdown-toggle' data-toggle='dropdown' title='Hyperlink'><i class='fa fa-link'></i></a>
                  <div class='dropdown-menu input-append'>
                     <input class='span2' placeholder='URL' type='text' data-edit='createLink' />
                     <button class='btn' type='button'>Add</button>
                  </div>
                  <a class='btn' data-edit='unlink' title='Remove Hyperlink'><i class='fa fa-cut'></i></a>
               </div>

               <div class='btn-group'>
                  <a class='btn' title='Insert picture (or just drag & drop)' id='pictureBtn'><i class='fa fa-picture-o'></i></a>
                  <input type='file' data-role='magic-overlay' data-target='#pictureBtn' data-edit='insertImage' />
               </div>

               <div class='btn-group'>
                  <a class='btn' data-edit='undo' title='Undo (Ctrl/Cmd+Z)'><i class='fa fa-undo'></i></a>
                  <a class='btn' data-edit='redo' title='Redo (Ctrl/Cmd+Y)'><i class='fa fa-repeat'></i></a>
               </div>
            </div>

           <div class='item_$this->ID'><div id='editor_$this->ID' class='editor-wrapper'>".$this->html->innerHTML."</div></div>
            <textarea $attr >".$this->html->innerHTML."</textarea>
      </div></div>".$js;
   }

}//eoNTx2C

class ZoriSelectControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($proto);
      $this->Options = $proto->Options;
      //print_rr($this);
   }

   public function iniSQL($sql, $sqlGrouping)
   {
      global $xdb;

      $this->sql = $sql;
      $this->sqlGrouping = $sqlGrouping;
      $sqlOrderBy = "";
      $idxOrderBy = false;

//vd("<BR>". $this->sql); //die("sdljkdjkjj");
// global $ljsbdfbjds;
// if($this->ID == "lstPaymentTerms")
// {
//    vd(strpos($this->sql,"GROUPING"));
//    vd($this->sql);
//    $ljsbdfbjds += 1;
//    echo "$ljsbdfbjds: ";
//    vd($this->sqlGrouping);
// }
      if($this->sql != "")
      {
         if(strpos($this->sql,"GROUPING") === false)
         {
            if($this->sqlGrouping != "")
            {
               //no "GROUPING" add grouping
                  $idxOrderBy = strpos($this->sql, "ORDER BY"); //vd($idxOrderBy);
                  $sqlOrderBy = substr($this->sql, $idxOrderBy); //vd($sqlOrderBy);

                  $this->sql = "SELECT $this->sqlGrouping AS GROUPING, der.*
                     FROM ($this->sql) as der
                  ". str_replace("ORDER BY", "ORDER BY GROUPING,", $sqlOrderBy);

            }else{
               $this->sql = str_replace("SELECT", "SELECT '' AS GROUPING,", $this->sql);
               $this->sql = str_replace("ORDER BY", "ORDER BY GROUPING,", $this->sql);
            }
         }

         $rstOptions = $xdb->doQuery($this->sql, 0); //echo "89yds73g";//die;
         while($row = $xdb->fetch_array($rstOptions))
         {
            $htmlOption = null;
            $htmlOption->value = $row[1];
            $htmlOption->innerHTML = $row[2];

            $arrOption[$row[0]][] = $htmlOption;
         }

         $this->Options = $arrOption;
         //die("kjsdfbn");
      }

// if($this->ID == "lstPaymentTerms")
// {
//    vd($this->sql);
// }

   }

   public function renderOptions($arrOption)
   {//print_rr($arrOption); echo("sdkjfbn");
//vd($this->VALUE);
      if(is_array($arrOption)){
         //print_rr($arrOption);
         foreach($this->Options as $strGrouping => $Options)
         {
            if($strGrouping != "") $innerHTML .= "<optGroup label=\"".strtoupper($strGrouping).".\">";
            //print_rr($Options);
            foreach($Options as $idx => $html)
            {//print_rr($html); vd($Options[$idx]->innerHTML);
               //if($html->value == null || $html->value == "") $html->value = $idx;//20170718 removed. Gael
               if($html->value == 0) $Options[0]->value = "";
               if($html->value == null || $html->value == "") $this->html->placeholder = $Options[0]->innerHTML;
               //echo "$this->VALUE == $html->value"; vd(($this->VALUE == $html->value));// trip = because
               //print_rr($this->html->placeholder);die("io");
               // $this->html->placeholder = ($this->isRequired == 1) ? "- Select -" : "None" ;
               // $this->html->allowClear = ($this->isRequired == 1) ? "false" : "None" ;
               $attr = self::renderAttributes($html, $enqoute);
               $innerHTML .= "<option $attr ". ($this->VALUE == $html->value ? "selected":"") .">". $html->innerHTML ."</option>";
            }
            if($strGrouping != "") $innerHTML .= "</optGroup>";
         }
      }
//die("ljfdsjln");
      $this->html->innerHTML = $innerHTML;
   }

   public function render()
   {//print_rr($this);
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;

      if($this->html->style == null) $this->html->style = "width:100%;";
      //print_rr($this->html);
      //$this->html->onmouseover = "function(){return false;}";

      $attr = self::renderAttributes($this->html, $enqoute);
      if($this->html->readonly == "true" || $this->html->readonly == "readonly" ){
         $jsAdd = "$('#$this->ID').prop('disabled', true);
         $('form[name=\"frmZori\"]').submit(function() {
            $('#$this->ID').prop('disabled', false);
         });";
      }

      $js = "
      <script>
         $(document).ready(function() {
            $('#$this->ID').select2({
               placeholder: '".$this->html->placeholder."',
               allowClear: ".$this->html->allowClear.",
            });
            $jsAdd
         });
      </script>";
      if($this->Comment != "")
      {
         $this->HTML = "
         <div class='item_$this->ID' style='width:100%;'>
            <div class='input-group'>
               <select $attr >".$this->html->innerHTML."</select>
               <span class='input-group-addon' tabindex='0' data-toggle='popover' title='$this->CommentTitle' data-html='true'
               data-content=\"$this->Comment\" data-trigger='focus' id='info_$this->ID'><i class='glyphicon glyphicon-info-sign'></i></span>
            </div>
         </div>".$js;
      }
      else{
         $this->HTML = "<div class='item_$this->ID'><select $attr >".$this->html->innerHTML."</select></div>".$js;
      }
   }

   public function reRender()
   {//used to regen the options if sql has changed
      $this->iniSQL($this->sql, $this->sqlGrouping);
      $this->renderOptions($this->Options);
      $this->render();
   }

}//eoNSelC



class ZoriDatalistControl extends ZoriSelectControl //>> extends ZoriControl2
{
   //public function __construct($proto)

   //public function iniSQL($sql, $sqlGrouping)

   //public function renderOptions($arrOption)

   public function render()
   {//print_rr($this);
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;
      if($this->html->style == null) $this->html->style = "width:100%;";

      $attr = self::renderAttributes($this->html, $enqoute);

      $js = "
      <script>
         $(document).ready(function() {

            $('#$this->ID').select2({
               placeholder: '".$this->html->placeholder."',
               allowClear: ".$this->html->allowClear.",
               tags: true
            });
         });
      </script>";
       if($this->Comment != "")
      {
         $this->HTML = "
         <div class='item_$this->ID'>
            <div class='input-group'>
               <select $attr >".$this->html->innerHTML."</select>
               <span class='input-group-addon' tabindex='0' data-toggle='popover' title='$this->CommentTitle' data-html='true'
               data-content='$this->Comment' data-trigger='focus' id='info_$this->ID'><i class='glyphicon glyphicon-info-sign'></i></span>
            </div>
         </div>".$js;
      }
      else{
         $this->HTML = "<div class='item_$this->ID'><select $attr >".$this->html->innerHTML."</select></div>".$js;
      }
   }
   //public function reRender()


}//eoNSelMulC

class ZoriSelectMultipleControl extends ZoriSelectControl
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {//print_rr($this);
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;
      $this->html->multiple = "multiple";

      $attr = self::renderAttributes($this->html, $enqoute);

      if($this->html->allowClear==""){$this->html->allowClear="true";}
      if($this->html->maximumSelectionLength ==""){$this->html->maximumSelectionLength="3";}

      $phpValue = explode(";", $this->VALUE);
      $jsValue = json_encode($phpValue);
      $js = "
      <script>
         $(document).ready(function() {
            //$('.select2_group').select2({});
            $('#$this->ID').select2({
               maximumSelectionLength: ".$this->html->maximumSelectionLength.",
               placeholder: '".$this->html->placeholder."',
               allowClear: ".$this->html->allowClear."
            });
            $('#$this->ID').val($jsValue).trigger('change');
         });
      </script>";
      if($this->Comment != "")
      {
         $this->HTML = "
         <div class='item_$this->ID'>
            <div class='input-group'>
               <select $attr >".$this->html->innerHTML."</select>
               <span class='input-group-addon' tabindex='0' data-toggle='popover' title='$this->CommentTitle' data-html='true'
               data-content='$this->Comment' data-trigger='focus' id='info_$this->ID'><i class='glyphicon glyphicon-info-sign'></i></span>
            </div>
         </div>".$js;
      }
      else{
         $this->HTML = "<div class='item_$this->ID'><select $attr multiple>".$this->html->innerHTML."</select></div>".$js;
      }
   }
}//eoNSelMulC


class ZoriDateControl extends ZoriControl2 // ZoriDateControl handles all the "dt" Fields of type date -- Gael.
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;

      ## Disable the control when readonly attribute is true. -- Gael.
      if($this->html->readonly == "true" || $this->html->readonly == "readonly" ){
         $jsAdd = "$('#$this->ID').prop('disabled', true);
         $('form[name=\"frmZori\"]').submit(function() {
            $('#$this->ID').prop('disabled', false);
         });";
      }

      if($this->isRequired == 0){
         if($this->VALUE === NULL || $this->VALUE == 0 || $this->VALUE == "0000-00-00" || $this->VALUE == ""){
            //print_rr("is not required ".$this->Name);
            $this->html->value =
            $this->VALUE = "";
            $jsClear = "'autoUpdateInput': false,";
            $jsApply =" $('#$this->ID').on('apply.daterangepicker', function(ev, picker) {
                           $(this).val(picker.startDate.format('YYYY/MM/DD'));
                        });";
         }
      }
      else{
         if ($this->VALUE === NULL || $this->VALUE == 0 || $this->VALUE == "0000-00-00" || $this->VALUE == ""){
            //print_rr("is required ".$this->Name);
            $this->html->value =
            $this->VALUE = date("Y-m-d");
            $jsClear = "";
         }
      }

      $attr = self::renderAttributes($this->html, $enqoute);

      $js = "
         <script>
            $(document).ready(function() {
               $('#$this->ID').daterangepicker({
                  'singleDatePicker': true,
                  'autoApply': true,
                  $jsClear
                  locale: {
                     format: 'YYYY/MM/DD'
                  }
               });
            });
            $jsApply
            $jsAdd
         </script>";

      $this->HTML = "
      <div class='item_$this->ID'>
      <div class='input-prepend input-group'>
      <span class='add-on input-group-addon'><i class='glyphicon glyphicon-calendar fa fa-calendar'></i></span>
      <input type='text' $attr /></div></div>".$js;
   }

}//endOfDateControl


class ZoriDateRangeControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;

      ## Disable the control when readonly attribute is true. -- Gael.
      if($this->html->readonly == "true" || $this->html->readonly == "readonly" ){
         $jsAdd = "$('#$this->ID').prop('disabled', true);
         $('form[name=\"frmZori\"]').submit(function() {
            $('#$this->ID').prop('disabled', false);
         });";
      }

      if($this->isRequired == 0){
         if($this->VALUE === NULL || $this->VALUE == 0 || $this->VALUE == "0000-00-00" || $this->VALUE == ""){
            //print_rr("is not required ".$this->Name);
            $this->html->value =
            $this->VALUE = "";
            $jsClear = "'autoUpdateInput': false,";
            $jsApply =" $('#$this->ID').on('apply.daterangepicker', function(ev, picker) {
                           $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
                        });";
         }
      }
      else{
         if ($this->VALUE === NULL || $this->VALUE == 0 || $this->VALUE == "0000-00-00" || $this->VALUE == ""){
            //print_rr("is required ".$this->Name);
            $this->html->value =
            $this->VALUE = date("Y-m-d");
            $jsClear = "";
         }
      }

      $attr = self::renderAttributes($this->html, $enqoute);

      $js="
      <script>
         $(document).ready(function() {
           $('#$this->ID').daterangepicker({
               timePicker: false,
               $jsClear
               locale: {
                  format: 'YYYY-MM-DD'
               }
            });
            $jsApply
            $jsAdd
         });
      </script>";

      $this->HTML = "
         <div class='item_$this->ID'>
         <div class='input-prepend input-group'>
            <span class='add-on input-group-addon'><i class='glyphicon glyphicon-calendar fa fa-calendar'></i></span>
            <input type=text $attr />
         </div></div>".$js;
   }

}//eoDtRanC

class ZoriDateTimeRangeControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;
      $this->html->class .= " form-control";

      ## Disable the control when readonly attribute is true. -- Gael.
      if($this->html->readonly == "true" || $this->html->readonly == "readonly" ){
         $jsAdd = "$('#$this->ID').prop('disabled', true);
         $('form[name=\"frmZori\"]').submit(function() {
            $('#$this->ID').prop('disabled', false);
         });";
      }

      if($this->isRequired == 0){
         if($this->VALUE === NULL || $this->VALUE == 0 || $this->VALUE == "0000-00-00 00:00" || $this->VALUE == ""){
            //print_rr("is not required ".$this->Name);
            $this->html->value =
            $this->VALUE = "";
            $jsClear = "'autoUpdateInput': false,";
            $jsApply =" $('#$this->ID').on('apply.daterangepicker', function(ev, picker) {
                           $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm') + ' - ' + picker.endDate.format('YYYY/MM/DD HH:mm'));
                        });";
         }
      }
      else{
         if ($this->VALUE === NULL || $this->VALUE == 0 || $this->VALUE == "0000-00-00 00:00" || $this->VALUE == ""){
            //print_rr("is required ".$this->Name);
            $this->html->value =
            $this->VALUE = date("Y-m-d HH:mm");
            $jsClear = "";
         }
      }

      $attr = self::renderAttributes($this->html, $enqoute);

      $js="
      <script>
         $(document).ready(function() {
           $('#$this->ID').daterangepicker({
               timePicker: true,
               timePickerIncrement: 15,
               $jsClear
               locale: {
                  format: 'YYYY-MM-DD HH:mm'
               }
            });
            $jsApply
            $jsAdd
         });
      </script>";
      $this->HTML = "
         <div class='item_$this->ID'>
         <div class='input-prepend input-group'>
            <span class='add-on input-group-addon'><i class='glyphicon glyphicon-calendar fa fa-calendar'></i></span>
            <input type=text $attr />
         </div></div>".$js;
   }

}//eoDtTRanC

class ZoriDateTimeControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;
      $this->html->class .= " form-control";

      ## Disable the control when readonly attribute is true. -- Gael.
      if($this->html->readonly == "true" || $this->html->readonly == "readonly" ){
         $jsAdd = "$('#$this->ID').prop('disabled', true);
         $('form[name=\"frmZori\"]').submit(function() {
            $('#$this->ID').prop('disabled', false);
         });";
      }

      if($this->isRequired == 0){
         if($this->VALUE === NULL || $this->VALUE == 0 || $this->VALUE == "0000-00-00 00:00" || $this->VALUE == ""){
            //print_rr("is not required ".$this->Name);
            $this->html->value =
            $this->VALUE = "";
            $jsClear = "'autoUpdateInput': false,";
            $jsApply =" $('#$this->ID').on('apply.daterangepicker', function(ev, picker) {
                           $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm'));
                        });";
         }
      }
      else{
         if ($this->VALUE === NULL || $this->VALUE == 0 || $this->VALUE == "0000-00-00 00:00" || $this->VALUE == ""){
            //print_rr("is required ".$this->Name);
            $this->html->value =
            $this->VALUE = date("Y-m-d");
            $jsClear = "";
         }
      }

      $attr = self::renderAttributes($this->html, $enqoute);
      $js = "
         <script>
            $(document).ready(function() {
               $('#$this->ID').daterangepicker({
                  'singleDatePicker': true,
                  'timePicker24Hour': true,
                  $jsClear
                  timePicker: true,
                  timePickerIncrement: 5,
                  locale: {
                     format: 'YYYY/MM/DD HH:mm'
                  }
               });
            });
            $jsApply
            $jsAdd
         </script>
      ";

      $this->HTML = "
      <div class='item_$this->ID'> 
         <div class='input-prepend input-group'> 
            <span class='add-on input-group-addon'><i class='glyphicon glyphicon-calendar fa fa-calendar'></i></span> 
            <input type=text $attr /> 
         </div>
      </div>".$js; 
   }
}//end of ZoriDateTimeControl.




class ZoriCustomControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render($HTML=null)
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;
   
      $this->HTML = $HTML;
   }
}//eoNIC

class ZoriLinkButtonControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render($enqoute="\"")
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;
      $this->html->class = "form-control";

      $attr = self::renderAttributes($this->html, $enqoute);
      if($this->Comment != "")
      {
         $this->HTML = "
         <div class='item_$this->ID'>
            <div class='input-group'>
               <a $attr >$this->Label</a>
               <span class='input-group-addon' tabindex='0' data-toggle='popover' title='$this->CommentTitle' data-html='true'
               data-content='$this->Comment' data-trigger='focus' id='info_$this->ID'><i class='glyphicon glyphicon-info-sign'></i></span>
            </div>
         </div>".$js;
      }
      else{
         $this->HTML = "<div class='item_$this->ID'><a $attr >$this->Label</a></div>".$js;
      }

//vd($this->HTML); die;
   }

}//eoNLinlC

class ZoriTimeControl extends ZoriControl2
{
   public function __construct($proto){
      foreach($proto as $key => &$value){
         //vd($key); vd($value);
         $this->{$key} = $value;
      }
      //print_rr($this);
   }

   public function render()
   {
      $this->html->id = $this->ID;
      $this->html->name = $this->Name;
      $this->html->class = "form-control";

      $attr = self::renderAttributes($this->html, $enqoute);
      $name_start = $attr->name."_start";
      $name_end = $attr->name."_end";
      $js = "
      <script>
         $(document).ready(function(){
            $('#".$this->ID."_Start').timepicker();
            $('#".$this->ID."_End').timepicker();
         });
      </script>
      ";

     
     if($this->Comment != "")
      {
         $this->HTML = "
         <div class='item_$this->ID'>
            <div class='input-group'>
               <table width=100% cellspacing='3' cellpadding='1' style='margin-top:-6px;'><tr>
               <td style='padding:10px; font-size:14px;'>From:</td><td>
                  <div class='input-group bootstrap-timepicker timepicker'>
                     <input id='".$this->ID."_Start' name='".$this->ID."_Start' type='text' class='".$this->html->class." input-small'>
                     <span class='input-group-addon'><i class='glyphicon glyphicon-time'></i></span>
                  </div></td><td style='padding:10px; font-size:14px;'>To:</td><td>
                  <div class='input-group bootstrap-timepicker timepicker'>
                     <input id='".$this->ID."_End' name='".$this->ID."_End' type='text' class='".$this->html->class." input-small'>
                     <span class='input-group-addon'><i class='glyphicon glyphicon-time'></i></span>
                  </div></td>
               </tr></table>
               <span class='input-group-addon' tabindex='0' data-toggle='popover' title='$this->CommentTitle' data-html='true'
               data-content='$this->Comment' data-trigger='focus' id='info_$this->ID'><i class='glyphicon glyphicon-info-sign'></i></span>
            </div>
         </div>".$js;
      }
      else{
         $this->HTML = "<div class='item_$this->ID'>
                           <table width=100% cellspacing='3' cellpadding='1' style='margin-top:-6px;'><tr>
                           <td style='padding:10px; font-size:14px;'>From:</td><td>
                              <div class='input-group bootstrap-timepicker timepicker'>
                                 <input id='".$this->ID."_Start' name='".$this->ID."_Start' type='text' class='".$this->html->class." input-small'>
                                 <span class='input-group-addon'><i class='glyphicon glyphicon-time'></i></span>
                              </div></td><td style='padding:10px; font-size:14px;'>To:</td><td>
                              <div class='input-group bootstrap-timepicker timepicker'>
                                 <input id='".$this->ID."_End' name='".$this->ID."_End' type='text' class='".$this->html->class." input-small'>
                                 <span class='input-group-addon'><i class='glyphicon glyphicon-time'></i></span>
                              </div></td>
                           </tr></table>
                        </div>".$js;
      }
   }

}//eoNTxC
?>