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

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

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
	$txtemail2 = $_SESSION['email_cli'];
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
    <title>Meowverse</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script type='text/javascript' src="js/jquery.autocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

	<script type="text/javascript">
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
				alert("Por favor, selecione seu gênero.");
				cadastro.txtsexo.focus();
				return false;
			}

			if (document.cadastro.txtemail2.value == "") {
				alert("Por favor, confirme seu e-mail.");
				cadastro.txtemail2.focus();
				return false;
			}

			if (document.cadastro.txtemail_2.value == "") {
				alert("Por favor, confirme seu e-mail.");
				cadastro.txtemail_2.focus();
				return false;
			}

			if (document.cadastro.txtemail2.value != document.cadastro.txtemail_2.value) {
				alert("O campo e-mail não confere com sua confirmação.");
				cadastro.txtemail2.value = "";
				cadastro.txtemail_2.value = "";
				cadastro.txtemail2.focus();
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

			return true;
		}
	
		$(document).ready(function() {
			$( "#olho1" ).mousedown(function() {
				$("#txtsenha_1").attr("type", "text");
			});

			$( "#olho1" ).mouseup(function() {
				$("#txtsenha_1").attr("type", "password");
			});

			var senha1 = $('#txtsenha_1');
			var olho1 = $("#olho1");

			olho1.mousedown(function() {
				senha1.attr("type", "text");
			});

			olho1.mouseup(function() {
				senha1.attr("type", "password");
			});
			// para evitar o problema de arrastar a imagem e a senha continuar exposta, 
			//citada pelo nosso amigo nos comentários
			$( "#olho1" ).mouseout(function() { 
				$("#txtsenha_1").attr("type", "password");
			});

			//////////////////////////////////////////////////////

			$( "#olho2" ).mousedown(function() {
				$("#txtsenha_2").attr("type", "text");
			});

			$( "#olho2" ).mouseup(function() {
				$("#txtsenha_2").attr("type", "password");
			});

			var senha2 = $('#txtsenha_2');
			var olho2 = $("#olho2");

			olho2.mousedown(function() {
				senha2.attr("type", "text");
			});

			olho2.mouseup(function() {
				senha2.attr("type", "password");
			});
			// para evitar o problema de arrastar a imagem e a senha continuar exposta, 
			//citada pelo nosso amigo nos comentários
			$( "#olho2" ).mouseout(function() { 
				$("#txtsenha_2").attr("type", "password");
			});

			function limpa_formulário_cep() {
				// Limpa valores do formulário de cep.
				$("#txtend_nome").val("");
				$("#txtbairro").val("");
				$("#txtcidade").val("");
				$("#txtuf").val("");
			}

			//Quando o campo cep perde o foco.
			$("#txtcep").blur(function() {
				//Nova variável "cep" somente com dígitos.
				var cep = $(this).val().replace(/\D/g, '');

				//Verifica se campo cep possui valor informado.
				if (cep != "") {

					//Expressão regular para validar o CEP.
					var validacep = /^[0-9]{8}$/;

					//Valida o formato do CEP.
					if(validacep.test(cep)) {

						//Preenche os campos com "..." enquanto consulta webservice.
						$("#txtend_nome").val("...");
						$("#txtbairro").val("...");
						$("#txtcidade").val("...");
						$("#txtuf").val("...");

						//Consulta o webservice viacep.com.br/
						$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

							if (!("erro" in dados)) {
								//Atualiza os campos com os valores da consulta.
								$("#txtend_nome").val(dados.logradouro);
								$("#txtbairro").val(dados.bairro);
								$("#txtcidade").val(dados.localidade);
								$("#txtuf").val(dados.uf);
							} //end if.
							else {
								//CEP pesquisado não foi encontrado.
								limpa_formulário_cep();
								alert("CEP não encontrado.");
							}
						});
					} //end if.
					else {
						//cep é inválido.
						limpa_formulário_cep();
						alert("Formato de CEP inválido.");
					}
				} //end if.
				else {
					//cep sem valor, limpa formulário.
					limpa_formulário_cep();
				}
			});
		});
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
				<a href="index.php"><img src="imagens/logo.png" alt="Faça um Site" /></a>
			<?PHP } ?>
				<!-- Título da página -->
				<h3><?PHP print $titulo_1; ?> <img src="imagens/marcador_setaDir.gif" align="absmiddle" /> <span class="c_cinza"><?PHP print $titulo_2; ?> </span> </h3>
				<!-- Exibe formulário se o $total_registros = 0 (não existe e-mail cadastrado no banco de dados) ou se a ação for uma alteração (alt) -->
				<?PHP if ($total_registros == 0 or $_SESSION['acao'] == "alt") { ?>
					<div class="container mt-4 border p-3">
						<form name="cadastro" method="post" action="cadastro1.php" onsubmit="return valida_form(this);">
							<div class="row row-cols-2">
								<div class="col-lg-6 col-12">
									<table class="table table-borderless">
										<thead>
											<tr>
												<th scope="col" colspan="2" class="text-center">Dados Pessoais</th>
											</tr>
										</thead>
										<tr>
											<td><label>Nome completo:</label></td>
											<td><input name="txtnome" type="text" class="caixa_texto" id="txtnome" maxlength="60" value="<?PHP print $txtnome; ?>" style="display: inline; width: 95%"/>*</td>
										</tr>
										<tr>
											<td><label><strong>(1)</strong> CPF:</label></td>
											<td><input name="txtcpf" type="text" class="caixa_texto" id="txtcpf" value="<?PHP print $txtcpf; ?>" onKeyPress="if(this.value.length==11) return false;" size="14"/> * </td>
										</tr>
										<tr>
											<td><label>RG:</label></td>
											<td><input name="txtrg" type="text" class="caixa_texto" id="txtrg" value="<?PHP print $txtrg; ?>" onKeyPress="if(this.value.length==7) return false;" size="10"/>*</td>
										</tr>
										<tr>
										<td><label>Gênero:</label></td>
											<td>
												<select name="txtsexo" id="txtsexo">
													<?php
													$generoSelecionado = isset($txtsexo) ? $txtsexo : "M"; // Define o gênero selecionado (padrão: Masculino)
													$opcoesGenero = array(
														"M" => "Masculino",
														"F" => "Feminino",
														"A" => "Agênero",
														"N" => "Não Binário",
														"O" => "Outro",
														"P" => "Prefiro não responder"
													);

													foreach ($opcoesGenero as $abreviacao => $genero) {
														$selected = ($generoSelecionado == $abreviacao) ? 'selected' : '';
														echo "<option value='$abreviacao' $selected>$genero</option>";
													}
													?>
												</select> *
											</td>

										</tr>
										<tr>
											<td><label>E-mail:</label></td>
											<td><input name="txtemail2" type="text" class="caixa_texto" maxlength="60" value="<?PHP print $txtemail2; ?>" style="display: inline; width: 95%"/>*</td>
										</tr>
										<tr>
											<td><label><strong>(2)</strong> Confirme o e-mail:</label></td>
											<td><input name="txtemail_2" type="text" class="caixa_texto" maxlength="60" value="<?PHP print $txtemail_2; ?>" style="display: inline; width: 95%"/>*</td>
										</tr>
										<tr>
											<td><label>Senha:</label></td>
											<td><input name="txtsenha_1" type="password" class="caixa_texto" id="txtsenha_1" size="10" maxlength="10" value="<?PHP print $txtsenha_1; ?>" /><img id="olho1" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII="
											/>* (mínimo de 5 caracteres)</td>
										</tr>
										<tr>
											<td><label>Confirme a senha:</label></td>
											<td><input name="txtsenha_2" type="password" class="caixa_texto" id="txtsenha_2" size="10" maxlength="10" value="<?PHP print $txtsenha_2; ?>" /><img id="olho2" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII="
											/>*</td>
										</tr>
							
									</table>
								</div> <!-- col dados-->
								<div class="col-lg-6 col-12">
									<table class="table table-borderless">
										<thead>
											<tr>
												<th scope="col" colspan="2" class="text-center">Endereço de Entrega</th>
											</tr>
										</thead>
										<tr>
											<td><label>CEP:</label></td>
											<td><input name="txtcep" type="text" class="caixa_texto" id="txtcep" size="11" value="<?PHP print $txtcep; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Logradouro:</label></td>
											<td><input name="txtend_nome" type="text" class="caixa_texto" id="txtend_nome"  maxlength="60" value="<?PHP print $txtend_nome; ?>" readonly style="background-color: #f0f0f0" style="display: inline; width: 95%"/></td>
										</tr>
										<tr>
											<td><label>Número:</label></td>
											<td><input name="txtend_num" type="text" class="caixa_texto" id="txtend_num" size="10" maxlength="10" value="<?PHP print $txtend_num; ?>" />*</td>
										</tr>
										<tr>
											<td><label>Complemento:</label></td>
											<td><input name="txtend_comp" type="text" class="caixa_texto" id="txtend_comp"  maxlength="50" value="<?PHP print $txtend_comp; ?>" style="display: inline; width: 95%"/></td>
										</tr>
										<tr>
											<td><label>Bairro:</label></td>
											<td><input name="txtbairro" type="text" class="caixa_texto" id="txtbairro"  maxlength="40" value="<?PHP print $txtbairro; ?>" readonly style="background-color: #f0f0f0; display: inline; width: 95%"/></td>
										</tr>
										<tr>
											<td><label>Cidade:</label></td>
											<td><input name="txtcidade" type="text" class="caixa_texto" id="txtcidade"  maxlength="40" value="<?PHP print $txtcidade; ?>" readonly style="background-color: #f0f0f0; display: inline; width: 95%"/></td>
										</tr>
										<tr>
											<td><label>Unidade federativa:</label></td>
											<td><input type="text" name="txtuf" id="txtuf" readonly style="background-color: #f0f0f0" value="<?php print $txtuf ?>"></td>
										</tr>
									</table>
								</div> <!-- col entrega -->
							</div>
							<div class="row mb-3">
          						<div class="text-center">
            						<button class="btn btn-success" type="submit" style="background-color: purple; border-color: purple;">Continuar</button>
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
			
			<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

		</div> <!-- container conteudo--> 
		
	</div> <!-- container principal--> 
	
</body>

</html>
<?PHP
// Libera os recursos usados pela conexão atual

mysqli_close($conexao);
?>