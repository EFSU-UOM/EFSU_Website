<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // only logged-in users
    }

    public function create()
    {
        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'complaint_text' => 'required|string',
        ]);

        Complaint::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'complaint_text' => $request->complaint_text,
        ]);

        return redirect()->back()->with('success', 'Your complaint has been submitted!');
    }
}
