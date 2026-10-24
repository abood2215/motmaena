@extends('errors.brand')
@php $isAr = (rescue(fn () => session('locale'), null, false) ?? 'ar') !== 'en'; @endphp
@section('code', '500')
@section('heading', $isAr ? 'صار خطأ مؤقت' : 'Something went wrong')
@section('message', $isAr ? 'نعتذر منك، صار خلل مؤقت عندنا. حاول بعد شوي، أو كلّمنا عالواتساب ونخدمك مباشرة.' : 'Sorry, we hit a temporary problem. Please try again shortly, or WhatsApp us and we will help right away.')
