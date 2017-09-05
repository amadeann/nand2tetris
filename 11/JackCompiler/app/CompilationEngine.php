<?php

namespace App;

class CompilationEngine {

    /*
    |--------------------------------------------------------------------------
    | Adding new elements to the symbol table
    |--------------------------------------------------------------------------
    |
    | Call to the define() method of the SymbolTable class can be done only from
    | within the compileIdentifier() method of the CompilationEngine class. 
    | define() method is called only when the $addToSymbolTable argument is set
    | to true. By default this arguments is set to false. It gets the value of
    | true only when compileIdentifier is called from within compileClassVarDec(),
    | compileParameterList(), or compileVarDec() methods.
    |
    */

    public $tokenizer;

    public $outputFile;

    public function __construct($inputFile, $outputFile) {

        $this->tokenizer = new JackTokenizer( $inputFile ); 

        $this->classSymbolTable = new SymbolTable();

        $this->subroutineSymbolTable = new SymbolTable();

        $this->outputFile = $outputFile;

    }

    protected $currenSymbolKind; // last encountered kind of an identifier

    protected $currenSymbolType; // last encountered type of an identifier

    protected $currenSymbolName; // last encountered name of an identifier

    /**
    * compile()
    */

    public function compile() {

        if ( !$this->tokenizer->hasMoreTokens() ) { return "line " . __LINE__ . " \n"; }
            
        $this->tokenizer->advance();

        $handle = fopen($this->outputFile, 'w') or die('Cannot open file:  ' . $this->outputFile );

        if ( $this->tokenizer->tokenType() !== 'KEYWORD' || $this->tokenizer->keyword() !== 'class' ) {

            fwrite( $handle,  'Invalid Jack code - the file should begin with a class declaration' );

        } else {
            
            fwrite( $handle, $this->compileClass() );

        }

        fclose($handle);
    }

    /**
    * compileClass()
    */

    public function compileClass() {
     
        $return_value = '<class>' . "\n";

        $return_value .= $this->compileKeyword('class');

        $return_value .= '<identifierClassDefined>' . $this->tokenizer->currentToken . "</identifierClassDefined>\n";
        
        if ( !$this->tokenizer->hasMoreTokens() ) {  return $return_value . "line " . __LINE__ . " \n"; }
                
        $this->tokenizer->advance();

        $return_value .= $this->compileSymbol('{');

        while ( in_array( $this->tokenizer->currentToken, ['static', 'field']) ) {

            $return_value .= $this->compileClassVarDec();

        }

        while ( in_array( $this->tokenizer->currentToken, ['constructor', 'function', 'method']) ) {

            $return_value .= $this->compileSubroutine();

            // return $return_value; // DEBUGGING 1

        }

        $return_value .= $this->compileSymbol('}');

        $return_value .= '</class>' . "\n";

        return $return_value;

    }

    /**
    * compileClassVarDec()
    */

    public function compileClassVarDec() {

        $return_value = "<classVarDec>\n";

        $return_value .= $this->compileKeyword( $this->tokenizer->currentToken );

        $return_value .= $this->compileTypeDeclaration();

        $return_value .= $this->compileIdentifier( $addToSymbolTable = true );

        while ( $this->tokenizer->currentToken === ',' ) {

            $return_value .= $this->compileSymbol(',');

            $return_value .= $this->compileIdentifier( $addToSymbolTable = true );

        }
        
        $return_value .= $this->compileSymbol(';');

        $return_value .= "</classVarDec>\n";

        return $return_value;

    }

    /**
    * compileSubroutine()
    */

