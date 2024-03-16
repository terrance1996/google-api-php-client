<!-- Search Form -->

<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once "templates/base.php";

echo pageHeader("Simple API Access");

$client = new Google\Client();
$client->setApplicationName("Hello");

// Warn if the API key isn't set.
if (!$apiKey = getApiKey()) {
    echo missingApiKeyWarning();
    return;
}

$client->setDeveloperKey($apiKey);

$service = new Google\Service\Books($client);
// Check if search query parameter is set
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
    <input type="text" name="query" placeholder="Enter your search query" value="<?php echo isset ($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
    <button type="submit">Search</button>
</form>

<?php if (isset ($_GET["query"]) && !empty (trim($_GET["query"]))): ?>
    <?php
    $client->setDefer(true);
    $query = $_GET['query'];
    $optParams = [
        'filter' => 'free-ebooks',
    ];
    $request = $service->volumes->listVolumes($query, $optParams);
    $resultsDeferred = $client->execute($request);

    // Display search results in a table
    ?>
    <?php if (!empty ($resultsDeferred)): ?>
        <?php
        echo "<h2>Search Results</h2>";
        echo "<table border='2'>";
        echo "<tr><th>Title</th><th>Subtitle</th><th>author</th></tr>";
        ?>
        <?php foreach ($resultsDeferred as $item): ?>
            <?php echo "<tr><td>"; ?>
            <?= "<a href='" . $item['volumeInfo']['canonicalVolumeLink'] . "'>" . $item['volumeInfo']['title'] . "</a>" ?>
            <?php echo "</td><td>"; ?>
            <?= $item['volumeInfo']['subtitle'] ?>
            <?php echo "</td><td>"; ?>
            <?php if (is_array($item['volumeInfo']['authors'])): ?>
                <?= implode(', ', $item['volumeInfo']['authors']) ?>
            <?php endif; ?>
            <?php echo "</td><tr>"; ?>
        <?php endforeach ?>
        <?php echo "</table>"; ?>
    <?php else: ?>
        <?php echo "<p>No results found for '$query'.</p>"; ?>
    <?php endif; ?>
<?php endif; ?>