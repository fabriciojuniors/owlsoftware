<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

 require_once $_SERVER['DOCUMENT_ROOT']. '/owlsoftware/vendor/autoload.php';

 $mpdf = new \Mpdf\Mpdf();


//Informações para sair no relatório
$resposta = "<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>
  <title>Impressão Ajuste de estoque</title>
</head>
<style>
</style>
<body>
  <!-- Conteúdo -->
   <h1> Teste </h1>
   <table border = 1>
      <thead>
      <tr>
         <td>Produto</td>
         <td>Tamanho</td>
      </tr>
      </thead>
      <tbody>
  <!-- Fim Conteúdo -->

</body>
</html>";
$sql = "select produto.descricao, tamanho.descricao from item_ajuste inner join produto inner join tamanho where produto.id = item_ajuste.produto and tamanho.id = item_ajuste.tamanho and item_ajuste.id_ajuste = 89";
$query = mysqli_query($link, $sql) or die(mysqli_error($link));
while($linha = mysqli_fetch_array($query)){
    $resposta .= "<tr><td>" . $linha[0] . "</td>";
    $resposta .= "<td>".$linha[1]."</td></tr>";
};
$resposta.="</tbody></table>";
echo $resposta;
// //Fim das informações
 $mpdf->WriteHTML($resposta);
 $mpdf->Output();
?>