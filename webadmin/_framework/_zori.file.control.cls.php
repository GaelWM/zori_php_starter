<?php

/**
  * Date: 2017/01/10
    File Name: _Zori.file.control.cls.php
    Class Name: ZoriFileUploadControl
    Author: Neil S
    Modify By: Gael Musikingala 10/02/2017
*/

class ZoriFileUploadControl extends ZoriControl2
{
    //FILE UPLOAD CONTROL ATTRIBUTES
    public $strPath;
    public $ajaxFunction;  //the name of the ajax function we want to call, the process
    public $ajaxParams;  //if we want to add additional parameters to the ajax functions
    public $css;
    public $uploadType;
    public $js;
    // public $jsExtra;
    // public $fileFormat = null;   //types of files we want to allow/accept... rejects all other formats.

   public function __construct($proto)
   {//ini
      foreach($proto as $key => &$value){
        $this->{$key} = $value;
      }
   }

   public function render()
   {//print_rr($this);

      if ($this->ID < 0){
         $this->ID = ($this->ID * (-1));  //make a positive number - js issue - neils
      }

      $this->html->name = "file".$this->ID;
      $this->html->id = "file".$this->ID;
      $this->html->active = 1;  //whether control should be disabled or enabled
      $this->html->class = "";
      //$this->html->tooltip = "";  //the tooltip for the control
      //$this->html->drag_and_drop = 0;  //whether the control can be drag-and-droppable
      //$this->html->css->hover = ""; //when hovering over the control
      $this->html->style = "";

      $label_ID = "fileupload".$this->ID; //the label for the input button
      $this->css = "#".$this->html->id."[type='file']{
                                    display: none;
                                  }
                                  #".$label_ID.":hover{
                                    cursor: pointer;
                                    color: rgb(35, 82, 124);
                                  }";
      $ajaxParams->Path = $this->strPath;

      foreach($ajaxParams as $key => $value){
         $this->ajaxParams .= "&$key=$value";
      }


      if($this->VALUE == "")
      {
         // $fileLink = "<a id='fileView$this->ID' target='_blank'>No training certificate has been uploaded yet.</a>";
        $fileLink = "<a id='fileView$this->ID' target='_blank'>No ".strtolower($this->uploadType)." has been uploaded yet.</a>";
      }else{
         $fileLink = "<a id='fileView$this->ID' href='". $this->strPath . $this->VALUE ."' target='_blank'>". $this->VALUE ."</a>";
      }
      //js for updating training certificate link
      $fileDate = $this->ID ."_". date("y-m-d") ."_";
      $jsExtra = "$('#fileView$this->ID').prop('href','".$this->strPath."' + '$fileDate' + $('#file$this->ID').val());
               document.getElementById('fileView$this->ID').innerHTML = '$fileDate' + $('#file$this->ID').val();";



      $this->html->onChange = "Upload_$this->ID(event);"; // changed the $this->onChange to $this->html->onChange
      $this->js .= "
        function Upload_$this->ID(event)
        {
            var formData = new FormData();
            formData.append('file', $('#".$this->html->id."')[0].files[0]);

            $.ajax({
                  type: 'POST',
                  url: 'ajaxFunctions.php?type=$this->ajaxFunction".(isset($this->ajaxParams) ? $this->ajaxParams : "")."',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(data){

                    //console.log(data);
                    //alert(data);

                    if (data == 0){
                      new PNotify({
                          title: 'Error',
                          text: 'Error occured, file was not upload.',
                          type: 'error',
                          styling: 'bootstrap3'
                          });

                    } else {
                      new PNotify({
                          title: 'Successfully',
                          //text: data+' has been successfully uploaded.',
                          text: data,
                          type: 'success',
                          styling: 'bootstrap3'
                          });

                           $jsExtra
                          /*$this->jsExtra*/

                    }
                  }

               });



        }";
        if ($this->ajaxFunction == "UploadProfilePicture" || $this->ajaxFunction == "UploadProduct"){
          $this->js .= "
            var loadFileFotos_$this->ID = function(event) {
               var output = document.getElementById('outputFotos$this->ID');
               output.src = URL.createObjectURL(event.target.files[0]);
            };";
        }


        //$this->Droppable = false;
        //$this->MultipleFiles = false;
        //make the control drang_n_droppable
        $this->js .= "var file = document.getElementById('$label_ID');
                     file.ondragover = function () { this.className = 'draghover'; return false; };
                     file.ondragend = function () { this.className = ''; return false; };
                     file.ondrop = function (event) {
                       event.preventDefault && event.preventDefault();
                       this.className = '';
                       var files = event.dataTransfer.files;

                       var str = '';

                        var formData = new FormData();
                        for (var i = 0; i < files.length; i++) {
                          formData.append('file', files[i]);
                          str += files[i].name;
                        }

                        //document.getElementById('#".$this->html->id."').value = str;

                        $.ajax({
                              type: 'POST',
                              url: 'ajaxFunctions.php?type=$this->ajaxFunction".(isset($this->ajaxParams) ? $this->ajaxParams : "")."',
                              data: formData,
                              processData: false,
                              contentType: false,
                              success: function(data){

                                if (data == 0){
                                  new PNotify({
                                      title: 'Error',
                                      text: 'Error occured, file was not upload.',
                                      type: 'error',
                                      styling: 'bootstrap3'
                                      });

                                } else {
                                  new PNotify({
                                      title: 'Successfully',
                                      //text: data+' has been successfully uploaded.',
                                      text: data,
                                      type: 'success',
                                      styling: 'bootstrap3'
                                      });

                                       $jsExtra

                                }
                              }

                           });

                           while(/\s/g.test(str)){
                              str = str.replace(/\s/, '_');
                           }

                           var type = '$this->ajaxFunction';

                           if (type == 'UploadProfilePicture'){
                              //alert('UploadProfilePicture');

                              // var outputt = document.getElementById('outputFotos$this->ID');
                              // outputt.src = URL.createObjectURL(files);

                              //alert('$this->strPath'+'$fileDate'+str);
                              setTimeout($('#outputFotos$this->ID').attr('src', '$this->strPath' + '$fileDate' + str), 2000);
                              //$('#outputFotos$this->ID').attr('src', '$this->strPath' + '$fileDate' + str);

                              //document.getElementById('outputFotos$this->ID').src = '$this->strPath' + '$fileDate' + str;
                              //$('#outputFotos$this->ID').prop('src','".$this->strPath."' + '$fileDate' + str);
                           } 
                           else {
                              //alert('UploadTC');
                              $('#fileView$this->ID').prop('href','".$this->strPath."' + '$fileDate' + str);
                              document.getElementById('fileView$this->ID').innerHTML = '$fileDate' + str;
                           }

                       return false;
                     };";


      // print_rr($fileLink);
      // print_rr($this->jsExtra);


      $attr = self::renderAttributes($this->html, $enqoute);
    
      //set css states
      $this->css = "#".$this->html->id."[type='file']{
                                    display: none;
                                  }
                                  #".$label_ID.":hover{
                                    cursor: pointer;
                                    color: rgb(35, 82, 124);
                                    ".$this->html->css->hover."
                                  }
                                  #".$label_ID.":focus{
                                    ".$this->html->css->focus."
                                  }";

      //Set styling and stuff like that, before rendering the control.

      //$labelStyle = "";
      if ($this->ajaxFunction == "UploadProfilePicture" || $this->ajaxFunction == "UploadProduct"){
          $labelStyle = "width: auto/*244px*/; height: auto/*154px*/; xborder: 1px dashed black;";
          $imgStyle = "/*border-radius: 10px;*/ /*width: 242px;*/ height: 152px;";
      } else {
        $labelStyle = "width: 196px; height: 52px; border: /*1px dashed black*/3px dashed rgb(115, 135, 156);";
      }
          
      $innerHTML = "<label id='".$label_ID."' for='".$this->html->id."' 
      style='xborder: 1px dashed black; $labelStyle xheight: 50px; xwidth: 150px; text-align: center;line-height: 45px;
      border-radius: 5px/*25px*/;".$this->html->style."' 
      class='".$this->html->class."'>".($this->ajaxFunction == "UploadProfilePicture" || $this->ajaxFunction == "UploadProduct"?"
         <img id='outputFotos$this->ID' xheight='150px' xheight='150px' style='$imgStyle float: left;' src='".(isset($this->VALUE)?$this->strPath.$this->VALUE:$this->strPath.($this->ajaxFunction == "UploadProduct"?"blankProduct.jpg":"blank.jpg"))."'/>": "Upload File")."</label>";

      $innerHTML .= "<input id='".$this->html->id."' type='file' ";  //opening...
      //$this->onChange = ($this->ajaxFunction == "UploadDocument"? "UploadDocument_$ID(event);":"UploadProfilePicture_$ID(event);"); //determines what onchange function to call
      $innerHTML .= "onchange='".$this->html->onChange."".($this->ajaxFunction == "UploadProfilePicture" || $this->ajaxFunction == "UploadProduct"?" loadFileFotos_".$this->ID."(event);":"")."'";
      $innerHTML .= ($this->ajaxFunction == "UploadProfilePicture" || $this->ajaxFunction == "UploadProduct" ? " accept='image/*'":"");
      //$this->html->innerHTML .= ($this->ajaxFunction == "UploadProfilePicture" ? "accept='image/*'":"");  //if profile picture, then default extentions to images.
      $innerHTML .= ($this->html->active?"":"disabled");  //check whether control should be disabled or enabled
      $innerHTML .= "/>"; //closing...

      $js = "<script>".$this->js."</script>";

      $trainningCertificateLink = "";
      // if ($this->ajaxFunction == "UploadTrainningCertificate"){
      //    $trainningCertificateLink = "<span style='line-height: 2.7;'>$fileLink</span><br><br>";
      // }
      if ($this->ajaxFunction == "UploadTrainningCertificate" || $this->ajaxFunction == "UploadDocument"){
         $trainningCertificateLink = "<span style='line-height: 2.7;'>$fileLink</span><br><br>";
      }

      // $this->HTML = "<style>".$this->css."</style>".$trainningCertificateLink.$innerHTML.$js.($this->ajaxFunction == "UploadProfilePicture"?"<br><span>Click above  to upload a photo</span>":"<br><span>Click above  to upload training certificate</span>");
      $this->HTML = "<style>".$this->css."</style>".$trainningCertificateLink.$innerHTML.$js.($this->ajaxFunction == "UploadProfilePicture"?"<br><span>Click above  to upload a photo</span>":"<br><span>Click above  to upload ".strtolower($this->uploadType)."</span>");
   }

  

}//eoNSelMulC

?>