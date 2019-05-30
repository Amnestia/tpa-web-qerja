Vue.component('chats',{
   props: ['i'],
   template: `<div class="chat-message">
                <div class="sender">{{i.sender}}: &nbsp;</div>
                <div class="message">{{i.message}}</div>
            </div>`
});

function main()
{
    chat.loading=true;
    firebase.database().ref().on('value',function(snap)
    {
        if(!header.user)
        return;
        chat.loading=false;
        var data=snap.val();
        var arr=[];
        for(var i in data)
        {
            if(header.user['user_id']===1)
            {
                if((data[i]['from']===1 && data[i]['to']===chat.id) || (data[i]['from']===chat.id && data[i]['to']===1))
                {
                    arr.push(data[i]);
                }
            }
            else
            {
                if((data[i]['from']===header.user['user_id'] && data[i]['to']===1) || (data[i]['from']===1 && data[i]['to']===header.user['user_id']))
                {
                    arr.push(data[i]);
                }
            }
        }
        chat.chats=arr;
    });
}

var chat=new Vue({
   el: '#chat',
   data: {
       chats: [],
       loading: false,
       id: 0
   },
   created: function()
   {
       this.id=parseInt(window.location.href.split('/')[4]);
   },
   methods: {
       sendMessage: function()
       {
           chat.loading=true;
           var message=$('#message').val();
           var data=[];
           data['sender']=header.user['name'];
           if(header.user['role_id']==1)
           {
               data['to']=parseInt(chat.id);
               data['from']=1;
           }
           else
           {
               data['from']=header.user['user_id'];
               data['to']=1;
           }
           data['message']=message;
           firebase.database().ref().push(data);
       }
   }
});
main();