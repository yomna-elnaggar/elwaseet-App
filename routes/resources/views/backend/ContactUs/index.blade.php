@extends('backend.layout.header&footer')
@section('content')



    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>الرسائل 
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
                            <li class="breadcrumb-item">الرسائل </li>
                            <li class="breadcrumb-item active">الرسائل </li>
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
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong> {{ Session::get('msg') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                        </div>



                        <div class="card-body">
                            <div class="table-responsive table-desi">
                                <table class="table all-package table-category " id="editableTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>الاميل</th>
                                            <th>رقم الهاتف</th>
                                            <th>الرسالة</th>
                                            <th>حذف</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @isset($ContactUs)
                                            @foreach ($ContactUs as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->id}}
                                                    </td>

                                                    <td data-field="name">{{$item->name}}</td>

                                                    <td data-field="slug">{{$item->email}}</td>
                                                    <td data-field="slug">{{$item->mobile_number}}</td>
                                                    <td data-field="slug" > .....{{substr($item->message, 0, 40)}}</td>

                                                    <td>
                                                       <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}">
                                                           <i class="fa fa-eye" title="show"></i>
                                                        </button>
                                                        <a href="{{route('ContactUs.destroy', $item->id)}}">
                                                            <i class="fa fa-trash" title="Delete"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                      
                                      <!-- Modal -->
<div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">الرسالة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{$item->message}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
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
