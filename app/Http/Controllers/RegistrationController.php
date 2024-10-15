<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function create()
    {
        $centers = VaccineCenter::all();
        return view('pages.register', compact('centers'));
    }

    public function store(RegistrationRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'nid' => $request->nid,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            Vaccination::create([
                'user_id' => $user->id,
                'vaccine_center_id' => $request->vaccine_center_id,
            ]);

            DB::commit();

            return redirect()->route('search.view')->with('success', 'Registered successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Registration failed due to some error! Please try again or contact with us.');
        }
    }
}
