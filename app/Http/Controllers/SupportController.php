<?php namespace App\Http\Controllers;
 use App\User;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Crypt;
 use Illuminate\Support\Facades\Input;
 use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;

 class SupportController extends Controller {



	 private function generateTicketID()
	 {
		 $key = md5(time());
         $offset = rand(0,24);
		 $key = substr($key, $offset, 8);

		 return $key;

	 }
	 /**
	  * Create a new controller instance.
	  *
	  * @return void
	  */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $tickets = DB::table('tickets')->where('owner', \Auth::user()->id)->paginate(10);
		return view('support.index', array('site'=>'Support', 'tickets'=>$tickets));
	}

	public function GET_Create()
	{
		return view('support.create', array('site'=>'Create a new Ticket'));
	}

	 public function POST_Create()
	{
		$input = Input::all();

		$ticket_id = $this->generateTicketID();
		$id = DB::table('tickets')->insertGetId(
			array(
				'ticket_id' => Crypt::encrypt($ticket_id),
				'owner' => Auth::user()->id,
				'status'=>Crypt::encrypt(1),
				'last_reply'=>Crypt::encrypt(time()),
				'topic'=>Crypt::encrypt($input['topic']),
				'department'=>Crypt::encrypt($input['department']),
				'service'=>Crypt::encrypt($input['service'])
			)
		);
		$ticket = DB::table('replies')->insertGetId(
			array(
				'ticket' => $id,
				'author' => Crypt::encrypt(Auth::user()->id),
				'date'=>Crypt::encrypt(time()),
				'message'=>Crypt::encrypt(nl2br(e($input['message'])))
			)
		);
		return view('support.ticket_created', array('site'=>'Ticket created!', 'ticket_id'=>$ticket_id, 'id'=>$ticket));
	}

     public function ShowSingle($id)
     {
         $tickets = DB::table('tickets')->where('owner', Auth::user()->id)->get();
         $return = [];
         foreach($tickets as $ticket)
         {
            $return[Crypt::decrypt($ticket->ticket_id)] = $ticket->id;
         }
         if(empty($return[$id]))
             App::abort(404);
         $ticket_details = DB::table('tickets')->where('id',$return[$id])->first();
         $replies = DB::table('replies')->where('ticket', $return[$id])->orderBy('id', 'desc')->get();

         return view('support.ticket', array('site'=>'Ticket: #'.$id, 'ticket'=>$ticket_details, 'replies'=>$replies));
     }
}
