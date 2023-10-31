<?PHP
// +---------------------------------------------------------+
// | Inclusão, alteração e visualização do cadastro          |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";

if ($_SESSION['acao'] <> "ver") {
	// Captura os dados do formulário
	$txtnome = $_POST['txtnome'];
	$txtcpf = $_POST['txtcpf'];
	$txtrg = $_POST['txtrg'];
	$txtsexo = $_POST['txtsexo'];
	$txtemail = $_POST['txtemail_1'];
	$txtsenha = $_POST['txtsenha_1'];
	$txtend_nome = $_POST['txtend_nome'];
	$txtend_num = $_POST['txtend_num'];
	$txtend_comp = $_POST['txtend_comp'];
	$txtcep = $_POST['txtcep'];
	$txtbairro = $_POST['txtbairro'];
	$txtcidade = $_POST['txtcidade'];
	$txtuf = $_POST['txtuf'];

	// Atualiza variáveis de sessão
	$_SESSION['id_cli'] = $reg['id'];
	$_SESSION['nome_cli'] = $txtnome;
	$_SESSION['cpf'] = $txtcpf;
	$_SESSION['rg'] = $txtrg;
	$_SESSION['sexo'] = $txtsexo;
	$_SESSION['email_cli'] = $txtemail;
	$_SESSION['senha'] = $txtsenha;
	$_SESSION['end nome'] = $txtend_nome;
	$_SESSION['end_num'] = $txtend_num;
	$_SESSION['end_comp'] = $txtend_comp;
	$_SESSION['cep'] = $txtcep;
	$_SESSION['bairro'] = $txtbairro;
	$_SESSION['cidade'] = $txtcidade;
	$_SESSION['uf'] = $txtuf;
}

if ($_SESSION['acao'] == "inc") {
	// Insere registro
	$sql = "INSERT INTO cadcli ";
	$sql = $sql . " (nome, cpf, rg, sexo, email, senha, end_nome, end_num, end_comp, cep, bairro, cidade, uf) ";
	$sql = $sql . "VALUES ('$txtnome', '$txtcpf', '$txtrg', '$txtsexo', '$txtemail','$txtsenha', '$txtend_nome', '$txtend_num', '$txtend_comp', '$txtcep', '$txtbairro','$txtcidade', '$txtuf') ";

	//echo $sql;
	//exit;
	mysqli_query($conexao, $sql);

	// recupera dados com base no CPF
	$sql = "SELECT * FROM cadcli";
	$sql .= " WHERE cpf = '" . $_SESSION['cpf'] . "' ";

	//echo $sql;
	//exit;
	$rs = mysqli_query($conexao, $sql);
	$reg = mysqli_fetch_array($rs);
	// Armazena dados do cliente nas variáveis de sessão para serem usados nas próximas páginas
	$_SESSION['id_cli'] = $reg['id'];
	$_SESSION['email_cli'] = $reg['email'];
	$_SESSION['nome_cli'] = $reg['nome'];
	$_SESSION['cpf'] = $reg['cpf'];
	$_SESSION['rg'] = $reg['rg'];
	$_SESSION['sexo'] = $reg['sexo'];
	$_SESSION['senha'] = $reg['senha'];
	$_SESSION['end_nome'] = $reg['end_nome'];
	$_SESSION['end_num'] = $reg['end_num'];
	$_SESSION['end_comp'] = $reg['end_comp'];
	$_SESSION['cep'] = $reg['cep'];
	$_SESSION['bairro'] = $reg['bairro'];
	$_SESSION['cidade'] = $reg['cidade'];
	$_SESSION['uf'] = $reg['uf'];
}

if ($_SESSION['acao'] == 'alt') {
	//Altera registro
	$sql = "UPDATE cadcli SET ";
	$sql = $sql . "nome = '$txtnome', ";
	$sql = $sql . "cpf = '$txtcpf', ";
	$sql = $sql . "rg = '$txtrg', ";
	$sql = $sql . "sexo = '$txtsexo', ";
	$sql = $sql . "email = '$txtemail', ";
	$sql = $sql . "senha = '$txtsenha', ";
	$sql = $sql . "end_nome = '$txtend_nome', ";
	$sql = $sql . "end_num = '$txtend_num', ";
	$sql = $sql . "end_comp = '$txtend_comp', ";
	$sql = $sql . "cep = '$txtcep', ";
	$sql = $sql . "bairro = '$txtbairro', ";
	$sql = $sql . "cidade = '$txtcidade', ";
	$sql = $sql . "uf = '$txtuf' ";
	$sql = $sql . " WHERE id = '" . $_SESSION['id_cli'] . "' ";

	//echo $sql;
	//exit;
	mysqli_query($conexao, $sql);
}

