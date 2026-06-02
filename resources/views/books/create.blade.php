@extends('layouts.app')

@section('title', 'Tambah Buku Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header/Back Nav -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Buku Baru</h2>
            <p class="text-slate-500 mt-1">Lengkapi data buku di bawah ini untuk menambahkan ke katalog.</p>
        </div>
        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            <!-- Cover Image Preview & Upload Container -->
            <div class="space-y-3">
                <label class="block text-sm font-bold text-slate-700">Cover Buku</label>
                <div class="flex flex-col md:flex-row items-center gap-6 p-6 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50 hover:bg-slate-50 hover:border-indigo-300 transition-all">
                    <!-- Image Preview Element -->
                    <div class="w-32 aspect-[3/4] rounded-xl overflow-hidden bg-slate-200 shrink-0 border border-slate-200/60 shadow-sm flex items-center justify-center text-slate-400 relative">
                        <img id="cover-preview" src="#" alt="Pratinjau Cover" class="w-full h-full object-cover hidden">
                        <!-- Placeholder Icon -->
                        <div id="cover-placeholder" class="flex flex-col items-center gap-1.5 p-3 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[10px] font-semibold text-slate-400">Pratinjau</span>
                        </div>
                    </div>

                    <!-- Upload Input -->
                    <div class="flex-grow w-full text-center md:text-left space-y-2">
                        <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-3">
                            <label for="cover" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm shadow-md transition-all">
                                <span>Pilih File</span>
                                <input type="file" id="cover" name="cover" accept="image/*" class="sr-only" onchange="previewImage(event)">
                            </label>
                            <span class="text-xs text-slate-400 font-medium">Atau seret gambar ke sini</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Direkomendasikan format PNG, JPG, JPEG, atau WebP (Maks. 2MB)</p>
                        @error('cover')
                            <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Two-Column Fields (Desktop) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Buku -->
                <div class="space-y-1.5">
                    <label for="title" class="block text-sm font-bold text-slate-700">Judul Buku <span class="text-rose-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Laskar Pelangi" class="block w-full px-4 py-3 border @error('title') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-sm transition-all" required>
                    @error('title')
                        <p class="text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penulis / Author -->
                <div class="space-y-1.5">
                    <label for="author" class="block text-sm font-bold text-slate-700">Penulis <span class="text-rose-500">*</span></label>
                    <input type="text" id="author" name="author" value="{{ old('author') }}" placeholder="Contoh: Andrea Hirata" class="block w-full px-4 py-3 border @error('author') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-sm transition-all" required>
                    @error('author')
                        <p class="text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penerbit / Publisher -->
                <div class="space-y-1.5">
                    <label for="publisher" class="block text-sm font-bold text-slate-700">Penerbit <span class="text-rose-500">*</span></label>
                    <input type="text" id="publisher" name="publisher" value="{{ old('publisher') }}" placeholder="Contoh: Bentang Pustaka" class="block w-full px-4 py-3 border @error('publisher') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-sm transition-all" required>
                    @error('publisher')
                        <p class="text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Terbit / Year -->
                <div class="space-y-1.5">
                    <label for="year" class="block text-sm font-bold text-slate-700">Tahun Terbit <span class="text-rose-500">*</span></label>
                    <input type="number" id="year" name="year" value="{{ old('year', date('Y')) }}" min="1000" max="{{ date('Y') + 2 }}" placeholder="Contoh: 2005" class="block w-full px-4 py-3 border @error('year') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-sm transition-all" required>
                    @error('year')
                        <p class="text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori / Category -->
                <div class="space-y-1.5 md:col-span-2">
                    <label for="category" class="block text-sm font-bold text-slate-700">Kategori <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="text" id="category" name="category" value="{{ old('category') }}" placeholder="Contoh: Novel, Fiksi, Teknologi, Biografi..." list="categories-list" class="block w-full px-4 py-3 border @error('category') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-sm transition-all" required autocomplete="off">
                        
                        <!-- Suggestion Datalist -->
                        <datalist id="categories-list">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                    </div>
                    @error('category')
                        <p class="text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi Buku / Description -->
            <div class="space-y-1.5">
                <label for="description" class="block text-sm font-bold text-slate-700">Deskripsi Buku <span class="text-rose-500">*</span></label>
                <textarea id="description" name="description" rows="5" placeholder="Tuliskan ringkasan atau deskripsi sinopsis buku secara mendalam..." class="block w-full px-4 py-3 border @error('description') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-sm transition-all" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs font-semibold text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-slate-100 py-2">

            <!-- Submission Row -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('books.index') }}" class="px-6 py-3 font-semibold text-sm text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-100 hover:shadow-indigo-200 transition-all">
                    <!-- Save Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <span>Simpan Buku</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JS Pratinjau Cover -->
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('cover-preview');
        const placeholder = document.getElementById('cover-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
