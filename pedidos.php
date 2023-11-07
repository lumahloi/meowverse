<?PHP
// +---------------------------------------------------------+
// | Meus pedidos                                            |
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
  <script language="javascript">
    function valida_form() {
      if (document.pedidos.txtemail.value == "") {
        alert("Por favor, preencha o campo e-mail.");
        pedidos.txtemail.focus();
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
  <div id="main" class="container">
    <!-- Logomarca e mneu superior -->
    <?PHP include "inc_menu_superior.php" ?>
    <?PHP include "inc_menu_categorias.php" ?>

    <h2 class="mt-5">Meus Pedidos</h2>
    
    <div class="container border mt-3 bg-light p-3">
      <p class="mt-3 text-center">Para prosseguir, por favor, identifique-se utilizando os campos abaixo e depois clique no botão "Continuar".</p>

      <form action="pedidos1.php" method="post" onsubmit="return valida_form(this);" class="col-md-6 mx-auto form-group mt-5">
        <div class="row mb-3">
          <label for="email" class="col-sm-2 col-form-label">Seu email:</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" placeholder="Insira seu email" id="email" name="txtemail">
          </div>
        </div>

        <div class="row mb-3">
          <label for="senha" class="col-sm-2 col-form-label">Sua senha:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" placeholder="Insira sua senha" id="senha" name="txtsenha">
            <small class="form-text text-muted">Nunca compartilharemos sua senha.</small>
          </div>
        </div>

        <div class="row mb-3">
          <div class="text-center">
            <button class="btn btn-success" type="submit" style="background-color: purple; border-color: purple;" >Continuar</button>
          </div>
        </div>
        
      </form>

    </div>

    <?PHP include "inc_rodape.php" ?>
      
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </div>
</body>
</html>