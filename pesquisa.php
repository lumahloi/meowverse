<?PHP
// +---------------------------------------------------------+
// | Pesquisa por subcategoria                              |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
include "inc_dbConexao.php";
SESSION_START();
// Recupera a subcategoria escolhida em inc_menu_superior.php (método POST)
if ($_POST['sub'] <> "") {
	$sub = $_POST['sub'];
}

// Recupera a subcategoria passada pelos links da ordenação [Menor valor,Maior Valor] desta página (Metodo GET)
if ($_GET['sub'] <> "") {
	$sub = $_GET['sub'];
}

// Ordena o modo de ordenação usando o método GET (link menor preço e maior preço)
$ordenar = $_GET['ordenar'];
if ($ordenar == "") {
	$ordenar = "preco DESC";
} else {
	$ordenar = $_GET['ordenar'];
}

// Seleciona os registros pela subcategeoria escolhida
$sql = "SELECT * FROM miniaturas ";
$sql .= "WHERE subcateg = '" . $sub . "' ";
$sql .= "ORDER BY " . $ordenar;
$rs = mysqli_query($conexao, $sql);
$total_registros = mysqli_num_rows($rs);

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
		
		<div class="container mt-3 mb-3">
			<div class="row">
				<div class="col">
					<h4 class="mt-2"><?PHP print $sub; ?> Total de itens encontrados: <?PHP print $total_registros; ?></h4>
				</div>
			</div>

			<div class="row row-cols-3 text-center">
				<div class="col">
					<p>Ordenar por:</p>
				</div>
				<?PHP if ($ordenar == "preco ASC") { ?>
					<div class="col">
						<p>Menor preço</p>
					</div>
					<div class="col">
						<a href="pesquisa.php?ordenar=preco DESC&sub=<?PHP print $sub; ?>">Maior preço</a>
					</div>
				<?PHP } else { ?>
					<div class="col">
						<a href="pesquisa.php?ordenar=preco ASC&sub=<?PHP print $sub; ?>">Menor preço</a>
					</div>
					<div class="col">
						<p>Maior preço</p>
					</div>
				<?PHP } ?>
			</div> <!-- row ordenar -->


			<div class="container">
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
									<div class="row">
										<div class="col-md-9 text-center">
											<a href="detalhes.php?produto=<?PHP print $codigo; ?>"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Mais detalhes</button></a>
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
						<div class="row row-cols-2">
							<div class="col">
									<div class="row">
										<a href="#"><img src="imagens/<?PHP print $codigo; ?>.jpg" class="img-fluid"onclick="ampliar_imagem('ampliar.php?codigo=<?PHP print $codigo; ?>&nome=<?PHP print $nome; ?>','','width=522,height=338,top=50,left=50')" /></a>
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
								<div class="row">
								<div class="col-md-9 text-center">
											<a href="detalhes.php?produto=<?PHP print $codigo; ?>"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Mais detalhes</button></a>
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

			</div> <!-- container itens-->

		</div> <!-- container conteudo-->
		
		<?PHP include "inc_rodape.php" ?>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</div> <!-- container pagina-->
</body>
</html>
<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>

