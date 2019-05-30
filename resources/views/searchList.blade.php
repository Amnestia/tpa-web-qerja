@extends("template.master")
@section("content")
<div id="search-list">
    <div class="tab">
        <button id="company-tab" class="tab-button" v-on:click="toggleCompany" v-if="curr!='company'">Company</button>
        <button id="company-tab" class="tab-button-selected" v-if="curr=='company'">Company</button>
        <button id="salary"  class="tab-button" v-on:click="toggleSalary" v-if="curr!='salary'">Salary</button>
        <button id="salary"  class="tab-button-selected" v-if="curr=='salary'">Salary</button>
        <button id="review"  class="tab-button" v-on:click="toggleReview" v-if="curr!='review'">Review</button>
        <button id="review"  class="tab-button-selected" v-if="curr=='review'">Review</button>
        <button id="jobs"    class="tab-button" v-on:click="toggleJobs" v-if="curr!='jobs'">Jobs</button>
        <button id="jobs"    class="tab-button-selected" v-if="curr=='jobs'">Jobs</button>
    </div>
    <div id="search-res">
        <div id="filter">
            <div class="search-title">Filter</div>
            <hr>
            <div class="filter-input">Keyword</div>
            <input type="text">
            <div class="filter-input">Industry</div>
            <input type="text">
            <button class="btn-green">Search</button>
        </div>
        <div id="list" v-if="">
            <div class="company" v-if="curr=='company'">
                <div class="search-title">Company</div>
                <hr>
                <companies v-if="!loading" v-for="i in companies" v-bind:i="i"></companies>
                <lock v-for="i in idx"></lock>
                <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
            </div>
            <div v-if="curr=='salary'">
                <div class="search-title">Salary</div>
                <hr>
                <salaries v-for="i in salaries" v-bind:i="i"></salaries>
                <lock v-for="i in idx"></lock>
                <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
            </div>
            <div v-if="curr=='review'">
                <div class="search-title">Review</div>
                <hr>
                <reviews v-for="i in reviews" v-bind:i="i"></reviews>
                <lock v-for="i in idx"></lock>
                <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
            </div>
            <div v-if="curr=='jobs'">
                <div class="search-title">Jobs</div>
                <hr>
                <jobs v-for="i in jobs" v-bind:i="i"></jobs>
                <lock v-for="i in idx"></lock>
                <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
            </div>
            <div class="pagination-div">
                <button class="pagination-btn btn-green next-btn" v-if="prev" v-on:click="toPrev">Previous page</button>
                <button class="pagination-btn btn-green prev-btn" v-if="next" v-on:click="toNext">Next page</button>
            </div>
        </div>
    </div>
</div>
@endsection("content")