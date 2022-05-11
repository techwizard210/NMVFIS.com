<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\EmailDemo;
use PharIo\Manifest\Email;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{

    public function sendEmail()
    {
        $username = $request->username;
        $username = $_GET['username'];
        $email = $_GET['email'];
        $message = $_GET['message'];
        dump($username);
        dump($email);
        dump($message);
        exit;
        $email = 'vsevolod.barmin.dev@gmail.com';

        $mailData = [
            'title' => 'Mail from NMVFIS.com',
            'username' => $username,
            'email' => $email,
            'body' => $message,
        ];

        Mail::to($email)->send(new EmailDemo($mailData));

        return response()->json([
            'message' => 'Email has been sent.'
        ], Response::HTTP_OK);
        // return redirect("contact.php")->withSuccess('Email has been sent');
    }
}
