<?PHP
// +---------------------------------------------------------+
// | Cadastro                                                |
// +---------------------------------------------------------+
// | Parte integrante do livro da sárie Faáa um Site         |
// | PHP 5 com banco de dados MySQL - Comárcio eletránico    |
// | Editora árica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+

SESSION_START();
include "inc_dbConexao.php";

if ($_POST['txtemail2'] <> "") {
	$txtemail2 = $_POST['txtemail2'];
	$_SESSION['acao'] = $_POST['acao'];
} else {
	$_SESSION['acao'] = "alt";
}

if ($_GET['txtemail2'] <> "") {
	$txtemail2 = $_POST['txtemail2'];
	$_SESSION['acao'] = "alt";
}

// INCLUSÃO DE NOVOS REGISTROS
// Verifica se o e-mail já está cadastro.
// Se o cliente estiver cadastrado $total_registros = 1; caso contrário será igual a 0.
if ($_SESSION['ACAO'] == "inc") {
	$sql = "SELECT email";
	$sql .= "FROM cadcli";
	$sql .= "WHERE email = '" . $txtemail2 . "' ";
	$rs = mysqli_query($conexao, $sql);
	$total_registros = mysqli_num_rows($rs);

	// Inicializa valores
	$txtnome = "";
	$txtcpf = "";
	$txtrg = "";
	$txtsexo = "0";
	$txtemail_1 = $_POST['txtemail2'];
	$txtsenha_1 = "";
	$txtsenha_2 = "";
	$txtend_nome = "";
	$txtend_num = "";
	$txtend_comp = "";
	$txtcep = "";
	$txtbairro = "";
	$txtcidade = "";
	$txtuf = "";

	// Titulo da página
	$titulo_2 = "Inclusão";
}

