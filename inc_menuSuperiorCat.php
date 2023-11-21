<?php
session_start();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


$num_ped = $_SESSION['num_ped'];

if ($num_ped) {
  $sql = "SELECT SUM(qt) AS total FROM itens WHERE num_ped = '" . $num_ped . "';";
  $rsb = mysqli_query($conexao, $sql);

  if (mysqli_num_rows($rsb) > 0) {
    $reg = mysqli_fetch_array($rsb);
    // Verifica se $reg['total'] é NULL e, nesse caso, define $qt como 0
    $qt = ($reg['total'] !== null) ? $reg['total'] : 0;
  } else {
    $qt = 0;
  }
} else {
  $qt = 0;
}

$cat_nome = $_GET['cat_nome'];
if(isset($cat_nome)&&$cat_nome!= '') {
  switch($cat_nome){
    case 'Nendoroid':
      $act_1 = 'active';
      break;
    case 'Figma':
      $act_2 = 'active';
      break;
    case 'Action Figures':
      $act_3 = 'active';
      break;
    case 'Funko POP':
      $act_4 = 'active';
      break;
    case 'Plushies':
      $act_5 = 'active';
      break;
    default:
      $act_6 = 'active';
  }
} else {
  $act_6 = 'active';
}
?>

<header class="site-navbar" role="banner">
        <div class="site-navbar-top">
          <div class="container">
            <div class="row align-items-center">
  
            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                <form action="pesquisa.php" method="get" class="site-block-top-search" autocomplete="off">
                  <span class="icon icon-search2"></span>
                  <input type="text" class="form-control border-0" placeholder="Procurar produtos" name="txtpes" id="txtpes">
                </form>
              </div>
  
              <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                <div class="">
                  <a href="index.php" class="js-logo-clone"><img src="imagens/logo.png" alt=""></a>
                </div>
              </div>
  
              <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                <div class="site-top-icons">
                  <ul>
                    <li><p><?php if ($_SESSION['nome_cli'] !== null) { print 'Olá, <strong>'.$_SESSION['nome_cli'].'</strong>';}?></p></li>
                    <li>
                      <a href="login.php?cadastro=S"><span class="icon icon-person"></span></a>
                    </li>
                    <li><a href="pedidos.php"><span class="icon icon-heart-o"></span></a></li>
                    <li>
                      <a href="cesta.php" class="site-cart">
                        <span class="icon icon-shopping_cart"></span>
                        <span class="count"><?php echo $qt; ?></span>
                      </a>
                    </li>
                    <?php if ($_SESSION['nome_cli'] !== null) { ?>
                    <li><a href="encerrar2.php"><span class="icon icon-sign-out"></span></a></li> <?php } ?>
                    <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                  </ul>
                </div> 
              </div>
  
            </div>
          </div>
        </div> 
        <nav class="site-navigation text-right text-md-center" role="navigation">
          <div class="container">
            <ul class="site-menu js-clone-nav d-none d-md-block">
              <li class="<?php echo $act_6?>"><a href="index.php">Home</a></li>
              <li class="<?php echo $act_1?>"><a href="categorias.php?cat_id=1&cat_nome=Nendoroid&ordenar=preco ASC">Nendoroid</a></li>
              <li class="<?php echo $act_2?>"><a href="categorias.php?cat_id=2&cat_nome=Figma&ordenar=preco ASC">Figma</a></li>
              <li class="<?php echo $act_3?>"><a href="categorias.php?cat_id=3&cat_nome=Action Figures&ordenar=preco ASC">Action Figures</a></li>
              <li class="<?php echo $act_4?>"><a href="categorias.php?cat_id=4&cat_nome=Funko POP&ordenar=preco ASC">Funko POP!</a></li>
              <li class="<?php echo $act_5?>"><a href="categorias.php?cat_id=5&cat_nome=Plushies&ordenar=preco ASC">Plushies</a></li>
            </ul>
          </div>
        </nav>
      </header>