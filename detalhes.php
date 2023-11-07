<?PHP
// +---------------------------------------------------------+
// | Detalhes da miniatura                                   |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


// Recupera o produto (método POST) passado por index.php, categorias.php e pesquisa.php

$produto = $_GET['produto'];

$sql = " SELECT categorias.cat_nome, miniaturas.* FROM categorias ";
$sql .= "INNER JOIN miniaturas ";
$sql .= "ON categorias.id = miniaturas.id_categoria ";
$sql .= "WHERE miniaturas.codigo = '" . $produto . "' ";

//echo $mysqli;
//exit;
$rs = mysqli_query($conexao,$sql);
$reg = mysqli_fetch_array($rs);

// Carrega as variaveis com os valores dos campos
$codigo = $reg["codigo"];
$nome = $reg["nome"];
$ano = $reg["ano"];
$nome_cat = $reg["nome_cat"];
$cat_sub = $reg["cat_sub"];
$preco = $reg["preco"];
$desconto = $reg["desconto"];
$desconto_boleto = $reg["desconto_boleto"];
$max_parcelas = $reg["max_parcelas"];
$escala = $reg["escala"];
$peso = $reg["peso"];
$comprimento = $reg["comprimento"];
$largura = $reg["largura"];
$altura = $reg["altura"];
$cor = $reg["cor"];
$estoque = $reg["estoque"];
$min_estoque = $reg["min_estoque"];
$credito = $reg["credito"];

$subcategoria = $reg["subcateg"];
$altura = $reg["altura"];
$fabrica = $reg["fabrica"];
$descricao = $reg["descricao"];
// Armazena em $valor_boleto o valor a ser pago com desconto por intermédio do cartão de credito
$valor_desconto = $preco - ($preco * $desconto / 100);
// Armazena em $valor_boleto o valor a ser pago com desconto por intermédio de boleto bancário
$valor_boleto = $valor_desconto - ($valor_desconto * $desconto_boleto / 100);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meowverse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script type='text/javascript' src="js/jquery.autocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<script type="text/JavaScript">
		<!--
// Função para abertura da janela de imagens ampliadas
function ampliar_imagem(url,nome_janela,parametros) { 
  window.open(url,nome_janela,parametros);
}
//-->
	</script>
</head>

<body>
	<div class="container">
		
		<?PHP include "inc_menu_superior.php" ?>
		<?PHP include "inc_menu_categorias.php" ?>
		
		<!-- Título da página (exibe o nome da categoria) -->
		<h3 class="mt-4 mb-4"><span class="c_cinza">Detalhes <?PHP print $nome_cat; ?></span> <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_preto"><?PHP print $nome; ?></span></h3>

		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="row">
						<a href="#"><img src="imagens/<?PHP print $codigo; ?>.jpg" class="img-fluid" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a>
					</div>
					<div class="row">
						<p class="text-muted small text-center">Clique na imagem para ampliar</p>
					</div>
					<div class="row">
						<h4 class="mt-2 mb-2">Dados técnicos</h4>
					</div>
					<div class="row p-3">
						<table class="table">
							<tr><td class="p-0"><p>Subcategoria:</p></td><td class="p-0"><p><?PHP print $subcategoria; ?></p></td></tr>
							<tr><td class="p-0"><p>Altura:</p></td><td class="p-0"><p><?PHP print $altura; ?></p></td></tr>
							<tr><td class="p-0"><p>Fábrica:</p></td><td class="p-0"><p><?PHP print $fabrica; ?></p></td></tr>
						</table>
					</div>
				</div> <!-- col esquerda-->

				<div class="col-md-9">
				<div class="container">
					<div class="row">

						<div class="col">
							<div class="row">
								<p class="text-decoration-line-through" style="color: gray;">de: R$ <span style="font-weight: bold;"><?PHP print number_format($preco, 2, ',', '.'); ?></span></p>
							</div>
							<div class="row">
								<p class="h4">Por: <span style="font-weight: bold; color: green"> R$ <?PHP print number_format($valor_desconto, 2, ',', '.'); ?></span> </p>
							</div>
						</div>

						<?PHP if ($estoque >= $min_estoque) { ?>
							<div class="col-md-4 text-end">
								<a href="cesta.php?produto=<?PHP print $codigo; ?>&inserir=S"><button class="btn btn-success btn-lg" style="background-color: purple; border-color: purple;">Comprar</button></a>
							</div>
						<?PHP } else { ?>
							<div class="col-md-4 text-end">
								<button class="btn btn-danger">Não disponível em estoque</button>
							</div>
						<?PHP } ?>
					</div>

					<div class="row">

						<p class="mb-4 mt-4"><?php echo $descricao; ?></p>

						<?PHP if ($max_parcelas >= $_SESSION['max_parcelas']) {
							$_SESSION['max_parcelas'] = $max_parcelas;
						} ?>

						<table class="table table-borderless table-striped table-sm">
							<thead>
								<th colspan="2" scope="col">Parcelamento no cartão de crédito</th>
							</thead>
							<tbody>
								<?PHP for ($contador = 1; $contador <= $max_parcelas; $contador++) { ?>
									<?PHP if ($contador % 2 == 1) { ?>
								<tr class="w-50">
									<td>
										<p class="small"><?PHP print $contador; ?> x de R$ <?PHP print number_format($valor_desconto / $contador, 2, ',', '.'); ?> sem juros</p>
									</td>
								<?PHP } else { ?>
									<td>
										<p class="small"><?PHP print $contador; ?> x de R$ <?PHP print number_format($valor_desconto / $contador, 2, ',', '.'); ?> sem juros</p>
									</td>
								</tr>
								<?PHP
								} // Encerra o Else
						}   // Encerra o for
						?>
							</tbody>
						</table>
					</div>

					
						<div class="row">
							<div class="col">
								<p>* Pague com Boleto Bancário e ganhe + <?PHP print number_format(($desconto_boleto), 0, ',', '.'); ?>% de desconto: <br><span style="font-weight: bold; color: green;">R$ <?PHP print number_format(($valor_boleto), 2, ',', '.'); ?></span></p>
							</div>
							<div class="col">
								<p>* Este produto pode ser pago com cartão de crédito em até <?PHP print $max_parcelas; ?> parcelas.</p>
								
							</div>
						</div>

					<div class="row mb-3 mt-4">	
						<div class="col">
							<p style="font-weight: bold">Formas de pagamento</p>
							<img src="imagens/banner_formapag.gif" alt="formas de pagamento" width="297" height="23" vspace="5" />
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="row">
								<p style="font-weight: bold">Prazos de entrega</p>
							</div>
							<div class="row">
								<p>2 dias úteis para o estado de São Paulo.</p>
								<p>5 dias úteis para os demais estados.</p>
							</div>
						</div>
					</div>

					<div class="row">
						<p style="font-weight: bold">Observações</p>
						<p>As mercadorias adquiridas serão despachadas, via Sedex(Sedex ou e_Sedex), no primeiro dia útil após a comprovação de pagamento, estando a entrega condicionada à disponibilidade de estoque. Prazo médio de entrega dos Correios: 24 a 72 horas.</p>
					</div>
				
				</div>
				</div> <!-- col direita-->
			</div>
		</div>
		<?PHP include "inc_rodape.php" ?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>