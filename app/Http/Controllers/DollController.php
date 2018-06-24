<?php

namespace App\Http\Controllers;

use App\Doll;
use Illuminate\Http\Request;

class DollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'dolls';

        return view('dolls.index', compact('page'));
    }

    /**
     * Return all of the existing models
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $dolls = Doll::all();

        return response()->json($dolls, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Doll $doll
     * @return \Illuminate\Http\Response
     */
    public function show(Doll $doll)
    {
        return $doll;
    }

    /**
     * Increaes the actual stock by 1
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function increase(Request $request, $id) {
        $doll = Doll::findOrFail($id);

        $doll->stock = $doll->stock + 1;
        $doll->save();

        return response()->json(null, 200);
    }

    /**
     * Decrease the actual stock by 1
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function decrease(Request $request, $id) {
        $doll = Doll::findOrFail($id);

        $doll->stock = $doll->stock > 0 ? $doll->stock - 1 : 0;
        $doll->save();

        return response()->json(null, 200);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'priority' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'ideal' => 'nullable|integer|min:0',
            'price' => 'nullable|string',
            'rank' => 'nullable|string',
            'notes' => 'nullable|string',
            'etsy_id' => 'nullable|integer|min:0'
        ]);

        Doll::forceCreate(request()->all());

        return ['message' => 'Doll Created!'];
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Doll $doll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doll $doll)
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'priority' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'ideal' => 'nullable|integer|min:0',
            'price' => 'nullable|string',
            'rank' => 'nullable|string',
            'notes' => 'nullable|string',
            'etsy_id' => 'nullable|integer|min:0'
        ]);

        $doll->update(request()->all());
        $doll->save();
        
        return response()->json(null, 200);
    }

    public function delete(Doll $doll)
    {
        $doll->delete();

        return response()->json(null, 204);
    }
}
