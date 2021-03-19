<?php
// Faz a inclusão do arquivo de conexão ao banco de dados
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

//Pega a informação vinda do arquivo funcoes.js/confirmar()
$json = file_get_contents('php://input');
$dados = json_decode($json, true);

//Verifica se o ID esta preenchido e decide entre cadastrar ou atualizar
if($dados['id'] != ''){
    atualizar($dados, $link);
} else{
   cadastrar($dados, $link);
}

function atualizar($dados, $link){
    $dataHoje = date("Y/m/d");  
    $sql = "UPDATE condicao_pagamento SET descricao = '$dados[descricao]', inativo = $dados[inativo], usuario_atualizacao = '$dados[usuario_atualizacao]', dt_atualizacao =  '$dataHoje', parcela_minima = '$dados[parcela_minima]', parcela_maxima = '$dados[parcela_maxima]', condicao = '$dados[condicao]' WHERE id = $dados[id]";
    $query = mysqli_query($link, $sql);

    if($query){
        echo "Registro atualizado com sucesso!";
    } else{
        echo "Erro ao salvar atualizações no registro. Entre em contato com o suporte. \n" . mysqli_error($link);
    }
}

//Função que faz as verificações de código
function cadastrar($dados, $link){
    if($dados['cod'] != ''){
        $cod = $dados['cod'];
        $sql = "SELECT * FROM condicao_pagamento WHERE cod='$cod'";
        $query = mysqli_query($link, $sql);
        $resultado = mysqli_num_rows($query);
        if ($resultado > 0){
            echo "Código informado já cadastrado.";
        } else{
            salvar($link, $dados,$cod);
        }
    }else{
        $sql = "select max(CAST(cod as int)) from condicao_pagamento";
        $query = mysqli_query($link, $sql);
        $resultado = mysqli_fetch_array($query);
        $cod =  $resultado[0]+1;
        salvar($link, $dados, $cod);
    }
}

//Função que faz o insert da informação no banco de dados
function salvar($link, $dados, $cod){
    $dataHoje = date("Y/m/d");  
    
    $sql = "INSERT INTO condicao_pagamento(cod, descricao, dt_criacao, dt_atualizacao, usuario_atualizacao, usuario_criacao, inativo, parcela_minima, parcela_maxima, condicao) VALUES('$cod', '$dados[descricao]', '$dataHoje', '$dataHoje', '$dados[usuario_atualizacao]', '$dados[usuario_criacao]', $dados[inativo], '$dados[parcela_minima]', '$dados[parcela_maxima]', '$dados[condicao]' )";
    $query = mysqli_query($link, $sql);

    if($query){
        echo "Salvo com sucesso!";
    } else{
        echo "Erro ao realizar cadastro, entre em contato com o suporte. \n" . mysqli_error($link);
    }
}
?>