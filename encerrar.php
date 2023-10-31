<?PHP
// +---------------------------------------------------------+
// | Encerrar seção                                          |
// +---------------------------------------------------------+
// | Parte integrante do livro da série Faça um Site         |
// | PHP 5 com banco de dados MySQL - Comércio eletrnico    |
// | Editora Érica - autor: Carlos A J Oliviero              |
// | www.facaumsite.com.br                                   |
// +---------------------------------------------------------+

// Destroi variáveis de seção

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
</head>

<body>
  <div class="container">
    <!-- Logomarca e pesquisa -->
    <div id="topo">
      <?PHP include "inc_menu_superior.php" ?>
    </div>

    <!-- Menu superior -->
    <div id="menuSup">
      <?PHP include "inc_menu_categorias.php" ?>
    </div>


    <table width="100%" height="295" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="37%">
          <div align="center">
            <h5 align="right"><img src="imagens/logo.png" width="178" height="178" /></h5>
          </div>
        </td>
        <td width="63%">
          <div align="center">
            <h5>Seção encerrada</h5>
            <p><strong>Obrigado por utilizar nossa loja virtual.</strong></p>
          </div>
        </td>
      </tr>
    </table>

    <?PHP include "inc_rodape.php" ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>