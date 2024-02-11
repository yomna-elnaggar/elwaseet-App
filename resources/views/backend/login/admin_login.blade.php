<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <link rel="icon" href="{{ url('../public/panel') }}/assets/images/favicon.png"> --}}
    <!--Page title-->
    <title>تسجيل دخول أدمن</title>
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/c7392f690f.js" crossorigin="anonymous"></script>
    <!--Custom CSS-->
    <link rel="stylesheet" href="{{  url('../public/css') }}/style-login-register.css">
</head>

<body>


    <div class="container">

        <!-- <a href="" class="logo" target="_blank">

            <img src="" alt="">
        </a> -->

        <div class="section">
            <div class="container">
                <div class="row full-height justify-content-center">
                    <div class="col-12 text-center align-self-center py-5">
                        <div class="section pb-5 pt-5 pt-sm-2 text-center">
                       
                         <!--    <h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
                            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" /> -->
                            <label for="reg-log"></label>
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">
                                    <div class="card-front">
                                        <div class="center-wrap" dir="rtl">
                                            <div class="section text-center">
                                                @if (Session::has('error'))
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <strong>{{session::get('error')}}</strong>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="width:10px !important; height:10px !important; color:#000;line-height:10px;"><i class="fa-sharp fa-solid fa-xmark"></i></button>
                                                  </div>
                                                @endif
                                                <h4 class="mb-4 pb-3">تسجيل الدخول</h4>
                                                <form action="{{route('admin.login')}}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="email" name="email" class="form-style"
                                                            placeholder="ايميل" id="logemail" autocomplete="on">
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input type="password" name="password" class="form-style"
                                                            placeholder="كلمة المرور" id="logpass"
                                                            autocomplete="off">
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>
                                                    <button type="submit" class="btn mt-4">تسجيل الدخول</button>
                                                </form>
                                                <p class="mb-0 mt-4 text-center">
                                                    <a href="#0" class="link">
                                                        نسيت كلمة المرور؟
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-back">
                                        <div class="center-wrap" dir="rtl">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">انشاء حساب جديد</h4>
                                                <form action="{{route('admin.register.create')}}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="text" name="name" class="form-style"
                                                            placeholder="ادخل اسمك بالكامل" id="logname"
                                                            autocomplete="off">
                                                        <i class="input-icon uil uil-user"></i>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input type="email" name="email" class="form-style"
                                                            placeholder="ايميل" id="logemail" autocomplete="off">
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input type="password" name="password" class="form-style"
                                                            placeholder="كلمة المرور" id="logpass"
                                                            autocomplete="off">
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input type="password" name="password_confirmation" class="form-style"
                                                            placeholder="تأكيد كلمة المرور" id="logpass"
                                                            autocomplete="off">
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>
                                                    <button type="submit" class="btn mt-4">تسجيل</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

</body>

</html>
