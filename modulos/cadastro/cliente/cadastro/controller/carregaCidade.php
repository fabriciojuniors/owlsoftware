<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $uf = $dados['uf'];
    $sql = "SELECT cidade.nome as cidade, cidade.* FROM cidade INNER JOIN uf where cidade.codigo_uf = uf.id AND uf.id = '$uf'";
    //echo $sql;
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if($query){
        while($row = mysqli_fetch_array($query)){
            $marcas[] = array(
                "id" => $row['id'],
                "cod" => $row['codigo_ibge'],
                "descricao" => $row['cidade'],
            );
        }
        $marcasJson = json_encode($marcas);
        echo $marcasJson;
    }else{
        echo "Erro ao carregar informação.";
    }
?>