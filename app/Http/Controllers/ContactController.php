<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\SocialLink;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.contact', compact('socialLinks'));
    }

    public function submit(Request $request)
    {
        Log::info('Contact form submission started', [
            'name' => $request->name,
            'email' => $request->email,
            'message_length' => strlen($request->message ?? '')
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Log::info('Contact form validation passed');

        try {
            // Store the message in the database
            Log::info('Attempting to create contact message in database');

            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'is_read' => false,
            ]);

            Log::info('Contact message created successfully', [
                'id' => $contactMessage->id,
                'name' => $contactMessage->name,
                'email' => $contactMessage->email
            ]);

            // Send email notification (if configured)
            Log::info('Attempting to send email notification');
            try {
                $adminEmail = config('mail.admin_email', 'admin@example.com');
                Log::info('Sending email to: ' . $adminEmail);

                Mail::to($adminEmail)->send(new ContactFormSubmission($contactMessage));
                Log::info('Email sent successfully');
            } catch (\Exception $e) {
                // Log email error but don't fail the contact form
                Log::error('Failed to send contact form email: ' . $e->getMessage(), [
                    'exception' => $e,
                    'admin_email' => config('mail.admin_email', 'admin@example.com')
                ]);
            }

            Log::info('Contact form submission completed successfully');
            return redirect()->route('contact')
                ->with('success', 'Thank you for your message! I\'ll get back to you soon.');

        } catch (\Exception $e) {
            Log::error('Contact form submission error: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return redirect()->route('contact')
                ->with('error', 'Sorry, there was an error sending your message. Please try again.')
                ->withInput();
        }
    }
}
