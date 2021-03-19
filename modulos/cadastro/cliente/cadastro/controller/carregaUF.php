<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $pais = $dados['pais'];
    $sql = "SELECT * FROM uf WHERE id_pais = $pais ";
    $query = mysqli_query($link, $sql);

    if($query){
        while($row = mysqli_fetch_array($query)){
            $marcas[] = array(
                "id" => $row['id'],
                "cod" => $row['cod'],
                "sigla" => $row['sigla'],
                "descricao" => $row['nome'],
                "inativo" => $row['inativo']
            );
        }
        $marcasJson = json_encode($marcas);
        echo $marcasJson;
    }else{
        echo "Erro ao carregar informação.";
    }
?>