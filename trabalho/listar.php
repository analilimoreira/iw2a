<?php
include("conexao.php");

$sql = "SELECT * FROM musicas";
$result = mysqli_query($conexao, $sql);

echo "<h1>Lista de Músicas</h1>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Artista</th><th>Favorita</th><th>Ações</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['artista'] . "</td>";
        echo "<td> Sim</td>";
        echo "<td>
                <a href='editar.php?id=" . $row['id'] . "'>Editar</a> | 
                <a href='excluir.php?id=" . $row['id'] . "'>Excluir</a>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Nenhuma música cadastrada.</p>";
}
?>
