@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">Support-Tickets</div>
			<div class="panel-body">

				<h3>Ticket-Overview</h3>
                <hr>
                <p>Here you can check your tickets and their status.</p>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                                <th>#</th>
                                <th>Topic</th>
                                <th>Status</th>
                                <th>Service</th>
                                <th>Department</th>
                                
                            </tr>
                          </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td>#{{Crypt::decrypt($ticket->ticket_id)}}</td>
                                    <td>{{Crypt::decrypt($ticket->topic)}}</td>
                                    <td>@if(Crypt::decrypt($ticket->status) ==1)
                                            <span class="label label-success">Active</span>
                                        @elseif(Crypt::decrypt($ticket->status) == 2)
                                            <span class="label label-warning">Canceled</span>
                                        @elseif(Crypt::decrypt($ticket->status) == 3)
                                            <span class="label label-info">In Progress</span>    
                                        @else
                                            <span class="label label-danger">Closed</span>
                                        @endif
                                    @if(Crypt::decrypt($ticket->service) != 0)
                                        <?php
                                            $product_id = DB::table('services')->where('id',Crypt::decrypt($ticket->service))->first()->product;
                                        ?>
                                        <td>{{DB::table('products')->where('id', $product_id)->first()->name}}</td>
                                    @else
                                        <td><i>None</i></td>
                                    @endif
                                    <td>{{DB::table('departments')->where('id', Crypt::decrypt($ticket->department))->first()->name}}</td>
                                    <td><div class="btn-group">
                                          <a href="{{URL::to('support/tickets/'.Crypt::decrypt($ticket->ticket_id))}}" type="button" class="btn btn-default">View Ticket</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                {{$tickets->links()}}
                <a href="{{URL::to('support/create/')}}" class="btn btn-success">Create a new Ticket</a>
                    </div>
			</div>
		</div>
	</div>
</div>
@stop
