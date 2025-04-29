@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Buat Tugas Baru</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
      @include('tasks._form')
    </form>
  </div>
@endsection
