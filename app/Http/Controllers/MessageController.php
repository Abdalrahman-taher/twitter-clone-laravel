<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Traits\HandlesMediaUploads;



class MessageController extends Controller
{
    use HandlesMediaUploads;

    // =====================================================
    // Messages Inbox
    // Show all conversations for authenticated user
    // =====================================================
    public function index()
    {
        $conversations = auth()->user()
            ->conversations()
            ->with('users.medias')
            ->latest()
            ->get();

        return view('messages.index', compact('conversations'));
    }


    // =====================================================
    // Open Conversation
    // Create conversation if it doesn't exist
    // =====================================================
    public function store(User $user)
    {
        $authUser = auth()->user();

        // Don't allow messaging yourself
        if ($authUser->id === $user->id) {
            return back();
        }

        // Find existing conversation
        $conversation = $authUser->conversations()
            ->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->first();

        // Create new conversation
        if (! $conversation) {

            $conversation = Conversation::create();

            $conversation->users()->attach([
                $authUser->id,
                $user->id,
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }

    // =====================================================
    // Show Conversation
    // Display conversation page
    // =====================================================

    public function show(Conversation $conversation)
    {
        abort_unless(
            $conversation->users->contains(auth()->id()),
            403
        );

        $conversation->load([
            'users.medias',
            'messages.sender.medias',
            'messages.medias',
        ]);

        return view('messages.show', compact('conversation'));
    }


    // =====================================================
    // Send Message
    // Store a new message inside conversation
    // =====================================================

    public function send(Request $request, Conversation $conversation)
    {
        abort_unless(
            $conversation->users->contains(auth()->id()),
            403
        );


        $request->validate([

            'body' => 'nullable|string|max:5000',

            'message_images' => 'nullable|array',
            'message_images.*' => 'image|max:2048',

            'message_videos' => 'nullable|array',
            'message_videos.*' => 'mimes:mp4|max:51200',

        ]);

        if (
            empty($request->body) &&
            ! $request->hasFile('message_images')
            &&
            ! $request->hasFile('message_videos')

        ) {
            return back();
        }


        $message = Message::create([

            'conversation_id' => $conversation->id,

            'sender_id' => auth()->id(),

            'body' => $request->body,

        ]);


        // Upload images/videos
        $this->uploadMedia(
            $request,
            $message,
            'message_images',
            'message_videos',
            'message'
        );

        return redirect()
            ->route('messages.show', $conversation)
            ->withFragment('bottom');
    }


}
