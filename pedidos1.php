<?PHP
// +---------------------------------------------------------+
// | Pedidos - Verifica e-mail, senha e exibe pedidos        |
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
// Inicializa variáver de erro
$erro = "0";

// Recupera e-mail e senha
if ($_POST['txtemail'] <> "") {
$email = $_POST['txtemail'];
$senha = $_POST['txtsenha'];
}

// Verifica se o e-mail do cliente já está cadastrado
$sql = "SELECT * ";
$sql .= " FROM cadcli ";
$sql .= " WHERE email = '" . $email . "' ";

$rs = mysqli_query($conexao, $sql);
$total_registros = mysqli_num_rows($rs);
if ($total_registros == 0) {
$mensagem_erro = "Email não cadastrado";
$erro = "1";
}

// Verifica senha
if ($erro == "0") {
	$sql = " SELECT * ";
	$sql .= " FROM cadcli ";
	$sql .= " WHERE senha = '" . $senha . "' ";
	
	$rs = mysqli_query($conexao, $sql);
	$reg = mysqli_fetch_array($rs);
	$total_registros = mysqli_num_rows($rs);
	if ($total_registros == 0) {
		$mensagem_erro = "Senha inválida.";
		$erro = "2";
	}
}

// Recupera dados do cadastro de clientes
if ($erro == "0") {
	$sql = " SELECT * ";
	$sql .= " FROM cadcli ";
	$sql .= " WHERE email = '" . $email . "' ";
	$sql .= " AND senha = '" . $senha . "' ";

	$rs = mysqli_query($conexao, $sql);
	$reg = mysqli_fetch_array($rs);

	// Armazena dados do cliente para as próximas páginas
	$_SESSION['email_cli'] = $reg['email'];
	$_SESSION['nome'] = $reg['nome'];
	$_SESSION['id'] = $reg['id'];	
	
	// Captura dados do pedido
	$sql = " SELECT * ";
	$sql .= " FROM pedidos ";
	$sql .= " WHERE id_cliente = '" . $_SESSION['id'] . "' ";
	$sql .= " ORDER BY id ";

	//echo $sql;
	//exit;
	$rs = mysqli_query($conexao, $sql);
	$total_registros = mysqli_num_rows($rs);
	
	// Carrega dados do cliente
	$sql = " SELECT * ";
	$sql .= " FROM cadcli ";
	$sql .= " WHERE id = '" . $_SESSION['id'] . "' ";

	//echo $sql;
	//exit;
	$rs1 = mysqli_query($conexao, $sql);
	$reg1 = mysqli_fetch_array($rs1);
	
	// Armazena dados do cliente para as próximas páginas
	$_SESSION['email_cli'] = $reg1['email'];
	$_SESSION['nome_cli'] = $reg1['nome'];
	$_SESSION['end_nome'] = $reg1['end_nome'];
	$_SESSION['end_num'] = $reg1['end_num'];
	$_SESSION['end_comp'] = $reg1['end_comp'];
	$_SESSION['cep'] = $reg1['cep'];
	$_SESSION['bairro'] = $reg1['bairro'];
	$_SESSION['cidade'] = $reg1['cidade'];
	$_SESSION['uf'] = $reg1['uf'];
	$_SESSION['id'] = $reg1['id'];
}

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
<body>
	<div class="container">
	
		<?PHP include "inc_menu_superior.php" ?>
		<?PHP include "inc_menu_categorias.php" ?>
		
		<!-- Título -->
		<?PHP if ($erro == 0) { ?>
			<h2 class="mt-5">Meus Pedidos</h2>
			<?PHP if ($total_registros <> 0) { ?>
				<!-- Exibe os itens do pedido -->
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td width="20%" class="caixa_cesta_tit"></td>
				<td width="11%" class="caixa_cesta_tit">N° Pedido</td>
				<td width="21%" class="caixa_cesta_tit">Data do pedido </td>
				<td width="13%" class="caixa_cesta_tit">Vencimento</td>
				<td width="22%" class="caixa_cesta_tit">Status</td>
				<td width="13%" class="caixa_cesta_tit"><div align="right">Valor</div></td>
				</tr>
			
				<?PHP
				while ($reg = mysqli_fetch_array($rs)) {
					$num_ped = $reg["num_ped"];
					$data = $reg["data"];
					$hora = $reg["hora"];
					$valor = $reg["valor"];
					$status = $reg["status"];
					$vencimento = $reg["vencimento"];
					$frete = $reg['frete'];
					$desconto = $reg['desconto'];
					?>
				
					<tr>
					<td class="caixa_pedido_item"><a href="detalhe_ped.php?det_ped=<?PHP print $num_ped; ?>"><button class="btn btn-secondary">Detalhar esse pedido</button></a> </td>
					<td class="caixa_pedido_item"><?PHP print $num_ped; ?></td>
					<td class="caixa_pedido_item"><?PHP print substr($data,8,2) . " / " . substr($data,5,2) . " / " . substr($data,0,4) . "&nbsp;&nbsp;&nbsp;&nbsp;" . $hora; ?> </td>
					<td class="caixa_pedido_item"><?PHP print substr($vencimento,8,2) . " / " . substr($vencimento,5,2) . " / " . substr($vencimento,0,4); ?></td>
					<td class="caixa_pedido_item"><?PHP print $status; ?></td>
					<td class="caixa_pedido_item"><div align="right">R$ <?PHP print number_format(($valor + $frete - $desconto),2,',','.'); ?></div></td>
					</tr>
				
					<?PHP
				}
				?>
				</table>
			
				<!-- total de registros end if -->

			<?PHP  } else { ?>
			
				<div class="container mt-3 mb-3 p-3 text-center bg-light border">
					<div class="row">
						<div class="col">
							<h4>Você não efetuou nenhuma compra em nosso site</h4>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<a href="index.php" class="btn btn-success" role="button" aria-pressed="true" style="background-color: purple; border-color: purple;">Voltar à loja</a>
						</div>
					</div>
				</div>
			<?PHP } ?>

		<?PHP } else { ?>
			<h2 class="mt-5">Meus Pedidos</h2>
			
			<?PHP if ($erro == 1) { ?>
				<div class="container mt-3 mb-3 p-3 text-center bg-light border">
					<div class="row">
						<h4><?PHP print $mensagem_erro; ?></h4>
						<div class="col">
							<a href="index.php" class="btn btn-success" role="button" aria-pressed="true" style="background-color: purple; border-color: purple;">Voltar à loja</a>
						</div>
					</div>
				</div>
			<?PHP } ?>
			<?PHP if ($erro == 2) { ?>
				<div class="container mt-3 mb-3 p-3 text-center bg-light border">
					<div class="row">
						<h4><?PHP print $mensagem_erro; ?></h4>
						<div class="col">
							<a href="index.php" class="btn btn-success" role="button" aria-pressed="true" style="background-color: purple; border-color: purple;">Voltar à loja</a>
						</div>
					</div>
				</div>
			<?PHP } ?>
			
		<?PHP } ?>
		<?PHP include "inc_rodape.php" ?>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	</div>

</body>
</html>
<?PHP
mysqli_free_result($rs);
mysqli_close ($conexao);
?>