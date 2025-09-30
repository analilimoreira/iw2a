<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$host = "localhost:8081";
$user = "root";
$pass = "";
$db   = "api_video2";

$conn = new mysql($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]);
    exit;
}

file_put_contents("log.txt", date('Y-m-d H:i:s') . " - Método: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['pesquisa'])) {
            $pesquisa = "%" . $_GET['pesquisa'] . "%";
            $stmt = $conn->prepare("SELECT * FROM musicas WHERE TITULO LIKE ? OR ARTISTA LIKE ?");
            $stmt->bind_param("ss", $pesquisa, $pesquisa);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $conn->query("SELECT * FROM musicas ORDER BY ID DESC");
        }

        $retorno = [];
        while ($linha = $result->fetch_assoc()) {
            $retorno[] = $linha;
        }

        echo json_encode($retorno);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("INSERT INTO musicas (TITULO, ARTISTA, ALBUM, GENERO, ATIVO) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $data['TITULO'], $data['ARTISTA'], $data['ALBUM'], $data['GENERO'], $data['ATIVO']);
        $stmt->execute();

        echo json_encode(["status" => "ok", "insert_id" => $stmt->insert_id]);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("UPDATE musicas SET TITULO=?, ARTISTA=?, ALBUM=?, GENERO=?, ATIVO=? WHERE ID=?");
        $stmt->bind_param("ssssii", $data['TITULO'], $data['ARTISTA'], $data['ALBUM'], $data['GENERO'], $data['ATIVO'], $data['ID']);
        $stmt->execute();

        echo json_encode(["status" => "ok"]);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM musicas WHERE ID=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["status" => "ok"]);
        break;
}

$conn->close();

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$result = $conn->query("SHOW TABLES LIKE 'musicas'");
if ($result && $result->num_rows == 1) {
    echo json_encode(["status" => "Conectado e tabela 'musicas' existe"]);
} else {
    echo json_encode(["error" => "Tabela 'musicas' não encontrada"]);
}

exit;
?>
