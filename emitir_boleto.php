<?PHP
// +---------------------------------------------------------+
// | Emissão do boleto bancário                              |
// +---------------------------------------------------------+
// | Parte integrante do livro da sárie Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero               |
// |                                                           |
// +---------------------------------------------------------+
SESSION_START();
include "inc_dbConexao.php";

// Captura os dados do pedido
$sql = "SELECT * ";
$sql .= "FROM pedidos ";
$sql .= "WHERE num_ped = '" . $_SESSION['num_ped1'] . "' ";
$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
$_SESSION['id_cli'] = $reg['id_cli'];
$_SESSION['dataped'] = $reg['data'];
$_SESSION['horaped'] = $reg['hora'];
$_SESSION['valor'] = $reg['valor'];
$_SESSION['datavenc'] = $reg['vencimento'];
$_SESSION['valor_frete'] = $reg['frete'];
$_SESSION['peso'] = $reg['peso'];
$_SESSION['desconto'] = $reg['desconto'];
$_SESSION['num_ped'] = $reg['num_ped'];
$_SESSION['id'] = $reg['id'];

// Calcula o valor do boleto
$_SESSION['valor_boleto'] = $_SESSION['valor'] + $_SESSION['valor_frete'] - $_SESSION['desconto'];
// Mantém zeros na casa decimal sem formatação para o cálculo da linha digitável
$_SESSION['valor_boleto1'] = number_format($_SESSION['valor_boleto'], 2, '', '');

// **** DADOS DO BOLETO
// DADOS FIXOS DE CONFIGURAÇÃO DO BOLETO
// 1. Dados da sua empresa
$boleto["cedente_nome"] = "FaÇa um Site Miniaturas Ltda";
$boleto["cedente_cnpj"] = "33.333.333/0001-33";

// 2. Dados da conta bancária da empresa (devem ser confirmados com o banco do cedente)
$boleto['num_banco'] = "935";				// Identificação do Banco (Banco teste = 935)
$boleto['dv_banco'] = "6";				// Identificação do Banco (Banco teste = 935)
$boleto['moeda'] = "9";							// Código da Moeda (Real = 9)
$boleto["num_agencia"] = "0572";		// Num da agência - sem digito verificador
$boleto["dv_agencia"] = "8";				// Dígito verificador da agência
$boleto["num_conta"] = "5543771";		// Num da conta corrente sem o dígito verificador
$boleto["dv_conta"] = "8";					// Digito verificador da conta corrente

// 3. Dados restritos do banco (devem ser confirmados com o banco do cedente)
$boleto["carteira"] = "06";			// Código da Carteira: Consultar seu banco
$boleto["aceite"] = "N";				// Aceite: Consultar seu banco
$boleto["especie"] = "R$";			// Espécie: Consultar seu banco
$boleto["especie_doc"] = "99";	// Espécie documento: Consultar seu banco
$boleto["fixo"] = "0";					// posicao 44 do código de barras

// 4. Informações gerais do boleto
$boleto['dv_codbar'] = "";	// Dígito verificador do Código de Barras

$boleto['fator'] = fator_venc($_SESSION['datavenc']);
$boleto['valor_zeroesq'] = zero_esquerda($_SESSION['valor_boleto1'], 10);
$boleto['nosso_numero'] = zero_esquerda($_SESSION['id'], 11);

// Taxa de cobrança para envio do boleto
$taxa_boleto = 3.00;

// Dados do Sacado
$boleto['sacado_nome'] = $_SESSION['nome_cli'];
$boleto['sacado_end1'] = ltrim($_SESSION['end_nome']) . ", " . ltrim($_SESSION['end_num']) . " " . ltrim($_SESSION['end_comp']);
$boleto['sacado_end2'] = substr($_SESSION['cep'], 0, 5) . "-" . substr($_SESSION['cep'], 5, 3) . "&nbsp;&nbsp;&nbsp;&nbsp;" . ltrim($_SESSION['bairro']) . "&nbsp;&nbsp;&nbsp;&nbsp;" . ltrim($_SESSION['cidade']) . "&nbsp;&nbsp;&nbsp;&nbsp;" . ltrim($_SESSION['uf']);

