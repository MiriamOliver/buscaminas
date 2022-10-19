<?php
    class Jugador{
        public $id;
        public $nombre;
        public $passw;
        public $correo;
        public $realizadas;
        public $ganadas;
        public $perdidas;
        public $verificado;

        function __construct($id, $nombre, $passw, $email, $realizadas, $ganadas, $perdidas, $verificar){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->passw = $passw;
            $this->correo = $email;
            $this->realizadas = $realizadas;
            $this->ganadas = $ganadas;
            $this->perdidas = $perdidas;
            $this->verificado = $verificar;
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
        public function getPasww()
        {
                return $this->passw;
        }

        /**
         * Set the value of clave
         *
         * @return  self
         */ 
        public function setPassw($passw)
        {
                $this->passw = $passw;

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

        /**
         * Get the value of correo
         */ 
        public function getCorreo()
        {
                return $this->correo;
        }

        /**
         * Set the value of correo
         *
         * @return  self
         */ 
        public function setCorreo($correo)
        {
                $this->correo = $correo;

                return $this;
        }

        /**
         * Get the value of verificado
         */ 
        public function getVerificado()
        {
                return $this->verificado;
        }

        /**
         * Set the value of verificado
         *
         * @return  self
         */ 
        public function setVerificado($verificado)
        {
                $this->verificado = $verificado;

                return $this;
        }

        function __toString(){
            return "Jugador{ ID : ".$this->id." Nombre : ".$this->nombre. ", Realizadas : " .$this->realizadas. ", Ganadas : " .$this->ganadas. ", Perdidas : " .$this->perdidas. "}";
        }
    }

?>