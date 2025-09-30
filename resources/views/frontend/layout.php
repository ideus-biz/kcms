<!doctype html>
<html class="l-html no-js" lang="<?=app()->getLocale()?>">
<head>
	<? include x_partview('layout-pre-import')?>
</head>
<body>
<!--[if IE]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->

<?if (Auth::Instance()->isAuthenticated()):?>
<div class="wrapper l-two-columns">
    <header id="header">
        <div class="header-top">
            <a href="<?=Route::Url('')?>" class="logo">
                <img class="desktop-logo" src="<?=x_uri_res('assets/images/logo.png')?>" width="248" height="55" alt="<?=x_spc(env('APP_NAME'))?> logo">
                <img class="mobile-logo" src="<?=x_uri_res('assets/images/logo.png')?>" width="79" height="40" alt="<?=x_spc(env('APP_NAME'))?> logo">
            </a>
            <span class="label"><?=x_html(env('APP_NAME'))?></span>
        </div>
        <div class="header-nav">
			<? include x_partview('layout-menu')?>
        </div>
        <div class="header-bottom">
            <!--<a href="<?/*=Route::Url('frontend:')*/?>" class="logout" target="_blank">
                <i class="logoIcon">
                  <span class="logoWeb"></span>
                </i>
                <span>Frontend site</span>
            </a>-->
            <a href="<?=Route::Url('account?action=logout')?>" class="logout">
                <i class="icon-logout"></i>
                <span>Logout</span>
            </a>
        </div>
    </header>
    <main>
        <?=$TEMPLATE?>

		<? include x_partview('layout-footer')?>
    </main>

</div>
<?else:?>
    <div class="wrapper">
        <header id="header">
            <div class="container">
                <a href="<?=Route::Url('')?>" class="logo"><img class="desktop-logo" src="<?=x_uri_res('assets/images/logo.png')?>" width="248" height="55" alt="<?=x_spc(env('APP_NAME'))?> logo"></a>
            </div>
        </header>
        <main>
			<?=$TEMPLATE?>
        </main>
        <? include x_partview('layout-footer')?>
    </div>
<?endif;?>

<? include x_partview('layout-post-import')?>

</body>
</html>
