@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

@section('content')
  <div class="container mx-auto text-center py-24">
    <h1 class="text-6xl font-bold text-red-600">403</h1>
    <p class="text-xl mt-4">Kamu tidak punya izin untuk mengakses halaman ini.</p>

    @if (isset($exception) && $exception->getMessage())
      <p class="text-sm text-gray-600 mt-2 italic">Catatan: {{ $exception->getMessage() }}</p>
    @endif

    <a href="{{ url()->previous() }}" class="mt-6 inline-block text-blue-600 underline">Kembali</a>
  </div>
@endsection
