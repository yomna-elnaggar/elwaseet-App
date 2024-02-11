@extends('backend.layout.headerFooter')
@section('content')


    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>انشاء التصنيف
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
                            <li class="breadcrumb-item">تصنيف رئيسي</li>
                            <li class="breadcrumb-item active">انشاء تصنيف فرعي</li>
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
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('msg') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
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
                            <form action="{{ route('state.update', $state->id) }}" method="post" class="needs-validation" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="validationCustom2" class="col-xl-3 col-md-4"><span>*</span> التصنيف العام </label>
                                    <div class="col-md-4">
                                        <select class="form-select" aria-label="Disabled select example" name="country_id"  onchange="console.log($(this).val())">
                                            <option value="{{ $state->country->id  }}" selected>  {{  $state->country->name('ar') }}</option>
                                            @foreach ($Country as $item)
                                                <option value="{{$item->id}}">{{$item->name('ar')}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom2" class="col-xl-3 col-md-4"><span>*</span>المحافظة </label>
                                    <div class="col-md-4">
                                        <select class="form-select" aria-label="Disabled select example" name="government_id" >
                                            <option
                                            value="{{ $state->government->id }}">
                                            {{ $state->government->name('ar') }}
                                            </option>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span>اسم
                                        المنطفة(عربي)</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="validationCustom1" type="text" name="name_ar"
                                            required="" value="{{$state->name('ar')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span>اسم
                                        المنطفة(english)</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="validationCustom1" type="text" name="name_en"
                                            required="" value="{{$state->name('en')}}">
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

@section('script')
<script>
    $(document).ready(function () {
        $('select[name="country_id"]').on('change', function () {
            var country_id = $(this).val();
            if (country_id) {
                $.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});
                $.ajax({
                    url: "{{ URL::to('government') }}/" + country_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        // console.log(data);
                        $('select[name="government_id"]').empty();
                        $.each(data, function (key, value) {
                            
                            $('select[name="government_id"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>

@endsection
