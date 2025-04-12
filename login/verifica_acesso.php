<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: http://localhost/BLFazenda/"); // Redireciona para login
    exit();
}

// Função para permitir acesso somente a certos níveis
function permitirAcesso($nivelPermitido) {
    if ($_SESSION['nivel'] !== $nivelPermitido) {
        header("Location: acesso_negado.php"); // Página de acesso negado
        exit();
    }
}

