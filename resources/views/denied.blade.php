<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Reason For Denied</h2>
  <form class="form-horizontal" action="{{route('post-denied-leave')}}" method="post">
    @csrf
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Comment:</label>
      <div class="col-sm-10">
        <textarea type="text" class="form-control" id="email" placeholder="Enter Comment" name="comment"></textarea>
        <input type="hidden" name="id" value="{{ $data['id'] }}"> 
      </div>
    </div>    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>
