export function footer() {
    const footer = document.getElementById("footer");
    
    footer.innerHTML = "<footer class='footer mt-auto py-3' style='background-color: #0d6efd; width: 100%; bottom: 0; position: fixed;'>"
        + "<h2 class='d-flex justify-content-center text-white'>Projeto da Faculdade</h2>"
		 + "</footer>"

    return footer;
}