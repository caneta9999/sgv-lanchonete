<?php

function formatarReais($dinheiro) {
    return "R$" . number_format($dinheiro, 2, ',', '.');
}