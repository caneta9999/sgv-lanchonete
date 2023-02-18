<?php
function limparSessao($codigosProdutos, $itensComanda) {
    echo "<script>
    sessionStorage.removeItem('" . $codigosProdutos . "')
    sessionStorage.removeItem('" . $itensComanda . "')
    </script>";
}
?>