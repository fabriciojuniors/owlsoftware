<?php
// Faz a inclusão do arquivo de conexão ao banco de dados
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

//Pega a informação vinda do arquivo funcoes.js/confirmar()
$json = file_get_contents('php://input');
$dados = json_decode($json, true);
$tabela = "tp_venda";
//Verifica se o ID esta preenchido e decide entre cadastrar ou atualizar
if($dados['id'] != ''){
    atualizar($dados, $link, $tabela);
} else{
   cadastrar($dados, $link, $tabela);
}

function atualizar($dados, $link, $tabela){
    $dataHoje = date("Y/m/d");  
    $sql = "UPDATE $tabela SET devolucao = '$dados[devolucao]', descricao = '$dados[descricao]', inativo = $dados[inativo], usuario_atualizacao = '$dados[usuario_atualizacao]', dt_atualizacao =  '$dataHoje', tp_movto_estoque = '$dados[tipomovto]', origem_movto_estoque = '$dados[origem]', gera_financeiro = '$dados[financeiro]' WHERE id = $dados[id]";
    $query = mysqli_query($link, $sql);

    if($query){
        echo "Registro atualizado com sucesso!";
    } else{
        echo "Erro ao salvar atualizações no registro. Entre em contato com o suporte. \n" . mysqli_error($link);
    }
}

//Função que faz as verificações de código
function cadastrar($dados, $link, $tabela){
    if($dados['cod'] != ''){
        $cod = $dados['cod'];
        $sql = "SELECT * FROM $tabela WHERE cod='$cod'";
        $query = mysqli_query($link, $sql);
        $resultado = mysqli_num_rows($query);
        if ($resultado > 0){
            echo "Código informado já cadastrado.";
        } else{
            salvar($link, $dados,$cod, $tabela);
        }
    }else{
        $sql = "select max(CAST(cod as int)) from $tabela";
        $query = mysqli_query($link, $sql);
        $resultado = mysqli_fetch_array($query);
        $cod =  $resultado[0]+1;
        salvar($link, $dados, $cod, $tabela);
    }
}

//Função que faz o insert da informação no banco de dados
function salvar($link, $dados, $cod, $tabela){
    $dataHoje = date("Y/m/d");  
    
    $sql = "INSERT INTO $tabela(cod, descricao, dt_criacao, dt_atualizacao, usuario_atualizacao, usuario_criacao, inativo, gera_financeiro, origem_movto_estoque, tp_movto_estoque, devolucao) VALUES('$cod', '$dados[descricao]', '$dataHoje', '$dataHoje', '$dados[usuario_atualizacao]', '$dados[usuario_criacao]', $dados[inativo], '$dados[financeiro]', $dados[origem], $dados[tipomovto], $dados[devolucao])";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if($query){
        echo "Salvo com sucesso!";
    } else{
        echo "Erro ao realizar cadastro, entre em contato com o suporte. \n" . mysqli_error($link);
    }
}
?>