    public function compileSubroutine() {

        $this->subroutineSymbolTable->startSubroutine();

        $return_value = "<subroutineDec>\n";

        $return_value .= $this->compileKeyword( $this->tokenizer->currentToken );

        $return_value .= $this->compileTypeDeclaration();

        // $return_value .= $this->compileIdentifier();

        $return_value .= '<identifierSubroutineDefined>' . $this->tokenizer->currentToken . "</identifierSubroutineDefined>\n";

        if ( !$this->tokenizer->hasMoreTokens() ) {  return $return_value . "line " . __LINE__ . " \n"; }
        
        $this->tokenizer->advance();

        $return_value .= $this->compileSymbol('(');

        $return_value .= $this->compileParameterList();

        $return_value .= $this->compileSymbol(')');

        $return_value .= "<subroutineBody>\n";

        $return_value .= $this->compileSymbol('{');

        while ( $this->tokenizer->currentToken === 'var' ) { 
            
            $return_value .= $this->compileVarDec();

        }
        
        $return_value .= $this->compileStatements();

        $return_value .= $this->compileSymbol('}');

        $return_value .= "</subroutineBody>\n";

        $return_value .= "</subroutineDec>\n";

        return $return_value;

    }

    /**
    * compileIdentifier()
    */

    public function compileIdentifier( $addToSymbolTable = false ) {

        $return_value = "";

        if ( $this->tokenizer->tokenType() !== 'IDENTIFIER' ) {
            
            return $return_value . "expected an identifier\n";

        }

        $identifier = $this->tokenizer->currentToken;

        if ( !$this->tokenizer->hasMoreTokens() ) {  return $return_value . "line " . __LINE__ . " \n"; }
        
        $this->tokenizer->advance();

        $this->setCurrentSymbolName( $identifier );

        if ( $addToSymbolTable ) {

            if ( in_array( $this->getCurrentSymbolKind(), ['static', 'field'] ) ) {

                $this->classSymbolTable->define( $this->getCurrentSymbolName(), $this->getCurrentSymbolType(), $this->getCurrentSymbolKind() );
            
            }

            if ( in_array( $this->getCurrentSymbolKind(), ['argument', 'var'] ) ) {

                $this->subroutineSymbolTable->define( $this->getCurrentSymbolName(), $this->getCurrentSymbolType(), $this->getCurrentSymbolKind() );
            
            }


        }

        // look up in the subroutine symbol table

        if ( $this->subroutineSymbolTable->kindOf( $identifier ) !== 'none' ) {

            $tag = 'identifier' . 
                ucfirst( $this->subroutineSymbolTable->kindOf( $identifier ) ) . 
                $this->subroutineSymbolTable->IndexOf( $identifier ) . 
                ( $addToSymbolTable ? 'Defined' : 'Used' );

        } elseif ( $this->classSymbolTable->kindOf( $identifier ) !== 'none' ) {

            $tag = 'identifier' . 
                ucfirst( $this->classSymbolTable->kindOf( $identifier ) ) . 
                $this->classSymbolTable->IndexOf( $identifier ) . 
                ( $addToSymbolTable ? 'Defined' : 'Used' );

        } else {

            if ( $this->tokenizer->currentToken == '.' ) {

                $tag ='identifierClassUsed';

            } else {

                $tag ='identifierSubroutineUsed';

            }

        }
        
        $return_value .= '<' . $tag . '>' . $identifier . '</' . $tag . ">\n";

        return $return_value;

    }

    /**
    * compileTypeDeclaration()
    */

    public function compileTypeDeclaration() {

        $return_value = "";

        if ( !in_array( $this->tokenizer->currentToken, ['int', 'char', 'boolean', 'void']) && $this->tokenizer->tokenType() !== 'IDENTIFIER' ) {
            
            return $return_value . "expected the type declaration" . '. encountered ' . $this->tokenizer->tokenType() . ' ' . $this->tokenizer->currentToken ."\n";

        }

        if (in_array( $this->tokenizer->currentToken, ['int', 'char', 'boolean', 'void'])) {

            if ( $this->tokenizer->currentToken === 'int' ) { $this->setCurrentSymbolType( 'int' ); }

            if ( $this->tokenizer->currentToken === 'char' ) { $this->setCurrentSymbolType( 'char' ); }

            if ( $this->tokenizer->currentToken === 'boolean' ) { $this->setCurrentSymbolType( 'boolean' ); }

            $return_value .= '<keyword>' . $this->tokenizer->currentToken . "</keyword>\n";

        } else {

            $this->setCurrentSymbolType( $this->tokenizer->currentToken );

            $return_value .= '<identifier>' . $this->tokenizer->currentToken . "</identifier>\n";

        }        

        if ( !$this->tokenizer->hasMoreTokens() ) {  return $return_value .  "line " . __LINE__ . " \n"; }
        
        $this->tokenizer->advance();

        return $return_value;

    }