// ***** CóDIGO DE BARRAS
// Monta cógigo de barras sem o dígito verificador
$boleto['codbarra_sem_dv'] = $boleto['num_banco'] . $boleto['moeda'] . $boleto['fator'] . $boleto['valor_zeroesq'] . $boleto['num_agencia'] . $boleto['carteira'] . $boleto['nosso_numero'] . $boleto['num_conta'] . $boleto['fixo'];

// Cálculo do dígito verificador (dv) do código de barras
// Inverte o código de barras para cálculo do dígito verificador
$boleto1 = strrev($boleto['codbarra_sem_dv']);
$soma = 0;
for ($i = 0; $i <= 42; $i++) {
	$a[$i] = substr($boleto1, $i, 1);
	// Multiplica as posições de 0 a 7 por 2,3,4,5,6,7,8 e 9
	if ($i <= 7) {
		$fator[$i] = $a[$i] * ($i + 2);
	}
	// Multiplica as posições de 8 a 15 por 2,3,4,5,6,7,8 e 9
	if ($i >= 8 and $i <= 15) {
		$fator[$i] = $a[$i] * ($i - 6);
	}
	// Multiplica as posições de 16 a 23 por 2,3,4,5,6,7,8 e 9
	if ($i >= 16 and $i <= 23) {
		$fator[$i] = $a[$i] * ($i - 14);
	}
	// Multiplica as posições de 24 a 31 por 2,3,4,5,6,7,8 e 9
	if ($i >= 24 and $i <= 31) {
		$fator[$i] = $a[$i] * ($i - 22);
	}
	// Multiplica as posições de 42 a 39 por 2,3,4,5,6,7,8 e 9
	if ($i >= 32 and $i <= 39) {
		$fator[$i] = $a[$i] * ($i - 30);
	}
	// Multiplica as posições de 40 a 42 por 2,3 e 4
	if ($i >= 40) {
		$fator[$i] = $a[$i] * ($i - 38);
	}
	// Soma os números de cada posição do código de barras invertido pelo respectivo fator
	$soma = $soma + $fator[$i];
	// Calcula o resto da divisão entre a soma e 11
	$dv = 11 - ($soma % 11);
	// Se o resultado da subtração (11 - resto de $soma) for igual a 0 (Zero), 1 (um)
	// ou maior que 9 (nove) deverão assumir o dígito igual a 1 (um).
	if ($dv == 0 or $dv == 1 or $dv > 9) {
		$dv = 1;
	}
}
// Monta o código de barras com o dígito verificador (dv)
$boleto['codbarra_dv'] = substr($boleto['codbarra_sem_dv'], 0, 4) . $dv . substr($boleto['codbarra_sem_dv'], 4, 39);

// TRANSFORMA O CÓDIGO DE BARRAS NUMÉRICO (base 10) EM BINÁRIO
$n[0] = "00110";
$n[1] = "10001";
$n[2] = "01001";
$n[3] = "11000";
$n[4] = "00101";
$n[5] = "10100";
$n[6] = "01100";
$n[7] = "00011";
$n[8] = "10010";
$n[9] = "01010";

$boleto['codbarra_binario'] = "";
for ($z = 0; $z < 44; $z = $z + 2) {
	for ($i = 0; $i < 5; $i++) {
		$x1 = substr($boleto['codbarra_dv'], $z, 1);
		$x2 = substr($boleto['codbarra_dv'], $z + 1, 1);
		$boleto['codbarra_binario'] = $boleto['codbarra_binario'] . substr($n[$x1], $i, 1) . substr($n[$x2], $i, 1);
	}
}

