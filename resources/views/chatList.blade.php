@extends("template.master")
@section("content")
<div id="chat-list">
    <span v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></span>
    <users v-for="i in users" v-bind:i="i"></users>
</div>
@endsection("content")