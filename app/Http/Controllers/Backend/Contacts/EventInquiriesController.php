<?php

namespace App\Http\Controllers\Backend\Contacts;

use App\Http\Controllers\Controller;
use App\Models\ContactUsMessage;
use Illuminate\Http\Request;

class EventInquiriesController extends ContactUsMessagesController
{
    # get all event inquiries
    public function index()
    {
        $messages = ContactUsMessage::where('message', 'like', 'Event Inquiry:%')
            ->orderBy('is_seen', 'ASC')
            ->latest()
            ->paginate(paginationNumber());
            
        return view('backend.pages.queries.events_index', compact('messages'));
    }

    # delete
    public function delete($id, $force = null)
    {
        $message = ContactUsMessage::where('id', $id)->first(); 
        if(!is_null($message)){
            if ($force != null) {
                $message->forceDelete();
            }else{
                $message->delete();
            }
        }
        
        flash(localize('Message deleted successfully'))->success();
        return redirect()->route('admin.events.queries.index');
    }

    # deleteAll
    public function deleteAll()
    {
        ContactUsMessage::where('message', 'like', 'Event Inquiry:%')->forceDelete();              
        flash(localize('Messages deleted successfully'))->success();
        return redirect()->route('admin.events.queries.index');
    }
}
