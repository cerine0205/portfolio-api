<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    // =============================
    // Visitor functions
    // =============================

    // Store a new message sent by a visitor
    public function store(Request $request)
    {
        // Validate incoming request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',

            // project_id is optional, but if provided it must exist in projects table
            'project_id' => 'nullable|exists:projects,id'
        ]);

        // Create the message in the database
        $message = Message::create($data);

        // Return the created message
        return response()->json($message, 201);
    }



    // =============================
    // Admin functions
    // =============================

    // Get all messages with their related project (if any)
    public function index()
    {
        return response()->json(
            Message::with('project')->latest()->get()
        );
    }


    // Delete a specific message
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json([
            'message' => 'Message deleted successfully'
        ]);
    }


    // Mark a message as read
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);

        $message->update([
            'is_read' => true
        ]);

        return response()->json([
            'message' => 'Message marked as read successfully'
        ]);
    }
}