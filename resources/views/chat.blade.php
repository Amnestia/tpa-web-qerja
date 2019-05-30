@extends("template.master")
@section("content")
<div id="chat">
    <div class="chatbox">
        <div class="chats">
            <chats v-for="i in chats" v-bind:i="i"></chats>
        </div>
    </div>
    <span v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></span>
    <div class="input">
        <input id="message" type="text" placeholder="Message"><br/>
        <button id="post" class="btn-green" v-on:click="sendMessage">Send</button><br/>
    </div>
</div>
@endsection("content")