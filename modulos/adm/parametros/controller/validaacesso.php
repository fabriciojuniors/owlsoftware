<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/selecaoBD.php";
    selectBD($link);
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT telas.nome as tela, permissoes_acesso.liberado as liberado FROM telas inner join permissoes_acesso where telas.id = permissoes_acesso.tela AND permissoes_acesso.usuario = $_SESSION[id]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($row =mysqli_fetch_array($query)){
        $result[] = $row;
    }
    $resultJ = json_encode($result);
    echo $resultJ;