{{-- Thin-line icons: @include('partials.lx-icon', ['i' => 'calendar', 'class' => '']) --}}
@php
    $paths = [
        'calendar'  => '<rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 9.5h17M8 3v4M16 3v4"/>',
        'clock'     => '<circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/>',
        'pin'       => '<path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0113 0c0 5.4-6.5 11-6.5 11z"/><circle cx="12" cy="10" r="2.3"/>',
        'award'     => '<circle cx="12" cy="9" r="5.5"/><path d="M8.6 13.4L7.5 21l4.5-2.5 4.5 2.5-1.1-7.6"/>',
        'lock'      => '<rect x="5" y="10.5" width="14" height="10" rx="2"/><path d="M8 10.5V7.5a4 4 0 018 0v3"/>',
        'card'      => '<rect x="3" y="5.5" width="18" height="13" rx="2"/><path d="M3 10h18M7 15h3"/>',
        'split'     => '<circle cx="6" cy="12" r="2.2"/><circle cx="12" cy="12" r="2.2"/><circle cx="18" cy="12" r="2.2"/><path d="M3 18.5h18"/>',
        'check'     => '<path d="M5 12.5l4.2 4.2L19 7"/>',
        'phone'     => '<path d="M5.5 4h3l1.5 4-2 1.3a11 11 0 005.7 5.7L15 13l4 1.5v3a2 2 0 01-2 2A15 15 0 013.5 6a2 2 0 012-2z"/>',
        'building'  => '<path d="M4 21V5.5A1.5 1.5 0 015.5 4h8A1.5 1.5 0 0115 5.5V21M15 10h3.5A1.5 1.5 0 0120 11.5V21M3 21h18M8 8h3M8 12h3M8 16h3"/>',
        'rings'     => '<circle cx="9" cy="14" r="5"/><circle cx="15" cy="14" r="5"/><path d="M10 4.5l2 2.5 2-2.5"/>',
        'family'    => '<circle cx="8" cy="7" r="2.5"/><circle cx="16" cy="7" r="2.5"/><circle cx="12" cy="13" r="2"/><path d="M4 20v-3a4 4 0 014-4M20 20v-3a4 4 0 00-4-4M9 21v-2a3 3 0 016 0v2"/>',
        'people'    => '<circle cx="9" cy="8" r="3"/><path d="M3.5 20a5.5 5.5 0 0111 0"/><circle cx="17" cy="9" r="2.3"/><path d="M15.5 14.3A4.5 4.5 0 0120.5 19"/>',
        'compass'   => '<circle cx="12" cy="12" r="8.5"/><path d="M15.5 8.5l-2 5-5 2 2-5z"/>',
        'chat'      => '<path d="M4 5.5h16v10H9l-5 4z"/>',
        'child'     => '<circle cx="12" cy="6.5" r="2.5"/><path d="M12 9v6M8 11.5l4 1.5 4-1.5M9.5 21l2.5-6 2.5 6"/>',
        'layers'    => '<path d="M12 4l8.5 4.5L12 13 3.5 8.5z"/><path d="M3.5 12.5L12 17l8.5-4.5M3.5 16.5L12 21l8.5-4.5"/>',
        'play'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M10 9.2v5.6l4.8-2.8z"/>',
        'arrow'     => '<path d="M15 6l-6 6 6 6"/>',
        'gift'      => '<rect x="3.5" y="9" width="17" height="11.5" rx="1.5"/><path d="M3.5 13h17M12 9v11.5M12 9c-1.5-3.5-5.5-4-5.5-1.5S10 9 12 9zm0 0c1.5-3.5 5.5-4 5.5-1.5S14 9 12 9z"/>',
        'whatsapp'  => '<path d="M4.5 19.5l1.2-3.6A8 8 0 1112 20a8 8 0 01-3.9-1z"/><path d="M9.2 8.6c.3 2.6 2.4 4.9 5 5.4l.9-1.2 1.8.8-.4 1.6c-3.6.4-7.6-3.3-7.3-7.1l1.6-.3.8 1.8z"/>',
    ];
@endphp
<svg class="lx-ico {{ $class ?? '' }}" viewBox="0 0 24 24" aria-hidden="true">{!! $paths[$i] ?? '' !!}</svg>
