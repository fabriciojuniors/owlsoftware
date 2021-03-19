<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    
    $sql = "SELECT COUNT(id) FROM telas";
    $query = mysqli_query($link, $sql);
    $linha = mysqli_fetch_array($query);
    $telas = $linha[0];
    for ($i=0; $i <= $telas ; $i++) { 
        $sql = "INSERT INTO permissoes_acesso(usuario, tela) VALUES(1, $i)" ;
        $query = mysqli_query($link, $sql);
    }