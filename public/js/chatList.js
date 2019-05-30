Vue.component('users',{
   props: ['i'],
   template: `<a v-bind:href="'/chat/'+i.user_id"><div class="user-list">
                <img v-bind:src="'/profile_picture/'+i.profile_picture" alt="" width="50px" height="50px">
                {{i.name}}
            </div></a>`
});

var chatList=new Vue({
   el: '#chat-list',
   data: {
       users: [],
       loading: false
   },
   methods:
   {
       getUserList: function()
       {
           chatList.loading=true;
           $.ajax({
               type: 'GET',
               url: '/api/getUser',
               dataType: 'json',
               success: function(response)
               {
                   chatList.loading=false;
                   chatList.users=response['users'];
               }
           });
       },
       chat : function(e)
       {

       }
   }
});
chatList.getUserList();