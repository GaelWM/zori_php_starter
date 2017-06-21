<?php

include_once("_nemo.cls.php");

class NemoCalendar Extends Nemo
{
   public $Data;

   public $viewCurrentDay = "";
   public $viewMonth = "";
   public $viewStartDate = "";
   public $viewEndDate = "";
   public $viewWeeks = 4;

   public $blnShowWeekends = true;

   // public $EntryTemplateHTML = "\$divEntry .= \"<tr style='' onclick='\$entry->Action' >
   //          <td>\$entry->strEntry</td>
   //          <td align=right><span title='\$entry->lblFact1'>\$entry->strFact1</span></td>
   //          <td align=right><span title='\$entry->lblFact2'>\$entry->strFact2</span></td>
   //       </tr>\";";

   // $divEntry .= sprintf($this->EntryTemplateHTML, $entry->EntryType, $entry->EntryID, $entry->Action
   //    , $entry->strEntry
   //    , $entry->lblFact1, $entry->strFact1
   //    , $entry->lblFact2, $entry->strFact2
   //    );

   public $EntryTemplateHTML = "
      <tr EntryType='%s' EntryID='%d' %s style='' class='trCalendarEntry'>
         <td>%s</td>
         <td align=right><span title=\"%s\">%s</span></td>
         <td align=right><span title=\"%s\">%s</span></td>
      </tr>";

   public $DayTemplateTAG = "<table border=0 cellpadding=2 cellspacing=0 width=100% class='tblNemoList'>";

   public $EntryType;
   public $EntryID;

   public $Caption = "";


