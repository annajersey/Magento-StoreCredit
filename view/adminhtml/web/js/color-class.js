define(
    [
        'jquery'
    ],
    function($) {
        "use strict";
        var coloramount = {

            colorclass:function(){console.log('inside');
                $('.col-amount').each(function(){
                    if($(this).text()>0) {$(this).addClass('positive');}
                    if($(this).text()<0) {$(this).addClass('negative');}
                });
            },

            init:function(){
                var self = this;    
                $(document).ready(function() {
                    self.colorclass();
                });
                $(document).ajaxStop(function() {
                    self.colorclass();
                });
            } 
        };
        
        return coloramount;
    }
);
 
