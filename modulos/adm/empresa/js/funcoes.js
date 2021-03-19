$(document).ready(function($){
    $("#cnpj").mask('00.000.000/0000-00', {reverse: true});


})

const editarEmp = (id,cnpj, razao, fantasia, ie) =>{
    document.getElementById("id").value = id;
    document.getElementById("cnpj").value = cnpj;
    document.getElementById("cnpj").readOnly = true;
    document.getElementById("razao").value = razao;
    document.getElementById("fantasia").value = fantasia;
    document.getElementById("ie").value = ie;
}