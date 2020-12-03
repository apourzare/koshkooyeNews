@extends('backend.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/css/dropzone.min.css')}}">
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
                <h3 class="custom-field-title text-right py-2 pr-2 mb-0 font-weight-bold">فرم ویرایش مقاله ({{$article->title}})</h3>
            </div>
            @include('backend.partials.form-errors')
            <div class="d-flex flex-column flex-md-row bg-white w-100">
                <div class="col-12 col-md-2 mt-3">
                    <img src="{{'/storage/photos/articles/'.$article->thumbnail }}" alt="" class="img-fluid mb-3">
                    @if ($article->video_url)
                        <video width="100%" controls>
                            <source src="{{ '/storage/videos/'. $article->video_url }}" type="video/mp4">
                            مرورگر شمااین ویدیورا پشتیبانی نمی کند.
                        </video>
                    @endif
                </div>
                <form class="customform p-3 col-12 col-md-10" method="post" action="{{route('article.update',$article->id)}}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group row d-flex align-items-center">
                    <label for="title" class="required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">تیتر :</label>
                    <div class="col-sm-6">
                        <input type="text" class="custom-field form-control form-control-sm" value="{{$article->title}}" id="title" name="title">
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="slug" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">نام مستعار:</label>
                    <div class="col-sm-6">
                        <input type="text" class="custom-field form-control form-control-sm" value="{{$article->slug}}" id="slug" name="slug">
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="roo_titr" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">روتیتر :</label>
                    <div class="col-sm-6">
                        <input type="text" class="custom-field form-control form-control-sm" value="{{$article->roo_titr}}" id="roo_titr" name="roo_titr">
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="body" class="required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2"> متن خبر:</label>
                    <div class="col-sm-6">
                        <textarea type="text" class="custom-field form-control form-control-sm ckeditor" id="textareaDescription" rows="10" id="body" name="body" >{{$article->body}}</textarea>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="summery" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">خلاصه خبر :</label>
                    <div class="col-sm-6">
                        <textarea type="text" class="custom-field form-control form-control-sm" rows="10" id="summery" name="summery" >{{$article->summery}}</textarea>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="body" class="required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2"> دسته بندی خبر:</label>
                    <div class="col-sm-6">
                        <select name="category_id[]" class="w-100 custom-field" multiple>
                            <option value="">با نگه داشتن کلید Cntrl چندین دسته بندی را انتخاب کنید...</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                    @foreach($article->categories as $item)
                                        {{$item->id==$category->id ? "selected" : ""}}
                                        @endforeach>
                                        {{$category->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="tag" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">تگ ها :</label>
                    <div class="col-sm-6 text-right">
                        <input type="text" placeholder="تگها را با علامت کاما(،) از هم جدا کنید." class="mb-2 custom-field form-control form-control-sm" name="tag">
                        <div class="row">
                            @foreach($article->tags as $tag)
                                <div class=" ml-4 d-flex position-relative mb-4"  id="updated_tag_{{$tag->id}}">
                                    <span id="output" class="px-2 py-0 bg-primary text-white"> {{ $tag->name }}</span>
                                    <div class="remove px-1 text-right">
                                        <input class="form-check-input" type="checkbox" id="checkbox_tag_{{$tag->id}}" name="removedTags[]" value="{{$tag->name}}">
                                        <label for="checkbox_tag_{{$tag->id}}" class="custom-field-title form-check-label mr-3">حذف</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center ">
                    <label for="author" class="required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2"> نویسنده :</label>
                    <div class="col-sm-4 d-flex justify-content-start">
                        <select name="author_id" class="w-100 custom-field">
                            <option value="">انتخاب کنید...</option>
                            @foreach($authors as $author)
                                <option @if ($author->id == $article->author_id) selected @endif
                                    value="{{$author->id}}" >{{$author->first_name.' '.$author->last_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center ">
                    <label for="publish_status" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2"> وضعیت نشر :</label>
                    <div class="col-sm-4 d-flex justify-content-start">
                        <select name="publish_status" class="w-100 custom-field">
                            <option value="0" @if ($article->publish_status==0) selected @endif> پیشنویس</option>
                            <option value="1" @if ($article->publish_status==1) selected @endif>انتشار یافته</option>
                            <option value="2" @if ($article->publish_status==2) selected @endif>آرشیو</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center ">
                    <label for="publish_status" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2"> نمایش در کروسل :</label>
                    <div class="col-sm-4 d-flex justify-content-start">
                        <div class="col-sm-8 text-right pr-md-0">
                            <input class="form-check-input" @if ($article->is_carousel==1) checked @endif type="radio" value="1" name="is_carousel" id="radio1">
                            <label class="custom-field-title form-check-label mr-3 ml-3">فعال</label>

                            <input class="form-check-input" @if ($article->is_carousel==0) checked @endif type="radio" value="0" name="is_carousel" id="radio2">
                            <label class="custom-field-title form-check-label mr-3">غیرفعال</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="photo_id" class="required custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">  تصویر اصلی :</label>
                    <input type="hidden" name="thumbnail" id="thumbnail" value="{{$article->thumbnail}}">
                    <div class="col-sm-6">
                        <div id="photo" class="dropzone" ></div>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="photo" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">گالری تصاویر</label>
                    <input type="hidden" name="image_url[]" id="image_url">
                    <div class="col-sm-6">
                        <div id="articlePhoto" class="dropzone mb-3"></div>
                        @if($article->photos)
                            <div class="row">
                                @foreach($article->photos as $photo)
                                    <div class="col-sm-3" id="updated_photo_{{$photo->id}}">
                                        <img src="{{'/storage/photos/gallery/'.$photo->path}}" class="w-100">
                                        <button type="button" class="btn btn-danger mx-1 my-0" onclick="removeImages({{$photo->id}})">حذف</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center">
                    <label for="video" class="custom-field-title col-sm-2 col-form-label text-right font-weight-bold mr-2">  ویدیو :</label>
                    <input type="hidden" name="video_url" id="article_video" value="{{$article->video_url}}">
                    <div class="col-sm-6">
                        <div id="video" class="dropzone" ></div>
                    </div>
                </div>
                <div class="d-flex mt-3">
                    <div class="col-sm-8 px-0">
                        <button onclick="articleGallery()" type="submit" class="btn custombutton custombutton-success py-2 px-4"> ذخیره</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script type="text/javascript" src="{{asset('backend/js/dropzone.js')}}"></script>
    <script src="{{asset('backend/js/ckeditor/ckeditor.js')}}"></script>
    <script>
        var drop = new Dropzone('#photo', {
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: '.jpg, .jpeg,.gif,.png',
            maxFilesize: 100, // MB
            contentsCss: "style.css",
            url: "{{ route('thumbnail.upload') }}",
            sending: function(file, xhr, formData){
                formData.append("_token","{{csrf_token()}}")
            },
            success: function(file, response){
                document.getElementById('thumbnail').value = response.url
            }
        });

        var drop1 = new Dropzone('#video', {
            addRemoveLinks: true,
            acceptedFiles: '.mp4',
            maxFilesize: 100, // MB
            timeout: 0,
            maxFiles: 1,
            url: "{{ route('video.upload') }}",
            sending: function(file, xhr, formData){
                formData.append("_token","{{csrf_token()}}")
            },
            success: function(file, response){
                document.getElementById('article_video').value = response.url
            }
        });

        var photos = [].concat({{$article->photos->pluck('id')}})
        var photosGallery = []
        var drop3 = new Dropzone('#articlePhoto', {
            addRemoveLinks: true,
            acceptedFiles: '.jpg, .jpeg,.gif,.png',
            maxFilesize: 100, // MB
            contentsCss: "style.css",

            url: "{{ route('gallery.upload') }}",
            sending: function(file, xhr, formData){
                formData.append("_token","{{csrf_token()}}")
            },
            success: function(file, response){
                photosGallery.push(response.url)
            }
        });
        articleGallery = function(){
            document.getElementById('image_url').value = photosGallery.concat(photos);
            document.getElementById('removed_tags').value = removedTags;
        }


        CKEDITOR.replace('textareaDescription',{
            customConfig: 'config.js',
            toolbar: 'simple',
            language: 'fa',
            removePlugins: 'cloudservices, easyimage',
            filebrowserUploadUrl: "{{route('photo.ck_upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
        })

        removeImages = function(id){
            var index = photos.indexOf(id)
            photos.splice(index, 1);
            document.getElementById('updated_photo_' + id).remove();
        }

    </script>
@endsection