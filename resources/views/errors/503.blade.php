@extends('errors.brand')
@php $isAr = (rescue(fn () => session('locale'), null, false) ?? 'ar') !== 'en'; @endphp
@section('code', '🛠')
@section('heading', $isAr ? 'نحدّث الموقع' : 'Updating the site')
@section('message', $isAr ? 'نشتغل على تحديث سريع، ارجع بعد دقائق.' : 'We are making a quick update — please check back in a few minutes.')
