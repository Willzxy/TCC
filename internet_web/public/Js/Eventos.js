let TemplateExibirPerfil = `
        <div class="outbar"></div>
        <img src="../img/PerfilVazia.jpg" class="fotoperfil">

        <h1> <a class="nomeperfil" href="/usuarios"> <?php $this->show('nome') ?> </a> </h1>
        <p>Faça uma breve descrição sobre você</p>

        <button id="BotaoEditarPerfil">Editar perfil</button>
    `

let botaoEditarPerfil = document.getElementById('BotaoEditarPerfil')
let BotaoPesquisaGrupo = document.getElementById('pesquisaGrupo')


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

botaoEditarPerfil.addEventListener('click', (event) => {
    event.preventDefault()

    let nomeantigo = document.getElementById('nomeantigo').innerText
    let descricaoantiga = document.getElementById('descricaoantiga').innerText


    document.getElementById('perfil_info').innerHTML = 
    `
        <div class="outbar"></div>
        <img src="../img/PerfilVazia.jpg" class="fotoperfil">

        <form action="/atualizarperfil" enctype="multipart/form-data" method="post">
            <input id="image" name="imagem" accept="image/*" type="file">
            <input type="text" name="nome" value="${nomeantigo}" class="nomeperfil">
            <input type="text" name="descricao" value="${descricaoantiga}"  class="descricao">

            <input type="submit" value="Atualizar Perfil">
        </form>
    `
})

BotaoPesquisaGrupo.addEventListener('click', (event) => {
    event.preventDefault()
})

function pesquisarUsuarios(){
    let campoPesquisa = document.getElementById('pesquisar_campo').value
    window.location.replace(`/pesquisar?tip=usuarios&search=${campoPesquisa}`);
}

function pesquisarGrupos(){
    let campoPesquisa = document.getElementById('pesquisar_campo').value
    window.location.replace(`/pesquisar?tip=grupos&search=${campoPesquisa}`);
}