<?php

namespace App\Http\Controllers;

use App\Models\TreeStruct;
use Illuminate\Http\Request;

class TreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $elements = TreeStruct::all();

        return response()->json($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'min:1', 'max:255'],
            'parent' => ['required', 'nullable', 'exists:App\Models\TreeStruct,id']
        ]);

        $model = TreeStruct::create($validated);

        return response()->json($model);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        return response()->json(TreeStruct::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required_without:parent', 'min:1', 'max:255'],
            'parent' => ['required_without:name', 'nullable', 'exists:App\Models\TreeStruct,id']
        ]);
        $model = TreeStruct::findOrFail($id)->update($validated);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $model = TreeStruct::findOrFail($id);

        return response()->json(['success' => $model->deleteWithChildren()]);
    }
}
