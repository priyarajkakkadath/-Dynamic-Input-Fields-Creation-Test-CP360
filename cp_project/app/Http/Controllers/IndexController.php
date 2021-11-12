<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HTMLFields;
use App\Models\FormInputFields;
use App\Models\DynamicOptions;
use Illuminate\Support\Facades\Validator;
use Redirect;

class IndexController extends Controller
{

    public function index()
    {

      $html_table = (new HTMLFields())->getTable();
      $option_table = (new DynamicOptions())->getTable();
      $form_input_table = (new FormInputFields())->getTable();

      $input_fields = FormInputFields::select($html_table.'.type',$form_input_table.'.type_id',$form_input_table.'.label',$form_input_table.'.id')
                          ->join($html_table,$html_table.'.id', $form_input_table.'.type_id')
                          ->orderBy($form_input_table.'.id', 'ASC')
                          ->get();

      $options = DynamicOptions::select('input_id','label')
                          ->get();

      $options_array = [];

      foreach($options as $key => $val) {

        $options_array[$val->input_id][] = $val->label;

      }

      return view('welcome', compact('options_array','input_fields'));
    }
}
