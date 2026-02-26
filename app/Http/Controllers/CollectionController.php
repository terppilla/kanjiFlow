<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // ВСЕ методы возвращают представление "в разработке"
    public function index()
    {
        return view('user.collections.under_construction');
    }
    
    public function create()
    {
        return view('user.collections.under_construction');
    }
    
    public function store(Request $request)
    {
        return redirect()->route('user.collections.index')
            ->with('info', 'Функция коллекций временно недоступна');
    }
    
    public function show($id)
    {
        return view('user.collections.under_construction');
    }
    
    public function edit($id)
    {
        return view('user.collections.under_construction');
    }
    
    public function update(Request $request, $id)
    {
        return redirect()->route('collections.index')
            ->with('info', 'Функция коллекций временно недоступна');
    }
    
    public function destroy($id)
    {
        return redirect()->route('collections.index')
            ->with('info', 'Функция коллекций временно недоступна');
    }
    
    public function addCharacter(Request $request, $collection)
    {
        return back()->with('info', 'Функция коллекций временно недоступна');
    }
    
    public function addMultipleCharacters(Request $request, $collection)
    {
        return back()->with('info', 'Функция коллекций временно недоступна');
    }
    
    public function removeCharacter($collection, $character)
    {
        return back()->with('info', 'Функция коллекций временно недоступна');
    }
    
    public function review($collection)
    {
        return view('user.collections.under_construction');
    }
}
