<?php
include('conexao.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM musicas WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Música excluída com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }

    $conn->close();
}
?>
