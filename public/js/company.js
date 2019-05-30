Vue.component('detailsalaries',{
    props: ['i'],
    template: `<div class="result">
                <div class="result-info">
                    <div class="result-data">
                        <div class="result-salary">
                            <a v-bind:href="'/company/salary/'+i.company_id">{{i.position}}</a>
                        </div>
                        <div class="result-name">
                            <a>{{i.name}}</a>
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

Vue.component('detailreviews',{
    props: ['i'],
    template: `<div class="result">
                <div class="rating-res">
                    <div class="result-data">
                        <div class="result-salary">
                            <a v-bind:href="'/company/review/'+i.company_id">{{i.position}}</a>
                        </div>
                        <div class="result-det">
                            <div class="result-detail">
                                {{i.avg}}/5
                            </div>&nbsp;
                        </div>
                    </div>
                    <hr>
                    <div class="result-slider">
                        <i class="fa fa-thumbs-o-up" style="color:green"></i>
                        {{i.positive_review}}
                        <br>
                        <i class="fa fa-thumbs-o-down" style="color:red"></i>
                        negative
                        {{i.negative_review}}
                    </div>
                    <hr>
                    <div class="result-rating">
                        <div class="result-rating-div">
                            <div class="result-rating-rate">
                                Salary: {{i.salary_rate}}/5
                            </div>
                            <div class="result-rating-rate">
                                Career: {{i.career_rate}}/5
                            </div>
                            <div class="result-rating-rate">
                                Management: {{i.management_rate}}/5
                            </div>
                        </div>
                        <div class="result-rating-div">
                            <div class="result-rating-rate">
                                Work-Life Balance : {{i.balance_rate}}/5
                            </div>
                            <div class="result-rating-rate">
                                Culture: {{i.culture_rate}}/5
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <button class="btn-green"  v-if="!i.helpful" v-bind:value="i.review_id" v-on:click="companyDetail.helpful">Helpful</button>
                        <button class="btn-yellow" v-if="i.helpful"  v-bind:value="i.review_id" v-on:click="companyDetail.delHelpful">Helpful</button>
                        <span>{{i.count}} find this helpful</span>
                        <div class="loading" v-if="companyDetail.helpful_loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
                    </div>
                </div>
            </div>`
});

Vue.component('detailjobs',{
    props: ['i'],
    template: `<div class="result">
                <div class="result-info">
                    <div class="result-data">
                        <div class="result-salary">
                            <a v-bind:href="'/company/salary/'+i.company_id">{{i.position.position}}</a>
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

Vue.component('detaillock',{
   template: `<div class="not-logged" v-if="header.loggedIn===0 && (companyDetail.curr=='review' || companyDetail.curr=='salary' || companyDetail.curr=='jobs')">
                <div class="not-logged-box">
                    Please  <a class="link" v-on:click="header.toggleLoginModal">login</a> if you want to see more.
                    You can <a class="link" v-on:click="header.toggleRegisterModal">register here</a> if you do not have an account
                </div>
            </div>`
});

var companyDetail = new Vue({
   el: '#company-detail',
   data:
       {
            company_name: "Verniy",
            curr: "profile",
            company: {
                country: 'z',
                industry: 'e',
                description: 'b',
                email: 'd',
                image: 'company_1.png',
                name: 'n',
                location: 'c',
                phone: 'e',
                website: 'a'
            },
           loading: false,
           salary: {
                'position': '',
                'average': 3,
                'max': 5,
                'min': 1
           },
           salaries: [],
           reviews: [],
           jobs: [],
           id: window.location.href.split('/')[5],
           followed: false,
           follow_loading: false,
           prev: false,
           next: false,
           next_link: '',
           prev_link: '',
           helpful_loading: false,
           idx: 0,
           requesting: false
       },
   created: function()
   {
      this.id=window.location.href.split('/')[5];
      $.ajax({
         type: 'GET',
         url: '/api/checkFollow',
         data: {
           'id': this.id,
           'user_id': header.loggedIn?header.user['user_id']:0
         },
         dataType: 'json',
         success: function(res)
         {
             companyDetail.followed=res["follow"];
         }
      });
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
           followCompany: function ()
           {
               if(!header.user)
               {
                   header.toggleLoginModal();
                   return;
               }
               companyDetail.follow_loading=true;
                $.ajax({
                    type: 'POST',
                    url: '/api/follow',
                    data: {
                        'id': this.id,
                        'user_id': header.loggedIn?header.user['user_id']:0
                    },
                    dataType: 'json',
                    success: function(res)
                    {
                        companyDetail.follow_loading=false;
                        companyDetail.followed=true;
                    }
                });
           },
           unfollowCompany: function()
           {
               if(!header.user)
               {
                   header.toggleLoginModal();
                   return;
               }
               companyDetail.follow_loading=true;
               $.ajax({
                   type: 'PATCH',
                   url: '/api/unfollow',
                   data: {
                       'id': this.id,
                       'user_id': header.loggedIn?header.user['user_id']:0
                   },
                   dataType: 'json',
                   success: function(res)
                   {
                       companyDetail.follow_loading=false;
                       companyDetail.followed=false;
                   }
               });
           },
           helpful: function(e)
           {
               if(!header.user)
               {
                   header.toggleLoginModal();
                   return;
               }
               companyDetail.helpful_loading=true;
               $.ajax({
                   type: 'POST',
                   url: '/api/helpful',
                   data: {
                       'id': e.srcElement.value,
                       'user_id': header.loggedIn?header.user['user_id']:0
                   },
                   dataType: 'json',
                   success: function(res)
                   {
                       var idx;
                       for(var i=0 ; i<companyDetail.reviews.length ; ++i)
                       {
                           if(companyDetail.reviews[i]['review_id']==e.srcElement.value)
                               idx=i;
                       }
                       companyDetail.helpful_loading=false;
                       companyDetail.reviews[idx]['helpful']=true;
                       companyDetail.reviews[idx]['count']++;
                   }
               });
           },
           delHelpful: function(e)
           {
               if(!header.user)
               {
                   header.toggleLoginModal();
                   return;
               }
               companyDetail.helpful_loading=true;
               $.ajax({
                   type: 'PATCH',
                   url: '/api/delHelpful',
                   data: {
                       'id': e.srcElement.value,
                       'user_id': header.loggedIn?header.user['user_id']:0
                   },
                   dataType: 'json',
                   success: function(res)
                   {
                       var idx;
                       for(var i=0 ; i<companyDetail.reviews.length ; ++i)
                       {
                           if(companyDetail.reviews[i]['review_id']==e.srcElement.value)
                               idx=i;
                       }
                       companyDetail.helpful_loading=false;
                       companyDetail.reviews[idx]['helpful']=false;
                       companyDetail.reviews[idx]['count']--;
                   }
               });
           },
           toggleProfile: function()
           {
                this.curr="profile";
                this.loading=true;
                $.ajax({
                   type: 'GET',
                   url: '/api/companyDetail/profile',
                   data: {
                       'id': companyDetail.id,
                       'user_id': header.user?header.user['user_id']:0
                   },
                   dataType: 'json',
                   success: function(response)
                   {
                       companyDetail.loading=false;
                       companyDetail.company=response['company'];
                       companyDetail.company['country']=response['country'];
                       companyDetail.company['city']=response['city'];
                       companyDetail.company['category']=response['category'];
                       companyDetail.company['location']+=', '+response['city']+', '+response['country'];
                   }
                });
           },
           toggleSalary: function()
           {
               this.loading=true;
               this.curr="salary";
               $.ajax({
                   type: 'GET',
                   url: '/api/companyDetail/salary',
                   data: {
                       'id': companyDetail.id,
                       'user_id': header.user?header.user['user_id']:0
                   },
                   dataType: 'json',
                   success: function (response) {
                       companyDetail.idx=0;
                       companyDetail.loading=false;
                       companyDetail.salaries=[];
                       companyDetail.next=true;
                       companyDetail.prev=false;
                        if(header.user)
                       {
                           companyDetail.salaries=response.data['data'];
                           companyDetail.next_link=response.data['next_page_url'];
                       }
                       else
                       {
                           for(var i=0 ; i<3 ; ++i)
                               companyDetail.salaries.push(response.data['data'][i]);
                           companyDetail.next_link=response.data['next_page_url'];
                           companyDetail.idx+=response.data['data'].length-3;
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
                   url: '/api/companyDetail/review',
                   data: {
                       'id': companyDetail.id,
                       'user_id': header.user?header.user['user_id']:0
                   },
                   dataType: 'json',
                   success: function (response) {
                       companyDetail.idx=0;
                       companyDetail.loading=false;
                       companyDetail.data=[];
                       companyDetail.next=true;
                       companyDetail.prev=false;
                       if(header.user)
                       {
                           companyDetail.reviews=response.data['data'];
                           companyDetail.next_link=response.data['next_page_url'];
                       }
                       else
                       {
                           for(var i=0 ; i<3 ; ++i)
                               companyDetail.reviews.push(response.data['data'][i]);
                           companyDetail.next_link=response.data['next_page_url'];
                           companyDetail.idx+=response.data['data'].length-3;
                       }
                   }
               });
           },
           toggleJobs: function()
           {
               if(companyDetail.requesting)
                   return;
               companyDetail.requesting=true;
               this.loading=true;
               this.curr="jobs";
               $.ajax({
                   type: 'GET',
                   url: '/api/companyDetail/jobs',
                   data: {
                       'id': companyDetail.id,
                       'user_id': header.user?header.user['user_id']:0
                   },
                   dataType: 'json',
                   success: function (response) {
                       companyDetail.idx=0;
                       companyDetail.loading=false;
                       companyDetail.jobs=[];
                       companyDetail.next=false;
                       companyDetail.prev=false;
                       companyDetail.requesting=false;
                       if(header.user)
                       {
                           companyDetail.jobs=response.data['data'];
                           companyDetail.next_link=response.data['next_page_url'];
                       }
                       else
                       {
                           for(var i=0 ; i<3 ; ++i)
                               companyDetail.jobs.push(response.data['data'][i]);
                           companyDetail.next_link=response.data['next_page_url'];
                           companyDetail.idx+=response.data['data'].length-3;
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
                if(companyDetail.requesting)
                   return;
                companyDetail.requesting=true;
                this.loading=true;
                $.ajax({
                   type: 'GET',
                   url: companyDetail.next_link,
                    data: {
                       'id': companyDetail.id,
                       'user_id': header.user?header.user['user_id']:0
                    },
                   dataType: 'json',
                   success: function(response)
                   {
                       companyDetail.requesting=false;
                       companyDetail.loading=false;
                       if(header.user)
                       {
                           if(response.data['data'][0]['job_id'])
                           {
                               for(var i=0 ; i<response.data['data'].length; ++i)
                               {
                                   companyDetail.jobs.push(response.data['data'][i]);
                               }
                               companyDetail.next_link=response.data['next_page_url'];
                           }
                           else
                           {
                               if(response.data['data'][0]['review_id'])
                               companyDetail.reviews=response.data['data'];
                               else if(response.data['data'][0]['salary_id'])
                               companyDetail.salaries=response.data['data'];

                               if(response.data['current_page']===1)
                               {
                                   companyDetail.next=true;
                                   companyDetail.prev=false;
                                   companyDetail.next_link=response.data['next_page_url'];
                               }
                               else if(response.data['current_page']===response.data['last_page'])
                               {
                                   companyDetail.next=false;
                                   companyDetail.prev=true;
                                   companyDetail.prev_link=response.data['prev_page_url'];
                               }
                               else
                               {
                                   companyDetail.next=true;
                                   companyDetail.prev=true;
                                   companyDetail.prev_link=response.data['prev_page_url'];
                                   companyDetail.next_link=response.data['next_page_url'];
                               }
                               companyDetail.toTop();
                           }
                       }
                       else
                       {
                           if(response.data['data'][0]['job_id'])
                           {
                               companyDetail.next_link=response.data['next_page_url'];
                               companyDetail.idx+=response.data['data'].length-3;
                           }
                           else
                           {
                               companyDetail.idx=0;
                               if(response.data['current_page']===1)
                               {
                                   for(var i=0 ; i<3 ; ++i)
                                   {
                                       companyDetail.companies.push(response.data['data'][i]);
                                       companyDetail.salaries.push(response.data['data'][i]);
                                       companyDetail.reviews.push(response.data['data'][i]);
                                   }

                                   companyDetail.next=true;
                                   companyDetail.prev=false;
                                   companyDetail.next_link=response.data['next_page_url'];
                                   companyDetail.idx+=response.data['data'].length-3;
                               }
                               else if(response.data['current_page']===response.data['last_page'])
                               {
                                   companyDetail.companies=[];
                                   companyDetail.salaries=[];
                                   companyDetail.reviews=[];

                                   companyDetail.next=false;
                                   companyDetail.prev=true;
                                   companyDetail.prev_link=response.data['prev_page_url'];
                                   companyDetail.idx+=response.data['data'].length;
                               }
                               else
                               {
                                   companyDetail.companies=[];
                                   companyDetail.salaries=[];
                                   companyDetail.reviews=[];

                                   companyDetail.next=true;
                                   companyDetail.prev=true;
                                   companyDetail.prev_link=response.data['prev_page_url'];
                                   companyDetail.next_link=response.data['next_page_url'];
                                   companyDetail.idx+=response.data['data'].length;
                               }
                               companyDetail.toTop();
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
                    url: companyDetail.prev_link,
                    data: {
                        'id': companyDetail.id,
                        'user_id': header.user?header.user['user_id']:0
                    },
                    dataType: 'json',
                    success: function(response)
                    {
                        companyDetail.requesting=false;
                        companyDetail.loading=false;
                        if(header.user)
                        {
                            if(response.data['data'][0]['job_id'])
                            {
                                for(var i=0 ; i<response.data['data'].length; ++i)
                                {
                                    companyDetail.jobs.push(response.data['data'][i]);
                                }
                                companyDetail.next_link=response.data['next_page_url'];
                            }
                            else
                            {
                                if(response.data['data'][0]['review_id'])
                                {
                                    companyDetail.reviews=response.data['data'];
                                }
                                else if(response.data['data'][0]['salary_id'])
                                {
                                    companyDetail.salaries=response.data['data'];
                                }

                                if(response.data['current_page']===1)
                                {
                                    companyDetail.next=true;
                                    companyDetail.prev=false;
                                    companyDetail.next_link=response.data['next_page_url'];
                                }
                                else if(response.data['current_page']===response.data['last_page'])
                                {
                                    companyDetail.next=false;
                                    companyDetail.prev=true;
                                    companyDetail.prev_link=response.data['prev_page_url'];
                                }
                                else
                                {
                                    companyDetail.next=true;
                                    companyDetail.prev=true;
                                    companyDetail.prev_link=response.data['prev_page_url'];
                                    companyDetail.next_link=response.data['next_page_url'];
                                }
                                companyDetail.toTop();
                            }
                        }
                        else
                        {
                            if(response.data['data'][0]['job_id'])
                            {
                                companyDetail.idx+=response.data['data'].length;
                                if(response.data['current_page']!=response.data['last_page'])
                                companyDetail.next_link=response.data['next_page_url'];
                            }
                            else
                            {
                                companyDetail.idx=0;
                                if(response.data['current_page']===1)
                                {
                                    for(var i=0 ; i<3 ; ++i)
                                    {
                                        companyDetail.companies.push(response.data['data'][i]);
                                        companyDetail.salaries.push(response.data['data'][i]);
                                        companyDetail.reviews.push(response.data['data'][i]);
                                    }
                                    companyDetail.next=true;
                                    companyDetail.prev=false;
                                    companyDetail.next_link=response.data['next_page_url'];
                                    companyDetail.idx+=response.data['data'].length-3;
                                }
                                else if(response.data['current_page']===response.data['last_page'])
                                {
                                    companyDetail.companies=[];
                                    companyDetail.salaries=[];
                                    companyDetail.reviews=[];

                                    companyDetail.next=false;
                                    companyDetail.prev=true;
                                    companyDetail.prev_link=response.data['prev_page_url'];
                                    companyDetail.idx+=response.data['data'].length;
                                }
                                else
                                {
                                    companyDetail.companies=[];
                                    companyDetail.salaries=[];
                                    companyDetail.reviews=[];

                                    companyDetail.next=true;
                                    companyDetail.prev=true;
                                    companyDetail.prev_link=response.data['prev_page_url'];
                                    companyDetail.next_link=response.data['next_page_url'];
                                    companyDetail.idx+=response.data['data'].length;
                                }
                                companyDetail.toTop();
                            }

                        }
                    }
                });
            }
       }
});