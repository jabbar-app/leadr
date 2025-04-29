@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold">Daftar Organisasi</h1>
      <a href="{{ route('organizations.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Organisasi</a>
    </div>

    @if (session('success'))
      <div class="mb-4 text-green-600 font-semibold">
        {{ session('success') }}
      </div>
    @endif

    <div class="overflow-x-auto">
      <table class="w-full bg-white rounded shadow">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Username</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Phone</th>
            <th class="p-3 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($organizations as $organization)
            <tr class="border-b">
              <td class="p-3">{{ $organization->name }}</td>
              <td class="p-3">{{ $organization->username }}</td>
              <td class="p-3">{{ $organization->email }}</td>
              <td class="p-3">{{ $organization->phone }}</td>
              <td class="p-3 flex gap-2">
                <a href="{{ route('pages.organization', $organization) }}" class="text-blue-600 hover:underline">Lihat</a>
                <a href="{{ route('organizations.edit', $organization) }}"
                  class="text-yellow-500 hover:underline">Edit</a>
                <form action="{{ route('organizations.destroy', $organization) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $organizations->links() }}
    </div>
  </div>
@endsection
