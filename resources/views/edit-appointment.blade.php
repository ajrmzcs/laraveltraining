@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit appointment</div>
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
                        <form method="POST" action="{{ route('appointment.update', [$appointment->id]) }}">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Insert title"
                                           value="{{ old('title', $appointment->title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $appointment->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="datetime">Date</label>
                                    <input type="datetime-local" class="form-control" id="datetime" name="datetime"
                                           value="{{ old('datetime', Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i:s') ) }}">
                                </div>
                                <div class="form-group">
                                    <label for="notification_date">Send Notification</label>
                                    <select class="form-control" name="notification_date">
                                        <option value="">-- Select status --</option>
                                        <option value="10" @if(old('notification_date') == 10) selected @endif>10 mins before</option>
                                        <option value="30" @if(old('notification_date') == 30) selected @endif>30 mins before</option>
                                        <option value="60" @if(old('notification_date') == 60) selected @endif>1 hr before</option>
                                        <option value="1440" @if(old('notification_date') == 1440) selected @endif>1 day before</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>&nbsp;&nbsp;
                                <button type="reset" class="btn btn-default">Reset</button>
                            </form>
                            <br>
                            <a href="{{ route('home') }}" class="btn btn-default"><span class="fa fa-arrow-left"></span> Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection