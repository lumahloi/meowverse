<?php
include "inc_dbConexao.php";

SESSION_START();

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

/*// Selecione e agrupa as subcategorias para serem exebidas na lista supensa da pesquisa
$sql_sub = "SELECT id,subcateg, COUNT(subcateg) as total_cat ";
$sql_sub .= "FROM miniaturas ";
$sql_sub .= "GROUP BY subcateg ";
$sql_sub .= "ORDER BY subcateg ";
$rs_sub = mysqli_query($conexao, $sql_sub);

// Cria a primeira da lista suspensa
$combo .= "<option value= '0'>--Pesquisar produtos</option><br> ";
// Cria as demais linhas da lista suspensa
while ($reg_sub = mysqli_fetch_array($rs_sub)) {
  $subcateg = $reg_sub["subcateg"];
  $total_cat = $reg_sub["total_cat"];

  // Carrega a lista suspensa com as demais opções retornadas pelo SELECT acumulando o resultado na variavel $combo
  $combo .= "<option value='" . $subcateg . "'>" . $subcateg . " (" . $total_cat . ")</option><br>";
}
mysqli_free_result($rs_sub);*/

// Captura os itens adicionados ao carrinho para serem exibidos na página
$num_ped = $_SESSION['num_ped'];
$sqlb = "SELECT * ";
$sqlb .= " FROM itens ";
$sqlb .= " WHERE num_ped = '" . $num_ped . "' ";
$sqlb .= " ORDER BY id ";

//echo $sql;
//exit;
$rsb = mysqli_query($conexao, $sqlb);
$total_itens = mysqli_num_rows($rsb);
$_SESSION['total_itens'] = $total_itens;
?>

<script type="text/javascript">
  $(document).ready(function(){
    $("#txtpes").autocomplete("listapes.php", {
      width: 240,
      matchContains: true,
      //mustMatch: true,
      //minChars: 0,
      //multiple: true,
      //highlight: false,
      //multipleSeparator: ",",
      selectFirst: false
      });
  });

</script>


<nav class="navbar navbar-expand-lg navbar-light">
  
    <!-- Logo -->
    <a href="index.php">
      <img src="imagens/logo.png" class="navbar-brand" alt="Faça um site">
    </a>

    <!-- Botão para exibir resto do menu caso a tela seja muito pequena -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Itens da navegação -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="pedidos.php">Meus Pedidos</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="login.php?cadastro=S">Meu Cadastro</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="cesta.php">
            Meu Carrinho 
            <span>(
              <?php 
                echo "<span style='font-weight: bold; color: purple;'>".$total_itens."</span>";
              ?>
            )</span>
          </a>
        </li>
      </ul>

      <form class="form-inline" method="get" action="pesquisa.php" autocomplete="off" class="px-4">
        <div class="row row-cols-2 gx-1">
          <div class="col-lg-11 col-8">
            <input type="search" name="txtpes" id="txtpes" class="form-control mr-sm-2" placeholder="Procurar por nome" aria-label="Search">
          </div>
          <div class="col-lg-1 col-4">
            <button class="btn btn-success my-2 my-sm-0" style="background-color: purple; border: purple;" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  
</nav>

<!-- -->