<?php

    class TokenService {
        
        private $info;
        private $secretKey = "sHht'DJu<wE*E~j9.>OZJ$*3`FIV!I";
        
        public function __construct(){}

        public function GetToken($info){
            try {                
                $this->info = $info;
                
                if(isset($_COOKIE["accessToken"])){
                    unset($_COOKIE["accessToken"]);
                }

                $jwt = $this->JWT();
                setcookie("accessToken", $jwt, ( time() + intval($GLOBALS["tokenExpirationTime"]) ), '/');
                return $jwt;

                return $_COOKIE["accessToken"];
            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

        public function IsValid($clientToken){
            try {
                if(!isset($_COOKIE["accessToken"]))
                    return false;

                $tokenServer = $this->base64url_decode($_COOKIE["accessToken"]);
                $tokenClient = $this->base64url_decode($clientToken);
                return $tokenServer == $tokenClient;
            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

        public function base64url_encode($data)
        {
            $b64 = base64_encode($data);
            
            if ($b64 === false) {
                return false;
            }
            $url = strtr($b64, '+/', '-_');
            return rtrim($url, '=');
        }
        
        public function base64url_decode($data, $strict = false)
        {
            $b64 = strtr($data, '-_', '+/');        
            return base64_decode($b64, $strict);
        }
        
        private function JWT(){
            //Criando o JWT token
            $header = [
                "typ" => "JWT",
                "alg" => "HS256",
            ];

            //Payload (conteúdo)
            $payload = [
                "exp" => (new DateTime("now"))->getTimestamp(),
                "info" => $this->info
            ];

            //Json
            $header = json_encode($header);
            $payload = json_encode($payload);

            //Base 64
            $header = $this->base64url_encode($header);
            $payload = $this->base64url_encode($payload);

            //Assinatura
            $sign = hash_hmac('sha256', $header . "." . $payload, $this->secretKey, true);
            $sign = $this->base64url_encode($sign);

            $token = $header . "." . $payload . "." . $sign;
            return $token;
        }

    }