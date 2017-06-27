function role2show(role){
	if (role == 'TANK'){
		return 'Tank';
	}
	else if (role == 'HEALING'){
		return 'Heal';
	}
	else if (role == 'DPS'){
		return 'Damage';
	}
	else{
		return '---';
	}
}

function icon2show(role){
	if (role == 'TANK'){
		return 'icon fa-shield';
	}
	else if (role == 'DPS'){
		return 'icon fa-dot-circle-o';
	}
	else if (role == 'HEALING'){
		return 'icon fa-plus-circle';
	}
}

function ShowModal(){
	document.getElementById('id01').style.display='block';
	$("body").removeClass( "is-menu-visible" );
}

// Get the modal
var modal = document.getElementById('id01');



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

$(document).ready(function() {
	var UrlParameter = window.location.search;
	if (UrlParameter === '?roster=true'){
		window.location.href = "rest/roster.php?forceupdate=true";
	}
	if (UrlParameter === '?progress=true'){
		window.location.href = "rest/progress.php?forceupdate=true";
	}

	$.getJSON('rest/progress.json', function(progress){
		for (i in progress.raids) {
			var raid=progress.raids[i];
			//Progress labels
			$('#progress_'+raid.id+' .nhc_caption').html(raid.nhc+" / "+raid.bosses);
			$('#progress_'+raid.id+' .hc_caption').html(raid.hc+" / "+raid.bosses);
			$('#progress_'+raid.id+' .m_caption').html(raid.m+" / "+raid.bosses);
			//Progress value + color
			var nhc_percent=100/raid.bosses*raid.nhc;
			$('#progress_'+raid.id+' .nhc_progress').val(nhc_percent);
			if (nhc_percent<100) {
				$('#progress_'+raid.id+' .nhc_progress').addClass('progress-20');
			}
			var hc_percent=100/raid.bosses*raid.hc;
			$('#progress_'+raid.id+' .hc_progress').val(hc_percent);
			if (hc_percent<100) {
				$('#progress_'+raid.id+' .hc_progress').addClass('progress-20');
			}
			var m_percent=100/raid.bosses*raid.m
			$('#progress_'+raid.id+' .m_progress').val(m_percent);
			if (m_percent<100) {
				$('#progress_'+raid.id+' .m_progress').addClass('progress-20');
			}
		}
	});

	$.getJSON('rest/settings.json', function(settings) {
		var abouttext = settings.abouttext;
		var newstext = settings.newstext;
		var lorem = "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.";

		$('#abouttext').append(abouttext);
		$('#news_body').append(newstext);
	})

	$.getJSON('rest/roster.json', function(roster) {
		// console.log(roster);
		for (i = 0; i < roster.members.length; ++i) {
			var player = roster.members[i];
			var wowclass = player.class;
			var wowname = player.name;
			var role = player.role;
			var spec = player.spec;
			var thumb = player.thumb;
			var rang = player.rang;
			var row = '';
			var server = 'http://eu.battle.net/wow/en/character/blackhand/' + wowname + '/advanced';

			//show Headers
        	if ($('#' + wowclass).text().length == 0){
        		var row2 = '<h2 class="'+ wowclass +'"><img class="class_icon" src="assets/css/images/'+ wowclass +'.png">'+ wowclass +'</h2>';
        		$('.' + wowclass +'_header').append(row2);
        	}
			$('.' + wowclass +'_header').show();

			//show chars
			row += '<li>';
			row += '<a href="' + server + '" target="_blank"><h3 class="' + wowclass + '">' + wowname + '</h3></a>';
			row += 'Role: ' + role2show(role) + '<br/>';
			row += 'Spec: ' + spec + '<br/>';
			row += 'Rang: ' + rang + '';
			row +='</li>';
        	$('#' + wowclass).append(row);
		}
	})
});
