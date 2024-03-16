<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
* {
  box-sizing: border-box;
}
body {
  background-color: #f1f1f1;
}
#regForm {
  background-color: #ffffff;
  margin: 100px auto;
  font-family: Raleway;
  padding: 40px;
  width: 40%;
  min-width: 100px;
}
h1 {
  text-align: center;  
}
.step {
  background-color: #bbbbbb;
  border: none;  
  display: inline-block;
  opacity: 0.5;
  align-items: center;
}
.step1 {
  background-color: #04AA6D; 
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}
#dynamicAddRemove{
  justify-content: center;
}
#dynamicAddRemove td, #dynamicAddRemove th, #dynamicAddRemove tr {
border: none;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<body>
  <form id="regForm" action="/step_2"method = "post">
    @csrf
    <div style="text-align:center;margin-top:20px; margin-bottom:50px">
      <button disabled class="item step1">Step 1</button>
      <button disabled class="item step">Step 2</button>
      <button disabled class="item step">Step 3</button>
      <button disabled class="item step">Review</button>
    </div>
    <div class="tab">        
      <table class="table table-bordered" id = "dynamicAddRemove">
          <tr>
              <th>Please select a meal</th>
              <th>Please enter number of people</th>
          </tr>
          <tr>
            <td>  
              <select name="selected_meal" id="selected_meal" class = "form-select">
                @foreach ($meals as $m)
                  <option {{ $selected_meal == $m ? 'selected' : '' }} value="{{$m}}"  >{{$m}}</option>
                @endforeach      
              </select>
            </td>
            <td>
              <input class="form-control" type="number" id="quantity_customers" name="quantity_customers" min="1" max = "10" value="{{$quantity_customers ?? 1}}">
            <td>
          </tr>
      </table>
    </div>
    <div style="overflow:auto;">
      <div style="float:right;">
        <button type="submit" class="btn btn-outline-success btn-block">Next</button>
      </div>
    </div>
  </form>
</body>
</html>