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
#res td, #res th, #res tr {
  border: none;
}
#dynamicAddRemove {
  border-collapse: collapse;
}
.error {
  display: none;
  margin-top: 10px;
  color: red;
}
</style>
<body>
  <form id="regForm" action="/step_3"method="post">
    @csrf
    <div style="text-align:center;margin-top:20px; margin-bottom:50px">
      <button disabled class="item step">Step 1</button>
      <button disabled class="item step1">Step 2</button>
      <button disabled class="item step">Step 3</button>
      <button disabled class="item step">Review</button>
    </div>
    <div class="tab1">
      <table class="table table-bordered" id = "res">
          <tr>
            <th>Please select a restaurant</th>
          </tr>
          <tr>
            <td>  
              <select name="selected_res" id="selected_res" class="form-control">
              <option value="" >------</option>
                @foreach ($restaurants as $m)
                  <option value="{{$m->id}}"  >{{$m->name}}</option>
                @endforeach      
              </select>
            <div id = "res_error" class ="error">Please select a restaurant</div>
            </td>
            
          </tr>
      </table>
    </div>
    <div class="tab2">        
      <table class="table table-bordered" id="dynamicAddRemove">
          <tr>
              <th>Please select a dish</th>
              <th>Please select no of servings</th>
          </tr>
          <tr id = "dishes">
              <td>  
                <select id = "selected_dish" class="form-select selected_dish"  name="addMoreInputFields[0][dish]">                     
                </select>
              </td>
              <td><input type="number" name="servings[0]" min="1" max = "10" class="form-control order_no" value = '1'></td>
              <td></td>
          </tr>
        </table>
        <div id = "dish_error"class = "error">Please don't select one dish twice</div>
        <div id = "number1_error"class = "error">Total dishes/serverings is greater or equal total customers</div>
        <div id = "number2_error"class = "error">Maximum of total dishes/serverings is 10</div>
        <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Dish</button>
    </div>
    <div class="tab3">
      <div>Meal: {{$selected_meal}}</div>
      <div>No of People: {{$quantity_customers}}</div>
      <div>Restaurant: <span id = "res_info"></span> </div>
      <div style="display: inline;"><span>Dishes:</span>
        <table class="table table-bordered" id = "dish_info">
        </table>
      </div>
    </div>
    <div style="overflow:auto;">
      <div style="float:right;">
          <button id = "back-1" class="btn btn-outline-success btn-block" type="button" onclick="window.location='{{ route('step_1') }}'">Previous</button>
          <button id = "back-2" class="btn btn-outline-success btn-block" type="button" >Previous</button>
          <button id = "back-3" class="btn btn-outline-success btn-block" type="button" >Previous</button>
          <button id = "next-3" class="btn btn-outline-success btn-block" type="button">Next</button>
          <button id = "next-4" class="btn btn-outline-success btn-block" type="button">Next</button>
          <button id = "submit" class="btn btn-outline-success btn-block" type="submit">Submit</button>
      </div>
    </div>
  </form>
</body>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
  var i = 0;
  var selectElement = document.getElementById("selected_dish");
  $("#dynamic-ar").click(function () {
    ++i;
    $("#dynamicAddRemove").append('<tr><td>'+  
        '<select name="addMoreInputFields['+i+'][dish]"class="form-select selected_dish">'+
        `${selectElement.innerHTML} </select>`+
    '</td>' +
    '<td><input type="number" name="servings['+i+ ']"  min="1" max = "10" class="form-control order_no" value = "1"></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
    );
    // update data for dishes option
    var firstDropdown = document.getElementById("selected_res");
    var secondDropdown = document.querySelectorAll(".selected_dish");
    firstDropdown.addEventListener("change", function() {
      var selectedOption = this.value;
      var data = @json($dishes);
      secondDropdown.forEach(function(s){
        while (s.firstChild) {
        s.removeChild(s.firstChild); 
      }
      data[selectedOption].forEach(function(d) {
        var option1 = document.createElement("option");
        option1.text = d;
        option1.value = d;
        s.appendChild(option1);    
      })
      });
    });
    // Delete button
    $(document).on('click', '.remove-input-field', function () {
      $(this).parents('tr').remove();
    });
  })
