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

    // Cadastrar ou Editar Produto
    if ($acao === 'cadastrar' || $acao === 'editar') {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        $data = $_POST['data_criacao'];
        $fornecedor = $_POST['id_fornecedor'];

        $imgPath = '';
        if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
            $nomeImg = uniqid() . '_' . $_FILES['img']['name'];
            $caminho = 'upload/' . $nomeImg;
            if (!is_dir('upload')) mkdir('upload');
            move_uploaded_file($_FILES['img']['tmp_name'], $caminho);
            $imgPath = $caminho;
        }

        if ($acao === 'cadastrar') {
            mysqli_query($conn, "INSERT INTO produtos (nome, img, descricao, preco, quantidade, data_criacao, id_fornecedor)
            VALUES ('$nome', '$imgPath', '$descricao', '$preco', '$quantidade', '$data', '$fornecedor')");
        } else {
            $id = $_POST['id'];
            if (empty($imgPath)) {
                $res = mysqli_query($conn, "SELECT img FROM produtos WHERE id = $id");
                $imgPath = mysqli_fetch_assoc($res)['img'];
            }
            mysqli_query($conn, "UPDATE produtos SET nome='$nome', img='$imgPath', descricao='$descricao', preco='$preco',
            quantidade='$quantidade', data_criacao='$data', id_fornecedor='$fornecedor' WHERE id=$id");
        }

        echo renderTabela($conn);
        exit;
    }

    // Deletar
if ($acao === 'deletar') {
    $id = $_POST['id'];

    // Excluir as vendas associadas ao produto
    mysqli_query($conn, "DELETE FROM vendas WHERE id_produto = $id");

    // Agora, excluir o produto
    mysqli_query($conn, "DELETE FROM produtos WHERE id = $id");

    // Retornar a tabela atualizada
    echo renderTabela($conn);
    exit;
}

}

// Tabela de produtos
function renderTabela($conn)
{
    $html = '';
    $res = mysqli_query($conn, "SELECT * FROM produtos");
    while ($p = mysqli_fetch_assoc($res)) {
        $html .= "<tr>
            <td><img src='{$p['img']}' width='60'></td>
            <td>{$p['nome']}</td>
            <td>{$p['descricao']}</td>
            <td>{$p['preco']}</td>
            <td>{$p['quantidade']}</td>
            <td>{$p['data_criacao']}</td>
            <td>{$p['id_fornecedor']}</td>
            <td>
                <button class='btn btn-warning btn-sm editar' data-id='{$p['id']}'>✏️</button>
                <button class='btn btn-danger btn-sm deletar' data-id='{$p['id']}'>🗑️</button>
            </td>
        </tr>";
    }
    return $html;
}

// Obter todos os fornecedores para o select
function getFornecedores($conn) {
    $result = mysqli_query($conn, "SELECT id, nome FROM fornecedores");
    $fornecedores = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $fornecedores[] = $row;
    }
    return $fornecedores;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Produtos 🍃</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4fff4; }
        .btn-primary { background-color: #2e7d32; border: none; }
        .btn-primary:hover { background-color: #1b5e20; }
        h1 { color: #2e7d32; }
        table img { border-radius: 8px; }
    </style>
</head>
<body class="p-4">
<?php include_once('navbar.php'); ?>
    <div class="main-content p-4 mt-4">
    <div class="container">
        <h1 class="mb-4">🌾 Produtos da Fazenda</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalProduto" id="novoBtn">➕ Novo Produto</button>
        
        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>Imagem</th><th>Nome</th><th>Descrição</th><th>Preço</th>
                    <th>Qtd</th><th>Data</th><th>Fornecedor</th><th>Ações</th>
                </tr>
            </thead>
            <tbody id="lista-produtos">
                <?= renderTabela($conn) ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalProduto" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="formProduto" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">📦 Cadastro de Produto</h5>
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
                        <label>🖼️ Imagem:</label>
                        <input type="file" name="img" id="img" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>💬 Descrição:</label>
                        <input type="text" name="descricao" id="descricao" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>💰 Preço:</label>
                        <input type="number" name="preco" id="preco" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>🔢 Quantidade:</label>
                        <input type="number" name="quantidade" id="quantidade" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>📅 Data:</label>
                        <input type="date" name="data_criacao" id="data_criacao" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>👤 Fornecedor:</label>
                        <select name="id_fornecedor" id="id_fornecedor" class="form-control">
                            <?php 
                                $fornecedores = getFornecedores($conn);
                                foreach ($fornecedores as $fornecedor) {
                                    echo "<option value='{$fornecedor['id']}'>{$fornecedor['nome']}</option>";
                                }
                            ?>
                        </select>
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
        $('#formProduto').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: 'produtos.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    bootstrap.Modal.getInstance(document.getElementById('modalProduto')).hide();
                    $('#lista-produtos').html(res);
                    $('#formProduto')[0].reset();
                    $('#acao').val('cadastrar');
                }
            });
        });

        // Novo
        $('#novoBtn').click(function () {
            $('#formProduto')[0].reset();
            $('#acao').val('cadastrar');
        });

        // Editar
        $(document).on('click', '.editar', function () {
            let id = $(this).data('id');
            $.post('produtos.php', { id, acao: 'editar' }, function (res) {
                $('#formProduto')[0].reset();
                $('#acao').val('editar');
                $('#id').val(id);
                $('#modalProduto').modal('show');
            });
        });

        // Deletar
        $(document).on('click', '.deletar', function () {
            if (confirm("Deseja remover esse produto?")) {
                let id = $(this).data('id');
                $.post('produtos.php', { id, acao: 'deletar' }, function (res) {
                    $('#lista-produtos').html(res);
                });
            }
        });
    </script>
</body>
</html>