// prepara as barras para impressão
$boleto['cod_grafico'] = "";	// Contém as imagens das barras (preta e branca)
for ($i = 0; $i < strlen($boleto['codbarra_binario']); $i++) {
	// Verifica se a posição da barra é par
	if ($i % 2 == 0) {
		// Se o número for zero imprime barra preta estreita
		if (substr($boleto['codbarra_binario'], $i, 1) == 0) {
			$boleto['cod_grafico'] = $boleto['cod_grafico'] . "<img src='imagens/p.png' width='1' height='50' border='0' />";
			// Se o número for 1 imprime barra preta larga
		} else {
			$boleto['cod_grafico'] = $boleto['cod_grafico'] . "<img src='imagens/p.png' width='3' height='50' border='0' />";
		}
	}

	// Verifica se a posição da barra é ímpar
	if ($i % 2 == 1) {
		// Se o número for zero imprime barra branca estreita	
		if (substr($boleto['codbarra_binario'], $i, 1) == 0) {
			$boleto['cod_grafico'] = $boleto['cod_grafico'] . "<img src='imagens/b.png' width='1' height='50' border='0' />";
			// Se o número for 1 imprime barra branca larga		
		} else {
			$boleto['cod_grafico'] = $boleto['cod_grafico'] . "<img src='imagens/b.png' width='3' height='50' border='0' />";
		}
	}
}
// Insere ao código de barras as barras start
$bar_start = "<img src='imagens/p.png' width='1' height='50' />";
$bar_start = $bar_start . "<img src='imagens/b.png' width='1' height='50' />";
$bar_start = $bar_start . "<img src='imagens/p.png' width='1' height='50' />";
$bar_start = $bar_start . "<img src='imagens/b.png' width='1' height='50' />";
$boleto['cod_grafico'] = $bar_start . $boleto['cod_grafico'];

// Insere ao código de barras as barras stop
$bar_stop = "<img src='imagens/p.png' width='3' height='50' />";
$bar_stop = $bar_stop . "<img src='imagens/b.png' width='1' height='50' />";
$bar_stop = $bar_stop . "<img src='imagens/p.png' width='1' height='50' />";
$boleto['cod_grafico'] = $boleto['cod_grafico'] . $bar_stop;


// ***** LINHA DIGITÁVEL
// Campo livre = Agência (cedente) + Carteira + Nosso número + Conta corrente (cedente) + Fixo (0)
$campo_livre = $boleto['num_agencia'] . $boleto["carteira"] . $boleto["nosso_numero"] . $boleto["num_conta"] . $boleto["fixo"];

// 1º campo
// Composto pelo código de Banco, código da moeda, as cinco primeiras posições do campo livre e o dígito de auto conferência(DAC) deste campo
$campo1 = $boleto['num_banco'] . $boleto['moeda'] . substr($campo_livre, 0, 5);
$dac_campo1 = calculo_dac1($campo1);

// 2º campo
// Composto pelas posições 6ª a 15ª do campo livre e o dígito verificador deste campo
$campo2 = substr($campo_livre, 5, 10);
$dac_campo2 = calculo_dac2($campo2);

// 3º campo
// Composto pelas posições 16ª a 25ª do campo livre e o dígito verificador deste campo deste campo
$campo3 = substr($campo_livre, 15, 10);
$dac_campo3 = calculo_dac2($campo3);

// 4º campo
// Composto pelo dígito verificador do código de barras, ou seja, a 5ª posiçõo do código de barras
$campo4 = $dv;

// 5º campo
// Composto pelo fator de vencimento com 4(quatro) caracteres e o valor do documento com 10(dez) caracteres, sem separadores e sem edição
$campo5 = fator_venc($_SESSION['datavenc']) . zero_esquerda($_SESSION['valor_boleto1'], 10);

