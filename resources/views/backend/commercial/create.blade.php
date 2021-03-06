@extends('backend.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/css/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/persianDatepicker-default.css')}}">
@endsection
@section('content')
    <div class="d-flex flex-column flex-md-row w-100 h-100">

        <!-- sidebar -->
        <div class="col-12 col-md-2 px-0 pl-md-2 h-100">
            @include('backend.partials.rightSidebar')
        </div>
        <!-- end of sidebar -->

        <div class="scroll col-12 col-md-10 px-0 px-md-4 mt-3 d-flex flex-column align-items-start pb-3">
            <div class="d-flex flex-column border-bottom w-100">
                <h3 class="custom-field-title text-right py-2 pr-2 mb-0 font-weight-bold">فرم ایجاد تبلیغ</h3>
            </div>
            @include('backend.partials.form-errors')
            <form class="customform p-3 w-100" method="post" action="{{route('commercial.store')}}" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="form-group row d-flex align-items-center">
                    <label for="title" class=" required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">عنوان :</label>
                    <div class="col-sm-6">
                        <input type="text" value="{{old('title')}}" class="custom-field form-control form-control-sm" id="title" name="title">
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="banner" class="required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">  بنر تبلیغاتی :</label>
                    <input type="hidden" value="{{old('banner')}}" name="banner" id="banner">
                    <div class="col-sm-6">
                        <div id="photo" class="dropzone" ></div>
                        <strong class="text-danger">* سایز عکس باید * : 400 باشد.</strong>
                    @if(session('commercial_banner'))
                            @if (session('commercial_banner')->originalName=='webm')
                                <video width="100px">
                                    <source src="{{'/storage'.session('commercial_banner')->path}}" type="video/mp4" >
                                </video>
                            @else
                                <img src="{{'/storage'.session('commercial_banner')->path}}" alt="" class="my-1" style="width:100px;">
                            @endif
                        @endif
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="click_count" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">تعداد کلیک :</label>
                    <div class="col-sm-6">
                        <input type="number" value="{{old('total_click')}}" class="custom-field form-control form-control-sm" id="" name="total_click">
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="url" class=" required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">آدرس :</label>
                    <div class="col-sm-6">
                        <input type="text" value="{{old('url')}}" class="custom-field form-control form-control-sm" id="url" name="url">
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="start_at" class=" required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2"> تاریخ شروع :</label>
                    <div class="col-sm-6">
                        <input type="text" value="{{old('start_date')}}" class="custom-field form-control form-control-sm" id="input3" name="start_date" />
                        <span id="span3"></span>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="finish_at" class=" required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2"> تاریخ پایان :</label>
                    <div class="col-sm-6">
                        <input type="text" value="{{old('finish_date')}}" class="custom-field form-control form-control-sm" id="input1" name="finish_date" />
                        <span id="span1"></span>
                    </div>
                </div>
                <div class="d-flex align-items-end">
                    <div class="col-sm-8 px-0">
                        <button type="submit" class="btn custombutton custombutton-success py-2 px-4"> ذخیره</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')

    <script type="text/javascript" src="{{asset('backend/js/dropzone.js')}}"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="{{asset('backend/js/persianDatepicker.min.js')}}"></script>
    <script>

        //datepicker
        $(function() {
            $("#input1, #span1").persianDatepicker();
            $("#input3, #span3").persianDatepicker();
        });

        var drop = new Dropzone('#photo', {
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: '.jpg, .jpeg,.gif,.png,.webm',
            maxFilesize: 1000, // MB
            contentsCss: "style.css",
            url: "{{ route('banner.upload') }}",
            sending: function(file, xhr, formData){
                formData.append("_token","{{csrf_token()}}")
            },
            success: function(file, response){
                document.getElementById('banner').value = response.url
            }
        });

    </script>
@endsection
