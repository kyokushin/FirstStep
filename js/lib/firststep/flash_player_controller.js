var initialize_flash_player = function(){};
var player = null;

$(document).ready(
    function() {
	var width = Math.floor(Math.random() * 600);
	var is_paused = false;

	player = $('#flash_player');

	player.flash(
	    {
		swf: 'YouTubeSetList.swf',
		width: width,
		allowScriptAccess:'always',
		id:'embed_player'
	    }
	);

	$('#next_button').click(function(){
	    play_youtube($('#play_lists').attr('next_song_url'));
	});


	$('#prev_button').click(function(){
	    play_youtube($('#play_lists').attr('prev_song_url'));
	});


	$('#stop_button').click(function(){
	    is_paused = !is_paused;
	    console.log(is_paused);
	    is_paused ? pause_youtube() : start_youtube();
	});
    }
);

    function play_youtube(url) {
	player.flash(
	    function() {
		console.log(url);
		this.PlayVideo(url);
	    }
	);
    }

    function pause_youtube() {
	$('#stop_button').attr('value', 'play');
	player.flash(
	    function() {
		this.PauseVideo();
	    }
	);
    }

    function start_youtube() {
	$('#stop_button').attr('value', 'pause');
	player.flash(
	    function() {
		this.StartVideo();
	    });
    }