</script>
<script>
  var firstDropdown = document.getElementById("selected_res");
  var steps = document.getElementsByClassName('item')
  $('.tab2').hide()
  $('.tab3').hide()
  $('#back-2').hide()
  $('#back-3').hide()
  $('#next-4').hide()
  $("#submit").hide()
  $('#next-4').click(function(){
    // get data order detail preview
    var dish_info = document.getElementById('dish_info')
    while (dish_info.firstChild) {
      dish_info.removeChild(dish_info.firstChild); 
    }
    var selectedDishes = document.querySelectorAll(".selected_dish");
    var orderNos = document.querySelectorAll(".order_no")
    for (var i = 0; i < selectedDishes.length; i++) {
      var dish_tr = document.createElement("tr");
      var dish_th = document.createElement("th");
      dish_th.textContent = selectedDishes[i].value;
      dish_th.textContent += (' - '+orderNos[i].value);
      dish_tr.appendChild(dish_th)
      dish_info.appendChild(dish_tr)
    }
    // check data before go to next step
    var selectedDishArr = [];
    var totalServer = 0;
    var customerQuantity = parseInt("{{$quantity_customers}}")
    selectedDishes.forEach(function(item){
      selectedDishArr.push(item.value)
    })
    orderNos.forEach(function(item){
      totalServer += parseInt(item.value)
    })
    function areAllElementsUnique(arr) {
      var uniqueValues = new Set(arr);
      return uniqueValues.size === arr.length;
    }
    $('#dish_error').hide();
    $('#number1_error').hide();
    $('#number2_error').hide();
    if (areAllElementsUnique(selectedDishArr) && customerQuantity <= totalServer  ) {
      $('.tab3').show()
      $('.tab2').hide()
      $('.tab1').hide()
      $('#back-1').hide()
      $('#back-2').hide()
      $('#back-3').show()
      $('#next-3').hide()
      $('#next-4').hide()
      $("#submit").show()
      steps[2].classList.remove('step1')
      steps[2].classList.add('step')
      steps[3].classList.add('step1')
      steps[3].classList.remove('step')
    } else if (!areAllElementsUnique(selectedDishArr)) {
      $('#dish_error').show();
    } else if (customerQuantity > totalServer ){
      $('#number1_error').show();
    } else if (totalServer > 10) {
      $('#number2_error').show();
    }
  })
  $('#back-3').click(function(){
    $('.tab1').hide()
    $('.tab2').show()
    $('.tab3').hide()
    $('#back-1').hide()
    $('#back-2').show()
    $('#back-3').hide()
    $('#next-3').hide()
    $('#next-4').show()
    $("#submit").hide()
    steps[3].classList.remove('step1')
    steps[3].classList.add('step')
    steps[2].classList.add('step1')
    steps[2].classList.remove('step')
  })
  $('#next-3').click(function(){
    if (firstDropdown.value == '') {
      $('#res_error').show()
    } else {
      $('#res_error').hide()
      $('.tab1').hide()
      $('.tab2').show()
      $('#back-1').hide()
      $('#back-2').show()
      $('#next-3').hide()
      $('#next-4').show()
      $("#submit").hide()
      steps[1].classList.remove('step1')
      steps[1].classList.add('step')
      steps[2].classList.add('step1')
      steps[2].classList.remove('step')
    }  
  })
  $('#back-2').click(function(){
    $('.tab1').show()
    $('.tab2').hide()
    $('#back-1').show()
    $('#back-2').hide()
    $('#next-3').show()
    $('#next-4').hide()
    $("#submit").hide()
    steps[2].classList.remove('step1')
    steps[2].classList.add('step')
    steps[1].classList.add('step1')
    steps[1].classList.remove('step')
  })
  $(document).ready(function() {
    var firstDropdown = document.getElementById("selected_res");
    var secondDropdown = document.querySelectorAll(".selected_dish");
    // Update data for dishes option
    firstDropdown.addEventListener("change", function() {
      var selectedOption = this.value;
      // get data restauranrs
      var data_res = @json($restaurants);
      // find selected restaurant
      var foundItem = data_res.find(function(item) {
          return item.id == selectedOption;
      });  
      // create restaurant info element
      var res_text = document.createElement("span");
      res_text.textContent = foundItem.name;
      var res_info = document.getElementById('res_info')
      while (res_info.firstChild) {
        res_info.removeChild(res_info.firstChild); 
        }
      res_info.appendChild(res_text)
      // update data for dishes by restaurant
      var data = @json($dishes);
      secondDropdown.forEach(function(s){
        while (s.firstChild) {
          s.removeChild(s.firstChild); 
        }
        data[selectedOption].forEach(function(d) {
          var option1 = document.createElement("option");
          option1.text = d;
          option1.value = d;
          s.appendChild(option1);
        })
      });
    });
  });
</script>
</html>