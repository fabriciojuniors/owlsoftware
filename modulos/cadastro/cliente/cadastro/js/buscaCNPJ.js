$(window).ready(function(){
    $("#cpfcnpj").keydown(function(){
        cnpj = $("#cpfcnpj").unmask();
        console.log(cnpj);
    })
})
// function buscaCNPJ(CNPJ){
//     CNPJ = CNPJ.replace(".","");
//     CNPJ = CNPJ.replace(".","");
//     CNPJ = CNPJ.replace("/","");
//     CNPJ = CNPJ.replace("-","");
//     if((CNPJ.length + 1) == 14){
//     fetch("https://consulta-cnpj-gratis.p.rapidapi.com/companies/"+CNPJ, {
// 	"method": "GET",
// 	"headers": {
// 		"x-rapidapi-host": "consulta-cnpj-gratis.p.rapidapi.com",
// 		"x-rapidapi-key": "20655f2e91mshffdc9f966f774c4p185fe3jsn09df78df96d8"
// 	}
//     })
//     .then(response => {
//         console.log(response);
//     })
//     .catch(err => {
//         console.log(err);
//     });
//     }
// }