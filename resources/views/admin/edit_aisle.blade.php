@extends('admin.layout')
@section('page_title','Edit Aisle')
@section('container')

<a href="{{url('admin/aisle')}}">
    <button type="button" class="btn btn-success m-t-25">
        Back
    </button>
</a>

<h2 class="m-t-30">Edit Aisle</h2>
<div class="row m-t-25">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/aisle/update')}}/{{$data->id}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="aisle_name" class="control-label mb-1">Aisle Name</label>
                        <input id="aisle_name" name="aisle_name" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$data->aisle_name}}"required>
                        
                        @error('aisle_name')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>    
                        @enderror
                    
                    </div>
                    <div class="form-group">
                        <label for="aisle_slug" class="control-label mb-1">aisle Slug</label>
                        <input id="aisle_slug" name="aisle_slug" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$data->aisle_slug}}" required>
                        
                        @error('aisle_slug')
                        <div class="alert alert-danger" role="alert">
                            "{{old('aisle_slug')}}"&nbsp;{{$message}}
                        </div>    
                        @enderror
                    </div>
                    
                    <div>
                        <button id="aisle-button" type="submit" class="btn btn-info mt-1 btn-sm  ">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection