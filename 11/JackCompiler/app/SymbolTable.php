<?php

namespace App;

class SymbolTable {

    public $table;

    public function __construct() {

        $this->table = [];

    }

    public function startSubroutine() {

        $this->table = [];

    }

    public function define( $name, $type, $kind ) {

        $this->table[$name] = [$type, $kind, $this->varCount( $kind ) ];

    }

    public function varCount( $kind ) {

        return count(

            array_filter(

                $this->table,
                function( $el ) use ( $kind ) {return $el[1] === $kind; }

            )

        ); 

    }

    public function kindOf( $name ) {

        if ( isset( $this->table[$name] ) ) { return $this->table[$name][1]; }

        return 'none';

    }

    public function typeOf( $name ) {

        if ( isset( $this->table[$name] ) ) { return $this->table[$name][0]; }

        return;

    }

    public function indexOf( $name ) {

        if ( isset( $this->table[$name] ) ) { return $this->table[$name][2]; }

        return;

    }

}