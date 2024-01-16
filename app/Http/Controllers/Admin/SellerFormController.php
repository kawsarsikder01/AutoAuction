<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerForm;
use Illuminate\Support\Facades\Validator;

class SellerFormController extends Controller
{
    public function index()
    {
        $data['formList'] = SellerForm::get();
        return view('admin.seller_forms.list',$data);
    }
    public function create()
    {
        return view('admin.seller_forms.create');
    }
    public function store(Request $request)
    {  
        // dd($request->all());
        $requestData = $request->all();
        $rules = [
            'name' => 'required|string',
            'field_name.*' => 'required|string',
            'input_type.*' => 'required|in:text,textarea,file,date,number,radio,radio_label',
            'is_required.*' => 'required|in:required,optional',
        ];

        $customMessages = [
            'field_name.*.required' => 'The form  field name is required.',
            'input_type.*.required' => 'The input type field is required.',
            'is_required.*.required' => 'The required field is required.',
            'input_type.*.in' => 'The Input type is invalid.',
            'is_required.*.in' => 'The required value is invalid.',
        ];

        $validator = Validator::make($requestData, $rules, $customMessages);
        if ($validator->fails()) {
           
            return redirect()->back()->withErrors($validator)->withInput();
        }
       $inputForm = array();
        try {
            $length = count($request->field_name);
            if($request->has('field_name')){
                for($i = 0; $i < $length; ++$i){
                    $arr = array();
                    $arr['field_name'] = clean($request->field_name[$i]);
                    $arr['field_label'] = ucwords($request->field_label[$i]);
                    $arr['type'] = $request->input_type[$i];
                    $arr['validation'] = $request->is_required[$i];
                    $inputForm[$i] = $arr;
                }
            }
            $form = new SellerForm ();
            $form->name = $request->name;
            $form->slug = slug($request->name);
            $form->input_form = $inputForm ?? '';
            $form->status = $request->status;
            $form->save();
            if (!$form) {
                throw new Exception('Something went wrong');
            }
        } catch(Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
       

        return back()->with('success', 'form create successfully');

    }
    public function edit($id)
    {
        try {
            $data['form'] = SellerForm::where('id', $id)->firstOr(function () {
                throw new Exception('No form found.');
            });
            return view("admin.seller_forms.edit",$data);

        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
    public function update(Request $request,$id)
    {
        // dd($request->all());
        $requestData = $request->all();
        $rules = [
            'name' => 'required|string',
            'field_name.*' => 'required|string',
            'field_label.*' => 'required|string',
            'input_type.*' => 'required|in:text,textarea,file,date,number,radio,radio_label',
            'is_required.*' => 'required|in:required,optional',
        ];

        $customMessages = [
            'field_name.*.required' => 'The form label field is required.',
            'field_label.*.required' => 'The form label field is required.',
            'input_type.*.required' => 'The input type field is required.',
            'is_required.*.required' => 'The required field is required.',
            'input_type.*.in' => 'The Input type is invalid.',
            'is_required.*.in' => 'The required value is invalid.',
        ];
        
        $validator = Validator::make($requestData, $rules, $customMessages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
      $inputForm = array();
        try {
           $length = count($request->field_name);
           for($i = 0; $i < $length ; ++$i){
            $arr = array();
            $arr['field_name'] = spaceClear($request->field_name[$i]);
            $arr['field_label'] =ucwords($request->field_label[$i]);
            $arr['type'] = $request->input_type[$i];
            $arr['validation'] = $request->is_required[$i];
            $inputForm[$i] = $arr;
           }
           $form = SellerForm::findOrFail($id);
           $form->name = $request->name;
           $form->slug = slug($request->name);
           $form->input_form =(object) $inputForm;
           $form->status = $request->status;
           $form->update();
           if(!$form){
            throw new Exception('Something went wrong');
           }

        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
        return back()->with('success', 'form update successfully');

    }
}
