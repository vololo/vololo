$(function() {
	$('#tune').click(function() {
		$('#subscribe').fadeIn(200);
		return false;
	});
	$('input,textarea').each(function() {
		var t = $(this);
		var p = t.attr('placeholder');
		if (p && p.length) {
			$(t).val(p).focus(function() {
				if ($(this).val() == p) $(this).val('');
			}).blur(function() {
				if ($(this).val() == '') $(this).val(p);
			});
		}
	});
	$('input[readonly=readonly]').live('mousedown', function() {
		$(this).select();
		return false;
	});
	$('#sb_studia').multiSelect({
		selectAllText: 'Выбрать все',
        noneSelected: 'Выберите студии',
        oneOrMoreSelected: 'Выбрано: %',
        listHeight: 500
	});
	$('#sb_type').multiSelect({
		selectAllText: 'Подписаться на все',
        noneSelected: 'На что подписаться',
        oneOrMoreSelected: 'Выбрано: %',
        listHeight: 500
	});
	$('#sb_src').change(function() {
		var v = $(this).val();
		if (v == 'rss') {
			$('#sb_src,#sb_type,#sb_studia,#sb_button').css('display', 'block');
			$('#sb_mail').css('display', 'none');
		}
		else if (v == 'twitter') {
			$('#sb_src,#sb_button').css('display', 'block');
			$('#sb_type,#sb_studia,#sb_mail').css('display', 'none');
		}
		else if (v == 'mail') {
			$('#sb_src,#sb_type,#sb_mail,#sb_studia,#sb_button').css('display', 'block');
		}
		else $('#sb_type,#sb_studia,#sb_mail,#sb_button').css('display', 'none');
		$('#sb_result').html('');
	}).val('');
	$('#ad').submit(function() {
		var message = $('#ad_message').val();
		if (message == $('#ad_message').attr('placeholder')) message = '';
		if (!message) {alert('Введите сообщение');return false;}
		$.ajax({
			async: false,
			url: '/mail/admin',
			dataType: 'text',
			type: 'post',
			data: $(this).serialize(),
			success: function() {
				alert('Сообщение отправлено');
				$('#ad_message').val('').blur();
			}
		});
		return false;
	});
	$('#sb').submit(function() {
		var h = '';
		var v = $('#sb_src').val();
		if (v == 'rss') {
			var studia = $('#sb_studia+.multiSelectOptions>.checked').length;
			var type = $('#sb_type+.multiSelectOptions>.checked').length;
			if (!type) {alert('Выберите на что подписываетесь');return false;}
			if (!studia) {alert('Выберите студии');return false;}
			var u =	'http://' + window.location.host + '/rss/' +
					$.fn.subscribe_implode('sb_type') +
					'/' +
					$.fn.subscribe_implode('sb_studia');
			h = '<input type="text" readonly="readonly" value="' + u + '" />';
		}
		else if (v == 'twitter') {
			h = '<a href="http://twitter.com/vololoru" target="_blank" title="Все что тут есть транслируется в Twitter">Идти на twitter/vololoru</a>';
		}
		else if (v == 'mail') {
			var studia = $('#sb_studia+.multiSelectOptions>.checked').length;
			var type = $('#sb_type+.multiSelectOptions>.checked').length;
			var mail = $('#sb_mail').val();
			if (mail == $('#sb_mail').attr('placeholder')) mail = '';
			if (!mail) {alert('Укажите e-mail');return false;}
			if (! /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(mail)) {alert('Неверный e-mail');return false;}
			if (!type) {alert('Выберите на что подписываетесь');return false;}
			if (!studia) {alert('Выберите студии');return false;}
			var u =	'http://' + window.location.host + '/mail/' +
					$.fn.subscribe_implode('sb_type') +
					'/' +
					$.fn.subscribe_implode('sb_studia');
			$.ajax({
				async: false,
				url: u,
				dataType: 'text',
				type: 'post',
				data: {'mail': mail},
				success: function() {
					alert('Ваш e-mail подписан');
				}
			});
		}
		$('#sb_result').html('<div>' + h + '</div>');
		return false;
	});
	$('#vote_avg').click(function() {
		$('.vote').each(function() {
			var t = $(this).addClass('disabled');
			$.fn.vote_set(t, t.attr('value_avg'));
			t.data('title', t.attr('title'));
			t.attr('title', t.attr('message_avg'));
		});
		$(this).addClass('active');
		$('#vote_my').removeClass('active');
		return false;
	});
	$('#vote_my').click(function() {
		$('.vote').each(function() {
			var t = $(this).removeClass('disabled');
			$.fn.vote_set(t, t.attr('value'));
			t.attr('title', t.data('title') ? t.data('title') : t.attr('message_avg'));
		});
		$(this).addClass('active');
		$('#vote_avg').removeClass('active');
		return false;
	});
	$('.vote').each(function() {
		var t = $(this);
		t.find('div').prepend('<span></span>');
		$.fn.vote_set(t, t.attr('value' + (t.hasClass('disabled') ? '_avg' : '')));
	});
	$('.vote>div>a').hover(function() {
		var t = $(this);
		var o = t.parents('.vote');
		if (o.hasClass('disabled')) return false;
		$.fn.vote_set(t.parents('.vote'), t.attr('title'));
	}, function() {
		var o = $(this).parents('.vote');
		if (o.hasClass('disabled')) return false;
		$.fn.vote_set(o, o.attr('value'));
	}).click(function() {
		var t = $(this);
		var id = t.parents('tr').attr('id');
		var o = t.parents('.vote');
		if (o.hasClass('disabled') || o.data('timer')) return false;
		var message = window.prompt('Прокомментируйте свою оценку');
		$.ajax({
			url: '/konkurs/vote',
			type: 'post',
			dataType: 'json',
			data: {
				id: id,
				type: o.attr('type'),
				value: t.attr('title'),
				message: message ? message : ''
			},
			complete: function() {
				$.fn.vote_loading_finish(o);
			},
			success: function(d) {
				if (d && d.value > 0 && d.value < 6) {
					o.attr('value_avg', d.value_avg);
					o.attr('value', d.value);
					o.attr('title', d.message);
					$.fn.vote_set(o, d.value);
				}
			}
		});
		o.data('timer', window.setTimeout(function() {
			$.fn.vote_loading_start(o);
		}, 400));
		return false;
	});
	$('.pane_ev .people>a').click(function() {
		var o = $(this).next('.invis');
		if (o.css('display') == 'none') o.slideDown(400);
		else o.slideUp(200);
		return false;
	});
});

