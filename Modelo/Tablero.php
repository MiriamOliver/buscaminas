<?php
    class Tablero {
        public $id;
        public $tab;
        public $mina;
        public $tam;

        function __construct(){
            $params = func_get_args();
		    $num_params = func_num_args();
		    $funcion_constructor ='__construct'.$num_params;
		    if (method_exists($this,$funcion_constructor)) {
			    call_user_func_array(array($this,$funcion_constructor),$params);
		    }
        }


        function __construct3($id, $long, $mina){
            $this->$id = $id;
            $this->tab = [];
            $this->mina = $mina;
            $this->tam = $long;
        }

        function __construct1($tablero){
            $this->tab = $tablero;
            $this->tam = count($tablero);
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of tab
         */ 
        public function getTab()
        {
                return $this->tab;
        }

        /**
         * Set the value of tab
         *
         * @return  self
         */ 
        public function setTab($tab)
        {
                $this->tab = $tab;

                return $this;
        }

        /**
         * Get the value of mina
         */ 
        public function getMina()
        {
                return $this->mina;
        }

        /**
         * Set the value of mina
         *
         * @return  self
         */ 
        public function setMina($mina)
        {
                $this->mina = $mina;

                return $this;
        }

        /**
         * Get the value of tam
         */ 
        public function getTam()
        {
                return $this->tam;
        }

        /**
         * Set the value of tam
         *
         * @return  self
         */ 
        public function setTam($tam)
        {
                $this->tam = $tam;

                return $this;
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
                }while($this->tab[$alea] == ' * ');
                $this->tab[$alea] = ' * ';      
            }
        }

        function construirPistas(){
            for( $i = 0; $i < $this->tam; $i++ ){
                if($this->tab[$i] == ' * '){
                    if($i + 1 < $this->tam && $this->tab[$i + 1] != ' * '){
                        if($this->tab[$i + 1] == ' - '){
                            $this->tab[$i + 1] = 1;
                        }else{
                            $this->tab[$i + 1] = $this->tab[$i + 1] + 1;
                        }
                    }
                    if($i - 1 > 0 && $this->tab[$i - 1] != ' * '){
                        if($this->tab[$i - 1] == ' - '){
                            $this->tab[$i - 1] = 1;
                        }else{
                            $this->tab[$i - 1] = $this->tab[$i + 1] + 1;
                        }
                    }
                }
            }
        }

        function comprobarTablero($pos){
            $result = false;
            if ($this->tab[$pos] == '*'){
                $result = true;
            }
            return $result;
        }

        function getResultado($pos){
            return $this->tab[$pos];
        }

        function guardarResultado($pos, $result){
            if($result == '-'){
                $this->tab[$pos] = 0;
            }else{
                $this->tab[$pos] = $result;
            }
        }

        function cantCasillas(){
            $casilla = 0;
            for( $i = 0; $i < $this->tam; $i++){
                if($this->tab[$i] == '-'){
                    $casilla ++;
                }
            }
            return $casilla;
        }
    }
?>