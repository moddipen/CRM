<!DOCTYPE html>
<html lang="en">
<head>
 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h1 align='center'>General Leave Details</h1>
         
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Date</th>
       
      </tr>
    </thead>
    <tbody>
      @foreach($generalLeave as $val)
      <tr>
        
          <td>{{ $val->title }}</td>
          <td>{{ $val->date}}</td>
        
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

</body>
</html>