$.fn.ft_zoom = function() {
	var o = $('.fs');
	if ($(document.body).hasClass('fullscreen')) {
		$(document.body).removeClass('fullscreen').find('.wrapper').show();
		$('.wrapper .padding>.left:first').prepend(o);
		o.find('.fs_zoom').attr('title', 'На весь экран').html('+');
	}
	else {
		$(document.body).addClass('fullscreen').append(o);
		o.find('.fs_zoom').attr('title', 'Свернуть').html('-');
		$(document.body).find('.wrapper').hide();
	}
	fz.tile_draw();
	return false;
};

$.fn.vote_loading_start = function(o) {
	o.addClass('loading');
};

$.fn.vote_loading_finish = function(o) {
	window.clearTimeout(o.data('timer'));
	o.data('timer', null);
	o.removeClass('loading');
};

$.fn.vote_set = function(o, v) {
	o.find('span').width(Number(v) * 16);
};

$.fn.subscribe_implode = function(id) {
	var u = '';
	if ($('#' + id + '+.multiSelectOptions>label').length == $('#' + id + '+.multiSelectOptions>.checked').length) u += 'all';
	else $('#' + id + '+.multiSelectOptions>.checked').each(function(i) {
		var v = $(this).find('input').val();
		if (v) u += (i ? '+' : '') + v;
	});
	return u ? u : 'all';
};
