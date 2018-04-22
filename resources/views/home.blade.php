@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
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
                            </div>
                            <div class="col-md-12">
                                <a href="{{ route('appointment.index') }}" class="btn btn-primary button-margin"><span class="fa fa-plus"></span> New</a>
                            </div>
                        </div>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
