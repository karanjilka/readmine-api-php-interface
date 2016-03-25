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
            'attr'=>['onchange'=>'this.form.submit()','class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('project_id','select',[
            'label'=>'Project',
            'template'=>false,
            'options'=>[''=>'Select Project']+$projects,
            'value'=>Request::input('project_id',null),
            'attr'=>['onchange'=>'this.form.submit()','class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('status_id','select',[
            'label'=>'Status',
            'template'=>false,
            'options'=>[''=>'Status']+$status,
            'value'=>Request::input('status_id',null),
            'attr'=>['onchange'=>'this.form.submit()','class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('tracker_id','select',[
            'label'=>'Track Id',
            'template'=>false,
            'options'=>[''=>'Select Track']+$track,
            'value'=>Request::input('tracker_id',null),
            'attr'=>['onchange'=>'this.form.submit()','class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('query_id','select',[
            'label'=>'Query',
            'template'=>false,
            'options'=>[''=>'Select Query']+$queries,
            'value'=>Request::input('query_id',null),
            'attr'=>['onchange'=>'this.form.submit()','class'=>'select-two']
        ]) !!}
        </div>
        <div class="col-md-3">
        {!! Laform::field('per_page','select',[
            'label'=>'Per Page',
            'template'=>false,
            'options'=>$per_pages,
            'value'=>Request::input('per_page',null),
            'attr'=>['onchange'=>'this.form.submit()','class'=>'select-two']
        ]) !!}
        </div>
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

    <div v-for="issue in issues">
        <div class="row">
            <div class="col-md-1" style="width:8%">
                <div>
                    <a style="color:#DD8100" href="{{config('project.url')}}/issues/@{{issue.id}}" target="_blank">
                    <strong>#@{{issue.id}}</strong></a>
                </div>
            </div>
            <div class="col-md-1" style="width:7%">
                <div>
                    <span v-if="issue.tracker.id==1" class="label label-danger">@{{issue.tracker.name}}</span>
                    <span v-if="issue.tracker.id==2" class="label label-primary">@{{issue.tracker.name}}</span>
                    <span v-if="issue.tracker.id==3" class="label label-warning">@{{issue.tracker.name}}</span>
                    <span v-if="issue.tracker.id==5" class="label label-info">@{{issue.tracker.name}}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div><strong>
                    <template v-if="issue.parent">
                    (#@{{issue.parent.id}})
                    </template>
                    @{{issue.subject}}</strong></div>
                    {{--<div>@{{issue.description|limit '100'}}</div> --}}
            </div>
            <div class="col-md-2">
                <strong>@{{issue.project.name}}</strong>
            </div>
            <div class="col-md-2" style="width:11%">
                <span v-if="issue.status.id==1" class="label label-primary">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==2" class="label label-info">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==3" class="label label-warning">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==4" class="label label-default">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==5" class="label label-success">@{{issue.status.name}}</span>
                <span v-if="issue.status.id==6" class="label label-danger">@{{issue.status.name}}</span>

                <span v-if="issue.priority.id==1" class="label label-info">@{{issue.priority.name}}</span>
                <span v-if="issue.priority.id==2" class="label label-primary">@{{issue.priority.name}}</span>
                <span v-if="issue.priority.id==3" class="label label-warning">@{{issue.priority.name}}</span>
                <span v-if="issue.priority.id==4" class="label label-danger">@{{issue.priority.name}}</span>
                <span v-if="issue.priority.id==5" class="label label-danger">@{{issue.priority.name}}</span>
            </div>
            <div class="col-md-2" style="width:12%">
                <div style="font-size:12px;">
                    <strong></strong> @{{issue.start_date}}
                    <template v-if="issue.due_date">
                        <strong>To </strong> @{{issue.due_date}}
                    </template>
                </div>
            </div>
            <div class="col-md-2" style="width:12%">
                <div style="font-weight:bold">
                    <i v-if="issue.assigned_to">@{{issue.assigned_to.name}}</i>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top:5px;">
            <div class="col-md-5">
                {!! Laform::field('comments','text',['template'=>'none',
                'attr'=>['v-model'=>'issue.comments','placeholder'=>'Comment','class'=>'input-sm'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.comments\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.comments\']">@{{error}}</div>'
                ]) !!}
            </div>
            <div class="col-md-2">
                {!! Laform::field('activity_id','select',['template'=>'none',
                'options'=>[''=>'Select Activity']+$activity,
                'attr'=>['v-select'=>'issue.activity_id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.activity_id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.activity_id\']">@{{error}}</div>'
                ]) !!}
            </div>
            <div class="col-md-2">
                {!! Laform::field('spent_on','text',['template'=>'none',
                'attr'=>['v-datepicker'=>'issue.spent_on',':dateformat'=>'"yy-mm-dd"','placeholder'=>'Date','class'=>'input-sm'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.spent_on\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.spent_on\']">@{{error}}</div>'
                ]) !!}
            </div>
            <div class="col-md-1">
                {!! Laform::field('hours','text',['template'=>'none',
                'attr'=>['v-model'=>'issue.hours','placeholder'=>'Hour','class'=>'input-sm'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.hours\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.hours\']">@{{error}}</div>'
                ]) !!}

            </div>
            <div class="col-md-1">
                <div v-if="issue.estimated_hours">
                <strong>Est :</strong> <span class="label label-warning">@{{issue.estimated_hours}}</span>
                </div>
            </div>
        </div>
        <hr>
    </div>
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
