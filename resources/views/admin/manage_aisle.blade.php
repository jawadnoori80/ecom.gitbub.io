@extends('admin.layout')
@section('page_title','Manage Aisle')
@section('container')

<a href="{{url('admin/aisle')}}">
    <button type="button" class="btn btn-success m-t-25">
        Back
    </button>
</a>

<h2 class="m-t-30">Manage Aisle</h2>
<div class="row m-t-25">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{route('aisle.insert')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="aisle_name" class="control-label mb-1">Aisle Name</label>
                        <input id="aisle_name" name="aisle_name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        
                        @error('aisle_name')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>    
                        @enderror
                    
                    </div>
                    <div class="form-group">
                        <label for="aisle_slug" class="control-label mb-1">Aisle Slug</label>
                        <input id="aisle_slug" name="aisle_slug" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        
                        @error('aisle_slug')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>    
                        @enderror
                    </div>
                    
                    <div>
                        <button id="aisle-button" type="submit" class="btn btn-info mt-2">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection