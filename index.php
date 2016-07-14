<?php

// Make pathway to the database, so SQLite/ PDO (PHP data object) can connect
$root = __DIR__;
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;

// Connection to the database, run a query, handle errors
$pdo = new PDO($dsn);
$stmt = $pdo->query(
        'SELECT
            title, created_at, body
        FROM
            post
        ORDER BY
            created_at DESC'
);
if ($stmt === false)
{
    throw new Exception('There was a problem running this query');
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>A blog application</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<h1>Blog title</h1>
<p>This paragraph summarizes what the blog is about.</p>

<p>
    <a href="#">Read more...</a>
</p>
</body>
</html>