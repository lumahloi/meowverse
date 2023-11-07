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

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

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
    <title>Meowverse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script type='text/javascript' src="js/jquery.autocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
		<img src="imagens/deco_<?PHP print $cat_id; ?>.png"/>
	</div>

	<div class="row row-cols-2">
			<div class="col-6">
				<p>Total de itens nesta categoria: <?PHP print $total_registros; ?></p>
			</div>
			<div class="col-6">
				<div class="row row-cols-3 text-end gx-0">
					<div class="col-6">
						<p>Ordenar por:</p>
					</div>
			
			<?PHP if ($ordenar == "preco ASC") { ?>
				<div class="col-3">
					<p style="font-weight: bold; color: purple">Menor preço</p>
				</div>
				<div class="col-3">
					<a href="categorias.php?cat_id=<?php echo $cat_id ?>&ordenar=preco DESC" style="text-decoration:none" class="link-secondary">Maior preço</a>
				</div>
			<?PHP } else { ?>
				<div class="col-3">
					<a href="categorias.php?cat_id=<?php echo $cat_id ?>&ordenar=preco ASC" style="text-decoration:none" class="link-secondary">Menor preço</a>
				</div>
				<div class="col-3">
					<p style="font-weight: bold; color: purple">Maior preço</p>
				</div>
			<?PHP } ?>
				</div>
			</div>
		</div>

	<!-- exibição dos itens -->
	<div class="container mt-3 border bg-light">

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
			
			<div class="container-fluid">
				<div class="row row-cols-2">
					<div class="col-md-6 col-12 p-3 mt-3 mb-3">
							<div class="row row-cols-2">
								<div class="col">
									<div class="row">
										<a href="#"><img src="imagens/<?PHP print $codigo; ?>.jpg" class="img-fluid" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a>
									</div>
									<div class="row">
										<p class="text-muted small text-center">Clique na imagem para ampliar</p>
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
									<?php 
									if($estoque < $min_estoque){
									?>
										<div class="row row-cols-2 text-center">
											<div class="col-6">
												<a href="detalhes.php?produto=<?PHP print $codigo; ?>"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Mais detalhes</button></a>
											</div>
											<div class="col-6">
												<button class="btn btn-danger">Indisponível</button>
											</div>
										</div>
									<?php
									} else { 
									?>
										<div class="row text-center">
												<div class="col">
													<a href="detalhes.php?produto=<?PHP print $codigo; ?>"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Mais detalhes</button></a>
												</div>
										</div>
									<?php 
									} 
									?>
								</div> <!-- fecha col conteudo  -->
							</div>
					</div> <!-- fecha coluna esquerda -->

			
		
				<?PHP
			// Exibe dados da coluna direita 
			} else { 
				?>
					<div class="col-md-6 col-12 p-3 mx-auto mt-3 mb-3">
						<div class="row row-cols-2">
							<div class="col">
									<div class="row">
										<a href="#"><img src="imagens/<?PHP print $codigo; ?>.jpg" class="img-fluid" onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a>
									</div>
									<div class="row">
										<p class="text-muted small text-center">Clique na imagem para ampliar</p>
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
								<?php 
									if($estoque < $min_estoque){
									?>
										<div class="row row-cols-2 text-center">
											<div class="col-6">
												<a href="detalhes.php?produto=<?PHP print $codigo; ?>"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Mais detalhes</button></a>
											</div>
											<div class="col-6">
												<button class="btn btn-danger">Indisponível</button>
											</div>
										</div>
									<?php
									} else { 
									?>
										<div class="row text-center">
												<div class="col">
													<a href="detalhes.php?produto=<?PHP print $codigo; ?>"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Mais detalhes</button></a>
												</div>
										</div>
									<?php 
									} 
									?>
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
		
	<?PHP include "inc_rodape.php" ?>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	</div>
</body>
</html>