<?php

/**
 * Get root path of the project
 *
 * @return string
 */
function getRootPath()
{
    return realpath(__DIR__ . '/..');
}

/**
 *  Retrieves the full path for the database file
 *
 * @return string
 */
function getDatabasePath()
{
    return getRootPath() . '/data/data.sqlite';
}

/**
 * Retrieves the DSN for the SQLite connection
 *
 * @return string
 */
function getDsn()
{
    return 'sqlite:' . getDatabasePath();
}

/**
 * Retrives the PDO (PHP Data Object) for database access
 *
 * @return \PDO
 */
function getPDO()
{
    return new PDO(getDsn());
}

/**
 * Escapes HTML so it is safe to output
 *
 * @param string $html
 * @return string
 */
function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

/**
 * Changes the default date style for easy reading
 *
 *@param  $sqlDate
 *return string
 */
function convertSqlDate($sqlDate)
{
    /* @var $date DateTime */
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $sqlDate);

    return $date->format('M d Y');
}

/**
 * Accounts for if the user is requesting a blog post which does not exist
 * @param $script
 */
function redirectAndExit($script)
{
    //Get the domain-relative URL and filepath
    $relativeUrl = $_SERVER['PHP_SELF'];
    $urlFolder = substr(relativeUrl, 0, strrpos($relativeUrl, '/') + 1);

    // Redirect to the full URL
    $host = $_SERVER['HTTP_HOST'];
    $fullUrl = 'http://' . $host . $urlFolder . $script;
    header('Location: ' . $fullUrl);
    exit();
}

/**
 * Returns the number of comments for the specified post
 *
 * @param integer $postId
 * @return integer
 */
function countCommentsForPost($postId)
{
    $pdo = getPDO();
    $sql = "
        SELECT
            COUNT(*) C
        FROM
           comments
        WHERE
           post_id = :post_id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array('post_id' => $postId, )
    );

    return (int) $stmt->fetchColumn();
}

/**
 * Returns all the comments for the specified post
 *
 * @param integer $postId
 * @return associative array
 */
function getCommentsForPost($postId)
{
    $pdo = getPDO();
    $sql = "
        SELECT
            id, name, text, created_at, website
        FROM
            comments
        WHERE
            post_id = :post_id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array('post_id' => $postId, )
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}