<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
      public function leave()
    {
        $leaves=Leave::where("user_id",Auth::id())->get();
        return view("leave",compact('leaves'));
    }
    public function applyLeave(Request $request)
    {
$checkLeave = Leave::where('user_id', Auth::id())
    ->where(function ($query) use ($request) {
        $query->whereBetween('from_date', [
            $request->from_date,
            $request->to_date
        ])
        ->orWhereBetween('end_date', [
            $request->from_date,
            $request->to_date
        ])
        ->orWhere(function ($query) use ($request) {
            $query->where('from_date', '<=', $request->from_date)
                ->where('end_date', '>=', $request->to_date);
        });
    })
    ->first();

if ($checkLeave) {
    return redirect()->back()->with('error', 'You have already applied for leave during these dates.');
}
        Leave::create([
            "user_id"=>Auth::id(),
            "from_date"=>$request->from_date,
            "end_date"=>$request->to_date,
            "reason"=>$request->reason,
            "status" =>"Pending",

        ]);
        return redirect()->back()->with("success","Leave Request Submitted Successfully");
    }
    public function leaveRequest()
    {
        $leaves=Leave::latest()->get();
        return view("approveleave",compact('leaves'));
    }
 
}
