<?php

namespace App;

/**
* Entire file is loaded to memory
*/

class JackTokenizer {

    public $code;
    public $currentToken = "";
    public $currentLineNumber = 0; // when we start processing the file, the line numebr is 0

    // probably need to leave it for later - it should be a part of the tokenType method
    private $tokens = [
        "KEYWORD" => ['class','constructor','function','method','field','static','var','int','char','boolean','void',
            'true','false','null','this','let','do','if','else','while','return'],
        "SYMBOL" => ['{','}','(',')','[',']','.',',',';','+','-','*','/','&','|','<','>','=','~'],
        "IDENTIFIER" => [],
        "INT_CONST" => [],
        "STRING_CONST" => []
    ];
    
    public function __construct( $inputFile ) {

        $code = file_get_contents($inputFile);

        // 2017-08-27: maybe I don't have to remove comments. Maybe I can just ignore them?
        // I think this may even have to be the case - how would I otherwise be able to return the line number with the error?
        // still, who asked me to build the logic for returning the line number with the error? Is it even the part of the compiler

        $code = preg_replace('!/\*.*?\*/!s', '', $code); // remove multiline comments
        $code = preg_replace('/\/\/.*(?:\r\n|\r|\n)/', '', $code); // remove single-line comments
        $code = preg_replace('/\n\s*\n/', "\n", $code); // remove empty lines
        $this->code = trim( $code ); // trim the code
    }

    public function hasMoreTokens() {
        return $this->code !== ""; // here I am not sure whether the line break will also be detected
    }

    public function advance() {
        // when the token advances, the left side of the input string (entire code loaded to memory) can be reaplced with "" (token is eaten)

        // match the pattern

        $pattern = '(class|constructor|function|method|field|static|var|int|char|boolean|void|true|false|null|this|let|do|if|else|while|return';
        $pattern .= '|\{|\}|\(|\)|\[|\]|\.|\,|\;|\+|\-|\*|\/|\&|\||\<|\>|\=|\~'; //symbol
        $pattern .= '|\d+'; // integerConstant
        $pattern .= '|\\"[^\"\n\r]*\"'; // stringConstant
        $pattern .= '|[a-zA-Z_]+\w*)'; // identifier

        preg_match('/' . $pattern . '/', $this->code, $matches, PREG_OFFSET_CAPTURE);

        $this->currentToken =  $matches[1][0];

        $this->code = substr($this->code, strlen( $this->currentToken ) ); // as I am using the PREG_OFFSET_CAPTURE flag

        $this->code = trim( $this->code ); // trimming, just to be on the safe side

    }

    public function tokenType() {

        // KEYWORD

        if(
            in_array(
                $this->currentToken,
                ['class','constructor','function','method','field','static','var','int','char','boolean','void',
                    'true','false','null','this','let','do','if','else','while','return']
            )
        ) { return 'KEYWORD'; }

        // SYMBOL

        if(
            in_array(
                $this->currentToken, 
                ['{','}','(',')','[',']','.',',',';','+','-','*','/','&','|','<','>','=','~']
            )
        ) { return 'SYMBOL'; }
        
        // IDENTIFIER

        if( preg_match( '/^[a-zA-Z_]+\w*$/', $this->currentToken ) == 1 ) { return 'IDENTIFIER'; }

        // INT_CONSTANT

        if( preg_match( '/\d+/', $this->currentToken ) == 1 ) { return 'INT_CONSTANT'; }

        // STRING_CONST

        if( preg_match( '/\"[^\"\n\r]*\"/', $this->currentToken ) == 1 ) { return 'STRING_CONSTANT'; }

        // ERROR

        return 'ERROR';

    }

    public function keyword() {

        return strtolower( $this->currentToken );

    }

    public function symbol() {

        switch ( $this->currentToken ) {
            case '<':
                return '&lt;';
                break;
            case '>':
                return '&gt;';
                break;
            case '""':
                return '&quot;';
                break;
            case '&':
                return '&amp;';
                break;
            default:
            return $this->currentToken;
        }

    }

    public function identifier() {

        return $this->currentToken;

    }

    public function intVal() {

        return $this->currentToken;

    }

    public function stringVal() {

        return substr( $this->currentToken, 1, strlen($this->currentToken) - 2 ); // strip the quotation marks
        
    }


}