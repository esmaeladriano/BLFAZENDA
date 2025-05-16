<?php
include_once('C:\xampp\htdocs\BLFazenda\conf\conexao.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
require_once '../../conf/conexao.php'; // conexão com banco

$sql = "SELECT * FROM pedidos ORDER BY data DESC";
$result = $conn->query($sql);
?>

!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Gestão de Fornecedores 🍃</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4fff4;
        }

        .btn-primary {
            background-color: #2e7d32;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1b5e20;
        }

        h1 {
            color: #2e7d32;
        }
    </style>
</head>

<body class="p-4">
    <?php include_once('navbar.php'); ?>
    <div class="main-content p-4 mt-4">
        <div class="container">

            <div class="container py-5">
                <h2 class="mb-4">📦 Pedidos Recebidos</h2>

                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Cliente</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Localidade</th>
                            <th>Total (AKZ)</th>
                            <th>Data</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pedido = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $pedido['id'] ?></td>
                                <td><?= $pedido['nome'] ?></td>
                                <td><?= $pedido['email'] ?></td>
                                <td><?= $pedido['telefone'] ?></td>
                                <td><?= $pedido['localidade'] ?></td>
                                <td><?= number_format($pedido['total'], 2, ',', '.') ?></td>
                                <td><?= $pedido['data'] ?></td>
                                <td>
                                    <a href="detalhes_pedido.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-primary">🔍 Ver</a>
                                </td>


                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
</body>

</html>