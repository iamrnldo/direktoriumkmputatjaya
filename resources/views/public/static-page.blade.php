@extends('layouts.app')
@section('title', $page->title ?? 'Halaman')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-10 text-white text-center">
                <h1 class="text-3xl font-extrabold">{{ $page->title ?? 'Halaman' }}</h1>
            </div>
            <div class="p-8 prose prose-slate max-w-none">
                {!! $page->content ?? 'Konten belum tersedia.' !!}
            </div>
        </div>
    </div>
</div>
@endsection
