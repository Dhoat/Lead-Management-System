<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadUpdate;
use Illuminate\Support\Facades\Auth;

class LeadUpdateController extends Controller
{
    public function postUpdate(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'lead_message' => 'required|string',
        ]);

        LeadUpdate::create([
            'lead_id' => $request->lead_id,
            'lead_message' => $request->lead_message,
            'user' => Auth::user()->name ?? 'Admin', 
        ]);

        return response()->json(['success' => 'Update posted successfully']);
    }

    
    public function viewUpdates($id)
    {
        $updates = LeadUpdate::where('lead_id', $id)->orderBy('created_at', 'DESC')->get();
        return response()->json($updates);
    }
}
