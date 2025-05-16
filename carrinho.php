<?php
// Inicia a sessão para armazenar o carrinho
session_start();

// Inicializa o carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Função para adicionar produto ao carrinho
function adicionarAoCarrinho($id, $nome, $preco, $quantidade = 1) {
    // Se o produto já está no carrinho, incrementa a quantidade
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]['quantidade'] += $quantidade;
    } else {
        // Adiciona novo produto
        $_SESSION['carrinho'][$id] = [
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade
        ];
    }
}

// Função para remover produto do carrinho
function removerDoCarrinho($id) {
    if (isset($_SESSION['carrinho'][$id])) {
        unset($_SESSION['carrinho'][$id]);
    }
}

// Função para atualizar quantidade
function atualizarQuantidade($id, $quantidade) {
    if (isset($_SESSION['carrinho'][$id])) {
        if ($quantidade > 0) {
            $_SESSION['carrinho'][$id]['quantidade'] = $quantidade;
        } else {
            removerDoCarrinho($id);
        }
    }
}

// Processa ações do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['adicionar'])) {
        adicionarAoCarrinho($_POST['id'], $_POST['nome'], $_POST['preco'], $_POST['quantidade']);
    }
    if (isset($_POST['remover'])) {
        removerDoCarrinho($_POST['id']);
    }
    if (isset($_POST['atualizar'])) {
        atualizarQuantidade($_POST['id'], $_POST['quantidade']);
    }
}

// Exibe o carrinho
echo "<h2>Carrinho de Compras</h2>";
if (empty($_SESSION['carrinho'])) {
    echo "<p>Seu carrinho está vazio.</p>";
} else {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Produto</th><th>Preço</th><th>Quantidade</th><th>Total</th><th>Ações</th></tr>";
    $totalGeral = 0;
    foreach ($_SESSION['carrinho'] as $id => $item) {
        $total = $item['preco'] * $item['quantidade'];
        $totalGeral += $total;
        echo "<tr>
            <td>{$item['nome']}</td>
            <td>R$ " . number_format($item['preco'], 2, ',', '.') . "</td>
            <td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='number' name='quantidade' value='{$item['quantidade']}' min='1' style='width:50px;'>
                    <button type='submit' name='atualizar'>Atualizar</button>
                </form>
            </td>
            <td>R$ " . number_format($total, 2, ',', '.') . "</td>
            <td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='$id'>
                    <button type='submit' name='remover'>Remover</button>
                </form>
            </td>
        </tr>";
    }
    echo "<tr><td colspan='3'><strong>Total Geral</strong></td><td colspan='2'><strong>R$ " . number_format($totalGeral, 2, ',', '.') . "</strong></td></tr>";
    echo "</table>";
}

// Exemplo de formulário para adicionar produto (para testes)
?>
<h3>Adicionar Produto (Exemplo)</h3>
<form method="post">
    <input type="hidden" name="id" value="1">
    <input type="hidden" name="nome" value="Produto Exemplo">
    <input type="hidden" name="preco" value="10.00">
    Quantidade: <input type="number" name="quantidade" value="1" min="1" style="width:50px;">
    <button type="submit" name="adicionar">Adicionar ao Carrinho</button>
</form>