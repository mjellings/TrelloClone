@extends('layouts.app', compact($boards))

@section('content')
<div class="content">
            <div class="container-fluid">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control border-input" name="title" value="{{ $card->title }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Content</label>
                                                    <textarea class="form-control border-input" name="content">{{ $card->content }}</textarea>
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
                </div>

            </div>
        </div>
@endsection