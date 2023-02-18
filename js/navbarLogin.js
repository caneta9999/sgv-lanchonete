export function navbarLogin() {
    const navbar = document.getElementById("navbar");

    navbar.innerHTML = "<header class='py-3 justify-content-center clearfix' style='background-color: #0d6efd'>" 
        + "<a id='nomeLanchonete' href='/sgv-lanchonete/paginas/index.php' class='text-white text-decoration-none'>Lanchonete</a>"
        + "</header>"

    
    return navbar;
}