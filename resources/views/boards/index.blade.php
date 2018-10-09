@extends('layouts.app')

@section('content')
<div class="content">
            <div class="container-fluid">
                @if (count($boards) > 0)
                
                <div class="row">
                    @foreach ($boards as $board)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{ $board->name }}</h4>
                                <!--<p class="category">category info</p>-->
                            </div>
                            <div class="content">
                                <p>{{ $board->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                @endif
            </div>
        </div>
@endsection