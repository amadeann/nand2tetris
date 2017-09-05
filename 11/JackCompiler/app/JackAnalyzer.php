<?php

namespace App;

class JackAnalyzer {

    public function tokenize( $inputFile ) {
    
        if( is_dir($inputFile) ) {

            $dir = new \DirectoryIterator($inputFile);

            foreach ($dir as $fileInfo) {

                if (!$fileInfo->isDot()) {

                    // execute the compileFile function only on .jack files

                    $extension = pathinfo ( $inputFile . DIRECTORY_SEPARATOR . $fileInfo , PATHINFO_EXTENSION );

                    if ( $extension == 'jack') {

                        $this->tokenizeFile( $inputFile . DIRECTORY_SEPARATOR . $fileInfo );

                    }

                }
                
            }

        } else {

            $this->tokenizeFile( $inputFile );

        }

    }
    
    public function compile( $inputFile ) {

        if( is_dir($inputFile) ) {

            $dir = new \DirectoryIterator($inputFile);

            foreach ($dir as $fileInfo) {

                if ( !$fileInfo->isDot() ) {

                    // execute the compileFile function only on .jack files

                    $extension = pathinfo ( $inputFile . DIRECTORY_SEPARATOR . $fileInfo , PATHINFO_EXTENSION );

                    if ( $extension === 'jack') {
                        
                        $outputFile = basename( $fileInfo, '.jack' ) . '.xml';
                        
                        // $compiler = new CompilationEngine( $inputFile, $outputFile );
                
                        ( new CompilationEngine( $inputFile . DIRECTORY_SEPARATOR . $fileInfo, $outputFile ) )->compile();

                    }

                }
            }

        } else {

            $outputFile = basename( $inputFile, '.jack' ) . '.xml';
            
            $compiler = new CompilationEngine( $inputFile, $outputFile );
    
            $compiler->compile();

        }

        return 'Aight, so the compile command works';
    }

    private function tokenizeFile($inputFile) {

        $tokenizer = new JackTokenizer( $inputFile );
        
        $tokenized_file = basename( $inputFile, '.jack' ) . 'T.xml';

        $handle = fopen($tokenized_file, 'w') or die('Cannot open file:  '.$tokenized_file);

        fwrite($handle, '<tokens>');
        
        // 2017-08-28: some loop which will be outputing new tokens
        while ( $tokenizer->hasMoreTokens() ) {

            $tokenizer->advance();
            
            switch( $tokenizer->tokenType() ) {
                case 'KEYWORD';
                    $new_line = '<keyword>' . $tokenizer->keyword() . '</keyword>';
                    break;
                case 'SYMBOL';
                    $new_line = '<symbol>' . $tokenizer->symbol() . '</symbol>';
                    break;
                case 'IDENTIFIER';
                    $new_line = '<identifier>' . $tokenizer->identifier() . '</identifier>';
                    break;
                case 'INT_CONSTANT';
                    $new_line = '<integerConstant>' . $tokenizer->intVal() . '</integerConstant>';
                    break;
                case 'STRING_CONSTANT';
                    $new_line = '<stringConstant>' . $tokenizer->stringVal() . '</stringConstant>';
                    break;
                default:
                    echo 'token ' . $tokenizer->currentToken . ' does not match any of the know token types;';
                    break;
            }

            $data = "\n" . $new_line;
            fwrite($handle, $data);
        }
        
        fwrite($handle, "\n" . '</tokens>');

        fclose($handle);

        return 'Aight, so the tokenize command works';
    }

}