@extends('backend.layout.headerFooter')
@section('content')


    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>اضافة منتج
                                <small>لوحة التحكم</small>
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            <li class="breadcrumb-item">
                                <a href="{{route('subcategory.all')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                </a>
                            </li>
                            <li class="breadcrumb-item">المنتجات </li>
                            <li class="breadcrumb-item active">اضافة منتج</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li class="text-danger">
                                    {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('product.update', $product->id) }}" method="post" class="needs-validation" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <select class="form-select" aria-label="Disabled select example" name="cate_id">
                                            <option value=" ">اختر تصنيف</option>
                                            @foreach ($category as $item)
                                                <option value="{{$item->id}}" {{$product->cate_id == $item->id ? 'selected' : ' '}}>{{$item->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>اسم المنتج</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="validationCustom0" type="text" name="name"
                                            value="{{$product->name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span>slug</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="validationCustom1" type="text" name="slug"
                                             value="{{$product->slug}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom2" class="col-xl-3 col-md-4"><span>*</span>وصف</label>
                                    <div class="col-md-8">
                                        <textarea class="ckeditor form-control" id="validationCustom3" name="description">{!! $product->description !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom3" class="col-xl-3 col-md-4"><span>*</span>السعر</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="validationCustom3" type="text" name="original_price"
                                             value="{{$product->original_price}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom4" class="col-xl-3 col-md-4"><span>*</span>صورة منتج</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="validationCustom4" type="file" name="picture"
                                             >
                                            <br>
                                        <img src="{{asset('picProducts/'. $product->picture)}}" width="60px" height="60px" alt="...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom5" class="col-xl-3 col-md-4"><span>*</span>الكمية</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="validationCustom5" type="number"
                                            name="qty" min="1" max="5" value="{{$product->qty}}" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-md-4">حالة</label>
                                    <div class="col-xl-9 col-md-8">
                                        <div class="checkbox checkbox-primary">
                                            <input id="checkbox-primary-2" type="checkbox" data-original-title=""
                                                title="" name="status" {{$product->status == 1? 'checked': ' '}}>
                                            <label for="checkbox-primary-2">اظهار المنتج</label>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary d-block">حفظ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>


@endsection
