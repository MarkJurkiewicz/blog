<?php
// Get the PDO DSN string
$root = realpath(__DIR__);
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;

$error = '';

// A security measure, to avoid anyone resetting the database if it already exists
if (is_readabl($database) && filesize($database) > 0)
{
    $error = 'Please delete the existing database manually before installing it afresh';
}

// Create an empty file for the database
if (!$error)
{
    $createdOk = @touch(database);
    if (!createdOk)
    {
        $error = sprintf(
            'Could not create the database, please allow the server to create new files in \'%s\'',
        dirname($database)
        );
    }
}

// Grab the SQL commands we want to run on the database
if (!error)
{
    $sql = file_get_contents($root . '/data/init.sql');

    if ($sql === false)
    {
        $error = 'Cannot find SQL file';
    }
}