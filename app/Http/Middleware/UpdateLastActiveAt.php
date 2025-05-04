public function handle($request, Closure $next)
{
if (auth()->check()) {
auth()->user()->update(['last_active_at' => now()]);
}

return $next($request);
}