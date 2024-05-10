let registrar = document.getElementById('link_registrar')
let autenticar = document.getElementById('link_autenticar')
let form_a = document.getElementById('autenticar')
let form_r = document.getElementById('registrar')


registrar.addEventListener('click', function (event) {
    event.preventDefault()

    form_a.style.display = 'block'
    form_r.style.display = 'none'

    console.log("teste")
})

autenticar.addEventListener('click', function (event) {
    event.preventDefault()

    form_a.style.display = 'none'
    form_r.style.display = 'block'
})