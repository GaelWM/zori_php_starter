<?php
	/**
	* GAEL MUSI-- 20160620
	*/

	require_once("project_files/mpdf/mpdf.php");

	class PDF extends mPDF
	{
		private $format; // e.g A3, A4, A5 etc. 
		private $font; // e.g Arial
		private $size; // e.g 9px;
		private $marginLeft;
		private $marginRight;
		private $marginTop;
		private $marginBottom;
		private $marginLeft;
		private $marginHeader;
		private $marginFooter;

		function __construct(argument)
		{
			$mpdf = new mPDF('utf-8', $format ,9,'Arial');
	        $mpdf->setHTMLHeader(getPDFHeader($COMPANYNAME));
	        $mpdf->setHTMLFooter(getPDFFooter());
	        if($orientation == 'P'){$mpdf->AddPage($orientation,'', '' ,'','',15,15,20,16,7,9);}else{$mpdf->AddPage($orientation,'', '' ,'','',30,30,30,30,18,12);}
	        $mpdf->WriteHTML($OutputPDF);
	        $mpdf->Output($strFilename."pdf", "I");

		}

		function getFooter() // Custom Footer 
	   	{
	      $PDFFooter = "
	      <hr /> 
	      <div style=' position:relative; width:95%; margin:0% 2.5% 2% 2.5%;'>
	         <table width='100%' border='0' align='center' cellspacing='1' cellpadding='2' >
	            <tr>
	               <td align='left'><b>Print Date: ".date("d F Y")."</b></td>
	               <td align='right'><b>Page {PAGENO} of {nbpg}</b></td>
	            </tr>
	         </table>
	      </div>";
	      return $PDFFooter;
	   	}

	   function getHeader($title)// Custom header
	   {
	      $PDFHeader = "
	      <div>
	         <h2 style='text-align:center' >$title</h2>
	      </div>";
	      return $PDFHeader;
	   }
	}
?>