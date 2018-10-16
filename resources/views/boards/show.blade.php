@extends('layouts.app', compact($boards))

@section('content')
<div class="content">
            <div class="container-fluid">

                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-plain">
                            <div class="content">
                                <p>{{ $board->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $cards = $board->cards()->orderBy('title', 'asc')->get(); ?>
                @if (count($cards) > 0)
                @foreach ($cards as $card)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{ $card->title }}</h4>
                            </div>
                            <div class="content">
                                {{ $card->content }}
                            </div>
                            <?php $tags = $card->tags()->orderBy('label', 'asc')->get(); ?>
                            @if (count($tags))
                            <div class="footer text-right">
                                @foreach ($tags as $tag)
                                <span class="card_tag card_{{ $tag->class }}">{{ $tag->label }}</span> 
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">New Card</h4>
                            </div>
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

                                <form action="/cards/create" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="board_id" value="{{ $board->id }}" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control border-input" placeholder="Title" value="" name="title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Content</label>
                                            <input type="text" class="form-control border-input" placeholder="Content" value="" name="content">
                                            {!! Form::textarea('keterangan', null, ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">Create Board</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection