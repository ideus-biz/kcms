<?php

namespace App\Http;


use Kcms\Core\Kernel as KcmsKernel;


class Kernel extends KcmsKernel
{
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 * 
	 * @var array
	 * @see parent::middlewareGroups['top']
	 */
	protected $middleware = [];
	
	
	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'proxies' => \App\Http\Middleware\TrustProxies::class,
		'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
	];
}