// LINHA DIGITÁVEL
$linha_digitavel = substr($campo1, 0, 5) . "." . substr($campo1, 5, 5) . $dac_campo1 . " ";
$linha_digitavel = $linha_digitavel . substr($campo2, 0, 5) . "." . substr($campo2, 5, 5) . $dac_campo2 . " ";
$linha_digitavel = $linha_digitavel . substr($campo3, 0, 5) . "." . substr($campo3, 5, 5) . $dac_campo3 . " ";
$linha_digitavel = $linha_digitavel . $campo4 . " " . $campo5;

// ***** FUNÇÕES
// CALCULO DO FATOR DE VENCIMENTO DO BOLETO
// Parâmetro: $data = Data de vencimento do boleto no formato aaaa-mm-dd
function fator_venc($data)
{
	// Separa a data em dia, mês e ano
	$dia = substr($data, 8, 2);
	$mes = substr($data, 5, 2);
	$ano = substr($data, 0, 4);
	// calcula o timestamp da data 07/10/1997 (base de cálculo do fator de vencimento)
	$timestamp_data1 = mktime(0, 0, 0, 10, 07, 1997);
	// calcula o timestamp da data de vencimento do boleto
	$timestamp_data2 = mktime(0, 0, 0, $mes, $dia, $ano);
	// Calcula a diferença de dias entre as duas datas. Como esta diferença é calculada em segundos, 
	// é necessário se dividir esse resultado por 86.400 (número de segundos de 1 dia)
	$dif_dias = round(($timestamp_data2 - $timestamp_data1) / 86400);
	return $dif_dias;
}

// INSERE ZEROS À ESQUERDA DE UM NÚMERO
// Parâmetros: $numero = número considerado, $zeros = tamanho do número (com zeros)
function zero_esquerda($numero, $zeros)
{
	// Retira o ponto decimal do número	
	$numero = str_replace(".", "", $numero);
	// Define o número de zeros a serem inseridos à esquerda do número
	$loop = $zeros - strlen($numero);
	for ($i = 0; $i < $loop; $i++) {
		$numero = "0" . $numero;
	}
	return $numero;
}

// Função formatar CNPJ
function formatar_cnpj($n)
{
	$cnpj_formatado = substr($n, 0, 2) . "." . substr($n, 2, 3) . "." . substr($n, 5, 3) . "/" . substr($n, 8, 4) . "-" . substr($n, 12, 2);
	return $cnpj_formatado;
}

// Cálculo do Dígito de auto conferência (DAC) da linha digitável para o campo 1
function calculo_dac1($campo)
{
	for ($i = 0; $i < 9; $i++) {
		// Varifica a posição do número. Se impar $fator_dac = 2. Se par $fator_dac = 1
		if ($i % 2 == 0) {
			$fator_dac = 2;
		} else {
			$fator_dac = 1;
		}
		// Multiplica a posição do número pelo $fator_dac
		$dac1 = (substr($campo, $i, 1) * $fator_dac);
		// Se o valor de $dac1 for maior do que 9, somam-se os dois dígitos, ex:
		// Se $dac1 = 12 teremos como resultado final 1 + 2, ou seja 3.
		if ($dac1 > 9) {
			$dac2 = substr($dac1, 0, 1) + substr($dac1, 1, 1);
		} else {
			$dac2 = $dac1;
		}
		$soma_dac = $soma_dac + $dac2;
		// Divide-se o resultado por 10, se resto = 0 o DAC será 0
		// Se resto diferente de 0 o DAC será: 10 - resto
		if ($soma_dac % 10 == 0) {
			$dac = 0;
		} else {
			$dac = 10 - ($soma_dac % 10);
		}
	}
	return $dac;
}

