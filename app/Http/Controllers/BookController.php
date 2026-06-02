<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Book::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        
        // Paginate by 6 items for grid aesthetic
        $books = $query->latest()->paginate(6)->withQueryString();
        
        // Dashboard Stats
        $stats = [
            'total' => Book::count(),
            'categories' => Book::distinct('category')->count(),
            'latest' => Book::latest()->first(),
        ];
        
        return view('books.index', compact('books', 'search', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get list of existing categories to help auto-suggest
        $categories = Book::distinct()->pluck('category')->filter()->toArray();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . (date('Y') + 2),
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ], [
            'title.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Nama penulis wajib diisi.',
            'publisher.required' => 'Nama penerbit wajib diisi.',
            'year.required' => 'Tahun terbit wajib diisi.',
            'year.integer' => 'Tahun terbit harus berupa angka.',
            'category.required' => 'Kategori buku wajib diisi.',
            'description.required' => 'Deskripsi buku wajib diisi.',
            'cover.image' => 'File harus berupa gambar.',
            'cover.mimes' => 'Format gambar harus jpeg, png, jpg, gif, webp, atau svg.',
            'cover.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $path;
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Book::distinct()->pluck('category')->filter()->toArray();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . (date('Y') + 2),
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ], [
            'title.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Nama penulis wajib diisi.',
            'publisher.required' => 'Nama penerbit wajib diisi.',
            'year.required' => 'Tahun terbit wajib diisi.',
            'year.integer' => 'Tahun terbit harus berupa angka.',
            'category.required' => 'Kategori buku wajib diisi.',
            'description.required' => 'Deskripsi buku wajib diisi.',
            'cover.image' => 'File harus berupa gambar.',
            'cover.mimes' => 'Format gambar harus jpeg, png, jpg, gif, webp, atau svg.',
            'cover.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }
            
            $path = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $path;
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
