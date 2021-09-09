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

    }