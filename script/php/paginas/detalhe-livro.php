<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/conexao.php';

$id = $_GET['id'] ?? 0;

// Query segura com prepared statement
$stmt = $pdo->prepare("SELECT * FROM livros WHERE id_livro = ?");
$stmt->execute([$id]);
$livro = $stmt->fetch();

if (!$livro) {
    echo "<p><strong>Livro não encontrado.</strong></p>";
    exit;
}

// Buscar comentários principais (sem pai)
$comentarios = $pdo->prepare("
    SELECT c.*, u.nome AS nome_utilizador 
    FROM comentarios c
    JOIN utilizadores u ON c.utilizador_id = u.id_utilizador
    WHERE livro_id = ? AND comentario_id_pai IS NULL
    ORDER BY criado_em DESC
");
$comentarios->execute([$id]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($livro['titulo']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($livro['titulo']) ?></h1>
    <p><?= nl2br(htmlspecialchars($livro['descricao'] ?? 'Sem descrição')) ?></p>

    <h2>Comentários</h2>
    <form method="POST" action="../comentarios/adicionar.php">
        <input type="hidden" name="livro_id" value="<?= $id ?>">
        <label>Usuário (ID): <input name="utilizador_id" required type="number"></label><br>
        <textarea name="comentario" required placeholder="Escreva seu comentário aqui..."></textarea><br>
        <button type="submit">Comentar</button>
    </form>

    <?php foreach ($comentarios as $c): ?>
        <div style="margin-top: 10px; border-top: 1px solid #ccc; padding-top: 10px;">
            <strong><?= htmlspecialchars($c['nome_utilizador']) ?>:</strong> 
            <?= nl2br(htmlspecialchars($c['comentario'])) ?>

            <form action="../comentarios/reagir.php" method="POST" style="display:inline;">
                <input type="hidden" name="comentario_id" value="<?= $c['id'] ?>">
                <input type="hidden" name="utilizador_id" value="1"> <!-- Ajustar com sessão ou entrada -->
                <button name="tipo" value="like">👍</button>
                <button name="tipo" value="dislike">👎</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
