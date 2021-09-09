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
                    $currentEmail = "";
                    $currentPassword = "";
                    $currentTipoPerfil = "";

                    foreach($allUsers["usuario"] as $val){
                        if($val["email"] == trim($email)){
                            $currentEmail = $val["email"];
                            $currentTipoPerfil = $val["tipoPerfil"];
                        }
                        if($val["senha"] == trim($password)){
                            $currentPassword = $val["senha"];
                            $currentTipoPerfil = $val["tipoPerfil"];
                        }
                    }

                    if(empty($currentEmail) || empty($currentPassword)){
                        return array("message" => "Wrong user");
                    }else{

                        $tokenService = new TokenService();
                        $token = $tokenService->GetToken(["email" => $currentEmail, "tipoPerfil" => $currentTipoPerfil]);

                        return array("token" => $token);
                    }
                }
            }
            catch(Exception $e){
                return array("message" => $e->getMessage());
            }
        }

    }