// DLA PRZYKLEJANEGO MENU
$(document).ready(function() {
	var NavY = $('.topnav').offset().top;
	 
    var stickyNav = function()
    {
        var ScrollY = $(window).scrollTop();
            
        if (ScrollY > NavY) 
        { 
            $('.topnav').addClass('sticky');
        } 
        else 
        {
            $('.topnav').removeClass('sticky'); 
        }
	};
	 
	stickyNav();
	 
	$(window).scroll(function() {
		stickyNav();
	});
	});

// ########################################################################################################
//PŁYNNA ANIMACJA DO NAGŁÓWKA MENU

jQuery(function($)
    {
        $.scrollTo(0);
        $('#link1').click(function() { $.scrollTo($('#nag1'), 2000);  });
        $('#link2').click(function() { $.scrollTo($('#nag2'), 2000);  });
        $('#link3').click(function() { $.scrollTo($('#nag3'), 2000);  });
        $('#link4').click(function() { $.scrollTo($('#nag4'), 2000);  });
        $('#link5').click(function() { $.scrollTo($('#nag5'), 2000);  });
        $('.scrollup').click(function() { $.scrollTo($('nav'), 1500);  });

    });

    $(window).scroll(function()
    {
        if ($(this).scrollTop() > 300) $('.scrollup').fadeIn();
        else $('.scrollup').fadeOut();
    });


// ########################################################################################################
// POKAŻ PIOSENKĘ PO KLIKNIĘCIU (MUZYKA->PŁYTY)

function show_song(song_number)
{
   $("#music").html("Piosenka nr: "+song_number+'<br /><audio controls controlsList="nodownload"><source src="snd/'+song_number+'.wav" /></audio>');
}

// ########################################################################################################
// ZEGAR

function zegar()
{
    var dzisiaj = new Date();

    var dzien = dzisiaj.getDate();
    if (dzien < 10) dzien = "0"+dzien;

    var miesiac = dzisiaj.getMonth()+1;
    if (miesiac < 10) miesiac = "0"+miesiac;

    var rok = dzisiaj.getFullYear();

    var godzina = dzisiaj.getHours();
    if (godzina < 10) godzina = "0"+godzina;

    var minuta = dzisiaj.getMinutes();
    if (minuta < 10) minuta = "0"+minuta;

    var sekunda = dzisiaj.getSeconds();
    if (sekunda < 10) sekunda = "0"+sekunda;

    $("#zegar").html(dzien +"/"+ miesiac +"/"+ rok +" "+ godzina +":"+ minuta +":"+ sekunda);
    
    setTimeout(zegar, 1000);
}

// ########################################################################################################
// PAMIĘĆ

var sekunda = 0;
var minuta = 0;
var godzina = 0;
function odliczanie()
{
    sekunda++;
    if (sekunda >= 60) 
    {
        sekunda = 0;
        minuta++;
    }
    if (minuta >= 60) 
    {
        minuta = 0;
        godzina++;
    }

    $('#czas_gry').html("Czas gry: " +godzina +":"+ minuta +":"+ sekunda);
    setTimeout("odliczanie()", 1000);
}
    
function wisielec_start()
{   
    odliczanie()
}








