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
    $sql = "UPDATE uf SET nome = '$dados[descricao]', inativo = $dados[inativo], usuario_atualizacao = '$dados[usuario_atualizacao]', dt_atualizacao =  '$dataHoje', sigla = '$dados[sigla]', id_pais = '$dados[pais]' WHERE id = $dados[id]";
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
        $sql = "SELECT * FROM uf WHERE cod='$cod'";
        $query = mysqli_query($link, $sql);
        $resultado = mysqli_num_rows($query);
        if ($resultado > 0){
            echo "Código informado já cadastrado.";
        } else{
            salvar($link, $dados,$cod);
        }
    }else{
        $sql = "select max(CAST(cod as int)) from uf";
        $query = mysqli_query($link, $sql);
        $resultado = mysqli_fetch_array($query);
        $cod =  $resultado[0]+1;
        salvar($link, $dados, $cod);
    }
}

//Função que faz o insert da informação no banco de dados
function salvar($link, $dados, $cod){
    $dataHoje = date("Y/m/d");  
    
    $sql = "INSERT INTO uf(cod, nome, dt_criacao, dt_atualizacao, usuario_atualizacao, usuario_criacao, inativo, sigla, id_pais) VALUES('$cod', '$dados[descricao]', '$dataHoje', '$dataHoje', '$dados[usuario_atualizacao]', '$dados[usuario_criacao]', $dados[inativo], '$dados[sigla]', $dados[pais])";
    $query = mysqli_query($link, $sql);

    if($query){
        echo "Salvo com sucesso!";
    } else{
        echo "Erro ao realizar cadastro, entre em contato com o suporte. \n" . mysqli_error($link);
    }
}
?>