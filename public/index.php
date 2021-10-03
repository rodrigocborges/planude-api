<?php
    
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header('Content-type: application/json; charset=utf-8');
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "OPTIONS") {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        header("HTTP/1.1 200 OK");
        die();
    }    

    require_once(__DIR__ . '/../util/Enumerators.php');
    require_once(__DIR__ . '/../util/XMLManager.php');
    require_once(__DIR__ . '/../src/Router.php');
    require_once(__DIR__ . '/../src/services/TokenService.php');
    require_once(__DIR__ . '/../src/services/UserService.php');
    require_once(__DIR__ . '/../src/services/ExamService.php');
    require_once(__DIR__ . '/../src/services/ConsultationService.php');

    date_default_timezone_set('America/Sao_Paulo');
    

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

    //Login
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

    //Usuários
    router('GET', '^/users/(?<id>\w+)$', function($params) {
        $userService = new UserService();
        echo json_encode($userService->GetByID($params["id"]));
    });

    router('GET', '^/users$', function($params) {
        $userService = new UserService();
        echo $userService->GetAll();
    });

    router('DELETE', '^/users/(?<id>\w+)$', function($params) {
        $userService = new UserService();
        echo json_encode($userService->DeleteByID($params["id"]));
    });

    router('POST', '^/users$', function($params) {
        $json = json_decode(file_get_contents('php://input'), true);
        $userService = new UserService();
        echo json_encode($userService->Create($json));
    });

    router('PATCH', '^/users/(?<id>\w+)$', function($params) {
        $json = json_decode(file_get_contents('php://input'), true);
        $userService = new UserService();
        echo json_encode($userService->Update($params["id"], $json));
    });

    //Exames (usado por laboratório e paciente)
    router('GET', '^/exams/(?<id>\w+)$', function($params) {
        $examService = new ExamService();
        echo json_encode($examService->GetByID($params["id"]));
    });

    router('GET', '^/exams$', function($params) {
        $examService = new ExamService();
        echo $examService->GetAll();
    });

    router('DELETE', '^/exams/(?<id>\w+)$', function($params) {
        $examService = new ExamService();
        echo json_encode($examService->DeleteByID($params["id"]));
    });

    router('POST', '^/exams$', function($params) {
        $json = json_decode(file_get_contents('php://input'), true);
        $examService = new ExamService();
        echo json_encode($examService->Create($json));
    });

    router('PATCH', '^/exams/(?<id>\w+)$', function($params) {
        $json = json_decode(file_get_contents('php://input'), true);
        $examService = new ExamService();
        echo json_encode($examService->Update($params["id"], $json));
    });

    //Consultas (usado por paciente e médico)
    router('GET', '^/consultations/(?<id>\w+)$', function($params) {
        $consultationService = new ConsultationService();
        echo json_encode($examService->GetByID($params["id"]));
    });

    router('GET', '^/consultations$', function($params) {
        $consultationService = new ConsultationService();
        echo $consultationService->GetAll();
    });

    router('DELETE', '^/consultations/(?<id>\w+)$', function($params) {
        $consultationService = new ConsultationService();
        echo json_encode($consultationService->DeleteByID($params["id"]));
    });

    router('POST', '^/consultations$', function($params) {
        $json = json_decode(file_get_contents('php://input'), true);
        $consultationService = new ConsultationService();
        echo json_encode($consultationService->Create($json));
    });

    router('PATCH', '^/consultations/(?<id>\w+)$', function($params) {
        $json = json_decode(file_get_contents('php://input'), true);
        $consultationService = new ConsultationService();
        echo json_encode($consultationService->Update($params["id"], $json));
    });

    /*
    LABORATORIO: inserção e listagem de exames (exame: nome do paciente, tipo de exame, resultado do exame, data cadastro)
    PACIENTE: listagem de consultas (data da consulta, receita, observacao) e listagem de exames (tipo de exame, resultado do exame, data de realizacao do exame)
    MEDICO: listagem e inserção de consultas (nome do paciente, receita, observacao)
    */

    header("HTTP/1.0 404 Not Found");
    echo json_encode(array("message" => "404"));