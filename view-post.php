<?php
// Make pathway to the database, so SQLite/PDO can connect
require_once 'lib/common.php';
require_once 'lib/view-post.php';

session_start();

//Get the post ID
if (isset($_GET['post_id']))
{
    $postId = $_GET['post_id'];
}
else
{
    // this will ensure that a post ID variable is always defined
    $postId = 0;
}

// Connection to the database, run a query, handle errors
$pdo = getPDO();
$row = getPostRow($pdo, $postId);
// if the row does not exist
if (!$row)
{
    redirectAndExit('index.php?not-found=1');
}

$errors = null;
if ($_POST) {
    $commentData = array(
        'name' => $_POST['comment-name'],
        'website' => $_POST['comment-name'],
        'text' => $_POST['comment-text'],
    );
    $errors = addCommentToPost($pdo, $postId, $commentData);

    //If no errors present, redirect to self and redisplay
    if (!$errors) {
        redirectAndExit('view-post.php?post_id=' . $postId);
    }
}
else
{
    $commentData = array(
        'name' => '',
        'website' => '',
        'text' => '',
    );
}
$stmt = $pdo->prepare(
    'SELECT
        title, created_at, body
    FROM
        post
    WHERE
        id = :id'
);
if ($stmt === false)
{
        throw new Exception('There was a problem preparing this query');
}
$result = $stmt->execute(
    array('id' => $postId, )
);
if ($result === false)
{
    throw new Exception('There was a problem running this query');
}

// Access a row
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Carriage returns for paragraph breaks
$bodyText = htmlEscape($row['body']);
$paraText = str_ireplace("\n", "</p><p>", $bodyText);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application |
            <?php echo htmlspecialchars($row['title']) ?>
        </title>
        <?php require 'templates/head.php' ?>
    </head>
<body>
    <?php require 'templates/title.php' ?>

    <div class="post">
        <h2>
            <?php echo htmlEscape($row['title']) ?>
        </h2>
        <div class="date">
            <?php echo convertSqlDate($row['created_at']) ?>
        </div>
        <?php // This is already escaped, so doesn't need further escaping ?>
        <?php echo convertNewlinesToParagraphs($row['body']) ?>
    </div>
    <div class="comment-list">
        <h3><?php echo countCommentsForPost($pdo, $postId) ?> comments</h3>
        <?php foreach (getCommentsForPost($pdo, $postId) as $comment): ?>
            <div class="comment">
                <div class="comment-meta">
                    Comment from
                    <strong><?php echo htmlEscape($comment['name']) ?></strong>
                    on
                    <?php echo convertSqlDate($comment['created_at']) ?>
                </div>
                <div class="comment-body">
                    <?php // This is already escaped ?>
                    <?php echo convertNewlinesToParagraphs($comment['text']) ?>
                </div>
        </div>
    <?php endforeach ?>

    <?php require 'templates/comment-form.php' ?>
</body>
</html>
