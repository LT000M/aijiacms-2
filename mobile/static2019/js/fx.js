wx.config({
	debug: false,
	appId: appid,
	timestamp: timestamp,
	nonceStr: nonceStr,
	signature: signature,
	jsApiList: [
		// ����Ҫ���õ� API ��Ҫ�ӵ�����б���
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
			  //alert('����ɹ�shareqq'); 
			},  
			cancel: function (res) {   
			  //alert('ȡ������');
			}  
		});  
				
		wx.onMenuShareQZone({  
			title: title,   
			desc: desc,  
			link: link, 
			imgUrl: imgUrl,  
			success: function (res) {   
			   //alert('����ɹ�shareqzone'); 
			},  
			cancel: function (res) {   
			 // alert('ȡ������');
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
			//alert('����ɹ�');
		  },
		  cancel: function (res) {
			//alert('ȡ������');
		  },
		  fail: function (res) {
			//alert('�������');
		  }
		});

		wx.onMenuShareTimeline({
		  title: title,
		  link: link,
		  imgUrl: imgUrl,
		  trigger: function (res) {

		  },
		  success: function (res) {
			//alert('����ɹ�');
		  },
		  cancel: function (res) {
			//alert('ȡ������');
		  },
		  fail: function (res) {
			//alert('�������');
		  }
		});

});