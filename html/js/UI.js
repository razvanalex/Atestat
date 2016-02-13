(function worker() {
    
    var rows = $('#myTable tr');
    var cols = $('#myTable td');
    var colsN = cols.length / rows.length;
    var table = document.getElementById('myTable');
    
    var ID = [];
    var Username = [];
    var FirstName = [];
    var LastName = [];
    var Email = [];
    var DateOfBirth = [];
    var Password = [];

    for(var i = 0; i < rows.length; i++){
        ID[i] = $(table.rows[i].cells[0]).text();
        Username[i] = $(table.rows[i].cells[1]).text();
        FirstName[i] = $(table.rows[i].cells[2]).text();
        LastName[i] = $(table.rows[i].cells[3]).text();        
        Email[i] = $(table.rows[i].cells[4]).text();
        DateOfBirth[i] = $(table.rows[i].cells[5]).text();
        Password[i] = $(table.rows[i].cells[6]).text();
    }

    $.ajax({
        method:'POST',    
        url: "../ajax/Edit.php",
        data:{
            action:"UPDATE",
            "Id":ID,
            "Username":Username,
            "FirstName":FirstName,
            "LastName":LastName,
            "Email":Email,
            "DateOfBirth":DateOfBirth,
            "Password":Password
        },
        success: function(data) {
            table = document.getElementById('myTable');
            $.getJSON( "../json/Update_Data.json", function(Users) {
                for(var i=0; i<data; i++){
                    $(table.rows[i].cells[0]).html(Users[i].ID);
                    $(table.rows[i].cells[1]).html(Users[i].Username);
                    $(table.rows[i].cells[2]).html(Users[i].FirstName);        
                    $(table.rows[i].cells[3]).html(Users[i].LastName);
                    $(table.rows[i].cells[4]).html(Users[i].Email);
                    $(table.rows[i].cells[5]).html(Users[i].DateOfBirth);
                    $(table.rows[i].cells[6]).html(Users[i].Password);
                }
            });
        },
        error: function(err){
            console.log(err);
        },
        complete: function() {
            setTimeout(worker, 5000);
        }
    });
})();

function YesNoBtn(temp){
    $('.Delete').removeClass('NOTvisible');
    var scrollTop = ($('html').scrollTop()) ? $('html').scrollTop() : $('body').scrollTop();
    $('body').css('top', -scrollTop).addClass('noscroll');
    
    $.ajax({
        url: '../ajax/Edit.php',
        method: 'POST',
        data:{
            action: 'GET_ID',
            "ID":temp
        },
        success:function(){
            
        }
    });
    
    $('#user').text(temp);
    $('.yes').click(function(){
        if(temp!=null) YES(temp);
        temp=null;
    });
    $('.no').click(function(){
        if(temp!=null) NO();
        temp=null; 
    });
}

function YES(temp){
    var scrollTop = ($('html').scrollTop()) ? $('html').scrollTop() : $('body').scrollTop();
     
    $('.Panel').addClass('NOTvisible');
    $('body').css('top', -scrollTop).removeClass('noscroll');
    myAjax(temp);
}

function NO(){
    var scrollTop = ($('html').scrollTop()) ? $('html').scrollTop() : $('body').scrollTop();
    
    $('.Panel').addClass('NOTvisible');
    $('body').css('top', -scrollTop).removeClass('noscroll');
}

function ArrangeID(){
    $.ajax({
        url: '../ajax/ArrangeID.php',
        method: 'POST',
        dataType: 'html',
        data:{
            ArrangeID: 'yes'
        },
        success:function(){}
    });
}

function myAjax(temp) {
    $.ajax({
      url: "../ajax/ajax.php",
      method: "POST",
      data: {   
            action:'call', 
            username_temp:temp
          },
      dataType: "html",
      success: function(id) { 
        var row = id-1;
        for(var i = id; i <= document.getElementById("myTable").rows.length; i++){
            $("#"+i).html(i-1);
            $("#"+i).attr('id', (i-1));
        }
        document.getElementById("myTable").deleteRow(row);
        ArrangeID();
      }
    });
    $('.Panel').toggleClass('visible');
 }

function Edit(temp){
    $.ajax({
        method: "POST",
        url: "../ajax/Edit.php",
        data: {   
                action:'GET',
                username_temp:temp,
            },
        success: function() {
            $.getJSON( "../json/Edit_Data.json", function(User) { 
                $('#FirstName').val(User.FirstName);
                $('#LastName').val(User.LastName);
                $('#Username').val(User.Username);
                $('#Email').val(User.Email);
                $('#DateOfBirth').val(User.DateOfBirth);
            });
        },
        error: function(err){
            console.log(err);
        }
    });
    
    $('.Edit').removeClass('NOTvisible');
    $('#Cancel').click(function(){
        $('.Edit').addClass('NOTvisible');
    }); 
    $('#Save').click(function(){
        Save(temp);
    });
}

function Save(temp){
    $.ajax({
        url: "../ajax/Edit.php",
        method: "POST",
        data: {   
            action:'SET', 
            oldUsername:temp,
            Username:$('#Username').val(),
            FirstName:$('#FirstName').val(),
            LastName:$('#LastName').val(),
            DateOfBirth:$('#DateOfBirth').val(),
            Email:$('#Email').val(),
            Password:$('#Password').val(),
            RePassword:$('#RePassword').val()
        },
        success: function(data) { 
            var table = document.getElementById('myTable');
            $.getJSON( "../json/Edit_Data.json", function(User) { 
                
                $('#FirstName').val(User.FirstName);
                $('#LastName').val(User.LastName);
                $('#Username').val(User.Username);
                $('#Email').val(User.Email);
                $('#DateOfBirth').val(User.DateOfBirth);
                
                var id = User.ID - 1;
                $(table.rows[id].cells[1]).html(User.Username);
                $(table.rows[id].cells[2]).html(User.FirstName);        
                $(table.rows[id].cells[3]).html(User.LastName);
                $(table.rows[id].cells[4]).html(User.Email);
                $(table.rows[id].cells[5]).html(User.DateOfBirth);
                $(table.rows[id].cells[6]).html(User.Password);
            });
            if(data === "NPASS"){
                $('.Error').removeClass('NOTvisible');
                $('.Error').html("Wrong Password!");
            }
            else if (data === "EEUSER"){
                $('.Error').removeClass('NOTvisible');
                $('.Error').html("Username exists!");
            }
            else {
                $('.Error').addClass('NOTvisible');
                $('.Edit').addClass('NOTvisible');
            }
            console.log(data);
        },
        error: function(err) { 
            console.log("Error: " + err);
        }
    });
}

(function search(){
    $.ajax({
        method:'POST',    
        url: "../ajax/Search.php",
        data:{
            action:"Search",
            "Id":'ID',
            "Text":"text"
        },
        success: function(data) {
            
        },
        error: function(err){
            console.log(err);
        },
        complete: function() {
            setTimeout(search, 5000);
        }
    });
});