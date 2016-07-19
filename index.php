<?php
require_once 'lib/common.php';

session_start();
// Connection to the database, run a query, handle errors
$pdo = getPDO();

$notFound = isset($_GET['not_found']);
$posts = getAllPosts($pdo);
?>


<!DOCTYPE html>
<html>
<head>
    <title>A blog application</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>

<?php require 'templates/title.php' ?>

    <?php if ($notFound): ?>
    <div style="border: 1px solid #ff6666; padding: 6px;">
        Error: cannot find the requested blog post
    </div>
    <?php endif ?>
<div class="post-list">
    <?php foreach ($posts as $post): ?>
        <div class="post-synopsis">
            <h2>
                <?php echo htmlEscape($post['title']) ?>
            </h2>
            <div class="meta">
                <?php echo convertSqlDate($post['created_at']) ?>
                (<?php echo $post['comment_count'] ?> comments)
            </div>
            <p>
                <?php echo htmlEscape($post['body']) ?>
            </p>
            <div class="post-controls">
                <a
                    href="view-post.php?post_id=<?php echo $post['id'] ?>"
                >Read more...</a>
                <?php if (isLoggedIn()): ?>
                    |
                    <a href="edit-post.php?post_id=<?php echo $post['id'] ?>">Edit</a>
                <?php endif ?>
            </div>
        </div>
    <?php endforeach ?>
</div>
</body>
</html>