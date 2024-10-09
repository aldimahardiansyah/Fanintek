<?php

namespace App\Http\Controllers;

use App\Models\Epresence;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EpresenceController extends Controller
{
    public function index()
    {
        $presences = DB::table('epresence')
            ->join('users', 'epresence.id_users', '=', 'users.id')
            ->select('epresence.*', 'users.nama as nama')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->waktu)->format('Y-m-d');
            });

        $data = [];
        foreach ($presences as $date => $presence) {
            $in = $presence->where('type', 'IN')->first();
            $out = $presence->where('type', 'OUT')->last();

            $data[] = [
                'id_user' => $in->id_users,
                'nama_user' => $in->nama,
                'tanggal' => $date,
                'waktu_masuk' => $in->waktu ? Carbon::parse($in->waktu)->format('H:i:s') : null,
                'waktu_pulang' => $out->waktu ? Carbon::parse($out->waktu)->format('H:i:s') : null,
                'status_masuk' => $in->is_approve ? 'APPROVE' : 'REJECT',
                'status_pulang' => $out->is_approve ? 'APPROVE' : 'REJECT',
            ];
        }

        return response()->json([
            'message' => 'Success get data',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        // get user data from token
        $user = $request->user();

        $request->validate([
            'waktu' => 'required',
            'type' => 'required|in:IN,OUT',
        ]);

        $presence = Epresence::create([
            'waktu' => $request->waktu,
            'type' => $request->type,
            'id_users' => $user->id,
        ]);

        return response()->json([
            'message' => 'Presence added successfully',
            'data' => $presence
        ], 201);
    }

    public function approval(Request $request, $id)
    {
        $presence = Epresence::find($id);

        if (!$presence) {
            return response()->json([
                'message' => 'Presence not found'
            ], 404);
        }

        if ($presence->user->npp_supervisor != $request->user()->npp) {
            return response()->json([
                'message' => 'You are not authorized to approve this presence'
            ], 403);
        }

        $request->validate([
            'is_approve' => 'required|boolean',
        ]);

        $presence->is_approve = $request->is_approve;
        $presence->save();

        return response()->json([
            'message' => 'Presence updated successfully',
            'data' => $presence
        ], 200);
    }
}
