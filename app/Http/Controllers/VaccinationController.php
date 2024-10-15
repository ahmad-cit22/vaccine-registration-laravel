<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{

    public function search_view()
    {
        return view('pages.search');
    }

    public function search(Request $request)
    {
        $request->validate(['nid' => 'required']);

        $user = User::with('vaccination')->where('nid', $request->nid)->first();

        if (!$user) {
            return view('status', ['status' => 'Not registered']);
        }

        $vaccination = $user->vaccination;

        if (!$vaccination) {
            return view('status', ['status' => 'Not registered']);
        }

        if ($vaccination->status === 'Scheduled') {
            return view('status', ['status' => 'Scheduled', 'date' => $vaccination->scheduled_date]);
        }

        if ($vaccination->scheduled_date < now()) {
            $vaccination->status = 'Vaccinated';
            $vaccination->save();
        }

        return view('status', ['status' => $vaccination->status]);
    }
}
