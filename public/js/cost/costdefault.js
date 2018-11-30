 var costdefatltController = {
     init: function () {
         this.selectView();
         this.getoOriginalPrice();
         $('.give-service-list').eq(0).addClass('selectIconShow');
     },
     getoOriginalPrice: function () {
         var recommendPrice = $('.recommendPrice').text();
         var givePrice = $('.selectIconShow').find('.givePrice').text();
         var originalPrice = Number(recommendPrice) + Number(givePrice);
         $('.originalPrice').text(originalPrice)
     }, //选择赠送协议
     selectView: function () {
         var _self = this;
         $('.give-service-list').on('click', function () {
             $('.give-service-list').removeClass('selectIconShow');
             $(this).addClass('selectIconShow');
             _self.getoOriginalPrice();
             _self.recommendService();
         })
     },
     submitView() {
         $('#submit').on('click', function () {
             $.ajax({
                 url: api_fruitloan_host + '/v1/user/info/create',
                 type: 'POST',
                 data: {},
                 success: function (json) {
                     _self.recommendService(json)
                 }
             })
         })
     }, //选择赠送协议交互
     recommendService: function (successData) {
         var AndroidSuccessData = JSON.stringify(successData);
         try {
             window.sd.recommendService(AndroidSuccessData);
             return;
         } catch (e) {
             console.log("Android-选择赠送协议方法失败");
         }
         try {
             window.webkit.messageHandlers.recommendService.postMessage(successData);
             return;
         } catch (e) {
             console.log("ios-选择赠送协议方法失败");
         }
         try {
             window.parent.postMessage({
                 'type': 'recommendService',
                 'successData': successData
             }, '*');
             return;
         } catch (e) {
             console.log("h5-选择赠送协议方法返失败");
         }
     }
 }
 $(function () {
     costdefatltController.init();
 })
