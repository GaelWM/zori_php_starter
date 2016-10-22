<?php
   ini_set('display_errors', '0');
   error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);

	function print_rr($value)
	{
		echo "<PRE>";
		print_r($value);
		echo "</PRE>";
	}
	function vd($value)
	{
	   var_dump($value);
	}
	function toMysqlDateFormat($date)
	{
		$newDate = date("Y-m-d", strtotime($date));
		return $newDate;
	}
	function isValidEmail($email){
      //return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);

      //UPDATED CODE FOR VALIDATE EMAIL - JACQUES 20131121
      return filter_var($email, FILTER_VALIDATE_EMAIL);
   }

   function qs($value){

      $translateTable = array("\""=>"'",
                              "�"=>"'",
                              "`"=>"'",
                              "’"=>"'",
                              '�'=>'"',
                              '�'=>'"',
                              "�"=>"...",
                              "–"=>"-",
                              "�"=>"-");//"funny chars" => "new chars". just add into the array
//echo "<BR>". vd($value);
      $value = strtr($value, $translateTable);//return $value; // strtr: foreach char in $value, if char == A then set char = B
      $value = trim($value);
      if (get_magic_quotes_gpc())
         $value = stripslashes($value);

      $value = str_replace('"',"'",$value);

      return $value;
   }

   function nCopy($obj)
   {
      return unserialize(serialize($obj));
   }

   /*
    * 20110125 - converts excel date to timestamp - pj
   */
   function exceltotime($intDays)
   {
      $intDaysOffsetFromFuckingMSdate = 36526; //ori 36524 days between 1 jan 1900 and 1 jan 2000, but ms dates run from 0 jan 1900... wtf
      $arrDT = explode(".",($intDays - $intDaysOffsetFromFuckingMSdate));//excel date has days.%time

      $intDays = $arrDT[0];
      $dtJan = strtotime("1 Jan 2000");
      $dt = strtotime("+ $intDays Days", $dtJan);

      $strDate = date("Ymd", $dt);

      if($strDate == "19700101")
         return false;
      else
         return $strDate;

   }

   function Obfuscate(){
      return GLC(newIP());
   }

