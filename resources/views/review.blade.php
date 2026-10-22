@extends('layouts.app')

@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
@endphp

@section('title', ($isAr ? 'قيّم تجربتك' : 'Rate your experience') . ' - ' . __('Motmaena Center'))

@section('content')
<section class="py-12 sm:py-20 bg-[#eef1f6] dark:bg-[#0b1220]" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4 max-w-lg">
        <div class="rounded-3xl bg-white dark:bg-[#111a2b] shadow-xl border border-[#dbe3ef] dark:border-white/10 p-7 sm:p-9">

            @if(session('review_ok'))
                <div class="text-center">
                    <div class="text-5xl mb-4">🌷</div>
                    <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $isAr ? 'شكراً على رأيك!' : 'Thank you for your feedback!' }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 font-bold mb-6">{{ $isAr ? 'رأيك يساعدنا نطوّر ويساعد غيرك يختار.' : 'Your feedback helps us improve and helps others decide.' }}</p>
                    <a href="{{ route('home') }}" class="inline-block rounded-xl px-6 py-3 font-black text-white bg-primary">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
                </div>
            @else
                <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-1">{{ $isAr ? 'كيف كانت تجربتك؟' : 'How was your experience?' }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-bold mb-6">{{ $offer['title'][$lang] ?? '' }}</p>

                <form method="POST" action="{{ route('review.store', $registration->review_token) }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-gray-600 dark:text-gray-300 mb-2">{{ $isAr ? 'تقييمك' : 'Your rating' }}</label>
                        <div class="flex flex-row-reverse justify-end gap-1 text-4xl" id="stars">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="r{{ $i }}" class="peer hidden" @checked(old('rating', $existing->rating ?? 5) == $i) required>
                                <label for="r{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400">★</label>
                            @endfor
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-600 dark:text-gray-300 mb-1.5">{{ $isAr ? 'رأيك بالدورة' : 'Your review' }}</label>
                        <textarea name="quote" rows="5" required minlength="5" maxlength="1000" class="w-full rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 px-4 py-3 text-sm font-bold text-gray-900 dark:text-white outline-none focus:border-primary">{{ old('quote', $existing->quote ?? '') }}</textarea>
                        @error('quote')<p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-600 dark:text-gray-300 mb-1.5">{{ $isAr ? 'اسمك' : 'Your name' }}</label>
                        <input name="name" value="{{ old('name', $registration->name) }}" required maxlength="120" class="w-full rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 px-4 py-3 text-sm font-bold text-gray-900 dark:text-white outline-none focus:border-primary">
                    </div>
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="show_name" value="1" checked class="accent-[#b04141]">
                        {{ $isAr ? 'أوافق على نشر رأيي باسمي في الموقع' : 'I agree to publish my review with my name' }}
                    </label>
                    <p class="text-xs text-gray-400 -mt-3">{{ $isAr ? 'إذا ألغيت الموافقة، يُنشر بالحرف الأول فقط.' : 'If unchecked, only your initial is shown.' }}</p>
                    <button class="w-full rounded-xl py-3.5 font-black text-white bg-primary hover:bg-primary-dark transition">{{ $isAr ? 'إرسال' : 'Send' }}</button>
                </form>
            @endif
        </div>
    </div>
</section>
@endsection
