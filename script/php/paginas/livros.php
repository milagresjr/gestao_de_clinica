<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/conexao.php';

$livros = $pdo->query("SELECT * FROM livros ORDER BY criado_em DESC")->fetchAll();
?>
<h1>Biblioteca</h1>
<a href="livros/adicionar.php">Adicionar Livro</a>
<ul>
<?php foreach ($livros as $livro): ?>
    <?php
        $id = isset($livro['id_livro']) ? htmlspecialchars($livro['id_livro']) : '0';
        $titulo = isset($livro['titulo']) ? htmlspecialchars($livro['titulo']) : 'Sem título';
    ?>
    <li>
        <a href="detalhe-livro.php?id=<?= $id ?>"><?= $titulo ?></a>
    </li>
<?php endforeach; ?>
</ul>

