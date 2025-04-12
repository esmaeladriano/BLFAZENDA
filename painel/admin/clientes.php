<?php
include_once('C:\xampp\htdocs\BLFazenda\conf\conexao.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    if ($acao === 'cadastrar') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];
        $query = "INSERT INTO clientes (nome, email, telefone, endereco) VALUES ('$nome', '$email', '$telefone', '$endereco')";
        mysqli_query($conn, $query);
        echo renderTabela($conn);
        exit;
    }

    if ($acao === 'editar') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];
        $query = "UPDATE clientes SET nome='$nome', email='$email', telefone='$telefone', endereco='$endereco' WHERE id=$id";
        mysqli_query($conn, $query);
        echo renderTabela($conn);
        exit;
    }

    if ($acao === 'deletar') {
        $id = $_POST['id'];
        mysqli_query($conn, "DELETE FROM clientes WHERE id = $id");
        echo renderTabela($conn);
        exit;
    }

    if ($acao === 'buscar') {
        $id = $_POST['id'];
        $res = mysqli_query($conn, "SELECT * FROM clientes WHERE id = $id");
        echo json_encode(mysqli_fetch_assoc($res));
        exit;
    }
}

function renderTabela($conn)
{
    $res = mysqli_query($conn, "SELECT * FROM clientes");
    $html = '<table class="table table-bordered table-hover">';
    $html .= '<thead class="table-success"><tr>
                <th>🌾 Nome</th><th>📧 Email</th><th>📞 Telefone</th><th>🏠 Endereço</th><th>⚙️ Ações</th>
              </tr></thead><tbody>';

    while ($row = mysqli_fetch_assoc($res)) {
        $html .= "<tr>
            <td>{$row['nome']}</td>
            <td>{$row['email']}</td>
            <td>{$row['telefone']}</td>
            <td>{$row['endereco']}</td>
            <td>
                <button class='btn btn-sm btn-warning me-1' onclick='editarCliente({$row['id']})'>✏️ Editar</button>
                <button class='btn btn-sm btn-danger btn-deletar' data-id='{$row['id']}'>🗑️ Excluir</button>
            </td>
        </tr>";
    }

    $html .= '</tbody></table>';
    return $html;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .modal-header { background-color: #2D5A27; color: white; }
        .btn-custom { background-color: #4A7856; color: white; }
        .alert-box { display: none; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body style="background-color: #f0fff0;">
<?php include_once('navbar.php'); ?>
    <div class="main-content p-4 mt-4">
<div class="container py-4">
    <h2 class="text-success mb-4">🌿 Gestão de Clientes da Fazenda</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalCliente" onclick="abrirModalCadastro()">+ Novo Cliente</button>
    <div id="lista-clientes">
        <?php echo renderTabela($conn); ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCliente" tabindex="-1">
  <div class="modal-dialog">
    <form id="formCliente" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="tituloModal">Cadastrar Cliente</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="idCliente">
        <input type="hidden" name="acao" id="acao" value="cadastrar">
        <div class="mb-3">
            <label>🌾 Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>📧 Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>📞 Telefone:</label>
            <input type="text" name="telefone" id="telefone" class="form-control">
        </div>
        <div class="mb-3">
            <label>🏠 Endereço:</label>
            <input type="text" name="endereco" id="endereco" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">💾 Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function abrirModalCadastro() {
        $('#tituloModal').text('Cadastrar Cliente');
        $('#acao').val('cadastrar');
        $('#formCliente')[0].reset();
        $('#idCliente').val('');
    }

    function editarCliente(id) {
        $.post('clientes.php', { id, acao: 'buscar' }, function (data) {
            const cliente = JSON.parse(data);
            $('#tituloModal').text('Editar Cliente');
            $('#acao').val('editar');
            $('#idCliente').val(cliente.id);
            $('#nome').val(cliente.nome);
            $('#email').val(cliente.email);
            $('#telefone').val(cliente.telefone);
            $('#endereco').val(cliente.endereco);
            new bootstrap.Modal(document.getElementById('modalCliente')).show();
        });
    }

    $('#formCliente').submit(function (e) {
        e.preventDefault();
        $.post('clientes.php', $(this).serialize(), function (res) {
            $('#modalCliente').modal('hide');
            $('#lista-clientes').html(res);
        });
    });

    $(document).on('click', '.btn-deletar', function () {
        if (confirm("Tem certeza que deseja excluir?")) {
            const id = $(this).data('id');
            $.post('clientes.php', { id, acao: 'deletar' }, function (res) {
                $('#lista-clientes').html(res);
            });
        }
    });
</script>
</body>
</html>
