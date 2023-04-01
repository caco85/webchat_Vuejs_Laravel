<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Events\Chat;

class MessageController extends Controller
{

    public function listMessages(User $user)
    {
        $userFrom_id = Auth::user()->id;
        $userTo_id = $user->id;

        $messages = Message::where(

            function($query) use ($userFrom_id, $userTo_id){
                $query->where([
                    'from' => $userFrom_id,
                    'to' =>$userTo_id
                ]);
            }

        )->orWhere(

            function($query) use ($userFrom_id, $userTo_id){
                $query->where([
                    'from' => $userTo_id,
                    'to' => $userFrom_id
                ]);
            }

        )->orderBy('created_at', 'ASC')->get();

        return response()->json([
            'messages' => $messages], Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->from = Auth::user()->id;
        $message->to  = $request->to;
        $message->content = filter_var($request->content, FILTER_SANITIZE_STRIPPED);
        $message->save();

        Event::dispatch(new SendMessage($message, $requet->to));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
