<?php

namespace App\Http\Controllers\Card;

use App\Card;
use App\Http\Requests\Cards\StoreRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DocCardController extends Controller
{
    /**
     * DocCardController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        $user = Auth::user();

        abort_if(! $user->isDoctor(), Response::HTTP_NOT_ACCEPTABLE, 'Not allowed');

        return view('card.create')->with(compact('id'));
    }

    /**
     * @param \App\Http\Requests\Cards\StoreRequest $request
     * @param                                       $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request, $id)
    {
        $patient           = User::findOrFail($id);
        $doc               = Auth::user();
        $data              = $request->validated();
        $data['doctor_id'] = $doc->id;
        $data['user_id']   = $patient->id;
        Card::create($data);

        return redirect()->back();
    }

}
