@extends('front.layout')
@section('page_title','Cart Page')
@section('container')
<div class="shopping-cart-page">
<div class="container-lg">
    
  <livewire:cart-page /> 
</div>
</div>

<script>
  $(document).ready(function() {
    
  });
</script>
@endsection
