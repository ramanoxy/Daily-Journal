<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJournalRequest;
use App\Models\Journal;
use Illuminate\Http\JsonResponse;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJournalRequest $request): JsonResponse
    {
        // Karena input sudah divalidasi di StoreJournalRequest, kita bisa langsung ambil datanya
        $journal = Journal::create([
            'user_id' => 1, // Hardcode ke user dummy yang kita buat di Langkah 1
            'content' => $request->validated('content'),
            'focus_level' => $request->validated('focus_level'),
            'energy_level' => $request->validated('energy_level'),
            'entry_date' => now()->toDateString(), // Otomatis simpan tanggal hari ini
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jurnal berhasil disimpan.',
            'data' => $journal
        ], 201); // 201 = Created
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
