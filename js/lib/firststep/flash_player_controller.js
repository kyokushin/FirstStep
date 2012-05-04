var initialize_flash_player = function(){};

$(document).ready(
    function() {
	var width = Math.floor(Math.random() * 600);
	$('#flash_player').flash(
	    {
		swf: 'YouTubeSetList.swf',
		width: width
	    }
	);
    }
);