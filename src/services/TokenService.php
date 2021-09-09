<?php

    class TokenService {
        
        private $info;
        
        public function __construct(){}

        public function GetToken($info){
            try {                
                $info["validation"] = date('Y-m-d\TH:i:sP'); 
                $info["key"] = mt_rand(0, 99999);
                $this->info = $info;

                //return $this->info;

                if(!isset($_COOKIE["accessToken"])){
                    $tokenData = base64_encode(json_encode($this->info));
                    setcookie("accessToken", $tokenData, time() + intval($GLOBALS["tokenExpirationTime"]), '/');
                    return $tokenData;
                }

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

                $tokenServer = json_decode(base64_decode($_COOKIE["accessToken"]), true);
                $tokenClient = json_decode(base64_decode($clientToken), true);
                return ($tokenClient == $tokenServer);
            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }

    }