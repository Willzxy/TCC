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