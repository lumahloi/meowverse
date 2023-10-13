<?PHP
// +---------------------------------------------------------+
// | Carrinho de compras                                     |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrônico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+

include "inc_dbConexao.php";

SESSION_START();

// Recupera valores passados pela página detalhes.php
// onde produto = código do produto selecionado
// inserir = S - adicionado ao botão comprar da página detalhes.php

$produto = $_GET['produto'];
$inserir = $_GET['inserir'];
// qt = 1, default para quantidade  por produto passado pelo campo  desta página
$qt = "1";

// Captura o último id de tabela de pedidos
$sql = "SELECT id, status ";
$sql .= " FROM pedidos ";
$sql .= " ORDER by id DESC ";

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);
$id_ped = $reg["id"];
$status = $reg["status"];

// Insere um registro na tabela de pedidos
if ($_SESSION['num_ped'] == '' and $inserir == "S") {
	// Incrementa 1 ao último id 
	$id_ped = $id_ped + 1;
	// prepara o número do pedido (id do pedido, hora e primeiro digito do minuto)
	$num_ped = $id_ped . "." . date("H") . substr(date("i"), 0, 1);
	$_SESSION['num_ped'] = $num_ped;
	$_SESSION['id_ped'] = $id_ped;

	// Número do boleto = número do pedido sem separador de milhar
	$SESSION['num_boleto'] = $id_ped . date("H") . substr(date("i"), 0, 1);

	$sqli = "INSERT INTO pedidos";
	$sqli .= " (num_ped, status) ";
	$sqli .= " VALUES('$num_ped','Em andamento') ";
	$rs = mysqli_query($conexao, $sqli);
	
	$_SESSION['status'] = 'Em andamento';
}

// Excluir itens do carrinho
$excluir = $_GET['excluir'];
$id = $_GET['id'];

if ($excluir = "S") {
	$sqld = " DELETE FROM itens ";
	$sqld .= "WHERE id = '" . $id . "' ";

	//echo $sqld;
	//exit;

	mysqli_query($conexao, $sqld);
}

// Captura dados do produto selecionado
$sql = "SELECT id, codigo, nome, preco, desconto, peso, desconto_boleto ";
$sql .= " FROM miniaturas ";
$sql .= " WHERE codigo = '" . $produto . "' ";

$rs = mysqli_query($conexao, $sql);
$reg = mysqli_fetch_array($rs);

$codigo = $reg["codigo"];
$nome = $reg["nome"];
$preco = $reg["preco"];
$peso = $reg["peso"];
$desconto = $reg["desconto"];
$desconto_boleto = $reg["desconto_boleto"];
$preco_desconto = $preco - ($preco * $desconto / 100);
$preco_boleto = $preco_desconto - ($preco_desconto * $desconto_boleto / 100);

$num_ped = $_SESSION['num_ped'];

// Verifica se o item já se encontra no carrinho
$sqld = "SELECT codigo ";
$sqld .= "FROM itens ";
$sqld .= "WHERE codigo = '" . $produto . "' ";
$sqld .= "AND num_ped = '" . $num_ped . "' ";

$rsd = mysqli_query($conexao, $sqld);
// Se nenhum registro for encontrado, $item_duplicado será igual a 0; caso contrario, será igual a 1
$item_duplicado = mysqli_num_rows($rsd);

// Adiciona o produto à tabela de itens somente se $item_duplicado for igual a 0 
if ($item_duplicado == 0 and $inserir == "S"){
	$sqli = "INSERT into itens";
	$sqli .= "(num_ped,codigo,nome,qt,preco,peso,preco_boleto,desconto,desconto_boleto) ";
	$sqli .= "VALUES('$num_ped','$codigo','$nome','$qt','$preco','$peso','$preco_boleto','$desconto','$desconto_boleto') ";
	
	mysqli_query($conexao, $sqli);
}

// Atualiza itens do carrinho de acordo com os valores digitados no campo "Quatidade" de cada item
for ($contador = 1; $contador <= $_SESSION['total_itens']; $contador++) {
	$b[$contador] = $_POST['txt' . $contador];
	$c[$contador] = $_POST['id' . $contador];

	$sqla = "UPDATE itens ";
	$sqla .= "SET qt = '" . $b[$contador] . "' ";
	$sqla .= "WHERE id = '" . $c[$contador] . "' ";

	//echo $sqla;
	//exit;
	mysqli_query($conexao, $sqla);
}

// Captura os itens adicionados ao carrinho para serem exibidos na página
$sql = "SELECT * ";
$sql .= " FROM itens ";
$sql .= " WHERE num_ped = '" . $num_ped . "' ";
$sql .= " ORDER BY id ";

