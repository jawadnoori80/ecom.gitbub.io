@extends('admin.layout')
@section('page_title','Edit Category')
@section('container')

<a href="{{url('admin/category')}}">
    <button type="button" class="btn btn-success m-t-25">
        Back
    </button>
</a>

<h2 class="m-t-30">Edit Category</h2>
<div class="row m-t-25">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/category/update')}}/{{$data->id}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="category_name" class="control-label mb-1">Category Name</label>
                        <input id="category_name" name="category_name" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$data->category_name}}"required>
                        
                        @error('category_name')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>    
                        @enderror
                    
                    </div>
                    <div class="form-group">
                        <label for="category_slug" class="control-label mb-1">Category Slug</label>
                        <input id="category_slug" name="category_slug" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$data->category_slug}}" required>
                        
                        @error('category_slug')
                        <div class="alert alert-danger" role="alert">
                            "{{old('category_slug')}}"&nbsp;{{$message}}
                        </div>    
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="aisle_id" class="control-label mb-1"> Aisle</label>
                        <select id="aisle_id" name="aisle_id" class="form-control form-select" required>
                            <option value="">Select Aisle</option>
                            @foreach($aisle as $list)
                            @if ($data->aisle_id==$list->id)
                            <option selected value="{{$list->id}}">
                                @else
                            <option value="{{$list->id}}">
                                @endif
                                {{$list->aisle_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <button id="category-button" type="submit" class="btn btn-info mt-1 btn-sm  ">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection