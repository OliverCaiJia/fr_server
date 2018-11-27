 var costdefatltController = {
     init: function () {
         this.selectView()
     }, //选择赠送协议
     selectView: function () {
         var _self = this;
         $('.service-list').on('click', function () {
             $(this).siblings('div').find('.selectIcon').hide();
             $(this).find('.selectIcon').show();
             _self.recommendService();
         })
     }, //选择赠送协议交互
     recommendService: function () {
         try {
             window.sd.recommendService();
             return;
         }
         catch (e) {
             console.log("Android-选择赠送协议方法失败");
         }
         try {
             window.webkit.messageHandlers.recommendService.postMessage({});
             return;
         }
         catch (e) {
             console.log("ios-选择赠送协议方法失败");
         }
         try {
             window.parent.postMessage({
                 'type': 'recommendService'
             }, '*');
             return;
         }
         catch (e) {
             console.log("h5-选择赠送协议方法返失败");
         }
     }
 }
 $(function () {
     costdefatltController.init();
 })