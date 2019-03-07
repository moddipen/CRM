@extends('layouts/default')
@section('title')
Error Report List
@parent
@stop
@section('content')

<html>
     <link rel="stylesheet" type="text/css" href="{{asset('public/prettyPhoto/css/prettyPhoto.css')}}">
</html>

<section class="content-header">
        
        <h1> {{  _('Error Details')}}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{route('error.index')}}">Error Report</a></li>
            <li class="active">Error details</li>
        </ol>
    </section>
    <section class="content">
        	
        	<h1>Error Report</h1>

        		<div class="form-group col-sm-12">
            		<strong >Title:</strong>
            		<p>{{ $viewError['title'] }}</p>
        		</div>
                <div class="form-group col-sm-12">
                    <strong>Description:</strong>
                    <p>{{ $viewError['description'] }}</p>
                </div>
 				<div class="form-group col-sm-12">
            		<strong >Attachment:</strong>
            		@if($viewError['attachment'] == '')
            			<p>No Attachment Found</p>
            		@else

                        <p><a rel="prettyPhoto" href="{{ asset('storage/app/'.$viewError['attachment']) }}" width="100px;" height="60px;" >
                          <img style="width:200px; height:200px;" src="{{ asset('storage/app/'.$viewError['attachment']) }}">
                      </a>

            			</p>
            		@endif
        		</div>

				<div class="form-group col-sm-12">
            		<strong >Video Link:</strong>
            		@if($viewError['title'] == '')
            			<p> No Video Link Found</p>
            		@else
            			<p><a href="{{ $viewError['video_link'] }}" target="_blank" >{{ $viewError['video_link'] }}</a></p>
            		@endif
        		</div>
				
                <div class="form-group col-sm-12">
                	@if($viewError['status'] == 1)
            		<strong >Fixed By ,</strong>
            		<p>{{$viewError->users->name}}</p>
            		@elseif($viewError['status'] == 0 && $viewError['updated_by'] != NULL)
            		<strong >Reopened By ,</strong>
            		<p>{{$viewError->users->name}}</p>
            		@endif
        		</div>
				
           
       
        <form action="{{route('error.fix',$viewError->id)}}" method="post">
        	@csrf
        	<input name="_method" type="hidden" value="PUT" />

	        <button align = 'center' type="submit" class="btn btn-success btn-lg" data-toggle="tooltip" data-placement="left" data-original-title="Solve Error" id="delButton">
	        @if($viewError['status'] == 0)
	        	Fix
	       	@else
	       		Reopen
	       	@endif
	        </button>

        </form>
        <!--row end-->
    </section>

    
@stop
    @section('footer_scripts')
    <script type="text/javascript" src="{{ asset('public/prettyPhoto/js/jquery-1.6.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/prettyPhoto/js/jquery.prettyPhoto.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("a[rel^='prettyPhoto']").prettyPhoto({'social_tools':false});
        });
    </script>
    @stop