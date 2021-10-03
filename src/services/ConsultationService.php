<?php

    class ConsultationService {

        private $xml;

        public function __construct(){
            $this->xml = new XMLManager("consultas.xml", "consulta");
        }

        public function Create($data){
            try {
                $data["id"] = md5(uniqid(rand(), true)); //id único

                $this->xml->AddData($data);

                return array('message' => 'Consulta cadastrada com sucesso!');
            }
            catch(Exception $e){
                return array("message" => $e->getMessage());
            }
        }

        public function GetAll(){
            try {
                return $this->xml->ShowJson();
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

        public function GetByID($id){
            try {
                foreach ($this->xml->LoadAll() as $exame) {
                    if ((string)$exame['id'] == (string)$id) {
                        return $exame;
                    }
                }
                return array();
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

        public function DeleteByID($id){
            try {
                $this->xml->DeleteDataByID($id);
                
                return array('message' => 'Consulta removida com sucesso!');
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

        public function Update($id, $data){
            try {
                $data["id"] = $id;

                $this->xml->UpdateData($data);                
                return array('message' => 'Consulta editada com sucesso!');
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

    }