{{-- An open in-person course as an event for search engines: date, place, price, trainer. $offer = CourseOffer::toOfferArray(), $offerKey. --}}
@php
    $evAr = app()->getLocale() == 'ar';
    $evLang = $evAr ? 'ar' : 'en';
    $evSite = \App\Models\SiteSetting::current();
    $evTopics = $offer['topics'][$evLang] ?? [];
    $evSchema = [
        '@context'            => 'https://schema.org',
        '@type'               => 'EducationEvent',
        'name'                => $offer['title'][$evLang],
        'description'         => $evTopics
            ? ($evAr ? 'محاور الدورة: ' : 'Course topics: ') . implode($evAr ? '، ' : ', ', $evTopics)
            : $offer['title'][$evLang] . ($evAr ? ' مع ' : ' with ') . $offer['trainer'][$evLang],
        'startDate'           => $offer['starts_at'],
        'eventStatus'         => 'https://schema.org/EventScheduled',
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'inLanguage'          => 'ar',
        'image'               => [asset($offer['share_image'] ?: 'og-default.jpg')],
        'url'                 => route('course.register', $offerKey),
        'location'            => [
            '@type'   => 'Place',
            'name'    => $evAr ? 'مركز مطمئنة' : 'Motmaena Center',
            'address' => [
                '@type'          => 'PostalAddress',
                'streetAddress'  => $evSite[$evAr ? 'address_ar' : 'address_en'] ?? '',
                'addressCountry' => 'KW',
            ],
        ],
        'organizer'           => ['@type' => 'Organization', 'name' => $evAr ? 'مركز مطمئنة' : 'Motmaena Center', 'url' => route('home')],
        'performer'           => ['@type' => 'Person', 'name' => $offer['trainer'][$evLang]],
        'offers'              => [
            '@type'         => 'Offer',
            'price'         => (string) $offer['price'],
            'priceCurrency' => 'KWD',
            'availability'  => $offer['is_full'] ? 'https://schema.org/SoldOut' : 'https://schema.org/InStock',
            'url'           => route('course.register', $offerKey),
        ],
    ];
@endphp
@push('structured-data')
<script type="application/ld+json">{!! json_encode($evSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush
