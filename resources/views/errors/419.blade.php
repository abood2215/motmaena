@extends('errors.brand')
@php $isAr = (rescue(fn () => session('locale'), null, false) ?? 'ar') !== 'en'; @endphp
@section('code', '⏱')
@section('heading', $isAr ? 'انتهت مدة الصفحة' : 'This page expired')
@section('message', $isAr ? 'الصفحة كانت مفتوحة فترة طويلة. ارجع للصفحة السابقة وحدّثها، وبعدين أعد المحاولة — ما انخصم منك أي مبلغ.' : 'The page was open for a long time. Go back, refresh it and try again — you have not been charged.')
@section('action')
    <a class="primary" href="javascript:history.back()">{{ $isAr ? 'ارجع وحاول مرة ثانية' : 'Go back and try again' }}</a>
@endsection
