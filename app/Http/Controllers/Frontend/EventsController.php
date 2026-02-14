<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactUsMessage;

class EventsController extends Controller
{
    /**
     * Show the events page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('frontend.default.pages.events.index');
    }

    /**
     * Store event inquiry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Basic validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'event_type' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'guest_count' => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

        // For now, save to ContactUsMessage table with a specific subject prefix
        // Since we don't have a dedicated Events table yet
        $msg = new ContactUsMessage;
        $msg->name          = $request->name;
        $msg->email         = $request->email;
        $msg->phone         = $request->phone;
        $msg->support_for   = 'Event Inquiry: ' . $request->event_type; // Distinction
        $msg->message       = "Event Date: " . $request->event_date . "\nGuest Count: " . $request->guest_count . "\n\nDetails:\n" . $request->message;
        $msg->save();

        // Optional: Send email to admin (can be added later if needed)

        flash(localize('Your event inquiry has been submitted successfully! We will contact you soon.'))->success();
        return back();
    }
}
