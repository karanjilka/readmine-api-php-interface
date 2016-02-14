<?php

namespace App\Http\Controllers\Redmineapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RedmineApi;

class RedmineTimeEntry extends Controller
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

        ];
        $this->messages = [

        ];
        $this->client = new \Redmine\Client(config('project.url'), config('project.username'), config('project.password'));
        $this->redmine = new RedmineApi($this->client);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = $this->redmine->getProjects()->lists('name', 'id')->toArray();
        $users = $this->redmine->getUsers()->lists('name', 'id')->toArray();
        $activity = $this->redmine->getActivity()->lists('name', 'id')->toArray();
        return view('redmine.create-time-entry', compact('projects', 'users','activity'));
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
        if ($request->input('issues')) {
            $issues = $request->input('issues');
            foreach ($issues as $key => $issue) {
                $this->rules['issues.'.$key.'.spent_on'] = 'required';
                $this->rules['issues.'.$key.'.activity_id'] = 'required';
                $this->rules['issues.'.$key.'.comments'] = 'required|max:255';
                $this->rules['issues.'.$key.'.project_id'] = 'required';
                $this->rules['issues.'.$key.'.hours'] = 'required|numeric';

                $this->messages['issues.'.$key.'.spent_on.required'] = 'This field is required';
                $this->messages['issues.'.$key.'.activity_id.required'] = 'This field is required';
                $this->messages['issues.'.$key.'.comments.required'] = 'This field is required';
                $this->messages['issues.'.$key.'.project_id.required'] = 'This field is required';
                $this->messages['issues.'.$key.'.hours.required'] = 'This field is required';

                $this->messages['issues.'.$key.'.hours.numeric'] = 'This feild must be numeric';
            }
        }

        $this->validate($request, $this->rules, $this->messages);

        if ($request->input('issues')) {
            $issues = $request->input('issues');
            foreach ($issues as $key => $issue) {
                $this->client->time_entry->create([
                    'project_id' => $issue['project_id'],
                    'spent_on' => $issue['spent_on'],
                    'hours' => $issue['hours'],
                    'activity_id' => $issue['activity_id'],
                    'comments' => $issue['comments'],
                ]);
            }
        }
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
