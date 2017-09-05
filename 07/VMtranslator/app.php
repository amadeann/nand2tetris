<?php

class Parser {

    public $fileHandle;

    public $currentLine;

    public $currentCommandType;

    public function __construct($fileName) {

        $this->fileHandle = fopen($fileName, "r");

    }

    public function hasMoreCommands() {

        return feof($this->fileHandle) ? true : false;

    }

    public function advance() {

        $this->currentLine = fgets($this->fileHandle);

        // clean comments

        $this->currentLine = explode('//', $this->currentLine,2)[0];

        // clean excessive white spaces

        $this->currentLine = preg_replace('/\s+/', ' ', $this->currentLine);

        return ! ( $this->currentLine == '' || $this->currentLine == ' ');

    }

    public function commandType() {

        $commandTypes = [
            'add' => 'C_ARITHMETIC',
            'sub' => 'C_ARITHMETIC',
            'neg' => 'C_ARITHMETIC',
            'eq' => 'C_ARITHMETIC',
            'gt' => 'C_ARITHMETIC',
            'lt' => 'C_ARITHMETIC',
            'and' => 'C_ARITHMETIC',
            'or' => 'C_ARITHMETIC',
            'not' => 'C_ARITHMETIC',
            'push' => 'C_PUSH',
            'pop' => 'C_POP',
            'label' => 'C_LABEL',
            'goto' => 'C_GOTO',
            'if-goto' => 'C_IF',
            'function' => 'C_FUNCTION',
            'return' => 'C_RETURN',
            'call' => 'C_CALL'
        ];

        $currentCommand = explode(' ',$this->currentLine)[0];

        return isset($commandTypes[$currentCommand]) ? $commandTypes[$currentCommand] : 'C_INVALID';

    }

    public function arg1() {
        $line = explode(' ',$this->currentLine); 
        return $this->currentCommandType == 'C_ARITHMETIC' ? $line[0] : $line[1];
    }

    public function arg2() {
        $line = explode(' ',$this->currentLine); 
        // 
        // THIS MAY CHANGE WHEN WE INCORPORATE OTHER COMMANDS!
        // 
        return $line[2];
    }

}

class CodeWriter {

    public $outputFile;

    public $fileName;

    public $jumpCount = 0;

    public $callCount = 0;

    public $currentFunction = '';

    public function __construct($fileName) {

        $is_dir = strpos($fileName, '.vm') === false ? true : false;

        $outputFileName = ($is_dir ? $fileName . DIRECTORY_SEPARATOR : '' ) . str_replace('.vm','',$fileName) . '.asm';

        $this->outputFile = fopen($outputFileName, 'w');      

    }

    public function setFileName($fileName) {
        $this->fileName = explode('.',$fileName)[0];
        $exploded = explode('/',$this->fileName);
        $this->fileName = $exploded[count($exploded)-1];
    }

