<?php
include_once('C:\xampp\htdocs\BLFazenda\conf\conexao.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}


// Carregar clientes
if (isset($_GET['clientes'])) {
    $res = $conn->query("SELECT id, nome FROM clientes");
    while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
    }
    exit;
}

// Carregar produtos
if (isset($_GET['produtos'])) {
    $res = $conn->query("SELECT id, nome FROM produtos");
    while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
    }
    exit;
}

// Preço do produto
if (isset($_GET['preco_produto'])) {
    $id = $_GET['preco_produto'];
    $res = $conn->query("SELECT preco FROM produtos WHERE id = $id");
    echo $res->fetch_assoc()['preco'] ?? 0;
    exit;
}

// Inserir ou editar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $id_cliente = $_POST['id_cliente'];
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];
    $preco_total = $_POST['preco_total'];
    $data_venda = $_POST['data_venda'];
    $tipo_venda = $_POST['tipo_venda'];

    if ($id == '') {
        $conn->query("INSERT INTO vendas (id_cliente, id_produto, quantidade, preco_total, data_venda, tipo_venda)
                      VALUES ('$id_cliente','$id_produto','$quantidade','$preco_total','$data_venda','$tipo_venda')");
    } else {
        $conn->query("UPDATE vendas SET 
                      id_cliente='$id_cliente', id_produto='$id_produto', quantidade='$quantidade', 
                      preco_total='$preco_total', data_venda='$data_venda', tipo_venda='$tipo_venda'
                      WHERE id = $id");
    }
    exit;
}

// Excluir venda
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM vendas WHERE id = " . $_GET['delete']);
    exit;
}

// Buscar dados de edição
if (isset($_GET['get'])) {
    $id = $_GET['get'];
    $res = $conn->query("SELECT * FROM vendas WHERE id = $id");
    echo json_encode($res->fetch_assoc());
    exit;
}

// Listar vendas
if (isset($_GET['listar'])) {
    $sql = "SELECT vendas.id, c.nome as cliente, p.nome as produto, vendas.quantidade, 
            vendas.preco_total, vendas.data_venda, vendas.tipo_venda 
            FROM vendas 
            JOIN clientes c ON vendas.id_cliente = c.id 
            JOIN produtos p ON vendas.id_produto = p.id";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$row['cliente']}</td>
            <td>{$row['produto']}</td>
            <td>{$row['quantidade']}</td>
            <td>{$row['preco_total']}</td>
            <td>{$row['data_venda']}</td>
            <td>{$row['tipo_venda']}</td>
            <td>
                <button onclick='abrirModal({$row['id']})'>✏️</button>
                <button onclick='deletar({$row['id']})'>🗑️</button>
            </td>
        </tr>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .modal-header { background-color: #2D5A27; color: white; }
        .btn-custom { background-color: #4A7856; color: white; }
        .alert-box { display: none; }
    </style>
<title>CRUD Vendas com Modal</title>
<style>
body { font-family: sans-serif; background: #f5f9f1; padding: 20px; }
h2 { color: #417d4f; }
button { padding: 8px 10px; background: #4caf50; color: white; border: none; border-radius: 5px; cursor: pointer; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
th { background: #d8e8d2; }

.modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.4);
  justify-content: center;
  align-items: center;
}
.modal-content {
  background: #ffffff;
  padding: 20px;
  width: 400px;
  border-radius: 8px;
}
.modal-content input, .modal-content select {
  width: 100%; padding: 8px; margin: 6px 0;
}
.close { float: right; font-size: 20px; cursor: pointer; }
</style>
</head>
<body>
<?php include_once('navbar.php'); ?>
<h2>📦 Vendas da Fazenda</h2>
<div class="main-content p-4 mt-4">
<button onclick="abrirModal()">➕ Nova Venda</button>

<table>
<thead>
<tr>
  <th>Cliente</th><th>Produto</th><th>Qtd</th><th>Preço</th><th>Data</th><th>Tipo</th><th>Ações</th>
</tr>
</thead>
<tbody id="tabela-vendas"></tbody>
</table>

<div class="modal" id="vendaModal">
  <div class="modal-content">
    <span class="close" onclick="fecharModal()">&times;</span>
    <form id="formVenda">
      <input type="hidden" name="id" id="id">
      <select name="id_cliente" id="id_cliente" required>
        <option value="">👤 Selecione Cliente</option>
      </select>
      <select name="id_produto" id="id_produto" required>
        <option value="">📦 Selecione Produto</option>
      </select>
      <input type="number" name="quantidade" id="quantidade" placeholder="Quantidade" required>
      <input type="number" name="preco_total" id="preco_total" placeholder="Preço" readonly required>
      <input type="date" name="data_venda" id="data_venda" required>
      <select name="tipo_venda" id="tipo_venda" required>
        <option value="">Tipo de Venda</option>
        <option value="grosso">Grossista</option>
        <option value="retalho">Retalho</option>
      </select>
      <button type="submit">💾 Salvar</button>
    </form>
  </div>
</div>

<script>
function carregarVendas() {
  fetch("vendas.php?listar=1")
    .then(res => res.text())
    .then(data => document.getElementById("tabela-vendas").innerHTML = data);
}

function carregarSelects() {
  fetch("vendas.php?clientes=1")
    .then(res => res.text())
    .then(op => document.getElementById("id_cliente").innerHTML += op);
  fetch("vendas.php?produtos=1")
    .then(res => res.text())
    .then(op => document.getElementById("id_produto").innerHTML += op);
}

function abrirModal(id = '') {
  document.getElementById("formVenda").reset();
  document.getElementById("id").value = '';
  if (id) {
    fetch("vendas.php?get=" + id)
      .then(res => res.json())
      .then(d => {
        document.getElementById("id").value = d.id;
        document.getElementById("id_cliente").value = d.id_cliente;
        document.getElementById("id_produto").value = d.id_produto;
        document.getElementById("quantidade").value = d.quantidade;
        document.getElementById("preco_total").value = d.preco_total;
        document.getElementById("data_venda").value = d.data_venda;
        document.getElementById("tipo_venda").value = d.tipo_venda;
      });
  }
  document.getElementById("vendaModal").style.display = "flex";
}

function fecharModal() {
  document.getElementById("vendaModal").style.display = "none";
}

document.getElementById("formVenda").addEventListener("submit", function(e){
  e.preventDefault();
  let dados = new FormData(this);
  fetch("vendas.php", {
    method: "POST",
    body: dados
  }).then(() => {
    fecharModal();
    carregarVendas();
  });
});

function deletar(id) {
  if (confirm("Deseja excluir?")) {
    fetch("vendas.php?delete=" + id).then(() => carregarVendas());
  }
}

document.getElementById("id_produto").addEventListener("change", function () {
  let id = this.value;
  if (id) {
    fetch("vendas.php?preco_produto=" + id)
      .then(res => res.text())
      .then(preco => document.getElementById("preco_total").value = preco);
  }
});

document.addEventListener("DOMContentLoaded", () => {
  carregarSelects();
  carregarVendas();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
