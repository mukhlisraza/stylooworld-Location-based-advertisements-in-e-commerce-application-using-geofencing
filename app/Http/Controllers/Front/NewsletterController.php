<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\NewsletterSubcriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    //
    public function checkSubscriberEmail(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $subscriberCount = NewsletterSubcriber::where('email', $data['subscriber_email'])->count();
            if ($subscriberCount > 0) {
                echo "Exists";
            } else {
                // Add email to table
                $newLetter = new NewsletterSubcriber;
                $newLetter->email = $data['subscriber_email'];
                $newLetter->status = 1;

                $newLetter->save();
                echo "Saved";
            }
        }
    }
}
