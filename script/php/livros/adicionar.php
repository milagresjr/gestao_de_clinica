<?php
include '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];
    $descricao = $_POST['descricao'];

    // Upload de imagem
    $capa = null;
    if ($_FILES['capa']['name']) {
        $ext = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['capa']['tmp_name'], '../uploads/' . $nome_arquivo);
        $capa = 'uploads/' . $nome_arquivo;
    }

    $sql = "INSERT INTO livros (titulo, autor, ano_publicacao, descricao, capa) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $autor, $ano, $descricao, $capa]);

    header("Location: ../index.php");
}
?>

<form method="POST" enctype="multipart/form-data">
    <input name="titulo" required placeholder="Título"><br>
    <input name="autor" placeholder="Autor"><br>
    <input name="ano" type="number" placeholder="Ano"><br>
    <textarea name="descricao" placeholder="Descrição"></textarea><br>
    <input type="file" name="capa" accept="image/*"><br>
    <button type="submit">Adicionar</button>
</form>
