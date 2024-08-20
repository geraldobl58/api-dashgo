<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Commission::query();

        if ($request->has('search')) {
            $query->where('title', 'LIKE', '%'.$request->input('search').'%');
        }

        $commissions = $query->paginate(10);

        return response()->json($commissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $commission = Commission::create($request->all());
        return response()->json($commission, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commission = Commission::findOrFail($id);
        return response()->json($commission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $commission = Commission::findOrFail($id);
        $commission->update($request->all());

        return response()->json($commission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commission = Commission::findOrFail($id);
        $commission->delete();

        return response()->json(null, 204);
    }
}
