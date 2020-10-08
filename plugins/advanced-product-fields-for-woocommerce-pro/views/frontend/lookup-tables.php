<script>

	WAPF.Filter.add('wapf/fx/functions', function(funcs) {
	    funcs.push('lookuptable');
	    return funcs;
	});

	WAPF.Filter.add('wapf/fx/solve', function(solution,data) {

	    if(data.func === 'lookuptable') {

            function findNearest(value,axis) {

                if(axis[''+value])
                    return value;

                var keys = Object.keys(axis);
                value = parseFloat(value);

                if(value < parseFloat(keys[0]))
                    return keys[0];

                for(var i=0; i < keys.length; i++ ) {
                    if(value > parseFloat(keys[i]) && value <= parseFloat(keys[i+1]))
                        return keys[i+1];
                }

                // return last
                return keys[i];

            }

	        var lookuptable = wapf_lookup_tables[data.args[0]];
	        var xValue = WAPF.Util.getFieldValue(jQuery('[data-field-id="'+data.args[1]+'"]'));
	        var yValue = WAPF.Util.getFieldValue(jQuery('[data-field-id="'+data.args[2]+'"]'));

            if(xValue == '' || yValue == '') return 0;

	        var tableXValue = findNearest(xValue,lookuptable);
	        var tableYValue = findNearest(yValue,lookuptable[tableXValue]);

	        return lookuptable[tableXValue][tableYValue];
        }

	    return solution;
	});
</script>