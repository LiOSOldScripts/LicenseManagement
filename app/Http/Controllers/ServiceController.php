<?php 
namespace App\Http\Controllers;
use App\User;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
class ServiceController extends Controller {

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
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    private function generateKey($prepend){
             $key = md5(time());
             $new_key = '';
             for($i=1; $i <= 25; $i ++ ){
                       $new_key .= $key[$i];
                       if ( $i%5==0 && $i != 25) $new_key.='-';
             }
          return strtoupper($prepend.'-'.$new_key);
    }
	public function ShowService($id)
	{

          $key = $this->generateKey('alpha');
        $service = DB::table('services')->where('id', $id)->first();
		return view('dashboard.single_service', array(
                                                        'id'=>$id, 
                                                        'site'=>'Service: #'.$id, 
                                                        'product'=>DB::table('products')->where('id', $service->product)->first(), 
                                                        'service'=>$service,
                                                        'key'=>$key));
	}
    public function resetLicense($id){
        //Get information about owner first
        $license = DB::table('license_keys')->where('id',$id)->first();
        $service = DB::table('services')->where('id',$license->service_id)->first();
        if(\Auth::user()->id != $service->owner){
            return \Redirect::to('/');
        }

        DB::table('license_keys')->where('id',$id)->update(array('ip'=>'', 'directory'=>''));
        return \Redirect::to('/services/'.$service->id);
    }
    public function TerminateService($id){
        //Get information about owner first
        $service = DB::table('services')->where('id',$id)->first();
        if(\Auth::user()->id != $service->owner){
            return \Redirect::to('/');
        }

        DB::table('services')->where('id',$id)->update(array('status'=>'2'));
        return \Redirect::to('/services/'.$id);
    }
}
