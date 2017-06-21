<?php
include_once("systems.php");

class ZoriMenu
{
   public $Control;
   public $ControlSideBar;
   public $Tier1 = array();
   public $Tier2 = array();

   public $SystemSettings = array();
   //private $db;


   public function __construct($zori=null)
   {
      global $SystemSettings;

      $this->SystemSettings = $SystemSettings;

      if(isset($zori))
         $this->SystemSettings = $zori->SystemSettings;

      //$this->db = new NemoDatabase("");

   }

   private function __autoload()
   {
   }

   public function setSecurityGroup($SGID)
   {
      $this->SystemSettings[USER]->SECURITYGROUPID = $SGID;
   }

   public function getControl()
   {
      return $this->Control;
   }

   // public function BuildMenu()
   // {
   //    //ini
   //    global $SystemSettings, $xdb;
   //    $xdb = new ZoriDatabase("",null,null,0);

   //    $rst1 = $xdb->doQuery("
   //       SELECT sysMenuLevel1.MenuLevel1ID AS ID, sysMenuLevel1.strMenuLevel1 AS Label, sysMenuLevel1.strUrl AS URL, Count(sysMenuLevel2.MenuLevel2ID) as Children, sysMenuLevel1.intOrder AS 'Order'
   //       FROM (sysSecurity INNER JOIN (sysMenuLevel2 INNER JOIN sysMenuLevel1 ON sysMenuLevel2.MenuLevel1ID = sysMenuLevel1.MenuLevel1ID) ON sysSecurity.refMenulevel2ID = sysMenuLevel2.MenuLevel2ID) INNER JOIN sysSecurityGroup ON sysSecurity.refSecurityGroupID = sysSecurityGroup.SecurityGroupID
   //       WHERE sysSecurityGroup.blnActive=1 AND sysSecurity.blnView=1
   //       GROUP BY sysSecurityGroup.SecurityGroupID, sysMenuLevel1.MenuLevel1ID, sysMenuLevel1.strMenuLevel1, sysMenuLevel1.strUrl, sysMenuLevel1.intOrder
   //       HAVING sysSecurityGroup.SecurityGroupID='". $_SESSION[USER]->SECURITYGROUPID ."'
   //       ORDER BY sysMenuLevel1.intOrder");

   //       $strMenu .= "<h1 class='hidden-sm hidden-xs' >".$SystemSettings[Brand]."</h1>
   //                <ul>";
   //       while($row1 = $xdb->fetch($rst1))
   //       {
   //          //print_rr($row1);
   //          if(file_exists($row1->strUrl) || $row1->Children > 0)
   //          {
   //             $strMenu .= "<li class='link' >";
   //             /*if(file_exists($row1->URL))
   //                $strMenu .= "<a href='$row1->URL'>$row1->Label</a>";
   //             else
   //                $strMenu .= "$row1->Label";*/

   //             $this->Tier1[$row1->ID] = $row1;

   //             $sql = "SELECT sysMenuLevel2.MenuLevel1ID as Tier1ID, sysMenuLevel2.MenuLevel2ID AS ID, sysMenuLevel2.strMenuLevel2 AS Label, sysMenuLevel2.strEntity AS Entity, sysMenuLevel2.strUrl AS URL, sysSecurity.blnView, sysSecurity.blnDelete, sysSecurity.blnSave, sysSecurity.blnSpecial, sysMenuLevel2.blnDivider, sysMenuLevel2.intOrder AS 'Order'
   //                      FROM sysSecurity INNER JOIN sysMenuLevel2 ON sysSecurity.refMenulevel2ID = sysMenuLevel2.MenuLevel2ID
   //                      WHERE (((sysMenuLevel2.MenuLevel1ID)=$row1->ID) AND ((sysMenuLevel2.blnMenuItem)=1) AND refSecurityGroupID = '".$_SESSION['USER']->SECURITYGROUPID."' )
   //                      GROUP BY sysMenuLevel2.MenuLevel1ID, sysMenuLevel2.MenuLevel2ID, sysMenuLevel2.intOrder, sysMenuLevel2.strMenuLevel2, sysMenuLevel2.strEntity, sysMenuLevel2.strUrl, sysSecurity.blnView, sysSecurity.blnDelete, sysSecurity.blnSave, sysSecurity.blnSpecial, sysMenuLevel2.blnDivider
   //                      HAVING (((sysSecurity.blnView)=1))
   //                      ORDER BY sysMenuLevel2.intOrder, sysMenuLevel2.strMenuLevel2";

