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
