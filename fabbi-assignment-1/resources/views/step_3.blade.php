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
    <h2 style="text-align: center;">Detail of success order</h2>
  <div class="regForm">        
      <table class="table table-bordered" id = "dynamicAddRemove">
      <div>Meal: {{$meal}}</div>
      <div>No of People: {{$quantity_customers}}</div>
      <div>Restaurant: {{$selected_res}} </div>
      <div style="display: inline;"><span>Dishes:</span>
        <table class="table table-bordered" >
        @foreach($selected_dish as $index => $item)
            <tr>
                <th>
                    {{ $item['dish'] }} - {{ $servings[$index] }}
                </th>
            </tr>
        @endforeach
        </table>
      </div>
      </table>
    </div>
    <div style="overflow:auto;">
      <div style="float:right;">
      </div>
    </div>
  </form>
</body>
</html>