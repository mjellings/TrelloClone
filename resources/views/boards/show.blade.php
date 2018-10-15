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

            </div>
        </div>
@endsection