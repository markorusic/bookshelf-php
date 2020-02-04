<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bad Request</title>
</head>
<body>
  <h1>Bad Request</h1>
  <?php if (isset($errors) && count($errors) > 0): ?>
    <h3>Errors:</h3>
    <ul>
      <?php foreach($errors as $error): ?>
        <li><?= $error ?></li>
      <?php endforeach ?>
    </ul>
  <?php endif ?>
</body>
</html>
