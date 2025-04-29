@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Hi, {{ Auth::user()->name }}!</h1>

    @include('components.alerts')

    <!-- 🎉 Congratulations Message -->
    @if ($pendingTasks == 0)
      <div class="bg-green-50 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow mb-8 animate-fade-up">
        <div class="flex items-center gap-2">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
          </svg>
          <div class="text-lg font-semibold">
            Selamat 🎉 Semua tugas kamu sudah selesai!
          </div>
        </div>
      </div>
    @endif

    <!-- Tabs -->
    <div class="bg-white p-6 rounded shadow mb-10">
      <h2 class="text-xl font-bold mb-4">Tugas Saya</h2>

      <!-- Tab Buttons -->
      <div class="flex flex-wrap gap-4 mb-6 border-b">
        <button type="button"
          class="tab-button text-sm font-semibold px-4 py-2 border-b-2 border-blue-600 text-blue-600 active"
          data-tab="tasks-tab">
          Daftar Tugas
        </button>
        <button type="button"
          class="tab-button text-sm font-semibold px-4 py-2 border-b-2 border-transparent hover:border-gray-300"
          data-tab="submitted-tab">
          Dikirim
        </button>
        <button type="button"
          class="tab-button text-sm font-semibold px-4 py-2 border-b-2 border-transparent hover:border-gray-300"
          data-tab="completed-tab">
          Selesai
        </button>
      </div>

      <!-- Tab Contents -->
      <div id="tasks-tab" class="tab-content">
        @if ($tasks->isEmpty())
          <p class="text-gray-600">Tidak ada tugas yang perlu dikerjakan saat ini.</p>
        @else
          <ul class="divide-y divide-gray-200">
            @foreach ($tasks as $task)
              <li class="py-4 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">{{ $task->title }}</h3>
                  <p class="text-sm text-gray-500">Batas waktu:
                    {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
                </div>
                <a href="{{ route('submissions.create', $task->id) }}"
                  class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm text-center">
                  Kerjakan Tugas
                </a>
              </li>
            @endforeach
          </ul>
        @endif
      </div>

      <div id="submitted-tab" class="tab-content hidden">
        @if ($submittedTasks->isEmpty())
          <p class="text-gray-600">Belum ada tugas yang dikirim.</p>
        @else
          <ul class="divide-y divide-gray-200">
            @foreach ($submittedTasks as $task)
              <li class="py-4 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">{{ $task->title }}</h3>
                  <p class="text-sm text-gray-500">Dikirim pada:
                    {{ \Carbon\Carbon::parse($task->submitted_at)->format('d M Y H:i') }}</p>
                </div>
                <span class="px-4 py-2 rounded bg-yellow-400 text-white text-sm text-center">
                  Menunggu Review
                </span>
              </li>
            @endforeach
          </ul>
        @endif
      </div>

      <div id="completed-tab" class="tab-content hidden">
        @if ($completedTasks->isEmpty())
          <p class="text-gray-600">Belum ada tugas yang selesai.</p>
        @else
          <ul class="divide-y divide-gray-200">
            @foreach ($completedTasks as $task)
              <li class="py-4 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">{{ $task->title }}</h3>
                  <p class="text-sm text-gray-500">
                    Selesai pada: {{ \Carbon\Carbon::parse($task->submitted_at)->format('d M Y H:i') }}
                  </p>
                  <p class="text-sm text-gray-600 mt-1">
                    Kamu dapat skor <span class="font-semibold text-green-600">{{ $task->score }}</span>
                  </p>
                </div>
                <span class="px-4 py-2 rounded bg-green-500 text-white text-sm text-center">
                  Tugas Disetujui
                </span>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>

    <!-- Ringkasan -->
    <div class="flex flex-wrap gap-4 mb-8">
      <!-- Card 1: Tugas Belum Dikerjakan -->
      <div
        class="bg-red-100 text-red-800 rounded-lg px-4 py-4 shadow-sm flex flex-col justify-center items-center flex-1 min-w-0 animate-fade-up">
        <span class="text-xs md:text-sm text-center">Tugas Belum Dikerjakan</span>
        <span class="text-2xl md:text-3xl font-bold">{{ $pendingTasks }}</span>
      </div>

      <!-- Card 2: Tugas Dikirim -->
      <div
        class="bg-yellow-100 text-yellow-800 rounded-lg px-4 py-4 shadow-sm flex flex-col justify-center items-center flex-1 min-w-0 animate-fade-up delay-1">
        <span class="text-xs md:text-sm text-center">Tugas Dikirim</span>
        <span class="text-2xl md:text-3xl font-bold">{{ $submittedTasks->count() }}</span>
      </div>

      <!-- Card 3: Tugas Selesai -->
      <div
        class="bg-green-100 text-green-800 rounded-lg px-4 py-4 shadow-sm flex flex-col justify-center items-center flex-1 min-w-0 animate-fade-up delay-2">
        <span class="text-xs md:text-sm text-center">Tugas Selesai</span>
        <span class="text-2xl md:text-3xl font-bold">{{ $completedTasksCount }}</span>
      </div>

      <!-- Card 4 (Info User) -->
      <div class="hidden md:flex flex-1 bg-white rounded-lg px-6 py-4 shadow-sm animate-fade-up delay-3">
        <div class="flex flex-col justify-center">
          <h2 class="text-lg font-bold text-gray-700 mb-2">Informasi Peserta</h2>
          <div class="text-gray-600 space-y-1 text-sm">
            <div><strong>Nama:</strong> {{ auth()->user()->name }}</div>
            <div><strong>Organisasi:</strong> {{ auth()->user()->organization->username ?? '-' }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Grafik Progress -->
    <div class="bg-white p-6 rounded shadow mb-10">
      <h2 class="text-xl font-bold mb-4">Progress Tugas 30 Hari Terakhir</h2>
      <div class="overflow-x-auto">
        <canvas id="tasksChart" height="300"></canvas>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    #tasksChart {
      max-height: 300px;
    }

    .fade-in {
      animation: fadeIn 0.5s ease-in-out forwards;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(10px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('tasksChart').getContext('2d');
    const tasksChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: {!! json_encode($dates) !!},
        datasets: [{
            label: 'Belum Dikerjakan',
            data: {!! json_encode($pendingData) !!},
            borderColor: 'rgb(239,68,68)',
            backgroundColor: 'rgba(239,68,68,0.2)',
            tension: 0.4,
            fill: true,
          },
          {
            label: 'Tugas Dikirim',
            data: {!! json_encode($submittedData) !!},
            borderColor: 'rgb(234,179,8)',
            backgroundColor: 'rgba(234,179,8,0.2)',
            tension: 0.4,
            fill: true,
          },
          {
            label: 'Tugas Selesai',
            data: {!! json_encode($completedData) !!},
            borderColor: 'rgb(34,197,94)',
            backgroundColor: 'rgba(34,197,94,0.2)',
            tension: 0.4,
            fill: true,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
          },
          tooltip: {
            mode: 'index',
            intersect: false,
          }
        },
        interaction: {
          mode: 'nearest',
          intersect: false
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah Tugas'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Tanggal'
            }
          }
        }
      }
    });

    // Tab Switching (langsung jalan tanpa nunggu DOMContentLoaded)
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
      button.addEventListener('click', () => {
        const target = button.getAttribute('data-tab');

        tabButtons.forEach(btn => {
          btn.classList.remove('border-blue-600', 'text-blue-600');
          btn.classList.add('border-transparent');
        });
        button.classList.add('border-blue-600', 'text-blue-600');

        tabContents.forEach(content => {
          content.classList.add('hidden');
          content.classList.remove('fade-in');
        });

        const activeTab = document.getElementById(target);
        activeTab.classList.remove('hidden');

        setTimeout(() => {
          activeTab.classList.add('fade-in');
        }, 50);
      });
    });
  </script>
@endpush
