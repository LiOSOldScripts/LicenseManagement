@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Support-Tickets</div>
                <div class="panel-body">

                    <h3>Create new Ticket</h3>
                    <hr>
                    <form action="{{URL::to('support/create')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="topic">Topic</label>
                                <input type="text" name="topic" id="topic" class="form-control" placeholder="Enter your topic here" required><br>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="name">Your name </label>
                                <input type="text" name="name" id="name" disabled class="form-control" placeholder="Your name" value="{{ Auth::user()->first.' '.Auth::user()->last }}" required><br>
                            <label for="service">Service</label>
                            <select class="form-control" name="service" id="service" required>
                                <option value="0">None</option>
                                @foreach(DB::table('services')->where('owner', \Illuminate\Support\Facades\Auth::user()->id)->get() as $service)
                                    <?php
                                        $product = DB::table('products')->where('id', $service->product)->first();
                                    ?>
                                    <option value="{{$service->id}}">{{$product->name}} (@if($service->status ==1 && $service->due_date > time())
                                            <span class="label label-success">Active</span>
                                        @elseif($service->status == 2 && $service->due_date > time())
                                            <span class="label label-default">Terminated</span>
                                        @elseif($service->status == 3 && $service->due_date > time())
                                            <span class="label label-warning">Suspended</span>
                                        @else
                                            <span class="label label-default">Expired</span>
                                        @endif) </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="department">Department</label>
                            <select id="department" name="department" class="form-control">
                                @foreach(DB::table('departments')->get() as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><br>
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" placeholder="Type your message in here..." class="form-control" rows="10" required></textarea>
                            <br>
                            <input type="submit" value="Submit" class="btn btn-success">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
