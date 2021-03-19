<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
$json = file_get_contents('php://input');
$dados = json_decode($json, true);
$pais = $dados['pais'];
    if($pais == "#"){
        echo "Nenhum estado cadastrado para o país selecionado.";
    }else{
        $sql = "SELECT * FROM uf WHERE id_pais = $pais";
        $sql = mysqli_query($link, $sql);
    
        while($result = mysqli_fetch_array($sql)){
            $ufs[] = array(
                "id" => $result['id'],
                "uf" => $result['nome']
            );
        };
        $ufsJson = json_encode($ufs);
        echo $ufsJson;
    }


?>