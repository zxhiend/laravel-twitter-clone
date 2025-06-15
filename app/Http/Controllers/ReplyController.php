<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tweet_id' => 'required|exists:tweets,id',
            'content' => 'required|string|max:280',
            'reply_id' => 'nullable|exists:replies,id',
        ]);
        Reply::create([
            'user_id' => auth()->id(),
            'tweet_id' => $request->tweet_id,
            'content' => $request->content,
            'reply_id' => $request->reply_id,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'content' => 'required|string|max:280',
        ]);
        $reply = Reply::findOrFail($id);
        $reply->update([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reply = Reply::findOrFail($id);
        if ($reply->user_id == auth()->id()) {
            if ($reply->replies()->count() > 0) {
                $reply->update([
                    'content' => '',
                ]);
            }
            $reply->replies()->delete();
            $reply->delete();
        }

        return redirect()->back();
    }
}
