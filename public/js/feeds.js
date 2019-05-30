Vue.component('feeds',{
   props: ['i'],
   template: `
            <div class="result" v-if="i.isA=='salary'">
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
            </div>
            <div class="result" v-if="i.isA=='review">
                <div class="rating-res">
                    <div class="result-data">
                        <div class="result-salary">
                            <a v-bind:href="'/company/review/'+i.company_id">{{i.position}}</a>
                        </div>
                        <div class="result-name">
                            <a v-bind:href="'/company/profile/'+i.company_id">{{i.name}}</a>
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
            </div>
            <div class="result" v-if="i.isA=='jobs'">
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

var feeds= new Vue({
    el: '#feeds',
    data: {
        loading: false,
        curr_page: 1,
        max_page: 0,
        feed_data: [],
        requesting: false
    },
    methods: {
        loadFeeds: function()
        {
            feeds.curr_page=1;
            feeds.loading=true;
            $.ajax({
                type: 'GET',
                url: '/api/getFeeds',
                data: {
                   'currPage': feeds.curr_page,
                   'user_id': header.loggedIn?header.user['user_id']:0
                },
                dataType: 'json',
                success: function(response)
                {
                    console.log(response.data);
                    feeds.loading=false;
                    feeds.max_page=Math.floor(response['max_page']);
                    feeds.feed_data=response['data'];
                }
            });
        },
        toNext: function()
        {
            if(feeds.requesting)
                return;
            feeds.requesting=true;
            feeds.curr_page+=1;
            feeds.loading=true;
            console.log(feeds.curr_page);
            $.ajax({
                type: 'GET',
                url: '/api/getFeeds',
                data: {
                    'currPage': feeds.curr_page,
                    'user_id': header.loggedIn?header.user['user_id']:0
                },
                dataType: 'json',
                success: function(response)
                {
                    for(var i in response['data'])
                    {
                        feeds.feed_data.push(response['data'][i]);
                    }
                    feeds.requesting=false;
                    feeds.loading=false;
                }
            });
        }
    }
});