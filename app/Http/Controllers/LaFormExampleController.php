<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaFormExampleController extends Controller
{
    protected $rules;
    protected $messages;
    protected $client;
    protected $redmine;
    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->rules = [
            'name.0'=>'required',
            'name.1'=>'required',
            'role_id'=>'required',
            'email'=>'required'
        ];
        $this->messages = [

        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laform-example');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if ($request->input('issues')) {
        //     $issues = $request->input('issues');
        //     foreach ($issues as $key => $issue) {
        //         $this->rules['issues.'.$key.'.subject'] = 'required|max:255';
        //         $this->rules['issues.'.$key.'.description'] = 'required';
        //         $this->rules['issues.'.$key.'.project_id'] = 'required|integer';
        //         $this->rules['issues.'.$key.'.estimated_hours'] = 'numeric';
        //         $this->rules['issues.'.$key.'.parent_issue_id'] = 'integer';
        //
        //         $this->messages['issues.'.$key.'.subject.required'] = 'This field is required';
        //         $this->messages['issues.'.$key.'.description.required'] = 'This field is required';
        //         $this->messages['issues.'.$key.'.project_id.required'] = 'This field is required';
        //
        //         $this->messages['issues.'.$key.'.project_id.integer'] = 'This feild must be number';
        //         $this->messages['issues.'.$key.'.parent_issue_id.integer'] = 'This feild must be number';
        //         $this->messages['issues.'.$key.'.estimated_hours.numeric'] = 'This feild must be numeric';
        //     }
        // }

        $this->validate($request, $this->rules, $this->messages);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
