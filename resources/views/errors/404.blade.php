@extends('errors.brand')
@php $isAr = (rescue(fn () => session('locale'), null, false) ?? 'ar') !== 'en'; @endphp
@section('code', '404')
@section('heading', $isAr ? 'الصفحة غير موجودة' : 'Page not found')
@section('message', $isAr ? 'يمكن الرابط قديم أو فيه خطأ. تقدر ترجع للرئيسية وتلاقي الدورات والاستشارات.' : 'The link may be old or mistyped. Head back home to find our courses and consultations.')
@section('action')
    <a class="primary" href="/courses">{{ $isAr ? 'تصفّح الدورات' : 'Browse courses' }}</a>
@endsection
