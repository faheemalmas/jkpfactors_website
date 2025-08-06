<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $receiverEmailAddress = "mtalhasajjad777@gmail.com";
        $senderEmail = "factorsjkp@gmail.com";
        $subject = "Your Subject Here";
        $content = "Your email content here.";

        try {
            Mail::to($receiverEmailAddress)->send(new ContactMail($senderEmail, $subject, $content));

            if (count(Mail::failures()) > 0) {
                return response()->json(['message' => 'Oops! There was some error sending the email.'], 500);
            }

            return response()->json(['message' => 'Email has been sent successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops! There was some error sending the email.'], 500);
        }
    }
}
