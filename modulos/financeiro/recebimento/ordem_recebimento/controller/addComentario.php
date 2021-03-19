<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "INSERT INTO comentario_or(comentario, usuario, ordem_recebimento)
            VALUES ('$dados[comentario]', '$_SESSION[usuario]', (SELECT id FROM ordem_recebimento WHERE numero = $dados[nor]))";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    if(mysqli_affected_rows($link)>0){
        echo "Comentário adicionado com sucesso.";
    }else{
        echo "Erro ao adicionar comentário. \n".mysqli_error($link);
    }