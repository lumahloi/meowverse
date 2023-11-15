<?PHP
SESSION_START();
include "inc_dbConexao.php";

ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);

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
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> 
          <span class="mx-2 mb-0">/</span> 
          <a href="login.php?cadastro=S">Login</a>
          <span class="mx-2 mb-0">/</span> 
          <strong class="text-black">Esqueci a senha</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Esqueci a senha</h2>
            <div class="p-3 p-lg-5 border">
              <form name="senha" method="post" action="senha1.php" onsubmit="return valida_form(this);">
                <div class="form-group row justify-content-md-center">
                  <div class="col-6">
                    <label for="txtemail" class="text-black">E-mail</label>
                    <input type="email" class="form-control" id="txtemail" name="txtemail">
                  </div>
                </div>
                <div class="form-group row justify-content-md-center">
                  <div class="col-6">
                      <input type="submit" value="Continuar" class="btn btn-primary btn-block py-3">
                  </div>
                </div>
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