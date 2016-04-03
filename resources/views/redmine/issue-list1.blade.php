@extends('redmine.layouts.default')

@section('content')

    {!! Laform::open(array('url'=>'redmine/issues1',
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
            <th>Priority</th>
            <th>Status</th>
            <th>Date</th>
            <th>Hours</th>
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
            <td>
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
                <span v-if="issue.priority.id==1" class="label label-info">@{{issue.priority.name}}</span>
                <span v-if="issue.priority.id==2" class="label label-primary">@{{issue.priority.name}}</span>
                <span v-if="issue.priority.id==3" class="label label-warning">@{{issue.priority.name}}</span>
                <span v-if="issue.priority.id==4" class="label label-danger">@{{issue.priority.name}}</span>
                <span v-if="issue.priority.id==5" class="label label-danger">@{{issue.priority.name}}</span>
            </td>
            <td>
                <span v-if="issue.status.id==1" class="label label-primary">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==2" class="label label-info">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==3" class="label label-warning">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==4" class="label label-default">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==5" class="label label-success">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==6" class="label label-danger">@{{issue.status.name}}</span>
            </td>
            <td>
                <strong></strong> @{{issue.start_date}}
                <template v-if="issue.due_date">
                    <strong>To </strong> @{{issue.due_date}}
                </template>
            </td>
            <td>
                <div v-if="issue.estimated_hours">
                <span class="label label-warning">@{{issue.estimated_hours}}</span>
                <template v-if="issue.spent_time">
                <span class="label label-danger">@{{issue.spent_time}}</span>
                </template>
                </div>
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