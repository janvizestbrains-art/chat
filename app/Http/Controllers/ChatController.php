<?php

namespace App\Http\Controllers;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Events\NotificationCreated;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Employee;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {

        if (Auth::user()->can('send to own employees')) {
            $employee_id = Employee::where('user_id', Auth::id())->first();
            $employee = Employee::where('reporting_manager_id', $employee_id->id)->get();
        } else {
            $employee = Employee::where('employment_status', 'active')->whereNot('user_id', Auth::id())->get();
        }

        $notifications = Notification::whereJsonContains('user_ids', (int) Auth::id())
            ->orwhereJsonCOntains('user_ids', (string) Auth::id())
            ->whereNot('sender_id', Auth::id())
            ->latest()->get();

        $sent = Notification::where('sender_id', Auth::id())->latest()->get();

        return view('index', compact('employee', 'notifications', 'sent'));
    }

    public function sendNotification(Request $request)
    {

        $notification = Notification::create(
            [
                'title' => $request->title,
                'description' => $request->description,
                'user_ids' => $request->user_ids,
                'sender_id' => Auth::id(),
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

        return redirect()->route('index');
    }

    public function chat()
    {

        return view('chat');
    }

    public function chatSend(Request $request)
    {


        if ($request->conversation_id) {
            $conversation = Conversation::where('id', $request->conversation_id)->first();

        } else {
            $conversation = Conversation::create([
                'type' => 'Private',
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
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $request->reciver_id,
            'message' => $request->message??null,
            'is_read' => 0,

        ]);
       if ($request->hasFile('file')) {

    $file = $request->file('file');

    if ($file->isValid()) {

        $path = $file->store('attachments', 'public');
       $attachment= MessageAttachment::create(
            [
            "message_id"=>$message->id,
            "file_type"=>$request->type,
            "file_path"=>$path,
        ]);
          MessageSent::dispatch(
            $conversation->id,
            Auth::id(),
            $request->reciver_id,
            $request->message,
            0,
            $message->created_at,
            $attachment->file_type,
            $attachment->file_path ,

        );


    }
}
 MessageSent::dispatch(
            $conversation->id,
            Auth::id(),
            $request->reciver_id,
            $request->message,
            0,
            $message->created_at,

        );


        return response()->json([
            'status' => true,
            'conversation' => $conversation,

        ]);
    }

    public function loadChat(Request $request)
    {

        $chat = ConversationParticipant::with('user.employee', 'conversation.messages','conversation.messages.attachments')->where('conversation_id', $request->conversationId)->get();

        if ($request->conversationId) {

            Message::where('conversation_id', $request->conversationId)
                ->where('sender_id', $request->receiverId)
                ->whereNot('sender_id', Auth::id())
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        }

        $user = User::with('employee')
            ->where('id', $request->receiverId)
            ->first();

        $user->employee->append([
            'full_name',
            'profile_url',
        ]);

        if ($chat->count() > 0) {
            return response()->json(
                [
                    'status' => true,
                    'data' => $chat,
                    'user' => $user,
                ]
            );
        } else {
            return response()->json([
                'status' => false,
                'user' => $user,

            ]);
        }
    }

    public function loadContact()
    {
        $authId = Auth::id();

        $users = User::where('id', '!=', $authId)
            ->whereHas('employee')
            ->with('employee')
            ->get();

        $users->each(function ($user) use ($authId) {

            $latestMessage = Message::where(function ($query) use ($authId, $user) {

                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $authId);
            })->orWhere(function ($query) use ($authId, $user) {

                $query->where('sender_id', $authId)
                    ->where('receiver_id', $user->id);
            })
                ->latest('created_at')
                ->first();

            $user->latest_message = $latestMessage?->message;
            $user->latest_message_at = $latestMessage?->created_at;
            $user->conversation_id = $latestMessage?->conversation_id;
            $user->unread_messages_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $authId)
                ->where('is_read', 0)
                ->count();

            $user->employee->append([
                'full_name',
                'profile_url',
            ]);
        });

        $users = $users->sortByDesc('latest_message_at')->values();

        return response()->json([
            'status' => true,
            'users' => $users,
        ]);
    }

    public function messageRead(Request $request)
    {
        $messages = Message::where('conversation_id', $request->conversation_id)
            ->where('sender_id', $request->sender_id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false);

        $messages->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        MessageRead::dispatch(
            $request->conversation_id,
            $request->sender_id
        );
        $messages = $messages->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }
}
