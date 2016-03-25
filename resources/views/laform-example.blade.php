<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="container">
            <div class="content">
                {!! Laform::open(array('url'=>'laform-example','class'=>'form-horizontal')) !!}

                {!! Laform::field('name[0]','text',[
                'template'=>'none',
                'label'=>'Name',
                'error_message_name'=>'name.0',
                ]) !!}

                {!! Laform::field('name[1]','text',[
                'template'=>'none',
                'label'=>'Name',
                'error_message_name'=>'name.1',
                ]) !!}

                {!! Laform::field('email','email',[
                'label'=>'Email address',
                'template'=>'none'
                ]) !!}

                {!! Laform::field('password','password',['label'=>'Password','template'=>'none']) !!}

                {!! Laform::field('password_confirmation','password',['label'=>'Confirm Password','template'=>'none']) !!}

                {!! Laform::field('role_id[]','select',
                ['label'=>'Select Roles',
                'template'=>'none',
                'error_message_name'=>'role_id',
                'options'=>[1=>'Admin',2=>'Siteadmin'],
                'attr'=>['multiple'=>'multiple']]) !!}

                {!! Laform::field('test_textarea','textarea',['label'=>'Text Area','template'=>'none','attr'=>['rows'=>'5','cols'=>'10']]) !!}

                {!! Laform::field('test_chexbox','checkbox',['option'=>'1','template'=>'none','label'=>'test Checkox']) !!}

                {!! Laform::field('test_radio','radio',['option'=>'1','template'=>'none','label'=>'test Checkox']) !!}

                {!! Laform::field('test_chexboxs[]','checkboxs',['template'=>'none','option'=>['1'=>'option 1','2'=>'option 2',
                '3'=>'option 3'],'label'=>'test Checkox']) !!}

                <button class="btn btn-success">Save</button>

                {!! Laform::close() !!}
            </div>
        </div>
    </body>
</html>
