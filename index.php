<?php

    require_once("util/XMLManager.php");

    header('Content-Type: application/json;charset=utf-8');

    $xmlManager = new XmlManager("medicos.xml", "medico");
    //$xmlManager->ShowRaw();

    //$xmlManager->AddData(array("id" => 1, "nome" => "Teste", "idade" => 30, "crm" => "3000-01"));

    //$xmlManager->DeleteDataByID(3);    

    //$xmlManager->UpdateData(array("id" => 3, "nome" => "Teste", "idade" => 30, "crm" => "3000-01"));

    //$xmlManager->ShowRaw();

    //$xmlManager->ShowJson();