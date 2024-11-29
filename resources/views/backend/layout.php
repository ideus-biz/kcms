<!doctype html>
<html class="l-html no-js" lang="<?=app()->getLocale()?>">
<head>
    <title><?=(isset($title)?"$title :: ":'').env('APP_NAME').' Administration' ?></title>
	<? include x_partview('layout-pre-import')?>
</head>
<body class="l-body -page_inner_page_<?=x_spc($pageStyleClass??kRequest()->routeNode()->name())?> <?=(kRequest()->routeNode()->name()?'-page_inner':'')?>">
<!--[if IE]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->

<div class="l-wrapper">
    <div class="l-aside admin-bg js-aside">
        <div class="b-asideControl">
            <button class="b-asideControl__btn hamburger hamburger--arrow js-asideControl" type="button">
                    <span class="hamburger-box">
                      <span class="hamburger-inner"></span>
                    </span>
            </button>
        </div>
        <div class="b-aside">
            <div class="l-siteLogo">
                <a class="b-siteLogo__link" itemprop="url" href="/">
                    <img class="b-siteLogo__icon" src="<?=x_uri_res('assets/img/logos/logo.png')?>" alt="" title="" itemprop="logo">
                </a>
            </div>
			
			<?x_partview_include('layout-menu')?>
        </div>
    </div>
    <div class="l-wrapperInner">
        <header class="l-siteHeader">
            <div class="b-siteHeader">
                <h1><?=x_lhtml($sectionTitle)?></h1>

                <div class="b-headerProfile">
					<?if(kAuth()->isAuthenticated()):?>
                        <div class="b-headerProfile__infoWrapper">
                            <div class="b-headerProfile__infoText">
                                <div class="b-headerProfile__name"><?=x_html(kAuthUser()->displayName())?></div>
                                <div class="b-headerProfile__status"><?=env('APP_NAME')?></div>
                            </div>

                            <div class="b-headerProfile__imgWrapper">
								<?if(kAuthUser()->photo->isFile()):?>
                                    <img class="b-headerProfile__img" src="<?=Resource_Image::Url(Auth::Instance()->user()->photo->file, 'avatar_profile')?>" alt="">
								<?endif;?>
                            </div>
                        </div>
						<? include x_partview('lang-menu')?>
                        <!--<a class="b-headerProfile__link" href="<?/*=\Kcms\Core\Route::Url(\App\Backend\Controller_Settings::RouteName())*/?>" aria-label="profile link"></a>-->
					<?else:?>
                        <div class="b-headerProfile__infoWrapper">
                            <div class="b-headerProfile__infoText">
                                <div class="b-headerProfile__name"><?=env('APP_NAME')?> Administration</div>
                            </div>
                        </div>
						<? include x_partview('lang-menu')?>
					<?endif;?>
                </div>
            </div>
        </header>

        <div class="l-content">

            <main class="l-contentText">
				<?=$TEMPLATE?>
            </main>
        </div><!--content-->
		
		<? include x_partview('layout-footer')?>
    </div><!--wrapperInner-->
</div><!--wrapper-->

<? include x_partview('layout-post-import')?>
</body>
</html>