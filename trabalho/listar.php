<?php
include('conexao.php');

$sql = "SELECT * FROM musicas";
$result = $conn->query($sql);


var_dump($result); 

if ($result->num_rows > 0) {
    echo '<div class="container my-4">';
    echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">';
    while($row = $result->fetch_assoc()) {
        var_dump($row); 
        echo '<div class="col">';
        echo '<div class="card shadow-sm h-100">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['nome']) . '</h5>';
        echo '<p class="card-text"><strong>Artista:</strong> ' . htmlspecialchars($row['artista']) . '</p>';
        echo '<p class="card-text"><strong>Favorita:</strong> ' . ($row['favorita'] ? 'Sim' : 'Não') . '</p>';
        echo '</div>';
        echo '<div class="card-footer text-center">';
        echo '<a href="editar.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm me-2">Editar</a>';
        echo '<a href="excluir.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm")">Excluir</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="container my-5"><p class="text-center">Nenhuma música cadastrada.</p></div>';
}

$conn->close();
?>
