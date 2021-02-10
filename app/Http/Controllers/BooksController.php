<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Books::all();
        return view('dashboard', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user=$request->user();
        if($user){
            return view('books.create', compact('user'));
        }else{
            return redirect()->route('books.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category'=> 'required',
            'quantity'=> 'required',
        ]);
        
        Books::create($request->all());

        return redirect()->route('books.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show(Books $book)
    // {
    //     return view('books.show', compact('book'));
        
    // }
    public function show(Books $book)
    {
        $category = Books::where('category', '=', $book->category)->inRandomOrder()->take(3)->get();
        $author = Books::where('author', '=', $book->author)->inRandomOrder()->take(3)->get();
        return view('books.show', [
            'book' => $book,
            'category' => $category,
            'author' => $author,

        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Books $book)
    {
        // retourne la vue
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Books $book)
    {
        $request->validate([
            'title'=>'required',
            'author'=>'required',
            'category'=>'required',
            'quantity'=>'required',
        ]);

        $book->update($request->all());
        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Books $book)
    {
        $book->delete($book);
        return redirect()->route('books.index');
    }

    
}