   //             if($xdb->num_rows($xdb->doQuery($sql)) == 0)
   //             {
   //                $strMenu .= "
   //                   <a href='$row1->URL'>
   //                   <span class='glyphicon glyphicon-user' aria-hidden='true'></span>
   //                   <span class='hidden-sm hidden-xs' >$row1->Label</span>
   //                </a>
   //             ";
   //             }

   //             $xdb->doQuery($sql);

   //             if($xdb->num_rows($xdb->doQuery($sql)) > 0)
   //             {
   //                $strMenu .= "
   //                   <li class='link'>
   //             <a href='#$row1->ID' data-toggle='collapse' aria-controls='$row1->ID'>
   //                <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span>
   //                <span class='hidden-sm hidden-xs' >$row1->Label</span>
   //                <span class='label label-success pull-right hidden-sm hidden-xs'>20</span>
   //             </a>";
   //                $strMenu .= "
   //                   <ul class='collapse collapseable' id='$row1->ID'>";

   //                while($row2 = $xdb->fetch())
   //                {
   //                   $this->Tier2[$row2->ID] = $row2;

   //                   $strMenu .= "<li>";
   //                   if($row2->blnDivider == 1)
   //                   {
   //                      $strMenu .= "<div class='divider'></div>";
   //                   }
   //                   if(file_exists($row2->URL))
   //                      $strMenu .= "<a href='$row2->URL'>$row2->Label</a>";
   //                   else
   //                      $strMenu .= "<a class='aIncative'>$row2->Label</a>";
   //                   //$strMenu .= "<a href='$row2->URL'>$row2->Label</a>";

   //                   $strMenu .= "</li>"; //l2
   //                }
   //                $strMenu .= "</ul>"; //l2
   //             }
   //             $strMenu .= "</li>"; //l1
   //          }
   //       }
   //       $strMenu .= "</ul>"; //l1
      
   //       return $strMenu;

