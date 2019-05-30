Vue.component('companies', {
    props: ['i'],
    template: `<div class="result">
                    <div class="result-info">
                        <img v-bind:src="'/img/'+i.image" alt="" width="60px" height="60px"/>
                        <div class="result-data">
                            <div class="result-name">
                                <a v-bind:href="'/company/profile/'+i.company_id">{{i.name}}</a>
                            </div>
                            <div>
                            
                            </div>
                            <div class="result-det">
                                <div class="result-rating">
                                    10/10
                                </div>
                                <div class="result-detail">
                                    <span class="result-detail-text">334</span> reviews
                                </div>
                                &nbsp;
                                <div class="result-detail">
                                    <span class="result-detail-text">474</span> salaries
                                </div>
                            </div>
                        </div>
                        <div class="result-edit">
                            <button id="add-salary" class="btn-green" v-on:click="searchList.addSalary">Add salary</button>
                            <button id="add-review" class="btn-green" v-on:click="searchList.addReview">Add review</button>
                            <button id="follow" class="btn-yellow" v-if="!i.followed" v-bind:value="i.company_id" v-on:click="searchList.followCompany">Follow</button>
                            <button id="unfollow" class="btn-yellow" v-if="i.followed" v-bind:value="i.company_id" v-on:click="searchList.unfollowCompany">Unfollow</button>
                            <div class="loading" v-if="searchList.follow_loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
                        </div>
                    </div>
                    <hr>
                    <div class="result-description">
                        {{i.description}}
                        <hr>
                        <a v-bind:href="'/company/profile/'+i.company_id">See company detail <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>`
});

Vue.component('salaries', {
    props: ['i'],
    template: `<div class="result">
                <div class="result-info">
                    <img v-bind:src="'/img/'+i.image" alt="" width="60px" height="60px"/>
                    <div class="result-data">
                        <div class="result-salary">
                            <a v-bind:href="'/company/salary/'+i.company_id">{{i.position}}</a>
                        </div>
                        <div class="result-name">
                            <a v-bind:href="'/company/profile/'+i.company_id">{{i.name}}</a>
                        </div>
                        <div class="result-det">
                            <div class="result-detail">
                                {{i.cnt}} salary data
                            </div>&nbsp;
                        </div>
                    </div>
                    <div class="avg-salary">
                        <div class="avg-salary-title">Avg. Salary</div>
                        <div class="avg-salary-am">{{i.avg}} {{i.currency}}</div>
                    </div>
                    <div class="result-slider">
                        <input type="range" max="'i.max'" min="'i.min'" value="@{{i.average}}" disabled="true" class="slider">
                        <div>{{i.min}} {{i.currency}} - {{i.max}} {{i.currency}}</div>
                    </div>
                </div>
            </div>`
});

Vue.component('reviews', {
    props: ['i'],
    template: `<div class="result">
                <div class="result-info">
                    <img v-bind:src="'/img/'+i.image" alt="" width="60px" height="60px"/>
                    <div class="result-data">
                        <div class="result-salary">
                            <a v-bind:href="'/company/review/'+i.company_id">{{i.position}}</a>
                        </div>
                        <div class="result-name">
                            <a v-bind:href="'/company/profile/'+i.company_id">{{i.name}}</a>
                        </div>
                        <div class="result-det">
                            <div class="result-detail">
                                {{i.cnt}} salary data
                            </div>&nbsp;
                        </div>
                    </div>                    
                    <div class="result-slider">
                    <i class="fa fa-thumbs-o-up" style="color:green"></i>
                        {{i.positive_review}}
                    </div>
                </div>
            </div>`
});

Vue.component('jobs', {
    props: ['i'],
    template: `<div class="result">
                <div class="result-info">
                    <img v-bind:src="'/img/'+i.position.company.image" alt="" width="60px" height="60px"/>
                    <div class="result-data">
                        <div class="result-salary">
                            <a v-bind:href="'/company/jobs/'+i.position.company_id">{{i.position.position}}</a>
                        </div>
                        <div class="result-name">
                            <a v-bind:href="'/company/profile/'+i.company_id">{{i.position.company.name}}</a>
                        </div>
                    </div>
                    <div class="result-slider">
                        Salary : {{i.salary}} {{i.currency.currency}}
                    </div>
                </div>
                <div class="result-description">
                    {{i.description}}
                    <hr>
                    <a v-bind:href="'/company/jobs/'+i.company_id">See company detail <i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>`
});

Vue.component('lock',{
   template: `<div class="not-logged" v-if="header.loggedIn===0">
                <div class="not-logged-box">
                    Please  <a class="link" v-on:click="header.toggleLoginModal">login</a> if you want to see more.
                    You can <a class="link" v-on:click="header.toggleRegisterModal">register here</a> if you do not have an account
                </div>
            </div>`
});

