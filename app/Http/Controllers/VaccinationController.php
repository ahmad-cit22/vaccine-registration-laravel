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

    // public function search(Request $request)
    // {
    //     $status = null;
    //     $date = null;

    //     if ($request->nid != null) {
    //         $request->validate(['nid' => 'min_digits:10']);

    //         $user = User::with('vaccination')->where('nid', $request->nid)->first();

    //         if (!$user) {
    //             $status = 'Not registered';
    //             return view('pages.search', compact('status', 'date'));
    //         }

    //         $vaccination = $user->vaccination;

    //         if (!$vaccination) {
    //             $status = 'Not registered';

    //             return view('pages.search', compact('status', 'date'));
    //         }

    //         if ($vaccination->status === 'Scheduled') {
    //             $status = 'Not registered';
    //             $date = $vaccination->scheduled_date;

    //             return view('pages.search', compact('status', 'date'));
    //         }

    //         if ($vaccination->scheduled_date < now()) {
    //             $vaccination->status = 'Vaccinated';
    //             $vaccination->save();
    //         }

    //         $status = $vaccination->status;
    //     }

    //     return view('pages.search', compact('status', 'date'));
    // }

    public function search(Request $request)
    {
        if (!$request->nid || strlen($request->nid) < 10) {
            return response()->json([
                'status' => 'validationFailed',
                'message' => 'You must enter a valid NID number containing at least 10 digits.',
            ]);
        }

        $user = User::where('nid', $request->nid)->first();

        if (!$user) {
            return response()->json([
                'status' => 'Not registered',
                'message' => 'This NID is not registered for vaccination yet. Please register first.',
            ]);
        }

        $vaccination = Vaccination::with('vaccineCenter')->where('user_id', $user->id)->first();

        $result = $this->getVaccinationStatus($vaccination);

        return response()->json([
            'status' => $result['status'],
            'message' => $result['message'],
        ]);
    }

    protected function getVaccinationStatus($vaccination)
    {
        if ($vaccination->scheduled_date == null) {
            return [
                'status' => 'Not scheduled',
                'message' => 'You are registered but your vaccination is not scheduled yet. We will notify you via email when scheduled.',
            ];
        }

        if ($vaccination->scheduled_date == today()) {
            $vaccination->status = 'Vaccinated';
            $vaccination->save();

            return [
                'status' => 'Scheduled',
                'message' =>
                'Your vaccination is scheduled on today at ' . $vaccination->vaccineCenter->name . ' center.',
            ];
        } else if ($vaccination->scheduled_date < now()) {
            $vaccination->status = 'Vaccinated';
            $vaccination->save();

            return [
                'status' => 'Vaccinated',
                'message' => 'You have been vaccinated on ' . $vaccination->scheduled_date->format('F j, Y') . ' at ' . $vaccination->vaccineCenter->name . ' center.',
            ];
        } else {
            return [
                'status' => 'Scheduled',
                'message' => 'Your vaccination is scheduled on ' . $vaccination->scheduled_date->format('F j, Y') . ' at ' . $vaccination->vaccineCenter->name . ' center.',
            ];
        }
    }
}
