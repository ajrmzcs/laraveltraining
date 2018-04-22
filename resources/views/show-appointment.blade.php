@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Show appointment details</div>
                    <div class="card-body">
                        {{--Alerts--}}
                        @if (session('status'))
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                {{ session('status') }}
                            </div>
                        @endif
                        {{--Error--}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="title"><strong>Title</strong></label>
                            <p>{{ $appointment->title }}</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="description"><strong>Description</strong></label>
                            <p>{{ $appointment->description }}</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="datetime"><strong>Date</strong></label>
                            <p>{{ Carbon\Carbon::parse($appointment->appointment_date)->toRfc1036String() }}</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="notification_date"><strong>Send Notification</strong></label>
                            <p>{{ $appointment->notification_date }}</p>
                        </div>
                        <hr>
                        <br>
                        <a href="{{ route('appointment.edit', [$appointment->id]) }}" class="btn btn-primary"><span class="fa fa-edit"></span> Edit</a>
                        {{--Delete Appointment--}}
                        <form style="Display:inline" action="{{ route('appointment.destroy', [$appointment->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Delete</button>
                        </form>
                        <a href="{{ route('home') }}" class="btn btn-default"><span class="fa fa-arrow-left"></span> Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection