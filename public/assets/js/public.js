jQuery(document).ready(function($){
   var elements=jQuery('.btc-online-value');
   var elements_ex=jQuery('.btc-online-value_ex');
   var pubnub={};



        if(elements.length > 0){
            
		    pubnub = PUBNUB.init({
			publish_key: "demo",
			subscribe_key: "sub-c-50d56e1e-2fd9-11e3-a041-02ee2ddab7fe",
			ssl: true
			});
        	pubnub.subscribe({
        		channel:["d5f06780-30a8-4a48-a2f8-7ed181b4a13f"],
        		message: function(m) {
        		   show_values(m);
                   },        	
        	});            
        }

    
           function show_values(m){
               for (var key in m.ticker){
                    var item=m.ticker[key];
                    for(var key1 in item){
                         var value=item[key1];
                         var element=jQuery('[data-type="'+ key +'"][data-value="'+ key1 +'"]');   
                         if(element.length > 0 || value != undefined){
                            element.text(value); 
                         }   
                    }
                }            

           } 
           
        if(elements_ex.length > 0){
            
             var ws = new WebSocket("ws://markets.blockchain.info:8080/ws/markets/chat/markets_mtgox_USD?_=1391587028779");
             ws.onopen = function()
             { };

            ws.onmessage = function (evt){ 
                var received_msg = evt.data;                 
                var msg=JSON.parse(received_msg);

                var condition=(msg.channel=='markets' &&
                               jQuery.inArray(msg.text.exchange_name,["btce","bitstamp"])>-1 &&
                               msg.text.currency=='USD');
           
                if(!condition) return false;
                
                var element=jQuery('[data-exchange="'+ msg.text.exchange_name +'"]');
                var last=parseFloat(msg.text.last);
                if(element.length > 0 || last != undefined){
                    
                    
                            element.number(last,2); 
                         }                   
         }
        }              

});