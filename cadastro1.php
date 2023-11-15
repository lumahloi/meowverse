<?PHP
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


if ($_SESSION['acao'] <> "ver") {
	// Captura os dados do formulário
	$txtnome = $_POST['txtnome'];
	$txtcpf = $_POST['txtcpf'];
	$txtrg = $_POST['txtrg'];
	$txtsexo = $_POST['txtsexo'];
	$txtemail = $_POST['txtemail2'];
	$txtsenha = $_POST['txtsenha_1'];
	$txtend_nome = $_POST['txtend_nome'];
	$txtend_num = $_POST['txtend_num'];
	$txtend_comp = $_POST['txtend_comp'];
	$txtcep = $_POST['txtcep'];
	$txtbairro = $_POST['txtbairro'];
	$txtcidade = $_POST['txtcidade'];
	$txtuf = $_POST['txtuf'];

    $sql = "select id from cadcli where cpf = '".$txtcpf."';";
    $rs = mysqli_query($conexao, $sql);
    $reg = mysqli_fetch_array($rs);

	// Atualiza variáveis de sessão
	$_SESSION['id_cli'] = $reg['id'];
	$_SESSION['nome_cli'] = $txtnome;
	$_SESSION['cpf'] = $txtcpf;
	$_SESSION['rg'] = $txtrg;
	$_SESSION['sexo'] = $txtsexo;
	$_SESSION['email_cli'] = $txtemail;
	$_SESSION['senha'] = $txtsenha;
	$_SESSION['end_nome'] = $txtend_nome;
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
	$sql = $sql . "VALUES ('$txtnome', '$txtcpf', '$txtrg', '$txtsexo', '$txtemail', '$txtsenha', '$txtend_nome', '$txtend_num', '$txtend_comp', '$txtcep', '$txtbairro','$txtcidade', '$txtuf') ";

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
	$sql = $sql . "senha = ('$txtsenha'), ";
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
    <title>Meowverse</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
</head>

<body>
    <div class="site-wrap">
        <?php include "inc_menuSuperior.php" ?>

        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <a href="index.php">Home</a>
                        <span class="mx-2 mb-0">/</span>
                        <a href="cesta.php">Carrinho</a>
                        <span class="mx-2 mb-0">/</span>
                        <a href="login.php">Login</a>
                        <span class="mx-2 mb-0">/</span>
                        <strong class="text-black">Cadastro</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <h2 class="h3 mb-3 text-black">Dados Pessoais</h2>
                        <div class="p-3 p-lg-5 border">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Nome completo </label>
                                    <p><?PHP print $_SESSION['nome_cli']; ?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">CPF </label>
                                    <p><?PHP print substr($_SESSION['cpf'], 0, 3) . "." . substr($_SESSION['cpf'], 3, 3) . "." . substr($_SESSION['cpf'], 6, 3) . "-" . substr($_SESSION['cpf'], 9, 2);?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">RG </label>
                                    <p><?PHP print number_format($_SESSION['rg'], 0, '', '.'); ?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Gênero </label>
                                    <p><?PHP print $_SESSION['sexo']; ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Email </label>
                                    <p><?PHP print $_SESSION['email_cli']; ?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Senha </label>
                                    <p><?PHP print $_SESSION['senha']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-5 mb-md-0">
                        <h2 class="h3 mb-3 text-black">Endereço de entrega</h2>
                        <div class="p-3 p-lg-5 border">

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">CEP </label>
                                    <p><?PHP print substr($_SESSION['cep'], 0, 5) . "-" . substr($_SESSION['cep'], 5, 3); ?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Rua </label>
                                    <p><?PHP print $_SESSION['end_nome']; ?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Número </label>
                                    <p><?PHP print number_format($_SESSION['end_num'], 0, '', '.'); ?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Complemento </label>
                                    <p><?php if(isset($_SESSION['end_comp'])&& !empty($_SESSION['end_comp'])){
                                        echo $_SESSION['end_comp'];
                                    } else {
                                        echo '-';
                                    }?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="c_fname" class="text-black">Bairro </label>
                                    <p><?PHP print $_SESSION['bairro']; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="c_lname" class="text-black">Cidade</label>
                                    <p><?PHP print $_SESSION['cidade']; ?></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Estado </label>
                                    <p><?PHP print $_SESSION['uf']; ?></p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="row justify-content-md-end mt-5">
                    <div class="col-md-3">
                        <p><?PHP print $mensagem; ?></p>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary btn-block py-3"
                            onclick="window.location='cadastro.php'">Alterar dados</button>
                    </div>
                    <div class="col-md-3">
                        <?php if ($_SESSION['cadastro'] == "S") { ?>
                        <button class="btn btn-primary btn-block py-3"
                            onclick="window.location='index.php'">Voltar à loja</button>
                        <?php } else { ?>

                        <button class="btn btn-primary btn-block py-3"
                            onclick="window.location='pagamento.php'">Continuar</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- </form> -->
            </div>
            
        </div>

        

        <?php include "inc_rodape.php" ?>
    </div>

    
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/main.js"></script>
</body>

</html>