$(function(e) {
	
	new JSR(['#range-1-1', '#range-1-2', '#range-1-3'], {
		sliders: 3,
		values: [25, 50, 75],
		labels: {
			minMax: false
		},
		log: 'info'
	});
	const r1 = new JSR(['#range-2-1', '#range-2-2'], {
		sliders: 2,
		min: 10,
		max: 20,
		values: [15, 17],
		limit: {
			show: true
		},
		labels: {
			
		}
	});
	new JSR(document.getElementById('range-3'), {
		sliders: 1,
		step: 0.01,
		values: [50],
		limit: {
			min: 19
		},
		labels: {
		}
	});
	new JSR(['#range-4-1', '#range-4-2'], {
		sliders: 2,
		step: 0.1,
		min: -200,
		max: 100,
		values: [50, 75]
	}).disable();
	
});