@extends('admin.layout')
@section('page_title','Manage Banners')
@section('container')

<a href="{{url('admin/HB')}}">
    <button type="button" class="btn btn-success m-t-25">
        Back
    </button>
</a>

<h2 class="m-t-30">Manage Home Banners</h2>
<div class="row m-t-25">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{route('HB.insert')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="hb_tag" class="control-label mb-1">Bannner Tag</label>
                        <input id="hb_tag" name="hb_tag" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        
                        @error('hb_tag')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>    
                        @enderror
                    
                    </div>
                    <div class="form-group">
                        <label for="hb_text" class="control-label mb-1">Banner Text</label>
                        <input id="hb_text" name="hb_text" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        
                        @error('hb_text')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>    
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="hb_link" class="control-label mb-1">Banner Link</label>
                        <input id="hb_link" name="hb_link" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        
                        @error('hb_link')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>    
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="image" class="control-label mb-1"> Image</label>
                        <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" required>
                        @error('image')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}		
                        </div>
                        @enderror
                    </div>
                    
                    <div>
                        <button id="hb-button" type="submit" class="btn btn-info mt-2">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection