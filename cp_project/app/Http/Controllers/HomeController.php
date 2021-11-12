<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HTMLFields;
use App\Models\FormInputFields;
use App\Models\DynamicOptions;
use Illuminate\Support\Facades\Validator;
use Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $html_fields = HTMLFields::get();

        $html_table = (new HTMLFields())->getTable();
        $option_table = (new DynamicOptions())->getTable();
        $form_input_table = (new FormInputFields())->getTable();

        $input_fields = FormInputFields::select($html_table.'.type',$form_input_table.'.label',$form_input_table.'.id')
                            ->join($html_table,$html_table.'.id', $form_input_table.'.type_id')
                            ->orderBy($form_input_table.'.id', 'DESC')
                            ->get();

        $options = DynamicOptions::select('input_id','label')
                            ->get();

        $options_array = [];

        foreach($options as $key => $val) {

          $options_array[$val->input_id][] = $val->label;

        }

        return view('home', compact('html_fields','options_array','input_fields'));
    }

    public function add_field(Request $request) {

      $rules = [
        'label' => 'required|string|max:20|min:3',
         'type' => 'required|integer',
         'options.*' => 'nullable|string|max:20|min:1|distinct',
       ];

       $messages = [
         'label.required' => 'Required',
         'label.string' => 'Required',
         'label.max' => "Length shouldn't exceed 20",
         'label.min' => "Length shouldn't minimum 3",
         'type.required' => 'Required',
         'type.integer' => 'Invalid option selected',
         'options.*.max' => "Length shouldn't exceed 20",
         'options.*.min' => "Length shouldn't minimum 3",
         'options.*.distinct' => "Same options not allowed",
        ];
        $request->flash();
        $this->validate($request, $rules, $messages);

        $label = $request->label;
        $type = $request->type;

        $html_fields = HTMLFields::where('id',$type)->first();


        $input_fields = FormInputFields::where('label',$label)->where('type_id',$type)->first();

        if($input_fields) {
          $message = array('type' => 'Error', 'class' => 'alert-danger',
           'text' => 'Same input field already inserted!' );
          $request->session()->flash('alert-message', $message);
          return redirect(route('home'));
        }

        if(!$html_fields) {

          $message = array('type' => 'Error', 'class' => 'alert-danger',
           'text' => 'Invalid type!' );
          $request->session()->flash('alert-message', $message);
          return redirect(route('home'));

        }

        $options = [];

        if($html_fields->multiple_options == 1) {
          $options = $request->options;

          $options = array_filter($options);

          if(count($options) <=0 ) {
            $message = array('type' => 'Error', 'class' => 'alert-danger',
             'text' => 'Please add options' );
            $request->session()->flash('alert-message', $message);
            return redirect(route('home'));
          }
        }

        $new_form_input = new FormInputFields();
        $new_form_input->label = $label;
        $new_form_input->type_id = $type;
        $new_form_input->created_at = now();
        $new_form_input->updated_at = now();
        $new_form_input->save();


        $options_array = [];
        foreach($options as $key => $val) {
          $options_array[] = array('input_id' => $new_form_input->id, 'label' => $val);
        }

        DynamicOptions::insert($options_array);

        $message = array('type' => 'Success', 'class' => 'alert-success',
         'text' => 'New form input field successfully created.' );
        $request->session()->flash('alert-message', $message);

        return redirect()->to(route('home'));
    }

    public function delete_field(Request $request,$id) {

      $input_fields = FormInputFields::where('id',$id)->first();

      if(!$input_fields) {
        $message = array('type' => 'Error', 'class' => 'alert-danger',
         'text' => 'Invalid input field!' );
        $request->session()->flash('alert-message2', $message);
        return redirect(route('home'));
      }

      FormInputFields::where('id',$id)->delete();

      $message = array('type' => 'Success', 'class' => 'alert-success',
       'text' => 'successfully Deleted.' );
      $request->session()->flash('alert-message2', $message);
      return redirect(route('home'));

    }
}