    /**
    * compileSymbol( $symbol )
    */

    public function compileSymbol( $symbol ) {

        $return_value = "";

        if ( $this->tokenizer->currentToken !== $symbol ) {
            
            return "expected '" . $symbol . "' symbol\n";

        } else {

            $return_value .= '<symbol>' . $this->tokenizer->symbol() .'</symbol>' . "\n";

        }

        if ( !$this->tokenizer->hasMoreTokens() ) {  return $return_value; }
        
        $this->tokenizer->advance();

        return $return_value;

    }

    /**
    * compileKeyword( $keyword )
    */

    public function compileKeyword( $keyword ) {
        
        $return_value = "";

        if ( $this->tokenizer->currentToken !== $keyword ) {
            
            return "expected '" . $keyword . "' keyword\n";

        } else {

            $return_value .= '<keyword>' . $keyword .'</keyword>' . "\n";

        }

        if ( $keyword === 'static') { $this->setCurrentSymbolKind( 'static' ); }

        if ( $keyword === 'field') { $this->setCurrentSymbolKind( 'field' ); }

        if ( $keyword === 'var') { $this->setCurrentSymbolKind( 'var' ); }

        if ( !$this->tokenizer->hasMoreTokens() ) {  return $return_value . "line " . __LINE__ . " \n"; }
        
        $this->tokenizer->advance();

        return $return_value;

    }

    /**
    * compileParameterList()
    */

    public function compileParameterList() {

        $this->setCurrentSymbolKind( 'argument' );

        $return_value = "<parameterList>\n";

        if ( $this->tokenizer->currentToken === ')' ) { // i.e. function with no parameters
            
            $return_value .= "</parameterList>\n";
            
            return $return_value;

        }

        $return_value .= $this->compileTypeDeclaration();

        $return_value .= $this->compileIdentifier( true );

        while ( $this->tokenizer->currentToken === ',' ) {

            $return_value .= $this->compileSymbol(',');

            $return_value .= $this->compileTypeDeclaration();
            
            $return_value .= $this->compileIdentifier( true );

        }

        $return_value .= "</parameterList>\n";

        return $return_value;

    }

    /**
    * compileVarDec()
    */

    public function compileVarDec() {

        $return_value = "<varDec>\n";
        
        if ( $this->tokenizer->currentToken !== 'var' ) {

            return $return_value . "expected 'var' keyword\n";

        }

        $return_value .= $this->compileKeyword('var');

        $return_value .= $this->compileTypeDeclaration();

        $return_value .= $this->compileIdentifier( true );

        while ( $this->tokenizer->currentToken === ',' ) {
            
            $return_value .= $this->compileSymbol(',');
            
            $return_value .= $this->compileIdentifier( true );

        }

        $return_value .= $this->compileSymbol(';');

        $return_value .= "</varDec>\n";

        return $return_value;
        
    }

    /**
    * compileStatements()
    */

    public function compileStatements() {

        $return_value = "<statements>\n";

        while ( in_array( $this->tokenizer->currentToken, ['let', 'if', 'while', 'do', 'return'] ) ) {
            
            switch ( $this->tokenizer->currentToken ) {

                case 'let':
                    $return_value .= $this->compileLet();
                    break;
                case 'if':
                    $return_value .= $this->compileIf();
                    break;
                case 'while':
                    $return_value .= $this->compileWhile();
                    break;
                case 'do':
                $return_value .= $this->compileDo();
                    break;
                case 'return':
                $return_value .= $this->compileReturn();
                    break;
                default:
                    return $return_value . "expected a statement keyword\n";

            }

        }

        $return_value .= "</statements>\n";
        
        return $return_value;

    }

