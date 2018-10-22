@extends('layouts.app', compact($boards))

@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">

                                @if (count($errors) > 0)
                                <!-- Form Error List -->
                                <div class="alert alert-danger">
                                    <strong>Whoops! Something went wrong!</strong>

                                    <br><br>

                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="/cards/{{ $card->id }}/edit" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="card_id" value="{{ $card->id }}" />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" class="form-control border-input" name="title" value="{{ $card->title }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Content</label>
                                                <textarea rows="5" class="form-control border-input" name="content">{{ $card->content }}</textarea>
                                                <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">* Markdown supported</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Update Card</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Tags</h4>
                            </div>
                            <div class="content">
                                @foreach ($tags as $tag)
                                {{ Form::checkbox('selected_tags[]', $tag->id, in_array($tag->id, $current_tags)) }}
                                {{ Form::label('selected_tag', $tag->label, array('class' => "card_tag card_" . $tag->class)) }}<br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection