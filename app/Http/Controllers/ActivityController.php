<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Facades\auth;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function loadActivity()
    {
        $activities=Activity::with(["user.employee","actor.employee","message"])->where("user_id",auth::id())
        ->latest()
        ->get();
        return response()->json(
            [
                "success" =>true,
                "data" =>$activities,
            ]
        );
    }
}
