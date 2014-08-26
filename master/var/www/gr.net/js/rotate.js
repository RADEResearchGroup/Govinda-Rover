var value = 0
$("#cam-feed").rotate({ 
   bind: 
     { 
        click: function(){
            value +=90;
            $(this).rotate({ animateTo:value})
        }
     } 
   
});