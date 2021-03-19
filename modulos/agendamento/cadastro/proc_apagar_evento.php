<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $query_event = "DELETE FROM agendamentos WHERE id=$id";

    
    if(mysqli_query($link, $query_event)){
        $_SESSION['msg'] = '<div class="alert alert-success" role="alert">O evento foi apagado com sucesso!</div>';
        header("Location: /owlsoftware/modulos/index.php?pag=agendamento");
    }else{
        $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: O evento não foi apagado com sucesso!</div>';
        header("Location: /owlsoftware/modulos/index.php?pag=agendamento");
    }
} else {
    $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: O evento não foi apagado com sucesso!</div>';
    header("Location: /owlsoftware/modulos/index.php?pag=agendamento");
}
