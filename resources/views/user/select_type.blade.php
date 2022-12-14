<div class="wrapper">

  @if($type == 1)

    <input type="radio" value="{{route('create-custom-quotation')}}" class="select-form" name="select" id="option-1">
    <input type="radio" value="{{route('create-new-quotation')}}" class="select-form" name="select" id="option-2">

  @elseif($type == 2)

    <input type="radio" value="{{route('customer-invoices')}}" class="select-form" name="select" id="option-1">
    <input type="radio" value="{{route('new-invoices')}}" class="select-form" name="select" id="option-2">

    @else

    <input type="radio" value="{{route('admin-product-create',['id' => $is_floor])}}" class="select-form" name="select" id="option-1">
    <input type="radio" value="{{route('admin-product-create',['id' => $is_blind])}}" class="select-form" name="select" id="option-2">

  @endif
 
  @if($type == 3)

    @if($is_floor)

      <label for="option-1" class="option option-1">
        <div class="dot"></div>
        <span>Vloeren</span>
      </label>

    @endif  

    @if($is_blind)

      <label for="option-2" class="option option-2">
        <div class="dot"></div>
        <span>Binnen zonwering</span>
      </label>

    @endif    

  @else

    <label for="option-1" class="option option-1">
      <div class="dot"></div>
      <span>Vloeren</span>
    </label>

    <label for="option-2" class="option option-2">
      <div class="dot"></div>
      <span>Binnen zonwering</span>
    </label>

  @endif
  
</div>

<style>

@import url('https://fonts.googleapis.com/css?family=Lato:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Lato', sans-serif;
}
html,body{
  display: grid;
  height: 100%;
  place-items: center;
  background: #0069d9;
  font-family: 'Lato', sans-serif;
}
.wrapper{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 500px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot{
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
  margin-left: 10px;
  margin-top: -1px;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span{
  color: #fff;
}

</style>

<script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>

<script>

    $('.select-form').click(function () {

        window.location.href = $(this).val();

    });

</script>
