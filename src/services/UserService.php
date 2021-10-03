<?php

    class UserService {

        private $xml;

        public function __construct(){
            $this->xml = new XMLManager("usuarios.xml", "usuario");
        }

        public function searcharray($value, $key, $array) {
            foreach ($array as $k => $val) {
                if ($val[$key] == $value) {
                    return $k;
                }
            }
            return null;
         }

        public function Login($fields){
            try {
                $email = isset($fields["email"]) ? $fields["email"] : "";
                $password = isset($fields["senha"]) ? $fields["senha"] : "";

                if(empty($email)){
                    return array("message" => "Empty email");
                }
                else if(empty($password)) {
                    return array("message" => "Empty password");
                }else{
                    $allUsers = json_decode($this->xml->ShowJson(), true);
                    $currentEmail = null;
                    $currentPassword = null;
                    $currentTipoPerfil = null;

                    $keyUser = array_search($email, array_column($allUsers["usuario"], "email"));
                    
                    if($keyUser >= 0){
                        $currentEmail = ($allUsers["usuario"][$keyUser]["email"] == $email) ? $email : null;
                        $currentPassword = ($allUsers["usuario"][$keyUser]["senha"] == $password) ? $password : null;
                        $currentTipoPerfil = ($allUsers["usuario"][$keyUser]["tipoPerfil"] != null && $currentEmail != null && $currentPassword != null) ? $allUsers["usuario"][$keyUser]["tipoPerfil"] : null;
                        if($currentEmail != null && $currentPassword != null && $currentTipoPerfil != null){
                            $tokenService = new TokenService();
                            $token = $tokenService->GetToken(["email" => $currentEmail, "tipoPerfil" => $currentTipoPerfil]);
    
                            return array("token" => $token);
                        }
                    }

                    return array("message" => "Wrong user");
                }
            }
            catch(Exception $e){
                return array("message" => $e->getMessage());
            }
        }

        public function Create($data){
            try {
                $data["id"] = md5(uniqid(rand(), true)); //id único

                $this->xml->AddData($data);

                return array('message' => 'Usuário cadastrado com sucesso!');
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
                foreach ($this->xml->LoadAll() as $usuario) {
                    if ((string)$usuario['id'] == (string)$id) {
                        return $usuario;
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
                
                return array('message' => 'Usuário removido com sucesso!');
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

        public function Update($id, $data){
            try {
                $data["id"] = $id;

                $this->xml->UpdateData($data);                
                return array('message' => 'Usuário editado com sucesso!');
            }
            catch(Exception $e){
                return array('message' => $e->getMessage());
            }
        }

    }