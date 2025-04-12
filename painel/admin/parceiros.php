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

    // Cadastrar ou Editar Parceiro
    if ($acao === 'cadastrar' || $acao === 'editar') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];
        $data_registro = $_POST['data_registro'];

        if ($acao === 'cadastrar') {
            // Verificar se já existe um parceiro com o mesmo email
            $queryCheckEmail = "SELECT * FROM parceiros WHERE email = '$email'";
            $resultCheckEmail = mysqli_query($conn, $queryCheckEmail);

            if (mysqli_num_rows($resultCheckEmail) > 0) {
                echo "<script>alert('Já existe um parceiro cadastrado com esse email.');</script>";
                exit;
            }

            // Inserir dados na tabela de parceiros
            $query = "INSERT INTO parceiros (nome, email, telefone, endereco, data_registro) 
                      VALUES ('$nome', '$email', '$telefone', '$endereco', '$data_registro')";
            mysqli_query($conn, $query);
        } else {
            $id = $_POST['id'];
            mysqli_query($conn, "UPDATE parceiros SET nome='$nome', email='$email', telefone='$telefone', 
            endereco='$endereco', data_registro='$data_registro' WHERE id=$id");
        }

        // Retornar a tabela atualizada
        echo renderTabelaParceiros($conn);
    }

    // Deletar Parceiro
    if ($acao === 'deletar') {
        $id = $_POST['id'];

        // Excluir as vendas associadas ao parceiro
        mysqli_query($conn, "DELETE FROM vendas WHERE id_parceiro = $id");

        // Agora, excluir o parceiro
        mysqli_query($conn, "DELETE FROM parceiros WHERE id = $id");

        // Retornar a tabela atualizada
        echo renderTabelaParceiros($conn);
        exit;
    }
}

// Tabela de Parceiros
function renderTabelaParceiros($conn)
{
    $html = '';
    $res = mysqli_query($conn, "SELECT * FROM parceiros");
    while ($p = mysqli_fetch_assoc($res)) {
        $html .= "<tr>
            <td>{$p['nome']}</td>
            <td>{$p['email']}</td>
            <td>{$p['telefone']}</td>
            <td>{$p['endereco']}</td>
            <td>{$p['data_registro']}</td>
            <td>
                <button class='btn btn-warning btn-sm editar' data-id='{$p['id']}'>✏️</button>
                <button class='btn btn-danger btn-sm deletar' data-id='{$p['id']}'>🗑️</button>
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
    <title>Gestão de Parceiros 🍃</title>
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
            <h1 class="mb-4">🌾 Parceiros da Fazenda</h1>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalParceiro" id="novoBtn">➕ Novo Parceiro</button>

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
                <tbody id="lista-parceiros">
                    <?= renderTabelaParceiros($conn) ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalParceiro" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form id="formParceiro" class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">📦 Cadastro de Parceiro</h5>
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
            $('#formParceiro').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: 'parceiros.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        bootstrap.Modal.getInstance(document.getElementById('modalParceiro')).hide();
                        $('#lista-parceiros').html(res);
                        $('#formParceiro')[0].reset();
                        $('#acao').val('cadastrar');
                    }
                });
            });

            // Novo Parceiro
            $('#novoBtn').click(function() {
                $('#formParceiro')[0].reset();
                $('#acao').val('cadastrar');
            });

            // Editar Parceiro
            $(document).on('click', '.editar', function() {
                let id = $(this).data('id');
                $.post('parceiros.php', {
                    id,
                    acao: 'editar'
                }, function(res) {
                    $('#formParceiro')[0].reset();
                    $('#acao').val('editar');
                    $('#id').val(id);
                    $('#modalParceiro').modal('show');
                });
            });

            // Deletar Parceiro
            $(document).on('click', '.deletar', function() {
                if (confirm("Deseja remover esse parceiro?")) {
                    let id = $(this).data('id');
                    $.post('parceiros.php', {
                        id,
                        acao: 'deletar'
                    }, function(res) {
                        $('#lista-parceiros').html(res);
                    });
                }
            });
        </script>
</body>

</html>
