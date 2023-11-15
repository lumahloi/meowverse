<?php
  include "inc_dbConexao.php";
  SESSION_START();
  
  ini_set('display_errors', 0);
  ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

  $sql = "select * from miniaturas where destaque = 'S' order by estoque DESC";
  $rs = mysqli_query($conexao, $sql);
  $total_registros = mysqli_num_rows($rs);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Meowverse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">

  
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  
</head>

<body>
  <div class="site-wrap">
    <?php include "inc_menuSuperiorCat.php" ?>

    <div class="site-blocks-cover" style="background-image: url(imagens/banner.jpg);" data-aos="fade">
      <div class="container">
        <div class="row align-items-start align-items-md-center justify-content-end">
          <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
            <h1 class="mb-2">A loja mais purrfeita para os nerds</h1>
            <div class="intro-text text-center text-md-left">
              <p class="mb-4">Aqui você encontra artigos geeks com qualidade e preço acessível, uma loja gatástica! </p>
              <p>
                <a href="#" class="btn btn-sm btn-primary">Comprar agora</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section site-section-sm site-blocks-1">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
            <div class="icon mr-4 align-self-start">
              <span class="icon-truck"></span>
            </div>
            <div class="text">
              <h2 class="text-uppercase">Entrega garantida</h2>
              <p>Nossa promessa é clara: entregamos com segurança e pontualidade. Com métodos de envio confiáveis,
                garantimos que você receba seus produtos no prazo estabelecido.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
            <div class="icon mr-4 align-self-start">
              <span class="icon-refresh2"></span>
            </div>
            <div class="text">
              <h2 class="text-uppercase">Devoluções grátis</h2>
              <p>Queremos que sua experiência de compra seja livre de estresse. Por isso, oferecemos devoluções grátis.
                Basta entrar em contato conosco e ajudaremos você.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
            <div class="icon mr-4 align-self-start">
              <span class="icon-help"></span>
            </div>
            <div class="text">
              <h2 class="text-uppercase">Atendimento acolhedor</h2>
              <p>Nosso compromisso com o cliente vai além da venda. Estamos aqui para ouvir suas perguntas, resolver
                problemas e garantir que sua experiência conosco seja excepcional.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Produtos em destaque</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="nonloop-block-3 owl-carousel">
              <?php
              for ($contador = 0; $contador < $total_registros; $contador++) {
                $reg = mysqli_fetch_array($rs);
                $codigo = $reg["codigo"];
                $nome = $reg["nome"];
                $estoque = $reg["estoque"];
                $min_estoque = $reg["min_estoque"];
                $preco = $reg["preco"];
                $desconto = $reg["desconto"];
                $valor_desconto = $preco - ($preco * $desconto / 100);
              ?>

              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="imagens/<?php print $codigo ?>.jpg" alt="Imagem de <?php print $nome?>" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <div style="height: 60px;">
                      <h3><a href="detalhes.php?produto=<?php print $codigo?>"><?php print $nome?></a></h3>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <p class="h5 text-secondary font-weight-bold"><s>R$ <?PHP print number_format($preco, 2, ',', '.'); ?></s></p>
                      </div>
                      <div class="col">
                        <p class="h5 text-primary font-weight-bold">R$ <?PHP print number_format($valor_desconto, 2, ',', '.'); ?></p>
                      </div>
                    </div>
                    <button class="btn btn-primary" onclick="window.location='detalhes.php?produto=<?php echo $codigo ?>'">Comprar</button>
                  </div>
                </div>
              </div>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "inc_rodape.php" ?>

  </div>

  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
</body>

</html>

<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>