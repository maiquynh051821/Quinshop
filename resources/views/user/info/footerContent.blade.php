@extends('user.main')
@section('body')

<section style="margin-top:100px;min-height:700px;margin-bottom:120px">
  
        <h3 style="text-align:center;color:black;margin-bottom:30px ">{{ $footer->name }}</h3>
     <div class="container">
        {!! $footer->content !!}
     </div>
</section>
   
@endsection