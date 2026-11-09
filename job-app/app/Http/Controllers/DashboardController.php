<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $qurey = JobVacancy::query();

        if ($request->has('search') && $request->has('Filter')) {
            $qurey->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
            ->orWhere('location', 'like', '%' . $request->search . '%')
            ->orWhereHas('company', function ($qurey) use ($request) {
                $qurey->where('name', 'like', '%' . $request->search . '%');
            });
            
        })
        ->where('type', $request->Filter);
        }

        if ($request->has('search') && $request->Fliter === null) {
            $qurey->where('title', 'like', '%' . $request->search . '%')
            ->orWhere('location', 'like', '%' . $request->search . '%')
            ->orWhereHas('company', function ($qurey) use ($request) {
                $qurey->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('Filter') && $request->Fliter === null) {
            $qurey->where('type', $request->Filter);
        }

        $jobs = $qurey
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('dashboard', compact('jobs'));
    }
}
