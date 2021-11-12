@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form Customization') }}</div>

                <div class="card-body">
                    @if (session('alert-message'))
                        <?php $alert = Session::get('alert-message'); ?>
                        <div class="alert {{ $alert['class'] }}" role="alert">
                            <strong>{{ $alert['type'] }}: </strong>{{ $alert['text'] }}
                        </div>
                    @endif


                    <form method="post" action="{{route('add_field')}}">
                      @csrf


                      <label>Label</label>
                      <input class="form-control" name="label" value="{{old('label')}}" autocomplete="off">
                      <p class="text-danger">{{$errors->first('label');}}</p>

                      <label>Type</label>
                      <select class="form-control" id="type" name="type" onchange="type_changed()">
                        <option value="">Select</option>
                        @foreach($html_fields as $key => $val)
                        <?php
                        $selected = '';
                        if($val->id == old('type')) {
                          $selected = 'selected';
                        }
                         ?>
                          <option value2="{{$val->multiple_options}}" {{$selected}} value="{{$val->id}}">{{$val->type}}</option>
                        @endforeach
                      </select>
                      <p class="text-danger">{{$errors->first('type');}}</p>
                      <input id="number_of_options" type="hidden" name="number_of_options">

                      <div id="multiple_options_div">
                        <?php for($i=1; $i<=old('number_of_options'); $i++) { $j = $i-1;  if($i == 1) { ?>

                          <div class="input-group mb-3"><input type="text" name="options[]" value="{{ old('options.'.$j) }}" class="form-control m-input" autocomplete="off"><div class="input-group-append"><button onclick="addOption()" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add">+</button></div></div>
                        <?php } else { ?>
                          <div class="input-group mb-3"><input type="text" name="options[]" value="{{ old('options.'.$j) }}" class="form-control m-input" autocomplete="off"><div class="input-group-append"><button id="removeOption" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remove">-</button></div></div>
                        <?php } ?>
                        <p class="text-danger">{{$errors->first('options.'.$j);}}</p>
                        <?php } ?>
                      </div>

                      <input type="submit" valuie="Add">
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Input fields') }}</div>

                <div class="card-body">
                    @if (session('alert-message2'))
                        <?php $alert = Session::get('alert-message2'); ?>
                        <div class="alert {{ $alert['class'] }}" role="alert">
                            <strong>{{ $alert['type'] }}: </strong>{{ $alert['text'] }}
                        </div>
                    @endif

                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Label</th>
                          <th scope="col">Type</th>
                          <th scope="col">Options</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          @forelse($input_fields as $key => $val)
                          <td scope="row">{{$key+1}}</td>
                          <td>{{$val->label}}</td>
                          <td>{{$val->type}}</td>
                          <?php
                          $options = [];
                          if(isset($options_array[$val->id])) {
                              $options = $options_array[$val->id];
                          }
                          ?>
                          <td>
                            <ul>
                            @foreach($options as $key_o => $avl_o)
                              <li>{{$avl_o}}</li>
                            @endforeach
                            </ul>
                          </td>
                          <td><a href="{{url('delete_field', $val->id)}}" onclick="return confirm('Delete selected item? Are you sure?')"><button type="button" class="btn btn-danger">Delete</button></a></td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4">No input fields added</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>

                </div>
            </div>


        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>

$(document).ready(function() {
    $('#number_of_options').val({{old('number_of_options',0)}});
    var number_of_options = '{{old('number_of_options')}}';
    if(number_of_options > 0) {
      $("#multiple_options_div").show();
    }

});

function type_changed() {

  var type = $('#type').val();

  var sel = document.getElementById('type');
  var selected = sel.options[sel.selectedIndex];
  var is_options = selected.getAttribute('value2');
  $("#multiple_options_div").hide();
  $('#multiple_options_div').html("");



  if(is_options == 1) {
    $('#number_of_options').val(1);
    $("#multiple_options_div").show();
    var html = '<div class="input-group mb-3"><input type="text" name="options[]" class="form-control m-input" autocomplete="off">';
    html += '<div class="input-group-append"><button onclick="addOption()" type="button" class="btn btn-success"  data-toggle="tooltip" data-placement="top" title="Add">+</button></div></div>';
    $('#multiple_options_div').append(html);
  }

}

function addOption() {

  var number_of_options = $('#number_of_options').val();
  number_of_options++;
  $('#number_of_options').val(number_of_options);
  var html = '<div class="input-group mb-3"><input id="inputFormRow" type="text" name="options[]" class="form-control m-input" autocomplete="off">';
  html += '<div class="input-group-append"><button id="removeOption" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remove">-</button></div></div>';
  $('#multiple_options_div').append(html);
}

$(document).on('click', '#removeOption', function () {
  var number_of_options = $('#number_of_options').val();
  number_of_options--;
  $('#number_of_options').val(number_of_options);
    $(this).parent('div').parent('div').remove();
});

</script>
