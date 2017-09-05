<?php

class Parser {

    public $assembly;

    public function __construct(Assembly $assembly) {
        $this->assembly = $assembly;
    }

    public function removeWhiteSpace() {
        $this->assembly->currentLine = preg_replace('/\s+/', '', $this->assembly->currentLine);
    }

    public function removeInlineComments() {
        $this->assembly->currentLine = explode('//',$this->assembly->currentLine)[0];
    }

    public function isEmptyLine() {
        return $this->assembly->currentLine == "";
    }

    public function currentInstructionType() {
        return $this->assembly->currentLine[0] == "@" ? "a" : "c";
    }

    public function parseA() {
        $command = $this->assembly->currentLine;
        $this->assembly->currentLine = [];
        $this->assembly->currentLine[0] = substr($command,1);
    }

    public function parseC() {
        $command = $this->assembly->currentLine;
        $this->assembly->currentLine = [];

        if(strpos($command,"=")===false) {
            $this->assembly->currentLine[0] = '';
        } else {
            $splittedCommand = explode("=", $command);
            $this->assembly->currentLine[0] = $splittedCommand[0];
            $command = $splittedCommand[1];
        }

        if(strpos($command,";")===false) {
            $this->assembly->currentLine[1] = $command;
            $this->assembly->currentLine[2] = '';

        } else {
            $splittedCommand = explode(";", $command);
            $this->assembly->currentLine[1] = $splittedCommand[0];
            $this->assembly->currentLine[2] = $splittedCommand[1];
        }
    }
}

class Code {

    private $comp = 

    [
        "0" => "0101010",
        "1" => "0111111",
        "-1" => "0111010",
        "D" => "0001100",
        "A" => "0110000",
        "!D" => "0001101",
        "!A" => "0110001",
        "-D" => "0001111",
        "-A" => "0110011",
        "D+1" => "0011111",
        "A+1" => "0110111",
        "D-1" => "0001110",
        "A-1" => "0110010",
        "D+A" => "0000010",
        "D-A" => "0010011",
        "A-D" => "0000111",
        "D&A" => "0000000",
        "D|A" => "0010101",
        "M" => "1110000",
        "!M" => "1110001",
        "-M" => "1110011",
        "M+1" => "1110111",
        "M-1" => "1110010",
        "D+M" => "1000010",
        "D-M" => "1010011",
        "M-D" => "1000111",
        "D&M" => "1000000",
        "D|M" => "1010101"
    ];

    public $dest = 

    [
        "" => "000",
        "M" => "001",
        "D" => "010",
        "MD" => "011",
        "A" => "100",
        "AM" => "101",
        "AD" => "110",
        "AMD" => "111"
    ];

    public $jump = 

    [
        "" => "000",
        "JGT" => "001",
        "JEQ" => "010",
        "JGE" => "011",
        "JLT" => "100",
        "JNE" => "101",
        "JLE" => "110",
        "JMP" => "111"
    ];

    public function __construct(Assembly $assembly) {

        $this->assembly = $assembly;

    }

    public function codeA($i) {

        return sprintf( "%016d", decbin($this->assembly->currentLine[0]));

    }

    public function codeC($i) {

        $value = "111";

        $value .= $this->comp[$this->assembly->currentLine[1]]; // computation

        $value .= $this->dest[$this->assembly->currentLine[0]]; // destination

        $value .= $this->jump[$this->assembly->currentLine[2]]; // jump

        return $value;

    }
}

