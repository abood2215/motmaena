<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Remembers where a visitor came from (UTM tags or the referring site) for the
 * rest of their visit, so a registration can be credited to the right ad/channel.
 * The latest tagged visit wins; an untagged visit never overwrites tagged data.
 */
class TrackVisitSource
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('get') && !$request->is('admin*')) {
            if ($request->filled('utm_source')) {
                session(['visit_source' => [
                    'utm_source'   => mb_substr($request->query('utm_source'), 0, 100),
                    'utm_medium'   => mb_substr((string) $request->query('utm_medium'), 0, 100) ?: null,
                    'utm_campaign' => mb_substr((string) $request->query('utm_campaign'), 0, 150) ?: null,
                    'referrer'     => $this->externalReferrer($request),
                ]]);
            } elseif (!session()->has('visit_source') && ($ref = $this->externalReferrer($request))) {
                session(['visit_source' => ['utm_source' => null, 'utm_medium' => null, 'utm_campaign' => null, 'referrer' => $ref]]);
            }
        }

        return $next($request);
    }

    private function externalReferrer(Request $request): ?string
    {
        $host = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST);

        return $host && $host !== $request->getHost() ? mb_substr($host, 0, 255) : null;
    }
}
