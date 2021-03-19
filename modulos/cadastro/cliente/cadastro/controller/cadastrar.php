<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if($dados['id'] == ''){
        cadastrar($link, $dados);
    } else{
        atualizar($link, $dados);
    }

    function cadastrar($link, $dados){
        $cpfcnpj = $dados['cpfcnpj'];
        $sql = "SELECT * FROM clientes WHERE CPF_CNPJ = '$cpfcnpj'";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $result = mysqli_num_rows($query);
        if($result > 0){
            echo "CPF/CNPJ informado já cadastrado na base de dados.";
        }else{
            salvar($link, $dados);
        }
    }

    function salvar($link, $dados){
        $data = date("Y/m/d"); 
        $sql = "INSERT INTO clientes(CPF_CNPJ, nome, razao_social, telefone, email, data_nascimento, sexo,CEP, pais, uf, cidade, bairro, rua,  complemento, inativo, dt_criacao, dt_atualizacao, usuario_criacao, usuario_atualizacao, cliente, fornecedor, cod_webmais, exporta_webmais) VALUES ('$dados[cpfcnpj]', '$dados[nome]', '$dados[razao]', '$dados[telefone]', '$dados[email]', '$dados[datanascimento]', '$dados[sexo]', '$dados[cep]', $dados[pais], $dados[uf], $dados[cidade], '$dados[bairro]', '$dados[rua]',  '$dados[complemento]', $dados[inativo],'$data', '$data','$dados[usuario]', '$dados[usuario]', $dados[cliente], $dados[fornecedor]), $dados[cod_webmais], 1";

        $query = mysqli_query($link, $sql) or die(mysqli_error($link));

        if($query){
            echo "Cliente cadastrado com sucesso.";
        } else{
            echo "Erro ao cadastrar cliente." . mysqli_error($link);
        }
    }

    function atualizar($link, $dados){
        $data = date("Y/m/d"); 
        $sql = "UPDATE clientes SET nome = '$dados[nome]', razao_social = '$dados[razao]', telefone = '$dados[telefone]', email = '$dados[email]', data_nascimento = '$dados[datanascimento]', sexo = '$dados[sexo]', CEP = '$dados[cep]', pais = $dados[pais], uf = $dados[uf], cidade = $dados[cidade], bairro = '$dados[bairro]', rua = '$dados[rua]', complemento = '$dados[complemento]', inativo = $dados[inativo], dt_atualizacao = '$data', usuario_atualizacao = '$dados[usuario]', cliente = $dados[cliente], fornecedor = $dados[fornecedor], exporta_webmais = 1, cod_webmais=$dados[cod_webmais] WHERE id = $dados[id]";

        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        if($query){
            echo "Registro atualizado com sucesso.";
        }else{
            echo "Erro ao salvar alteração no cadastro";
        }

    }
    
?>