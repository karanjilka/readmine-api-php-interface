<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="container">
            <div class="content">
                {!! Laform::open(array('url'=>'admin/formtest','class'=>'form-horizontal')) !!}

                {!! Laform::field('name','text',[
                'template'=>'none',
                'label'=>'Name',
                ]) !!}

                {!! Laform::field('email','email',['label'=>'Email address','template'=>'none']) !!}

                {!! Laform::field('password','password',['label'=>'Password','template'=>'none']) !!}

                {!! Laform::field('password_confirmation','password',['label'=>'Confirm Password','template'=>'none']) !!}

                {!! Laform::field('role_id[]','select',
                ['label'=>'Select Roles',
                'template'=>'none',
                'options'=>[1=>'Admin',2=>'Siteadmin'],
                'attr'=>['multiple'=>'multiple']]) !!}

                {!! Laform::field('test_textarea','textarea',['label'=>'Text Area','template'=>'none','attr'=>['rows'=>'5','cols'=>'10']]) !!}

                {!! Laform::field('test_chexbox','checkbox',['option'=>'1','template'=>'none','label'=>'test Checkox']) !!}

                {!! Laform::field('test_radio','radio',['option'=>'1','template'=>'none','label'=>'test Checkox']) !!}

                {!! Laform::field('test_chexboxs[]','checkboxs',['template'=>'none','option'=>['1'=>'option 1','2'=>'option 2',
                '3'=>'option 3'],'label'=>'test Checkox']) !!}

                {!! Laform::close() !!}
            </div>
        </div>
    </body>
</html>
