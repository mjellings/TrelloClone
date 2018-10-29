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

                                    <form action="/boards/create" method="post">
                                    {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control border-input" name="name" placeholder="Name" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control border-input" name="description" placeholder="Description" value="">
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

                @if (count($boards) > 0)
                
                <div class="row">
                    @foreach ($boards as $board)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title card_title">{{ $board->name }} 
                                    @if ($board->pivot->can_write)
                                    <a href="/boards/{{ $board->id }}/edit" id="{{ $board->id }}_edit" style="display: none;"><i class="ti-pencil-alt"></i></a>
                                    @endif
                                </h4>
                                <!--<p class="category">category info</p>-->
                            </div>
                            <div class="content">
                                <p>{{ $board->description }}</p>
                            </div>
                            <div class="footer">
                                <p>
                                    <a class="btn btn-info btn-fill btn-wd" href="/boards/{{ $board->id }}">
                                        View
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                @else 
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="content">
                                <p>Nothing to see here, why not create a new board.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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