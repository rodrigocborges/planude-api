<?php

    class ExamService {

        private $xml;

        public function __construct(){
            $this->xml = new XMLManager("exames.xml", "exame");
        }

        public function Create($data){
            try {
                $data["id"] = md5(uniqid(rand(), true)); //id único

                $this->xml->AddData($data, $data["usuarioid"]);

                return array('message' => 'Exame cadastrado com sucesso!');
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

        public function GetByUserID($uid){
            try {
                $data = array();
                foreach ($this->xml->LoadAll() as $exame) {
                    if ((string)$exame['usuarioid'] == (string)$uid) {
                        array_push($data, $exame);
                    }
                }
                return $data;
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

        public function DeleteByID($id){
            try {
                $this->xml->DeleteDataByID($id);
                
                return array('message' => 'Exame removido com sucesso!');
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

        public function Update($id, $data){
            try {
                $data["id"] = $id;

                $this->xml->UpdateData($data);                
                return array('message' => 'Exame editado com sucesso!');
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

    }