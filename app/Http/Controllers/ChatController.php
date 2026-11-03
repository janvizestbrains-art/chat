<?php

namespace App\Http\Controllers;

use App\Events\NotificationCreated;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Employee;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {

        if (Auth::user()->can("send to own employees")) {
            $employee_id = Employee::where("user_id", Auth::id())->first();
            $employee = Employee::where("reporting_manager_id", $employee_id->id)->get();
        } else {
            $employee = Employee::where("employment_status", "active")->whereNot("user_id", Auth::id())->get();
        }

        $notifications = Notification::whereJsonContains("user_ids", (int)auth::id())
            ->orwhereJsonCOntains("user_ids", (string)auth::id())
            ->whereNot("sender_id", Auth::id())
            ->latest()->get();

        $sent = Notification::where("sender_id", auth::id())->latest()->get();


        return view("index", compact('employee', 'notifications', 'sent'));
    }
    public function sendNotification(Request $request)
    {

        $notification = Notification::create(
            [
                "title" => $request->title,
                "description" => $request->description,
                "user_ids" => $request->user_ids,
                'sender_id' => auth::id(),
            ]
        );

        foreach ($request->user_ids as $userId) {
            // dd($userId);
            NotificationCreated::dispatch(
                $userId,
                $request->title,
                $request->description,
                $notification->created_at,
            );
        }
        return redirect()->route("index");
    }

    public function chat()
    {
        $users = User::with("conversationParticipants",'employee')->whereNot("id", Auth::id())
        ->whereHas('employee')->get();
        // dd(Auth::id());
//        dd($users->map(function ($user) {
//     return [
//         'user_id' => $user->id,
//         'employee_id' => $user->employee?->id,
//         'employee_name' => $user->employee?->full_name,
//         'conversation_ids' => $user->conversationParticipants->pluck('conversation_id'),
//     ];
// }));
        return view("chat", compact("users"));
    }
    public function chatSend(Request $request)
    {
        if ($request->conversation_id) {
            $conversation = Conversation::where("id", $request->conversation_id)->first();
        } else {
            $conversation = Conversation::create([
                "type" => "Private"
            ]);
              ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
        ]);

        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $request->reciver_id,
        ]);
        }

        $message = Message::create([
            "conversation_id" => $conversation->id,
            "sender_id" => Auth::id(),
            "message" => $request->message,
            "is_read" => 0,
            "read_at" => now(),
        ]);
        return response()->json([
            "status" => true,
            "conversation"=>$conversation,

            ]);
    }

    public function loadChat(Request $request)
    {
        $chat = ConversationParticipant::with("user.employee", "conversation.messages")->where("conversation_id", $request->conversationId)->get();

      $user = User::with('employee')
    ->where('id', $request->receiverId)
    ->first();

$user->employee->append([
    'full_name',
    'profile_url'
]);


        if($chat->count()>0)

{        return response()->json(
            [
                "status" => true,
                "data" => $chat,
                'user'=>$user,
            ]
        );
}
    else
        {
            return response()->json([
                "status"=>false,
                'user'=>$user,

            ]);
        }
    }
   public function loadContact()
{
    $users = User::where('id', '!=', Auth::id())
        ->whereHas('employee')
        ->with('employee', 'conversationParticipants.conversation.latestMessage')
        ->get()
        ->sortByDesc(fn ($user) => $user->conversationParticipants
            ->max('conversation.latestMessage.created_at')
        )
        ->values();


}
}
