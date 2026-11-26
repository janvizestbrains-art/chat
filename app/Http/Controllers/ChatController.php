<?php

namespace App\Http\Controllers;

use App\Events\LatestMessageDeletedForMe;
use App\Events\MessageCount;
use App\Events\MessageDeleteEveryone;
use App\Events\MessageLatest;
use App\Events\MessageReact;
use App\Events\MessageRead;
use App\Events\MessageReply;
use App\Events\MessageSent;
use App\Events\MessageUpdate;
use App\Events\NotificationCreated;
use App\Events\UnreadMessage;
use App\Events\UserTyping;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Employee;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\MessageDraft;
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
    public function hasLink($message)
{
    return preg_match('/(https?:\/\/[^\s<]+|www\.[^\s<]+)/i', $message) === 1;
}
    public function unreadMessages(int $receiver_id)
    {
        $unread_count = Message::where("receiver_id", $receiver_id)
            ->where("is_read", false)
            ->where("delete_for_everyone", false)
            ->count();
        return $unread_count;
    }

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

        $message_draft = MessageDraft::where("conversation_id", $request->conversation_id)->where("user_id", auth::id())->first();
        if ($message_draft) {
            $message_draft->delete();
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $request->reciver_id,
            'message' => $request->message ?? ($request->type == "image" ? "image" : "Document"),
            'is_read' => 0,
            'link' =>$this->hasLink($request->message) ? true :false,

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
        $unread_count = Message::where("conversation_id", $conversation->id)
            ->where("receiver_id", $message->receiver_id)
            ->where("is_read", false)
            ->where("delete_for_everyone", false)
            ->count();
        //dd($unread_count);



        UnreadMessage::dispatch(
            $message->receiver_id,
            $this->unreadMessages($message->receiver_id),
        );


        MessageCount::dispatch(
            $message->conversation_id,
            $message->receiver_id,
            $unread_count
        );

        MessageLatest::dispatch(
            $conversation->id,
            $request->reciver_id,
            $message->message ?? 'Sent a File',
            auth::id(),
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

        $messagePin = MessagePin::with([
            "message",
            "user"
        ])
            ->where("conversation_id", $request->conversationId)->where("user_id", auth::id())->first();

        $message_draft = MessageDraft::where("conversation_id", $request->conversationId)->where("user_id", auth::id())->first();

        $chat = ConversationParticipant::with([
            'user.employee',
            'conversation.messages.reactions',
            'conversation.messages.messagestar',
            'conversation.messages.messagepin',
            'conversation.messages.replyMessage.sender',



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
            UnreadMessage::dispatch(
                auth::id(),
                $this->unreadMessages(auth::id()),
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
                    'messagepin' => $messagePin,
                    'message_draft' => $message_draft,

                ]
            );
        } else {
            return response()->json([
                'status' => false,
                'user' => $user,

            ]);
        }
    }
    public function loadContact(Request $request)
    {
        $authId = Auth::id();
        $users = User::where('id', '!=', $authId)
            ->whereHas('employee')
            ->whereDoesntHave('conversationParticipants', function ($query) use ($authId) {
                $query->whereIn('conversation_id', function ($subQuery) use ($authId) {
                    $subQuery->select('conversation_id')
                        ->from('conversation_participants')
                        ->where('user_id', $authId)
                        ->where('is_archived', true);
                });
            })
            ->with('employee')
            ->get();

        $users->each(function ($user) use ($authId) {

            $latestMessage = $user->latest_message;

            $user->latest_message_text = $latestMessage?->message;
            $user->latest_message_at = $latestMessage?->created_at;
          $conversationId = ConversationParticipant::where('user_id', $authId)
    ->whereHas('conversation.participants', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })
    ->latest('conversation_id')
    ->value('conversation_id');

$user->conversation_id = $conversationId;

            $user->unread_messages_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $authId)
                ->where('is_read', false)
                ->where('clear_for_receiver', false)
                ->where('delete_for_everyone', false)
                ->count();

            $user->employee->append([
                'full_name',
                'profile_url',
            ]);
        });

        $users = $users->sortByDesc('latest_message_at')->values();
        $isarchive = ConversationParticipant::where("user_id", auth::id())
            ->where("is_archived", true)
            ->exists();
        $archive_count = ConversationParticipant::where("user_id", auth::id())
            ->where("is_archived", true)
            ->count();

        return response()->json([
            'success' => true,
            'users' => $users,
            'isarchive' => $isarchive,
            'archive_count' => $archive_count,
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
        UnreadMessage::dispatch(
            auth::id(),
            $this->unreadMessages(auth::id()),
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
        $message_pin = MessagePin::where("message_id", $request->messageId)->first();
        $message_star = MessageStar::where("message_id", $request->messageId)->first();

        if ($message_pin) {
            $message_pin->delete();
        }
        if ($message_star) {
            $message_star->delete();
        }

        $latestMessage = Message::where("conversation_id", $message->conversation_id)->where("delete_for_everyone", false)
            ->where(function ($query) {
                $query->where("delete_for_me", false)
                ->orWhere("sender_id","!=",auth::id());

            })
            ->latest()->first();


        if ($latestMessage) {
            LatestMessageDeletedForMe::dispatch(
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
        $message_pin = MessagePin::where("message_id", $request->messageId)->first();
        $message_star = MessageStar::where("message_id", $request->messageId)->first();
        if ($message_pin) {
            $message_pin->delete();
        }
        if ($message_star) {
            $message_star->delete();
        }

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

        UnreadMessage::dispatch(
            $message->receiver_id,
            $this->unreadMessages($message->receiver_id),
        );
        $unread_count = Message::where("conversation_id", $message->conversation_id)
            ->where("receiver_id", $message->receiver_id)
            ->where("is_read", false)
            ->where("delete_for_everyone", false)
            ->count();
        MessageCount::dispatch(
            $message->conversation_id,
            $message->receiver_id,
            $unread_count,

        );

        MessageLatest::dispatch(
            $latestMessage->conversation_id,
            auth::id(),
            $latestMessage->message,
            $latestMessage->receiver_id,
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
        LatestMessageDeletedForMe::dispatch(
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


        $message = Message::with('reactions')->where("id", $message->id)->first();
        $reactions = [];
        foreach ($message->reactions as $reaction) {
            $reactions[] =
                [
                    'user_id' => $reaction->user_id,
                    'reaction' => $reaction->reaction,
                ];
        }

        return response()->json([
            "success" => true,
            'message_id' => $message->id,
            "reactions" => $reactions,
        ]);
    }

    public function messageRemoveReact(Request $request)
    {
        $message = MessageReaction::where("message_id", $request->messageId)->where("user_id", auth::id())->first();
        if ($message) {
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


        $message = Message::with('reactions')->where("id", $message->id)->first();
        $reactions = [];
        foreach ($message->reactions as $reaction) {
            $reactions[] =
                [
                    'user_id' => $reaction->user_id,
                    'reaction' => $reaction->reaction,
                ];
        }


        return response()->json([
            "success" => true,
            "message_id" => $message->id,
            "reactions" => $reactions,
        ]);
    }

    public function messageStar(Request $request)
    {
        $message = MessageStar::where("message_id", $request->message_id)->where("user_id", auth::id())->first();
        if ($message) {
            $message->delete();
        } else {
            MessageStar::create([
                "message_id" => $request->message_id,
                "user_id" => auth::id(),
            ]);
        }

        $message = Message::findOrFail($request->message_id);

        $receiverId = $message->sender_id == auth::id()
            ? $message->receiver_id
            : $message->sender_id;

        return response()->json([
            "success" => true,
            "conversation_id" => $message->conversation_id,
            "receiver_id" => $receiverId,
        ]);
    }

    public function messagePin(Request $request)
    {
        $conversation = Message::findOrFail($request->message_id);
        $message = MessagePin::where("conversation_id", $conversation->conversation_id)->where("message_id", $conversation->id)->where("user_id", auth::id())->first();


        if ($message) {
            $message->delete();
        } else {

            $conversation_data = MessagePin::where("conversation_id", $conversation->conversation_id)->where("user_id", auth::id())->first();
            if ($conversation_data) {
                $conversation_data->delete();
            }

            //dd($conversation);
            MessagePin::create([
                "conversation_id" => $conversation->conversation_id,
                "message_id" => $request->message_id,
                "user_id" => auth::id(),
            ]);
        }
        $receiverId = $conversation->sender_id == auth::id()
            ? $conversation->receiver_id
            : $conversation->sender_id;
        return response()->json([
            "success" => true,
            "conversation_id" => $conversation->conversation_id,
            "receiver_id" => $receiverId,
        ]);
    }

    public function getUsers()
    {
        $users = User::with(['employee'])->whereNot("id", auth::id())
            ->whereHas('employee')
            ->get();
        return response()->json([
            "success" => true,
            "users" => $users,
        ]);
    }


    public function messageForward(Request $request)
    {
        foreach ($request->users as $user) {
            $conversation = ConversationParticipant::wherein("user_id", [auth::id(), $user])
                ->groupBy("conversation_id")
                ->havingRaw('count(distinct user_id)=2')
                ->value('conversation_id');


            $message = Message::where("id", $request->message_id)->first();
            $message_attach = MessageAttachment::where("message_id", $message->id)->first();

            if ($conversation) {

                $message_data = Message::create([
                    "conversation_id" => $conversation,
                    "sender_id" => auth::id(),
                    "receiver_id" => $user,
                    "message" => $message->message,
                    "link" =>$this->hasLink($message->message) ?true:false,
                ]);
                if ($message_attach) {
                    $message_attach_data = MessageAttachment::create([
                        "message_id" => $message_data->id,
                        "file_type" => $message_attach->file_type,
                        "file_path" => $message_attach->file_path,

                    ]);
                }
            } else {
                $conversation_data = Conversation::create(
                    [
                        "type" => "Private",
                    ]
                );
                ConversationParticipant::create([
                    "conversation_id" => $conversation_data->id,
                    "user_id" => auth::id(),
                ]);
                ConversationParticipant::create([
                    "conversation_id" => $conversation_data->id,
                    "user_id" => $user,
                ]);
                $message_data = Message::create([
                    "conversation_id" => $conversation_data->id,
                    "sender_id" => auth::id(),
                    "receiver_id" => $user,
                    "message" => $message->message,
                ]);
                if ($message_attach) {
                    $message_attach_data = MessageAttachment::create([
                        "message_id" => $message_data->message_id,
                        "file_type" => $message_attach->file_type,
                        "file_path" => $message_attach->file_path,
                    ]);
                }
            }


            $unread_count = Message::where("conversation_id", $message_data->conversation_id)->where("receiver_id", $message_data->receiver_id)->where("is_read", false)->count();


            MessageCount::dispatch(
                $message_data->conversation_id,
                $message_data->receiver_id,
                $unread_count
            );

            MessageLatest::dispatch(
                $message_data->conversation_id,
                $message_data->receiver_id,
                $message_data->message,
                auth::id(),
            );


            MessageSent::dispatch(
                $message_data->id,
                $message_data->conversation_id,
                Auth::id(),
                $message_data->receiver_id,
                $message_data->message,
                0,
                $message_data->created_at,
                $message_attach_data->file_type ?? null,
                $message_attach_data->file_path ?? null,

            );
        }


        return response()->json(
            [
                "success" => true,


            ]
        );
    }


    public function messageReply(Request $request)
    {
        $message = Message::where("id", $request->message_id)->first();
        $receiverId = $message->sender_id == auth::id()
            ? $message->receiver_id
            : $message->sender_id;
        if ($message) {
            $message_data = Message::create([
                "conversation_id" => $message->conversation_id,
                "sender_id" => auth::id(),
                "receiver_id" => $receiverId,
                "message" => $request->text,
                "reply_message_id" => $message->id,
                'link' =>$this->hasLink($request->text)?true:false,

            ]);
        }


        $unread_count = Message::where("conversation_id", $message_data->conversation_id)->where("receiver_id", $message_data->receiver_id)->where("is_read", false)->count();
        //dd($unread_count);


        MessageCount::dispatch(
            $message_data->conversation_id,
            $message_data->receiver_id,
            $unread_count
        );

        MessageLatest::dispatch(
            $message_data->conversation_id,
            $message_data->receiver_id,
            $message_data->message,
            auth::id(),
        );





        MessageReply::dispatch(
            $message_data->id,
            $message_data->conversation_id,
            $message_data->sender_id,
            $message_data->receiver_id,
            $message_data->replyMessage->message,
            0,
            $message_data->created_at,
            $message_data->replyMessage->sender->name,
            $message_data->message,
            $message_data->link,

        );


        return response()->json([
            "success" => true,
            "conversation_id" => $message->conversation_id,
            "receiver_id" => $receiverId,
        ]);
    }

    public function userTyping(Request $request)
    {


        $istyping = $request->boolean('istyping');

        if($request->conversation_id)
        {

        UserTyping::dispatch(
            $request->conversation_id,

            $request->receiver_id,
            $istyping,
        );
        }
        return response()->json([
            "success" => true,
        ]);
    }

    public function saveMessageDraft(Request $request)
    {
        $draft = MessageDraft::where("conversation_id", $request->conversation_id)->where("user_id", auth::id())->first();
        if ($draft) {
            $updatedraft = MessageDraft::where("conversation_id", $request->conversation_id)->where("user_id", auth::id())
                ->update([
                    "draft" => $request->draft,
                ]);
        } else {
            MessageDraft::create([
                "conversation_id" => $request->conversation_id,
                "user_id" => auth::id(),
                "draft" => $request->draft,
            ]);
        }
        return response()->json([
            "success" => true,
        ]);
    }

    public function chatArchived(Request $request)
    {
        $conversation = ConversationParticipant::where("conversation_id", $request->conversation_id)->where("user_id", auth::id())->first();
        if ($conversation) {
            $conversation->update([
                "is_archived" => true,
            ]);
        }
        $archive_count = ConversationParticipant::where("user_id", auth::id())
            ->where("is_archived", true)
            ->count();
        return response()->json(
            [
                "success" => true,
                'archive_count' => $archive_count,
            ]
        );
    }

    public function chatUnArchived(Request $request)
    {
        $conversation = ConversationParticipant::where("conversation_id", $request->conversation_id)->where("user_id", auth::id())->first();
        if ($conversation) {
            $conversation->update([
                "is_archived" => false,
            ]);

            $isarchived = ConversationParticipant::where("user_id", auth::id())->where("is_archived", true)->exists();

            return response()->json([
                "success" => true,
                'isarchived' => $isarchived,
            ]);
        }
    }




    public function loadArchiveContact()
    {
        $authId = Auth::id();
        $users = User::where('id', '!=', $authId)
            ->whereHas('employee')
            ->whereHas('conversationParticipants', function ($query) use ($authId) {
                $query->whereIn('conversation_id', function ($subQuery) use ($authId) {
                    $subQuery->select('conversation_id')
                        ->from('conversation_participants')
                        ->where('user_id', $authId)
                        ->where('is_archived', true);
                });
            })
            ->with('employee')
            ->get();

        $users->each(function ($user) use ($authId) {

            $latestMessage = $user->latest_message;

            $user->latest_message_text = $latestMessage?->message;
            $user->latest_message_at = $latestMessage?->created_at;
  $conversationId = ConversationParticipant::where('user_id', $authId)
    ->whereHas('conversation.participants', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })
    ->latest('conversation_id')
    ->value('conversation_id');

$user->conversation_id = $conversationId;
            $user->unread_messages_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $authId)
                ->where('is_read', false)
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
            'success' => true,
            'users' => $users,
        ]);
    }
}
