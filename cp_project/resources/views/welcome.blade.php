@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form') }}</div>

                <div class="card-body">

                      @forelse($input_fields as $key => $val)
                      <label>{{$val->label}}</label>

                      @switch($val->type_id)
                        @case(1)
                            <input class="form-control" name="{{$val->label}}" autocomplete="off">
                            @break
                        @case(2)
                            <input class="form-control" type="number" name="{{$val->label}}" autocomplete="off">
                            @break
                        @case(3)
                            <select class="form-control" name="{{$val->label}}">
                              <?php
                              $options = [];
                              if(isset($options_array[$val->id])) {
                                  $options = $options_array[$val->id];
                              }
                              ?>
                              <option value="">Select</option>
                              @foreach($options as $key_o => $avl_o)
                                <option value="{{$avl_o}}">{{$avl_o}}</option>
                              @endforeach
                            </select>
                            @break
                    @endswitch
                      @empty
                      <p>Form has no contents</p>
                      @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
