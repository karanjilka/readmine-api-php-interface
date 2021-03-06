@extends('redmine.layouts.default')

@section('content')

    {!! Laform::open(array('url'=>'redmine/issue',
    'class'=>'form-verticle',
    'method'=>'GET'
    )) !!}

    <div class="row">
        <div class="col-md-3">
        {!! Laform::field('assigned_to_id','select',[
            'label'=>'Assinged To',
            'template'=>false,
            'options'=>[''=>'Select User']+$users,
            'value'=>Request::input('assigned_to_id',null),
            'attr'=>['class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('project_id','select',[
            'label'=>'Project',
            'template'=>false,
            'options'=>[''=>'Select Project']+$projects,
            'value'=>Request::input('project_id',null),
            'attr'=>['class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('status_id','select',[
            'label'=>'Status',
            'template'=>false,
            'options'=>[''=>'Status']+$status,
            'value'=>Request::input('status_id',null),
            'attr'=>['class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('tracker_id','select',[
            'label'=>'Track Id',
            'template'=>false,
            'options'=>[''=>'Select Track']+$track,
            'value'=>Request::input('tracker_id',null),
            'attr'=>['class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('query_id','select',[
            'label'=>'Query',
            'template'=>false,
            'options'=>[''=>'Select Query']+$queries,
            'value'=>Request::input('query_id',null),
            'attr'=>['class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('per_page','select',[
            'label'=>'Per Page',
            'template'=>false,
            'options'=>$per_pages,
            'value'=>Request::input('per_page',null),
            'attr'=>['class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('with_spent_hours','checkbox',[
            'label'=>'With Spent Hours',
            'template'=>'verticle',
            'option'=>'1',
            'value'=>Request::input('with_spent_hours',null),
            'attr'=>['class'=>'select-two']
        ]) !!}
        </div>
        <button class="btn btn-primary btn-lg">Search</button>
    </div>
    {!! Laform::close() !!}

<div id="app">
    {!! Laform::open(array('url'=>'redmine/issue/timelog',
    '@submit.prevent'=>'onSave'
    )) !!}
    <br>
    <div class="form-group clearfix">
    <div class="pull-right">
        <button class="btn btn-primary btn-lg"> Save </button>
    </div>
    </div>

    <table class="table">
        <tr>
            <th>Id</th>
            <th>Parent</th>
            <th>Title</th>
            <th>Project</th>
            <th>To</th>
            <th>Type</th>
            <th>Hours</th>
            <th>Comment</th>
            <th>Activity</th>
            <th>Date</th>
            <th>Hour</th>
        </tr>
        <tr v-for="issue in issues">
            <td>
                <a style="color:#DD8100" href="{{config('project.url')}}/issues/@{{issue.id}}" target="_blank">
                <strong>@{{issue.id}}</strong></a>
            </td>
            <td>
                <template v-if="issue.parent">
                    @{{issue.parent.id}}
                 </template>
            </td>
            <td width="30%">
                <strong>@{{issue.subject}}</strong>
            </td>
            <td>
                <strong>@{{issue.project.name}}</strong>
            </td>
            <td>
                <i v-if="issue.assigned_to">@{{issue.assigned_to.name}}</i>
            </td>
            <td>
                <span v-if="issue.tracker.id==1" class="label label-danger">@{{issue.tracker.name}}</span>
                <span v-if="issue.tracker.id==2" class="label label-primary">@{{issue.tracker.name}}</span>
                <span v-if="issue.tracker.id==3" class="label label-warning">@{{issue.tracker.name}}</span>
                <span v-if="issue.tracker.id==5" class="label label-info">@{{issue.tracker.name}}</span>
            </td>
            <td>
                <div v-if="issue.estimated_hours">
                <span class="label label-warning">@{{issue.estimated_hours}}</span>
                <template v-if="issue.spent_time">
                <span class="label label-danger">@{{issue.spent_time}}</span>
                </template>
                </div>
            </td>
            <td width="20%">
                {!! Laform::field('comments','text',['template'=>'none',
                'attr'=>['v-model'=>'issue.comments','placeholder'=>'Comment','class'=>'input-sm'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.comments\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.comments\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td>
                 {!! Laform::field('activity_id','select',['template'=>'none',
                'options'=>[''=>'Select Activity']+$activity,
                'attr'=>['v-select'=>'issue.activity_id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.activity_id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.activity_id\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td width="8%">
                 {!! Laform::field('spent_on','text',['template'=>'none',
                'attr'=>['v-datepicker'=>'issue.spent_on',':dateformat'=>'"yy-mm-dd"','placeholder'=>'Date','class'=>'input-sm'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.spent_on\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.spent_on\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td width="5%">
                {!! Laform::field('hours','text',['template'=>'none',
                'attr'=>['v-model'=>'issue.hours','placeholder'=>'Hour','class'=>'input-sm'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.hours\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.hours\']">@{{error}}</div>'
                ]) !!}
            </td>
        </tr>
    </table>
    <hr>

    <div class="form-group clearfix">
    <div class="pull-right">
        <button class="btn btn-primary btn-lg"> Save </button>
    </div>
    </div>

    {!! Laform::close() !!}
    {!! $paglinks !!}
</div>
@stop

@section('script')
<script type="text/javascript">
new Vue({
    el:'#app',
    data:{
        issues:{!! json_encode($issues['issues']) !!},
        timeentries:[],
        errors:[],
        current_url:'{!! Request::url() !!}?{!! $_SERVER['QUERY_STRING'] !!}'
    },
    methods:{
        onSave : function(){
            var self = this;
            $('.ajax-loader').show();
            this.$http.post('/redmine/issue/timelog',{issues: self.issues}).then(function(response){
                window.location = self.current_url;
                $('.ajax-loader').hide();
            },function(response){
                $('.ajax-loader').hide();
                this.errors = response.data;
            });
        },
    }
});
</script>
@stop
