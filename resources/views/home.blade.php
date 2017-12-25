@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">Dashboard</div>
			<div class="panel-body">

				<h3>Hello, {{ Auth::user()->first.' '.Auth::user()->last }}</h3>
                <hr>
                <p>Here you can check your services and their status.</p>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                                <th>#</th>
                                <th>Package</th>
                                <th>Status</th>
                                <th>Expire-Date</th>
                            </tr>
                          </thead>
                            <tbody>
                                @foreach(DB::table('services')->where('owner', Auth::user()->id)->get() as $service)
                                <?php
                                    $product = DB::table('products')->where('id', $service->product)->first();
                                ?>
                                <tr>
                                    <td>{{$service->id}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>@if($service->status ==1 && $service->due_date > time())
                                            <span class="label label-success">Active</span>
                                        @elseif($service->status == 2 && $service->due_date > time())
                                            <span class="label label-default">Terminated</span>
                                        @elseif($service->status == 3 && $service->due_date > time())
                                            <span class="label label-warning">Suspended</span>
                                        @else
                                            <span class="label label-default">Expired</span>
                                        @endif
                                    <td>{{date('d.m.Y', $service->due_date)}}</td>
                                    <td><div class="btn-group">
                                          <a href="{{URL::to('services/'.$service->id)}}" type="button" class="btn btn-default">View Service</a>
                                        @if($service->status == 1 && $service->due_date > time())
                                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                        @endif
                                          <ul class="dropdown-menu" role="menu">
                                        @if($product->download_id != 0)
                                              <li><a href="{{URL::to('downloads/'.$product->download_id)}}">Show Download</a></li>
                                              <li class="divider"></li>
                                        @endif
                                        @if($service->status == 1 && $service->due_date > time())
                                            <li><a href="#" data-toggle="modal" data-target="#terminate_service_{{$service->id}}">Terminate Service</a></li>
                                        @endif
                                          </ul>
                                        </div>
                                    </td>
                                </tr>
<div class="modal fade" id="terminate_service_{{$service->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Terminate Service</h4>
                          </div>
                          <div class="modal-body">
                            <div class="alert alert-warning alert-dismissible" role="alert">

                              <strong>ATTENTION!</strong><br> 
                                <p>Terminating your service will let all license keys associated with it become invalid! We will <b>not</b> refund your remaining payments!</p>
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
                            @endforeach
                            </tbody>
                        </table>
                    </div>
			</div>
		</div>
	</div>
</div>
@stop
