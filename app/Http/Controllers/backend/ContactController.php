<?php

namespace App\Http\Controllers\backend;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $this->authorize('create',Auth::user());
        $contacts = Contact::paginate(20);
        return view('backend.contact.list',compact('contacts'));
    }
    public function show($id)
    {
        $this->authorize('create',Auth::user());
        $contact = Contact::find($id);
        return view('backend.contact.show',compact('contact'));
    }
}