// Inicializa variáveis de mensagem e título da página
$mensagem = "";
$titulo_2 = "Informações Cadastrais";

// Mensagem e titulo para alteração de dados
if ($_SESSION['acao'] = "alt") {
	$mensagem = "* Sua alteração cadastral foi concluida com sucesso.";
	$titulo_2 = "Alteração";
}
// Mensagem e titulo para inclusão de dados 
if ($_SESSION['acao'] == "ins") {
	$mensagem = "* Seu cadastro foi concluído com sucesso";
	$titulo_2 = "Inclusão";
}


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

<body>
	<div class="container">
		<!-- Se clicado no botão Meu cadastro do menu superior -->
		
			<?PHP include "inc_menu_superior.php" ?>
			<?PHP include "inc_menu_categorias.php" ?>
			<!-- Se a página for chamada por intermédio do botão "Fechar pedido" do carrinho de compras -->
			<!-- Não exibe menu superior e menu de categorias. Neste caso, exibe o banner da primeira etapa de uma compra (1. Minha identificação) -->
			<?PHP $titulo_1 = "Meu Cadastro"; ?>
		
		<?PHP if($_POST ['cadastro'] != "S") {?>
			<?PHP $titulo_1 = "Etapa 2"; ?>
			<?PHP $titulo_2 = "Endereço de Entrega - Dados Pessoais"; ?>
			
		<?PHP } ?>

		<!-- Título da página -->
		<h3 class="mt-3"><?PHP print $titulo_1; ?> <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_cinza"><?PHP print $titulo_2; ?> </span> </h3>

		<div class="container border mt-4">
			<div class="row row-cols-2">
				<div class="col">
					<table class="table table-borderless">
						<thead>
							<tr>
								<th colspan="2" class="text-center">Dados pessoais</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><label>Nome:</label></td>
								<td><p><?PHP print $_SESSION['nome_cli']; ?></p></td>
							</tr>
							<tr>
								<td><label>CPF:</label></td>
								<td><p><?PHP print substr($_SESSION['cpf'], 0, 3) . "." . substr($_SESSION['cpf'], 3, 3) . "." . substr($_SESSION['cpf'], 6, 3) . "-" . substr($_SESSION['cpf'], 9, 2); ?></p></td>
							</tr>
							<tr>
								<td><label>RG:</label></td>
								<td><p><?PHP print number_format($_SESSION['rg'], 0, '', '.'); ?></p></td>
							</tr>
							<tr>
								<td><label>Sexo:</label></td>
								<td><p><?PHP print $_SESSION['sexo']; ?></p></td>
							</tr>
							<tr>
								<td><label>E-mail:</label></td>
								<td><p><?PHP print $_SESSION['email_cli']; ?></p></td>
							</tr>
							<tr>
								<td><label>Senha:</label></td>
								<td><p><?PHP print $_SESSION['senha']; ?></p></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="col">
					<table class="table table-borderless">
						<thead>
							<tr>
								<th colspan="2" class="text-center">Endereço de entrega</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><label>Endereço:</label></td>
								<td><p><?PHP print $_SESSION['end_nome']; ?></p></td>
							</tr>
							<tr>
								<td><label>Número:</label></td>
								<td><p><?PHP print number_format($_SESSION['end_num'], 0, '', '.'); ?></p></td>
							</tr>
							<tr>
								<td><label>Complemento:</label></td>
								<td><p><?PHP print $_SESSION['end_comp']; ?></p></td>
							</tr>
							<tr>
								<td><label>CEP:</label></td>
								<td><p><?PHP print substr($_SESSION['cep'], 0, 5) . "-" . substr($_SESSION['cep'], 5, 3); ?></p></td>
							</tr>
							<tr>
								<td><label>Bairro:</label></td>
								<td><p><?PHP print $_SESSION['bairro']; ?></p></td>
							</tr>
							<tr>
								<td><label>Cidade:</label></td>
								<td><p><?PHP print $_SESSION['cidade']; ?></p></td>
							</tr>
							<tr>
								<td><label>Unidade Federativa:</label></td>
								<td><p><?PHP print $_SESSION['uf']; ?></p></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row row-cols-2 p-3">
				<div class="col">
					<p><?PHP print $mensagem; ?></p>
				</div>
				<div class="col text-end">
					<a href="cadastro.php"><button class="btn btn-secondary">Alterar dados</button></a>
					<?PHP if ($_SESSION['cadastro'] == "S") { ?>
								<a href="index.php"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Voltar à loja</button></a>
							<?PHP } else { ?>
								<a href="pagamento.php"><button class="btn btn-success" style="background-color: purple; border-color: purple;">Continuar</button></a>
					<?PHP } ?>
				</div>
			</div>
		</div>
		<!-- rodape da página -->
		<?PHP include "inc_rodape.php" ?>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</body>

</html>