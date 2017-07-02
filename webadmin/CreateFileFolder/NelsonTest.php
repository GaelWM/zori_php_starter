<?php
include_once('_framework/_zori.list.cls.php');

class NelsonTest extends ZoriList
{
    public function __construct()
    {
        // You can write functionality code here
    }
    
    // Save function
    public static function saveNelsonTest(&$UserID)
    {
        global $xdb, $SystemSettings;
        $db = new ZoriDatabase("sysUser", $UserID, null, 0);
        $xdb = nCopy($db);
        $db->SetValues($_POST);
        $db->Fields[strPasswordMD5] = md5($_POST[strPassword]);
        $db->Fields[strLastUser] = $_SESSION['USER']->USERNAME;
        if($UserID == 0)
        {
            $db->Fields[strFirstUser] = $nemo->SystemSettings[USER]->USERNAME;
            $db->Fields[dtFirstEdit] = date("Y-m-d H:i:s");
        }
        $result = $db->Save();
        if($UserID == 0) $UserID = $db->ID[UserID];
        if($result->Error == 1)
        {
            return $result->Message;
        }
        else
        {
            return "Details Saved.";
        }
    }
    
    // Delete Function
    public static function deleteNelsonTest($chkSelect)
    {
        // You can write functionality code here
        global $xdb;
        if(count($chkSelect) > 0)
        {
             foreach($chkSelect as $key => $value)
            {
                
                $xdb->doQuery("UPDATE sysUser SET blnActive = 0 WHERE UserID = ". $xdb->qs($key));
            }
            return "Records Deleted. ";
        }
    }
    
    // Update Function
    public static function updateNelsonTest()
    {
        // You can write functionality code here
        
        
        
        
        
        
        
        
    }
    
    // view Function
    public static function viewNelsonTest()
    {
        // You can write functionality code here
    }
    
}
