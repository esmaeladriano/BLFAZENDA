<?php
session_start();

// Remover item do carrinho
if (isset($_GET['remover']) && isset($_SESSION['carrinho'][$_GET['remover']])) {
    unset($_SESSION['carrinho'][$_GET['remover']]);
    $mensagem = "Produto removido do carrinho.";
}

// Cálculo total
$total = 0;
$envio = 1000; // AKZ - valor fixo de envio

if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $id => $produto) {
        $total += $produto['preco'] * $produto['quantidade'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Carrinho de Compras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="mb-4 text-center">🧺 Carrinho de Compras</h2>

  <?php if (isset($mensagem)): ?>
    <div class="alert alert-info alert-dismissible fade show text-center">
      <?= $mensagem ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (!empty($_SESSION['carrinho'])): ?>
    <table class="table table-bordered table-hover">
      <thead class="table-secondary">
        <tr>
          <th>Produto</th>
          <th>Preço Unit.</th>
          <th>Quantidade</th>
          <th>Subtotal</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['carrinho'] as $id => $item): ?>
          <tr>
            <td><?= $item['nome'] ?></td>
            <td><?= number_format($item['preco'], 2, ',', '.') ?> AKZ</td>
            <td><?= $item['quantidade'] ?></td>
            <td><?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?> AKZ</td>
            <td>
              <a href="?remover=<?= $id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remover este item?')">🗑 Remover</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <tr class="table-light fw-bold">
          <td colspan="3" class="text-end">Total dos Produtos:</td>
          <td colspan="2"><?= number_format($total, 2, ',', '.') ?> AKZ</td>
        </tr>
        <tr class="table-light fw-bold">
          <td colspan="3" class="text-end">Custo de Envio:</td>
          <td colspan="2"><?= number_format($envio, 2, ',', '.') ?> AKZ</td>
        </tr>
        <tr class="table-dark text-white fw-bold">
          <td colspan="3" class="text-end">Total Geral:</td>
          <td colspan="2"><?= number_format($total + $envio, 2, ',', '.') ?> AKZ</td>
        </tr>
      </tbody>
    </table>

    <div class="text-center mt-4">
      <a href="finalizar_compra.php" class="btn btn-success btn-lg">💳 Finalizar Compra</a>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">
      Nenhum produto no carrinho.
    </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
