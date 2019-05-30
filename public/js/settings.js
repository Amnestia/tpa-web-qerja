var settings = new Vue({
    el: '#settings',
    data: {
        loading: false,
        curr: 'profile',
        pass_invalid: false,
        image_invalid: false,
        password_error: [],
        image_error: [],
        success: false
    },
    created: function()
    {
        setTimeout(function()
        {
            if(header.user)
            {
                if(header.user['profile_picture'])
                    $('#newPict').attr('src',"/profile_picture/"+header.user['profile_picture']);
            }
        },500);
    },
    methods:{
        toggleProfile: function()
        {
            settings.curr='profile';
        },
        toggleFollow: function()
        {
            settings.curr="follow";
        },
        changePassword: function()
        {
            settings.loading=true;
            $.ajax({
               type: "POST",
               url: "/api/changePassword",
               data: {
                   'oldPass': $('#oldPass').val(),
                   'newPass': $('#newPass').val(),
                   'conPass': $('#conPass').val(),
                   'id': header.user['user_id']
               },
               dataType: "json",
               success: function(response)
               {
                   settings.loading=false;
                   if(response['errors'])
                   {
                       settings.success=false;
                       settings.pass_invalid=true;
                       settings.password_error=response['errors'];
                   }
                   else
                   {
                       settings.pass_invalid=false;
                       settings.success=true;
                   }
               }
            });
        },
        changePicture: function()
        {
            var formData=new FormData($('#profPict')[0]);
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "/changePicture",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response)
                {
                    settings.loading=false;
                    header.user=response['user'];
                    $('#newPict').attr('src',"/profile_picture/"+header.user['profile_picture']);
                }
            });
        }


    }
});