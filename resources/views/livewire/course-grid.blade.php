{{-- Recorded courses, in the quiet editorial look (partials/lx-styles): 12 at a time, then "show more". --}}
@php $isArG = app()->getLocale() == 'ar'; @endphp
<div class="lx" dir="{{ $isArG ? 'rtl' : 'ltr' }}">

    {{-- Heading, search and level --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-6">
        <div class="max-w-xl">
            <p class="lx-label mb-3">{{ $isArG ? 'دورات مسجّلة' : 'Recorded courses' }}</p>
            <h2 class="lx-h2 mb-3">{{ __('Discover our courses') }}</h2>
            <p class="lx-text">{{ __('Carefully thought educational paths') }}</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <label class="relative w-full sm:w-72">
                <span class="sr-only">{{ __('Search for a course') }}</span>
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="{{ __('Search for a course') }}" class="lx-input {{ $isArG ? '!pr-11' : '!pl-11' }}">
                <svg class="lx-ico absolute top-1/2 -translate-y-1/2 {{ $isArG ? 'right-4' : 'left-4' }} !w-[18px] !h-[18px] !stroke-[var(--muted)]" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="M20 20l-4.2-4.2"/></svg>
            </label>
            <select wire:model.live="level" class="lx-input lx-select sm:w-48" aria-label="{{ __('All Levels') }}">
                <option value="">{{ __('All Levels') }}</option>
                <option value="مبتديء">{{ __('Beginner') }}</option>
                <option value="متوسط">{{ __('Intermediate') }}</option>
                <option value="متقدم">{{ __('Advanced') }}</option>
                <option value="عام">{{ __('General') }}</option>
            </select>
        </div>
    </div>

    @if($courses->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
        @foreach($courses as $course)
        <article class="lx-card p-5 flex flex-col">
            <div class="flex items-start gap-4">
                {{-- Same doctor photo on every card: a small WebP copy, decorative (the title is next to it) --}}
                <img src="{{ asset('courses-img/dr-tariq-thumb.webp') }}" alt="" width="256" height="256" loading="lazy" decoding="async" class="w-12 h-12 rounded-full object-cover object-top shrink-0" style="border: 1px solid var(--line)">
                <div class="min-w-0">
                    <p class="text-xs font-bold lx-muted mb-1">{{ $isArG ? 'مسجّلة' : 'Recorded' }} · {{ $isArG ? 'أ.د. طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}</p>
                    <h3 class="font-extrabold leading-snug line-clamp-2" style="color: var(--ink)">{{ $course->title }}</h3>
                    {{-- 5-Star Rating: the same five stars on every course, not real ratings, so hidden (config/claims.php) --}}
                    @if(config('claims.show_unverified'))
                    <div class="flex items-center gap-0.5 text-[#b08a45] mt-2">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    @endif
                </div>
            </div>
            <a href="{{ $course->external_url ?? '#' }}" target="_blank" rel="noopener" class="mt-5 lx-btn lx-btn-outline w-full !py-2.5 text-sm">
                {{ $isArG ? 'سجّل الآن' : 'Enroll Now' }}
                <svg class="lx-ico !w-4 !h-4 {{ $isArG ? '' : 'rotate-180' }}" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>
            </a>
        </article>
        @endforeach
    </div>

    @if($total > $courses->count())
    <div class="text-center mt-10">
        <button type="button" wire:click="loadMore" wire:loading.attr="disabled" class="lx-btn lx-btn-outline">
            {{ $isArG ? 'عرض المزيد من الدورات' : 'Show more courses' }}
            <span class="lx-muted font-semibold">({{ $total - $courses->count() }})</span>
        </button>
    </div>
    @endif

    @else
    <div class="py-14 text-center">
        <h3 class="lx-h3 mb-2">{{ __('No results found for') }} "{{ $search }}"</h3>
        <p class="lx-muted font-semibold">{{ __('Try searching with other words') }}</p>
    </div>
    @endif
</div>
