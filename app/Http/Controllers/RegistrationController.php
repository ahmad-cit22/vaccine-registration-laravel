<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        $centers = VaccineCenter::all();
        return view('pages.register', compact('centers'));
    }

    public function store(RegistrationRequest $request)
    {
        // $request->validate([
        //     'nid' => 'required|unique:users,nid',
        //     'name' => 'required|string',
        //     'email' => 'required|email|unique:users,email',
        //     'vaccine_center_id' => 'required|exists:vaccine_centers,id',
        // ]);

        $user = User::create([
            'nid' => $request->nid,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        Vaccination::create([
            'user_id' => $user->id,
            'vaccine_center_id' => $request->vaccine_center_id,
        ]);

        return redirect()->route('search');
    }
}
