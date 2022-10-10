<?php
    class Tablero {
        public $id;
        public $tab;
        public $pos;
        public $tam;


        function __construct($p,$long){
            $this->$id;
            $this->tab = [];
            $this->pos = $p;
            $this->tam = $long;
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
         * Get the value of pos
         */ 
        public function getPos()
        {
                return $this->pos;
        }

        /**
         * Set the value of pos
         *
         * @return  self
         */ 
        public function setPos($pos)
        {
                $this->pos = $pos;

                return $this;
        }

        /**
         * Get the value of mensaje
         */ 
        public function getMensaje()
        {
                return $this->mensaje;
        }

        /**
         * Set the value of mensaje
         *
         * @return  self
         */ 
        public function setMensaje($mensaje)
        {
                $this->mensaje = $mensaje;

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
    }
?>