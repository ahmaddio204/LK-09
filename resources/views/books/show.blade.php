@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb / Back button -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Katalog</span>
        </a>

        <!-- Fast Edit controls -->
        <div class="flex gap-2">
            <a href="{{ route('books.edit', $book->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-bold rounded-xl bg-amber-500 hover:bg-amber-600 text-white shadow-sm transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Ubah</span>
            </a>
            
            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirmDelete(event, '{{ $book->title }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold rounded-xl bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Details Card Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-12 p-8 md:p-12">
            <!-- Left Side: High-res Cover Image -->
            <div class="md:col-span-4 flex flex-col items-center">
                <div class="w-full max-w-[280px] aspect-[3/4] rounded-2xl overflow-hidden bg-slate-100 shadow-md border border-slate-200/50 hover:shadow-xl transition-all duration-300">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                </div>
                <div class="mt-4 text-center">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                        {{ $book->category }}
                    </span>
                </div>
            </div>

            <!-- Right Side: Extensive Metadata & Description -->
            <div class="md:col-span-8 flex flex-col justify-between">
                <div>
                    <!-- Title & Basic Info -->
                    <div class="space-y-3 pb-6 border-b border-slate-100">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                            {{ $book->title }}
                        </h1>
                        <p class="text-lg text-slate-500 font-semibold flex items-center gap-1.5">
                            <span>Oleh:</span>
                            <span class="text-slate-800 font-bold bg-slate-50 px-3 py-1 rounded-lg border border-slate-100">{{ $book->author }}</span>
                        </p>
                    </div>

                    <!-- Book Metadata Grid -->
                    <div class="grid grid-cols-2 gap-4 py-6 border-b border-slate-100">
                        <div>
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Penerbit</span>
                            <strong class="text-slate-800 text-sm font-semibold">{{ $book->publisher }}</strong>
                        </div>
                        <div>
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Tahun Terbit</span>
                            <strong class="text-slate-800 text-sm font-semibold">{{ $book->year }}</strong>
                        </div>
                        <div>
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Kategori</span>
                            <strong class="text-slate-800 text-sm font-semibold">{{ $book->category }}</strong>
                        </div>
                        <div>
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Terakhir Diperbarui</span>
                            <strong class="text-slate-800 text-sm font-semibold">{{ $book->updated_at->diffForHumans() }}</strong>
                        </div>
                    </div>

                    <!-- Description Area -->
                    <div class="py-6 space-y-3">
                        <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Sinopsis / Deskripsi</span>
                        <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line text-justify bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                            {{ $book->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Confirm Delete handler -->
<script>
    function confirmDelete(event, title) {
        event.preventDefault();
        const form = event.currentTarget;
        if (confirm(`Apakah Anda yakin ingin menghapus buku "${title}" dari database? Tindakan ini tidak dapat dibatalkan.`)) {
            form.submit();
        }
    }
</script>
@endsection
