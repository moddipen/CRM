@extends('layouts/default')

@section('content')


    <section class="content-header">
    <h1>Ticket</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('home') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{route('ticket.index')}}">Ticket</a></li>
            <li class="active">Show Ticket</li>
        </ol>
    </section>
    <section>
        <h1>Tickets View </h1>

        </br>

        <div class="form-group col-sm-12">
            <strong >Ticket Number:</strong>
            <p>{{ $showTicket['ticket_number'] }}</p>
        </div>

        <div class="form-group col-sm-12">
            <strong >Title:</strong>
            <p>{{ $showTicket['title'] }}</p>
        </div>

        
        <div class="form-group col-sm-12">
            <strong>Description:</strong>
            <p>{{ $showTicket['description']  }}</p>
        </div>

        <div class="form-group col-sm-12">
            <strong>Status:</strong>
        
            @if($showTicket['status'] == 1)
                <p>Approved</p>  
            @else
                <p>Pending</p>
            @endif

        </div>
    </section>
@stop
