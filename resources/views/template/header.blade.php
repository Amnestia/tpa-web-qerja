<header>
    <nav>
        <div id="header-contents">
            <a href="/"><img src="{{asset('img/logo.png')}}"></a>
            <ul id="left-header-contents" v-if="!search">
                <li v-if="loggedIn!=1"><a href="/searchList/company">Company</a></li>
                <li v-if="loggedIn!=1"><a href="/searchList/salary">Salary</a></li>
                <li v-if="loggedIn!=1"><a href="/searchList/review">Review</a></li>
                <li v-if="loggedIn!=1"><a href="/searchList/jobs">Jobs</a></li>
                <li v-if="loggedIn==2"><a href="/feeds">Feeds</a></li>
                <li v-if="loggedIn==1"><a href="/chatList">Chat</a></li>
                <li v-if="loggedIn==2"><a href="/chat/1">Chat</a></li>
                <li v-if="loggedIn==1"><a href="/addCompany">Add Company</a></li>
            </ul>
            <div class="searchbar-div" v-if="search">
                <i class="fa fa-search searchbar-icon"></i>
                <input id="searchbar" type="text" placeholder="Search">
            </div>
            <ul id="right-header-contents">
                <button class="button-header" v-on:click="toggleSearchbar">
                    <li><i class="fa fa-search"></i></li>
                </button>
                <li class="dropdown-li">
                    <button id="dropdown" class="button-header"  v-on:click="toggleDropdown">
                        @{{curr}}<i class="fa fa-angle-down"></i>
                    </button>
                    <div class="dropdown-contents" v-if="dropdownCond">
                        <languages v-for="i in languages" v-bind:i="i"></languages>
                    </div>
                </li>
                <div class="log-reg" v-if="loggedIn==0">
                    <button id="login-button" class="button-header" v-on:click="toggleLoginModal"><li>Login</li></button>
                    <button id="register-button" class="button-header" v-on:click="toggleRegisterModal"><li>Register</li></button>
                </div>
                <div class="dropdown-li" v-if="loggedIn!=0">
                    <button id="dropdown" class="button-header"  v-on:click="toggleUserDropdown">
                        <img id="profile_pict" v-bind:src="'/profile_picture/'+user.profile_picture" alt="" width="50px" height="50px">
                        @{{user['name']}}
                    </button>
                    <div class="dropdown-contents-user" v-if="userDropdown">
                        <div class="dr-contents" v-on:click="toSettings">Settings</div>
                        <div class="dr-contents" v-on:click="logout">Logout</div>
                    </div>
                </div>
            </ul>
            <div class="modal" v-if="loginModal">
                <div class="modal-content">
                    <span class="close" v-on:click="closeModal">&times;</span>
                    <div class="modal-title">Login</div>
                    <form action="" method="post">
                        {{csrf_field()}}
                        <span class="error-tooltip" v-if="login_failed">@{{login_error}}</span>
                        <a class="link" v-on:click='resendEmail' v-if="resend_email">Click here to resend your verification email</a>
                        <span class="success-tooltip" v-if="resend_success">@{{resend}}</span>
                        <br>
                        <input id="login-email" class="field" type="text" name="email" placeholder="email">
                        <span class="error-tooltip" v-if="email_invalid">@{{email_error}}</span>
                        <br>
                        <input id="login-pass" class="field" type="password" name="password" placeholder="password">
                        <span class="error-tooltip" v-if="pass_invalid">@{{pass_error}}</span>
                        <br>
                        <input id="remember-me" type="checkbox" name="remember-me"><span class="form-content">Remember me</span>
                        <br>
                        <input class="modal-button" type="button" name="submit" value="Submit" v-on:click="login">
                        <span v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                    </form>
                </div>
            </div>
            <div class="modal" v-if="registerModal">
                <div class="modal-content">
                    <span class="close" v-on:click="closeModal">&times;</span>
                    <div class="modal-title">Register</div>
                    <form action="" method="post">
                        {{csrf_field()}}
                        <span class="success-tooltip" v-if="successfully_registered">Successfully registered, please check and verify your email.</span>
                        <br>
                        <input id="regis-name" class="field" type="text" name="name" placeholder="name">
                        <span class="error-tooltip" v-if="name_invalid">@{{name_error}}</span>
                        <br>
                        <input id="regis-email" class="field" type="text" name="email" placeholder="email">
                        <span class="error-tooltip" v-if="email_invalid">@{{email_error}}</span>
                        <br>
                        <input id="regis-pass" class="field" type="password" name="password" placeholder="password">
                        <span class="error-tooltip" v-if="pass_invalid">@{{pass_error}}</span>
                        <br>
                        <input id="regis-conpass" class="field" type="password" name="conpass" placeholder="Confirm password">
                        <br>
                        <input class="modal-button" type="button" name="submit" value="Submit" v-on:click="register">
                        <span v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </nav>
</header>