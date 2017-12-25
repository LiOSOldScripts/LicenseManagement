<?php namespace App\Http\Controllers;
use App\User;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class UpdateController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    private function generateTicketID($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return '#'.$randomString;

    }
    public function UpdateTickets(){
        $tickets = DB::table('users')->get();

        foreach($tickets as $ticket){
            DB::table('users')
                ->where('id', $ticket->id)
                ->update(array(
                    'first'    => Crypt::encrypt($ticket->first),
                    'last'   => Crypt::encrypt($ticket->last),
                    'ip'      => Crypt::encrypt($ticket->ip),

                    ));
        }
    }

}
