<?php


// Aqui você faria a conexão com o banco e buscaria os produtos
$sql_produtos = "SELECT * FROM produtos ORDER BY id DESC LIMIT 6";
$res_produtos = mysqli_query($conn, $sql_produtos);
$produtos = mysqli_fetch_all($res_produtos, MYSQLI_ASSOC);

// Lógica para adicionar ao carrinho
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['adicionar_carrinho'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = (int)$_POST['quantidade'];

    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]['quantidade'] += $quantidade;
    } else {
        $_SESSION['carrinho'][$id] = [
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade
        ];
    }

    $mensagem = "Produto adicionado ao carrinho!";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Produtos | Loja</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/animate.css/animate.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="mb-4 text-center animate__animated animate__fadeInUp">🛒 Produtos Recentes</h2>

  <?php if (isset($mensagem)): ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
      <?= $mensagem ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <?php foreach ($produtos as $produto): ?>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="http://localhost/BLFazenda/painel\admin/<?= $produto['img'] ?>" class="card-img-top" alt="<?= $produto['nome'] ?>" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title"><?= $produto['nome'] ?></h5>
            <p class="card-text"><?= $produto['descricao'] ?></p>
            <p><strong>💰</strong> <?= number_format($produto['preco'], 2, ',', '.') ?> AKZ</p>

            <button
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#modalCompra"
              data-id="<?= $produto['id'] ?>"
              data-nome="<?= $produto['nome'] ?>"
              data-preco="<?= $produto['preco'] ?>"
              data-img="<?= $produto['img'] ?>"
            >
              🛒 Comprar
            </button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Modal de Compra -->
<div class="modal fade" id="modalCompra" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="post">
        <input type="hidden" name="adicionar_carrinho" value="1">

        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Detalhes do Produto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center">
          <img id="modal-img" src="" alt="" class="img-fluid mb-3 rounded" style="max-height: 200px;">
          <h4 id="modal-nome"></h4>
          <p><strong>Preço:</strong> <span id="modal-preco"></span> AKZ</p>
          <div class="form-group mb-3">
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="modal-quantidade" class="form-control" value="1" min="1" required>
          </div>

          <!-- Campos ocultos -->
          <input type="hidden" name="id" id="modal-id">
          <input type="hidden" name="nome" id="modal-nome-input">
          <input type="hidden" name="preco" id="modal-preco-input">
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success w-100">✅ Confirmar Compra</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const modal = document.getElementById('modalCompra');
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const nome = button.getAttribute('data-nome');
    const preco = button.getAttribute('data-preco');
    const img = button.getAttribute('data-img');

    document.getElementById('modal-img').src = img;
    document.getElementById('modal-nome').innerText = nome;
    document.getElementById('modal-preco').innerText = parseFloat(preco).toLocaleString('pt-AO', { minimumFractionDigits: 2 });

    document.getElementById('modal-id').value = id;
    document.getElementById('modal-nome-input').value = nome;
    document.getElementById('modal-preco-input').value = preco;
    document.getElementById('modal-quantidade').value = 1;
  });
</script>

</body>
</html>
