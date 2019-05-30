@extends("template.master")
@section("content")
<div id="company-detail">
    <div class="company-info">
        <img v-bind:src="'/img/'+company.image" alt="" width="60px" height="60px">
        <div class="logo">
            <div class="company-data">
                <div class="company-name">
                    @{{company['name']}}
                </div>
                <div class="company-rate">
                    10/10
                </div>
            </div>
        </div>
        <div class="company-edit">
            <button id="add-salary" class="btn-green" v-on:click="addSalary">Add salary</button>
            <button id="add-review" class="btn-green" v-on:click="addReview">Add review</button>
            <button id="follow" class="btn-yellow" v-if="!followed" v-on:click="followCompany">Follow</button>
            <button id="unfollow" class="btn-yellow" v-if="followed" v-on:click="unfollowCompany">Unfollow</button>
            <div class="loading" v-if="follow_loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
        </div>
    </div>
    <div class="tab">
        <button id="profile" class="tab-button" v-on:click="toggleProfile" v-if="curr!='profile'">Profile</button>
        <button id="profile" class="tab-button-selected" v-if="curr=='profile'">Profile</button>
        <button id="salary"  class="tab-button" v-on:click="toggleSalary" v-if="curr!='salary'">Salary</button>
        <button id="salary"  class="tab-button-selected" v-if="curr=='salary'">Salary</button>
        <button id="review"  class="tab-button" v-on:click="toggleReview" v-if="curr!='review'">Review</button>
        <button id="review"  class="tab-button-selected" v-if="curr=='review'">Review</button>
        <button id="jobs"    class="tab-button" v-on:click="toggleJobs" v-if="curr!='jobs'">Jobs</button>
        <button id="jobs"    class="tab-button-selected" v-if="curr=='jobs'">Jobs</button>
    </div>
    <div class="info">
        <div class="profile" v-if="curr=='profile'">
            <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
            <div class="company-profile-title">
                <div class="company-profile">Country: @{{company['country']}}</div>
            <div class="company-profile">Industry: @{{company['category']}}</div>
            </div>
            <hr>
            <div class="company-description">
                <div class="company-description-title">
                    Description
                </div>
                <div class="company-description">
                    @{{company['description']}}
                </div>
            </div>
            <hr>
            <div class="company-contact">
                <div class="company-contact-div">
                    <div class="company-contact-title">
                        Location
                    </div>
                    <div class="company-contact-data">
                        @{{company['location']}}
                    </div>
                </div>
                <div class="company-contact-div">
                    <div class="company-contact-title">
                        Email
                    </div>
                    <div class="company-contact-data">
                        @{{company['email']}}
                    </div>
                </div>
                <div class="company-contact-div">
                    <div class="company-contact-title">
                        Phone
                    </div>
                    <div class="company-contact-data">
                        @{{company['phone']}}
                    </div>
                </div>
                <div class="company-contact-div">
                    <div class="company-contact-title">
                        Website
                    </div>
                    <div class="company-contact-data">
                        @{{company['website']}}
                    </div>
                </div>
            </div>
        </div>
        <div class="salary" v-if="curr==='salary'">
            <detailsalaries v-for="i in salaries" v-bind:i="i"></detailsalaries>
            <detaillock v-for="i in idx"></detaillock>
            <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
        </div>
        <div class="review" v-if="curr=='review'">
            <detailreviews v-for="i in reviews" v-bind:i="i"></detailreviews>
            <detaillock v-for="i in idx"></detaillock>
            <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
        </div>
        <div class="jobs" v-if="curr=='jobs'">
            <detailjobs v-for="i in jobs" v-bind:i="i"></detailjobs>
            <detaillock v-for="i in idx"></detaillock>
            <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
        </div>
        <div class="pagination-div" v-if="curr!='profile'">
            <button class="pagination-btn btn-green next-btn" v-if="prev" v-on:click="toPrev">Previous page</button>
            <button class="pagination-btn btn-green prev-btn" v-if="next" v-on:click="toNext">Next page</button>
        </div>
    </div>
</div>
@endsection("content")