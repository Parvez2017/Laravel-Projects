@extends('layouts.backend.app')

@push('css')

@endpush


@section('content')

    <div class="container-fluid">

        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="body">
                        <form action="{{route('admin.tag.update',$tag->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <label for="tag">Edit Tag</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="name" class="form-control" placeholder="" name="name" value="{{$tag->name}}">
                                </div>
                            </div>

                            <a href="{{route('admin.tag.index')}}" class="btn btn-danger m-t-15 waves-effect">Back</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')

@endpush