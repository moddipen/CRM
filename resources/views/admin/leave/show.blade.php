@extends('layouts/default')

@section('content')


    <section class="content-header">
    <h1>Employee Leave</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('home') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{route('employee.leave.index')}}">Employee Leave</a></li>
           
        </ol>
    </section>
    <section>
        <h1>Show Leave</h1>

        </br>

        
        <div class="form-group col-sm-12">
            <strong >Title:</strong>
            <p>{{ $showLeave['title'] }}</p>
        </div>

        
        <div class="form-group col-sm-12">
            <strong>From:</strong>
            <p>{{ $showLeave['from']  }}</p>
        </div>

        
        <div class="form-group col-sm-12">
            <strong>To:</strong>
            <p>{{ $showLeave['to']  }}</p>
        </div>

        <div class="form-group col-sm-12">
            <strong>Description:</strong>
            <p>{{ $showLeave['description']  }}</p>
        </div>
        
        
    </section>
@stop
