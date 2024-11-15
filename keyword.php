<?php
// Database connection
$host = 'localhost';
$db = 'test';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Fetch tags
$sql = "SELECT * FROM tags";
$stmt = $pdo->query($sql);
$tags = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tag Appender with Summernote</title>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

</head>
<body>

<!-- Summernote Text Editor -->
<div id="summernote">Type here or click tags to insert</div>

<!-- Tags Section -->
<h3>Click to append tags:</h3>
<div id="tag-list">
    <?php foreach ($tags as $tag): ?>
        <button class="tag-button" data-tag="<?= htmlspecialchars($tag['tag_name']) ?>">
            <?= htmlspecialchars($tag['tag_name']) ?>
        </button>
    <?php endforeach; ?>
</div>

<script>
// Initialize Summernote
$(document).ready(function() {
    $('#summernote').summernote({
        placeholder: 'Type or click on tags to append...',
        tabsize: 2,
        height: 200
    });

    // Append clicked tag to Summernote
    $('.tag-button').on('click', function() {
        var tag = $(this).data('tag');
        $('#summernote').summernote('code', $('#summernote').summernote('code') + tag + ' ');
    });
});
</script>

</body>
</html>