Class SymbolTable {

    public $freeMemoryAddress = 16;
    
    public $symbols = [
        "SP" => "0",
        "LCL" => "1",
        "ARG" => "2",
        "THIS" => "3",
        "THAT" => "4",
        "R0" => "0",
        "R1" => "1",
        "R2" => "2",
        "R3" => "3",
        "R4" => "4",
        "R5" => "5",
        "R6" => "6",
        "R7" => "7",
        "R8" => "8",
        "R9" => "9",
        "R10" => "10",
        "R11" => "11",
        "R12" => "12",
        "R13" => "13",
        "R14" => "14",
        "R15" => "15",
        "SCREEN" => "16384",
        "KBD" => "24576"
    ];

    public function __construct(Assembly $assembly) {

        $this->assembly = $assembly;

    }

    public function isLabel() {

        $line = $this->assembly->currentLine;

        if ( preg_match('/^\(([a-zA-Z_\.\$][a-zA-Z0-9_\.\$]*)\)$/',$line,$matches) ) {
            $this->symbols[$matches[1]] = $this->assembly->currentLineNumber;
            return true;
        }

        return false;

    }

    public function isVariable() {

        $line = $this->assembly->currentLine[0];

        echo "can I WRITE ANYTHING AT ALL. line is: {$line}?\n";

        if ( preg_match('/^([a-zA-Z_\.\$][a-zA-Z_0-9\.\$]*)$/',$line,$matches) ) {

            if( ! array_key_exists($matches[1], $this->symbols) ) {

                echo "writing new symbol to a table\n";

                $this->symbols[$matches[1]] = $this->freeMemoryAddress;

                $this->assembly->currentLine[0] = $this->freeMemoryAddress;

                $this->freeMemoryAddress++;

            } else {

                echo "{$matches[1]} is in the symbol table as {$this->symbols[$matches[1]]}\n";

                $this->assembly->currentLine[0] = $this->symbols[$matches[1]];

            }

            return true;
        }

        return false;

    }

}

class Assembly {

    public $fileName;

    public $symbolTable = [];

    public $allMatches = [];

    public $rawFile;

    public $compiledProgram = [];

    public $currentLine;

    public $currentLineNumber = 0;

    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    public function compile($outputFile) {
        // starts the compile process
        $this->readFile();

        // initialize the parser

        $parser = new Parser($this);

        // initialize the coder

        $code = new Code($this);

        // initialize the symbol table

        $symbolTable = new SymbolTable($this);

        // first iteration
        // parsing white spaces, comments and adding addresses to the symbol table

        $rawLineCount = count($this->rawFile);

        /* Temporarily I do not care about the symbol table */

        for($i=0; $i<$rawLineCount; $i++) {

            $this->currentLine = $this->rawFile[$i];
            $parser->removeWhiteSpace();
            $parser->removeInlineComments();

            if($parser->isEmptyLine()) {
                continue;
            } else {

                if( ! $symbolTable->isLabel() ) {

                    $this->compiledProgram[$this->currentLineNumber] = $this->currentLine;
                    $this->currentLineNumber++;

                }                
            }
        }

        var_dump($this->compiledProgram);

        // second
        // parse the instructions

        $compiledLineCount = count($this->compiledProgram);

        echo "there are $compiledLineCount compiled lines\n";

        $this->currentLineNumber = 0;
        
        for($i=0;$i<$compiledLineCount;$i++) {

            $this->currentLine = $this->compiledProgram[$this->currentLineNumber];

            if($parser->currentInstructionType() == "a") {

                $parser->parseA();

                $symbolTable->isVariable();

                $this->compiledProgram[$this->currentLineNumber] = $code->codeA($this->currentLine);
            } else {

                $parser->parseC();

                $this->compiledProgram[$this->currentLineNumber] = $code->codeC($this->currentLine);
            }

            $this->currentLineNumber++;
        }

        // var_dump($symbolTable);

        var_dump($this->compiledProgram);

        $this->writeToFile($outputFile);


    }

    private function readFile() {
        // read file to memory
        // $handle = fopen(__DIR__ . DIRECTORY_SEPARATOR . $this->fileName, "r") or die("Couldn't open $this->fileName");
        $this->rawFile = file(__DIR__ . DIRECTORY_SEPARATOR . $this->fileName) or die("Couldn't open $this->fileName");
        // var_dump($this->rawFile);
    }

    private function writeToFile($fileName) {
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . $fileName, implode(PHP_EOL, $this->compiledProgram));
    }

}

// echo "Peace out";
// exit;

// $foo = new Assembly('random_text_file.asm');
$foo = new Assembly('../pong/Pong.asm');
$foo->compile('Pong.hack');