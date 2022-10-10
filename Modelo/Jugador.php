<?php
    class Jugador{
        public $id;
        public $nombre;
        public $clave;
        public $realizadas;
        public $ganadas;
        public $perdidas;

        function __construct($id, $nombre, $clave, $realizadas, $ganadas, $perdidas){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->clave = $clave;
            $this->realizadas = $realizadas;
            $this->ganadas = $ganadas;
            $this->perdidas = $perdidas;
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of clave
         */ 
        public function getClave()
        {
                return $this->clave;
        }

        /**
         * Set the value of clave
         *
         * @return  self
         */ 
        public function setClave($clave)
        {
                $this->clave = $clave;

                return $this;
        }

        /**
         * Get the value of realizadas
         */ 
        public function getRealizadas()
        {
                return $this->realizadas;
        }

        /**
         * Set the value of realizadas
         *
         * @return  self
         */ 
        public function setRealizadas($realizadas)
        {
                $this->realizadas = $realizadas;

                return $this;
        }

        /**
         * Get the value of ganadas
         */ 
        public function getGanadas()
        {
                return $this->ganadas;
        }

        /**
         * Set the value of ganadas
         *
         * @return  self
         */ 
        public function setGanadas($ganadas)
        {
                $this->ganadas = $ganadas;

                return $this;
        }

        /**
         * Get the value of perdidas
         */ 
        public function getPerdidas()
        {
                return $this->perdidas;
        }

        /**
         * Set the value of perdidas
         *
         * @return  self
         */ 
        public function setPerdidas($perdidas)
        {
                $this->perdidas = $perdidas;

                return $this;
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

        function __toString(){
            return "Jugador{ Nombre : ".$this->nombre. ", Realizadas : " .$this->realizadas. ", Ganadas : " .$this->ganadas. ", Perdidas : " .$this->perdidas. "}";
        }
    }

?>