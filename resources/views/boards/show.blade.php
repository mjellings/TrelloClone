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
                <div class="row">
                @foreach ($cards as $card)
                
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title card_title">{{ $card->title }} 
                                    @if ($board->pivot->can_write)
                                    <a href="/cards/{{ $card->id }}/edit" id="{{ $card->id }}_edit" style="display: none;"><i class="ti-pencil-alt"></i></a>
                                    @endif
                                </h4>
                            </div>
                            <div class="content">
                                <?php $Parsedown = new Parsedown(); 
                                $Parsedown->setSafeMode(true); ?>
                                {!! parsedown($card->content) !!}
                            </div>
                            <?php $tags = $card->tags()->orderBy('label', 'asc')->get(); ?>
                            
                            <div class="footer">
                                <p class="author_info" style="text-align: left; padding-left: 15px;">
                                    <span class="auther_name">{{ $card->user->name }}</span> 
                                    // 
                                    <span class="created_at">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($card->created_at))->diffForHumans() }}</span>
                                </p>
                                @if (count($tags))
                                <p class="text-right">
                                    @foreach ($tags as $tag)
                                    <span class="card_tag card_{{ $tag->class }}">{{ $tag->label }}</span> 
                                    @endforeach
                                </p>
                                @endif
                            </div>
                            
                        </div>
                    </div>

                @endforeach
                </div>
                @endif

                @if ($board->pivot->can_write)
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
                                            {!! Form::textarea('content', null, ['class'=>'form-control border-input']) !!}
                                            <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">* Markdown supported</a>
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
                @endif
                
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Share Board</h4>
                            </div>
                            <div class="content table-responsive">
                                @if ($board->pivot->is_owner)
                                <form action="/boards/{{ $board->id }}/share" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="board_id" value="{{ $board->id }}" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="can_write" id="can_write">

                                            <label class="form-check-label" for="can_write">
                                                User can add cards
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control border-input" placeholder="Users email address" name="email" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">Share Board</button>
                                </div>
                                </form>
                                @endif

                                @if (count($board->user))
                                <table class="table table-striped">
                                    <thead>
                                        <th>Name</th>
                                    	<th>Email</th>
                                        <th>Board Owner</th>
                                    	<th>Can Add Cards?</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($board->user as $u)
                                        <tr>
                                        	<td>{{ $u->name }}</td>
                                        	<td>{{ $u->email }}</td>
                                            <td>{{ ($u->pivot->is_owner) ? 'Yes' : '' }}</td>
                                        	<td>{{ ($u->pivot->can_write) ? 'Yes' : '' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $(".card_title").hover(function(){
    $(this).find('a').css("display", "inline");
    }, function(){
    $(this).find('a').css("display", "none");
    });
});
</script>
@endsection