    /**
    * compileDo()
    */

    public function compileDo() {

        $return_value = "";
        
        if ( $this->tokenizer->currentToken !== 'do' ) {

            return $return_value . "expected 'do' keyword\n";

        }

        $return_value .= "<doStatement>\n";

        $return_value .= $this->compileKeyword('do');

        $return_value .= $this->compileIdentifier();

        if ( $this->tokenizer->currentToken === '.' ) {

            $return_value .= $this->compileSymbol('.');

            $return_value .= $this->compileIdentifier();

        }

        $return_value .= $this->compileSymbol('(');

        $return_value .= $this->compileExpressionList();

        $return_value .= $this->compileSymbol(')');

        $return_value .= $this->compileSymbol(';');

        $return_value .= "</doStatement>\n";

        return $return_value;

    }

    /**
    * compileLet()
    */

    public function compileLet() {

        $return_value = "";
        
        if ( $this->tokenizer->currentToken !== 'let' ) {

            return $return_value . "expected 'let' keyword\n";

        }

        $return_value .= "<letStatement>\n";

        $return_value .= $this->compileKeyword('let');

        $return_value .= $this->compileIdentifier();

        if ( $this->tokenizer->currentToken === '[' ) {

            $return_value .= $this->compileSymbol('[');

            $return_value .= $this->compileExpression();

            $return_value .= $this->compileSymbol(']');

        }

        $return_value .= $this->compileSymbol('=');

        $return_value .= $this->compileExpression();

        $return_value .= $this->compileSymbol(';');

        $return_value .= "</letStatement>\n";

        return $return_value;

    }

    /**
    * compileWhile()
    */

    public function compileWhile() {

        $return_value = "";
        
        if ( $this->tokenizer->currentToken !== 'while' ) {

            return $return_value . "expected 'while' keyword\n";

        }

        $return_value .= "<whileStatement>\n";

        $return_value .= $this->compileKeyword('while');

        $return_value .= $this->compileSymbol('(');

        $return_value .= $this->compileExpression();

        $return_value .= $this->compileSymbol(')');

        $return_value .= $this->compileSymbol('{');

        $return_value .= $this->compileStatements();

        $return_value .= $this->compileSymbol('}');
        
        $return_value .= "</whileStatement>\n";

        return $return_value;

    }

    /**
    * compileReturn()
    */

    public function compileReturn() {

        $return_value = "";
        
        if ( $this->tokenizer->currentToken !== 'return' ) {

            return $return_value . "expected 'return' keyword\n";

        }

        $return_value .= "<returnStatement>\n";

        $return_value .= $this->compileKeyword('return');

        if ($this->tokenizer->currentToken !== ';') {

            $return_value .= $this->compileExpression();

        }

        $return_value .= $this->compileSymbol(';');
        
        $return_value .= "</returnStatement>\n";

        return $return_value;

    }

    /**
    * compileIf()
    */

    public function compileIf() {

        $return_value = "";
        
        if ( $this->tokenizer->currentToken !== 'if' ) {

            return $return_value . "expected 'if' keyword\n";

        }

        $return_value .= "<ifStatement>\n";

        $return_value .= $this->compileKeyword('if');

        $return_value .= $this->compileSymbol('(');

        $return_value .= $this->compileExpression();

        $return_value .= $this->compileSymbol(')');

        $return_value .= $this->compileSymbol('{');
    
        $return_value .= $this->compileStatements();
        
        $return_value .= $this->compileSymbol('}');

        if ( $this->tokenizer->currentToken === 'else' ) {

            $return_value .= $this->compileKeyword('else');

            $return_value .= $this->compileSymbol('{');
                
            $return_value .= $this->compileStatements();
            
            $return_value .= $this->compileSymbol('}');

        }
        
        $return_value .= "</ifStatement>\n";

        return $return_value;

    }