    public function writeArithmetic( $command ) {
        // fwrite($this->outputFile, 'Here goes what we should write' . '\n');
        $line = '// ' . $command . " command\n";
        $line .= '// command: ' . $command . "\n";
        switch ($command) {
            case 'add':
                $operandCount = 2;
                $operation = "M=D+M";
                $requiresBranching = false;
                break;
            case 'sub':
                $operandCount = 2;
                $operation = "M=M-D";
                $requiresBranching = false;
                break;
            case 'neg':
                $operandCount = 1;
                $operation = "M=-M";
                break;
            case 'eq':
                $requiresBranching = true;
                $operation = "D;JEQ\n";
                $operandCount = 2;
                $this->jumpCount++;
                break;
            case 'gt':
                $requiresBranching = true;
                $operation = "D;JGT\n";
                $operandCount = 2;
                $this->jumpCount++;
                break;
            case 'lt':
                $requiresBranching = true;
                $operation = "D;JLT\n";
                $operandCount = 2;
                $this->jumpCount++;
                break;
            case 'and':
                $requiresBranching = false;
                $operation = "M=D&M";
                $operandCount = 2;
                break;
            case 'or':
                $requiresBranching = false;
                $operation = "M=D|M";
                $operandCount = 2;
                break;
            case 'not':
                $operandCount = 1;
                $operation = "M=!M";
                break;
        }

        // decrement the stack pointer (common for operations with 1 and 2 operands)
        $line .= "@SP\n";
        $line .= "M=M-1\n";

        if ($operandCount == 2) {
            // two variable arithmetic
            // first number
            $line .= "A=M\n";
            $line .= "D=M\n";
            // second number
            $line .= "@SP\n";
            $line .= "M=M-1\n";
            $line .= "A=M\n";
            // perform the operation
            if ($requiresBranching) {
                $line .= "D=M-D\n";
                $line .= "M=-1\n"; // true
                $line .= "@" . ($this->fileName) . "." . "JMP" . ($this->jumpCount) . "\n";
                $line .= $operation . "\n";
                $line .= "@SP\n";
                $line .= "A=M\n";
                $line .= "M=0\n";
                $line .= "(" . ($this->fileName) . "." . "JMP" . ($this->jumpCount) . ")\n";
                $this->jumpCount++;
            } else {
                $line .= $operation . "\n";
            }
        } else {
            // single variable arithmetic
            $line .= "A=M\n";
            $line .= $operation . "\n";
        }

        // increment the stack pointer (common for operations with 1 and 2 operands)
        $line .= "@SP\n";
        $line .= "M=M+1\n";
        fwrite( $this->outputFile, $line );
    }

    public function writePushPop( $command, $segment = '', $index = '' ) {
        $line = '// ' . $command . " command\n";
        $line .= '// command: ' . $command . ', segment: ' . $segment . ', index: ' . $index . "\n";

        switch($segment) {
            case 'argument':
                $segment = 'ARG';
                break;
            case 'local':
                $segment = 'LCL';
                break;
            case 'static':
                $segment = "{$this->fileName}";
                break;
            case 'constant':
                $segment = '0'; // virtual address
                break;
            case 'this':
                $segment = 'THIS';
                break;
            case 'that':
                $segment = 'THAT';
                break;
            case 'pointer':
                $segment = '3';
                break;
            case 'temp':
                $segment = '5';
                break;            
        }
        // are we dealing with push or pop command?
        if( $command == 'C_PUSH') {
            // are we dealing with the static variable?
            if($segment == $this->fileName) {
                $line .= "@$segment.$index\n";
            } else {
                // get the value we need from a given segment and store it to D
                $line .= "@$segment\n";
                $line .= "D=". ( is_numeric($segment) ? 'A' : 'M') ."\n"; // for constant, pointer and temp registers we need to take the A value
                $line .= "@$index\n";
                $line .= "A=D+A\n";
            }
            $line .= "D=". ($segment == '0' ? 'A' : 'M') ."\n";
            // for this purpose I will have to translate the value of $segment varaible into the address in the memory
            // store the value at the address indicated by the stack pointer
            $line .= "@SP\n";
            $line .= "A=M\n";
            $line .= "M=D\n";
            // increment the stack pointer
            $line .= "@SP\n";
            $line .= "M=M+1\n";
        } else {
            // do the pop stuff
            // decrement the stack pointer
            $line .= "@SP\n";
            $line .= "M=M-1\n";
            // read the value from the stack
            $line .= "A=M\n";
            $line .= "D=M\n";
            /**
            * Sth innovative here: store the value to pop in a general purpose
            * register R13
            */
            $line .= "@R13\n";
            $line .= "M=D\n";
            // are we dealing with the static variable?
            if($segment == $this->fileName) {
                $line .= "@$segment.$index\n";
                
            } else {
                // get the address of the appropriate segment
                $line .= "@$segment\n";
                $line .= "D=". ( is_numeric($segment) ? 'A' : 'M') ."\n"; // for constant, pointer and temp registers we need to take the A value
                $line .= "@$index\n";
                $line .= "A=D+A\n";
            }
            /**
            * Sth innovative here: store the segment to pop to in the general purpose
            * register R14
            */
            $line .= "D=A\n";
            $line .= "@R14\n";
            $line .= "M=D\n";
            // store the popped vlaue in the segment
            $line .= "@R13\n";
            $line .= "D=M\n";
            $line .= "@R14\n";
            $line .= "A=M\n";
            $line .= "M=D\n";
        }
        fwrite($this->outputFile, $line);
    }

