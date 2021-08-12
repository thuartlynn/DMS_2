@extends('layouts.welcome')

@section('content')
  <div id="app" class="flex-column-design">
    <div class="" id="up">
      <indexbanner></indexbanner>
    </div>
      
    <div class="" id="center">
      <router-view></router-view>
    </div>
    
    <div class="" id="bottom">
      <copyright></copyright>
    </div>
  </div>

  <!-- style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 10px; z-index:99;" -->
@endsection