   //    }
    public function BuildMenu($orientation = "vertical")
   {
      $xdb = new ZoriDatabase("",null,null,0);

      $rst1 = $xdb->doQuery("
         SELECT sysMenuLevel1.MenuLevel1ID AS ID, sysMenuLevel1.strMenuLevel1 AS Label, sysMenuLevel1.strIconClass AS ICON, sysMenuLevel1.strUrl AS URL, Count(sysMenuLevel2.MenuLevel2ID) as Children, sysMenuLevel1.intOrder AS 'Order'
         FROM (sysSecurity INNER JOIN (sysMenuLevel2 INNER JOIN sysMenuLevel1 ON sysMenuLevel2.MenuLevel1ID = sysMenuLevel1.MenuLevel1ID) ON sysSecurity.refMenulevel2ID = sysMenuLevel2.MenuLevel2ID) INNER JOIN sysSecurityGroup ON sysSecurity.refSecurityGroupID = sysSecurityGroup.SecurityGroupID
         WHERE sysSecurityGroup.blnActive=1 AND sysSecurity.blnView=1
         GROUP BY sysSecurityGroup.SecurityGroupID, sysMenuLevel1.MenuLevel1ID, sysMenuLevel1.strMenuLevel1, sysMenuLevel1.strUrl, sysMenuLevel1.intOrder
         HAVING sysSecurityGroup.SecurityGroupID='". 1 ."'
         ORDER BY sysMenuLevel1.intOrder", 0);

      $strMenu .= "<ul class='nav side-menu'>";
      while($row1 = $xdb->fetch($rst1))
      {
         //print_rr($row1);
         if(file_exists($row1->strUrl) || $row1->Children > 0)
         {
            $strMenu .= "<li>";
            if(file_exists($row1->URL))
               $strMenu .= "<a href='$row1->URL'><i class='$row1->ICON'></i>$row1->Label</a>";
            else
               $strMenu .= "<a><i class='$row1->ICON'></i> $row1->Label <span class='fa fa-chevron-down'></span></a>";
           //$strMenu .= "<a href='$row1->URL'>$row1->Label</a>";

            $this->Tier1[$row1->ID] = $row1;

            $sql = "SELECT sysMenuLevel2.MenuLevel1ID as Tier1ID, sysMenuLevel2.MenuLevel2ID AS ID, sysMenuLevel2.strMenuLevel2 AS Label, sysMenuLevel2.strEntity AS Entity, sysMenuLevel2.strUrl AS URL, sysSecurity.blnView, sysSecurity.blnDelete, sysSecurity.blnSave, sysSecurity.blnSpecial, sysMenuLevel2.blnDivider, sysMenuLevel2.intOrder AS 'Order'
                     FROM sysSecurity INNER JOIN sysMenuLevel2 ON sysSecurity.refMenulevel2ID = sysMenuLevel2.MenuLevel2ID
                     WHERE (((sysMenuLevel2.MenuLevel1ID)=$row1->ID) AND ((sysMenuLevel2.blnMenuItem)=1) AND refSecurityGroupID = '".$_SESSION[USER]->SECURITYGROUPID."' )
                     GROUP BY sysMenuLevel2.MenuLevel1ID, sysMenuLevel2.MenuLevel2ID, sysMenuLevel2.intOrder, sysMenuLevel2.strMenuLevel2, sysMenuLevel2.strEntity, sysMenuLevel2.strUrl, sysSecurity.blnView, sysSecurity.blnDelete, sysSecurity.blnSave, sysSecurity.blnSpecial, sysMenuLevel2.blnDivider
                     HAVING (((sysSecurity.blnView)=1))
                     ORDER BY sysMenuLevel2.intOrder, sysMenuLevel2.strMenuLevel2";

            $xdb->doQuery($sql, 0);

            if($xdb->num_rows($xdb->doQuery($sql)) > 0)
            {
               $strMenu .= "
                  <ul class='nav child_menu'>"; //NB! YOU NEED THE FUCKING NL/CR BEFORE THE UL ELSE IE FUCKING PREMATURELY RENDERS IT LIKE A HIGHSCHOOL PUSSYBOUY FFS!

               while($row2 = $xdb->fetch())
               {
                  $this->Tier2[$row2->ID] = $row2;

                  $strMenu .= "<li>";
                 /* if($row2->blnDivider == 1)
                  {
                     $strMenu .= "<div class='menuL2divider'></div>";
                  }*/
                  if(file_exists($row2->URL))
                     $strMenu .= "<a href='$row2->URL'>$row2->Label</a>";
                  else
                     $strMenu .= "<a class='aInactiveMenuItem'>$row2->Label</a>";
                  //$strMenu .= "<a href='$row2->URL'>$row2->Label</a>";

                  $strMenu .= "</li>"; //l2
               }
               $strMenu .= "</ul>"; //l2
            }
            $strMenu .= "</li>"; //l1
         }
      }
      $strMenu .= "</ul>"; //l1
      $this->Control = "<div id='sidebar-menu' class='main_menu_side hidden-print main_menu'><div class='menu_section'>" . $strMenu . "</div></div>";
   }

   ## side bar ###############################################################
   public function BuildSideBar()
   {
      global $xdb;

      $rstSideBar = $xdb->doQuery("SELECT * FROM sysMenuSidebar WHERE blnActive = 1 ORDER BY intOrder ASC ");

      $sideMenu = "<ul>";
      while($rowSideBar = $xdb->fetch_object($rstSideBar))
      {


         if($rowSideBar->blnNotifyCounter == 1)
         {
            $test = call_user_func($rowSideBar->strFunctionName);
            $notifyCounter = "<div class='NotifyCounter'>$test</div>";
         }
         else
         {
            $notifyCounter = "";
         }

         $sideMenu .= "<li><a href='$rowSideBar->strUrl'>
                           $rowSideBar->strMenuSidebar
                           $notifyCounter
                           </a></li>";
      }
      $sideMenu .= "</ul>";
      return $sideMenu;
   }
}


?>
