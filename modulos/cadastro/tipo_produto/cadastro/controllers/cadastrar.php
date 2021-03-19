<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $cod = $_POST['cod'];
    $descricao = $_POST['descricao'];
    $usuario = $_POST['usuario'];
    $inativo = $_POST['inativo'];

    $sql = "INSERT INTO tipo_produto(cod, descricao, inativo, usuario_criacao, usuario_atualizacao) VALUES('$cod', '$descricao', '$inativo', '$usuario', '$usuario')";
    $query = mysqli_query($link, $sql);

    //char, varchar, date, time 

    if($query){
        echo 1;
    } else{
        echo mysqli_error($link);
    }
?>