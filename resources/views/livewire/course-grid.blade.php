<div class="container mx-auto px-4 relative z-10">

    <!-- Filters & Search -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 sm:mb-12 md:mb-16 gap-5 md:gap-8 animate-fade-in-up">
        <div class="w-full md:w-1/2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-2 sm:mb-4 inline-block relative">
                {{ __('Discover our courses') }}
                <span class="absolute -bottom-2 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-16 sm:w-24 h-1.5 bg-primary rounded-full"></span>
            </h2>
            <p class="text-sm sm:text-base text-[var(--muted-color)] max-w-xl mt-4">{{ __('Carefully thought educational paths') }}</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 w-full md:w-auto">
            <!-- Search Input -->
            <div class="relative w-full sm:w-auto">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('Search for a course') }}"
                    class="w-full sm:w-72 md:w-80 bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-2xl {{ app()->getLocale() == 'ar' ? 'px-5 pr-11' : 'px-11 pr-5' }} py-3 sm:py-4 text-sm focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all outline-none shadow-sm dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Level Filter -->
            <select wire:model.live="level" class="w-full sm:w-auto bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-2xl px-5 py-3 sm:py-4 text-sm focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all outline-none shadow-sm sm:min-w-[150px] dark:text-white">
                <option value="">{{ __('All Levels') }}</option>
                <option value="مبتديء">{{ __('Beginner') }}</option>
                <option value="متوسط">{{ __('Intermediate') }}</option>
                <option value="متقدم">{{ __('Advanced') }}</option>
                <option value="عام">{{ __('General') }}</option>
            </select>
        </div>
    </div>

    <!-- Course Grid -->
    @if($courses->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 md:gap-8 lg:gap-10">
        @foreach($courses as $course)
        <div class="card-premium group p-3 reveal" style="transition-delay: {{ $loop->index * 0.1 }}s">
            <div class="relative h-48 sm:h-56 md:h-64 rounded-xl overflow-hidden mb-4 sm:mb-6">
                <img src="{{ $course->image ?? 'https://placehold.co/600x400/b04141/white?text=' . urlencode($course->title) }}"
                    alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                @if($course->is_new)
                <div class="absolute top-3 left-3 glass-effect px-3 py-1 rounded-full text-xs font-bold text-primary shadow-lg border-primary/20">{{ __('New') }}</div>
                @endif

                <div class="absolute bottom-3 {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} bg-white/90 dark:bg-dark-surface/90 backdrop-blur px-2.5 py-1 rounded-lg text-xs font-bold text-gray-900 dark:text-white border border-white/20">
                    {{ __($course->level) }}
                </div>
            </div>
            <div class="px-3 sm:px-4 pb-3 sm:pb-4">
                <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 sm:mb-3 text-gray-900 dark:text-white group-hover:text-primary transition-colors duration-300 leading-snug">{{ $course->title }}</h3>
                <p class="text-[var(--muted-color)] text-xs sm:text-sm mb-4 sm:mb-6 leading-relaxed line-clamp-2">{{ $course->description }}</p>
                <div class="flex justify-between items-center pt-4 sm:pt-5 border-t border-gray-100 dark:border-dark-border">
                    <div>
                        <span class="text-[10px] sm:text-xs text-[var(--muted-color)] block mb-0.5 sm:mb-1">{{ __('Current Price') }}</span>
                        <span class="text-lg sm:text-xl md:text-2xl font-black text-primary">{{ number_format($course->price) }} <small class="text-[10px] sm:text-xs font-bold opacity-70">{{ __('SAR') }}</small></span>
                    </div>
                    <a href="#" class="btn-motmaena text-xs sm:text-sm px-4 sm:px-6 py-2 sm:py-2.5">{{ __('Register Now') }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="py-14 sm:py-20 text-center animate-fade-in-up">
        <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gray-50 dark:bg-dark-surface rounded-full flex items-center justify-center mx-auto mb-5 sm:mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-12 sm:w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <h3 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('No results found for') }} "{{ $search }}"</h3>
        <p class="text-sm text-[var(--muted-color)]">{{ __('Try searching with other words') }}</p>
    </div>
    @endif
</div>
