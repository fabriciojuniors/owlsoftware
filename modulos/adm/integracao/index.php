<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

    <title>Integração ERP</title>
</head>

<body>
    <div id="conteudo" style="display: block;">

        <h1 class="h4 mb-0 text-gray-800">Integração ERP</h1> <br>

        <form class="" action="/owlsoftware/modulos/adm/integracao/gerarIntegracao.php" onsubmit="target_popup(this)" method="post">
            <input type="submit" id="gerar" tabindex="4" onclick="" class="btn btn-square btn-success" value="Gerar Transação">
        </form>
    </div>
</body>
<script>
    function target_popup(form) {
        window.open('', 'formpopup', 'width=10,height=10,resizeable,scrollbars');
        form.target = 'formpopup';
    }
</script>

</html>