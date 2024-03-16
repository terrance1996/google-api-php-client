<?php include_once "templates/base.php" ?>
<?= pageHeader("PHP Library Examples"); ?>

<?php if (isset($_POST['api_key'])) : ?>
    <?php setApiKey($_POST['api_key']) ?>
    <span class="warn">
    API Key set!
    </span>
<?php endif ?>

<?php if (!getApiKey()) : ?>
<div class="api-key">
  <strong>You have not entered your API key</strong>
  <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
    API Key:<input type="text" name="api_key" placeholder="API-Key" required/>
    <input type="submit" value="Set API-Key"/>
  </form>
  <em>This can be found in the <a href="http://developers.google.com/console" target="_blank">Google API Console</em>
</div>
<?php endif ?>

<ul>
  <!-- <li><a href="books-test.php">A query using simple API access for books</a></li> -->
  <li><a href="books-test-input.php">A query input using simple API access for books</a></li>
</ul>

