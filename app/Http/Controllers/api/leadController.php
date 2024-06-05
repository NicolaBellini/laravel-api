<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lead;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewContact;

class leadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'name' => 'required|min:3|max:100',
                'mail' => 'required|email',
                'text' => 'required|min:3',
            ],
            [
                'name.required' => 'Il campo nome è obbligatorio.',
                'name.min' => 'Il nome deve contenere almeno 3 caratteri.',
                'name.max' => 'Il nome non può superare i 100 caratteri.',
                'mail.required' => 'Il campo email è obbligatorio.',
                'mail.email' => 'Il formato dell\'email non è valido.',
                'text.required' => 'Il campo testo è obbligatorio.',
                'text.min' => 'Il testo deve contenere almeno 3 caratteri.',
            ]
        );
        if ($validator->fails()) {
            $success = false;
            $errors = $validator->errors();
            return response()->json(compact('success', 'errors'));
        }
        // salvo l' email nel db

        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        // invio l' email
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new NewContact($new_lead));


        // restituisco il json con l' avvenuto invio

        $success = true;
        return response()->json(compact('success'));
    }
}
