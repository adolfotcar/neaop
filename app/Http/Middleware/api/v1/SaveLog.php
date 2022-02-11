<?php namespace App\Http\Middleware\api\v1;

use Closure;
use App\Models\api\v1\Syslog;

class SaveLog {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);

		Syslog::doLog();

		return $response;
	}

}