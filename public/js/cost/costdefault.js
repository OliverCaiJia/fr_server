 var costdefatltController = {
     init: function () {
         this.selectView();
         this.getoOriginalPrice();
         this.submitView();
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
         })
     },
     submitView() {
         var _self = this;
         $('#submit').on('click', function () {
             $.ajax({
                 url: api_fruitloan_host + '/v1/user/order/create',
                 type: 'POST',
                 data: {
                     'order_type_nid': 'order_extra_service',
                     'amount': $('#totalPrice').text(),
                     'count': 1,
                     'extra_type_nid': $('.selectIconShow').data('seqnid')
                 },
                 success: function (json) {
                     if (json.code == 200 && json.error_code == 0) {
                         _self.recommendService(json)
                     } else {
                         base.popupCover({
                             content: json.error_message
                         });
                     }
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
             window.webkit.messageHandlers.recommendService.postMessage({
                 successData: successData
             });
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
