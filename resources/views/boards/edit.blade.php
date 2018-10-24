@extends('layouts.app', compact($boards))

@section('content')
<div class="content">
            <div class="container-fluid">

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
                
                <form action="/boards/{{ $board->id }}/edit" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="board_id" value="{{ $board->id }}" />
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control border-input" name="name" placeholder="Name" value="{{ $board->name }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control border-input" name="description" placeholder="Description" value="{{ $board->description }}">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-info btn-fill btn-wd">Update Board</button>
                    </div>
                </form>

            </div>
        </div>
@endsection
