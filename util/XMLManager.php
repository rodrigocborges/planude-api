<?php

    //Classe responsável para realizar a manipulação de arquivos xml
    class XMLManager {

        private $filename;
        private $xmlString;
        private $xml;
        private $mainNode; //Nó responsável por ser o principal para ser realizado as operações do CRUD

        private $path = __DIR__."/../database/";

        public function __construct($filename, $mainNode){
            $this->filename = $filename;
            $this->mainNode = $mainNode;
            $this->xmlString = file_get_contents($this->path.$this->filename);
            $this->xml = new SimpleXMLElement($this->xmlString);
        }

        //Deleta um registro pelo id do nó principal definido no construtor
        public function DeleteDataByID($id){
            try {
                if($this->xml == null){
                    throw new Exception("Arquivo XML não carregado");
                }

                $indexToRemove = 0;
                $aux = 0;

                $element = $this->mainNode;

                foreach($this->xml->$element as $el){
                    if($el["id"] == $id){
                        $indexToRemove = $aux;
                        break;
                    }
                    ++$aux;
                }

                unset($this->xml->$element[$indexToRemove]);
                $this->xml->saveXML($this->path.$this->filename);

            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

        //Adiciona registros em uma determinada tag
        public function AddData($data, $usuarioID = null){
            try {
                if($this->xml == null){
                    throw new Exception("Arquivo XML não carregado");
                }
                $element = $this->mainNode;
                $aux = $this->xml->addChild($element, "");
                $aux->addAttribute("id", $data["id"]);

                if($usuarioID != null){
                    $aux->addAttribute("usuarioid", $usuarioID);
                }

                foreach($data as $key => $v)
                {
                    if($key != "id" || $key != "usuarioid"){
                        $aux->addChild($key, $v);
                    }
                }

                $this->xml->saveXML($this->path.$this->filename);

            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

        //Edita registros baseados em um ID
        public function UpdateData($data){
            try {
                if($this->xml == null){
                    throw new Exception("Arquivo XML não carregado");
                }

                $element = $this->mainNode;
                $indexToUpdate = 0;
                $aux = 0;                

                foreach($this->xml->$element as $el){
                    if($el["id"] == $data["id"]){
                        $indexToUpdate = $aux; 
                        break;
                    }
                    ++$aux;
                }

                foreach($data as $key => $val){
                    if($key != "id"){
                        $this->xml->$element[$indexToUpdate]->$key = $val;
                    }
                }

                $this->xml->saveXML($this->path.$this->filename);

            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

        //Carrega todos os registros em um vetor bruto
        public function LoadAll(){
            try {
                if($this->xml == null){
                    throw new Exception("Arquivo XML não carregado");
                }

                $element = $this->mainNode;         
                $array = array();
                
                foreach($this->xml->$element as $val){
                    $array[] = $val;
                }

                return $array;

            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

        //Carrega todos os elementos e retorna um JSON para converter após para um vetor
        public function ShowJson(){
            try {
                $json = json_encode($this->xml);
                return $json;
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