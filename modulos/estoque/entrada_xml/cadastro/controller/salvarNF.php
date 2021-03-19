<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if($dados['idNota'] == ''){
        salvarNF($link, $dados);
    }

    function salvarNF($link, $dados){
        $sql = "SELECT * FROM nota_fiscal_entrada WHERE numero = $dados[numero] AND fornecedor = $dados[fornecedor]";
        $query = mysqli_query($link, $sql);
        
        if($query){
            if(mysqli_num_rows($query)>0){
                echo "Nota com mesmo número e fornecedor já lançada. Por gentileza verificar";
                return;
            }
        }else{echo "Não foi possível verificar o lançamento da nota fiscal. \n" . mysqli_error($link); return;}

        $sql = "INSERT INTO nota_fiscal_entrada(numero, chave, arquivo_xml, fornecedor, tp_entrada, emissao, entrada, usuario, status)
                VALUES($dados[numero], '$dados[chave]', '$dados[nomeArquivo]', $dados[fornecedor], $dados[tp_entrada], '$dados[emissao]', '$dados[entrada]', $_SESSION[id], 1)";
        $query = mysqli_query($link, $sql);

        if($query){
            echo "1";
        }else{echo "Erro ao salvar nota fiscal. \n".mysqli_error($link); return;};
    }
?>