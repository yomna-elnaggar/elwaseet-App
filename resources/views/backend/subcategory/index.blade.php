@extends('backend.layout.headerFooter')
@section('content')


    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>التصنيف الفرعي
                                <small>لوحة التحكم</small>
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                </a>
                            </li>
                            <li class="breadcrumb-item">التصنيف</li>
                            <li class="breadcrumb-item active">تصنيف تصنيف فرعي</li>
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
                    <div class="card">
                        <div class="card-header">
                            <form class="form-inline search-form search-box">
                                {{-- <div class="form-group">
                                <input class="form-control-plaintext" type="search" placeholder="Search..">
                            </div> --}}
                            </form>

                            <a href="{{ route('subcategory.create') }}" class="btn btn-primary add-row mt-md-0 mt-2">اضافة
                                تصنيف فرعي</a>
                        </div>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('msg') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive table-desi">
                                <table class="table all-package table-category " id="editableTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم(عربي)</th>
                                            <th>اسم(english)</th>
                                            <th>تصنيف عام</th>
                                            <th>تصنيف رئيسي</th>
                                            <th>صورة </th>
                                            <th>خيارات</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @isset($subcategory)
                                            @foreach ($subcategory as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->id}}
                                                    </td>

                                                    <td data-field="name">{{$item->name('ar')}}</td>
                                                    <td data-field="name">{{$item->name('en')}}</td>
                                                    <td data-field="slug">{{$item->superCategory->name('ar')}}</td>
                                                    <td data-field="slug">{{ $item->category ? $item->category->name('ar') : 'لا يوجد قسم رئيسي ' }}</td>
                                                    <td class="order-cancle" data-field="status">
                                                        <div class="card-icon">
                                                            <img src="{{url('public/'.$item->image)}}" alt="">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <a href="{{route('subcategory.edit' , $item->id)}}">
                                                            <i class="fa fa-edit" title="Edit"></i>
                                                        </a>

                                                        <a href="{{route('subcategory.destroy', $item->id)}}">
                                                            <i class="fa fa-trash" title="Delete"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection
