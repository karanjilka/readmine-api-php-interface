@extends('redmine.layouts.default')

@section('content')
<div id="app">
    {!! Laform::open(array('url'=>'redmine/timeentry',
    'class'=>'form-horizontal',
    '@submit.prevent'=>'onSave'
    )) !!}

    <div v-for="issue in issues">
        <div class="clearfix">
            <div class="clearfix">
                <div class="pull-left"><strong>#@{{($index+1)}}</strong></div>
                <div class="pull-right"><a href="#" @click.stop.prevent="removeStack($index)" class="btn btn-danger btn-sm"> Remove </a></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3">
                    {!! Laform::field('project_id','select',['template'=>'none',
                    'label'=>'Project',
                    'options'=>[''=>'Select Project']+$projects,
                    'attr'=>['v-select'=>'issue.project_id'],
                    'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.project_id\']}'],
                    'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.project_id\']">@{{error}}</div>'
                    ]) !!}
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    {!! Laform::field('activity_id','select',['template'=>'none',
                    'label'=>'Activity',
                    'options'=>[''=>'Select Activity']+$activity,
                    'attr'=>['v-select'=>'issue.activity_id'],
                    'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.activity_id\']}'],
                    'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.activity_id\']">@{{error}}</div>'
                    ]) !!}
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    {!! Laform::field('spent_on','text',['template'=>'none',
                    'field_prefix'=>'<label class="control-label">Spent On</label>',
                    'attr'=>['v-datepicker'=>'issue.spent_on',':dateformat'=>'"yy-mm-dd"'],
                    'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.spent_on\']}'],
                    'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.spent_on\']">@{{error}}</div>'
                    ]) !!}
                </div>
            </div>
            <div class="clearfix">
                <div class="col-md-2">
                    {!! Laform::field('hours','text',['template'=>'none',
                    'label'=>'Hours',
                    'attr'=>['v-model'=>'issue.hours'],
                    'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.hours\']}'],
                    'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.hours\']">@{{error}}</div>'
                    ]) !!}
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-9">
                    {!! Laform::field('comments','text',['template'=>'none',
                    'label'=>'Comment',
                    'attr'=>['v-model'=>'issue.comments'],
                    'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.comments\']}'],
                    'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.comments\']">@{{error}}</div>'
                    ]) !!}
                </div>
            </div>
        </div>

        <hr>
    </div>
    <div class="form-group">
    <div class="pull-left">
        <button class="btn btn-primary btn-lg"> Save </button>
    </div>
    <div class="pull-right">
        <a href="#" @click.stop.prevent="addMore()" class="btn btn-success btn-lg"> Add </a>
    </div>
    </div>

    {!! Laform::close() !!}
</div>
@stop

@section('script')
<script type="text/javascript">
new Vue({
    el:'#app',
    data:{
        issues:[
            {
                project_id:'',
                spent_on:'',
                hours:'',
                activity_id:'',
                start_date:'',
                comments:'',
            }
        ],
        errors:[],
    },
    methods:{
        onSave : function(){
            var self = this;
            $('.ajax-loader').show();
            this.$http.post('/redmine/timeentry',{issues: self.issues}).then(function(response){
                window.location = '/redmine/timeentry/create';
                $('.ajax-loader').hide();
            },function(response){
                $('.ajax-loader').hide();
                this.errors = response.data;
            });
        },
        removeStack : function(index){
            //var self = this;
            this.issues.splice(index, 1);
        },
        addMore : function(){
            //var self = this;
            this.issues.push({
                project_id:'',
                spent_on:'',
                hours:'',
                activity_id:'',
                start_date:'',
                comments:'',
            });
        }
    }
});
</script>
@stop
