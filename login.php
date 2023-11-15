<?PHP
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);


// cadastro = S (se entrada for pelo menu Meu cadastro(neste caso exibe o menu de categorias))
// cadastro = "" se entrada for pelo carrinho de compras (neste caso exibe as etapas de uma compra e
// não exibe o menu superior e menu  de categorias)
$_SESSION['cadastro'] = $_GET['cadastro'];

// Armazena na variavel de sessao o modo de visualização cadastral
$_SESSION['acao'] = "ver";

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

  <script language="javascript">
		//Valida campos do formulário de entrega (usuários já cadastrados)-->
		function valida_form() {
			if (document.form_cadastro.txtemail1.value == "") {
				alert("Por favor, preencha o campo [Seu e-mail].");
				form_cadastro.txtemail1.focus();
				return false;
			}
			if (document.form_cadastro.txtsenha1.value == "") {
				alert("Por favor, preencha o campo [Senha].");
				form_cadastro.txtsenha1.focus();
				return false;
			}
			return true;
		}

		// Valida campos do formulário de cadastro (novos usuários) -->
		function valida_form1() {
			if (document.form_cadastro.txtemail2.value == "") {
				alert("Por favor, preencha o campo [Seu e-mail].");
				form_cadastro.txtemail2.focus();
				return false;
			}
			return true;
		}
	</script>
</head>

<body>
  <div class="site-wrap">
    <?php include "inc_menuSuperior.php" ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <a
              href="cesta.php">Carrinho</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Login</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Já sou cadastrado</h2>
            <div class="p-3 p-lg-5 border">
              <form name="form_entrega" method="post" action="login1.php" onsubmit="return valida_form(this);">
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtemail1" class="text-black">E-mail</label>
                    <input type="email" class="form-control" id="txtemail1" name="txtemail1" value="<?php echo $_SESSION['email_cli']?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtsenha1" class="text-black">Senha</label>
                    <input type="password" class="form-control" id="txtsenha1" name="txtsenha1" value="<?php echo $_SESSION['senha']?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                      <a href="senha.php" role="button" class="btn btn-outline-primary btn-block py-3">Esqueci a senha</a>
                  </div>
                  <div class="col-md-6">
                    <input type="submit" value="Continuar" class="btn btn-primary btn-block py-3">
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Quero me cadastrar</h2>
            <div class="p-3 p-lg-5 border">
              <form action="cadastro.php" name="form_cadastro" method="post" onsubmit="return valida_form1(this);">
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtemail1" class="text-black">E-mail</label>
                    <input type="email" class="form-control" id="txtemail2" name="txtemail2">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="txtsenha2" class="text-black">Senha</label>
                    <input type="text" class="form-control" id="txtsenha2" name="txtsenha2" readonly
                      value="Será pedido na próxima etapa">
                  </div>
                </div>
                <div class="form-group">
                  <input type="submit" value="Continuar" class="btn btn-primary btn-block py-3">
                </div>
                <input type="hidden" name="acao" value="inc" />
              </form>

            </div>
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