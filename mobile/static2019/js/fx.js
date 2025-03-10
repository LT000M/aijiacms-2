wx.config({
	debug: false,
	appId: appid,
	timestamp: timestamp,
	nonceStr: nonceStr,
	signature: signature,
	jsApiList: [
		// 所有要调用的 API 都要加到这个列表中
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareQZone'
	  ]
});  

wx.ready(function () {

		wx.error(function(res){ 

		});
		
		wx.checkJsApi({
			jsApiList: [
				'onMenuShareTimeline',
				'onMenuShareAppMessage'
			],
			success: function (res) {
				//alert(JSON.stringify(res));
			}
		}); 
		
		
		wx.onMenuShareQQ({  
			title: title,   
			desc: desc,  
			link: link, 
			imgUrl: imgUrl,  
			success: function (res) {   
			  //alert('分享成功shareqq'); 
			},  
			cancel: function (res) {   
			  //alert('取消分享');
			}  
		});  
				
		wx.onMenuShareQZone({  
			title: title,   
			desc: desc,  
			link: link, 
			imgUrl: imgUrl,  
			success: function (res) {   
			   //alert('分享成功shareqzone'); 
			},  
			cancel: function (res) {   
			 // alert('取消分享');
			}  
		}); 
		
		wx.onMenuShareAppMessage({
		  title: title,
		  desc: desc,
		  link: link,
		  imgUrl: imgUrl,
		  trigger: function (res) {
		  },
		  success: function (res) {
			//alert('分享成功');
		  },
		  cancel: function (res) {
			//alert('取消分享');
		  },
		  fail: function (res) {
			//alert('分享出错');
		  }
		});

		wx.onMenuShareTimeline({
		  title: title,
		  link: link,
		  imgUrl: imgUrl,
		  trigger: function (res) {

		  },
		  success: function (res) {
			//alert('分享成功');
		  },
		  cancel: function (res) {
			//alert('取消分享');
		  },
		  fail: function (res) {
			//alert('分享出错');
		  }
		});

});