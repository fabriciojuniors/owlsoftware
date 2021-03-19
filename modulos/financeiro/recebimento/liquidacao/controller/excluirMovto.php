<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT valor_movimentacao, parcela_or FROM liquidacao_or WHERE id = $dados[id]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query) > 0){
        $resultado = mysqli_fetch_array($query);
        $valor = $resultado[0];
        $parcela = $resultado[1];
        
        $sql = "SELECT valor_movimentacao FROM liquidacao_or WHERE id= $dados[id]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $linha = mysqli_fetch_array($query);
        $valorMovimentacao = $linha[0];
        $sql = "DELETE FROM liquidacao_or WHERE id= $dados[id]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));

        if(mysqli_affected_rows($link) > 0){
            $sql = "SELECT valor, valor_saldo, numero FROM parcela_or WHERE id = $parcela";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            
            if(mysqli_num_rows($query) > 0){
                $resultado = mysqli_fetch_array($query);
                $valorParcela = $resultado[0];
                $saldoParcela = $resultado[1];
                $numParcela = $resultado[2];
                $saldoAjustado = $saldoParcela + $valor;
                ($saldoAjustado == $valorParcela) ? $status = 1 : $status = 3;

                $sql = "UPDATE parcela_or SET valor_saldo = $saldoAjustado, status = $status WHERE id = $parcela";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                if(mysqli_affected_rows($link) > 0){
                    $sql = "SELECT ordem_recebimento FROM parcela_or WHERE id = $parcela";
                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                    if(mysqli_num_rows($query) > 0){
                        $resultado = mysqli_fetch_array($query);
                        $or = $resultado[0];
                        $sql = "SELECT SUM(valor_movimentacao) 
                                FROM liquidacao_or INNER JOIN ordem_recebimento 
                                                   INNER JOIN parcela_or
                                WHERE liquidacao_or.parcela_or = parcela_or.id AND parcela_or.ordem_recebimento = ordem_recebimento.id AND ordem_recebimento.id = $or";
                        $query = mysqli_query($link, $sql);

                        if(mysqli_num_rows($query) > 0){
                            $resultado = mysqli_fetch_array($query);
                            $valorMovimentado = $resultado[0];

                            $sql = "SELECT valor_total FROM ordem_recebimento WHERE id = $or";
                            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                            if(mysqli_num_rows($query)> 0){
                                $resultado = mysqli_fetch_array($query);
                                $valorOR = $resultado[0]; 
                                $saldoAtualOR = $valorOR - $valorMovimentado;
                                ($saldoAtualOR == $valorOR)? $status = 1 : $status = 3;

                                $sql = "UPDATE ordem_recebimento SET valor_saldo = $saldoAtualOR, status = $status WHERE id = $or";
                                $query = mysqli_query($link, $sql) or die(mysqli_error($link));

                                if(mysqli_affected_rows($link) > 0){
                                    $sql = "INSERT INTO comentario_or(comentario, usuario, ordem_recebimento) VALUES('Movimentação no valor de R$$valorMovimentacao referente a parcela $numParcela foi excluída. (Comentário automático)', '$_SESSION[usuario]', $or)";
                                    //echo $sql;
                                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                                    echo "Movimentação excluída com sucesso.";
                                }else{
                                    echo "Erro ao atualizar saldo da OR. ". mysqli_error($link);
                                }
                            }else{
                                echo "Não foi possível obter o valor da OR. " . mysqli_error($link);
                            }
                        }else{
                            echo "Não foi possível obter o valor de movimentação da OR." . mysqli_error($link);
                        }
                    }else{
                        echo "Não foi possível selecionar a ordem de recebimento. " . mysqli_error($link);
                    }
                }else{
                    echo "Não foi possível atualizar o saldo da parcela. " . mysqli_error($link);
                }
            }else{
                echo "Não foi possível obter o saldo da parcela. " . mysqli_error($link);
            }
        }else{
            echo "Não foi possível excluir movimentação. " . mysqli_error($link);
        }
    }else{
        echo "Não foi possível obter o valor da movimentação.". mysqli_error($link);
    }
?>    