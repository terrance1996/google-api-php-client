<?php
/*
 * Copyright 2013 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

include_once __DIR__ . '/../vendor/autoload.php';
include_once "templates/base.php";

echo pageHeader("Simple API Access");

/************************************************
  We create the client and set the simple API
  access key. If you comment out the call to
  setDeveloperKey, the request may still succeed
  using the anonymous quota.
 ************************************************/
$client = new Google\Client();
$client->setApplicationName("GoogleConsoleExample");

// Warn if the API key isn't set.
if (!$apiKey = getApiKey()) {
    echo missingApiKeyWarning();
    return;
}

$client->setDeveloperKey($apiKey);

$service = new Google\Service\Books($client);


$client->setDefer(true);
$query = 'Harry Potter';
$optParams = [
    'filter' => 'free-ebooks',
];
$request = $service->volumes->listVolumes($query, $optParams);
$resultsDeferred = $client->execute($request);

?>

<h3>Results Of Deferred Call:</h3>
<?php foreach ($resultsDeferred as $item) : ?>
    <?php echo "Title:    ";?><?= $item['volumeInfo']['title'] ?>
  <br />
  <?php echo "Subtitle:    ";?><?= $item['volumeInfo']['subtitle'] ?>
  <br />
  <?php echo "Author:     ";?><?= $item['volumeInfo']['authors'][0] ?>
  <br />
  <?php echo "Link:     ";?><?= $item['volumeInfo']['canonicalVolumeLink']?>
  <br />
  <?php var_dump($item['volumeInfo']) ?>
  <br />
<?php endforeach ?>
