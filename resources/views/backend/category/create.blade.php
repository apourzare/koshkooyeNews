@extends('backend.layouts.master')

@section('content')
    <div class="d-flex flex-column flex-md-row w-100 h-100">

        <!-- sidebar -->
        <div class="col-12 col-md-2 px-0 pl-md-2 h-100">
            @include('backend.partials.rightSidebar')
        </div>
        <!-- end of sidebar -->

        <div class="scroll col-12 col-md-10 px-0 px-md-4 mt-3 d-flex flex-column align-items-start pb-3">
            <div class="d-flex flex-column border-bottom w-100">
                <h3 class="custom-field-title text-right py-2 pr-2 mb-0 font-weight-bold">فرم ایجاد دسته بندی</h3>
            </div>
            @include('backend.partials.form-errors')
            <form class="customform p-3 w-100" method="post" action="{{route('category.store')}}">
                @method('POST')
                @csrf
                <div class="form-group row d-flex align-items-center">
                    <label for="name" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">نام :</label>
                    <div class="col-sm-4">
                        <input type="text" class="custom-field form-control form-control-sm" id="name" name="name">
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="slug" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2"> نام مستعار:</label>
                    <div class="col-sm-4">
                        <input type="text" class="custom-field form-control form-control-sm" id="slug" name="slug">
                    </div>
                </div>
                <div class="d-flex align-items-end">
                    <div class="col-sm-6">
                        <button type="submit" class="btn custombutton custombutton-success py-2 px-4"> ذخیره</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
