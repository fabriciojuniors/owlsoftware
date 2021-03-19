
<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/modulos/vendas/nf_pedido/consulta/controller/imprimirNFPDF.php";
    require $_SERVER['DOCUMENT_ROOT']. '/owlsoftware/common/PHPMailer-master\PHPMailer-master\src\Exception.php';
    require $_SERVER['DOCUMENT_ROOT']. '/owlsoftware/common/PHPMailer-master\PHPMailer-master\src\PHPMailer.php';
    require $_SERVER['DOCUMENT_ROOT']. '/owlsoftware/common/PHPMailer-master\PHPMailer-master\src\SMTP.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
function enviarEmail($dados){

    //$json = file_get_contents('php://input');
    //$dados = json_decode($json, true);
    gerarPDF($dados['nota']);
    $caminho = $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/modulos/vendas/nf_pedido/espelhos/nota'.$dados['nota'].'.pdf';

    $email = explode(";", $dados['email']);

    $erro = "false";
    foreach ($email as $envio) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = 'email@gmail.com';
    $mail->Password = 'senha';
    $mail->setFrom('fabriciojuniorsc@gmail.com');
    $mail->addAddress($envio);
    $mail->Subject = 'Recebimento nota fiscal.';
    $mail->Body = $dados['msg'];
    $mail->addAttachment($caminho, 'nota.pdf');
    //send the message, check for errors
    if($mail->send()){

    } else{
        echo $mail->ErrorInfo;
    }
    if($erro == "false"){
        echo "E-mail enviado com sucesso. \n";
    }
    @unlink($caminho);
};

}
?>
