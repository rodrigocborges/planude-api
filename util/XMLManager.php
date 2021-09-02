<?php

    //Classe responsável para realizar a manipulação de arquivos xml
    class XMLManager {

        private $filename;
        private $xmlString;
        private $xml;

        private $path = "database/";

        public function __construct($filename){
            $this->filename = $filename;
            $this->xmlString = file_get_contents($this->path.$this->filename);
            $this->xml = new SimpleXMLElement($this->xmlString);
        }

        //Adiciona registros em uma determinada tag
        public function AddData($tag, $val){
            try {
                if($this->xml == null){
                    throw new Exception("Arquivo XML não carregado");
                }

                $aux = $this->xml->addChild($tag, "");
                foreach($val as $key => $v)
                {
                    $aux->addChild($key, $v);
                }

                $this->xml->saveXML($this->path.$this->filename);

            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

        //Mostrar o conteúdo do XML de forma bruta
        public function ShowRaw(){
            try {
                print_r($this->xml);
            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

    }