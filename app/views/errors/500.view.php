<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Server error</title>
</head>
<body>
  <h1>Server Error</h1>
  <?php if (isset($message)): ?>
    <p><?= $message ?></p>
  <?php endif ?>
</body>
</html>