//View blog posts
<?php
// Make pathway to the database, so SQLite/PDO can connect
$root = __DIR__;
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;

// Connection to the database, run a query, handle errors
$pdo = new PDO($dsn);
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
    array('id' => 1, )
);
if ($result === false)
{
    throw new Exception('There was a problem running this query');
}

// Access a row
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application |
            <?php echo htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    </head>
<body>
    <h1>Blog title</h1>
    <p>This paragraph summarizes what the blog is about.</p>

</body>
</html>