//echo $sql;
//exit;
$rs = mysqli_query($conexao, $sql);
$total_itens = mysqli_num_rows($rs);
$_SESSION['total_itens'] = $total_itens;
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
			<?PHP for ($contador = 1; $contador <= $_SESSION['total_itens']; $contador++) { ?>
				if (document.cesta.txt<?PHP print $contador; ?>.value < 1) {
					alert("O campo quantidade não pode ser menor do que 1.");
					document.cesta.txt<?PHP print $contador; ?>.focus();
					return false;
				}
				if (document.cesta.txt<?PHP print $contador; ?>.value > 10) {
					alert("O campo quantidade não pode conter mais de 10 itens.");
					document.cesta.txt<?PHP print $contador; ?>.focus();
					return false;
				}
			<?PHP } ?>
			return true;
		}
	</script>
</head>
<body>
    <div class="container">
    <?PHP include "inc_menu_superior.php" ?>
        <?PHP include "inc_menu_categorias.php" ?>
    </div>
    <div class="container">
        
        <?PHP if ($_SESSION['num_ped'] == "") { ?>
                    <div class="container mx-auto text-center mt-5 mb-5">
                    <div class="row">
                        <div class="col">
                            <h4 class="mb-3">Seu carrinho está vazio</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="index.php" class="btn btn-success" role="button" aria-pressed="true">Voltar à loja</a>
                        </div>
                    </div>
                </div>
                <?PHP } else { ?>
                <!-- Exibe título da página e número do pedido caso existam produtos no carrinho -->
                <div class="row">
                    <h2 class="mt-5">Meu carrinho de compras</h2>
                </div>
                <div class="row">
                    <p class="text-end">Número do seu pedido: <?PHP print $_SESSION['num_ped']; ?></p>
                </div>
                <!-- Exibe os itens no carrinho -->
                <form action="login.php" method="post" onsubmit="return valida_form(this);">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Descrição do produto</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Excluir item</th>
                                <th scope="col">Preço unitário R$</th>
                                <th scope="col">Total R$</th>
                            </tr>
                        </thead>
                        <?PHP
                            $subtotal = 0;
                            $n = 0;
                            while ($reg = mysqli_fetch_array($rs)) {
                                $n = $n + 1;
                                $id = $reg["id"];
                                $codigo = $reg["codigo"];
                                $nome = $reg["nome"];
                                $qt = $reg["qt"];
                                $preco_unitario = $reg["preco"];
                                $peso = $reg["peso"];
                                $preco_total = $preco_unitario * $qt;
                                $subtotal = $subtotal + $preco_total;
                            ?>
                        <tbody>
                            <tr>
                                <td>
                                    <img src='imagens/<?PHP print $codigo; ?>.jpg' width='53' height='32' align="absmiddle" />&nbsp;&nbsp;&nbsp;<?PHP print $codigo; ?> - <?PHP print $nome; ?>
                                </td>
                                <td>
                                    <input name="txt<?PHP print $n; ?>" value="<?PHP print $qt; ?>" type="text" size="2" maxlength="6" class="caixa_texto" readonly/>
                                </td>
                                <td>
                                    <a href="cesta.php?id=<?PHP print $id ?>&excluir=S"><img src='imagens/btn_removerItem.gif' alt='Comprar' hspace='5' border='0' /></a>
                                </td>
                                <td>
                                    <p>R$ <?PHP print number_format($preco_unitario, 2, ',', '.'); ?></p>
                                </td>
                                <td>
                                    <p>R$ <?PHP print number_format($preco_total, 2, ',', '.'); ?></p>
                                </td>
                                <!-- Armazena id e código do item nos campos ocultos para serem capturados pelo POST do formulário -->
                                <input type=hidden name="id<?PHP print $n; ?>" value="<?PHP print $id; ?>">
                                    <input type=hidden name="cod<?PHP print $n; ?>" value="<?PHP print $codigo; ?>">
                            </tr>
                        </tbody>
                        <?PHP
                            }
                            ?>
                        <tr>
                           <td colspan="3">
                                <p>O valor total da sua compra não inclui o frete, ele será calculado no fechamento do seu pedido.</p>
                           </td>
                           <td>
                                <p>Subtotal</p>
                           </td>
                           <td>
                                <p class="fw-bold">R$ <?PHP print number_format($subtotal, 2, ',', '.'); ?></p>
                           </td>
                        </tr>
                        <tfoot>
                            <td colspan="4">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="index.php"><button type="button" class="btn btn-secondary">Comprar mais produtos</button></a>
                                    <a href="cesta.php"><button type="button" class="btn btn-primary">Atualizar valores</button></a>
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success">Finalizar pedido</button>
                            </td>
                        </tfoot>
                    </table>
                </form>
            <?PHP } ?>
        <?PHP include "inc_rodape.php" ?>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

<?PHP
// Libera os recursos usados pela conexão atual
mysqli_free_result($rs);
mysqli_free_result($rsd);
mysqli_close($conexao);
?>