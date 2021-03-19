<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
    <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
    <script src="/owlsoftware/modulos/vendas/cancelar_venda/js/cancelarNF.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <title>Cancelar Venda</title>
</head>
<style>
    input[type="date"]::-webkit-inner-spin-button {
        display: none;
        -webkit-appearance: none;
    }
</style>

<body>
    <div id="conteudo" style="display: block;">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Cancelar Venda</h1>
        </div>

        <div class="col-md-6">
            <label for="">N° NF</label>
            <input type="text" class="form-control campos" style="width: 80px;" id="nNf">
            <label for="">Motivo:</label>
            <textarea name="motivo" id="motivo" cols="10" rows="5" style="width: 400px;" class="form-control"></textarea>
            <label for="">Senha: </label>
            <input type="password" name="" id="senha" class="form-control campos"> <br>
            <button style="float: left;" class="btn btn-success btn-square" onclick="cancelarNF()">Cancelar</button>
        </div>

    </div>
</body>

</html>