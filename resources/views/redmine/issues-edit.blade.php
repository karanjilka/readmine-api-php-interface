@extends('redmine.layouts.default')

@section('content')

    {!! Laform::open(array('url'=>'redmine/issues-edit',
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
    {!! Laform::open(array('url'=>'redmine/issues-edit',
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
            <th>Priority</th>
            <th>Status</th>
            <th>Hours</th>
            <th>Start Date</th>
            <th>Due Date</th>
        </tr>
        <tr v-for="issue in issues">
            <td>
                <a style="color:#DD8100" href="{{config('project.url')}}/issues/@{{issue.id}}" target="_blank">
                    <strong>@{{issue.id}}</strong></a>
            </td>
            <td>
                 {!! Laform::field('parent_id','text',['template'=>'none',
                    'label'=>false,
                    'attr'=>['v-model'=>'issue.parent.id'],
                    'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.parent.id\']}'],
                    'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.parent.id\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td width="30%">
                {!! Laform::field('subject','textarea',['template'=>'none',
                'label'=>false,
                'attr'=>['rows'=>2,'v-model'=>'issue.subject'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.subject\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.subject\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td>
                <strong>@{{issue.project.name}}</strong>
            </td>
            <td>
                {!! Laform::field('assigned_to_id','select',['template'=>'none',
                'label'=>false,
                'options'=>[''=>'Assinged To']+$users,
                'attr'=>['v-select'=>'issue.assigned_to.id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.assigned_to.id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.assigned_to.id\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td>
                {!! Laform::field('tracker_id','select',['template'=>'none',
                'label'=>false,
                'options'=>$track,
                'attr'=>['v-select'=>'issue.tracker.id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.tracker.id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.tracker.id\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td>
                 {!! Laform::field('priority_id','select',['template'=>'none',
                'label'=>false,
                'options'=>$priority,
                'attr'=>['v-select'=>'issue.priority.id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.priority.id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.priority.id\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td>
                {!! Laform::field('status_id','select',['template'=>'none',
                'label'=>false,
                'options'=>$status,
                'attr'=>['v-select'=>'issue.status.id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.status.id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.status.id\']">@{{error}}</div>'
                ]) !!}
            </td>
            <td width="6%">
                {!! Laform::field('estimated_hours','text',['template'=>'none',
                'label'=>false,
                'attr'=>['v-model'=>'issue.estimated_hours'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.estimated_hours\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.estimated_hours\']">@{{error}}</div>'
                ]) !!}
                <template v-if="issue.spent_time">
                    <span class="label label-danger">@{{issue.spent_time}}</span>
                </template>
            </td>
            <td>
                {!! Laform::field('start_date','text',['template'=>'none',
                    'wrapper'=>false,
                    'label'=>false,
                    'attr'=>['v-datepicker'=>'issue.start_date',':dateformat'=>'"yy-mm-dd"'],
                    'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.start_date\']}'],
                    'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.start_date\']">@{{error}}</div>'
                ]) !!}
            </td>
             <td>
                {!! Laform::field('due_date','text',['template'=>'none',
                    'wrapper'=>false,
                    'label'=>false,
                    'attr'=>['v-datepicker'=>'issue.due_date',':dateformat'=>'"yy-mm-dd"'],
                    'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.due_date\']}'],
                    'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.due_date\']">@{{error}}</div>'
                ]) !!}
            </td>

        </tr>
    </table>
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
            this.$http.post('/redmine/issues-edit',{issues: self.issues}).then(function(response){
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