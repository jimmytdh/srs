<?php
    $user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('app')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 404</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

                    <p>
                        We could not find the page you were looking for.
                        Meanwhile, you may <a href="{{ url('/') }}">return to dashboard</a> or try using the search form.
                    </p>

                    <form class="search-form" action="{{ url('/documents/search') }}" method="post">
                        <div class="input-group">
                            {{ csrf_field() }}
                            <input type="text" name="keyword" class="form-control" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.input-group -->
                    </form>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')

@endsection
