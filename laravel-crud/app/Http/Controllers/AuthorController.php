<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Models\Book;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author ::all();
        return view('authors.index',compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {       
        // Lấy dữ liệu từ form
        $name = $request->input('name');
        
        // Tạo đối tượng tác giả và lưu vào cơ sở dữ liệu
        $author = new Author;
        $author->name = $name;
        $author->save();
        
        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return view('authors.show',compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }
    
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required',
        ]);
        
        // Lấy dữ liệu từ form
        $name = $request->input('name');
        
        // Tạo đối tượng tác giả và lưu vào cơ sở dữ liệu
        $author->name = $name;
        $author->save();
        
        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $books = Book::all();
        foreach($books as $book){
            if($book->author_id == $author->id){
                $book->delete();
            }
        }
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully');
    }
}