    public function writeInit() {
        $line = "// Bootstrap code\n";
        $line .= "@256\n";
        $line .= "D=A\n";
        $line .= "@SP\n";
        $line .= "M=D\n";
        fwrite( $this->outputFile, $line );
        // call the Sys.init
        $this->writeCall('Sys.init',0);
        // fwrite( $this->outputFile, $line );
    }

    public function writeLabel($label) {
        $line = "// Label\n";
        $line .= "({$this->currentFunction}\$$label)\n";
        fwrite( $this->outputFile, $line );
    }

    public function writeGoto($label) {
        $line = "// Goto\n";
        $line .= "@{$this->currentFunction}\$$label\n";
        $line .= "0;JMP\n";
        fwrite( $this->outputFile, $line );
    }

    public function writeIf( $label ) {
        $line = "// If statement \n";
        $line .= "@SP\n";
        $line .= "M=M-1\n";
        $line .= "A=M\n";
        $line .= "D=M\n";
        $line .= "@{$this->currentFunction}\$$label\n";
        $line .= "D;JNE\n";
        fwrite( $this->outputFile, $line );
    }

    public function writeCall($functionName, $args) {
        // push the return address
        $line = "// Call function $functionName\n";
        $line .= "// Push the return address\n";
        $line .= "@{$this->currentFunction}\$ret.{$this->callCount}\n";
        $line .= "D=A\n";
        $line .= "@SP\n";
        $line .= "A=M\n";
        $line .= "M=D\n";
        $line .= "@SP\n";
        $line .= "M=M+1\n";
        // push local, arg, this and that
        $segments = ['LCL', 'ARG', 'THIS', 'THAT'];
        for ($i=0;$i<4;$i++) {
            $line .= "@".$segments[$i]."\n";
            $line .= "D=M\n";
            $line .= "@SP\n";
            $line .= "A=M\n";
            $line .= "M=D\n";
            $line .= "@SP\n";
            $line .= "M=M+1\n";
        }
        // reposition ARG
        $line .= "@".($args+5)."\n";
        $line .= "D=A\n";
        $line .= "@SP\n";
        $line .= "D=M-D\n";
        $line .= "@ARG\n";
        $line .= "M=D\n";
        // reposition LCL
        $line .= "@SP\n";
        $line .= "D=M\n";
        $line .= "@LCL\n";
        $line .= "M=D\n";
        // go to f
        $line .= "// Go to $functionName\n";
        $line .= "@$functionName\n";
        $line .= "0;JMP\n";
        $line .= "({$this->currentFunction}\$ret.{$this->callCount})\n";
        $this->callCount++;
        fwrite( $this->outputFile, $line );
    }

