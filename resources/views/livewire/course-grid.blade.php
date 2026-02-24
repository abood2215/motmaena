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
                    class="w-full sm:w-64 md:w-80 bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-2xl {{ app()->getLocale() == 'ar' ? 'px-4 pr-10' : 'px-10 pr-4' }} py-3 text-sm focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all outline-none shadow-sm dark:text-white">
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
        @foreach($courses as $course)

        {{-- Reveal wrapper: handles staggered entrance, no hover interference --}}
        <div class="reveal-scale h-full" style="transition-delay: {{ $loop->index * 0.08 }}s">

            {{-- Card: handles hover effects with no delay --}}
            <div class="group relative flex flex-col h-full bg-white dark:bg-dark-surface rounded-[2rem] overflow-hidden cursor-pointer
                        border border-[#f0eaea] dark:border-dark-border
                        transition-all duration-500
                        hover:-translate-y-2
                        hover:border-primary/20
                        hover:shadow-[0_28px_65px_-12px_rgba(176,65,65,0.22),_0_8px_22px_-4px_rgba(176,65,65,0.10)]"
                 style="box-shadow: 0 2px 10px rgba(0,0,0,0.06);">

                {{-- Shine sweep on hover --}}
                <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-[2rem] z-30">
                    <div class="card-shine-inner"></div>
                </div>

                {{-- Top accent bar: slides in from right on hover --}}
                <div class="h-[3px] bg-gradient-to-l from-primary via-primary-light to-primary/20
                            origin-right scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out shrink-0"></div>

                <!-- TOP SECTION: Presentation Graphic -->
                <div class="relative h-52 overflow-hidden">
                    {{-- Warm gradient background --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-[#fff4f4] via-[#fef8f5] to-[#fafafa]
                                dark:from-[#201818] dark:via-[#1e1a18] dark:to-[#1a1a1a]
                                transition-all duration-700 group-hover:from-[#ffeeee]"></div>

                    {{-- Dot pattern --}}
                    <div class="absolute inset-0 opacity-[0.07] pointer-events-none z-10"
                         style="background-image: radial-gradient(#b04141 1.5px, transparent 1.5px); background-size: 16px 16px;"></div>

                    {{-- Fade to card bg at bottom --}}
                    <div class="absolute bottom-0 inset-x-0 h-14 bg-gradient-to-t from-white dark:from-dark-surface to-transparent z-20 pointer-events-none"></div>

                    {{-- Decorative circle (top right, expands on hover) --}}
                    <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-primary/5 dark:bg-primary/10
                                transition-all duration-700 group-hover:scale-[1.7] group-hover:bg-primary/8"></div>

                    {{-- Small warm accent circle (bottom left) --}}
                    <div class="absolute -left-4 bottom-0 w-20 h-20 rounded-full bg-amber-50/70 dark:bg-dark-border/20
                                transition-all duration-700 group-hover:scale-125"></div>

                    {{-- Profile image (circular, glows on hover) --}}
                    <div class="absolute bottom-3 left-4 z-20">
                        <div class="relative w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-full overflow-hidden
                                    border-[3px] border-white dark:border-dark-surface shadow-lg
                                    transition-all duration-500
                                    group-hover:scale-105
                                    group-hover:shadow-[0_8px_28px_rgba(176,65,65,0.22)]">
                            <img src="{{ (isset($course->image) && file_exists(public_path($course->image))) ? asset($course->image) : asset('courses/dr-tariq.png') }}"
                                 alt="{{ $course->title }}"
                                 class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-112">
                        </div>
                    </div>

                    {{-- Course label + title (right side) --}}
                    <div class="absolute top-5 right-5 z-20 text-right" style="max-width: 57%">
                        {{-- Pill badge with live dot --}}
                        <span class="inline-flex items-center gap-1.5 bg-primary/8 border border-primary/25 text-primary
                                     text-[10px] font-bold px-3 py-1 rounded-full mb-2.5 tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary badge-live-dot shrink-0"></span>
                            {{ app()->getLocale() == 'ar' ? 'دورة' : 'COURSE' }}
                        </span>
                        {{-- Title --}}
                        <h4 class="text-base sm:text-xl md:text-2xl font-black text-[#5a4a42] dark:text-white leading-[1.2] line-clamp-3
                                   transition-colors duration-300 group-hover:text-primary">
                            {{ $course->title }}
                        </h4>
                    </div>
                </div>

                <!-- BOTTOM SECTION: Academic Details -->
                <div class="flex-1 p-5 flex flex-col bg-white dark:bg-dark-surface border-t border-[#f8eeee] dark:border-dark-border">
                    <div class="flex flex-col items-end text-right w-full">
                        {{-- "Recorded" badge with live dot --}}
                        <span class="inline-flex items-center gap-1.5 bg-[#fff0f0] dark:bg-primary/10 text-primary
                                     text-[10px] font-black px-3 py-1 rounded-lg mb-3 self-end">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary badge-live-dot shrink-0"></span>
                            {{ app()->getLocale() == 'ar' ? 'مسجلة' : 'Recorded' }}
                        </span>

                        {{-- Title (detail row) --}}
                        <h3 class="text-[16px] font-black text-[#5a4a42] dark:text-white mb-1 leading-tight line-clamp-2
                                   transition-colors duration-300 group-hover:text-[#3d2e28] dark:group-hover:text-white">
                            {{ $course->title }}
                        </h3>

                        {{-- Instructor --}}
                        <span class="text-xs font-semibold text-gray-400 mb-3 block">أ.د طارق الحبيب</span>

                        {{-- 5-Star Rating --}}
                        <div class="flex items-center gap-0.5 text-[#f59e0b] mb-4">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-3.5 h-3.5 fill-current transition-transform duration-300 group-hover:scale-110"
                                 style="transition-delay: {{ $i * 0.05 }}s" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                    </div>

                    <!-- Footer: CTA Button -->
                    <div class="mt-auto pt-4 border-t border-gray-50 dark:border-dark-border">
                        <a href="{{ $course->external_url ?? '#' }}" target="_blank"
                           class="flex items-center justify-center gap-2 w-full
                                  bg-primary/8 hover:bg-primary
                                  border border-primary/30 hover:border-primary
                                  text-primary hover:text-white
                                  text-sm font-black
                                  px-5 py-2.5 rounded-xl
                                  transition-all duration-300
                                  hover:shadow-lg hover:shadow-primary/25
                                  hover:-translate-y-0.5
                                  group/btn">
                            <span>{{ app()->getLocale() == 'ar' ? 'سجل الآن' : 'Enroll Now' }}</span>
                            <svg class="w-4 h-4 transition-transform duration-300
                                        {{ app()->getLocale() == 'ar' ? 'rotate-180 group-hover/btn:-translate-x-1' : 'group-hover/btn:translate-x-1' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
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
