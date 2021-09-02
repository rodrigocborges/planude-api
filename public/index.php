<?php

    require_once(__DIR__ . '/../util/XMLManager.php');
    require_once(__DIR__ . '/../src/Router.php');

    header("Content-Type: application/json;charset=utf-8");

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

    router('GET', '^/teste$', function($params) {
        echo json_encode(array("message" => "EAEEEEE"));
    });

    header("HTTP/1.0 404 Not Found");
    echo json_encode(array("message" => "404"));