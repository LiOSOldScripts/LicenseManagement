@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Support-Tickets</div>
                <div class="panel-body">

                    <h3>Create new Ticket</h3>
                    <hr>
                    <div class="alert alert-success">
                        <div style="text-align: center;">
                            <h4>Ticket created successfully!</h4>
                            <p>Ticket-ID: <a href="{{URL::to('support/'.$ticket_id)}}">#{{$ticket_id}}</a></p>

                            <p>Thanks for contacting us. Please wait until we answered your ticket, because we will answer it as soon as possible.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
