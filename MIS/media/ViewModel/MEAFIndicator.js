function viewModel() {
	var self = this;

	$('tbody tr').each(function () {
		$(this).find('td').each(function (i) {
			if (i >= 3 && i <= 7) {
				var text = $(this).text();
				$(this).text('');
				$(this).html('<span>' + text + '</span><hr><span>&nbsp;</span>');
			}
		});
	});

	app.ajax('/MEAFIndicator/getData').done(function (rs) {
		var keys = Object.keys(rs[0]).filter(r => r != 'Year');
		keys.forEach(k => {
			var year = 2021;

			$('#' + k).find('td').each(function (i) {
				if (i >= 3 && i <= 7) {
					var found = rs.find(r => r.Year == year);
					var value = found == null ? '&nbsp;' : found[k];
					var target = $(this).find('span:first').text();
					var color = getColor(k, value, target);

					if (value === '') value = '&nbsp;';

					$(this).find('span:last').html(value).css('color', color);

					year++;
				}
			});
		});
	});

	function getColor(key, value, target) {
		if (value === '') return '';

		if (['Tpr', 'Api', 'ApiPfMix', 'Severe', 'Death', 'Foci'].contain(key)) {
			return parseFloat(value) <= parseFloat(target) ? 'blue' : 'red';
		}

		if (['AberEndemic', 'Aber'].contain(key)) {
			return parseFloat(value) >= parseFloat(target) ? 'blue' : 'red';
		}

		if (['OdApi', 'OdApiPfMix', 'Classified', 'Investigated', 'Responded', 'NewFoci', 'FociResponse'].contain(key)) {
			return parseInt(value.split('%')[0]) >= parseInt(target.split('%')[0]) ? 'blue' : 'red';
		}

		if (['L1L3'].contain(key)) {
			return parseInt(value.split('%')[0]) <= parseInt(target.split('%')[0]) ? 'blue' : 'red';
		}

		if (['HFCompleteness', 'VMWCompleteness', 'StockCompleteness', 'PfMixTreat', 'PvTreat'].contain(key)) {
			var v = parseFloat(value.split('%')[0]);
			var t = target.split('%')[0];
			var greater = t.contain('>');
			t = parseInt(t.replace('>', ''));

			if (greater) return v > t ? 'blue' : 'red';
			return v >= t ? 'blue' : 'red';
		}
	}
}