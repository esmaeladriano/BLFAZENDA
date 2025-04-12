<?php
include_once('./conf/conexao.php');

$sql_banner = "SELECT * FROM banners ORDER BY id ASC LIMIT 3";
$res_banner = mysqli_query($conn, $sql_banner);
$banners = mysqli_fetch_all($res_banner, MYSQLI_ASSOC);

$sql_produtos = "SELECT * FROM produtos ORDER BY id DESC LIMIT 6";
$res_produtos = mysqli_query($conn, $sql_produtos);
$produtos = mysqli_fetch_all($res_produtos, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestão de Fazendas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <style>
    * { box-sizing: border-box; }
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    header, footer { background-color: #2ecc71; color: white; text-align: center; padding: 1rem; }
    nav a { margin: 0 1rem; color: white; text-decoration: none; }
    .carousel { position: relative; max-width: 100%; overflow: hidden; margin-bottom: 1rem; }
    .mySlides { display: none; width: 100%; height: 400px; object-fit: cover; }
    .dot-container { text-align: center; margin-top: 0.5rem; }
    .dot { height: 15px; width: 15px; margin: 0 2px; background-color: #bbb; border-radius: 50%; display: inline-block; cursor: pointer; }
    .active, .dot:hover { background-color: #717171; }
    section { padding: 2rem 1rem; }
    .section-title { text-align: center; font-size: 2rem; margin-bottom: 1rem; }
    .produtos-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; }
    .produto { border: 1px solid #ccc; border-radius: 8px; padding: 1rem; width: 250px; background-color: #f9f9f9; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .produto img { max-width: 100%; border-radius: 5px; }
    .produto h3 { margin: 0.5rem 0; }
    footer { margin-top: 2rem; }
    .btn { background: #27ae60; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
    .stat-box { text-align: center; padding: 1rem; background: #fff; border-radius: 10px; width: 200px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .stat-number { font-size: 2rem; color: #27ae60; font-weight: bold; }
    .testemunhos { background: #ecf0f1; padding: 2rem 1rem; }
    .testimonial-slider { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 1rem; }
    .testimonial { background: white; padding: 1rem; border-radius: 10px; min-width: 300px; scroll-snap-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .servicos { background-color: #f0fff0; padding: 2rem 1rem; display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; }
    .servico-box { background: #fff; padding: 1rem; border-radius: 8px; width: 250px; box-shadow: 0 0 10px rgba(0,0,0,0.05); text-align: center; }
    @media (max-width: 768px) {
      .stat-box, .servico-box, .produto { width: 90%; }
    }
  </style>
</head>
<body>
  <header>
    <h1 class="animate__animated animate__fadeInDown">🌾 Sistema de Gestão de Fazendas</h1>
    <nav class="animate__animated animate__fadeIn">
      <a href="#">Início</a>
      <a href="#">Produtos</a>
      <a href="#">Sobre</a>
      <a href="#">Login</a>
    </nav>
  </header>

  <!-- Carrossel -->
  <div class="carousel">
    <?php foreach ($banners as $index => $banner): ?>
      <img class="mySlides" src="<?= $banner['imagem'] ?>" alt="Banner <?= $index + 1 ?>" />
    <?php endforeach; ?>
    <div class="dot-container">
      <?php for ($i = 0; $i < count($banners); $i++): ?>
        <span class="dot" onclick="currentSlide(<?= $i + 1 ?>)"></span>
      <?php endfor; ?>
    </div>
  </div>

  <!-- Produtos -->
  <section>
    <h2 class="section-title animate__animated animate__fadeInUp">Produtos Recentes</h2>
    <div class="produtos-container">
      <?php foreach ($produtos as $produto): ?>
        <div class="produto animate__animated animate__fadeInUp">
          <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>" />
          <h3><?= $produto['nome'] ?></h3>
          <p><?= $produto['descricao'] ?></p>
          <p><strong>Preço:</strong> <?= number_format($produto['preco'], 2, ',', '.') ?> AKZ</p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Seção Gestão -->
  <section style="background-color: #eafaf1;">
    <h2 class="section-title animate__animated animate__fadeIn">🔧 Gestão Facilitada</h2>
    <p style="text-align:center;">Controle de produtos, fornecedores, clientes e vendas num só lugar.</p>
  </section>

  <!-- Como usar -->
  <section>
    <h2 class="section-title animate__animated animate__fadeInUp">📋 Como Usar</h2>
    <ol style="max-width:600px;margin:auto;">
      <li>Crie seu login.</li>
      <li>Adicione seus produtos e fornecedores.</li>
      <li>Registre vendas e acompanhe estatísticas.</li>
    </ol>
  </section>

  <!-- Estatísticas -->
  <section style="text-align:center; background-color:#fefefe;">
    <h2 class="section-title animate__animated animate__fadeInUp">📈 Estatísticas</h2>
    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:1rem;">
      <div class="stat-box"><div class="stat-number" data-count="350">0</div><p>Produtos</p></div>
      <div class="stat-box"><div class="stat-number" data-count="120">0</div><p>Fornecedores</p></div>
      <div class="stat-box"><div class="stat-number" data-count="78">0</div><p>Clientes</p></div>
      <div class="stat-box"><div class="stat-number" data-count="215">0</div><p>Vendas</p></div>
    </div>
  </section>

  <!-- Serviços -->
  <section class="servicos">
    <div class="servico-box animate__animated animate__zoomIn"><i class="fas fa-seedling fa-2x"></i><h3>Produção</h3><p>Gestão de safra e plantio.</p></div>
    <div class="servico-box animate__animated animate__zoomIn"><i class="fas fa-balance-scale fa-2x"></i><h3>Pesagem</h3><p>Controle de colheita.</p></div>
    <div class="servico-box animate__animated animate__zoomIn"><i class="fas fa-handshake fa-2x"></i><h3>Parcerias</h3><p>Conexão entre produtor e mercado.</p></div>
    <div class="servico-box animate__animated animate__zoomIn"><i class="fas fa-wallet fa-2x"></i><h3>Vendas</h3><p>Venda no retalho ou grosso.</p></div>
  </section>

  <!-- Depoimentos -->
  <section class="testemunhos">
    <h2 class="section-title animate__animated animate__fadeIn">💬 Depoimentos</h2>
    <div class="testimonial-slider">
      <div class="testimonial"><p>"Sistema incrível! Controlei toda minha fazenda com facilidade."</p><strong>- João Pedro</strong></div>
      <div class="testimonial"><p>"Relatórios organizados e interface simples. Muito útil."</p><strong>- Maria Clara</strong></div>
      <div class="testimonial"><p>"Meu estoque e vendas estão sempre em dia agora!"</p><strong>- José Carlos</strong></div>
    </div>
  </section>

  <footer>
    <p>&copy; <?= date("Y") ?> Sistema de Gestão de Fazendas. Todos os direitos reservados.</p>
  </footer>

  <script>
    // Carrossel
    let slideIndex = 1;
    showSlides(slideIndex);
    function plusSlides(n) { showSlides(slideIndex += n); }
    function currentSlide(n) { showSlides(slideIndex = n); }
    function showSlides(n) {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) { slides[i].style.display = "none"; }
      for (i = 0; i < dots.length; i++) { dots[i].className = dots[i].className.replace(" active", ""); }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
    }

    // Contador
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
      counter.innerText = '0';
      const updateCount = () => {
        const target = +counter.getAttribute('data-count');
        const count = +counter.innerText;
        const increment = target / 50;
        if (count < target) {
          counter.innerText = Math.ceil(count + increment);
          setTimeout(updateCount, 20);
        } else {
          counter.innerText = target;
        }
      };
      updateCount();
    });
  </script>
</body>
</html>
