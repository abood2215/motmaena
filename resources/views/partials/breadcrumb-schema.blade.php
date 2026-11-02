{{-- BreadcrumbList structured data. $items: [[name, url], ...] after Home, which is always first.
     Every url is a real route of the site; the last item is the current page. --}}
@php
    $crumbs = array_merge([[app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home', route('home')]], $items);
    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => array_map(fn ($c, $i) => [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $c[0],
            'item'     => $c[1],
        ], $crumbs, array_keys($crumbs)),
    ];
@endphp
@push('structured-data')
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush
