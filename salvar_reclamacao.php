<?php

use Vtiful\Kernel\Format;
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "TCCGER";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $nome = $conn->real_escape_string($_POST['nome']);
    $cpf = $conn->real_escape_string($_POST['cpf']);
    $endereco = $conn->real_escape_string($_POST['endereco']);

    // Lê a imagem se enviada
    $imagemBinario = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemBinario = file_get_contents($_FILES['imagem']['tmp_name']);
    }

    // Usar prepared statement
    $stmt = $conn->prepare("INSERT INTO reclamacoes (descricao, categoria, nome, cpf, endereco, imagem) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssb", $descricao, $categoria, $nome, $cpf, $endereco, $null);

    if ($imagemBinario !== null) {
        $stmt->send_long_data(5, $imagemBinario);
    }

    if ($stmt->execute()) {
        echo "<div class='success-message'>Reclamação enviada com sucesso!</div>";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