//******************************
//**PROJECT SPECIFIC FU*CTIONS**
//******************************
   /*
    * Login Facillity added by Stephen on the 20101126
    */

   function tblLoginInsert($message)
   {
      global $strUsername , $strPassword;
      $vdb = new NemoDatabase("sysLogin", 0, null, 0);
      $vdb->Fields[strIP] = $_SERVER['REMOTE_ADDR'];
      $vdb->Fields[strResult] = $message;
      $vdb->Fields[strUsername] = $strUsername;
      $vdb->Fields[strPassword] = "******"; //$strPassword; //20150708 - popi changes - pj
      //unset($vdb->FieldList[5]);// = date("YmdHi");
      //print_rr($vdb);
      $vdb->Save();
   }

   function tblSpamInsert($strSpam, $strEmail)
   {
      $sdb = new NemoDatabase("sysSpam", 0, null, 0);
      $sdb->Fields[strSpam] = $strSpam;
      $sdb->Fields[strEmail] = $strEmail;
      $sdb->Fields[strIP] = $_SERVER['REMOTE_ADDR'];
      //unset($vdb->FieldList[5]);// = date("YmdHi");
      //print_rr($vdb);
      $sdb->Save();
   }

   /*
    * SMS Facility Added by Stephen 20 December 2010
    */
   function SendSMS($smsNumber, $smsMessage)
   {
      global $SystemSettings;

      $data= array(
         "Type"=> "sendparam",
         "Username" => $SystemSettings[smsUsername],
         "Password" => $SystemSettings[smsPassword],
         "live" => $SystemSettings[smsLive],
         "numto" => $smsNumber,
         "data1" => $smsMessage); //This contains data that you will send to the server.

      $data = http_build_query($data); //builds the post string ready for posting
      return do_post_request("http://www.mymobileapi.com/api5/http5.aspx", $data);  //Sends the post, and returns the result from the server.
   }

   function do_post_request($url, $data, $optional_headers = null)
   {
      $params = array("http" => array(
               "method" => "POST",
               "content" => $data
            ));
      if ($optional_headers !== null) {
      $params["http"]["header"] = $optional_headers;
      }

      $ctx = stream_context_create($params);
      $fp = @fopen($url, "rb", false, $ctx);

      if (!$fp) {
         echo "Problem with $url: ";
         print_rr(error_get_last());
         die;
         throw new Exception("Problem with $url, ". print_rr(error_get_last()));
      }


      $response = @stream_get_contents($fp);
      if ($response === false) {
         echo "Problem reading data from $url: ";
         print_rr(error_get_last());
         die;
         throw new Exception("Problem reading data from $url, ". error_get_last());
      }
      $response;
      return formatXmlString($response);
   }
   function formatXmlString($xml)
   {
      // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
      $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);

      // now indent the tags
      $token      = strtok($xml, "\n");
      $result     = ''; // holds formatted version as it is built
      $pad        = 0; // initial indent
      $matches    = array(); // returns from preg_matches()

      // scan each line and adjust indent based on opening/closing tags
      while ($token !== false) :
         // test for the various tag states
         // 1. open and closing tags on same line - no change
         if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
            $indent=0;
         // 2. closing tag - outdent now
         elseif (preg_match('/^<\/\w/', $token, $matches)) :
            $pad--;
         // 3. opening tag - don't pad this one, only subsequent tags
         elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
            $indent=1;
         // 4. no indentation needed
         else :
            $indent = 0;
         endif;
         // pad the line with the required number of leading spaces
         $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
         $result .= $line . "\n"; // add to the cumulative result, with linefeed
         $token   = strtok("\n"); // get the next token
         $pad    += $indent; // update the pad size for subsequent lines
      endwhile;

      $pos = strpos($result, "False");
      if($pos == "")
      {
         $result = "SMS Sent Successfully.";
      }
      else
      {
         $result = "Error Sending SMS: ". str_replace("False","" , $result);
      }
      return $result;
   }

   /*function vd($var)
   {
      var_dump($var);
   }*/
   function gpc_extract($array, &$target, $overrideDebug=0)
	{
		if($overrideDebug == 1)
			print_rr($array);

      $is_magic_quotes = get_magic_quotes_gpc();
      foreach ($array AS $key => $value)
		{
         if($is_magic_quotes){
            $target[$key] = @stripslashes($value);
         } else {
            $target[$key] = $value;
         }
			if($overrideDebug == 1)
				echo "\n\r<BR \>$key => $value";

      }
      return TRUE;
   }
	function localize($obj, $overrideDebug=0)
	{
		gpc_extract($obj, $GLOBALS, $overrideDebug);
	}

   //UTILITY FUNCTIONS
   /*function print_rr($value, $blnString=false)
   {
      echo "<PRE>";
      print_r($value,$blnString);
      echo "</PRE>";
   }*/

   function changeSort($sort){
      $arrSwop = array('ASC' => 'DESC','DESC' => 'ASC');
      return $arrSwop[$sort];
   }

   function swapIt($c){
      $arrSwop = array("#E1E0DF" => "#FEFEFE","#FEFEFE" => "#E1E0DF");
      return $arrSwop[$sort];
   }

   function roundUp($dblValue, $div, $mean)
   {
      $dblValue =  round($dblValue / $div / $mean, 2);
      $dblValue =  round($dblValue, 1);
	   $dblValue =  round($dblValue * $mean, 1);
      return $dblValue;
   }

   function windowLocation($strPage, $target="")
   {
      echo "<script>window.". $target ."location.href=\"$strPage\";</script>";
   }

   function alert($strMessage)
   {
      return "<script>alert(\"$strMessage\");</script>";
   }

   function js($strCommand)
   {
      return "<script>$strCommand</script>";
   }


	
?>