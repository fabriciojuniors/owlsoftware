<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
        
        //Pega o maior numero de OR para gerar a próxima
        $sqlNumOR = "SELECT MAX(numero) FROM ordem_pagamento";
        $queryNumOR = mysqli_query($link, $sqlNumOR) or die (mysqli_error($link));
        $linha = mysqli_fetch_array($queryNumOR);
        $numeroOR = $linha[0] + 1;

        //Faz o insert da OR
        $sqlOR = "INSERT INTO ordem_pagamento(numero, cliente, emissao, valor_total, valor_saldo, condicao, forma_pagamento,  observacao, usuario_cadastro, status) VALUES($numeroOR, $dados[cliente], '$dados[emissao]', $dados[valor],$dados[valor] , $dados[condicao], $dados[formapag], '$dados[obs]', '', 1)";
        $queryOR = mysqli_query($link, $sqlOR) or die(mysqli_error($link));
        if($sqlNumOR){
            $sqlIDOR = "SELECT MAX(id) FROM ordem_pagamento";
            $queryIDOR = mysqli_query($link,$sqlIDOR);
            $linha = mysqli_fetch_array($queryIDOR);
            $idOR = $linha[0];

            //Busca a condicao de pagamento selecionada    
            $sqlCond = "SELECT condicao FROM condicao_pagamento WHERE id = $dados[condicao]";
            $queryCond = mysqli_query($link, $sqlCond) or die(mysqli_error($link));
            $linha = mysqli_fetch_array($queryCond);
            $condicao = $linha[0];
            $dias = explode("/", $condicao);
            $numParcelas = count($dias);

            //Define o valor de cada parcela
            $valorParcelas = $dados['valor'] / $numParcelas;

            //Calcula os dias de vencimento para cada parcela e armazena no array Data
            for ($i=0; $i < $numParcelas ; $i++) { 
                @$data[$i] = date('Y-m-d', strtotime("+".$dias[$i]."days", strtotime($dados['emissao'])));
            }   

            $j = 1;  
            foreach ($data as $d) {
                    $sqlParcela = "INSERT INTO parcela_op(ordem_pagamento, numero, emissao, vencimento, valor, valor_saldo, status) VALUES($idOR, $j, '$dados[emissao]', '$d', $valorParcelas, $valorParcelas, 1)";
                    $quertParcela = mysqli_query($link, $sqlParcela) or die(mysqli_error($link));
                    if($quertParcela){

                    }else{
                        echo "Não foi possível salvar a parcela. " . mysqli_error($link);
                    }
                    $j++;
            }
            echo "Salvo com sucesso./".$idOR;
        }else{
            echo "Erro ao salvar ordem de pagamento. \n" . mysqli_error($link);
        }
    //Fim do bloco da Ordem de Recebimento
?>    