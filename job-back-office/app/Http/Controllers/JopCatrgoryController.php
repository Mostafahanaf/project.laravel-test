<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JobCategoryRequest;
use App\Http\Requests\JobCategoryUpdateRequest;
use App\Models\JobCategory;

class JopCatrgoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobCategory::latest();

        if($request->input('archived') == 'true'){
            $query->onlyTrashed();
        }

        $categories = $query->paginate(10)->onEachSide(1);
        return view('Job-Category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Job-Category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryRequest $request)
    {
        $validatedData = $request->validated();
        JobCategory::create($validatedData);
        return redirect()->route('job-categorise.index')->with('success', 'Job category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = JobCategory::findOrFail($id);
        return view('Job-Category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $category = JobCategory::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validatedData);

        return redirect()->route('job-categorise.index')->with('success', 'Job category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = JobCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('job-categorise.index')->with('success', 'Job category archived successfully.');
    }

    public function restore($id)
    {
        $category = JobCategory::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('job-categorise.index', ['archived' => 'true'])->with('success', 'Job category restored successfully.');
    }
}
