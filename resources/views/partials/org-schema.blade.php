{{-- The center as a local business for search engines (name, place, phone, social accounts, the supervising doctor).
     Only facts the site already shows: no ratings, prices or opening hours until the center confirms them. --}}
@php
    $orgAr = app()->getLocale() == 'ar';
    $orgSite = \App\Models\SiteSetting::current();
    $orgPhone = '+' . preg_replace('/\D/', '', (string) ($orgSite['phone'] ?? $orgSite['whatsapp'] ?? ''));
    $orgSchema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'ProfessionalService',
        '@id'         => route('home') . '#center',
        'name'        => $orgAr ? 'مركز مطمئنة' : 'Motmaena Center',
        'alternateName' => $orgAr ? 'Motmaena Center' : 'مركز مطمئنة',
        'description' => $orgAr
            ? 'مركز في الكويت للاستشارات الأسرية والتربوية والاجتماعية، وجلسات وباقات الأطفال، والدورات الحضورية والمسجّلة، بإشراف أ.د. طارق الحبيب.'
            : 'A center in Kuwait for family, parenting and social consultations, children\'s sessions and packages, and in-person and recorded courses, supervised by Prof. Dr. Tariq Al-Habib.',
        'url'         => route('home'),
        'logo'        => asset('logo.webp'),
        'image'       => asset('photos/center-reception.webp'),
        'telephone'   => $orgPhone,
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $orgSite[$orgAr ? 'address_ar' : 'address_en'] ?? '',
            'addressCountry'  => 'KW',
        ],
        // The point on the map embedded in the footer
        'geo'         => ['@type' => 'GeoCoordinates', 'latitude' => 29.3901935, 'longitude' => 47.9907505],
        'areaServed'  => ['@type' => 'Country', 'name' => $orgAr ? 'الكويت' : 'Kuwait'],
        // Opening hours and price range as given by the center (config/center.php)
        'openingHoursSpecification' => [[
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => config('center.hours.days'),
            'opens'     => config('center.hours.opens'),
            'closes'    => config('center.hours.closes'),
        ]],
        'priceRange'  => config('center.prices.specialist') . '–' . config('center.prices.dr_tariq_first') . ' KWD',
        'founder'     => [
            '@type'    => 'Person',
            'name'     => config('doctor.name.' . ($orgAr ? 'ar' : 'en')),
            'jobTitle' => config('doctor.title.' . ($orgAr ? 'ar' : 'en')),
        ],
        'knowsAbout'  => $orgAr
            ? ['استشارات زوجية', 'استشارات أسرية', 'استشارات تربوية', 'استشارات اجتماعية', 'تطوير الذات', 'جلسات الأطفال', 'دورات تدريبية']
            : ['Marital counselling', 'Family counselling', 'Parenting guidance', 'Social counselling', 'Self-development', 'Children\'s sessions', 'Training courses'],
        'sameAs'      => [
            'https://www.instagram.com/motmaena_kw/',
            'https://www.facebook.com/motmaenakw',
            'https://www.tiktok.com/@motmaena_kw',
        ],
    ];
@endphp
@push('structured-data')
<script type="application/ld+json">{!! json_encode($orgSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush
