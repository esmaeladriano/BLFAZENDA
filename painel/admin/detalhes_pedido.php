<?php
include_once('C:\xampp\htdocs\BLFazenda\conf\conexao.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
require_once '../../conf/conexao.php'; // conexão com banco

$id_pedido = $_GET['id'] ?? 0;

// Buscar pedido
$pedido = $conn->query("SELECT * FROM pedidos WHERE id = $id_pedido")->fetch_assoc();

// Buscar itens do pedido
$itens = $conn->query("SELECT * FROM pedido_itens WHERE pedido_id = $id_pedido");
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
    <?php if ($pedido): ?>
      <h2>📄 Detalhes do Pedido #<?= $pedido['id'] ?></h2>
      <p><strong>Cliente:</strong> <?= $pedido['nome'] ?> | <strong>Email:</strong> <?= $pedido['email'] ?></p>
      <p><strong>Telefone:</strong> <?= $pedido['telefone'] ?> | <strong>Localidade:</strong> <?= $pedido['localidade'] ?></p>
    <?php else: ?>
      <div class="alert alert-danger">Pedido não encontrado.</div>
    <?php endif; ?>
    <p><strong>Total:</strong> <?= number_format($pedido['total'], 2, ',', '.') ?> AKZ</p>

    <hr>

    <h4>Itens do Pedido</h4>
    <table class="table">
      <thead>
        <tr>
          <th>Produto</th>
          <th>Qtd</th>
          <th>Preço Unitário</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($item = $itens->fetch_assoc()): ?>
          <tr>
            <td><?= $item['nome_produto'] ?></td>
            <td><?= $item['quantidade'] ?></td>
            <td><?= number_format($item['preco_unitario'], 2, ',', '.') ?> AKZ</td>
            <td><?= number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.') ?> AKZ</td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <a href="pedidos_admin.php" class="btn btn-secondary mt-3">← Voltar</a>
  </div>
</body>
</html>
