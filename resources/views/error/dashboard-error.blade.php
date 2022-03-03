<style>

.middle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}
</style>
@extends('layouts.main')

@section('content')
<div class="middle">
<img width="200" alt="image" src="{{ asset('assets/images/503.svg') }}">
                        <h1 class="display-1 fw-600 font-secondary" style="color: #812720">403</h1>
                        <h5>Access Denied</h5>
                        <p class="opacity-75">
                            You are not granted priviliges to access this page. Please contact the Administrator.
                            <!-- of <strong>IASBYHEART Team</strong>. -->
                        </p></div>
@endsection