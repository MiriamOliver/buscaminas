<?php
    class Tablero {
        public $id;
        public $tab;
        public $mina;
        public $tam;


        function __construct($mina,$long){
            $this->$id;
            $this->tab = [];
            $this->mina = $mina;
            $this->tam = $long;
        }

        function generarTablero(){
            for( $i = 0; $i < $this->tam; $i++ ){
                $this->tab[$i]= ' - ';
            }          
        }

        function addMinas(){
            for($i = 0; $i < $this->mina; $i++){
                do{
                    $alea = rand(0,($this->tam-1));
                }while($this->tab[$alea] == '*');
                $this->tab[$alea] = '*';      
            }
        }

        function construirPistas(){
            for( $i = 0; $i < $this->tam; $i++ ){
                if($this->tab[$i] == '*'){
                    if($i + 1 < $this->tam && $this->tab[$i + 1] != '*'){
                        $this->tab[$i + 1] = $this->tab[$i + 1] + 1;
                    }
                    if($i - 1 > 0 && $this->tab[$i - 1] != '*'){
                        $this->tab[$i - 1] = $this->tab[$i + 1] + 1;
                    }
                }
            }
        }

        function comprobarTablero($pos){
            $result = false;
            if ($this->tab[$pos] == '*'){
                $result = true;
            }
            return result;
        }

        function getResultado($pos){
            return $this->tab[$pos];
        }

        function guardarResultado($pos, $result){
            $this->tab[$pos] = $result;
        }

    }
?>