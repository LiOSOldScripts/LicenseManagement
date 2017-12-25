@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Viewing Ticket: #{{Crypt::decrypt($ticket->ticket_id)}}</div>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><b>Status:</b> @if(Crypt::decrypt($ticket->status) ==1)
                                <span class="label label-success">Active</span>
                            @elseif(Crypt::decrypt($ticket->status) == 2)
                                <span class="label label-warning">Canceled</span>
                            @elseif(Crypt::decrypt($ticket->status) == 3)
                                <span class="label label-info">In Progress</span>
                            @else
                                <span class="label label-danger">Closed</span>
                            @endif
                        </td>
                        <td>
                            <b>Assigned Service: </b>
                            @if(Crypt::decrypt($ticket->service) != 0)
                                <?php
                                $product_id = DB::table('services')->where('id',Crypt::decrypt($ticket->service))->first()->product;
                                ?>
                                {{DB::table('products')->where('id', $product_id)->first()->name}}
                            @else
                                <i>None</i>
                            @endif

                        </td>
                        <td>
                            <b>Last reply:</b> {{date('d.m.Y', Crypt::decrypt($ticket->last_reply))}}
                        </td>
                        <td>
                            <b>Department: </b> {{DB::table('departments')->where('id', Crypt::decrypt($ticket->department))->first()->name}}
                        </td>
                    </tr>
                    </tbody>
                </table>


            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Actions</div>
                <div class="panel-body">
                        @if(Crypt::decrypt($ticket->status) == 1)
                            <form method="post">
                        <textarea class="form-control" rows="7" placeholder="Type your answer here..."></textarea>
                        <br>
                        {{csrf_field()}}
                        <input type="submit" class="btn btn-success" value="Answer" data-loading-text="Loading...">
                    </form>
                        @else
                            <div class="alert alert-danger">Ticket is closed!</div>
                        @endif
                    <div class="pull-right">
                    </div>
                </div>
            </div>
            @foreach($replies as $reply)
                <div class="panel @if($reply->staff) panel-primary @else  panel-default @endif">
                    <?php
                        $user = DB::table('users')->where('id',Crypt::decrypt($reply->author))->first();
                    ?>
                    <div class="panel-heading">{{date('d.m.Y, H:m', Crypt::decrypt($reply->date))}} <span class="pull-right"><a href="#{{$reply->id}}">#</a> </span> </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-1" style="border-right:1px solid #eeeeee ;">
                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($user->email))}}" height="70" width="70" class="img-circle"><br>
                                <p>{{$user->first.' '.$user->last}}</p>
                                <hr>
                                @if($reply->staff)<span class="label label-primary">Staff</span> @endif
                                @if(!$reply->staff)<span class="label label-warning">Costumer</span> @endif
                                @if($user->id == Auth::user()->id) <span class="label label-info">You</span> @endif
                            </div>
                            <div class="col-lg-11">
                                <a id="{{$reply->id}}"></a>
                                {{Crypt::decrypt($reply->message)}}
                            </div>
                        </div>


                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop
