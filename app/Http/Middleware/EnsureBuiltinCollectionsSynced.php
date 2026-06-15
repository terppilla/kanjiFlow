<?php

namespace App\Http\Middleware;

use App\Services\BuiltinCollectionsSync;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBuiltinCollectionsSynced
{
    public function __construct(
        private readonly BuiltinCollectionsSync $builtinCollectionsSync,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user !== null) {
            $this->builtinCollectionsSync->syncForUserIfNeeded($user);
        }

        return $next($request);
    }
}
