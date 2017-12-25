@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">Overview</div>
			<div class="panel-body">

				<h3>Service Overview</h3>
                <hr>
                <p>Get specific information about this service.</p>
                    <div class="col-md-6">
                        <h4>Service-ID: {{$service->id}}</h4>
                        <h4>Product: {{$product->name}}</h4>
                        <h4>Status: @if($service->status ==1 && $service->due_date > time())
                                            <span class="label label-success">Active</span>
                                        @elseif($service->status == 2 && $service->due_date > time())
                                            <span class="label label-default">Terminated</span>
                                        @elseif($service->status == 3 && $service->due_date > time())
                                            <span class="label label-warning">Suspended</span>
                                        @else
                                            <span class="label label-default">Expired</span>
                                        @endif</h4>
                    </div>
                    <div class="col-md-6">
                        <h4>Ordered: {{date('d.m.Y', $service->creation)}}</h4>
                        <h4>Due-Date: {{date('d.m.Y', $service->due_date)}}</h4>
                        <h4>Renewal: @if($product->duration >0) Every {{$product->duration}} day(s) @else Never (Lifetime product) @endif</h4>
                        <h4>Price: {{$product->price}}€</h4>
                    </div>
                 
                       
                </div>
			</div>
<div class="panel panel-default">
			<div class="panel-heading">Options </div>
			<div class="panel-body">
                @if($service->status != 1 || $service->due_date < time())
                    <div class="alert alert-warning alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <strong>Information:</strong><br> Your product is @if($service->status == 2 && $service->due_date > time())
                                                                        terminated
                                                                    @elseif($service->status == 3 && $service->due_date > time())
                                                                        suspended
                                                                    @else
                                                                        expired
                                                                    @endif
                                                        and can not be managed any longer! 
                    </div>
                @else
                    @foreach(DB::table('license_keys')->where('service_id',$id)->get() as $license)

                    <div class="col-md-6">
                        <h4>IP: @if(empty($license->ip)) No IP registered! @else{{$license->ip}}  <a class="modal-accept btn btn-xs btn-warning" href="#" data-toggle="modal" data-target="#license_{{$license->id}}"><i class="fa fa-repeat"></i> Reset IP</a>@endif</h4>
                    </div>
                    <div class="col-md-6">
                        <h4>Licensekey: <code data-toggle="tooltip" data-placement="bottom" title="You can use this key on up to {{$product->licenses}} URLs">{{$license->key}}</code></h4>
                        <h4>Directory: <code>{{$license->directory}}</code></h4>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="license_{{$license->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Reset URL</h4>
                          </div>
                          <div class="modal-body">
                            <div class="alert alert-warning alert-dismissible" role="alert">

                              <strong>ATTENTION!</strong><br> 
                                <p>Resetting the URL will allow users knowing your key to activate their own URL! Only reset it, if you can re-enter in a very small timeframe.<br>
                                <b>If you are not able to use the key, don't reset it!</b></p>
                            </div>
                              <div class="row">
                                <div class="col-md-8">
                                    <p>License-Key: <code>{{$license->key}}</code></p>
                                    <p>Old IP: {{$license->ip}}</p>
                                    <a href="{{URL::to('license/reset/'.$license->id)}}" class="btn btn-danger wait-button">Yes, reset it!</a>
                                </div>
                              </div>


                          </div>
                          <div class="modal-footer">
                          </div>
                        </div>
                      </div>
                    </div>
                @endforeach
                @endif
                 
                       
                </div>
			</div>
        @if($service->status==1)
<div class="panel panel-default">
			<div class="panel-heading">Actions</div>
			<div class="panel-body">
                    <div class="col-md-6">
                        <a href="#" data-toggle="modal" data-target="#terminate_service" class="btn btn-danger">Terminate Service</a>
                <div class="modal fade" id="terminate_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Terminate Service</h4>
                          </div>
                          <div class="modal-body">
                            <div class="alert alert-warning alert-dismissible" role="alert">

                              <strong>ATTENTION!</strong><br> 
                                <p>Terminating your service will let all license keys associated with it become invalid! We will <b>not</b> refund your remaining payment!</p>
                            </div>
                              <div class="row">
                                <div class="col-md-8">
                                    <p>Service: {{$service->id}}</p>
                                    <p>Product: {{$product->name}}</p>
                                    <a href="{{URL::to('services/terminate/'.$service->id)}}" class="btn btn-danger wait-button">Yes, terminate it!</a>
                                </div>
                              </div>


                          </div>
                          <div class="modal-footer">
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                 
                       
                </div>
			</div>
        @endif
		</div>

	</div>
@stop