    /**
    * compileExpression()
    */

    public function compileExpression() {

        $return_value = "<expression>\n";

        $return_value .= $this->compileTerm();

        if ( in_array( $this->tokenizer->currentToken, ['+', '-', '*', '/', '&', '|', '<', '>', '='] ) ) {

            $return_value .= $this->compileSymbol( $this->tokenizer->currentToken );

            $return_value .= $this->compileTerm();

        }

        $return_value .= "</expression>\n";

        return $return_value;

    }

    /**
    * compileTerm()
    */

    public function compileTerm() {

        $return_value = "<term>\n";

        if ( $this->tokenizer->tokenType() === 'INT_CONSTANT') {

            $return_value .= "<integerConstant>" . $this->tokenizer->currentToken . "</integerConstant>\n";

            if ( !$this->tokenizer->hasMoreTokens() ) {  return $return_value .  "line " . __LINE__ . " \n"; }
            
            $this->tokenizer->advance();

        } elseif ( $this->tokenizer->tokenType() === 'STRING_CONSTANT') {
            
            $return_value .= "<stringConstant>" . $this->tokenizer->stringVal() . "</stringConstant>\n";

            if ( !$this->tokenizer->hasMoreTokens() ) {  return $return_value .  "line " . __LINE__ . " \n"; }
            
            $this->tokenizer->advance();

        } elseif ( in_array( $this->tokenizer->currentToken, ['true', 'false', 'null', 'this'] ) ) {
            
            $return_value .= $this->compileKeyword( $this->tokenizer->currentToken );

        } elseif ( $this->tokenizer->currentToken === '(') {
            
            $return_value .= $this->compileSymbol('(');

            $return_value .= $this->compileExpression();

            $return_value .= $this->compileSymbol(')');

        } elseif ( in_array( $this->tokenizer->currentToken, ['-', '~'] ) ) {

            $return_value .= $this->compileSymbol( $this->tokenizer->currentToken );

            $return_value .= $this->compileTerm();

        } else {

            $return_value .= $this->compileIdentifier();

            if( $this->tokenizer->currentToken === '[' ) {

                $return_value .= $this->compileSymbol('[');

                $return_value .= $this->compileExpression();

                $return_value .= $this->compileSymbol(']');

            } elseif ( $this->tokenizer->currentToken === '(' ) {

                $return_value .= $this->compileSymbol('(');

                $return_value .= $this->compileExpressionList();

                $return_value .= $this->compileSymbol(')');

            } elseif ( $this->tokenizer->currentToken === '.' ) {

                $return_value .= $this->compileSymbol('.');

                $return_value .= $this->compileIdentifier();

                $return_value .= $this->compileSymbol('(');
                
                $return_value .= $this->compileExpressionList();

                $return_value .= $this->compileSymbol(')');

            }

        }

        $return_value .= "</term>\n";

        return $return_value;

    }

    /**
    * compileExpressionList()
    */

    public function compileExpressionList() {

        $return_value = "<expressionList>\n";

        if ( $this->tokenizer->currentToken === ')' ) { return $return_value . "</expressionList>\n"; } // no expressions

        $return_value .= $this->compileExpression();

        while ( $this->tokenizer->currentToken === ',' ) {

            $return_value .= $this->compileSymbol( ',' );

            $return_value .= $this->compileExpression();

        }

        $return_value .= "</expressionList>\n";

        return $return_value;
        
    }

    public function setCurrentSymbolKind( $kind ) {
        
        $this->currenSymbolKind = $kind;
                
    }

    public function getCurrentSymbolKind() {

        return $this->currenSymbolKind;
        
    }

    public function setCurrentSymbolType( $type ) {

        $this->currenSymbolType = $type;

    }

    public function getCurrentSymbolType() {

        return $this->currenSymbolType;

    }

    public function setCurrentSymbolName( $name ) {

        $this->currenSymbolName = $name;

    }

    public function getCurrentSymbolName() {

        return $this->currenSymbolName;

    }

}