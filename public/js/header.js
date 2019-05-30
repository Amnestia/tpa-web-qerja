Vue.component('languages', {
    props: ['i'],
    template: `<a href=""><div class="dr-contents">{{i.lang}}</div></a>`
});


$(document).ready(function()
{
    $.ajax({
        type: "GET",
        url: "/checkLogin",
        success: function(result)
        {
            if(result["user"])
            {
                header.user=result["user"];
                header.loggedIn=header.user["role_id"];
            }
        }
    });
    setTimeout(function()
    {
        if(header.user)
        if(header.user['profile_picture'])
        {
            $('#newPict').attr('src',"/profile_picture/"+header.user['profile_picture']);
        }
        var curr=window.location.href.split('/');
        if(curr[3]==='settings')
        {
            $('#newPict').attr('src',"/profile_picture/"+header.user['profile_picture']);
        }
        else if(curr[3]==='searchList')
        {
            if(curr[4]==='company')
            {
                setTimeout(function(){
                    searchList.toggleCompany();
                },500);
            }
            else if(curr[4]==='salary')
            {
                setTimeout(function(){
                    searchList.toggleSalary();
                },500);
            }
            else if(curr[4]==='review')
            {
                setTimeout(function(){
                    searchList.toggleReview();
                },500);
            }
            else if(curr[4]==='jobs')
            {
                setTimeout(function(){
                    searchList.toggleJobs();
                },500);
            }
            else
            {
                window.history.back();
            }
        }
        else if(curr[3]==='company')
        {
            companyDetail.toggleProfile();
            if(curr[4]==='profile')
            {
            }
            else if(curr[4]==='salary')
            {
                companyDetail.toggleSalary();
            }
            else if(curr[4]==='review')
            {
                companyDetail.toggleReview();
            }
            else if(curr[4]==='jobs')
            {
                companyDetail.toggleJobs();
            }
            else
            {
                window.history.back();
            }
        }
        else if(curr[3]==='feeds')
        {
            feeds.loadFeeds();
        }
    },1000);
});

