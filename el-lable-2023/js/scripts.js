jQuery(function($){
	
	var isTouchDevice = !!('ontouchstart' in window);
	if(isTouchDevice)$('body').addClass('touch_device');
	
	/* Search Widget */
	$('.widget_search input[type="search"]').attr('placeholder', 'Search Articles');
	
	/* Ajax Loadmore for Posts */
	$('.articles ~ .buttons a[href*="/page/"]').click(function(e){
		e.preventDefault();
		if($(this).is('[disabled]'))return;
		var $button = $(this);
		var pager = parseInt($(this).data('pager') || $(this).attr('href').split('/page/')[1].split('/')[0], 10);
		var data = {
			action:'load_posts',
			data:$('.articles').data(),
			pager:pager,
		};
		$.ajax({
			type:'post',
			url:ajax.url,
			data:data,
			beforeSend:function(res){
				$button.attr('disabled', 'disabled');
			},
			complete:function (res) {
				$button.removeAttr('disabled');
			},
			success: function(res){
				if(res.posts){
					$(res.posts).appendTo('.articles');
				}
				if(res.remaining && res.remaining > 0){
					$button.data('pager', pager + 1);
				}
				else{
					$button.remove();
				}
			}
		});
	});
	
	/* Ajax Loadmore for Cases */
	$('.cases .buttons a[href*="/page/"]').click(function(e){
		e.preventDefault();
		if($(this).is('[disabled]'))return;
		var $button = $(this);
		var $ul = $(this).parents('.cases').children('ul');
		var pager = parseInt($(this).data('pager') || $(this).attr('href').split('/page/')[1].split('/')[0], 10);
		var data = {
			action:'load_cases',
			data:$ul.data(),
			pager:pager,
		};
		$.ajax({
			type:'post',
			url:ajax.url,
			data:data,
			beforeSend:function(res){
				$button.attr('disabled', 'disabled');
			},
			complete:function (res) {
				$button.removeAttr('disabled');
			},
			success: function(res){
				if(res.cases){
					$(res.cases).appendTo($ul);
				}
				if(res.remaining && res.remaining > 0){
					$button.data('pager', pager + 1);
				}
				else{
					$button.parent().remove();
				}
			}
		});
	});
	
	/* Read more */
	$('#content').delegate('.links .more', 'click', function(e){
		e.preventDefault();
		var $content = $(this).parents('.links:first').siblings('.content');
		if($(this).toggleClass('active').hasClass('active')){
			$content.slideDown();
		}
		else{
			$content.slideUp();
		}
	});
	
	/* Intro Carousel */
	$('#content .intro ul').each(function(){
		if($(this).children().length <= 1)return;
		$(this).owlCarousel({
			loop:true,
			nav:true,
			dots:false,
			autoplay:true,
			autoplayTimeout:10000,
			items:1,
		});
	});
	$('#content .intro').find('a[href*="//youtu"]').fancybox();
	
	/* Testimonials Carousel */
	$('#content .testimonials ul').each(function(){
		$(this).owlCarousel({
			loop:true,
			nav:true,
			dots:true,
			autoplay:true,
			autoplayTimeout:10000,
			items:1,
		});
	});
	
	/* Articles Carousel */
	$('#content .subscribe-news .articles').each(function(){
		$(this).owlCarousel({
			loop:true,
			nav:false,
			dots:false,
			autoplay:true,
			autoplayTimeout:10000,
			responsive:{
				0:{
					items:1,
					margin:0,
				},
				500:{
					items:2,
					margin:20,
				},
				800:{
					items:3,
					margin:20,
				},
				1024:{
					items:4,
					margin:20,
				}
			}
		});
	});
	
	/* Scroll to The Elemtnt */
	$('#content a[href^="#"]').click(function(e){
		var $element = $($(this).attr('href'));
		if(!$element.length)return;
		e.preventDefault();
		$('html, body').animate({'scrollTop':$element.offset().top - 20}, 1000);
	});
	
	/* Mobile Menu  */
	// making
	$('#mobile_menu').append($('#header').find('.widget_nav_menu, .buttons').clone());
	// show|hide
	$('#header a[href="#mobile_menu"]').click(function(e){
		e.preventDefault();
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('#mobile_menu_overlay, #mobile_menu').removeClass('active');
		}
		else{
			$(this).addClass('active');
			$('#mobile_menu_overlay, #mobile_menu').addClass('active');
		}
	});
	$('#mobile_menu .menu > .menu-item.menu-item-has-children').append(`<i>`);
	$('#mobile_menu .menu > .menu-item.menu-item-has-children > a[href="#"], #mobile_menu .menu > .menu-item.menu-item-has-children > i').click(function(e){
		e.preventDefault();
		var $ul = $(this).siblings('ul');
		if($ul.filter(':animated').length)return false;
		if($(this).parents('.menu-item:first').toggleClass('opened').hasClass('opened')){
			$ul.slideDown(300);
		}
		else{
			$ul.slideUp(300);
		}
	});
	
	/* CF7 */
	$('.wpcf7 form').append('<input type="hidden" name="bo' + 'ul' + 'der" value="da' + 'sh">');
	$('.wpcf7').bind('wpcf7mailsent', function(e){
		var text = e.detail.apiResponse.message.split('. ');
		var $block = $('#accept_message');
		$block.find('h4').text(text[0]);
		$block.find('p').text(text[1]);
		$block.addClass('visible');
	});
	$('#accept_message > a').click(function(e){
		e.preventDefault();
		$(this).parents('.visible:first').removeClass('visible');
	});
	
	/* maskedinput */
	if($.inputmask){
		$('input[type="tel"], input[name*="phone"]').inputmask("(999) 999-9999", {
			placeholder:"Х",
			clearMaskOnLostFocus: true,
		});
	}
	
	$('a[href="#back"]').click(function(e){
		e.preventDefault();
		location.href = history.back();
	});
	
	/* AOS */
	//$('#content > h1, #content > h2').attr('data-aos', 'zoom-in');
	/*AOS.init({
		//easing:'ease-out-back',
		duration:1000,
	});*/
	
	$('#login .login_form_sel a').click(function(e){
		e.preventDefault();
		$(this).addClass('active').siblings().removeClass('active');
		var index = $(this).parent().children().index(this);
		$(this).parents('.login-form').find('.tml').removeClass('visible').eq(index).addClass('visible');
	})
	.eq(0).click();
	$('#login .tml').eq(0).addClass('visible');
    /*-------------------*/
    /*Forgot Pass form*/
    $('.btn + a[href="#forgot"').click(function(){
        $('#login_form > *').removeClass('active');
        $('#forgot').removeClass('hidden').addClass('active');
        $('#log_in').addClass('hidden');
        $('#create').remove();
        $('.login_form_sel a').not('.active').text('Password Recovery').attr('href','#forgot');
        $('.login_form_sel a').toggleClass('active');
        return false;   
    });
    $('.pass_eye').click(function(){
        $(this).toggleClass('open');
        if ($(this).siblings('input').attr('type')=='password'){
            $(this).siblings('input').attr('type','text');
        }else{
            $(this).siblings('input').attr('type','password');
        }
    });
	/* Theme My Login */
	$('.tml .placeholder').each(function(){
		$(this).siblings('input, button').attr('placeholder', $(this).text());
	});
});