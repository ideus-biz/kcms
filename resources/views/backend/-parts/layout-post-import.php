<script src="<?=x_uri_res('assets/js/vendor/jquery-3.7.1.min.js', 'base')?>"></script>
<script src="<?=x_uri_res('js/jquery.inputmask.min.js', 'base')?>"></script>
<script src="<?=x_uri_res('tinymce/tinymce.min.js', 'base')?>"></script>
<script src="<?=x_uri_res('tinymce/config.js', 'base')?>"></script>
<script src="<?=x_uri_res('js/phone-format.js', 'base')?>"></script>
<!--<script src="--><?//=x_uri_res('jbox/jBox.js', 'base')?><!--"></script>-->
<script src="<?=Resource_Js::Url('config')?>"></script>
<script src="<?=Resource_Js::Url('active/module.js')?>"></script>
<script src="<?=x_uri_res('assets/js/scripts.js')?>"></script>
<script src="<?=x_uri_res('assets/js/project.js')?>"></script>
<!--<script async src="//maps.googleapis.com/maps/api/js?key=--><?//=config('kcms.geo.google.default.mapKey')?><!--&language=--><?//=\Kcms\Core\Locale::Instance()->getLang()?><!--&callback=initGMap"></script>-->
<script>
	(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
		key: "<?=config('kcms.geo.google.default.mapKey')?>",
		v: "weekly", // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
		language: "<?=\Kcms\Core\Locale::Instance()->getLang()?>",
	});
</script>
