export function footer() {
    const footer = document.getElementById("footer");
    footer.innerHTML = "<footer class='footer mt-auto py-3 justify-content-center clearfix' style='background-color: #0d6efd; width: 100%; bottom: 0; position: fixed;'>"
        + "<h2 class='d-flex justify-content-center text-white'>Projeto da Faculdade</h2>"
		+ "<form id='formAjuda' method='POST' action='/sgv-lanchonete/paginas/indexAjuda.php'>"
        + "<input name='ajudaSubmit' class='inputAjuda btn btn-secondary' type='submit' value='Ajuda'>"
        + "</form>"
         + "</footer>"
    return footer;
}