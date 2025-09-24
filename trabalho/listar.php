<?php
include('conexao.php');

$sql = "SELECT * FROM musicas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Música</th>
                    <th>Artista</th>
                    <th>Ativa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"]. "</td>
                <td>" . $row["nome"]. "</td>
                <td>" . $row["artista"]. "</td>
                <td>" . ($row["ativo"] ? 'Sim' : 'Não') . "</td>
                <td>
                    <a href='editar.php?id=".$row["id"]."' class='btn btn-warning'>Editar</a>
                    <a href='excluir.php?id=".$row["id"]."' class='btn btn-danger'>Excluir</a>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "Nenhuma música encontrada";
}

$conn->close();
?>