// ALTERAÇÃO DE REGISTROS
// Recupera registro (campos armazenados nas variáveis de sessão
if ($_SESSION['acao'] == "alt") {
	// Inicializa valores
	$txtnome = $_SESSION['nome_cli'];
	$txtcpf = $_SESSION['cpf'];
	$txtrg = $_SESSION['rg'];
	$txtsexo = $_SESSION['sexo'];
	$txtemail_1 = $_SESSION['email_cli'];
	$txtemail_2 = $_SESSION['email_cli'];
	$txtsenha_1 = $_SESSION['senha'];
	$txtsenha_2 = $_SESSION['senha'];
	$txtend_nome = $_SESSION['end_nome'];
	$txtend_num = $_SESSION['end_num'];
	$txtend_comp = $_SESSION['end_comp'];
	$txtcep = $_SESSION['cep'];
	$txtbairro = $_SESSION['bairro'];
	$txtcidade = $_SESSION['cidade'];
	$txtuf = $_SESSION['uf'];

	//Titulo da página 
	$titulo_2 = "Alteração";
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
	<script language="javascript">
		function valida_form() {
			if (document.cadastro.txtnome.value == "") {
				alert("Por favor, informe seu nome completo.");
				cadastro.txtnome.focus();
				return false;
			}

			if (document.cadastro.txtcpf.value == "") {
				alert("Por favor, informe seu CPF.");
				cadastro.txtcpf.focus();
				return false;
			}

			if(document.cadastro.txtrg.value == "") {
				alert("Por favor, informe seu RG.");
				cadastro.txtrg.focus();
				return false;
			}

			function validarCPF(Objcpf) {
				var cpfUsuario = Objcpf.value;
				exp = /\.|\-/g;
				cpfUsuario = cpfUsuario.toString().replace(exp, "");
				var digitoDigitado = eval(cpfUsuario.charAt(9) + cpfUsuario.charAt(10));
				var soma1 = 0,
					soma2 = 0;
				var vlr = 11;

				for (i = 1; i <= 9; i++) {
					soma1 += eval(cpfUsuario.charAt(i) * (vlr - 1));
					soma2 += eval(cpfUsuario.charAt(i) * vlr);
					vlr--;
				}
				soma1 = (((soma1 * 10) % 11) === 10 ? 0 : ((soma1 * 10) % 11));
				soma2 = (((soma2 + (2 * soma1)) * 10) % 11);

				var digitoGerado = (soma1 * 10) + soma2;
				if (digitoGerado !== digitoDigitado) {
					alert('CPF Invalido!');
					Objcpf.value = '';
				} else if (digitoGerado === 00000000000) {
					alert('CPF Invalido!');
					Objcpf.value = '';
				}
			}

			if (document.cadastro.txtsexo.value == 0) {
				alert("Por favor, selecione seu sexo.");
				cadastro.txtsexo.focus();
				return false;
			}

			if (document.cadastro.txtemail_1.value == "") {
				alert("Por favor, confirme seu e-mail.");
				cadastro.txtemail_1.focus();
				return false;
			}

			if (document.cadastro.txtemail_2.value == "") {
				alert("Por favor, confirme seu e-mail.");
				cadastro.txtemail_2.focus();
				return false;
			}

			if (document.cadastro.txtemail_1.value != document.cadastro.txtemail_2.value) {
				alert("O campo e-mail não confere com sua confirmação.");
				cadastro.txtemail_1.value = "";
				cadastro.txtemail_2.value = "";
				cadastro.txtemail_1.focus();
				return false;
			}

			if (document.cadastro.txtsenha_1.value.length < 5) {
				alert("O campo senha deve conter 5 ou mais caracteres.");
				cadastro.txtsenha_1.focus();
				return false;
			}

			if (document.cadastro.txtsenha_2.value.length < 5) {
				alert("O campo de confirmação da senha deve conter 5 ou mais caracteres.");
				cadastro.txtsenha_2.focus();
				return false;
			}

			if (document.cadastro.txtsenha_1.value != document.cadastro.txtsenha_2.value) {
				alert("O campo senha não confere com sua confirmação.");
				cadastro.txtsenha_1.value = "";
				cadastro.txtsenha_2.value = "";
				cadastro.txtsenha_1.focus();
				return false;
			}

			if (document.cadastro.txtend_nome.value == "") {
				alert("Por favor, informe seu logradouro.");
				cadastro.txtend_nome.focus();
				return false;
			}

			if (document.cadastro.txtend_num.value == "") {
				alert("Por favor, informe o número do seu logradouro.");
				cadastro.txtend_num.focus();
				return false;
			}

			if (document.cadastro.txtcep.value.length < 8) {
				alert("O campo CEP deve conter 8 caracteres.");
				cadastro.txtcep.focus();
				return false;
			}

			if (document.cadastro.txtbairro.value == "") {
				alert("Por favor, informe seu bairro.");
				cadastro.txtbairro.focus();
				return false;
			}

			if (document.cadastro.txtcidade.value == "") {
				alert("Por favor, informe sua cidade.");
				cadastro.txtcidade.focus();
				return false;
			}

			if (document.cadastro.txtuf.value == 0) {
				alert("Selecione um estado.");
				cadastro.txtuf.focus();
				return false;
			}

			// Verifica o CEP conforme o estado selecionado
			if (document.cadastro.txtuf.value == "AC") {
				if (document.cadastro.txtcep.value < "69900000" || document.cadastro.txtcep.value > "69999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "AL") {
				if (document.cadastro.txtcep.value < "57000000" || document.cadastro.txtcep.value > "57999999") {
					alert("O CEP digitado é invalido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "AP") {
				if (document.cadastro.txtcep.value < "68900000" || document.cadastro.txtcep.value > "68999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "AM") {
				if (document.cadastro.txtcep.value < "69000000" || document.cadastro.txtcep.value > "69899999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "BA") {
				if (document.cadastro.txtcep.value < "40000000" || document.cadastro.txtcep.value > "48999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "CE") {
				if (document.cadastro.txtcep.value < "60000000" || document.cadastro.txtcep.value > "63999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "DF") {
				if (document.cadastro.txtcep.value < "70000000" || document.cadastro.txtcep.value > "73699999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "ES") {
				if (document.cadastro.txtcep.value < "29000000" || document.cadastro.txtcep.value > "29999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "GO") {
				if (document.cadastro.txtcep.value < "72800000" || document.cadastro.txtcep.value > "76799999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "MA") {
				if (document.cadastro.txtcep.value < "65000000" || document.cadastro.txtcep.value > "65999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "MT") {
				if (document.cadastro.txtcep.value < "78000000" || document.cadastro.txtcep.value > "78899999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "MS") {
				if (document.cadastro.txtcep.value < "79000000" || document.cadastro.txtcep.value > "79999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "MG") {
				if (document.cadastro.txtcep.value < "30000000" || document.cadastro.txtcep.value > "39999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "PA") {
				if (document.cadastro.txtcep.value < "66000000" || document.cadastro.txtcep.value > "68899999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "PB") {
				if (document.cadastro.txtcep.value < "58000000" || document.cadastro.txtcep.value > "58999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "PR") {
				if (document.cadastro.txtcep.value < "80000000" || document.cadastro.txtcep.value > "87999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "PE") {
				if (document.cadastro.txtcep.value < "50000000" || document.cadastro.txtcep.value > "56999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "PI") {
				if (document.cadastro.txtcep.value < "64000000" || document.cadastro.txtcep.value > "64999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "RJ") {
				if (document.cadastro.txtcep.value < "20000000" || document.cadastro.txtcep.value > "28999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "RN") {
				if (document.cadastro.txtcep.value < "59000000" || document.cadastro.txtcep.value > "59999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "RS") {
				if (document.cadastro.txtcep.value < "90000000" || document.cadastro.txtcep.value > "99999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "RO") {
				if (document.cadastro.txtcep.value < "78900000" || document.cadastro.txtcep.value > "78999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "RR") {
				if (document.cadastro.txtcep.value < "69300000" || document.cadastro.txtcep.value > "69399999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "SC") {
				if (document.cadastro.txtcep.value < "88000000" || document.cadastro.txtcep.value > "89999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "SC") {
				if (document.cadastro.txtcep.value < "00000000" || document.cadastro.txtcep.value > "19999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "SP") {
				if (document.cadastro.txtcep.value < "01000000" || document.cadastro.txtcep.value > "19999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "SE") {
				if (document.cadastro.txtcep.value < "49000000" || document.cadastro.txtcep.value > "49999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			if (document.cadastro.txtuf.value == "TO") {
				if (document.cadastro.txtcep.value < "77000000" || document.cadastro.txtcep.value > "77999999") {
					alert("O CEP digitado é inválido para o estado selecionado.");
					cadastro.txtcep.focus();
					return false;
				}
			}
			return true;
		}
	</script>
</head>

<body>
	<div class="container">
		
		<!-- Se clicado no botão Meu cadastro do menu superior -->
		<?PHP if ($_SESSION['cadastro'] == "S") { ?>
			<?PHP include "inc_menu_superior.php" ?>
			<?PHP include "inc_menu_categorias.php" ?>
			<!-- Se a página for chamada por intermédio do botão "Fechar pedido" do carrinho de compras -->
			<!-- Não exibe menu superior e menu de categorias. Neste caso, exibe o banner da primeira etapa de uma compra (1. Minha identificação) -->

			<div class="container mt-4 mb-3"
				<?PHP $titulo_1 = "Meu Cadastro"; ?>
			<?PHP } else { ?>
				<?PHP $titulo_1 = "Etapa 2"; ?>
				<?PHP $titulo_2 = "Endereço de Entrega - Dados Pessoais"; ?>
				<a href="index.php"><img src="imagens/logo_fs.gif" alt="Faça um Site" border="0" /></a>
			<?PHP } ?>
				<!-- Título da página -->
				<h3><?PHP print $titulo_1; ?> <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_cinza"><?PHP print $titulo_2; ?> </span> </h3>
				<!-- Exibe formulário se o $total_registros = 0 (não existe e-mail cadastrado no banco de dados) ou se a ação for uma alteração (alt) -->
				<?PHP if ($total_registros == 0 or $_SESSION['acao'] == "alt") { ?>
					<div class="container mt-4 border p-3">
						<form name="cadastro" method="post" action="cadastro1.php" onsubmit="return valida_form(this);">
							<div class="row row-cols-2">
								<div class="col">
									<table class="table table-borderless">
										<thead>
											<tr>
												<th scope="col" colspan="2" class="text-center">Dados Pessoais</th>
											</tr>
										</thead>
										<tr>
											<td><label>Nome completo:</label></td>
											<td><input name="txtnome" type="text" class="caixa_texto" id="txtnome" size="35" maxlength="60" value="<?PHP print $txtnome; ?>" />*</td>
										</tr>
										<tr>
											<td><label><strong>(1)</strong> CPF:</label></td>
											<td><input name="txtcpf" type="text" class="caixa_texto" id="txtcpf" size="15" maxlength="11" value="<?PHP print $txtcpf; ?>" /> * (somente números)</td>
										</tr>
										<tr>
											<td><label>RG:</label></td>
											<td><input name="txtrg" type="text" class="caixa_texto" id="txtrg" size="15" maxlength="14" value="<?PHP print $txtrg; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Sexo:</label></td>
											<td><select name="txtsexo" id="txtsexo">
												<?PHP
													if ($txtsexo == "F") {
														$itens_sexo = $itens_sexo . "<option value='M'>Masculino</option><br /> ";
														$itens_sexo = $itens_sexo . "<option value='F' selected='selected'>Feminino</option><br /> ";
													} else {
														$itens_sexo = $itens_sexo . "<option value='M' selected='selected'>Masculino</option><br /> ";
														$itens_sexo = $itens_sexo . "<option value='F'>Feminino</option><br /> ";
													}
													print $itens_sexo;
												?></select> *</td>
										</tr>
										<tr>
											<td><label>E-mail:</label></td>
											<td><input name="txtemail_1" type="text" class="caixa_texto" size="35" maxlength="60" value="<?PHP print $txtemail_1; ?>" />*</td>
										</tr>
										<tr>
											<td><label><strong>(2)</strong> Confirme o e-mail:</label></td>
											<td><input name="txtemail_2" type="text" class="caixa_texto" size="35" maxlength="60" value="<?PHP print $txtemail_2; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Senha:</label></td>
											<td><input name="txtsenha_1" type="text" class="caixa_texto" id="txtsenha_1" size="10" maxlength="10" value="<?PHP print $txtsenha_1; ?>" />* (mínimo de 5 caracteres)</td>
										</tr>
										<tr>
											<td><label>Confirme a senha:</label></td>
											<td><input name="txtsenha_2" type="text" class="caixa_texto" id="txtsenha_2" size="10" maxlength="10" value="<?PHP print $txtsenha_2; ?>" />*</td>
										</tr>
							
									</table>
								</div> <!-- col dados-->
								<div class="col">
									<table class="table table-borderless">
										<thead>
											<tr>
												<th scope="col" colspan="2" class="text-center">Endereço de Entrega</th>
											</tr>
										</thead>
										<tr>
											<td><label>Logradouro:</label></td>
											<td><input name="txtend_nome" type="text" class="caixa_texto" id="txtend_nome" size="35" maxlength="60" value="<?PHP print $txtend_nome; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Número:</label></td>
											<td><input name="txtend_num" type="text" class="caixa_texto" id="txtend_num" size="10" maxlength="10" value="<?PHP print $txtend_num; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Complemento:</label></td>
											<td><input name="txtend_comp" type="text" class="caixa_texto" id="txtend_comp" size="20" maxlength="20" value="<?PHP print $txtend_comp; ?>" /></td>
										</tr>
										<tr>
											<td><label>CEP:</label></td>
											<td><input name="txtcep" type="text" class="caixa_texto" id="txtcep" size="15" maxlength="8" value="<?PHP print $txtcep; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Bairro:</label></td>
											<td><input name="txtbairro" type="text" class="caixa_texto" id="txtbairro" size="35" maxlength="40" value="<?PHP print $txtbairro; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Cidade:</label></td>
											<td><input name="txtcidade" type="text" class="caixa_texto" id="txtcidade" size="35" maxlength="40" value="<?PHP print $txtcidade; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Unidade federativa:</label></td>
											<td><select name="txtuf" class="formulario_cadastro2">
												<?PHP
													// Carrega combo de unidades federativas
													$itens_uf = "<option value='0'>-- Selecione um estado</option><br /> ";
													$sql_uf = "SELECT * FROM tb_estados ";
													$rs_uf = mysqli_query($conexao, $sql_uf);
													while ($reg_uf = mysqli_fetch_array($rs_uf)) {
														if ($txtuf == $reg_uf['uf']) {
															$itens_uf = $itens_uf . "<option value='" . $reg_uf['uf'] . "' selected='selected'>" . $reg_uf['nome'] . "</option><br /> ";
														} else {
															$itens_uf = $itens_uf . "<option value='" . $reg_uf['uf'] . "'>" . $reg_uf['nome'] . "</option><br /> ";
														}
													}
													print $itens_uf;
												?>
											</select> *</td>
										</tr>
									</table>
								</div> <!-- col entrega -->
							</div>
							<div class="row mb-3">
          						<div class="text-center">
            						<button class="btn btn-success" type="submit">Continuar</button>
          						</div>
        					</div>
						</form>
					</div> <!-- container formulário--> 
					<p>&nbsp;</p>
					<div id="caixa">
						<h4>Observações</h4>
						<p class="c_cinza"><strong>(*)</strong> Os campos marcados cos asterisco são de preenchimento obrigatório.</p>
						<p class="c_cinza"><strong class="c_preto">(1) Porque pedimos seu CPF?</strong> O CPF é um dado de identificação importante, pessoal e intransferível, que garante maior segurança em suas transções no Faça um Site Miniaturas. Por isso, o pedimos em seu cadastro no site, além do mais, ele é um dado obrigatório para a emissão da nota fiscal. Tanto o CPF quanto seus demais dados serão mantidos em completo sigilo, não sendo repassados a terceiros sob nenhuma hipótese.</p>
						<p class="c_cinza"><strong class="c_preto">(2) Porque preciso repetir meu e-mail e senha?</strong> É muito importante que a comunicação da Faça un Site Miniaturas com você
							aconteça satisfatoriamente. Por isso, pedimos a confirmação do seu e-mail, evitando erros de digitação que possam impedir o recebimento de mensagens sobre pedidos feitos no site. Seu e-mail permanecerá em completo sigilo e não será repassado a terceiros sob nenhuma hipótese.</p>
					</div>
					<!-- Informa que o e-mail já esta cadastrado) -->
				<?PHP } else { ?>
					<div id="caixa" align="center">
						<table width="100%" height="200" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center">
									<h1 class="c_vermelho">E-mail já cadastrado, utilize outro por favor.</h1>
									<p><a href="javascript:history.go(-1)"><img src="imagens/btn_voltar.gif" alt="Voltar" vspace="5" border="0" /></a></p>
								</td>
							</tr>
						</table>
					</div>
				<?PHP } ?>
				<?PHP include "inc_rodape.php" ?>
			</div>
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		</div> <!-- container conteudo--> 
		
	</div> <!-- container principal--> 
	
</body>

</html>
<?PHP
// Libera os recursos usados pela conexão atual

mysqli_close($conexao);
?>