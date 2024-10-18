let registrar = document.getElementById('link_registrar')
let autenticar = document.getElementById('link_autenticar')
let redefinir_btn = document.getElementById('botaoredefinir')
let esquecisenha = document.getElementById('esquecisenha')

let form_a = document.getElementById('autenticar')
let form_r = document.getElementById('registrar')
let form_redefinir = document.getElementById('redefinir')

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

let loginerro = urlParams.get('login')

function ExibirAutenticar(){
    form_a.style.display = 'none'
    form_r.style.display = 'block'
    form_redefinir.style.display = 'none'
}

function ExibirCadastro(){
    form_a.style.display = 'block'
    form_r.style.display = 'none'
    form_redefinir.style.display = 'none'
}

function ExibirRedefinirSenha(){
    form_a.style.display = 'none'
    form_r.style.display = 'none'
    form_redefinir.style.display = 'block'
}

registrar.addEventListener('click', function (event) {
    event.preventDefault()
    ExibirCadastro()
})

autenticar.addEventListener('click', function (event) {
    event.preventDefault()
    ExibirAutenticar()
})

esquecisenha.addEventListener('click', function (event){
    event.preventDefault()
    ExibirRedefinirSenha()
})

if(loginerro == 3){
    form_a.style.display = 'block'
    form_r.style.display = 'none'
}

document.getElementById('form_registro').addEventListener('submit', function(event) {
    const senha = document.getElementById("senha");
    const confirmarSenha = document.getElementById("confirmar_senha");

    if (senha.value !== confirmarSenha.value) {
        event.preventDefault();

        senha.style.border = "2px solid red";
        confirmarSenha.style.border = "2px solid red";
        alert("As senhas não coincidem.");

    } else {
        senha.style.border = "";
        confirmarSenha.style.border = "";
    }
});