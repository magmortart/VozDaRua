<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "TCCGER";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT ID, descricao, categoria, nome, endereco, imagem, data 
        FROM RECLAMACOES ORDER BY ID DESC";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    echo "<table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>";
    echo "<tr style='background-color: #1f2937; color: white;'>
            <th style='padding: 5px; border: 1px solid #ccc;'>ID</th>
            <th style='padding: 5px; border: 1px solid #ccc;'>Descrição</th>
            <th style='padding: 5px; border: 1px solid #ccc;'>Categoria</th>
            <th style='padding: 5px; border: 1px solid #ccc;'>Nome</th>
            <th style='padding: 5px; border: 1px solid #ccc;'>Endereço</th>
            <th style='padding: 5px; border: 1px solid #ccc;'>Imagem</th>
            <th style='padding: 5px; border: 1px solid #ccc;'>Registrada em</th>
          </tr>";
    while ($linha = $res->fetch_assoc()) {
        echo "<tr style='background-color: #f9f9f9;'>
                <td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($linha['ID']) . "</td>
                <td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($linha['descricao']) . "</td>
                <td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($linha['categoria']) . "</td>
                <td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($linha['nome']) . "</td>
                <td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($linha['endereco']) . "</td>
                <td style='padding: 10px; border: 1px solid #ccc; text-align: center;'>";
        
        if (!empty($linha['imagem'])) {
            $imgBase64 = base64_encode($linha['imagem']);
            echo "<img src='data:image/jpeg;base64,{$imgBase64}' width='120' style='border-radius:6px;' />";
        } else {
            echo "Sem imagem";
        }

        echo "</td>
              <td style='padding: 5px; border: 1px solid #ccc;'>" . 
              htmlspecialchars(date("d/m/Y", strtotime($linha['data']))) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhuma reclamação encontrada.</p>";
}

$conn->close();
?>
