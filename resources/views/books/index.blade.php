@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<!-- Hero / Header Section -->
<div class="mb-10 text-center md:text-left md:flex md:items-center md:justify-between gap-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-8 md:p-12 text-white shadow-xl">
    <div class="space-y-4 max-w-2xl">
        <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
            Kelola Koleksi Buku <br class="hidden md:inline"><span class="bg-gradient-to-r from-indigo-400 to-violet-300 bg-clip-text text-transparent">Dengan Lebih Mudah</span>
        </h1>
        <p class="text-slate-300 text-base md:text-lg">
            Sistem katalog modern untuk mengelola judul, informasi penulis, penerbit, kategori, dan deskripsi buku perpustakaan Anda secara real-time.
        </p>
    </div>
    <div class="mt-6 md:mt-0 flex justify-center">
        <a href="{{ route('books.create') }}" class="inline-flex items-center space-x-2 px-6 py-4 text-base font-bold rounded-2xl bg-indigo-500 hover:bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all duration-300 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:rotate-90 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Buku Baru</span>
        </a>
    </div>
</div>

<!-- Dashboard Stats Banner -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
    <!-- Stat 1: Total Buku -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-all duration-300">
        <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Buku</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $stats['total'] }}</h3>
        </div>
    </div>
    
    <!-- Stat 2: Kategori Unik -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-all duration-300">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Kategori Unik</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $stats['categories'] }}</h3>
        </div>
    </div>

    <!-- Stat 3: Buku Terbaru -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-all duration-300">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Terbaru Ditambahkan</p>
            <h3 class="text-base font-bold text-slate-900 mt-1 truncate">
                {{ $stats['latest'] ? $stats['latest']->title : 'Belum ada buku' }}
            </h3>
        </div>
    </div>
</div>

<!-- Search Panel -->
<div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mb-10">
    <form action="{{ route('books.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan judul, penulis, penerbit atau kategori..." class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm placeholder-slate-400 transition-all bg-slate-50/50">
        </div>
        <div class="flex gap-2 shrink-0">
            @if($search)
                <a href="{{ route('books.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold text-sm transition-all flex items-center justify-center">
                    Reset
                </a>
            @endif
            <button type="submit" class="px-6 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm transition-all shadow-md flex-grow sm:flex-grow-0 flex items-center justify-center gap-2">
                <span>Cari</span>
            </button>
        </div>
    </form>
</div>

<!-- Catalog List -->
@if($books->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-3xl border border-slate-100 p-12 md:p-20 text-center shadow-sm">
        <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mx-auto text-slate-400 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 mb-2">Buku Tidak Ditemukan</h3>
        <p class="text-slate-500 max-w-md mx-auto mb-8">
            @if($search)
                Maaf, pencarian untuk "{{ $search }}" tidak mencocokkan buku mana pun dalam koleksi database. Silakan coba kata kunci lain.
            @else
                Saat ini belum ada data buku terdaftar. Silakan tekan tombol di bawah ini untuk menambahkan buku pertama Anda.
            @endif
        </p>
        @if($search)
            <a href="{{ route('books.index') }}" class="inline-flex items-center justify-center px-6 py-3 font-semibold rounded-xl bg-slate-900 hover:bg-slate-800 text-white transition-all">
                Tampilkan Semua Buku
            </a>
        @else
            <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center px-6 py-3 font-bold rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-100 transition-all">
                Tambah Buku Pertama
            </a>
        @endif
    </div>
@else
    <!-- Books Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
        @foreach($books as $book)
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <!-- Cover Section -->
                <div class="relative aspect-[3/4] bg-slate-100 overflow-hidden shrink-0">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <!-- Category Badge -->
                    <span class="absolute top-4 left-4 inline-flex items-center px-3  py-1.5 rounded-full text-xs font-bold bg-white/95 text-indigo-600 backdrop-blur-sm shadow-sm">
                        {{ $book->category }}
                    </span>
                    <!-- Published Year Badge -->
                    <span class="absolute top-4 right-4 inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-slate-900/90 text-slate-100 shadow-sm">
                        {{ $book->year }}
                    </span>
                </div>

                <!-- Info Section -->
                <div class="p-6 flex-grow flex flex-col">
                    <div class="mb-4 flex-grow">
                        <h4 class="text-xl font-bold text-slate-900 tracking-tight line-clamp-1 mb-1 group-hover:text-indigo-600 transition-colors">
                            {{ $book->title }}
                        </h4>
                        <p class="text-sm font-semibold text-slate-500 mb-3 flex items-center gap-1.5">
                            <span>Penulis:</span>
                            <span class="text-slate-700 font-medium">{{ $book->author }}</span>
                        </p>
                        <p class="text-xs text-slate-400 flex items-center gap-1.5">
                            <span>Penerbit:</span>
                            <span class="text-slate-500 font-medium">{{ $book->publisher }}</span>
                        </p>
                    </div>

                    <hr class="border-slate-100 mb-5">

                    <!-- Actions -->
                    <div class="flex items-center justify-between gap-2 mt-auto">
                        <div class="flex items-center gap-2">
                            <!-- View Detail -->
                            <a href="{{ route('books.show', $book->id) }}" class="inline-flex items-center justify-center p-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-indigo-600 hover:bg-slate-50 hover:border-indigo-100 transition-all" title="Detail Buku">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('books.edit', $book->id) }}" class="inline-flex items-center justify-center p-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-amber-600 hover:bg-slate-50 hover:border-amber-100 transition-all" title="Edit Buku">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </div>

                        <!-- Delete Form with Dynamic Alert -->
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirmDelete(event, '{{ $book->title }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center p-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-rose-600 hover:bg-slate-50 hover:border-rose-100 transition-all" title="Hapus Buku">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Container -->
    <div class="mt-8 flex justify-center">
        <div class="bg-white border border-slate-100 px-6 py-4 rounded-2xl shadow-sm w-full md:w-auto">
            {{ $books->links() }}
        </div>
    </div>
@endif

<!-- JS Confirm Delete handler -->
<script>
    function confirmDelete(event, title) {
        event.preventDefault();
        const form = event.currentTarget;
        // Basic fallback dialog styled elegantly
        if (confirm(`Apakah Anda yakin ingin menghapus buku "${title}" dari database? Tindakan ini tidak dapat dibatalkan.`)) {
            form.submit();
        }
    }
</script>
@endsection
