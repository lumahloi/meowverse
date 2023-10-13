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
            <button class="btn btn-success" type="submit">Continuar</button>
          </div>
        </div>
        
      </form>

    </div>

    <?PHP include "inc_rodape.php" ?>
      
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </div>
</body>
</html>