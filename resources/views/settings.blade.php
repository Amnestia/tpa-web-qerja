@extends("template.master")
@section("content")
<div id="settings">
    <div class="tab">
        <button id="profile" class="tab-button" v-on:click="toggleProfile" v-if="curr!='profile'">Profile</button>
        <button id="profile" class="tab-button-selected" v-if="curr=='profile'">Profile</button>
        <button id="salary"  class="tab-button" v-on:click="toggleFollow" v-if="curr!='follow'">Salary</button>
        <button id="salary"  class="tab-button-selected" v-if="curr=='follow'">Salary</button>
    </div>
    <div class="loading" v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
    <div class="profile" v-if="curr=='profile'">
        <div class="change-password">
            Change Password
            <form action="" method="POST">
                {{csrf_field()}}
                <span v-if="pass_invalid" class="error-tooltip">@{{password_error}}</span>
                <span v-if="success" class="success-tooltip">Password changed successfully</span>
                <br>
                Old Password&nbsp;<input id='oldPass' type="password" name="oldPass">
                <br>
                New Password&nbsp;<input id='newPass' type="password" name="newPass">
                <br>
                Confirm New Password&nbsp;<input id='conPass' type="password" name="password_confirmation">
                <br>
                <input class="btn-green" type="button" v-on:click="changePassword" value="Change password">
            </form>
        </div>
        <hr>
        <div class="user-image">
            {{csrf_field()}}
            <img id="newPict" alt="" width="50%" height="70%">
            <form id="profPict" action="" method="POST">
                {{csrf_field()}}
                Change profile picture
                <br>
                <input type="file" name="pict">
                <br>
            </form>
            <input class="btn-green" type="button" v-on:click="changePicture" value="Change">
        </div>
    </div>
    <div class="following" v-if="curr=='follow'">

    </div>
</div>
@endsection("content")