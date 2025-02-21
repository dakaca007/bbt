// search.php
$searchTerm = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
$stmt = $conn->prepare("
    SELECT *, MATCH(title, content) AGAINST(:term IN BOOLEAN MODE) AS score
    FROM forum_threads
    WHERE MATCH(title, content) AGAINST(:term IN BOOLEAN MODE)
    ORDER BY score DESC
");
$stmt->bindValue(':term', $searchTerm);
$stmt->execute();