	public function __construct($strCaption, $dtStartDate, $dtEndDate=null)
   {
      $this->Caption = $strCaption;

      $this->viewMonth = date("M", strtotime($dtStartDate));
      $this->viewMonthStartDate = date("Y-m-01", strtotime($dtStartDate));

      //set viewStart/End dates
      if(date("D", strtotime($dtStartDate)) != "Mon"){
         $this->viewStartDate = date("Y-m-d", strtotime("$dtStartDate previous Monday"));
      }else{
         $this->viewStartDate = date("Y-m-d", strtotime("$dtStartDate Monday"));
      }

      if($dtEndDate == null)
         $dtEndDate = date("Y-m-d", strtotime("$dtStartDate +$this->viewWeeks Weeks"));

      if(date("D", strtotime($dtEndDate)) != "Sun"){
         $this->viewEndDate = date("Y-m-d", strtotime("$dtEndDate next Sunday"));
      }else{
         $this->viewEndDate = date("Y-m-d", strtotime("$dtEndDate Sunday"));
      }
      //vd(date("W", strtotime($this->viewEndDate) - strtotime($this->viewStartDate)));

      $this->Filters[frStartDate]->tag = "input";
      $this->Filters[frStartDate]->html->type = "text"; //hidden

      $this->Filters[frStudyID]->tag = "input";
      $this->Filters[frStudyID]->html->type = "text"; //hidden

      $this->Filters[frMode]->tag = "input";
      $this->Filters[frMode]->html->type = "text"; //hidden

      $this->Filters[frCurrentDay]->tag = "input";
      $this->Filters[frCurrentDay]->html->type = "text"; //hidden

//print_rr($this);
      parent::__construct();

      $this->viewCurrentDay = $this->Filters[frCurrentDay]->html->value;
   }

//*************************
//***PUBLIC FUNCTIONS******
//*************************
   public function getData($EntryType=null, $EntryID=null)
   {
      global $xdb, $TR, $SP, $HR, $BR, $DT, $SystemSettings;

      $this->EntryType = $EntryType;
      $this->EntryID = $EntryID;
      if($this->EntryType != null)
      {
         $where .= " AND EntryType IN(\"$this->EntryType\")";
      }
      if($this->EntryID != null)
      {
         $where .= " AND EntryID IN(\"$this->EntryID\")";
      }

      $rst = $xdb->doQuery("SELECT * FROM vieCalendar
         WHERE dtEntry BETWEEN '$this->viewStartDate' AND '$this->viewEndDate' $where
         ORDER BY dtEntry, strPriority, intOrder, strEntry",0);
      while($row = $xdb->fetch())
      {
         $this->Data[$row->dtEntry]->rows[] = $row;
      }

      //print_rr($this->Data);

      return $this->Data;
   }


   public function renderCalendar($htmlAddtional=null)
   {
      global $xdb, $TR, $SP, $HR, $BR, $DT, $SystemSettings;


      $d = "Y-m-d";
      $D = "D";
      $m = "Y-m";
      $w = "W";
      $dt = date($d);

      //0 - create calendar structure
      //1 - push data to structure & build display

      //0 - create calendar structure
      $trHeadings = "";
      for($i = 0; $i < 7; $i++)
      {
         $day = date($D, strtotime("Monday +$i Days"));
         if($this->blnShowWeekends == false && ($day == "Sat" || $day == "Sun")){
            continue;
         }

         $this->Calendar->Days[] = $day;
         $trHeadings .= "<th>$day</th>";
      }

      $trHeadings = "
         <tr>
            <th>#</th>
            <th>Week</th>
            $trHeadings
         </tr>";

      $idxDay = $this->viewStartDate;
      while($idxDay <= $this->viewEndDate)
      {
         //debug
         $i++;
         if($i > 50)
            break;

         //ini
         $stt = strtotime($idxDay);
         $idxM = date($m, $stt);
         $idxW = date($w, $stt);

         $Day = new stdClass();
         $Day->date = $idxDay;
         $Day->dateShort = date("j", $stt);
         $Day->day = date($D, $stt);
         $Day->blnToday = false;

         if($idxDay == $dt)
            $Day->blnToday = true;

         if($this->blnShowWeekends == false && ($Day->day == "Sat" || $Day->day == "Sun")){
            $idxDay = date($d, strtotime("$idxDay +1 Day"));
            continue;
         }

         $this->Calendar->Weeks[$idxW]->Days[] = $Day;

         //post
         $idxDay = date($d, strtotime("$idxDay +1 Day"));


      }

      //print_rr($this->Calendar);
      //1 - push data to structure & build display
      $i = 0;
      $trCalendar =
      $currentMonth = "";
      foreach ($this->Calendar->Weeks as $idxW => $Week)
      {//print_rr($Week); //die;

         $i++;
         $trCalendar .= "
         <tr class='trCalendarWeek'>
            <th class='tdCalendarCount tdCount textColour ' align='right'>$i</th>
            <th class='tdCalendarWeek' >Week: ". (int) $idxW ."</th>";

         foreach($Week->Days as $j => $Day)
         {//print_rr($Day);
            $idxDay = $Day->date;
            $idxDayJS = str_replace("-","",$Day->date);
            $stt = strtotime($idxDay);
            $idxM = date($m, $stt);
            $idxW = date($w, $stt);
            $cssToday = "";

            if($currentMonth != $idxM)
               $Day->dateShort = "<b>".date("j M", $stt)."</b>";
            if($Day->blnToday == true)
               $cssToday = " tdCalendarToday";

            $trCalendar .= "
            <td class='tdCalendarDay$cssToday' name='tdCalendarDay' id=\"tdCalendarDay_$idxDay\" onclick=\"setViewCurrentDay('$idxDay');\">
               <div style='float: right' class='divCalendarLblDay'>". $Day->dateShort ."</div>
               <div >
                  <div class='divCalendarDayData'>". $this->renderDay($this->Data[$idxDay]->rows) ."</div>
               </div>
            </td>";

            $currentMonth = $idxM;
         }



         $trCalendar .= "</tr>";
      }

      //print_rr($this->Filters);

      if($this->Filters){
      foreach($this->Filters as $key => $filter){
         $htmlFilters .= NemoControl::renderControl($filter->tag, $filter->html);
      }}

      return "
         <table border=0 width='1000px' class='tblCalendar' cellpadding=2 cellspacing=1>
            <caption >
               <span >
                  <a href='?Action=Nav&frStartDate=". date("Y-m-01", strtotime("$this->viewMonthStartDate -1 month")) ."'>&lt;&lt;</a>
                  $SP$SP
                  $this->viewMonth
                  $SP$SP
                  <a href='?Action=Nav&frStartDate=". date("Y-m-01", strtotime("$this->viewMonthStartDate +1 month")) ."'>&gt;&gt;</a></span>
               $this->Caption
            </caption>
            $trHeadings
            $trCalendar
         </table>
         $htmlFilters"
         . js("
            function setViewCurrentDay(idxDay)
            {//alert(idxDayJS);

               var dtCurrentDay = $('td[name=\"tdCalendarDay\"][id=\"tdCalendarDay_'+ idxDay +'\"]');

               $('td[name=\"tdCalendarDay\"]').removeClass('tdCalendarCurrent');

               dtCurrentDay.addClass('tdCalendarCurrent');
               //dtCurrentDay.toggleClass('tdCalendarCurrent'); //works nicely, but not suitable for this

               var viewCurrentDay = $('#frCurrentDay');
               viewCurrentDay.val(idxDay);

            }

            setViewCurrentDay('$this->viewCurrentDay');
            ")
         . $htmlAddtional;
   }

//*************************
//***PRIVATE FUNCTIONS*****
//*************************
   private function renderDay($arrEntry)
   {//print_rr($arrEntry);
      global $xdb, $TR, $SP, $HR, $BR, $DT, $SystemSettings;
      $divEntry = "";

      if(is_array($arrEntry)){
      foreach ($arrEntry as $i => $entry)
      {//print_rr($entry);

         // $divEntry .= "<tr style='' onclick=\"$entry->Action\" >
         //    <td>$entry->strEntry</td>
         //    <td align=right><span title=\"$entry->lblFact1\">$entry->strFact1</span></td>
         //    <td align=right><span title=\"$entry->lblFact2\">$entry->strFact2</span></td>
         // </tr>";

         //eval($this->EntryTemplateHTML);

         if($entry->Action != "") $entry->Action = "onclick=\"$entry->Action\"";
         $divEntry .= sprintf($this->EntryTemplateHTML, $entry->EntryType, $entry->EntryID, $entry->Action
            , $entry->strEntry
            , $entry->lblFact1, $entry->strFact1
            , $entry->lblFact2, $entry->strFact2
            );

      }}
// vd($this->DayTemplateTAG . $divEntry . str_replace("<", "</", $this->DayTemplateTAG));
//    echo $BR;
      return $this->DayTemplateTAG . $divEntry . str_replace("<", "</", $this->DayTemplateTAG);
   }

   public static function getCalendarEntryDiv($htmlAdditional)
   {
      global $xdb, $TR, $SP, $HR, $BR, $DT, $SystemSettings;
      return "
         <div id='divCalendarEntry' xclass='tblNemoList'>
         </div>"
         . $htmlAdditional;
   }

//*************************
//***OVERRIDES******
//*************************
   public function Display($index="")
   {

      if(empty($index))
         $index = "layout.back.calendar.incl.php";

      include_once($this->Layouts[$index]);
   }

   protected function Sandbox()
   {
      return "
      <table border='0' cellpadding='2' cellspacing='1' width='100%' id='tblContent'>
         <tr>
            <td align='left' valign='top' id='tdContentRight'>
               <div id='divContentx'>
               ". $this->ContentLeft ."
               </div>
            </td>
            <td align='left' valign='top' id='tdContentLeft'>
               <div id='divContentx'>
               ". $this->ContentRight ."
               </div>

            </td>
         </tr>
         <tr><td colspan='100%' style='background: transparent; padding: 0px;'>". $this->Content ."</td></tr>
      </table>
      ";
   }


}//eoC
?>