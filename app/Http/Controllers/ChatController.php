<?php

namespace App\Http\Controllers;

use App\Events\MessageCount;
use App\Events\MessageDeleteEveryone;
use App\Events\MessageLatest;
use App\Events\MessageReact;
use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Events\MessageUpdate;
use App\Events\NotificationCreated;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Employee;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\MessagePin;
use App\Models\MessageReaction;
use App\Models\MessageStar;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'message' => $request->message ?? ($request->type == "image" ? "image" : "Document"),
            'is_read' => 0,

        ]);
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            if ($file->isValid()) {

                $path = $file->store('attachments', 'public');
                $attachment = MessageAttachment::create(
                    [
                        "message_id" => $message->id,
                        "file_type" => $request->type,
                        "file_path" => $path,
                    ]
                );
            }
        }
        $unread_count = Message::where("conversation_id", $conversation->id)->where("receiver_id", $request->reciver_id)->where("is_read", false)->count();
        //dd($unread_count);


        MessageCount::dispatch(
            $message->conversation_id,
            $message->receiver_id,
            $unread_count
        );

        MessageLatest::dispatch(
            $conversation->id,
            $request->reciver_id,
            $message->message ?? 'Sent a File',
        );


        MessageSent::dispatch(
            $message->id,
            $conversation->id,
            Auth::id(),
            $request->reciver_id,
            $request->message,
            0,
            $message->created_at,
            $attachment->file_type ?? null,
            $attachment->file_path ?? null,

        );




        return response()->json([
            'status' => true,
            'conversation' => $conversation,

        ]);
    }

    public function loadChat(Request $request)
    {

        $messagePin=MessagePin::with([
            "message",
            "user"
        ])
        ->where("conversation_id",$request->conversationId)->first();

        $chat = ConversationParticipant::with([
            'user.employee',
            'conversation.messages.reactions',
            'conversation.messages.messagestar',
            'conversation.messages.messagepin',


            'conversation.messages' => function ($query) {

                $query->where(function ($q) {
                    $q->where('delete_for_me', false)
                        ->orWhere('sender_id', '!=', Auth::id());
                })

                    ->where(function ($q) {
                        $q->where(function ($q1) {
                            $q1->where('clear_for_sender', false)
                                ->where('sender_id', Auth::id());
                        })

                            ->orWhere(function ($q2) {
                                $q2->where('clear_for_receiver', false)
                                    ->where('receiver_id', Auth::id());
                            });
                    })


                    ->orderBy('created_at', 'asc');
            },

            'conversation.messages.attachments',

        ])
            ->where('conversation_id', $request->conversationId)
            ->where('user_id', Auth::id())
            ->get();


        if ($request->conversationId) {

            Message::where('conversation_id', $request->conversationId)
                ->where('sender_id', $request->receiverId)
                ->whereNot('sender_id', Auth::id())
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
            MessageRead::dispatch(
                $request->conversationId,
                $request->receiverId,
            );
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
                    'messagepin' =>$messagePin,
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

            $latestMessage = $user->latest_message;

            $user->latest_message_text = $latestMessage?->message;
            $user->latest_message_at = $latestMessage?->created_at;
            $user->conversation_id = $latestMessage?->conversation_id;

            $user->unread_messages_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $authId)
                ->where('is_read', 0)
                ->where('clear_for_receiver', false)
                ->where('delete_for_everyone', false)
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
    public function messageUpdate(Request $request, $id)
    {
        $message = Message::where("id", $id)->firstOrFail();

        $message->update([
            "message" => $request->message,
            "is_edited" => true,
        ]);

        MessageUpdate::dispatch(
            $message->id,
            $message->conversation_id,
            $message->receiver_id,
            $message->sender_id,
            $message->message,
            $message->updated_at,
            (bool) $message->is_edited,
        );

        return response()->json([
            "success" => true,
        ]);
    }

    public function messageDeleteForMe(Request $request)
    {
        $message = Message::where("id", $request->messageId)->first();
        Message::where("id", $request->messageId)->update([
            "delete_for_me" => true,
        ]);

        $latestMessage = Message::where("conversation_id", $message->conversation_id)->where("delete_for_everyone", false)
            ->where(function ($query) {
                $query->where("delete_for_me", false)
                    ->orWhere("sender_id", '!=', auth::id());
            })
            ->latest()->first();


        if ($latestMessage) {
            MessageLatest::dispatch(
                $latestMessage->conversation_id,
                auth::id(),
                $latestMessage->message,
            );
        }
        return response()->json([
            "success" => true,
            "conversation_id" => $message->conversation_id,
            "receiver_id" => $message->receiver_id,

        ]);
    }

    public function messageDeleteForEveryone(Request $request)
    {
        $message = Message::where("id", $request->messageId)->first();
        Message::where("id", $request->messageId)->update([
            "delete_for_everyone" => true

        ]);

        $attachment = MessageAttachment::where("message_id", $message->id)->first();
        if ($attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }
        $latestMessage = Message::where("conversation_id", $message->conversation_id)->where("delete_for_everyone", false)
            ->where(function ($query) {
                $query->where("delete_for_me", false)
                    ->orWhere("sender_id", '!=', auth::id());
            })
            ->latest()->first();

        MessageDeleteEveryone::dispatch(
            $request->messageId,
            auth::id(),
            $message->receiver_id,
        );

        MessageLatest::dispatch(
            $latestMessage->conversation_id,
            auth::id(),
            $latestMessage->message,
        );

        MessageLatest::dispatch(
            $latestMessage->conversation_id,
            $latestMessage->receiver_id,
            $latestMessage->message,
        );
        //  MessageLatest::dispatch(
        //     $latestMessage->conversation_id,
        //     $latestMessage->receiver_id,
        //     $latestMessage->message,
        // );

        return response()->json([
            "success" => true,
            "conversation_id" => $message->conversation_id,
            "receiver_id" => $message->receiver_id,
        ]);
    }

    public function clearChat(Request $request)
    {
        Message::where("conversation_id", $request->conversation_id)->where("sender_id", auth::id())->update([
            "clear_for_sender" => true,
        ]);
        Message::where("conversation_id", $request->conversation_id)->where("receiver_id", auth::id())->update([
            "clear_for_receiver" => true,
        ]);
        MessageLatest::dispatch(
            $request->conversation_id,
            auth::id(),
            "No Messages Yet",
        );

        return response()->json([
            "success" => true,
        ]);
    }
    public function messageReact(Request $request)
    {
        $message = MessageReaction::where("message_id", $request->messageId)->where("user_id", auth::id())->first();
        if ($message) {
            $message->update([
                "reaction" => $request->emo,
            ]);
        } else {
            MessageReaction::create([
                "message_id" => $request->messageId,
                "user_id" => auth::id(),
                "reaction" => $request->emo,
            ]);
        }
        $message = Message::findOrFail($request->messageId);

        $receiverId = $message->sender_id == auth::id()
            ? $message->receiver_id
            : $message->sender_id;



        MessageReact::dispatch(
            $request->messageId,
            auth::id(),
            $receiverId,
            $request->emo
        );

        return response()->json([
            "success" => true,
            "conversation_id" => $message->conversation_id,
            "receiver_id" => $receiverId,
        ]);
    }

    public function messageRemoveReact(Request $request)
    {
        $message=MessageReaction::where("message_id",$request->messageId)->where("user_id",auth::id())->first();
        if($message)
        {
                $message->delete();

        }
    $message = Message::findOrFail($request->messageId);

    $receiverId = $message->sender_id == auth::id()
        ? $message->receiver_id
        : $message->sender_id;

    MessageReact::dispatch(
        $message->id,
     auth::id(),
        $receiverId,
        ''
    );


        return response()->json([
            "success"=>true,
             "conversation_id" => $message->conversation_id,
            "receiver_id" => $receiverId,
        ]);
    }

    public function messageStar(Request $request)
    {
        $message=MessageStar::where("message_id",$request->message_id)->where("user_id",auth::id())->first();
        if($message)
            {
                $message->delete();

            }
        else
        {
            MessageStar::create([
                "message_id"=>$request->message_id,
                "user_id" =>auth::id(),
            ]);

        }

         $message = Message::findOrFail($request->message_id);

    $receiverId = $message->sender_id == auth::id()
        ? $message->receiver_id
        : $message->sender_id;

        return response()->json([
            "success" =>true,
            "conversation_id" =>$message->conversation_id,
            "receiver_id" =>$receiverId,
        ]);
    }

    public function messagePin(Request $request)
    {
        $message=MessagePin::where("message_id",$request->message_id)->where("user_id",auth::id())->first();
          $conversation = Message::findOrFail($request->message_id);

        if($message)
        {
            $message->delete();
        }
        else
            {

                //dd($conversation);
                MessagePin::create([
                    "conversation_id" =>$conversation->conversation_id,
                    "message_id"=>$request->message_id,
                    "user_id"=>auth::id(),
                ]);

            }
             $receiverId = $conversation->sender_id == auth::id()
        ? $conversation->receiver_id
        : $conversation->sender_id;
            return response()->json([
                "success"=>true,
                "conversation_id"=>$conversation->conversation_id,
                "receiver_id" =>$receiverId,
            ]);
    }
}
