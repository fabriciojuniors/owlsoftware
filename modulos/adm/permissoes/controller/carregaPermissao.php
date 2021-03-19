<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT telas.nome, permissoes_acesso.liberado
            FROM permissoes_acesso INNER JOIN telas
            WHERE permissoes_acesso.tela = telas.id
                  AND usuario = $dados[usuario]
                  AND telas.modulos = $dados[modulos]";
    $query = mysqli_query($link, $sql);

    while($row = mysqli_fetch_array($query)){
        $result[] = $row;
    }
    @$resultJ = json_encode($result);
    echo $resultJ;