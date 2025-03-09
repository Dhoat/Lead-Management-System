<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index(){
        return view('leads.index');
    }

    // public function getData(Request $request){
    //     if ($request->ajax()) {
    //         $query = Lead::select(['id', 'name', 'email', 'mobile', 'status', 'source']);

    //         // Apply filters if present
    //         if (!empty($request->search_name)) {
    //             $query->where('name', 'LIKE', "%{$request->search_name}%");
    //         }
    //         if (!empty($request->search_email)) {
    //             $query->where('email', 'LIKE', "%{$request->search_email}%");
    //         }

    //         return DataTables::eloquent($query)
    //             ->addColumn('action', function ($lead) {
    //                 return '<button class="btn btn-sm btn-primary edit-lead" data-id="'.$lead->id.'">Edit</button>
    //                         <button class="btn btn-sm btn-success post-update" data-id="'.$lead->id.'">Post Update</button>
    //                         <button class="btn btn-sm btn-info view-updates" data-id="'.$lead->id.'">View Updates</button>';
    //             })
    //             ->make(true);
    //     }
    // }
    public function getData(Request $request){
        if ($request->ajax()) {
            $query = Lead::select(['id', 'name', 'email', 'mobile', 'status', 'source', 'description']);
    
            if (!empty($request->search_name)) {
                $query->where('name', 'LIKE', "%{$request->search_name}%");
            }
            if (!empty($request->search_email)) {
                $query->where('email', 'LIKE', "%{$request->search_email}%");
            }
    
            return DataTables::eloquent($query)->toJson();
        }
    }
    
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'source' => 'required|string',
            'status' => 'in:new,accepted,completed,rejected,invalid'
        ]);

        $lead->update($request->except(['mobile', 'email'])); 

        return response()->json(['success' => 'Lead updated successfully']);
    }

}
