<?php
include_once('C:\xampp\htdocs\BLFazenda\conf\conexao.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Consultar todos os usuários
$sql = "SELECT * FROM usuarios ORDER BY nome ASC";
$res = mysqli_query($conn, $sql);
$usuarios = mysqli_fetch_all($res, MYSQLI_ASSOC);

// Buscar dados de usuário para edição (via GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($res);
    echo json_encode($usuario);
    exit();
}

// Adicionar ou editar usuário (via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['role'])) {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $id = isset($_POST['userId']) ? intval($_POST['userId']) : 0;

    // Verificar se o email já existe no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $email, $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($res) > 0) {
        echo 'Erro: O email já está cadastrado!';
        exit();
    }

    if ($id === 0) {
        // Inserir
        $sql = "INSERT INTO usuarios (nome, email, senha, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $senha, $role);
        $res = mysqli_stmt_execute($stmt);
        echo $res ? 'Usuário adicionado com sucesso!' : 'Erro ao adicionar usuário!';
    } else {
        // Atualizar
        $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ?, role = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $email, $senha, $role, $id);
        $res = mysqli_stmt_execute($stmt);
        echo $res ? 'Usuário atualizado com sucesso!' : 'Erro ao atualizar usuário!';
    }
    exit();
}

// Excluir usuário (via POST com exclusividade)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteId'])) {
    $id = intval($_POST['deleteId']);
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $res = mysqli_stmt_execute($stmt);
    echo $res ? 'Usuário excluído com sucesso!' : 'Erro ao excluir usuário!';
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .modal-header {
            background-color: #2D5A27;
            color: white;
        }

        .btn-custom {
            background-color: #4A7856;
            color: white;
        }

        .alert-box {
            display: none;
        }
    </style>
</head>

<body>
    <?php include_once('navbar.php'); ?>
    <div class="main-content p-4 mt-4">
        <h2 class="text-center">Gerenciar Usuários</h2>
        <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#modalForm" id="addUserBtn">Adicionar Usuário</button>

        <div id="alertBox" class="alert alert-success alert-box"></div>

        <div id="usuariosTable">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= $usuario['nome'] ?></td>
                            <td><?= $usuario['email'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm editBtn" data-id="<?= $usuario['id'] ?>">Editar</button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="<?= $usuario['id'] ?>">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="userId" name="userId">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Nível de Acesso</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="usuario">Usuário</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-custom">Salvar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Adicionar novo usuário
            $('#addUserBtn').on('click', function() {
                $('#userForm')[0].reset();
                $('#userId').val('');
                $('#modalFormLabel').text('Adicionar Usuário');
            });

            // Editar usuário
            $('.editBtn').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var usuario = JSON.parse(response);
                        $('#userId').val(usuario.id);
                        $('#nome').val(usuario.nome);
                        $('#email').val(usuario.email);
                        $('#senha').val('');
                        $('#modalFormLabel').text('Editar Usuário');
                        $('#modalForm').modal('show');
                    }
                });
            });

            // Excluir usuário
            $('.deleteBtn').on('click', function() {
                var id = $(this).data('id');
                if (confirm('Tem certeza que deseja excluir este usuário?')) {
                    $.ajax({
                        url: '',
                        type: 'POST',
                        data: {
                            deleteId: id
                        },
                        success: function(response) {
                            $('#alertBox').text(response).fadeIn().delay(2000).fadeOut(function() {
                                location.reload();
                            });
                        }
                    });
                }
            });

            // Salvar usuário
            $('#userForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#alertBox').text(response).fadeIn().delay(2000).fadeOut(function() {
                            $('#modalForm').modal('hide');
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>