let TemplateExibirPerfil = `
        <div class="outbar"></div>
        <img src="../img/PerfilVazia.jpg" class="fotoperfil">

        <h1> <a class="nomeperfil" href="/usuarios"> <?php $this->show('nome') ?> </a> </h1>
        <p>Faça uma breve descrição sobre você</p>

        <button id="BotaoEditarPerfil">Editar perfil</button>
    `;


document.addEventListener('DOMContentLoaded', () => {
    let campo_pesquisar_menu = document.getElementById('pesquisar_campo');
    let campo_pesquisar_lista = document.getElementById('pesquisar_lista');

    campo_pesquisar_menu.addEventListener('focus', () => {
        campo_pesquisar_lista.classList.add('visible');
    });

    campo_pesquisar_menu.addEventListener('blur', () => {
        setTimeout(() => {
            campo_pesquisar_lista.classList.remove('visible');
        }, 100); 
    });
});

let botaoEditarPerfil = document.getElementById('BotaoEditarPerfil')

botaoEditarPerfil.addEventListener('click', (event) => {
    event.preventDefault()

    let nomeantigo = document.getElementById('nomeantigo').innerText
    let descricaoantiga = document.getElementById('descricaoantiga').innerText


    document.getElementById('perfil_info').innerHTML = 
    `
        <div class="outbar"></div>
        <img src="../img/PerfilVazia.jpg" class="fotoperfil">

        <form action="/atualizarperfil" method="post">
            <input type="text" name="nome" value="${nomeantigo}" class="nomeperfil">
            <input type="text" name="descricao" value="${descricaoantiga}"  class="descricao">

            <input type="submit" value="Atualizar Perfil">
        </form>
    `
})