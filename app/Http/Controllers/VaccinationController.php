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
                'status' => $vaccination->status,
                'message' => 'You are registered but your vaccination is not scheduled yet. We will notify you via email soon when scheduled.',
            ];
        }

        if ($vaccination->scheduled_date == today()) {
            return [
                'status' => $vaccination->status,
                'message' =>
                'Your vaccination is scheduled on today at ' . $vaccination->vaccineCenter->name . ' center.',
            ];
        } else if ($vaccination->scheduled_date < now()) {
            $vaccination->status = 'Vaccinated';
            $vaccination->save();

            return [
                'status' => $vaccination->status,
                'message' => 'You have been vaccinated on ' . $vaccination->scheduled_date->format('F j, Y') . ' at ' . $vaccination->vaccineCenter->name . ' center.',
            ];
        } else {
            return [
                'status' => $vaccination->status,
                'message' => 'Your vaccination is scheduled on ' . $vaccination->scheduled_date->format('F j, Y') . ' at ' . $vaccination->vaccineCenter->name . ' center.',
            ];
        }
    }
}
