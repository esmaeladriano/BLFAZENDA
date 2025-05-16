<?php
session_start();

// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho'])) {
    header('Location: ver_carrinho.php');
    exit;
}


// Totais
$total = 0;
$envio = 1000;

foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['preco'] * $item['quantidade'];
}
$total_geral = $total + $envio;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Finalizar Compra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="mb-4 text-center">🧾 Finalizar Compra</h2>

  <div class="row">
    <div class="col-md-7">
      <form action="processa_pedido.php" method="post" class="border p-4 bg-white rounded shadow-sm">

        <h4>📋 Informações do Cliente</h4>

        <div class="mb-3">
          <label>Nome</label>
          <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>" readonly>
        </div>

        <div class="mb-3">
          <label>Email</label>
          <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" readonly>
        </div>

        <div class="mb-3">
          <label>Telefone</label>
          <input type="text" class="form-control" name="telefone" placeholder="Ex: 923123456" required>
        </div>

        <div class="mb-3">
          <label>Localidade / Endereço</label>
          <input type="text" class="form-control" name="localidade" placeholder="Ex: Luanda, Bairro X" required>
        </div>

        <input type="hidden" name="total" value="<?= $total_geral ?>">

        <button type="submit" class="btn btn-success w-100">💳 Finalizar Compra</button>
      </form>
    </div>

    <div class="col-md-5">
      <div class="border p-4 bg-white rounded shadow-sm">
        <h4>🛒 Resumo do Pedido</h4>
        <ul class="list-group mb-3">
          <?php foreach ($_SESSION['carrinho'] as $item): ?>
            <li class="list-group-item d-flex justify-content-between">
              <?= $item['nome'] ?> (x<?= $item['quantidade'] ?>)
              <span><?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?> AKZ</span>
            </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between">
            <strong>Subtotal</strong>
            <strong><?= number_format($total, 2, ',', '.') ?> AKZ</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <strong>Envio</strong>
            <strong><?= number_format($envio, 2, ',', '.') ?> AKZ</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between text-success">
            <strong>Total Geral</strong>
            <strong><?= number_format($total_geral, 2, ',', '.') ?> AKZ</strong>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
