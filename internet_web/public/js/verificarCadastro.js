let registrar = document.getElementById('link_registrar')
let autenticar = document.getElementById('link_autenticar')
let form_a = document.getElementById('autenticar')
let form_r = document.getElementById('registrar')

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

let loginerro = urlParams.get('login')

function ExibirAutenticar(){
    form_a.style.display = 'none'
    form_r.style.display = 'block'
}

function ExibirCadastro(){
    form_a.style.display = 'block'
    form_r.style.display = 'none'
}

registrar.addEventListener('click', function (event) {
    event.preventDefault()
    ExibirCadastro()
})

autenticar.addEventListener('click', function (event) {
    event.preventDefault()
    ExibirAutenticar()
})

if(loginerro == 3){
    form_a.style.display = 'block'
    form_r.style.display = 'none'
}