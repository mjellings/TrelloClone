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
                            <!-- Placeholder for card tags
                            <div class="footer text-right">
                                <span class="card_tag card_important">Imporant</span> 
                                <span class="card_tag card_completed">Completed</span>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
        </div>
@endsection