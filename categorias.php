<?PHP
// +---------------------------------------------------------+
// | Exibição das miniaturas por categoria                   |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "inc_dbConexao.php";
SESSION_START();

// Recupera id da categoria, nome da categoria e modo de ordenação e modo de ordenação pelo método GET

// Passados pelo inc_menu_sup e os links Menor Preço e Maior preço desta página
$cat_id		=	 $_GET['cat_id'];
$cat_nome	= 	$_GET['cat_nome'];
$ordenar	= 	$_GET['ordenar'];

// Seleciona miniaturas pelo id de categoria
$sql	 			= 	"SELECT * FROM miniaturas ";
$sql				.= 	"WHERE id_categoria = '" . $cat_id . "' ";
$sql				.= 	"ORDER BY " . $ordenar;
//echo $sql;
//exit;

$rs 				=	 mysqli_query($conexao, $sql);
$total_registros	= mysqli_num_rows($rs);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça um Site - PHP 5 com Banco de Dados MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
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

	<div class="row">
		<img src="imagens/deco_<?PHP print $cat_id; ?>.jpg"/>
	</div>

	<div class="row row-cols-2 mt-3 justify-content-between">
		<div class="col-md-6">
			<p><?PHP print $cat_nome; ?> <span class="c_cinza">Total de itens nesta categoria: <?PHP print $total_registros; ?></span></p>
		</div>

		<div class="row row-cols-3">
			<div class="col">
				<p>Ordenar por:</p>
			</div>
			
			<?PHP if ($ordenar == "preco ASC") { ?>
				<div class="col">
					<p>Menor preço</p>
				</div>
				<div class="col">
					<a href="categorias.php?cat_id=<?PHP print $cat_id; ?>&cat_nome=<?PHP print $cat_nome; ?>&ordenar=preco DESC">Maior preço</a>
				</div>
			<?PHP } else { ?>
				<div class="col">
					<a href="categorias.php?cat_id=<?PHP print $cat_id; ?>&cat_nome=<?PHP print $cat_nome; ?>&ordenar=preco ASC">Menor preço</a>
				</div>
				<div class="col">
					<p>Maior preço</p>
				</div>
			<?PHP } ?>
		</div>
	</div>

	<!-- exibição dos itens -->
	<div class="container mt-3">

		<?PHP
		for($contador=0; $contador < $total_registros; $contador++) {
			$reg = mysqli_fetch_array($rs); 
			$codigo = $reg["codigo"];
			$nome = $reg["nome"];
			$estoque = $reg["estoque"];
			$min_estoque = $reg["min_estoque"];
			$preco = $reg["preco"];
			$desconto = $reg["desconto"];
			$credito = $reg["credito"];
			$valor_desconto = $preco - ($preco * $desconto / 100);

			
						
			// Exibe dados da coluna esquerda 
			if ($contador % 2 == 0) {
			?>
			
			<div class="container-fluid bg-light border">
				<div class="row row-cols-2">
					<div class="col-sm-5 p-3 mt-3 mb-3">
							<div class="row row-cols-2">
								<div class="col">
									<div class="row">
										<a href="#"><img src="imagens/<?PHP print $codigo; ?>.jpg" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a>
									</div>
									<div class="row">
										<p class="text-muted">Clique na imagem para ampliar</p>
									</div>
									<div class="row">
										<p class="fw-lighter text-muted fs-6">crédito da imagem: <?PHP print $credito; ?></p>
									</div>
								</div> <!-- fecha col imagem -->
								<div class="col">
									<div class="row">
										<h5><?PHP print $nome; ?></h5>
									</div>
									<div class="row">
										<p class="text-decoration-line-through">de: R$ <?PHP print number_format($preco,2,',','.'); ?></p>
									</div>
									<div class="row">
										<p>Por: <span class="fw-bold">R$ <?PHP print number_format($valor_desconto,2,',','.'); ?></span> à vista</p>
									</div>
									<div class="row">
										<div class="col">
											<p class="fw-bold"><a href="detalhes.php?produto=<?PHP print $codigo; ?>" class="text-decoration-none mais-detalhes">Mais detalhes</a></p>
										</div>
										<div class="col">
											<p class="text-danger"><?PHP if ($estoque < $min_estoque) { ?>Indisponível<?PHP } ?></p>
										</div>
									</div>
								</div> <!-- fecha col conteudo  -->
							</div>
					</div> <!-- fecha coluna esquerda -->

			
		
				<?PHP
			// Exibe dados da coluna direita 
			} else { 
				?>
					<div class="col-sm-5 p-3 mx-auto mt-3 mb-3">
						<div class="row">
							<div class="col">
									<div class="row row-cols-2">
										<a href="#"><img src="imagens/<?PHP print $codigo; ?>.jpg" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a>
									</div>
									<div class="row">
										<p class="text-muted">Clique na imagem para ampliar</p>
									</div>
									<div class="row">
										<p class="fw-lighter text-muted fs-6">crédito da imagem: <?PHP print $credito; ?></p>
									</div>
							</div> <!-- fecha col imagem -->
							<div class="col">
								<div class="row">
									<h5><?PHP print $nome; ?></h5>
								</div>
								<div class="row">
									<p class="text-decoration-line-through">de: R$ <?PHP print number_format($preco,2,',','.'); ?></p>
								</div>
								<div class="row">
									<p>Por: <span class="fw-bold">R$ <?PHP print number_format($valor_desconto,2,',','.'); ?></span> à vista</p>
								</div>
								<div class="row">
									<div class="col">
										<p class="fw-bold"><a href="detalhes.php?produto=<?PHP print $codigo; ?>" class="text-decoration-none mais-detalhes">Mais detalhes</a></p>
									</div>
									<div class="col">
										<p class="text-danger"><?PHP if ($estoque < $min_estoque) { ?>Indisponível<?PHP } ?></p>
									</div>
								</div>
							</div> <!-- fecha col conteudo -->
						</div>
					</div> <!-- fecha coluna direita -->
			
				</div> <!-- fecha row -->
			</div> <!-- fecha container -->

				<?PHP
			} // Encerra o Else
		}   // Encerra o for
		?>
	</div> <!-- fecha container -->
		
	

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
	</div>
</body>
</html>