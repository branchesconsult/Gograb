<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="{!! asset('frontend/images/Symbol-1-2@2x.png') !!}" width="148" height="48"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                {{ renderMenuItems(getMenuItems('frontend', 2)) }}
            </ul>
            @if(!\Auth::check())
                <button
                        class="btn btn-outline-success my-2 my-sm-0"
                        data-toggle="modal"
                        data-target="#login"
                        type="submit">
                    Login
                </button>
                <button class="btn btn-outline-success my-2 my-sm-0 active" data-toggle="modal" data-target="#signup"
                        type="submit">Signup
                </button>
            @endif
            @if(\Auth::check())
            <!--User avatar-->
                <div class="dropdown">
                    <a class="prof-pic dropdown-toggle" href="#" role="button" id="prof-pic" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <img src="{!! asset('frontend/images/alleanza_albania_-8@2x.png') !!}"/>
                        <span></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="prof-pic">
                        {{ link_to_route('frontend.user.account', 'Profie', [], ['class' => 'dropdown-item']) }}
                        {{ link_to_route('frontend.auth.logout', 'Logout', [], ['class' => 'dropdown-item']) }}
                    </div>
                </div>
                <!--Messages-->
                <div class="dropdown massage">
                    <a class="top-massage dropdown-toggle" href="#" role="button" id="top-massage"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-comments"></i><span></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="top-massage">
                        <a class="dropdown-item" href="#">
                            <img src="images/alleanza_albania_-8@2x.png"/>
                            <h4>Jhon Doe</h4>
                            <p>Can You Please Tell me is there any..</p>
                            <span>3 Months ago</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <img src="images/alleanza_albania_-8@2x.png"/>
                            <h4>Jhon Doe</h4>
                            <p>Can You Please Tell me is there any..</p>
                            <span>3 Months ago</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <img src="images/alleanza_albania_-8@2x.png"/>
                            <h4>Jhon Doe</h4>
                            <p>Can You Please Tell me is there any..</p>
                            <span>3 Months ago</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <img src="images/alleanza_albania_-8@2x.png"/>
                            <h4>Jhon Doe</h4>
                            <p>Can You Please Tell me is there any..</p>
                            <span>3 Months ago</span>
                        </a>
                    </div>
                </div>
                <!--Notifications-->
                <div class="dropdown notify">
                    <a class="top-notify dropdown-toggle" href="#" role="button" id="top-notify"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i><span></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="top-notify">
                        <a class="dropdown-item" href="#">
                            <img src="images/alleanza_albania_-8@2x.png"/>
                            <h4>Jhon Doe</h4>
                            <p>Can You Please Tell me is there any..</p>
                            <span>3 Months ago</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <img src="images/alleanza_albania_-8@2x.png"/>
                            <h4>Jhon Doe</h4>
                            <p>Can You Please Tell me is there any..</p>
                            <span>3 Months ago</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <img src="images/alleanza_albania_-8@2x.png"/>
                            <h4>Jhon Doe</h4>
                            <p>Can You Please Tell me is there any..</p>
                            <span>3 Months ago</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <img src="images/alleanza_albania_-8@2x.png"/>
                            <h4>Jhon Doe</h4>
                            <p>Can You Please Tell me is there any..</p>
                            <span>3 Months ago</span>
                        </a>
                    </div>
                </div>
                <!--btn verify-->
            @endif
            @if(\Auth::check() && \Auth::user()->confirmed == 0)
                <button class="btn btn-outline-success my-2 my-sm-0 active" data-toggle="modal"
                        data-target="#varify"
                        type="submit">Varify
                </button>
        @endif
        <!--Cart-->
            <div class="dropdown">
                <a class="top-cart dropdown-toggle"
                   href="#"
                   role="button"
                   id="cart-dd"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-shopping-cart"></i>
                    <span>{!! Cart::count() !!}</span>
                </a>
            </div>
        </div>
    </nav>
</header>