// Cálculo do Dígito de auto conferência (DAC) da linha digitável para o campo 2 e 3
function calculo_dac2($campo)
{
	for ($i = 0; $i < 10; $i++) {
		// Varifica a posição do número. Se impar $fator_dac = 2. Se par $fator_dac = 1
		if ($i % 2 == 0) {
			$fator_dac = 1;
		} else {
			$fator_dac = 2;
		}
		// Multiplica a posição do número pelo $fator_dac
		$dac1 = (substr($campo, $i, 1) * $fator_dac);
		// Se o valor de $dac1 for maior do que 9, somam-se os dois dígitos, ex:
		// Se $dac1 = 12 teremos como resultado final 1 + 2, ou seja 3.
		if ($dac1 > 9) {
			$dac2 = substr($dac1, 0, 1) + substr($dac1, 1, 1);
		} else {
			$dac2 = $dac1;
		}
		$soma_dac = $soma_dac + $dac2;
		// Divide-se o resultado por 10, se resto = 0 o DAC será 0
		// Se resto diferente de 0 o DAC será: 10 - resto
		if ($soma_dac % 10 == 0) {
			$dac = 0;
		} else {
			$dac = 10 - ($soma_dac % 10);
		}
	}
	return $dac;
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
	<style type="text/css">
		<!--
		.linha_inf {
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
			font-weight: bold;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 2px;
			padding-left: 10px;
		}

		.linha_dir {
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
			border-right-width: 1px;
			border-right-style: solid;
			border-right-color: #000000;
			font-weight: bold;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 2px;
			padding-left: 10px;
		}

		.titulo_inf {
			font-size: 8px;
			line-height: 10px;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 0px;
			padding-left: 2px;
		}

		.titulo_dir {
			border-right-width: 1px;
			border-right-style: solid;
			border-right-color: #000000;
			font-size: 8px;
			line-height: 10px;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 0px;
			padding-left: 2px;
		}

		.logo_banco {
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
			border-right-width: 1px;
			border-right-style: solid;
			border-right-color: #000000;
			font-weight: bold;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 2px;
			padding-left: 0px;
		}

		.logo_fs {
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
			font-weight: bold;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 2px;
			padding-left: 0px;
		}

		.num_banco {
			padding: 2px;
			font-size: 18px;
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
			border-right-width: 1px;
			border-right-style: solid;
			border-right-color: #000000;
			text-align: center;
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #000000;
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;
		}

		.linha_digitavel {
			padding: 2px;
			font-size: 16px;
			font-weight: normal;
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
			text-align: right;
		}

		.valor {
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
			font-weight: bold;
			padding-top: 0px;
			padding-right: 15px;
			padding-bottom: 2px;
			padding-left: 10px;
			text-align: right;
		}

		.sacado {
			font-weight: bold;
			padding-top: 3px;
			padding-right: 15px;
			padding-bottom: 3px;
			padding-left: 30px;
		}

		.avalista {
			font-size: 8px;
			line-height: 10px;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 0px;
			padding-left: 2px;
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
		}

		.autenticacao {
			font-size: 9px;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 0px;
			padding-left: 2px;
		}

		.instrucoes {
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
			padding-top: 0px;
			padding-right: 2px;
			padding-bottom: 2px;
			padding-left: 10px;
		}

		p {
			padding-top: 1px;
			padding-right: 0px;
			padding-bottom: 1px;
			padding-left: 0px;
			margin: 0px;
		}

		.linha_digitavelA {
			padding: 2px;
			font-size: 20px;
			font-weight: normal;
		}

		.titulo {
			padding: 2px;
			font-size: 14px;
			font-weight: normal;
			text-align: right;
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #000000;
		}
		-->
	</style>
</head>

<body onload="javascript:window.print();">
	<!-- Menu de emissão do boleto -->
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td height="28" valign="top" background="imagens/menu_boleto.gif">
				<div align="right">
					<a href="javascript:window.print();"><img src="imagens/btn_transparente.gif" width="85" height="23" hspace="3" border="0" /></a>
					<a href="index.php"><img src="imagens/btn_transparente.gif" width="80" height="23" hspace="3" border="0" /></a>
					<a href="pedidos.php"><img src="imagens/btn_transparente.gif" alt="Ver meus pedidos" width="100" height="23" hspace="3" border="0" /></a>
					<a href="encerrar.php"><img src="imagens/btn_transparente.gif" alt="Encerrar se&ccedil;&atilde;o" width="71" height="23" hspace="3" border="0" /></a>
				</div>
			</td>
		</tr>
	</table>

	<!-- Recibo do Sacado -->
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td class="logo_fs"><a href="index.php"><img src="imagens/logo_fsboleto.gif" width="178" height="37" vspace="2" border="0" /></a></td>
			<td width="439" class="titulo">Boleto para pagamento do pedido n°<strong>&nbsp;<?PHP print $_SESSION['num_ped']; ?></strong></td>
		</tr>
	</table>

	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="5" class="titulo_dir">Local de Pagamento</td>
			<td width="146" class="titulo_inf">Vencimento</td>
		</tr>
		<tr>
			<td colspan="5" class="linha_dir">PAGAVEL PREFERENCIALMENTE EM QUALQUER AGÊNCIA BANCO TESTE</td>
			<td class="linha_inf"><?PHP print substr($_SESSION['datavenc'], 8, 2) . "/" . substr($_SESSION['datavenc'], 5, 2) . "/" . substr($_SESSION['datavenc'], 0, 4); ?></td>
		</tr>
		<tr>
			<td colspan="5" class="titulo_dir">Cedente</td>
			<td class="titulo_inf">Agência/Código Cedente</td>
		</tr>
		<tr>
			<td colspan="5" class="linha_dir"><?PHP print strtoupper($boleto["cedente_nome"]); ?></td>
			<td class="linha_inf"><?PHP print $boleto["num_agencia"] . "-" . $boleto["dv_agencia"] . "/" . $boleto["num_conta"] . "-" . $boleto["dv_conta"]; ?></td>
		</tr>
		<tr>
			<td width="109" class="titulo_dir">Data do Documento </td>
			<td width="129" class="titulo_dir">N&ordm; do Documento </td>
			<td width="113" class="titulo_dir">Esp&eacute;cie Documento </td>
			<td width="84" class="titulo_dir">Aceite</td>
			<td width="119" class="titulo_dir">Data do Processamento</td>
			<td class="titulo_inf">Nosso Número</td>
		</tr>
		<tr>
			<td class="linha_dir"><?PHP print substr($_SESSION['dataped'], 8, 2) . "/" . substr($_SESSION['dataped'], 5, 2) . "/" . substr($_SESSION['dataped'], 0, 4); ?></td>
			<td class="linha_dir"><?PHP print $_SESSION['num_ped']; ?></td>
			<td class="linha_dir"><?PHP print $boleto["especie_doc"]; ?></td>
			<td class="linha_dir"><?PHP print $boleto["aceite"]; ?></td>
			<td class="linha_dir"><?PHP print date('d/m/Y'); ?></td>
			<td class="linha_inf"><?PHP print $boleto['carteira'] . "-" . $boleto['nosso_numero']; ?></td>
		</tr>
		<tr>
			<td class="titulo_dir">Uso do Banco </td>
			<td class="titulo_dir">Carteira</td>
			<td class="titulo_dir">Esp&eacute;cie</td>
			<td class="titulo_dir">Quantidade</td>
			<td class="titulo_dir">Valor</td>
			<td class="titulo_inf">(=) Valor do Documento </td>
		</tr>
		<tr>
			<td class="linha_dir">&nbsp;</td>
			<td class="linha_dir"><?PHP print $boleto['carteira']; ?></td>
			<td class="linha_dir"><?PHP print $boleto['especie']; ?></td>
			<td class="linha_dir">&nbsp;</td>
			<td class="linha_dir">&nbsp;</td>
			<td class="valor"><?PHP print number_format($_SESSION['valor_boleto'], 2, ',', '.'); ?></td>
		</tr>
		<tr>
			<td colspan="5" class="titulo_inf">&nbsp;</td>
			<td class="titulo_inf">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6" valign="top" class="instrucoes">
				<p><strong>Instruções de impressão</strong></p>
				<p>- Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).</p>
				<p>- Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à direita do formulário.</p>
				<p>- Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.</p>
				<p>&nbsp;</p>
				<p><strong>Pagamento via Internet Banking</strong></p>
				<p>Caso tenha problemas ao imprimir este boleto, ou se desejar pagá-lo através do Internet Banking, utilize a linha digitável descrita abaixo:</p>
				<p>&nbsp;</p>
				<p align="center" class="linha_digitavelA"><?PHP print $linha_digitavel; ?></p>
				<p>&nbsp;</p>
			</td>
		</tr>

		<tr>
			<td colspan="6" class="titulo_inf">Sacado</td>
		</tr>
		<tr>
			<td colspan="6" class="sacado">
				<?PHP print $boleto['sacado_nome']; ?><br />
				<?PHP print $boleto['sacado_end1']; ?><br />
				<?PHP print $boleto['sacado_end2']; ?></td>
		</tr>
		<tr>
			<td colspan="6" class="avalista">Sacador/Avalista</td>
		</tr>
		<tr>
			<td colspan="6">
				<div align="right"><strong>Recibo do Sacado -</strong> <span class="autenticacao">Autentica&ccedil;&atilde;o Mec&acirc;nica</span> </div>
			</td>
		</tr>

		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6"><img src="imagens/corte.gif" width="700" height="12" /></td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
	</table>

	<!-- Ficha de Compensação -->
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="157" class="logo_banco"><img src="imagens/logo_banco.gif" width="140" height="23" /></td>
			<td width="51" class="num_banco"><?PHP print $boleto['num_banco'] . "-" . $boleto['dv_banco']; ?></td>
			<td width="492" class="linha_digitavel"><?PHP print $linha_digitavel; ?></td>
		</tr>
	</table>

	<!-- Ficha de compensação -->
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="5" class="titulo_dir">Local de Pagamento</td>
			<td width="146" class="titulo_inf">Vencimento</td>
		</tr>
		<tr>
			<td colspan="5" class="linha_dir">PAGAVEL PREFERENCIALMENTE EM QUALQUER AGÊNCIA BANCO TESTE</td>
			<td class="linha_inf"><?PHP print substr($_SESSION['datavenc'], 8, 2) . "/" . substr($_SESSION['datavenc'], 5, 2) . "/" . substr($_SESSION['datavenc'], 0, 4); ?></td>
		</tr>
		<tr>
			<td colspan="5" class="titulo_dir">Cedente</td>
			<td class="titulo_inf">Agência/Código Cedente</td>
		</tr>
		<tr>
			<td colspan="5" class="linha_dir"><?PHP print strtoupper($boleto["cedente_nome"]); ?></td>
			<td class="linha_inf"><?PHP print $boleto["num_agencia"] . "-" . $boleto["dv_agencia"] . "/" . $boleto["num_conta"] . "-" . $boleto["dv_conta"]; ?></td>
		</tr>
		<tr>
			<td width="109" class="titulo_dir">Data do Documento </td>
			<td width="129" class="titulo_dir">N&ordm; do Documento </td>
			<td width="113" class="titulo_dir">Esp&eacute;cie Documento </td>
			<td width="84" class="titulo_dir">Aceite</td>
			<td width="119" class="titulo_dir">Data do Processamento</td>
			<td class="titulo_inf">Nosso Número</td>
		</tr>
		<tr>
			<td class="linha_dir"><?PHP print substr($_SESSION['dataped'], 8, 2) . "/" . substr($_SESSION['dataped'], 5, 2) . "/" . substr($_SESSION['dataped'], 0, 4); ?></td>
			<td class="linha_dir"><?PHP print $_SESSION['num_ped']; ?></td>
			<td class="linha_dir"><?PHP print $boleto["especie_doc"]; ?></td>
			<td class="linha_dir"><?PHP print $boleto["aceite"]; ?></td>
			<td class="linha_dir"><?PHP print date('d/m/Y'); ?></td>
			<td class="linha_inf"><?PHP print $boleto['carteira'] . "-" . $boleto['nosso_numero']; ?></td>
		</tr>
		<tr>
			<td class="titulo_dir">Uso do Banco </td>
			<td class="titulo_dir">Carteira</td>
			<td class="titulo_dir">Esp&eacute;cie</td>
			<td class="titulo_dir">Quantidade</td>
			<td class="titulo_dir">Valor</td>
			<td class="titulo_inf">(=) Valor do Documento </td>
		</tr>
		<tr>
			<td class="linha_dir">&nbsp;</td>
			<td class="linha_dir"><?PHP print $boleto['carteira']; ?></td>
			<td class="linha_dir"><?PHP print $boleto['especie']; ?></td>
			<td class="linha_dir">&nbsp;</td>
			<td class="linha_dir">&nbsp;</td>
			<td class="valor"><?PHP print number_format($_SESSION['valor_boleto'], 2, ',', '.'); ?></td>
		</tr>
		<tr>
			<td colspan="5" class="titulo_dir">INSTRU&Ccedil;&Otilde;ES (Texto de responsabilidade do Cedente) </td>
			<td class="titulo_inf">(-) Desconto/Abatimento </td>
		</tr>
		<tr>
			<td colspan="5" rowspan="9" valign="top" class="linha_dir">
				<p>&nbsp;</p>
				<p>ATENÇÂO:</p>
				<p>- Não pague este boleto após o seu vencimento.</p>
				<p>- Após esta data o pedido será cancelado e o boleto perderá a validade.
				<p>&nbsp;</p>
				<p>BOLETO PARA FINS DIDÁTICOS&nbsp;&nbsp;&nbsp;* NUNCA EFETUE SEU PAGAMENTO *</p>
			</td>
			<td class="linha_inf">&nbsp;</td>
		</tr>
		<tr>
			<td class="titulo_inf">(-) Outras Dedu&ccedil;&otilde;es </td>
		</tr>
		<tr>
			<td class="linha_inf">&nbsp;</td>
		</tr>
		<tr>
			<td class="titulo_inf">(+) Mora/Multa </td>
		</tr>
		<tr>
			<td class="linha_inf">&nbsp;</td>
		</tr>
		<tr>
			<td class="titulo_inf">(+) Outros Acr&eacute;scimos </td>
		</tr>
		<tr>
			<td class="linha_inf">&nbsp;</td>
		</tr>
		<tr>
			<td class="titulo_inf">(=) Valor Cobrado </td>
		</tr>
		<tr>
			<td class="linha_inf">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6" class="titulo_inf">Sacado</td>
		</tr>
		<tr>
			<td colspan="6" class="sacado">
				<?PHP print $boleto['sacado_nome']; ?><br />
				<?PHP print $boleto['sacado_end1']; ?><br />
				<?PHP print $boleto['sacado_end2']; ?></td>
		</tr>
		<tr>
			<td colspan="5" class="avalista">Sacador/Avalista</td>
			<td class="avalista">
				<div align="right">C&oacute;digo de Baixa </div>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<div align="right"><strong>Ficha de Compensa&ccedil;&atilde;o -</strong> <span class="autenticacao">Autentica&ccedil;&atilde;o Mec&acirc;nica</span> </div>
			</td>
		</tr>

		<tr>
			<td colspan="6"><?PHP print $boleto['cod_grafico']; ?></td>
		</tr>
	</table>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
<?PHP
// Destroi variáveis de seção
SESSION_DESTROY();
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_close($conexao);
?>