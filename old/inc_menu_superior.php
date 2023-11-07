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
$combo .= "<option value= '0'>--Selecione</option><br> ";
// Cria as demais linhas da lista suspensa
while ($reg_sub = mysqli_fetch_array($rs_sub)) {
  $subcateg = $reg_sub["subcateg"];
  $total_cat = $reg_sub["total_cat"];

  // Carrega a lista suspensa com as demais opções retornadas pelo SELECT acumulando o resultado na variavel $combo
  $combo .= "<option value='" . $subcateg . "'>" . $subcateg . " (" . $total_cat . ")</option><br>";
}
mysqli_free_result($rs_sub);
?>

<form id="form2" name="form2" method="post" action="pesquisa.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="20%" align="left"><a href="index.php"><img src="imagens/logo_fs.gif" alt="Faça um Site" width="180" height="50" border="0" /></a></td>
      <td width="67%">
        <div align="right">
          <a href="pedidos.php" class="link_cadastro">Meus Pedidos</a>
          <a href="login_novo.php?cadastro=S" class="link_cadastro">Meu Cadastro</a>
          <a href="cesta.php" class="link_carrinho">Meu Carrinho
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
          <img src="imagens/marcador_lupa.gif" width="11" height="11" align="absmiddle" />
        </div>
      </td>
      <td width="11%">
        <div align="right">

          <!-- Carrega a lista suspensa com os valores armazenados na variável $combo -->
          <select name="sub">
            <?PHP print $combo; ?>
          </select>
        </div>
      </td>
      <td width="2%"><input name="imageField" type="image" src="imagens/btn_ok.gif" alt="Executar pesquisa" /></td>
    </tr>
  </table>
</form>