$(window).scroll(function(e){
    var curr=window.location.href.split('/');
   if((searchList.curr=="review" || searchList.curr=="salary" || searchList.curr=="jobs") && $(window).scrollTop()>=$(document).height()-$(window).height())
   {
       if(searchList.next_link)
       {
           searchList.toNext();
       }
   }
   else if(companyDetail.curr=="jobs" && $(window).scrollTop()>=$(document).height()-$(window).height())
   {
       if(companyDetail.next_link)
       {
           companyDetail.toNext();
       }
   }
   else if(curr[3]=='feeds' && $(window).scrollTop()>=$(document).height()-$(window).height())
   {
       if(feeds.curr_page<feeds.max_page)
       {
           feeds.toNext();
       }
   }
});

var searchList= new Vue({
    el: '#search-list',
    data:
        {
            curr: "company",
            result: [],
            company: {
                country: 'z',
                industry: 'e',
                description: 'b',
                email: 'd',
                name: 'n',
                location: 'c',
                phone: 'e',
                website: 'a',
                followed: false
            },
            prev: false,
            next: false,
            companies: [],
            loading: true,
            next_link: '',
            prev_link: '',
            follow_loading: false,
            salaries: [],
            salary: [],
            idx: 0,
            reviews: [],
            jobs: [],
            requesting: false
        },
    methods:
        {
            addSalary: function ()
            {
                window.location.href="/addSalary";
            },
            addReview: function ()
            {
                window.location.href="/addReview";
            },
            followCompany: function (e)
            {
                if(!header.user)
                {
                    header.toggleLoginModal();
                    return;
                }
                searchList.follow_loading=true;
                $.ajax({
                    type: 'POST',
                    url: '/api/follow',
                    data: {
                        'id': e.srcElement.value,
                        'user_id': header.loggedIn?header.user['user_id']:0
                    },
                    dataType: 'json',
                    success: function(res)
                    {
                        var idx;
                        for(var i=0 ; i<searchList.companies.length ; ++i)
                        {
                            if(searchList.companies[i]['company_id']==e.srcElement.value)
                                idx=i;
                        }
                        searchList.follow_loading=false;
                        searchList.companies[idx].followed=true;
                    }
                });
            },
            unfollowCompany: function(e)
            {
                if(!header.user)
                {
                    header.toggleLoginModal();
                    return;
                }
                searchList.follow_loading=true;
                $.ajax({
                    type: 'PATCH',
                    url: '/api/unfollow',
                    data: {
                        'id': e.srcElement.value,
                        'user_id': header.loggedIn?header.user['user_id']:0
                    },
                    dataType: 'json',
                    success: function(res)
                    {
                        var idx;
                        for(var i=0 ; i<searchList.companies.length ; ++i)
                        {
                            if(searchList.companies[i]['company_id']==e.srcElement.value)
                                idx=i;
                        }
                        searchList.follow_loading=false;
                        searchList.companies[idx].followed=false;
                    }
                });
            },
            toggleCompany: function()
            {
                this.loading=true;
                this.curr="company";
                $.ajax({
                   type: 'GET',
                   url: '/api/company',
                   data: {
                     'user_id': header.user?header.user['user_id']:0
                   },
                   dataType: 'json',
                   success: function (response) {
                       searchList.idx=0;
                       searchList.loading=false;
                       searchList.companies=[];
                       if(header.user)
                       {
                           searchList.companies=response.companies['data'];
                           if(response.companies['current_page']==1)
                           {
                               searchList.next=true;
                               searchList.prev=false;
                           }
                           searchList.next_link=response.companies['next_page_url'];
                       }
                       else
                       {
                           for(var i=0 ; i<3 ; ++i)
                           searchList.companies.push(response.companies['data'][i]);
                           if(response.companies['current_page']==1)
                           {
                               searchList.next=true;
                               searchList.prev=false;
                           }
                           searchList.next_link=response.companies['next_page_url'];
                           searchList.idx+=response.companies['data'].length;
                       }
                   }
                });
            },
            toggleSalary: function()
            {
                this.loading=true;
                this.curr="salary";
                $.ajax({
                    type: 'GET',
                    url: '/api/salary',
                    data: {
                        'user_id': header.user?header.user['user_id']:0
                    },
                    dataType: 'json',
                    success: function (response) {
                        searchList.idx=0;
                        searchList.loading=false;
                        searchList.salaries=[];
                        searchList.next=false;
                        searchList.prev=false;
                        if(header.user)
                        {
                            searchList.salaries=response.salaries['data'];
                            searchList.next_link=response.salaries['next_page_url'];
                        }
                        else
                        {
                            for(var i=0 ; i<3 ; ++i)
                                searchList.salaries.push(response.salaries['data'][i]);
                            searchList.next_link=response.salaries['next_page_url'];
                            searchList.idx+=response.salaries['data'].length;
                        }
                    }
                });
            },
            toggleReview: function()
            {
                this.loading=true;
                this.curr="review";
                $.ajax({
                    type: 'GET',
                    url: '/api/review',
                    data: {
                        'user_id': header.user?header.user['user_id']:0
                    },
                    dataType: 'json',
                    success: function (response) {
                        searchList.idx=0;
                        searchList.loading=false;
                        searchList.reviews=[];
                        searchList.next=false;
                        searchList.prev=false;
                        if(header.user)
                        {
                            searchList.reviews=response.reviews['data'];
                            searchList.next_link=response.reviews['next_page_url'];
                        }
                        else
                        {
                            for(var i=0 ; i<3 ; ++i)
                                searchList.reviews.push(response.reviews['data'][i]);
                            searchList.next_link=response.reviews['next_page_url'];
                            searchList.idx+=response.reviews['data'].length;
                        }
                    }
                });
            },
            toggleJobs: function()
            {
                this.loading=true;
                this.curr="jobs";
                $.ajax({
                    type: 'GET',
                    url: '/api/jobs',
                    data: {
                        'user_id': header.user?header.user['user_id']:0
                    },
                    dataType: 'json',
                    success: function (response) {
                        searchList.idx=0;
                        searchList.loading=false;
                        searchList.jobs=[];
                        searchList.next=false;
                        searchList.prev=false;
                        if(header.user)
                        {
                            searchList.jobs=response.jobs['data'];
                            searchList.next_link=response.jobs['next_page_url'];
                        }
                        else
                        {
                            for(var i=0 ; i<3 ; ++i)
                                searchList.jobs.push(response.jobs['data'][i]);
                            searchList.next_link=response.jobs['next_page_url'];
                            searchList.idx+=response.jobs['data'].length;
                        }
                    }
                });
            },
            toTop: function()
            {
                document.body.scrollTop=0;
                document.documentElement.scrollTop=0;
            },
            toNext: function()
            {
                if(searchList.requesting)
                   return;
                searchList.requesting=true;
                this.loading=true;
                $.ajax({
                   type: 'GET',
                   url: searchList.next_link,
                    data: {
                        'user_id': header.user?header.user['user_id']:0
                    },
                   dataType: 'json',
                   success: function(response)
                   {
                       console.log(response);
                       searchList.requesting=false;
                       searchList.loading=false;
                       if(header.user)
                       {
                           if(response.companies)
                           {
                               searchList.companies=response.companies['data'];
                               if(response.companies['current_page']==1)
                               {
                                   for(var i=0 ; i<3 ; ++i)
                                       searchList.reviews.push(response.reviews['data'][i]);
                                   searchList.next=true;
                                   searchList.prev=false;
                                   searchList.next_link=response.companies['next_page_url'];
                               }
                               else if(response.companies['current_page']==response.companies['last_page'])
                               {
                                   searchList.next=false;
                                   searchList.prev=true;
                                   searchList.prev_link=response.companies['prev_page_url'];
                               }
                               else
                               {
                                   searchList.next=true;
                                   searchList.prev=true;
                                   searchList.prev_link=response.companies['prev_page_url'];
                                   searchList.next_link=response.companies['next_page_url'];
                               }
                               searchList.toTop();
                           }
                           else if(response.salaries)
                           {
                               for(var i=0 ; i<response.salaries['data'].length; ++i)
                               {
                                   searchList.salaries.push(response.salaries['data'][i]);
                               }
                               searchList.next_link=response.salaries['next_page_url'];
                           }
                           else if(response.reviews)
                           {
                               for(var i=0 ; i<response.reviews['data'].length; ++i)
                               {
                                   searchList.reviews.push(response.reviews['data'][i]);
                               }
                               searchList.next_link=response.reviews['next_page_url'];
                           }
                           else if(response.jobs)
                           {
                               for(var i=0 ; i<response.jobs['data'].length; ++i)
                               {
                                   searchList.jobs.push(response.jobs['data'][i]);
                               }
                               searchList.next_link=response.jobs['next_page_url'];
                           }
                       }
                       else
                       {
                           if(response.companies)
                           {
                               if(response.companies['current_page']==1)
                               {
                                   for(var i=0 ; i<3 ; ++i)
                                   searchList.companies.push(response.companies['data'][i]);
                                   searchList.next=true;
                                   searchList.prev=false;
                                   searchList.next_link=response.companies['next_page_url'];
                               }
                               else if(response.companies['current_page']==response.companies['last_page'])
                               {
                                   searchList.companies=[];
                                   searchList.next=false;
                                   searchList.prev=true;
                                   searchList.prev_link=response.companies['prev_page_url'];
                               }
                               else
                               {
                                   searchList.companies=[];
                                   searchList.next=true;
                                   searchList.prev=true;
                                   searchList.prev_link=response.companies['prev_page_url'];
                                   searchList.next_link=response.companies['next_page_url'];
                               }
                               searchList.idx=0;
                               searchList.idx+=response.companies['data'].length;
                               searchList.toTop();
                           }
                           else if(response.salaries)
                           {
                               console.log("asd");
                               searchList.idx+=response.salaries['data'].length;
                               searchList.next_link=response.salaries['next_page_url'];
                           }
                           else if(response.reviews)
                           {
                               searchList.idx+=response.reviews['data'].length;
                               searchList.next_link=response.reviews['next_page_url'];
                           }
                           else if(response.jobs)
                           {
                               searchList.idx+=response.jobs['data'].length;
                               searchList.next_link=response.jobs['next_page_url'];
                           }
                       }
                   }
                });
            },
            toPrev: function()
            {
                this.loading=true;
                $.ajax({
                    type: 'GET',
                    url: searchList.prev_link,
                    data: {
                        'user_id': header.user?header.user['user_id']:0
                    },
                    dataType: 'json',
                    success: function(response)
                    {
                        searchList.requesting=false;
                        searchList.loading=false;
                        if(header.user)
                        {
                            if(response.companies)
                            {
                                searchList.companies=response.companies['data'];
                                if(response.companies['current_page']==1)
                                {
                                    for(var i=0 ; i<3 ; ++i)
                                        searchList.reviews.push(response.reviews['data'][i]);
                                    searchList.next=true;
                                    searchList.prev=false;
                                    searchList.next_link=response.companies['next_page_url'];
                                }
                                else if(response.companies['current_page']==response.companies['last_page'])
                                {
                                    searchList.next=false;
                                    searchList.prev=true;
                                    searchList.prev_link=response.companies['prev_page_url'];
                                }
                                else
                                {
                                    searchList.next=true;
                                    searchList.prev=true;
                                    searchList.prev_link=response.companies['prev_page_url'];
                                    searchList.next_link=response.companies['next_page_url'];
                                }
                                searchList.toTop();
                            }
                            else if(response.salaries)
                            {
                                for(var i=0 ; i<response.salaries['data'].length; ++i)
                                {
                                    searchList.salaries.push(response.salaries['data'][i]);
                                }
                                searchList.next_link=response.salaries['next_page_url'];
                            }
                            else if(response.reviews)
                            {
                                for(var i=0 ; i<response.reviews['data'].length; ++i)
                                {
                                    searchList.reviews.push(response.reviews['data'][i]);
                                }
                                searchList.next_link=response.reviews['next_page_url'];
                            }
                            else if(response.jobs)
                            {
                                for(var i=0 ; i<response.jobs['data'].length; ++i)
                                {
                                    searchList.jobs.push(response.jobs['data'][i]);
                                }
                                searchList.next_link=response.jobs['next_page_url'];
                            }
                        }
                        else
                        {
                            if(response.companies)
                            {
                                if(response.companies['current_page']==1)
                                {
                                    for(var i=0 ; i<3 ; ++i)
                                        searchList.companies.push(response.companies['data'][i]);
                                    searchList.next=true;
                                    searchList.prev=false;
                                    searchList.next_link=response.companies['next_page_url'];
                                }
                                else if(response.companies['current_page']==response.companies['last_page'])
                                {
                                    searchList.companies=[];
                                    searchList.next=false;
                                    searchList.prev=true;
                                    searchList.prev_link=response.companies['prev_page_url'];
                                }
                                else
                                {
                                    searchList.companies=[];
                                    searchList.next=true;
                                    searchList.prev=true;
                                    searchList.prev_link=response.companies['prev_page_url'];
                                    searchList.next_link=response.companies['next_page_url'];
                                }
                                searchList.idx=0;
                                searchList.idx+=response.companies['data'].length;
                                searchList.toTop();
                            }
                            else if(response.salaries)
                            {
                                searchList.idx+=response.salaries['data'].length;
                            }
                            else if(response.reviews)
                            {
                                searchList.idx+=response.reviews['data'].length;
                            }
                            else if(response.jobs)
                            {
                                searchList.idx+=response.jobs['data'].length;
                            }
                        }
                    }
                });
            }
        }
});