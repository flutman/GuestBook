@extends('main')

@section('title', 'Main Page')

@section('content')

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!--FORM-->
                        {!! Form::open(['data-route' => 'posts', 'class' => 'form-horizontal', 'id' => 'form-data']) !!}
                        <div class="form-group">
                            {{ Form::label('post_text', "Сообщение: ", array('class' => 'col-sm-2 control-label')) }}
                            <div class="col-sm-10">
                            {{ Form::textarea('post_text', null, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                {{ Form::submit('Отправить сообщение', array('class' => 'btn btn-success')) }}
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <!-- END FORM -->
                    </div>
                </div>
                <div class="row"> <!-- POSTS -->
                    @if (isset($posts))

                        @foreach($posts as $post)
                        <div class="col-md-12">
                            <div class="row">
                                <div class="post col-md-8">
                                    <h4>{{ isset($post->user) ? $post->user->name : "Аноним"}}</h4>
                                    <h6>{{ date('M j, Y H:i', strtotime($post->created_at)) }}</h6>
                                    <p>{{ isset($post) ? $post->text : 'Новый пост' }}</p>
                                </div>
                                @hasrole('admin')
                                <div class="col-md-4 text-right">
                                    <div class="btn-group" role="group" aria-label="...">
                                    {!! Html::linkRoute('posts.edit', 'Редактировать',
                                        array($post->id),
                                        array('class' => 'btn btn-warning'))
                                    !!}
                                    {!! Html::linkRoute('posts.destroy', 'Удалить',
                                        array($post->id),
                                        array('class' => 'btn btn-danger'))
                                     !!}
                                    </div>
                                </div>
                                @endhasrole
                            </div>
                            <hr/>
                        </div> <!-- POST BLOCK -->
                        @endforeach

                    @endif
                </div>
            </div>
        </main>
@endsection
