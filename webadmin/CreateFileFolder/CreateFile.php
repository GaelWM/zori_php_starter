<?php

/**
 * Description of CreateFile
 *
 * @author Nelson
 */
class CreateFile
{


    private $fileName = "NelsonTest";
    private $ext = "php";
   // private $path = 'webadmin/CreateFileFolder';
    //private $path =
    private $myfile;
    private $tabString;
    private $indentationLevelZero = 0;
    private $indentationLevelOne = 4;
    private $indentationLevelTwo = 8;
    private $indentationLevelThree = 12;
    private $indentationLevelFour = 16;


    public function __construct()
    {
        $path = getcwd();
        //$path = chdir('webadmin/CreateFileFolder');
        if ($this->validatePath($path))
        {
            $this->createFile($path, $this->fileName, $this->ext);
            echo 'File created';
        }

        // Php header
        $this->writeToFile("<?php");

        // includes
        $this->writeToFile("include_once('_framework/_zori.list.cls.php');");
        $this->spaceBetweenLines(1);

        /* Class Created */
        $this->writeToFile("class " . $this->fileName . " extends ZoriList");
        $this->openCurlyBracket();

        // Indent with a single tab
        $this->tabing($this->indentationLevelOne);

        // Constructor of the class
        $this->writeToFile("public function __construct()");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelTwo);

        // construct functionality
        $this->writeToFile("// You can write functionality code here");

        $this->tabing($this->indentationLevelOne);
        $this->closeCurlyBracket();
        $this->spaceBetweenLines(1);
        /* End constructor */

        /* Save Function */
        $this->writeToFile("// Save function");
        $this->writeToFile("public static function save" . $this->fileName . "(&$"."UserID)");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelTwo);

        // save functionality
        $this->writeToFile("global $" . "xdb, $"."SystemSettings;");
        $this->writeToFile("$". "db = new ZoriDatabase(\"sysUser\", $". "UserID, null, 0);");
        $this->writeToFile("$". "xdb = nCopy($". "db);");
        $this->writeToFile("$"."db->SetValues($"."_POST);");
        $this->writeToFile("$"."db->Fields[strPasswordMD5] = md5($"."_POST[strPassword]);");
        $this->writeToFile("$"."db->Fields[strLastUser] = $"."_SESSION['USER']->USERNAME;");
        $this->writeToFile("if($"."UserID == 0)");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelThree);
        $this->writeToFile("$"."db->Fields[strFirstUser] = $"."nemo->SystemSettings[USER]->USERNAME;");
        $this->writeToFile("$"."db->Fields[dtFirstEdit] = date(\"Y-m-d H:i:s\");");
        $this->tabing($this->indentationLevelTwo);
        $this->closeCurlyBracket();

        $this->writeToFile("$"."result = $"."db->Save();");
        $this->writeToFile("if($"."UserID == 0) $"."UserID = $"."db->ID[UserID];");
        $this->writeToFile("if($"."result->Error == 1)");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelThree);
        $this->writeToFile("return $"."result->Message;");
        $this->tabing($this->indentationLevelTwo);
        $this->closeCurlyBracket();
        $this->writeToFile("else");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelThree);
        $this->writeToFile("return \"Details Saved.\";");
        $this->tabing($this->indentationLevelTwo);
        $this->closeCurlyBracket();

        $this->tabing($this->indentationLevelOne);
        $this->closeCurlyBracket();
        $this->spaceBetweenLines(1);
        /* End Save Function */

        /* Delete Function */
        $this->writeToFile("// Delete Function");
        $this->writeToFile("public static function delete" . $this->fileName . "($"."chkSelect)");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelTwo);

        // Delete functionality
        $this->writeToFile("// You can write functionality code here");
        $this->writeToFile("global $"."xdb;");
        $this->writeToFile("if(count($"."chkSelect) > 0)");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelThree);
        $this->writeToFile(" foreach($"."chkSelect as $"."key => $"."value)");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelFour);
        $this->writeToFile("");
        $this->writeToFile("$"."xdb->doQuery(\"UPDATE sysUser SET blnActive = 0 WHERE UserID = \". $"."xdb->qs($"."key));");
        $this->tabing($this->indentationLevelThree);
        $this->closeCurlyBracket();
        $this->writeToFile("return \"Records Deleted. \";");
        $this->tabing($this->indentationLevelTwo);
        $this->closeCurlyBracket();


        $this->tabing($this->indentationLevelOne);
        $this->closeCurlyBracket();
        $this->spaceBetweenLines(1);
        /* End Delete Function */

        /* Update function */
        $this->writeToFile("// Update Function");
        $this->writeToFile("public static function update" . $this->fileName . "()");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelTwo);

        // Update functionality
        $this->writeToFile("// You can write functionality code here");
        $this->writeToFile("");
        $this->writeToFile("");
        $this->writeToFile("");
        $this->writeToFile("");
        $this->writeToFile("");
        $this->writeToFile("");
        $this->writeToFile("");
        $this->writeToFile("");

        $this->tabing($this->indentationLevelOne);
        $this->closeCurlyBracket();
        $this->spaceBetweenLines(1);
        /* Update function */

        /* View function */
        $this->writeToFile("// view Function");
        $this->writeToFile("public static function view" . $this->fileName . "()");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelTwo);

        // Update functionality
        $this->writeToFile("// You can write functionality code here");

        $this->tabing($this->indentationLevelOne);
        $this->closeCurlyBracket();
        $this->spaceBetweenLines(1);
        /* End View function */

        $this->tabing($this->indentationLevelZero);
        $this->closeCurlyBracket();
        /* Class Created */



        echo "<br><strong>I Wrote a lot </strong> nneeehhhh..... <br> Check path: ' " . $path . "' for the file";
    }

    private function tabing($num)
    {
        $this->tabString = "";
        if ($num > 0)
        {
            for ($index = 0; $index < $num; $index++)
            {
                $this->tabString .= " ";
            }
        }
    }

    protected function writeToFile($line)
    {
        fwrite($this->myfile, $this->tabString . $line . "\n");
    }

    private function openCurlyBracket()
    {
        $this->writeToFile("{");
    }

    private function closeCurlyBracket()
    {
        $this->writeToFile("}");
    }

    private function spaceBetweenLines($numOfSpace)
    {

        for ($index = 0; $index < $numOfSpace; $index++)
        {
            $this->writeToFile("");
        }
    }

    private function createFile($path, $fileName, $extension)
    {
        $this->myfile = fopen($path . "/" . $fileName . "." . $extension, "w") or die("Unable to create '$this->className'");
    }

    // Validate fileName
    private function validatePath($pathName)
    {
        if (file_exists($pathName))
        {
            if (is_dir($pathName))
            {
                return true;
            } else
            {
                echo "File '$this->className' could not be created at the path '$pathName'";
            }
        } else
        {
            echo "Path '$pathName' does not exists";
        }
    }

}
