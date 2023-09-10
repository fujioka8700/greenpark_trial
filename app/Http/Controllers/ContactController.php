<?php

namespace App\Http\Controllers;

use App\Mail\Contacted;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
  public function send(ContactRequest $request)
  {
    $params = [
      'name' => $request->name,
      'email' => $request->email,
      'body' => $request->body,
    ];

    \Mail::to(config('mail.admin'))->send(new Contacted($params));
  }
}
