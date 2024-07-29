<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    Dear <?=x_html($account->displayName())?>,<br>
    Your password has changed.
    Now you can <a href="<?=Route::Url('account?action=login', null, true)?>">log in</a>.
</body>
</html>
