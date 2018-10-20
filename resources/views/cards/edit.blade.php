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

                                    Form here
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection