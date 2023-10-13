<?php
include "inc_dbConexao.php";
SESSION_START();

// Selecione e agrupa as subcategorias para serem exebidas na lista supensa da pesquisa
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
mysqli_free_result($rs_sub);
?>

<nav class="navbar navbar-expand-lg navbar-light">
  
    <!-- Logo -->
    <a href="index.php">
      <figure>
          <img src="imagens/logo_fs.gif" class="img-fluid navbar-brand" alt="Faça um site">
      </figure>
    </a>

    <!-- Botão para exibir resto do menu caso a tela seja muito pequena -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
          <a class="nav-link" href="cesta.php">Meu Carrinho
            <span class="c_verde">(
                <?PHP if (['total_itens'] == 0 or ['num_ped'] == "") {
                  print "vazio";
                } ?>
                <?PHP if (['num_ped'] == "") { ?>
                  <?PHP if (['total_itens'] == 1) {
                    print ['total_itens'] . " produto";
                  } ?>
                  <?PHP if (['total_itens'] > 1) {
                    print ['total_itens'] . " produtos";
                  } ?>
                <?PHP } ?>
                )</span></span></a>
        </li>
      </ul>

      <!-- Pesquisa de produtos -->
      <form class="form-inline my-2 my-lg-0 d-flex align-items-center" method="post" action="pesquisa.php">
        <select name="sub">
            <?PHP print $combo; ?>
        </select>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>

      
    </div>
  
</nav>

<!-- -->