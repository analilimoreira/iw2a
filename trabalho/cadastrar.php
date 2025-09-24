<?php
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $artista = $_POST['artista'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $sql = "INSERT INTO musicas (nome, artista, ativo) VALUES ('$nome', '$artista', $ativo)";

    if ($conn->query($sql) === TRUE) {
        echo "Música cadastrada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
