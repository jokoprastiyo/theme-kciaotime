( function( $ ) {

$( document ).ready(function() {

  $('.nav-menu').prepend('<div class="menu-button">Menu</div>');
  $('.nav-menu .menu-button').on('click', function(){

    var menu = $(this).next('ul');
    if (menu.hasClass('open')) {

      menu.removeClass('open');
    } else {

      menu.addClass('open');
    }
  });
});
} )( jQuery );