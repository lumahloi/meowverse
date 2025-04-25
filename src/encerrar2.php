<?PHP
// Destroi variáveis de seção

include "inc_dbConexao.php";
session_start();
session_destroy();

// Libera os recursos usados pela conexão atual
if(isset($rs)){
  mysqli_free_result($rs);
  mysqli_close($conexao);
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
    <?php include "inc_menuSuperiorCat.php" ?>

    <div class="row mt-5 mb-5">
          <div class="col-md-12 text-center">
            <span class="icon-check_circle display-3 text-success"></span>
            <h2 class="display-3 text-black">Deslogado!</h2>
            <p class="lead mb-5">Você saiu da sua conta.</p>
            <p><a href="index.php" class="btn btn-sm btn-primary">Voltar à loja</a></p>
          </div>
        </div>
    </div>

    <?php include "inc_rodape.php" ?>

      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/owl.carousel.min.js"></script>
      <script src="js/aos.js"></script>
      <script src="js/main.js"></script>
</body>
</html>