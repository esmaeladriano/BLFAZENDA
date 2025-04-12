<?php
include_once('C:\xampp\htdocs\BLFazenda\conf\conexao.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Receber requisições AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    // Cadastrar ou Editar Fornecedor
    if ($acao === 'cadastrar' || $acao === 'editar') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];
        $data_registro = $_POST['data_registro'];

        if ($acao === 'cadastrar') {
            // Verificar se já existe um fornecedor com o mesmo email
            $queryCheckEmail = "SELECT * FROM fornecedores WHERE email = '$email'";
            $resultCheckEmail = mysqli_query($conn, $queryCheckEmail);

            if (mysqli_num_rows($resultCheckEmail) > 0) {
                echo "<script>alert('Já existe um fornecedor cadastrado com esse email.');</script>";
                exit;
            }

            // Inserir dados na tabela de fornecedores
            $query = "INSERT INTO fornecedores (nome, email, telefone, endereco, data_registro) 
                  VALUES ('$nome', '$email', '$telefone', '$endereco', '$data_registro')";
            mysqli_query($conn, $query);
        } else {
            $id = $_POST['id'];
            mysqli_query($conn, "UPDATE fornecedores SET nome='$nome', email='$email', telefone='$telefone', 
            endereco='$endereco', data_registro='$data_registro' WHERE id=$id");
        }

        // Retornar a tabela atualizada
        echo renderTabelaFornecedores($conn);
    }


    // Deletar Fornecedor
    if ($acao === 'deletar') {
        $id = $_POST['id'];

        // Excluir as vendas associadas ao fornecedor
        mysqli_query($conn, "DELETE FROM vendas WHERE id_fornecedor = $id");

        // Agora, excluir o fornecedor
        mysqli_query($conn, "DELETE FROM fornecedores WHERE id = $id");

        // Retornar a tabela atualizada
        echo renderTabelaFornecedores($conn);
        exit;
    }
}

// Tabela de Fornecedores
function renderTabelaFornecedores($conn)
{
    $html = '';
    $res = mysqli_query($conn, "SELECT * FROM fornecedores");
    while ($f = mysqli_fetch_assoc($res)) {
        $html .= "<tr>
            <td>{$f['nome']}</td>
            <td>{$f['email']}</td>
            <td>{$f['telefone']}</td>
            <td>{$f['endereco']}</td>
            <td>{$f['data_registro']}</td>
            <td>
                <button class='btn btn-warning btn-sm editar' data-id='{$f['id']}'>✏️</button>
                <button class='btn btn-danger btn-sm deletar' data-id='{$f['id']}'>🗑️</button>
            </td>
        </tr>";
    }
    return $html;
}

?>

<!DOCTYPE html>
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
            <h1 class="mb-4">🌾 Fornecedores da Fazenda</h1>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalFornecedor" id="novoBtn">➕ Novo Fornecedor</button>

            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th>Data de Registro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="lista-fornecedores">
                    <?= renderTabelaFornecedores($conn) ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalFornecedor" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form id="formFornecedor" class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">📦 Cadastro de Fornecedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3 px-4">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="acao" id="acao" value="cadastrar">

                        <div class="col-md-6">
                            <label>📛 Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>📧 Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>📞 Telefone:</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>🏠 Endereço:</label>
                            <input type="text" name="endereco" id="endereco" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>📅 Data de Registro:</label>
                            <input type="date" name="data_registro" id="data_registro" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">💾 Salvar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Submeter formulário
            $('#formFornecedor').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: 'fornecedores.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        bootstrap.Modal.getInstance(document.getElementById('modalFornecedor')).hide();
                        $('#lista-fornecedores').html(res);
                        $('#formFornecedor')[0].reset();
                        $('#acao').val('cadastrar');
                    }
                });
            });

            // Novo Fornecedor
            $('#novoBtn').click(function() {
                $('#formFornecedor')[0].reset();
                $('#acao').val('cadastrar');
            });

            // Editar Fornecedor
            $(document).on('click', '.editar', function() {
                let id = $(this).data('id');
                $.post('fornecedores.php', {
                    id,
                    acao: 'editar'
                }, function(res) {
                    $('#formFornecedor')[0].reset();
                    $('#acao').val('editar');
                    $('#id').val(id);
                    $('#modalFornecedor').modal('show');
                });
            });

            // Deletar Fornecedor
            $(document).on('click', '.deletar', function() {
                if (confirm("Deseja remover esse fornecedor?")) {
                    let id = $(this).data('id');
                    $.post('fornecedores.php', {
                        id,
                        acao: 'deletar'
                    }, function(res) {
                        $('#lista-fornecedores').html(res);
                    });
                }
            });
        </script>
</body>

</html>