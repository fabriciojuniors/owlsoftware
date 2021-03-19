<?php
// Faz a inclusão do arquivo de conexão ao banco de dados
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

//Pega a informação vinda do arquivo funcoes.js/confirmar()
$json = file_get_contents('php://input');
$dados = json_decode($json, true);
$tabela = "cidade";
//Verifica se o ID esta preenchido e decide entre cadastrar ou atualizar
if($dados['id'] != ''){
    atualizar($dados, $link, $tabela);
} else{
   cadastrar($dados, $link, $tabela);
}

function atualizar($dados, $link, $tabela){
    $dataHoje = date("Y/m/d");  
    $sql = "UPDATE $tabela SET nome = '$dados[descricao]' , codigo_uf = '$dados[uf]' WHERE id = $dados[id]";
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
    
    $sql = "INSERT INTO $tabela(cod, nome, id_uf) VALUES('$cod', '$dados[descricao]',  $dados[uf])";
    $query = mysqli_query($link, $sql);

    if($query){
        echo "Salvo com sucesso!";
    } else{
        echo "Erro ao realizar cadastro, entre em contato com o suporte. \n" . mysqli_error($link);
    }
}
?>