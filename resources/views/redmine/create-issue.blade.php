@extends('redmine.layouts.default')

@section('content')
<div id="app">
    {!! Laform::open(array('url'=>'redmine/issue',
    'class'=>'form-horizontal',
    '@submit.prevent'=>'onSave'
    )) !!}

    <div v-for="issue in issues">
        <div class="clearfix">
            <div class="clearfix">
                <div class="pull-left"><strong>#@{{($index+1)}}</strong></div>
                <div class="pull-right"><a href="#" @click.stop.prevent="removeStack($index)" class="btn btn-danger btn-sm"> Remove </a></div>
            </div>
            <div class="col-md-7">
                {!! Laform::field('subject','text',['template'=>'none',
                'label'=>'Subject',
                'attr'=>['v-model'=>'issue.subject'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.subject\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.subject\']">@{{error}}</div>'
                ]) !!}

                {!! Laform::field('description','textarea',['template'=>'none',
                'label'=>'Description',
                'attr'=>['rows'=>4,'v-model'=>'issue.description'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.description\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.description\']">@{{error}}</div>'
                ]) !!}
                <div class="clearfix">
                    <div class="col-md-4">
                        {!! Laform::field('start_date','text',['template'=>'none',
                        'wrapper'=>false,
                        'field_prefix'=>'<label class="control-label">Start Date</label>',
                        'attr'=>['v-datepicker'=>'issue.start_date',':dateformat'=>'"yy-mm-dd"'],
                        'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.start_date\']}'],
                        'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.start_date\']">@{{error}}</div>'
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Laform::field('due_date','text',['template'=>'none',
                        'wrapper'=>false,
                        'field_prefix'=>'<label class="control-label">Due Date</label>',
                        'attr'=>['v-datepicker'=>'issue.due_date',':dateformat'=>'"yy-mm-dd"'],
                        'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.due_date\']}'],
                        'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.due_date\']">@{{error}}</div>'
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Laform::field('parent_issue_id','text',['template'=>'none',
                        'wrapper'=>false,
                        'field_prefix'=>'<label class="control-label">Parent Issue Id</label>',
                        'attr'=>['v-model'=>'issue.parent_issue_id'],
                        'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.parent_issue_id\']}'],
                        'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.parent_issue_id\']">@{{error}}</div>'
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                {!! Laform::field('tracker_id','select',['template'=>'none',
                'label'=>'Type',
                'options'=>$track,
                'attr'=>['v-select'=>'issue.tracker_id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.tracker_id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.tracker_id\']">@{{error}}</div>'
                ]) !!}

                {!! Laform::field('project_id','select',['template'=>'none',
                'label'=>'Project Id',
                'options'=>[''=>'Select Project']+$projects,
                'attr'=>['v-select'=>'issue.project_id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.project_id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.project_id\']">@{{error}}</div>'
                ]) !!}

                {!! Laform::field('assigned_to_id','select',['template'=>'none',
                'label'=>'Assinged To',
                'options'=>[''=>'Assinged To']+$users,
                'attr'=>['v-select'=>'issue.assigned_to_id'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.assigned_to_id\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.assigned_to_id\']">@{{error}}</div>'
                ]) !!}

                {!! Laform::field('estimated_hours','text',['template'=>'none',
                'field_prefix'=>'<label class="control-label">Estimated Hours</label>',
                'attr'=>['v-model'=>'issue.estimated_hours'],
                'wrapper_attr'=>['v-bind:class'=>'{ \'has-error\': errors[\'issues.\'+$index+\'.estimated_hours\']}'],
                'field_suffix'=>'<div class="text-danger" v-for="error in errors[\'issues.\'+$index+\'.estimated_hours\']">@{{error}}</div>'
                ]) !!}
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
                subject:'',
                description:'',
                project_id:'',
                assigned_to_id:'',
                parent_issue_id:'',
                start_date:'',
                due_date:'',
                estimated_hours:'',
                tracker_id:'2'
            }
        ],
        errors:[],
    },
    methods:{
        onSave : function(){
            var self = this;
            $('.ajax-loader').show();
            this.$http.post('/redmine/issue',{issues: self.issues}).then(function(response){
                window.location = '/redmine/issue/create';
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
                subject:'',
                description:'',
                project_id:'',
                assigned_to_id:'',
                parent_issue_id:'',
                start_date:'',
                due_date:'',
                estimated_hours:'',
                tracker_id:'2'
            });
        }
    }
});
</script>
@stop
