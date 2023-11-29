@extends('layouts.website')

@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center my-5 py-5">
            <h1 class="text-white mt-4 mb-4">Elevating Education Through Feedback</h1>
            <h1 class="text-white display-1 mb-5">Explore and Connect </h1>
            <div class="mx-auto mb-5" style="width: 100%; max-width: 600px;">
                <div class="input-group " style='display:inline-block'>
                       <a style=" background: #000;
    padding: 16px !important;
    text-transform: uppercase;
    width: 45%;
    float: inline-start; " href="https://educationscience.joharshakildeveloper.com/login" class="btn btn-primary py-2 px-4 d-none d-lg-block">Login </a>  
            
            <small class="px-3">|</small>
             <a style=" background: #000;
    padding: 16px !important;
    text-transform: uppercase;
    width: 45%;
    float: inline-start;  " href="https://educationscience.joharshakildeveloper.com/register" class="btn btn-primary py-2 px-4 d-none d-lg-block">SIGN UP</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="img/about.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">About Us</h6>
                        <h1 class="display-4">Bridging Gaps in Education Through Feedback</h1>
                    </div>
                    <p>Portal to provide new factors between the conection, and connectivity with different students belonging from different nations such as who is the leader, and who are decision-makers in groups. on the bases of visual metrics which help institutions to analyze their performance and make such decisions to bring new changes faster and better decisions for students and the organization.</p>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->




@endsection
