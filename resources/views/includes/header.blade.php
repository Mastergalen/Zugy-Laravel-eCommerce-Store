<div class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <button type="button" class="navbar-toggle cart-icon" data-toggle="collapse" data-target="#navbar-cart">
                <i class="fa fa-shopping-cart"></i>
                <span class="cart-respons">{!! trans('menu.cart') !!} (<span class="cart-subtotal">{!! money_format("%i", Cart::total()) !!}</span>&#8364;)</span>
            </button>

            <button class="btn btn-default navbar-btn visible-xs navbar-toggle getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
            
            <a href="{!! localize_url('/') !!}">
                <img src="/img/zugy-navbar-logo.png"
                             style="display:inline; height:35px; float: left; margin: 8px 3px 0 0">
            </a>
        </div>

        <nav class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/"><i class="fa fa-home"></i> {!! trans('pages.home.title') !!}</a></li>
                <li class="dropdown mega-dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> {!! trans('menu.shop') !!}<b class="caret"></b></a>

                    <ul class="dropdown-menu mega-dropdown-menu row" role="menu">
                        @include('includes.mega-dropdown')
                    </ul>
                </li>
                <li><a href="{!! localize_url('routes.about-us') !!}">{!! trans('pages.about-us.title') !!}</a></li>
                <li><a href="{!! localize_url('routes.contact') !!}">{!! trans('pages.contact.title') !!}</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <p class="navbar-btn">
                        <button class="btn btn-default getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
                    </p>
                </li>
                <li class="hidden-xs cart-icon">
                    <a href="#" data-toggle="collapse" data-target="#navbar-cart">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="cart-respons">{!! trans('menu.cart') !!} (<span class="cart-subtotal">{!! money_format("%i", Cart::total()) !!}</span>&#8364;)</span>
                        <b class="caret"></b>
                    </a>
                </li>
                @if (!auth()->guest())
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="{!! localize_url('routes.account.settings') !!}"><i class="fa fa-user"></i> {!! trans('menu.my-account') !!} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @if(auth()->user()->isAdmin)
                                <li><a href="/admin"><i class="fa fa-dashboard"></i> {!! trans('menu.admin-dashboard') !!}</a></li>
                                <li class="divider" role="separator"></li>
                            @endif
                            <li><a href="{!! localize_url('routes.account.index') !!}"><i class="fa fa-user"></i> {!! trans('menu.my-account') !!}</a></li>
                            <li><a href="{!! localize_url('routes.account.settings') !!}"><i class="fa fa-cog"></i> {!! trans('menu.account-settings') !!}</a></li>
                            <li><a href="/auth/logout"><i class="fa fa-sign-out"></i> {!! trans('menu.sign-out') !!}</a></li>
                            <li class="divider" role="separator"></li>
                            <li class="dropdown-header">{!! auth()->user()->name !!}</li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{!! route('login') !!}"><i class="fa fa-sign-in"></i> {!! trans('menu.sign-in') !!}</a>
                    </li>
                    @foreach(Localization::getSupportedLocales() as $localeCode => $properties)
                        @if($localeCode == 'en') <?php $flagCode = 'gb' ?>
                        @else
                            <?php $flagCode = $localeCode ?>
                        @endif
                        <li class="language-selector">
                            <a href="{{Localization::getLocalizedURL($localeCode) }}"><span class="f32"><i class="flag {{$flagCode}}"></i></span></a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </nav><!--/.nav-collapse -->
        <!--Navbar cart-->
        <div id="navbar-cart" class="collapse" collapse="cartCollapsed">
            <div class="mega-dropdown ">
                @include('includes._mini-cart')
            </div>
        </div>

    </div>

    <div id="search-full" class="text-right">
        <a class="pull-right search-close" id="search-close"> <i class=" fa fa-times-circle"> </i> </a>
        <div class="search-input-box pull-right">
            <form id="search-form" method="GET" action="#">
                <input type="search" data-search-url="{!! localize_url('routes.search', ['query' => '']) !!}" name="q" placeholder="{!! trans('buttons.search.prompt') !!}" class="search-input">
                <button class="btn-nobg search-btn" type="submit"> <i class="fa fa-search"> </i> </button>
            </form>
        </div>
    </div>
</div><!--/Navigation Bar-->

<div class="container">
    <noscript><div class="alert" id="javascriptWarning">You need to enable Javascript in order to use this site.</div></noscript>
</div>