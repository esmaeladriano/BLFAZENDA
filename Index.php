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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestão de Fazendas</title>
  <link rel="stylesheet" href="./style.css">
  <!-- Inclui Swiper CSS -->
  <!-- Inclui Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body>
  <?php
  session_start();
  ?>

  <header>
    <h1 class="animate__animated animate__fadeInDown">🌾 Sistema de Gestão de Fazendas</h1>
    <nav class="animate__animated animate__fadeIn">
      <a href="#">Início</a>
      <a href="#">Produtos</a>
      <a href="#">Sobre</a>
      <a href="./login/">Login</a>
      <a href="./carrinho.php" style="margin-left:20px;">
        <i class="fas fa-shopping-cart"></i>
        <?php
        $qtd_carrinho = 0;
        if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
          foreach ($_SESSION['carrinho'] as $item) {
            $qtd_carrinho += $item['quantidade'];
          }
        }
        ?>
        <span style="background:#2e7d32; color:#fff; border-radius:50%; padding:2px 8px; font-size:0.9em;">
          <?= $qtd_carrinho ?>
        </span>
      </a>
      <?php if (isset($_SESSION['email'])): ?>
        <span style="margin-left:20px; color:#2e7d32;">
          <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['email']) ?>
        </span>
        <a href="./login/exit.php" style="color:#c62828; margin-left:10px;">
          <i class="fas fa-sign-out-alt" style="color:#c62828;"></i> Sair
        </a>
      <?php endif; ?>

    </nav>
  </header>

  <!-- Carrossel -->
  <div class="carousel">
    <?php foreach ($banners as $index => $banner): ?>
      <img class="mySlides"
        src="<?= 'http://localhost/BLFazenda/painel\admin/' . $banner['imagem'] ?>"
        alt="Banner <?= $index + 1 ?>" />
    <?php endforeach; ?>
    <div class="dot-container">
      <?php for ($i = 0; $i < count($banners); $i++): ?>
        <span class="dot" onclick="currentSlide(<?= $i + 1 ?>)"></span>
      <?php endfor; ?>
    </div>
  </div>


  <!-- Produtos -->
  <section>
    <h2 class="section-title animate__animated animate__fadeInUp">🛒 Produtos Recentes</h2>

    <div class="swiper produtos-swiper animate__animated animate__fadeInUp">
      <div class="swiper-wrapper">
        <?php foreach ($produtos as $produto): ?>
          <div class="swiper-slide">
            <div class="card-produto">

              <img src="<?= 'http://localhost/BLFazenda/painel\admin/' . $produto['img'] ?>" alt="<?= $produto['nome'] ?>" />
              <div class="card-content">
                <h3><?= $produto['nome'] ?></h3>
                <p><?= $produto['descricao'] ?></p>
                <p><strong>💰 Preço:</strong> <?= number_format($produto['preco'], 2, ',', '.') ?> AKZ</p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Setas de navegação -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

      <!-- Paginação -->
      <div class="swiper-pagination"></div>
    </div>
  </section>



  <!-- Gestão Facilitada -->
  <section class="gestao-section animate__animated animate__fadeIn">
    <div class="gestao-content container">
      <div class="gestao-text">
        <h2 class="section-title">🔧 Gestão Facilitada</h2>
        <p>Gerencie <strong>produtos</strong>, <strong>fornecedores</strong>, <strong>clientes</strong> e <strong>vendas</strong> de forma centralizada, com controle e eficiência.</p>
      </div>
      <div class="gestao-itens">
        <div class="gestao-item"><i class="fas fa-box-open"></i> Produtos</div>
        <div class="gestao-item"><i class="fas fa-truck"></i> Fornecedores</div>
        <div class="gestao-item"><i class="fas fa-users"></i> Clientes</div>
        <div class="gestao-item"><i class="fas fa-chart-line"></i> Vendas</div>
      </div>
    </div>
  </section>


  <!-- Como usar -->
  <section class="como-usar-section animate__animated animate__fadeInUp">
    <div class="container">
      <h2 class="section-title">📋 Como Usar</h2>
      <p class="intro-text">Siga esses simples passos para começar a utilizar nossa plataforma de gestão de forma eficiente:</p>
      <ol class="como-usar-steps">
        <li><i class="fas fa-user-plus"></i> Crie seu login.</li>
        <li><i class="fas fa-box-open"></i> Adicione seus produtos e fornecedores.</li>
        <li><i class="fas fa-chart-line"></i> Registre vendas e acompanhe as estatísticas.</li>
      </ol>
    </div>
  </section>



  <!-- Estatísticas -->
  <section class="estatisticas-section animate__animated animate__fadeInUp">
    <div class="container">
      <h2 class="section-title">📈 Estatísticas</h2>
      <div class="estatisticas-grid">
        <div class="stat-box">
          <div class="stat-number" data-count="350">0</div>
          <p>Produtos</p>
        </div>
        <div class="stat-box">
          <div class="stat-number" data-count="120">0</div>
          <p>Fornecedores</p>
        </div>
        <div class="stat-box">
          <div class="stat-number" data-count="78">0</div>
          <p>Clientes</p>
        </div>
        <div class="stat-box">
          <div class="stat-number" data-count="215">0</div>
          <p>Vendas</p>
        </div>
      </div>
    </div>
  </section>



  <!-- Serviços -->
  <section class="servicos container animate__animated animate__fadeInUp">
    <h2 class="section-title">🌾 Nossos Serviços</h2>
    <div class="servicos-row">
      <div class="servico-box animate__animated animate__zoomIn">
        <i class="fas fa-seedling"></i>
        <h3>Produção</h3>
        <p>Gestão eficiente da safra e plantio com tecnologia integrada.</p>
      </div>
      <div class="servico-box animate__animated animate__zoomIn">
        <i class="fas fa-balance-scale"></i>
        <h3>Pesagem</h3>
        <p>Controle rigoroso da colheita com registros automáticos.</p>
      </div>
      <div class="servico-box animate__animated animate__zoomIn">
        <i class="fas fa-handshake"></i>
        <h3>Parcerias</h3>
        <p>Conectamos produtores a fornecedores e distribuidores.</p>
      </div>
      <div class="servico-box animate__animated animate__zoomIn">
        <i class="fas fa-wallet"></i>
        <h3>Vendas</h3>
        <p>Gestão completa de vendas no retalho ou em grande escala.</p>
      </div>
    </div>
  </section>

  <!-- Estilos personalizados -->


  <!-- Depoimentos -->
  <section class="testemunhos animate__animated animate__fadeIn">
    <div class="container">
      <h2 class="section-title">💬 Depoimentos</h2>
      <div class="testimonial-slider">
        <div class="testimonial">
          <p>"Sistema incrível! Controlei toda minha fazenda com facilidade."</p>
          <strong>- João Pedro</strong>
        </div>
        <div class="testimonial">
          <p>"Relatórios organizados e interface simples. Muito útil."</p>
          <strong>- Maria Clara</strong>
        </div>
        <div class="testimonial">
          <p>"Meu estoque e vendas estão sempre em dia agora!"</p>
          <strong>- José Carlos</strong>
        </div>
      </div>
    </div>
  </section>




  <!-- Footer -->
  <footer style="background-color: #2e7d32; color: #fff; text-align: center; padding: 20px 0;">
    <p style="font-size: 1rem; margin: 0;">&copy; <?= date("Y") ?> Sistema de Gestão de Fazendas. Todos os direitos reservados.</p>
    <div style="margin-top: 10px;">
      <a href="#" style="color: #fff; text-decoration: none; margin: 0 10px;">Termos de Uso</a>
      <a href="#" style="color: #fff; text-decoration: none; margin: 0 10px;">Política de Privacidade</a>
      <a href="#" style="color: #fff; text-decoration: none; margin: 0 10px;">Suporte</a>
    </div>
  </footer>

  <!-- Script para o slider de depoimentos -->
  <script>
    let currentIndex = 0;
    const testimonials = document.querySelectorAll('.testimonial');
    const totalTestimonials = testimonials.length;

    function showNextTestimonial() {
      testimonials[currentIndex].style.opacity = 0;
      currentIndex = (currentIndex + 1) % totalTestimonials;
      testimonials[currentIndex].style.opacity = 1;
    }

    setInterval(showNextTestimonial, 5000); // Troca a cada 5 segundos
  </script>


  <!-- Script para animação dos números -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const statNumbers = document.querySelectorAll('.stat-number');

      statNumbers.forEach(function(statNumber) {
        let count = 0;
        const target = +statNumber.getAttribute('data-count');
        const increment = target / 100;

        function updateCounter() {
          if (count < target) {
            count += increment;
            statNumber.innerText = Math.ceil(count);
            setTimeout(updateCounter, 10);
          } else {
            statNumber.innerText = target;
          }
        }

        updateCounter();
      });
    });
  </script>
  <!-- Inicializa o slider -->
  <script>
    const swiper = new Swiper('.produtos-swiper', {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      },
      breakpoints: {
        640: {
          slidesPerView: 1
        },
        768: {
          slidesPerView: 2
        },
        1024: {
          slidesPerView: 3
        }
      }
    });
  </script>

  <script>
    // Slider de banners
    let slideIndex = 0;
    showSlides();

    function showSlides() {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1;
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      if (slides[slideIndex - 1]) {
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
      }
      setTimeout(showSlides, 5000); // Troca a cada 5 segundos
    }

    // Animação de estatísticas
    const counters = document.querySelectorAll(".stat-number");
    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute("data-count");
        const count = +counter.innerText;
        const speed = 10;
        const inc = Math.ceil(target / speed);

        if (count < target) {
          counter.innerText = count + inc;
          setTimeout(updateCount, 50);
        } else {
          counter.innerText = target;
        }
      };
      updateCount();
    });
  </script>
</body>

</html>