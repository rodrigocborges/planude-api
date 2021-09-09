<?php

    require_once(__DIR__ . '/../util/Enumerators.php');
    require_once(__DIR__ . '/../util/XMLManager.php');
    require_once(__DIR__ . '/../src/Router.php');
    require_once(__DIR__ . '/../src/services/TokenService.php');
    require_once(__DIR__ . '/../src/services/UserService.php');

    date_default_timezone_set('America/Sao_Paulo');
    header("Content-Type: application/json;charset=utf-8");

    $tokenExpirationTime = 300; //em segundos

    router('GET', '^/$', function($params) {
        echo 'Teste rota /';

        $xmlManager = new XmlManager("medicos.xml", "medico");
        //$xmlManager->ShowRaw();

        //$xmlManager->AddData(array("id" => 1, "nome" => "Teste", "idade" => 30, "crm" => "3000-01"));

        //$xmlManager->DeleteDataByID(3);    

        //$xmlManager->UpdateData(array("id" => 3, "nome" => "Teste", "idade" => 30, "crm" => "3000-01"));

        //$xmlManager->ShowRaw();

        $xmlManager->ShowJson();
    });


    router('POST', '^/login$', function($params) {
        $json = json_decode(file_get_contents('php://input'), true);
        $userService = new UserService();
        echo json_encode($userService->Login($json));
    });

    router('POST', '^/checktoken$', function($params) {
        $tokenService = new TokenService();
        $json = json_decode(file_get_contents('php://input'), true);
        echo json_encode(["is_valid" => $tokenService->IsValid($json["token"])]);
    });

    header("HTTP/1.0 404 Not Found");
    echo json_encode(array("message" => "404"));