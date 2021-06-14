<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Serve index / route
     * @return Response
     */
    public function index()
    {
        return $this->successResponse(["version" => app()->version(), "servertime" => time()], "Welcome to Nyxordinal Online Notes API");
    }

    /**
     * Get note
     * @param string $note_id
     * @return Response
     */
    public function get($note_id)
    {
        try {
            $note = Note::firstOrCreate(
                ["title" => $note_id],
                ["content" => ""]
            );
            return $this->successResponse($note);
        } catch (\Exception $e) {
            return $this->badRequestResponse($e);
        }
    }

    /**
     * Update note
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        try {
            $this->validate($request, [
                'note_id' => 'required',
                'content' => 'required'
            ]);

            $note = Note::updateOrCreate(
                ["title" => $request->input('note_id')],
                ["content" => $request->input('content')]
            );

            return $this->successResponse($note);
        } catch (\Exception $e) {
            return $this->badRequestResponse($e);
        }
    }
}
