/**
*Created By Lizhigang
**/
;(function($){
	$(function(){
		//后台删除公共函数
		$('table,ol').on('click','.delete',function(e){
			var _this=$(this);
			var href=_this.data('href');
			// $.SmartMessageBox({
			// 	title : "确定删除吗",
			// 	content : "删除的数据将被永远清除，请谨慎操作",
			// 	buttons : '[否][是]'
			// }, function(ButtonPressed) {
			// 	if (ButtonPressed === "是") {
			// 		$.ajax({
			// 			type:'DELETE',
			// 			url:href,
			// 			success:function(res){
			// 				var color='#659265';
			// 				if(res.error==0){
			// 					_this.parents('tr').remove();
			// 					_this.parents('li.dd-item').remove();
			// 				}else{
			// 					color='#C46A69';
			// 				}

			// 				$.smallBox({
			// 					title : "消息通知",
			// 					content : res.msg,
			// 					color : color,
			// 					iconSmall : "fa fa-check fa-2x fadeInRight animated",
			// 					timeout : 2000
			// 				});

			// 				setTimeout(function(){
			// 					location.reload();
			// 				},2000);
			// 			}
			// 		});
					
			// 	}		
			// });
			
			layer.confirm('确定删除吗(请谨慎操作)？',{
				btn:['确定','取消']
			},function(index){
				layer.close(index);
				$.ajax({
					type:'DELETE',
					url:href,
					success:function(res){
						var color='#659265';
						if(res.error==0){
							_this.parents('tr').remove();
							_this.parents('li.dd-item').remove();
						}else{
							color='#C46A69';
						}

						$.smallBox({
							title : "消息通知",
							content : res.msg,
							color : color,
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 2000
						});

						setTimeout(function(){
							location.reload();
						},2000);
					}
				});
			},function(index){
				layer.close(index);
			});
			e.preventDefault();
		});
	});
})(jQuery);