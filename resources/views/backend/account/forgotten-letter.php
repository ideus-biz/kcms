<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    Dear <?=x_html($account->displayName())?>,<br>
    Please go to <a href="<?=Route::Url(Auth::Instance()->actionConfig('reset')->url, null, true).'?token='.$account->user->resetToken?>">Reset account password</a> page<br/>
    and set up your new password.
</body>
</html>
