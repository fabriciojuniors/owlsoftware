<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $descricao = $_POST['descricao'];
    $inativo = $_POST['inativo'];
    $data = $_POST['data'];
    $usuario = $_POST['usuario'];
    $id = $_POST['id'];

    $sql = "UPDATE tipo_produto SET descricao = '$descricao', inativo = $inativo, dt_atualizacao = '$data', usuario_atualizacao = '$usuario' WHERE id = $id";
    $query = mysqli_query($link, $sql) or die (mysqli_error($link));

    $linha = mysqli_affected_rows($link);

    echo $linha;
?>