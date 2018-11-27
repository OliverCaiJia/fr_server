 var userinfoController = {
     init: function () {
         this.areaSelect('#address');
         this.areaSelect('#company_location');
         this.selectChange();
         this.radioView();
         this.submitView();
     }
     , /*地址选择*/
     areaSelect: function (dom) {
         var _this = this;
         var area1 = new LArea();
         area1.init({
             'trigger': dom
             , 'keys': {
                 id: 'id'
                 , name: 'name'
             }
             , 'type': 1
             , 'data': LAreaData
         });
         area1.value = [1, 13, 3];
         $(dom).focus(function () {
             document.activeElement.blur();
         });
     }
     , selectChange: function () {
         var text = $('#profession').find("option:selected").text();
         showData(text);
         $('#profession').on('change', function () {
             var text = $(this).find("option:selected").text();
             $(this).addClass('selectColor');
             $('.showData1,.showData3,.showData4').hide();
             showData(text);
         })

         function showData(text) {
             if (text == '上班族' || text == '公务员') {
                 $('.showData1,.showData4').show();
             }
             else if (text == '企业主') {
                 $('.showData3,.showData4').show();
             }
         }
     }, //单选点击
     radioView: function () {
         $('.radio-box').on('click', 'span', function () {
             $(this).addClass('active').siblings('span').removeClass('active');
         })
     }, //提交按钮
     submitView: function () {
         var _self = this;
         $('.button').on('click', function () {
             var user_location = $('#address').val()
                 , user_address = $('#user_address').val()
                 , company_name = $('#company_name').val()
                 , company_location = $('#company_location').val()
                 , company_address = $('#company_address').val()
                 , zhima_score = $('#zhima_score').val()
                 , profession = $('#profession').find("option:selected").val() || ''
                 , work_time = $('#work_time').find("option:selected").val() || ''
                 , month_salary = $('#month_salary').find("option:selected").val() || ''
                 , house_fund_time = $('#house_fund_time').find("option:selected").val() || ''
                 , company_license_time = $('#company_license_time').find("option:selected").val() || ''
                 , has_social_security = $('#has_social_security').find('.active').data('val') || ''
                 , has_house = $('#has_house').find('.active').data('val') || ''
                 , has_auto = $('#has_auto').find('.active').data('val') || ''
                 , has_house_fund = $('#has_house_fund').find('.active').data('val') || ''
                 , has_assurance = $('#has_assurance').find('.active').data('val') || ''
                 , has_creditcard = $('#has_creditcard').find('.active').data('val') || ''
                 , has_weilidai = $('#has_weilidai').find('.active').data('val') || '';
             var professionText = $('#profession').find("option:selected").text();
             if (professionText == '上班族' || professionText == '公务员') {
                 if (company_name == '' || company_location == '' || company_address == '' || work_time == '' || month_salary == '') {
                     base.popupCover({
                         content: '请填写完整信息！'
                     });
                     return;
                 }
             }
             else if (professionText == '企业主') {
                 if (company_license_time == '' || company_name == '' || company_location == '' || company_address == '') {
                     base.popupCover({
                         content: '请填写完整信息！'
                     });
                     return;
                 }
             }
             else if (user_location == '' || user_address == '' || profession == '' || zhima_score == '' || house_fund_time == '' || has_social_security == '' || has_house == '' || has_auto == '' || has_house_fund == '' || has_assurance == '' || has_creditcard == '' || has_weilidai == '') {
                 base.popupCover({
                     content: '请填写完整信息！'
                 });
                 return;
             }
             $.ajax({
                 url: api_fruitloan_host + '/v1/user/info/create'
                 , type: 'POST'
                 , data: {
                     user_location: user_location
                     , user_address: user_address
                     , profession: profession
                     , company_name: company_name
                     , company_location: company_location
                     , company_address: company_address
                     , work_time: work_time
                     , month_salary: month_salary
                     , zhima_score: zhima_score
                     , house_fund_time: house_fund_time
                     , company_license_time: company_license_time
                     , has_social_security: has_social_security
                     , has_house: has_house
                     , has_auto: has_auto
                     , has_house_fund: has_house_fund
                     , has_assurance: has_assurance
                     , has_creditcard: has_creditcard
                     , has_weilidai: has_weilidai
                 }
                 , success: function (json) {
                     _self.personInfoBind(json)
                 }
             })
         })
     }, //提交成功后终端交互
     personInfoBind: function (successData) {
         var AndroidSuccessData = JSON.stringify(successData);
         try {
             window.sd.personInfoBind(AndroidSuccessData);
             return;
         }
         catch (e) {
             console.log("Android-提交信息方法失败");
         }
         try {
             window.webkit.messageHandlers.personInfoBind.postMessage(successData);
             return;
         }
         catch (e) {
             console.log("ios-提交信息方法失败");
         }
         try {
             window.parent.postMessage({
                 'type': 'personInfoBind'
                 , 'successData': successData
             }, '*');
             return;
         }
         catch (e) {
             console.log("h5-提交信息方法返失败");
         }
     }
 }
 $(function () {
     userinfoController.init();
 })