<?php

    require_once("util/XMLManager.php");

    $xmlManager = new XmlManager("medicos.xml");

    //$xmlManager->AddData("medico", array("nome" => "Teste", "idade" => 30, "crm" => "3000-01"));

    $xmlManager->ShowRaw();