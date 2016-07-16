<?php

/**
 * Retrieves a single post
 *
 * @param PDO $pdo
 * @param integer $postId
 * @throws Exception
 */
function getPostRow(PDO $pdo, $postId)
{
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
// Retrives a row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;

}

/**
 * Writes a comment to a particular post
 *
 * @param PDO $pdo
 * @param integer $postId
 * @param array $commentDate
 * @return array
 */
function addCommentToPost(PDO $pdo, $postId, array $commentData)
{
    $errors = array();

    // Do some validation
    if (empty($commentData['name'])) {
        $errors['name'] = 'A name is required';
    }
    if (empty($commendData['text'])) {
        $errors['text'] = 'A comment is required';
    }

    // If no errors present, attempt to write the comment
    if (!$errors) {
        $sql = "
            INSERT INTO
                comments
            (name, website, text, post_id)
            VALUES(:name, :website, :text, :post_id)
        ";
        $stmt = $pdo->prepare($sql);
        if ($stmt === false)
        {
            throw new Exception('Cannot prepare statement to insert comment');
        }
        $result = $stmt->execute(
            array_merge($commentData, array('post_id' => $postId, ))
        );

        if ($result === false)
        {
            //@todo this renders a database-level to the user, fix this
            $errorInfo = $pdo->errorInfo();
            if ($errorInfo)
            {
                $errors[] = $errorInfo[2];
            }
        }
    }

    return $errors;
}

