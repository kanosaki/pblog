
pblog = {};

var Ev  = function(){
    this.callbacks = [];
};

Ev.prototype = {
    bind : function(fn){
        this.callbacks.push(fn);
    },

    trigger : function(arg){
        var callbacks = this.callbacks;
        for(var i = 0; i < callbacks.length; i++){
            callbacks[i](arg);
        }
    }
};

pblog.Event = Ev;

window.userinfo_updated = new pblog.Event();
