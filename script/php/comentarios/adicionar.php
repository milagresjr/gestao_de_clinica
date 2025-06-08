<?php include '../includes/conexao.php';

$livro_id = $_POST['livro_id'];
$usuario = $_POST['usuario'];
$comentario = $_POST['comentario'];
$pai = $_POST['comentario_id_pai'] ?? null;

$sql = "INSERT INTO comentarios (livro_id, usuario, comentario, comentario_id_pai) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$livro_id, $usuario, $comentario, $pai]);

header("Location: ../paginas/livros.php?id=$livro_id");
?>
