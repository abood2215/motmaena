@extends('errors.brand')
@php $isAr = (rescue(fn () => session('locale'), null, false) ?? 'ar') !== 'en'; @endphp
@section('code', '429')
@section('heading', $isAr ? 'محاولات كثيرة' : 'Too many attempts')
@section('message', $isAr ? 'انتظر دقيقة وحاول مرة ثانية.' : 'Please wait a minute and try again.')
@section('action')
    <a class="primary" href="javascript:history.back()">{{ $isAr ? 'رجوع' : 'Go back' }}</a>
@endsection
