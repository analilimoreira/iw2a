<?php
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM musicas WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $artista = $_POST['artista'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $sql = "UPDATE musicas SET nome='$nome', artista='$artista', ativo=$ativo WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Música atualizada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="form-group">
        <label for="nome">Nome da Música:</label>
        <input type="text" name="nome" value="<?php echo $row['nome']; ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="artista">Artista:</label>
        <input type="text" name="artista" value="<?php echo $row['artista']; ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="ativo">Ativa:</label>
        <input type="checkbox" name="ativo" <?php echo $row['ativo'] ? 'checked' : ''; ?>>
    </div>
    <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
