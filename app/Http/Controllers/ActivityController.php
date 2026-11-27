<?php

namespace App\Http\Controllers;

use App\Events\ActivityCount;
use App\Events\ActivityRead;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;

class ActivityController extends Controller
{
    public function loadActivity()
    {
        $activities = Activity::with(["user.employee", "actor.employee", "message"])->where("user_id", auth::id())
            ->latest()
            ->get();
        return response()->json(
            [
                "success" => true,
                "data" => $activities,
            ]
        );
    }
    public function readActivity(Request $request)
    {
        $activity = Activity::where("id", $request->activity_id)
            ->where("is_read", false)
            ->first();
        if ($activity) {
            $activity->update([
                "is_read" => true,
            ]);
            ActivityRead::dispatch(
                $activity->id,
                auth::id(),
            );
            $activity_count = Activity::where("user_id", auth::id())->where("is_read", false)->count();
            ActivityCount::dispatch(
                auth::id(),
                $activity_count,


            );
        }
        return response()->json(
            [
                "success" => true,
            ]
        );
    }
    public function readMessageActivity(Request $request)
    {
        Activity::where("message_id", $request->message_id)
            ->where("user_id", auth::id())
            ->where("is_read", false)
            ->update([
                "is_read" => true,
            ]);
        $activity_count = Activity::where("user_id", auth::id())
            ->where("is_read", false)->count();
        ActivityCount::dispatch(
            auth::id(),
            $activity_count,
        );

        $activityIds = Activity::where('message_id', $request->message_id)
            ->where('user_id', auth::id())
            ->where('is_read', false)
            ->pluck('id');
        foreach ($activityIds as $activityId) {
            ActivityRead::dispatch($activityId, auth::id());
        }
        return response()->json([
            "success" => true,
        ]);
    }


}
