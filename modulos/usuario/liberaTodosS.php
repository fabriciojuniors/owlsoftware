<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    function liberaTodosS($usuario, $link){
        mysqli_select_db($link, $_SESSION['namespace']);
        $sql = "SELECT COUNT(id) FROM telas";
        $query = mysqli_query($link, $sql);
        $linha = mysqli_fetch_array($query);
        $telas = $linha[0];
        $sql = "SELECT * FROM permissoes_acesso WHERE usuario = $usuario";
        $query = mysqli_query($link, $sql);
        if(!mysqli_num_rows($query)>0){
            for ($i=0; $i <= $telas ; $i++) { 
                $sql = "INSERT INTO permissoes_acesso(usuario, tela) VALUES($usuario, $i)" ;
                $query = mysqli_query($link, $sql);
            }
        }

    }