var header = new Vue(
{
    el: '#header-contents',
    data:
        {
            email_error: '',
            userDropdown: false,
            fail_login: 0,
            search: false,
            dropdownCond: false,
            loginModal: false,
            registerModal: false,
            successful: false,
            curr: 'INDONESIA (EN)',
            name_error: '',
            name_invalid: false,
            email_invalid: false,
            pass_error: '',
            pass_invalid: false,
            loggedIn: 0,
            successfully_registered: false,
            user: null,
            login_failed: false,
            loading: false,
            languages:
                [
                    {lang: 'Indonesia - Bahasa Indonesia'},
                    {lang: 'Indonesia - English'},
                    {lang: 'Malaysia -English'}
                ],
            login_error: "",
            resend_success: false,
            resend: "",
            resend_email: false
        },
    methods:
        {
            toggleSearchbar: function()
            {
                this.search=!this.search;
            },
            toggleDropdown: function()
            {
                this.dropdownCond=!this.dropdownCond;
            },
            toggleUserDropdown: function()
            {
                this.userDropdown=!this.userDropdown;
            },
            toggleLoginModal : function()
            {
                this.loginModal=!this.loginModal;
            },
            toggleRegisterModal: function()
            {
                this.registerModal=!this.registerModal;
            },
            removeAllWarnings: function()
            {
                header.login_failed=false;
                header.resend_email=false;
                header.resend_success=false;
                header.name_invalid=false;
                header.pass_invalid=false;
                header.email_invalid=false;
                header.successfully_registered=false;
            },
            closeModal: function()
            {
                var header = this;
                if(header.loginModal)
                    header.loginModal=!header.loginModal;
                else if(header.registerModal)
                    header.registerModal=!header.registerModal;
                else if(header.successful)
                    header.successful=!header.successful;
                else if(header.successfully_registered)
                    header.successfully_registered=!header.successfully_registered;
                header.removeAllWarnings();
                header.loading=false;
                header.userDropdown=false;
                header.dropdownCond=false;
            },
            register: function()
            {
                header.removeAllWarnings();
                header.loading=true;
                $.ajax({
                    type: "POST",
                    url: "/api/register",
                    data: {
                        name: $('#regis-name').val(),
                        email: $('#regis-email').val(),
                        password: $('#regis-pass').val(),
                        password_confirmation: $('#regis-conpass').val()
                    },
                    dataType: 'json',
                    success: function(result)
                    {
                        header.loading=false;
                        if(result["errors"])
                        {
                            var x=result["errors"];
                            if(x["name"])
                            {
                                header.name_invalid=true;
                                header.name_error=x["name"];
                            }
                            else
                                header.name_invalid=false;
                            if(x["email"])
                            {
                                header.email_invalid=true;
                                header.email_error=x["email"];
                            }
                            else
                                header.email_invalid=false;
                            if(x["password"])
                            {
                                    header.pass_invalid=true;
                                    header.pass_error=x["password"];
                            }
                            else
                                header.pass_invalid=false;
                        }
                        else
                        {
                            header.removeAllWarnings();
                            header.successfully_registered = true;
                        }
                    }
                });
            },
            login: function()
            {
                header.removeAllWarnings();
                header.loading=true;
                $.ajax({
                    type: "GET",
                    url: "/login",
                    data: {
                        email: $('#login-email').val(),
                        password: $('#login-pass').val(),
                        remember: $('#remember-me')[0].checked?1:0
                    },
                    dataType: 'json',
                    success: function(result)
                    {
                        header.loading=false;
                        if(result["errors"])
                        {
                            var x=result["errors"]
                            if(x["email"])
                            {
                                header.email_invalid=true;
                                header.email_error=x["email"];
                            }
                            else
                                header.email_invalid=false;
                            if(x["password"])
                            {
                                header.pass_invalid=true;
                                header.pass_error=x["password"];
                            }
                            else
                                header.pass_invalid=false;
                            return;
                        }
                        if(result["failed"])
                        {
                            header.fail_login+=1;
                            header.login_failed=true;
                            header.login_error=result["failed"];
                            if(result["user"])
                            {
                                header.user=result["user"];
                                header.resend_email=true;
                            }
                            return;
                        }
                        header.removeAllWarnings();
                        header.fail_login=0;
                        header.user=result["user"];
                        header.loggedIn=header.user["role_id"];
                        var curr=window.location.href.split('/');
                        curr=curr[0]+'//'+curr[2];
                        if(header.loggedIn==2)
                        window.location.href=curr+'/searchList/company';
                        else
                        window.location.href=curr+'/chatList';
                        header.closeModal();
                    },
                    error: function ()
                    {
                        header.fail_login+=1;
                    }
                });
            },
            logout: function()
            {
                header.page_loading=true;
                $.ajax({
                    type: "GET",
                    url: "/logout",
                    success: function(result)
                    {
                        header.page_loading=false;
                        header.loggedIn=0;
                        header.user=null;
                        var curr=window.location.href.split('/');
                        curr=curr[0]+'//'+curr[2];
                        window.location.href=curr;
                    }
                });
            },
            resendEmail: function()
            {
                header.loading=true;
                $.ajax({
                    type: "PATCH",
                    url: "/api/resendEmail",
                    data: {
                        id: header.user["user_id"],
                        email: header.user["email"]
                    },
                    dataType: 'json',
                    success: function(result)
                    {
                        header.loading=false;
                        header.login_failed=false;
                        header.resend_email=false;
                        if(result['success'])
                        {
                            header.resend_success=true;
                            header.resend=result['success'];
                            header.user=null;
                        }
                        header.closeModal();
                    }
                });
            },
            toSettings: function()
            {
                var curr=window.location.href.split('/');
                curr=curr[0]+'//'+curr[2];
                window.location.href=curr+'/settings';
            }
        }
});

$('body').click(function(e)
{
    if($(e.target).is('.modal') && !$(e.target).is('.button-header'))
       header.closeModal();
});
