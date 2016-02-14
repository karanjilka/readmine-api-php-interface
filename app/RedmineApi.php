<?php

namespace App;

use Cache;

class RedmineApi
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getProjects()
    {
        if (!Cache::has('projects')) {
            Cache::store('file')->forever('projects', $this->client->project->all());
        }

        $projects = Cache::store('file')->get('projects');

        return collect($projects['projects']);
    }

    public function getTrack()
    {
        if (!Cache::has('tracker')) {
            Cache::store('file')->forever('tracker', $this->client->tracker->all());
        }

        $data = Cache::store('file')->get('tracker');

        return collect($data['trackers']);
    }

    public function getQueries()
    {
        if (!Cache::has('query')) {
            Cache::store('file')->forever('query', $this->client->query->all());
        }

        $data = Cache::store('file')->get('query');

        return collect($data['queries']);
    }

    public function getPriority()
    {
        if (!Cache::has('issue_priority')) {
            Cache::store('file')->forever('issue_priority', $this->client->issue_priority->all());
        }

        $data = Cache::store('file')->get('issue_priority');

        return collect($data['issue_priorities']);
    }

    public function getStatus()
    {
        if (!Cache::has('issue_status')) {
            Cache::store('file')->forever('issue_status', $this->client->issue_status->all());
        }

        $data = Cache::store('file')->get('issue_status');

        return collect($data['issue_statuses']);
    }

    public function getCurrentUser()
    {
        if (!Cache::has('currentuser')) {
            Cache::store('file')->forever('currentuser', $this->client->user->getCurrentUser());
        }

        $currentuser = Cache::store('file')->get('currentuser');
        return $currentuser['user'];
    }

    public function getUsers()
    {
        if (!Cache::has('users')) {
            Cache::store('file')->forever('users', $this->client->user->all());
        }

        $users = Cache::store('file')->get('users');

        if(!empty($users['users'])){
            return collect($users['users']);
        }else{
            $user = $this->getCurrentUser();
            return collect([$user]);
        }
    }

    public function getActivity()
    {
        if (!Cache::has('time_entry_activity')) {
            Cache::store('file')->forever('time_entry_activity', $this->client->time_entry_activity->all());
        }

        $data = Cache::store('file')->get('time_entry_activity');

        return collect($data['time_entry_activities']);
    }

    public function setAllCache()
    {
        Cache::flush();
        Cache::store('file')->forever('projects', $this->client->project->all());
        Cache::store('file')->forever('time_entry_activity', $this->client->time_entry_activity->all());
        Cache::store('file')->forever('query', $this->client->query->all());
    }
}
