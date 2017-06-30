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
    private $path = 'zori_php_stater/webadmin/createFie';
    private $myfile;
    private $tabString;
    private $indentationLevelZero = 0;
    private $indentationLevelOne = 4;
    private $indentationLevelTwo = 8;

    public function __construct()
    {
        if ($this->validatePath($this->path))
        {
            $this->createFile($this->path, $this->fileName, $this->ext);
            echo 'File created';
        }

        // Php header
        $this->writeToFile("<?php");

        // includes
        $this->writeToFile("include_once('_framework/_zori.list.cls.php');");
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
        $this->writeToFile("public function save" . $this->fileName . "()");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelTwo);

        // save functionality
        $this->writeToFile("// You can write functionality code here");

        $this->tabing($this->indentationLevelOne);
        $this->closeCurlyBracket();
        $this->spaceBetweenLines(1);
        /* End Save Function */

        /* Delete Function */
        $this->writeToFile("// Delete Function");
        $this->writeToFile("public function delete" . $this->fileName . "()");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelTwo);

        // Delete functionality
        $this->writeToFile("// You can write functionality code here");

        $this->tabing($this->indentationLevelOne);
        $this->closeCurlyBracket();
        $this->spaceBetweenLines(1);
        /* End Delete Function */

        /* Update function */
        $this->writeToFile("// Update Function");
        $this->writeToFile("public function update" . $this->fileName . "()");
        $this->openCurlyBracket();
        $this->tabing($this->indentationLevelTwo);

        // Update functionality
        $this->writeToFile("// You can write functionality code here");

        $this->tabing($this->indentationLevelOne);
        $this->closeCurlyBracket();
        $this->spaceBetweenLines(1);
        /* Update function */

        /* View function */
        $this->writeToFile("// view Function");
        $this->writeToFile("public function view" . $this->fileName . "()");
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



        echo "<br><strong>I Wrote a lot </strong> nneeehhhh..... <br> Check path: ' " . $this->path . "' for the file";
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
