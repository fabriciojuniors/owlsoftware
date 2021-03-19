<?php
        include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
        include 'enviar.php';
        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);

        enviarEmail($dados);
        
?>