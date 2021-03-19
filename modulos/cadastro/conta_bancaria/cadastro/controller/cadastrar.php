<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

//Pega a informação vinda do arquivo funcoes.js/confirmar()
$json = file_get_contents('php://input');
$dados = json_decode($json, true);

if($dados['id'] == ''){
    cadastrar($link, $dados);
}else{
    atualizar($link, $dados);
}

function cadastrar($link, $dados){
    if($dados['codigo'] == ''){
        $sql = "SELECT MAX(cod) FROM conta_bancaria";
        $query = mysqli_query($link, $sql);
        $result = mysqli_fetch_array($query);
        $cod = $result[0] + 1;
        salvar($dados, $cod, $link);
    }
}

function atualizar($link, $dados){
    $data = date("Y/m/d"); 
    $sql = "UPDATE conta_bancaria SET agencia = '$dados[agencia]', dv_agencia = '$dados[dvagencia]', conta = '$dados[conta]', dv_conta = '$dados[dvconta]', inativo = $dados[inativo], dt_atualizacao = '$data', usuario_atualizacao = '$dados[usuario]' WHERE id = $dados[id]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if($query){
        echo "Registro atualizado com sucesso.";
    }
    else{
        echo "Erro ao salvar atualização.";
    }
}

function salvar($dados, $cod, $link){
    $data = date("Y/m/d"); 
    $sql = "INSERT INTO conta_bancaria(cod, titular, banco, agencia, dv_agencia, conta, dv_conta, inativo, dt_criacao, dt_atualizacao, usuario_atualizacao, usuario_criacao) VALUES ($cod, '$dados[titular]', $dados[portador], '$dados[agencia]', '$dados[dvagencia]', '$dados[conta]', '$dados[dvconta]', $dados[inativo], '$data', '$data', '$dados[usuario]', '$dados[usuario]')";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if($query){
        echo "Cadastro realizado com sucesso.";
    }else{
        echo "Erro ao realizar cadastro.";
    }
}
?>