<?php

namespace App\Http\Controllers\Redmineapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RedmineApi;
use Illuminate\Pagination\LengthAwarePaginator;

class RedmineIssueController extends Controller
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
    public function index(Request $request)
    {
        $projects = $this->redmine->getProjects()->lists('name', 'id')->toArray();
        $users = $this->redmine->getUsers()->lists('mail', 'id')->toArray();
        $track = $this->redmine->getTrack()->lists('name', 'id')->toArray();
        $status = $this->redmine->getStatus()->lists('name', 'id')->toArray();
        $queries = $this->redmine->getQueries()->lists('name', 'id')->toArray();
        $activity = $this->redmine->getActivity()->lists('name', 'id')->toArray();
        $per_pages = ['25' => '25', '50' => '50', '100' => '100', '200' => '200', '300' => '300'];

        $offset = (($request->input('page', 1) - 1) * $request->input('per_page', 25));
        $parmas['offset'] = $offset;
        $parmas['limit'] = $request->input('per_page', 25);
        if ($request->input('project_id')) {
            $parmas['project_id'] = $request->input('project_id');
        }
        if ($request->input('assigned_to_id')) {
            $parmas['assigned_to_id'] = $request->input('assigned_to_id');
        }
        if ($request->input('status_id')) {
            $parmas['status_id'] = $request->input('status_id');
        }
        if ($request->input('tracker_id')) {
            $parmas['tracker_id'] = $request->input('tracker_id');
        }
        if ($request->input('query_id')) {
            $parmas['query_id'] = $request->input('query_id');
        }
        $issues = $this->client->issue->all($parmas);
        if ($request->input('with_spent_hours')) {
            foreach($issues['issues'] as $key => $issue){
                $issues['issues'][$key]['timeentries'] = $this->client->time_entry->all(['limit'=>50,'issue_id'=>$issue['id']]);
                $issues['issues'][$key]['spent_time'] = 0;
                if(!empty($issues['issues'][$key]['timeentries']['time_entries'])){
                    foreach($issues['issues'][$key]['timeentries']['time_entries'] as $entry_key => $time_entry){
                        $issues['issues'][$key]['spent_time']=$issues['issues'][$key]['spent_time']+$time_entry['hours'];
                    }
                }
            }
        }

        $pagination = new LengthAwarePaginator($issues['issues'], $issues['total_count'], $parmas['limit'], $request->input('page'));
        $pagination->setPath('/redmine/issue');
        $paglinks = $pagination->appends($request->except(['page']))->render();

        return view('redmine.issue-list',
        compact('issues', 'users', 'paglinks', 'projects', 'users', 'track', 'per_pages', 'status', 'queries', 'activity'));
    }

    public function issueList1(Request $request)
    {
        $projects = $this->redmine->getProjects()->lists('name', 'id')->toArray();
        $users = $this->redmine->getUsers()->lists('mail', 'id')->toArray();
        $track = $this->redmine->getTrack()->lists('name', 'id')->toArray();
        $status = $this->redmine->getStatus()->lists('name', 'id')->toArray();
        $queries = $this->redmine->getQueries()->lists('name', 'id')->toArray();
        $activity = $this->redmine->getActivity()->lists('name', 'id')->toArray();
        $per_pages = ['25' => '25', '50' => '50', '100' => '100', '200' => '200', '300' => '300'];

        $offset = (($request->input('page', 1) - 1) * $request->input('per_page', 25));
        $parmas['offset'] = $offset;
        $parmas['limit'] = $request->input('per_page', 25);
        if ($request->input('project_id')) {
            $parmas['project_id'] = $request->input('project_id');
        }
        if ($request->input('assigned_to_id')) {
            $parmas['assigned_to_id'] = $request->input('assigned_to_id');
        }
        if ($request->input('status_id')) {
            $parmas['status_id'] = $request->input('status_id');
        }
        if ($request->input('tracker_id')) {
            $parmas['tracker_id'] = $request->input('tracker_id');
        }
        if ($request->input('query_id')) {
            $parmas['query_id'] = $request->input('query_id');
        }

        $issues = $this->client->issue->all($parmas);
        if ($request->input('with_spent_hours')) {
            foreach($issues['issues'] as $key => $issue){
                $issues['issues'][$key]['timeentries'] = $this->client->time_entry->all(['limit'=>50,'issue_id'=>$issue['id']]);
                $issues['issues'][$key]['spent_time'] = 0;
                if(!empty($issues['issues'][$key]['timeentries']['time_entries'])){
                    foreach($issues['issues'][$key]['timeentries']['time_entries'] as $entry_key => $time_entry){
                        $issues['issues'][$key]['spent_time']=$issues['issues'][$key]['spent_time']+$time_entry['hours'];
                    }
                }
            }
        }

        $pagination = new LengthAwarePaginator($issues['issues'], $issues['total_count'], $parmas['limit'], $request->input('page'));
        $pagination->setPath('/redmine/issues1');
        $paglinks = $pagination->appends($request->except(['page']))->render();

        return view('redmine.issue-list1',
        compact('issues', 'users', 'paglinks', 'projects', 'users', 'track', 'per_pages', 'status', 'queries', 'activity'));
    }

    public function issueEdit(Request $request)
    {
        $projects = $this->redmine->getProjects()->lists('name', 'id')->toArray();
        $users = $this->redmine->getUsers()->lists('mail', 'id')->toArray();
        $track = $this->redmine->getTrack()->lists('name', 'id')->toArray();
        $status = $this->redmine->getStatus()->lists('name', 'id')->toArray();
        $queries = $this->redmine->getQueries()->lists('name', 'id')->toArray();
        $activity = $this->redmine->getActivity()->lists('name', 'id')->toArray();
        $priority = $this->redmine->getPriority()->lists('name', 'id')->toArray();

        $per_pages = ['25' => '25', '50' => '50', '100' => '100', '200' => '200', '300' => '300'];

        $offset = (($request->input('page', 1) - 1) * $request->input('per_page', 25));
        $parmas['offset'] = $offset;
        $parmas['limit'] = $request->input('per_page', 25);
        if ($request->input('project_id')) {
            $parmas['project_id'] = $request->input('project_id');
        }
        if ($request->input('assigned_to_id')) {
            $parmas['assigned_to_id'] = $request->input('assigned_to_id');
        }
        if ($request->input('status_id')) {
            $parmas['status_id'] = $request->input('status_id');
        }
        if ($request->input('tracker_id')) {
            $parmas['tracker_id'] = $request->input('tracker_id');
        }
        if ($request->input('query_id')) {
            $parmas['query_id'] = $request->input('query_id');
        }

        $issues = $this->client->issue->all($parmas);
        if ($request->input('with_spent_hours')) {
            foreach($issues['issues'] as $key => $issue){
                $issues['issues'][$key]['timeentries'] = $this->client->time_entry->all(['limit'=>50,'issue_id'=>$issue['id']]);
                $issues['issues'][$key]['spent_time'] = 0;
                if(!empty($issues['issues'][$key]['timeentries']['time_entries'])){
                    foreach($issues['issues'][$key]['timeentries']['time_entries'] as $entry_key => $time_entry){
                        $issues['issues'][$key]['spent_time']=$issues['issues'][$key]['spent_time']+$time_entry['hours'];
                    }
                }
            }
        }

        $pagination = new LengthAwarePaginator($issues['issues'], $issues['total_count'], $parmas['limit'], $request->input('page'));
        $pagination->setPath('/redmine/issues-edit');
        $paglinks = $pagination->appends($request->except(['page']))->render();

        return view('redmine.issues-edit',
        compact('issues', 'users', 'paglinks', 'projects', 'users', 'track', 'per_pages', 'status', 'queries', 'activity','priority'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = $this->redmine->getProjects()->lists('name', 'id')->toArray();
        $users = $this->redmine->getUsers()->lists('mail', 'id')->toArray();
        $track = $this->redmine->getTrack()->lists('name', 'id')->toArray();

        return view('redmine.create-issue', compact('projects', 'users', 'track'));
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
                $this->rules['issues.'.$key.'.subject'] = 'required|max:255';
                $this->rules['issues.'.$key.'.description'] = 'required';
                $this->rules['issues.'.$key.'.project_id'] = 'required|integer';
                $this->rules['issues.'.$key.'.estimated_hours'] = 'numeric';
                $this->rules['issues.'.$key.'.parent_issue_id'] = 'integer';

                $this->messages['issues.'.$key.'.subject.required'] = 'This field is required';
                $this->messages['issues.'.$key.'.description.required'] = 'This field is required';
                $this->messages['issues.'.$key.'.project_id.required'] = 'This field is required';

                $this->messages['issues.'.$key.'.project_id.integer'] = 'This feild must be number';
                $this->messages['issues.'.$key.'.parent_issue_id.integer'] = 'This feild must be number';
                $this->messages['issues.'.$key.'.estimated_hours.numeric'] = 'This feild must be numeric';
            }
        }

        $this->validate($request, $this->rules, $this->messages);

        if ($request->input('issues')) {
            $issues = $request->input('issues');
            foreach ($issues as $key => $issue) {
                $this->client->issue->create([
                    'project_id' => $issue['project_id'],
                    'subject' => $issue['subject'],
                    'description' => $issue['description'],
                    'assigned_to_id' => $issue['assigned_to_id'],
                    'parent_issue_id' => $issue['parent_issue_id'],
                    'start_date' => $issue['start_date'],
                    'due_date' => $issue['due_date'],
                    'estimated_hours' => $issue['estimated_hours'],
                    'tracker_id' => $issue['tracker_id'],
                ]);
            }
        }
    }

    public function postTimeLog(Request $request)
    {
        if ($request->input('issues')) {
            $issues = $request->input('issues');
            foreach ($issues as $key => $issue) {
                if (!empty($issue['hours'])) {
                    $this->rules['issues.'.$key.'.comments'] = 'required|max:255';
                    $this->rules['issues.'.$key.'.activity_id'] = 'required';
                    $this->rules['issues.'.$key.'.spent_on'] = 'required';
                    $this->rules['issues.'.$key.'.hours'] = 'required|numeric';

                    $this->messages['issues.'.$key.'.comments.required'] = 'This field is required';
                    $this->messages['issues.'.$key.'.activity_id.required'] = 'This field is required';
                    $this->messages['issues.'.$key.'.spent_on.required'] = 'This field is required';
                    $this->messages['issues.'.$key.'.hours.required'] = 'This field is required';

                    $this->messages['issues.'.$key.'.hours.numeric'] = 'This feild must be numeric';
                }
            }
        }

        $this->validate($request, $this->rules, $this->messages);

        if ($request->input('issues')) {
            $issues = $request->input('issues');
            foreach ($issues as $key => $issue) {
                if (!empty($issue['hours'])) {
                    $this->client->time_entry->create([
                        'issue_id' => $issue['id'],
                        'spent_on' => $issue['spent_on'],
                        'hours' => $issue['hours'],
                        'activity_id' => $issue['activity_id'],
                        'comments' => $issue['comments'],
                    ]);
                }
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

    public function clearCache()
    {
        $this->redmine->setAllCache();

        return view('redmine.clear-cache');
    }
}
