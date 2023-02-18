export function navbar() {
    const navbar = document.getElementById("navbar");

    navbar.innerHTML = "<header class='py-3 justify-content-center clearfix' style='background-color: #0d6efd'>" 
        + "<a id='nomeLanchonete' href='/sgv-lanchonete/paginas/index.php' class='text-white text-decoration-none'>Lanchonete</a>"
        + "<form id='formLogout' method='POST' action='/sgv-lanchonete/paginas/Login/logoutCamadaNegocios.php'>"
        + "<input name='sairSubmit' class='inputSair btn btn-danger' type='submit' value='Sair da conta'>"
        + "</form>"
        + "</header>"
    return navbar;
}