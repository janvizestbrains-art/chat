<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
     DB::transaction(function () {

    // Get first two existing users
    $users = User::query()
        ->orderBy('id')
        ->take(2)
        ->get();

    if ($users->count() < 2) {
        throw new \RuntimeException(
            'At least two users are required to seed chat.'
        );
    }

    $userOne = $users[0];
    $userTwo = $users[1];

    // Find existing private conversation
    $conversation = Conversation::query()
        ->where('type', 'private')
        ->whereHas('participants', function ($query) use ($userOne) {
            $query->where('users.id', $userOne->id);
        })
        ->whereHas('participants', function ($query) use ($userTwo) {
            $query->where('users.id', $userTwo->id);
        })
        ->first();

    // Create conversation if it does not exist
    if (!$conversation) {
        $conversation = Conversation::create([
            'name' => null,
            'type' => 'private',
        ]);
    }

    // Add participants
    $conversation->participants()->syncWithoutDetaching([
        $userOne->id,
        $userTwo->id,
    ]);

    // Sample messages
    $messages = [
        [
            'sender_id' => $userOne->id,
            'message' => 'Hello!',
            'is_read' => true,
            'read_at' => now()->setTime(10, 30, 0),
        ],
        [
            'sender_id' => $userTwo->id,
            'message' => 'Hi, how are you?',
            'is_read' => true,
            'read_at' => now()->setTime(10, 32, 0),
        ],
        [
            'sender_id' => $userOne->id,
            'message' => 'I am fine. How about you?',
            'is_read' => true,
            'read_at' => now()->setTime(10, 35, 0),
        ],
        [
            'sender_id' => $userTwo->id,
            'message' => 'I am good too.',
            'is_read' => false,
            'read_at' => null,
        ],
        [
            'sender_id' => $userOne->id,
            'message' => 'How is your work going?',
            'is_read' => false,
            'read_at' => null,
        ],
    ];

    foreach ($messages as $message) {
        $conversation->messages()->updateOrCreate(
            [
                'sender_id' => $message['sender_id'],
                'message' => $message['message'],
            ],
            [
                'is_read' => $message['is_read'],
                'read_at' => $message['read_at'],
            ]
        );
    }

});
    }
}
