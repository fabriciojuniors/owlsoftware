function editar(id, nome, email, login, senha, data_nascimento){
    document.getElementById("idUsuario").value = id;
    document.getElementById("nome").value = nome;
    document.getElementById("email").value = email;
    document.getElementById("login").value = login;
    document.getElementById("login").readOnly = true;
    document.getElementById("senha").value = senha;
    document.getElementById("datanascimento").value = data_nascimento;
}