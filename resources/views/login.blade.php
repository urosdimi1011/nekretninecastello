<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

<div class="container">

    <div class="screen">

        <div class="screen__content">
            <div class="p-4 logo logo-desktop d-flex justify-content-center">
                <a href="https://www.castellonekretnine.rs/">
                    <img src="<?=asset("assets/img/logo.png")?>" height="80" width="" alt="logo">
                </a>
            </div>
            <h3 class="naslov-logina-i-registracije">Ulogujte se</h3>
            <form action="" method="post" class="login">
                @csrf
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" name="emailLogin" class="login__input" value="{{old('emailLogin')}}" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'"  placeholder="Email">
                    @if($errors->has('emailLogin'))
                        <p class="error">* {{$errors->first("emailLogin")}}</p>
                    @endif
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" name="passwordLogin" value="{{old('passwordLogin')}}" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" class="login__input" placeholder="Lozinka">
                    @if($errors->has('passwordLogin'))
                        <p class="error">* {{$errors->first("passwordLogin")}}</p>
                    @endif
                </div>
                @if(session()->get("error-msg"))
                    <span class="error">* {{session()->get("error-msg")}}</span>
                @endif
                @if(session()->get("success"))
                    <span class="success">{{session()->get("success")}}</span>
                @endif
                <button class="button login__submit">
                    <span class="button__text">Uloguj se</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
            </form>
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
    </div>
</div>
</body>
