<?php include '../includes/conexao.php';

$comentario_id = $_POST['comentario_id'];
$usuario = $_POST['usuario'];
$tipo = $_POST['tipo'];

$sql = "INSERT INTO reacoes (comentario_id, usuario, tipo) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$comentario_id, $usuario, $tipo]);

$livro_id = $pdo->query("SELECT livro_id FROM comentarios WHERE id = $comentario_id")->fetchColumn();
header("Location: ../paginas/livros.php?id=$livro_id");
?>
