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
    $date = DateTime::createFromFormat('Y-m-d', $sqlDate);

    return $date->format('M d Y');
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

}
