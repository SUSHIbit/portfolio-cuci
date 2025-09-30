<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contacts.index', compact('messages'));
    }

    public function markAsRead(ContactMessage $contact)
    {
        $contact->update(['is_read' => true]);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message marked as read!');
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted successfully!');
    }
}
