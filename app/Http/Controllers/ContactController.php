<?php
namespace App\Http\Controllers;

use App\Services\ContactService;
use Illuminate\Http\Request;


class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService) {
        $this->contactService = $contactService;
    }

    public function contact() {
        return view('pages.contact');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $this->contactService->handleContactForm($validated);

        return back()->with('success', 'Mesajınız uğurla göndərildi!');
    }
}