    public function writeReturn() {
        $line = "// Return from {$this->currentFunction}\n";
        $line .= "@LCL\n";
        $line .= "D=M\n";
        $line .= "@R13\n"; // FRAME temporary variable
        $line .= "M=D\n";
        $line .= "@5\n";
        $line .= "D=A\n";
        $line .= "@R13\n";
        $line .= "D=M-D\n";
        $line .= "A=D\n";
        $line .= "D=M\n";
        $line .= "@R14\n"; // RET temporary variable
        $line .= "M=D\n";
        // pop the return value to the calling function's first argument value
        $line .= "@SP\n";
        $line .= "A=M-1\n";
        $line .= "D=M\n";
        $line .= "@ARG\n";
        $line .= "A=M\n";
        $line .= "M=D\n";
        $line .= "@ARG\n";
        $line .= "D=M+1\n";
        $line .= "@SP\n";
        $line .= "M=D\n";
        // THAT=* (FRAME-1); THIS=* (FRAME-2); ARG=* (FRAME-3); LCL=* (FRAME-4)
        $segments = ['THAT', 'THIS', 'ARG', 'LCL'];
        for($i=0;$i<4;$i++) {
            $line .= "@".($i+1)."\n";
            $line .= "D=A\n";
            $line .= "@R13\n";
            $line .= "D=M-D\n";
            $line .= "A=D\n";
            $line .= "D=M\n";
            $line .= "@".$segments[$i]."\n";
            $line .= "M=D\n";
        }
        // go the the return address
        $line .= "@R14\n";
        $line .= "A=M\n";
        $line .= "0;JMP\n";
        fwrite( $this->outputFile, $line );
    }

    public function writeFunction($functionName, $args) {
        $this->currentFunction = $functionName;
        $line = "// Write function $functionName\n";
        $line .= "// Current function set to: {$this->currentFunction}\n";
        $line .= "({$this->currentFunction})\n";
        for ($i=0;$i<$args;$i++) {
            $line .= "@0\n";
            $line .= "D=A\n";
            $line .= "@SP\n";
            $line .= "A=M\n";
            $line .= "M=D\n";
            $line .= "@SP\n";
            $line .= "M=M+1\n";
        }
        fwrite( $this->outputFile, $line );
    }

    public function close() {
        fclose($this->outputFile);
    }

}

function compileFile($fileName, $codeWriter) {
    
    $parser = new Parser($fileName);

    $codeWriter->setFileName($fileName);

    if ($parser->fileHandle) {

        while ( ! $parser->hasMoreCommands()) {
            
            // if advance is false, it means that the current line was empty after cleaering up the comments

            if( !$parser->advance() ) continue;

            echo $parser->commandType() . '<br>';
            
            switch( $parser->currentCommandType = $parser->commandType() )  {

                case 'C_ARITHMETIC':
                    $codeWriter->writeArithmetic( $parser->arg1() );
                    break;
                case 'C_PUSH':
                case 'C_POP':
                    $codeWriter->writePushPop( $parser->currentCommandType , $parser->arg1(), $parser->arg2() );
                    break;
                case 'C_LABEL':
                    $codeWriter->writeLabel( $parser->arg1() );
                    break;
                case 'C_GOTO':
                    $codeWriter->writeGoTo( $parser->arg1() );
                    break;
                case 'C_IF':
                    $codeWriter->writeIf( $parser->arg1() );
                    break;
                case 'C_FUNCTION':
                    $codeWriter->writeFunction( $parser->arg1(), $parser->arg2() );
                    break;
                case 'C_CALL':
                    $codeWriter->writeCall( $parser->arg1(), $parser->arg2() );
                    break;
                case 'C_RETURN':
                    $codeWriter->writeReturn();
                    break;
                default:
                    echo "The parser returned an invalid exception";
                    break;
            }      


        }

        fclose($parser->fileHandle);

    } else {

        throw new Exception('There was a problem with opening the file ' . $fileName);

    } 

}

function compile($directory) {

    $codeWriter = new CodeWriter($directory);

    $codeWriter->setFileName('Sys');

    $codeWriter->writeInit();

    if( is_dir($directory) ) {
        $dir = new DirectoryIterator($directory);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                // execute the compileFile function only on vm files
                $extension = pathinfo ( $directory . DIRECTORY_SEPARATOR .$fileinfo , PATHINFO_EXTENSION );
                if ( $extension == 'vm') {
                    compileFile($directory . DIRECTORY_SEPARATOR . $fileinfo, $codeWriter);
                }
            }
        }
    } else {
        compileFile($directory, $codeWriter);
    }

    $codeWriter->close();
}


