@extends("template.master")
@section("content")
<div id="feeds">
    <div class="page-title">Feeds</div>
    <hr>
    <feeds v-for="i in feed_data" v-bind:i="i"></feeds>
    <div v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
</div>
@endsection("content")