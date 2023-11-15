<?PHP
    //$conexao = mysqli_connect("localhost","id21484300_lumah","Senha@123","id21484300_db_php5");
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'db_php5';
    
    $conexao = new mysqli($servername, $username, $password, $database);

    // Verificar a conexão
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }
?>
