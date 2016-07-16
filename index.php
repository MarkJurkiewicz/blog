<?php
require_once 'lib/common.php';

session_start();
// Connection to the database, run a query, handle errors
$pdo = getPDO();
$stmt = $pdo->query(
        'SELECT
            id, title, created_at, body
        FROM
            post
        ORDER BY
            created_at DESC'
);
if ($stmt === false)
{
    throw new Exception('There was a problem running this query');
}

$notFound = isset($_GET['not_found']);
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
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="post-synopsis">
            <h2>
                <?php echo htmlEscape($row['title']) ?>
            </h2>
            <div class="meta">
                <?php echo convertSqlDate($row['created_at']) ?>
                (<?php echo countCommentsForPost($pdo, $row['id']) ?> comments)
            </div>
            <p>
                <?php echo htmlEscape($row['body']) ?>
            </p>
            <div class="read-more">
                <a
                    href="view-post.php?post_id=<?php echo $row['id'] ?>"
                >Read more...</a>
            </div>
        </div>
    <?php endwhile ?>
</div>
</body>
</html>