<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT valor FROM parametros_faturamento WHERE id = 1";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $senhaArray = mysqli_fetch_array($query);
    $senha = $senhaArray[0];
    if($senha == $dados['senha']){
        $sql = "SELECT * FROM nota_fiscal WHERE numero = $dados[nota]";
        $query = mysqli_query($link, $sql) or die(mysqli_errno($link));
    
        if(mysqli_num_rows($query) >0 ){
            $nota = mysqli_fetch_array($query);
            if($nota['status'] == 4 || $nota['status'] == 3){
                echo "Não foi possível cancelar nota fiscal, a mesma já está cancelada ou foi devolvida.";
            }else{
                $sql = "DELETE FROM movimento_estoque WHERE num_doc = $dados[nota] AND tp_movto_estoque = (SELECT tp_movto_estoque FROM tp_venda WHERE id = $nota[tp_venda])";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                if($query){
                    $sql = "UPDATE nota_fiscal SET status = 4 WHERE numero = $dados[nota]";
                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                    if($query){
                        $sql = "INSERT INTO nota_fiscal_cancelada(nota_fiscal, motivo, usuario) VALUES((SELECT id FROM nota_fiscal WHERE numero = $dados[nota]), '$dados[motivo]', $_SESSION[id])";
                        $query = mysqli_query($link, $sql)or die(mysqli_error($link));
                        echo "Nota cancelada com sucesso.";
                    }else{
                        echo "Não foi possível cancelar nota fiscal.";
                    }
                }else{
                    echo "Não possível remover movimento de estoque. Nota não foi cancelada.";
                }
            }
        }else{
            echo "Nota não encontrada";
        }
    }else{
        echo "Senha para cancelamento inválida.";
    }
