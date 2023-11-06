/**
 * Sticky Header
 * Adds a class to header on scroll
 */

jQuery( document ).on( 'scroll', function() {
	if ( jQuery( document ).scrollTop() > 0 ) {
		jQuery( 'header, body' ).addClass( 'shrink' );
	} else {
		jQuery( 'header, body' ).removeClass( 'shrink' );
	}
} );


jQuery( document ).ready( function( jQuery ) {

    if (navigator.userAgent.indexOf('Mac OS X') != -1) {
        jQuery("body").addClass("style-for-apple");
    } else {
        jQuery("body").addClass("style-for-window");
    }

	/**/
    (function ($) {
    "use strict";
   
    
    var $body = $('body');
    
    if ($(".has-children--multilevel-submenu").find('.submenu').length) {
        var elm = $(".has-children--multilevel-submenu").find('.submenu');
        
        elm.each(function(){
            var off = $(this).offset();
            var l = off.left;
            var w = $(this).width();
            var docH = windows.height();
            var docW = windows.width() - 10;
            var isEntirelyVisible = (l + w <= docW);

            if (!isEntirelyVisible) {
                $(this).addClass('left');
            }
        });
    }
    
    $("#mobile-menu-trigger").on('click', function(){
        $("#mobile-menu-overlay").addClass("active");
        $body.addClass('no-overflow');
    });
    
    $("#mobile-menu-close-trigger").on('click', function(){
        $("#mobile-menu-overlay").removeClass("active");
        $body.removeClass('no-overflow');
    });
    
    $(".offcanvas-navigation--onepage ul li a").on('click', function(){
        $("#mobile-menu-overlay").removeClass("active");
        $body.removeClass('no-overflow');
    });
    
    $body.on('click', function(e){
        var $target = e.target;
        if (!$($target).is('.mobile-menu-overlay__inner') && !$($target).parents().is('.mobile-menu-overlay__inner') && !$($target).is('#mobile-menu-trigger') && !$($target).is('#mobile-menu-trigger i')){
            $("#mobile-menu-overlay").removeClass("active");
            $body.removeClass('no-overflow');
        }
    });

     $('.openmenu-trigger').on('click', function (e) {
        e.preventDefault();
        $('.open-menuberger-wrapper').addClass('is-visiable');
    });

    $('.page-close').on('click', function (e) {
        e.preventDefault();
        $('.open-menuberger-wrapper').removeClass('is-visiable');
    });

    $("#open-off-sidebar-trigger").on('click', function(){
        $("#page-oppen-off-sidebar-overlay").addClass("active");
        $body.addClass('no-overflow');
    });
    
    $("#menu-close-trigger").on('click', function(){
        $("#page-oppen-off-sidebar-overlay").removeClass("active");
        $body.removeClass('no-overflow');
    });
    
   
    
    $("#hidden-icon-trigger").on('click', function(){
        $("#hidden-icon-wrapper").toggleClass("active");
    });
    
    var $offCanvasNav = $('.offcanvas-navigation'),
        $offCanvasNavSubMenu = $offCanvasNav.find('.sub-menu');
    
    
    $offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i></i></span>');
        
    $offCanvasNav.on('click', 'li a, li .menu-expand', function(e) {
        var $this = $(this);
        if ( ($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand')) ) {
            e.preventDefault();
            if ($this.siblings('ul:visible').length){
                $this.parent('li').removeClass('active');
                $this.siblings('ul').slideUp();
            } else {
                $this.parent('li').addClass('active');
                $this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
                $this.closest('li').siblings('li').find('ul:visible').slideUp();
                $this.siblings('ul').slideDown();
            }
        }
    });
    

	})(jQuery);

	jQuery('.slick').slick({
	    dots: false,
        infinite: true,
        speed: 4500,
        slidesToShow: 3,
        //cssEase: 'linear',
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        arrows: false,
        responsive: [
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 1,
              }
            },
        ]
    });

    jQuery( "#togglebtn" ).on( "click", function() { 
        if (jQuery(this).html() == '<i class="fas-icon fa-solid fa-play play-post"></i>'){
           jQuery('.slick').slick('slickPlay');
           jQuery(this).html('<i class="fas-icon fa-solid fa-pause stop-post"></i>');
       } else {
        jQuery('.slick').slick('slickPause');  
        jQuery(this).html('<i class="fas-icon fa-solid fa-play play-post"></i>'); 
    }  
    });

    jQuery('.grid-slider1').slick({
		dots: true,
		infinite: false,
        speed: 1500,
		slidesToShow: 1,
		slidesToScroll: 1,
        infinite: true,
		arrows: false,
        autoplay: true,
    });

    jQuery('.video-slider').slick({
        dots: true,
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        autoplay: false,
    });
    jQuery(".cl-right span").on( "click", function() {
        jQuery(this).addClass('active-cat').siblings().removeClass('active-cat');
    });

} );

const monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
var str = new Date().toLocaleString('en-US', { timeZone: 'America/Chicago' }); 
console.log('time'+str);
var d = new Date(str);

function updateClock() {
  // Increment the date
  d.setTime(d.getTime() + 1000);

  // Translate time to pieces
  var currentHours = (d.getHours() < 10 ? '0' : '') + d.getHours();
  var currentMinutes = d.getMinutes();
  var currentSeconds = d.getSeconds();
  var currentMonth = monthNames[d.getMonth()];
  var currentDate = (d.getDate() < 10 ? '0' : '') + d.getDate();
  var currentYear = d.getFullYear();
  // Add the beginning zero to minutes and seconds if needed
  currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
  currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

  // Add either "AM" or "PM"
  var timeOfDay = (currentHours < 12) ? "AM" : "PM";

  // Convert the hours our of 24-hour time
  currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;
  currentHours = (currentHours == 0) ? 12 : currentHours;

  // Generate the display string
  var currentTimeString = currentMonth + "    " +  currentDate + ",   " + currentYear +  "   " + currentHours + ":" + currentMinutes + "   " + timeOfDay;

  // Update the time
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}

window.onload = function() {
  updateClock();
  setInterval('updateClock()', 1000);
}

jQuery(window).load(function() {  
	jQuery(".overlay-loader").fadeOut();  
})

jQuery(function ($) {
    var $buttonTop = $('.button-top');
    $buttonTop.on('click', function () {
      $('html, body').animate({
        scrollTop: 0,
      }, 1800);
    });
  });
  var ppp = 10; // Post per page
  var pageNumber = 1;
  var filter_ppp = 10; // Post per page
  var filter_pageNumber = 1;
  var buspostperpage = 3; // Business Post per page
  var buspageNumber = 1; 
  
  jQuery(function() {
  
    jQuery('.event-search-section').hide();
  
      // For Latest News Block Variation-1 //
      jQuery("div span.cat_filter_item").on("click", function(){
          var catId = jQuery(this).attr("data-catid");
          var nopost = jQuery('#current_catone_ids').val();
          var noofpost = jQuery('#current_catno_ids').val();
          jQuery.ajax({
            type: 'POST',
            url: localVars.ajax_url,
            data: {
              action: 'filter_latest_one_column',
              catId,
              nopost,
              noofpost,
            },
            beforeSend:function(xhr){
              jQuery('.ajax_filter_res_one_col').html('');
              jQuery('.ajax_filter_res_one_col').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
            },
            success: function(data) {
              jQuery('.ajax_filter_res_one_col').html('');
              jQuery('.ajax_filter_res_one_col').html(data);
            },
            
          });
          return false;
      });
  
      // For Latest News Block Variation-2 //
      jQuery("div span.cat_filter_items").on("click", function(){
        var cattwoId = jQuery(this).attr("data-catid");
        var nopostvartwo = jQuery('#current_cattwo_ids').val();
        var noofpostvartwo = jQuery('#current_cattwono_ids').val();
        jQuery.ajax({
          type: 'POST',
          url: localVars.ajax_url,
          data: {
            action: 'filter_latest',
            cattwoId,
            nopostvartwo,
            noofpostvartwo,
          },
          beforeSend:function(xhr){
            jQuery('.ajax_filter_res').html('');
            jQuery('.ajax_filter_res').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
          },
          success: function(data) {
            jQuery('.ajax_filter_res').html('');
            jQuery('.ajax_filter_res').html(data);
          },
          
        });
        return false;
    });
  
    var sbuspostperpage = 10; // Business Post per page
    var sbuspageNumber = 1; 
    // For Search Business Directory //
   jQuery(".search_btns.event_search_btns input.business-dire-search").on("click", function(){
    jQuery('.search-bus-directory .block-heading .block-title').html('Search Results');
    var bus_cat = jQuery('#bus_category').val();
    var bus_location = jQuery('#bus_location').val();
    var bus_keyword = jQuery('#bus_keyword').val();
    var bus_dayopen = jQuery('#bus_dayopen').val();
    // Business Post per page
    sbuspageNumber++; 
    jQuery.ajax({
      type: 'POST',
      dataType: "json",
      url: localVars.ajax_url,
      data: {
        action: 'filter_business_dir_list',
        bus_cat,
        bus_location,
        bus_keyword,
        bus_dayopen,
        buspostperpage,
        buspageNumber,
      },
      beforeSend:function(xhr){
        jQuery('.bus-more-btn').hide();
        jQuery('.ajax_filter_bus_dir_list').html('');
        jQuery('.ajax_filter_bus_dir_list').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
      },
      success: function(data) {
        console.log(data.filter_bus_maxpage);
        jQuery('.ajax_filter_bus_dir_list').html(data.filter_bus_dir_html);
        if(data.filter_bus_maxpage == 'true')
        {
          console.log(data.filter_bus_maxpage);
          jQuery('.bus-more-btn').hide();
          jQuery('.ajax_filter_bus_dir_list').append('<div class="item no-more-date">No more Business Directories found!</div>');
         
        }else{
          jQuery('.bus-more-btn').html('<div class="more-event-btn">Load More</div>');
          jQuery('.bus-more-btn').show();
         
        }
       
      },
    });
    return false;
  });
  
  // For Reset Business Directory //
  jQuery(".bus_dir_reset_btn").on("click", function(){
    jQuery("#bus_dayopen").val('');
    jQuery("#bus_category").val('');
    jQuery("#bus_location").val('');
    jQuery("#bus_keyword").val('');
    jQuery('.search-bus-directory .block-heading .block-title').html('Business Directory');
    var bus_cat = jQuery('#bus_category').val();
    var bus_location = jQuery('#bus_location').val();
    var bus_keyword = jQuery('#bus_keyword').val();
    var bus_dayopen = jQuery('#bus_dayopen').val();
    sbuspostperpage = 10; // Business Post per page
    sbuspageNumber = 1; 
    jQuery.ajax({
      type: 'POST',
      dataType: "json",
      url: localVars.ajax_url,
      data: {
        action: 'filter_business_dir_list',
        bus_cat,
        bus_location,
        bus_keyword,
        bus_dayopen,
        buspostperpage,
        buspageNumber,
      },
      beforeSend:function(xhr){
        jQuery('.bus-more-btn').hide();
        jQuery('.ajax_filter_bus_dir_list').html('');
        jQuery('.ajax_filter_bus_dir_list').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
      },
      success: function(data) {
        console.log(data.filter_bus_maxpage);
        jQuery('.ajax_filter_bus_dir_list').html(data.filter_bus_dir_html);
        if(data.filter_bus_maxpage == 'true')
        {
          console.log(data.filter_bus_maxpage);
          jQuery('.bus-more-btn').hide();
         
        }else{
          jQuery('.bus-more-btn').html('<div class="more-event-btn">Load More</div>');
          jQuery('.bus-more-btn').show();
         
        }
       
      },
    });
    return false;
  });
  
  jQuery(".directory-more-btn").on("click",function(){ 
    bus_load_post();
  }); 
  
  function bus_load_post(){
    var bus_cat = jQuery('#bus_category').val();
    var bus_location = jQuery('#bus_location').val();
    var bus_keyword = jQuery('#bus_keyword').val();
    var bus_dayopen = jQuery('#bus_dayopen').val();
    sbuspageNumber++;
    jQuery.ajax({
      type: 'POST',
      url: localVars.ajax_url,
      dataType: "json",
      data: {
        action: 'loadmore_filter_search_buss_dir',
        bus_cat,
        bus_location,
        bus_keyword,
        bus_dayopen,
        sbuspostperpage,
        sbuspageNumber,
      },
      beforeSend:function(xhr){
        
        jQuery('.bus-more-btn').html('');
        jQuery('.bus-more-btn').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
      },
      success: function(data) {
        jQuery('.ajax_filter_bus_dir_list').append(data.more_bus_dir_html);
        console.log(data.more_bus_maxpage);
        if(data.more_bus_maxpage == 'true')
        {
         
          jQuery('.bus-more-btn').html('');
          jQuery('.ajax_filter_bus_dir_list').append('<div class="item no-more-date">No more Business Directories found!</div>');
         
        }else{
          jQuery('.bus-more-btn').html('<div class="more-event-btn">Load More</div>');
         
        }
      },
  
    });
    return false;
  }
  
  // End Business Directory //
  
  if ( jQuery( "#form1" ).length ) {
    jQuery("#form1").validate({
      // Define validation rules
      rules: {
          business_name: "required",
          phone: "required",
          email: "required",
          business_name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          phone: {
            required: true,
            minlength: 10,
            maxlength: 10,
            number: true
          },
          cat: {
            required: true,
          },
      },
    // Specify validation error messages
      messages: {
          business_name: "Please provide a valid business name.",
          email: {
            required: "Please enter your email",
            minlength: "Please enter a valid email address"
          },
          phone: {
            required: "Please provide a phone number",
            minlength: "Phone number must be min 10 characters long",
            maxlength: "Phone number must not be more than 10 characters long"
          },
          cat: {
            required: "Please Select Category"
          },
      },
      submitHandler: function (form) {
          form.submit();
      }
    }); 
  }
     
    jQuery(".btn-dark").on("click", function(){
    jQuery("#form1").valid();
  });
  
      if ( jQuery( "#event_form_entry" ).length ) {
        jQuery("#event_form_entry").validate({
          // Define validation rules
          rules: {
              venue: "required",
              description: "required",
              venue: {
                required: true,
              },
              description: {
                required: true,
              },
          },
        // Specify validation error messages
          messages: {
              venue: "Please provide a venue details.",
              description: "Please provide a description.",
              
          },
          submitHandler: function (form) {
              form.submit();
          }
        }); 
      }
  
      jQuery(".event-btn").on("click", function(){
        jQuery("#event_form_entry").valid();
      });
  
      jQuery(".video-slider .item .fa-play").on("click", function(){
        jQuery(this).next().click();
        jQuery(this).hide();
      });
  
  // For Event Search Filter Search Click Event //
  jQuery(".events_reset_btn").on("click", function(){
  
    jQuery('.event-search-section').hide();
  });
  jQuery(".btn-event-search-filter").on("click", function(){
  
        jQuery('.event-search-section').show();
        jQuery('.event-search-section .block-title').html('Search results');
        var filter_date = jQuery('.filter-event-date').val();
        var filter_location = jQuery('.filter-event-location').val();
        var filter_text = jQuery('.filter-event-text').val();
        //pageNumber = 1;
          jQuery.ajax({
          type: 'POST',
          url: localVars.ajax_url,
          dataType: "json",
          data: {
            action: 'filter_search_event',
            filter_date,
            filter_location,
            filter_text,
           
          },
          beforeSend:function(xhr){
            jQuery('.event-more-btn').html('');
            jQuery('.upcoming_ajax_event_filter_search_res').html('');
            jQuery('.upcoming_ajax_event_filter_search_res').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
          },
          success: function(data) {
  
            jQuery('.upcoming_ajax_event_filter_search_res').html('');
            jQuery('.upcoming_ajax_event_filter_search_res').html(data.uhtml);
            
            console.log(data.up_maxpage);
            if(data.up_maxpage == 'true')
            {
              jQuery('.event-more-btn').html('');
             
            }else{
              jQuery('.event-more-btn').html('<div class="more-event-btn">Load More</div>');
             
            }
          },
          
          });
  
          jQuery([document.documentElement, document.body]).animate({
            scrollTop: jQuery(".upcoming_ajax_event_filter_search_res").offset().top - 100
          }, 2000);
  
        return false;
        });
  if(jQuery('.featured_events_slider').length > 0) {
        jQuery('.featured_events_slider').slick({
          infinite: true,
          autoplay: true,
          arrows: false,
          dots: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
    }
        jQuery('.single_event_img_slider').slick({
          infinite: true,
          autoplay: true,
          arrows: false,
          dots: true,
          slidesToShow: 1,
          slidesToScroll: 1,
        });
  
        jQuery('.sq-dots').slick({
          infinite: true,
          autoplay: true,
          arrows: false,
          dots: true,
          slidesToShow: 1,
          slidesToScroll: 1,
        });
  
        jQuery('.bus_dir_img_slider').slick({
          infinite: true,
          autoplay: true,
          arrows: false,
          dots: true,
          slidesToShow: 1,
          slidesToScroll: 1,
        });
  
        jQuery('.grid-slider-partners').slick({
          infinite: true,
          autoplay: true,
          arrows: false,
          dots: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
  
        jQuery('.single-posts-img-slider').slick({
          infinite: true,
          autoplay: true,
          arrows: false,
          dots: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
  
        jQuery(".more_up_event_posts_btn").on("click",function(){ 
          load_posts();
        });
        jQuery(".more_event_posts_btn").on("click",function(){ 
          event_filter_load_posts();
        });
  });
  ``
  
  // Make Primium Business //
  function make_primium(obj){
  
    var bid = "" ;
    
      bid =jQuery(obj).attr("data-id"); 
  
    jQuery.ajax({
      type: 'POST',
      url: localVars.ajax_url,
      data: {
        action: 'make_business_premium',
        bid,
        
      },
      beforeSend:function(xhr){
  
        jQuery(obj).html(" <div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>"); 
      },
      success: function(data) {
        jQuery('.ajax_filter_res_onethree_col').html('');
        
        var result = JSON.parse(data);
        if(result.success){
          location.reload();
        }
      },
      
    });
   
  }
  function checkout_primium(check_obj){
    var prod_id_arr = new Array();
    var bid = "" ; 
    var val = [];
    
    if(jQuery(check_obj).attr("data-id") != "")
    {
      bid =jQuery(check_obj).attr("data-id");
      localStorage.removeItem('bid');
    localStorage.setItem("bid", JSON.stringify(bid));
    }else{
      
      jQuery("input[class='chkbox']:checked").each(function() {
        // Add the selected value to the array
        val.push(jQuery(this).val());
      });
      bid =  val.join(",");
      localStorage.removeItem('bid');
      localStorage.setItem("bid", JSON.stringify(bid));
      
    }
  
    var obj = {
      prod_id: jQuery(check_obj).attr("data-prod-id"),
      qty:bid.split(",").length,
      prd_tot: jQuery(check_obj).attr("data-tot"),
      start_date: 'na',
      no_of_month : 'na',
      base_price: jQuery(check_obj).attr("data-tot"),
      
  };
  
  prod_id_arr.push(obj);
    jQuery.ajax({
      type: 'POST',
      url: localVars.ajax_url,
      data: {
        action: "add_prod_to_cart",
                  prod_id_arr,
      },
      beforeSend:function(xhr){
        jQuery(check_obj).html(" <div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>"); 
  
      },
      success: function(data) {
        jQuery('.ajax_filter_res_onethree_col').html('');
        
        //var result = JSON.parse(data);
       
          location.href = "/checkout/";
        
      },
      
    });
  }
  
  function load_posts(){
    var filter_date = jQuery('.filter-event-date').val();
    var filter_location = jQuery('.filter-event-location').val();
    var filter_text = jQuery('.filter-event-text').val();
  
    pageNumber++;
    jQuery.ajax({
      type: 'POST',
      url: localVars.ajax_url,
      dataType: "json",
      data: {
        action: 'loadmore_up_filter_search_event',
        filter_date,
        filter_location,
        filter_text,
        ppp,
        pageNumber,
      },
      beforeSend:function(xhr){
        
        jQuery('.up-event-more-btn').html('');
        jQuery('.up-event-more-btn').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
      },
      success: function(data) {
        jQuery('.upcoming_ajax_more_event_res').append(data.more_event_html);
  
  
        if(data.more_maxpage == 'true')
        {
          console.log(data.more_maxpage);
          jQuery('.up-event-more-btn').html('');
          jQuery('.upcoming_ajax_more_event_res').append('<div class="item no-more-date">No more Events found!</div>');
         
        }else{
          jQuery('.up-event-more-btn').html('<div class="more-event-btn">Load More</div>');
         
        }
      },
  
    });
    return false;
  }
  
  function event_filter_load_posts(){
    var filter_date = jQuery('.filter-event-date').val();
    var filter_location = jQuery('.filter-event-location').val();
    var filter_text = jQuery('.filter-event-text').val();
  
    filter_pageNumber++;
    jQuery.ajax({
      type: 'POST',
      url: localVars.ajax_url,
      dataType: "json",
      data: {
        action: 'loadmore_filter_search_event',
        filter_date,
        filter_location,
        filter_text,
        filter_ppp,
        filter_pageNumber,
      },
      beforeSend:function(xhr){
        
        jQuery('.event-more-btn').html('');
        jQuery('.event-more-btn').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
      },
      success: function(data) {
        jQuery('.upcoming_ajax_event_filter_search_res').append(data.more_event_html);
        if(data.more_maxpage == 'true')
        {
        
          jQuery('.event-more-btn').html('');
          jQuery('.upcoming_ajax_event_filter_search_res').append('<div class="item no-more-date">No more Events found!</div>');
         
        }else{
          jQuery('.event-more-btn').html('<div class="more-event-btn">Load More</div>');
         
        }
      },
  
    });
    return false;
  }
  
  jQuery(function() {
    var mindate_today = new Date();
    function subtractDays(date, days) {
      date.setDate(date.getDate() - days);
    
      return date;
    }
    var newDate = subtractDays(mindate_today, 14);
    
    // May 10, 2022
    console.log(newDate);
      var dd = String(newDate.getDate()).padStart(2, '0');
      var mm = String(newDate.getMonth() + 1).padStart(2, '0');
      var yyyy = newDate.getFullYear();
  
      mindate_today = mm + '-' + dd + '-' + yyyy;
  
      var is_date_picket_exists = document.getElementsByName("eventdatefilter").length;
      if (typeof(is_date_picket_exists) != 'undefined' && is_date_picket_exists != null && is_date_picket_exists > 0) {

        jQuery('input[name="eventdatefilter"]').daterangepicker({
          opens: 'left',
          minDate: mindate_today,
          autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        }, function(start, end, label) {
          console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
     }
  
    jQuery('input[name="eventdatefilter"]').on('apply.daterangepicker', function(ev, picker) {
      jQuery(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
  
    jQuery('input[name="eventdatefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      jQuery(this).val('');
    });
  
    var waukesha_state  =  [
      "Big Bend",
      "Brookfield",
      "Butler",
      "Delafield",
      "Dousman",
      "Eagle",
      "Elm Grove",
      "Genesee Depot",
      "Hartland",
      "Lannon",
      "Menomonee Falls",
      "Merton",
      "Mukwonago",
      "Muskego",
      "Nashotah",
      "New Berlin",
      "North Lake",
      "North Prairie",
      "Oconomowoc",
      "Okauchee",
      "Pewaukee",
      "Sussex",
      "Wales",
      "Waukesha",
  ];
    jQuery( "#bus_location" ).autocomplete({
      source: waukesha_state, minLength:0
    }).on('focus', function() { jQuery(this).keydown(); });
  
    jQuery("#event_location").autocomplete({
          source: waukesha_state, minLength:0
      }).on('focus', function() { jQuery(this).keydown(); });
  
  });
  
  jQuery( document ).ready(function($) {
    $('.calendar-icon').click(function(event){
      event.preventDefault();
      $('input[name="eventdatefilter"]').trigger('click');
  })
    // jQuery('span.calendar-icon').on("click", function(){
      // 	if(jQuery('.daterangepicker').css('display') == 'none')
      // 	{	
      // 		jQuery('.daterangepicker').show();
      // 	}else{
      // 		jQuery('.daterangepicker').hide();
      // 	}
      // }); 
  
  
      var yintppp = jQuery('#pagin_no').val(); // Post per page
      var yintpageNumber = 1;
    var exclude_posts = jQuery('#exc_posts').val();
      
  
    function yint_load_posts(){
      var yint_category = jQuery('.more_story_cat').val();
      yintpageNumber++;
      jQuery.ajax({
        type: 'POST',
        url: localVars.ajax_url,
        dataType: "json",
        data: {
          action: 'load_more_post_you_may_be_interested_in_ajax',
          yintppp,
          yintpageNumber,
          yint_category,
          exclude_posts,
        },
        beforeSend:function(xhr){
          
          jQuery('.yint-more-btn').html('');
          jQuery('.yint-more-btn').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
        },
        success: function(data) {
          jQuery('.ajax-more-stories').append(data.yint_event_html);
          if(data.yint_maxpage == 'true')
          {
            console.log(data);
            jQuery('.yint-more-btn').html('');
            jQuery('.ajax-more-stories').append('<div class="item no-more-date">No more Stories found!</div>');
  
          }else{
            jQuery('.yint-more-btn').html('<div class="more-event-btn">Load More</div>');
           
          }
        },
    
      });
      return false;
    }
      $("#yint_more_posts").on("click",function(){ // When btn is pressed.
      
      yint_load_posts();
      
   });
      
  });
  
  
  function update_total(obj) {
      var pid = jQuery(obj).attr("data-prod-id");
      var f_total = 0;
      var total = 0;
      var number_of_month = parseInt(jQuery("#number_of_month_" + pid).val());
      var f_url = "?add-to-cart=";
      var q_url = "&quantity=";
  
      var qty = jQuery(obj).find(":selected").val();
      var price = jQuery(obj).attr("data-price");
  
  
      total =
          parseInt(jQuery("#prod_id_" + pid).val()) *
          parseInt(price);
          
  if(jQuery("#number_of_month_" + pid).length > 0 ){
    total = total *number_of_month;
  }
      jQuery("#total_" + pid).html(addZeroes(total));
      // if(qty > 0){
      //   add_to_cart.push(pid);
      //   f_quantity.push(qty);
      // }else{
      //   const index = add_to_cart.indexOf(pid);
      //   const index_qty = f_quantity.indexOf(qty);
  
      //  add_to_cart.splice(index, 1);
      //  f_quantity.splice(index_qty, 1);
      // }
  
      jQuery(".prod").each(function (index, item) {
          // console.log(jQuery(item).find(':selected').val());
          if (jQuery(item).find(":selected").val() > 0) {
              var prod_id = jQuery(item).data("prod-id");
              f_total = f_total + parseInt(jQuery("#total_" + prod_id).html());
              f_url += prod_id + ",";
  
              q_url +=
                  jQuery("#prod_id_" + prod_id)
                      .find(":selected")
                      .val() + ",";
          }
      });
      // for (let i = 0; i < add_to_cart.length; i++) {
      //   f_url += add_to_cart[i] + ",";
      //  // if(jQuery('#prod_id_'+add_to_cart[i]).attr("data-prod-id") == add_to_cart[i]){
      //   q_url += jQuery('#prod_id_'+add_to_cart[i]).find(':selected').val() + ",";
      //  // console.log(jQuery("#prod_id_"+add_to_cart[i]+" option:selected").val());
      //  // f_total = f_total + parseInt(jQuery('#total_'+add_to_cart[i]).html());
      // //  }
      // //console.log(parseInt(jQuery('#total_'+add_to_cart[i]).html()));
      // }
      jQuery("#g_tot").html(addZeroes(f_total));
      //document.getElementById('submit_btn').setAttribute('href','/focus-waukesha/cart/'+f_url.slice(',', -1)+q_url.slice(',', -1));
  
      console.log(
          document.location.host +
              "/cart/" +
              f_url.slice(",", -1) +
              q_url.slice(",", -1)
      );
      //http://localhost/focus-waukesha/test/?add-to-cart=150,198&quantity=2,3
  }
  var IdAddtocart = 0;
  jQuery(function() {
      jQuery("#prod_submit_btn").on("click", function (e) {
          e.preventDefault();
          //     jQuery('.modal').toggleClass('is-visible');
          if (jQuery("#cart_val").val() == "n") {
              //alert(jQuery("#cart_val").val());
              jQuery("#confirmModal").toggleClass("is-visible");
        jQuery('body').addClass('cart-popup');
          } else {
              jQuery("#ok").trigger("click");
          }
      });
  
      jQuery("#ok").on("click", function (e) {
      localStorage.removeItem('bid');
      localStorage.removeItem('eid');
      localStorage.removeItem('f_eid');
          var prod_id_arr = new Array();
          var obj = {};
          jQuery(".prod").each(function (index, item) {
              if (jQuery(item).find(":selected").val() > 0) {
                  var prod_id = jQuery(item).data("prod-id");
          var start_dt = "na";
          var prdtot = jQuery('#total_' + prod_id).html();
          var prod_no_of_month = "na";
          if(jQuery('#number_of_month_' + prod_id).length > 0 ){
            prod_no_of_month =jQuery('#number_of_month_' + prod_id).val();
          }
          if(jQuery('#start_date_' + prod_id).length > 0 ){
            start_dt =jQuery('#start_date_' + prod_id).val();
            prdtot = prod_no_of_month * jQuery(item).data("price");
          }
          var obj = {
            prod_id: prod_id,
            qty: jQuery(item).find(":selected").val(),
            prd_tot: prdtot,
            start_date: start_dt,
            no_of_month : prod_no_of_month,
            base_price: jQuery(item).data("price")
        };
                  // f_url += prod_id + ",";
                  // obj['prod_id'] = prod_id;
                  // obj['qty'] = jQuery(item).find(":selected").val();
                  // obj['prd_tot'] = jQuery('#total_'+prod_id).html();
                  // prod_id_arr.push({prod_id,jQuery(item).find(':selected').val()});
                  //q_url += jQuery('#prod_id_'+prod_id).find(':selected').val() + ",";
          prod_id_arr.push(obj);
              }
        
          });
          
          jQuery.ajax({
              type: "POST",
              url: localVars.ajax_url,
              data: {
                  action: "add_prod_to_cart",
                  prod_id_arr,
              },
              beforeSend: function () {
                  if (jQuery("#cart_val").val() == "n") {
                      //jQuery("#confirmModal").toggleClass("is-visible");
                  }
                  jQuery("#ok").html("");
                  jQuery("#ok").html(
                      "<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>"
                  );
              },
              success: function (data) {
          
                  jQuery("#s_msg").html("");
                  jQuery("#s_msg").html("Successfully added to cart");
                  //jQuery('#prod_submit_btn').html('');
                  //jQuery('#prod_submit_btn').html(data);
                  if (jQuery("#additional_comment").val() != "") {
                      localStorage.setItem(
                          "order_comment",
                          jQuery("#additional_comment").val()
                      );
                  }
          if( jQuery("#provide").is(":checked")){
            localStorage.setItem(
                          "provide_content",
                          'Yes'
                      );
            localStorage.removeItem("need_assistance");
          }
          
          if(jQuery("#assistance").is(":checked")){
            localStorage.setItem(
                          "need_assistance",
                          'Yes'
                      );
            localStorage.removeItem("provide_content");
          }
  
                  location.href = "/cart/";
              },
          });
      });
      jQuery("#no").on("click", function (e) {
          jQuery("#confirmModal").toggleClass("is-visible");
      jQuery('body').removeClass('cart-popup');
      });
  
    jQuery(".btn-search-page-filter").on("click", function (e) { 
      var sValue = jQuery('.search-keyword-text').val();
      var catValue = jQuery('.search-category-text').val();
  
      var tagValue = jQuery('.search-tag-text').val();
      tagValue = tagValue.replace(/\s+/g, '-').toLowerCase();
  
      var typeValue = jQuery('.search_post_type').val();
      var url = '/?s=' + sValue +'&cat=' + catValue + '&tag=' + tagValue + '&type=' + typeValue;
      window.location.replace(url);
    });
  
    jQuery(".search_reset_btn").on("click", function (e) {
     
  
      var url = '/?s=';
      window.location.replace(url);
    });
  
  
  });
  
  // jQuery(document).ready(function() {
  //
  //   // Select all checkboxes
  //   var checkboxes = jQuery("input[type='checkbox']");
  
  //   // Attach a change event listener to checkboxes
  //   checkboxes.change(function() {
  //     // Check if all checkboxes are selected
  //     var allSelected = checkboxes.length === checkboxes.filter(":checked").length;
  
  //     // Enable or disable the button based on checkbox selection
  //     if (allSelected) {
  //       jQuery("#prod_submit_btn").prop("disabled", false);
  //     } else {
  //       jQuery("#prod_submit_btn").prop("disabled", true);
  //     }
  //   });
  // });
  jQuery(function() {
    if(localStorage.getItem("order_comment") != "" && localStorage.getItem("order_comment") != 'undefined'){
      jQuery("#order_comments").val(localStorage.getItem("order_comment"));
      }
      if(localStorage.getItem("provide_content") != "" && localStorage.getItem("provide_content") != 'undefined'){
      jQuery("#billing_opt_for_provide_content").val(localStorage.getItem("provide_content"));
      }
      if(localStorage.getItem("need_assistance") != "" && localStorage.getItem("need_assistance") != 'undefined'){
      jQuery("#billing_opt_for_need_assistance").val(localStorage.getItem("need_assistance"));
      }
      // Select all checkboxes and select boxes
      var checkboxes = jQuery("input[type='checkbox']");
      var selectBoxes = jQuery(".prod");
  
      // Attach change event listeners to checkboxes and select boxes
      checkboxes.change(checkIfEnableButton);
      selectBoxes.change(checkIfEnableButton);
  
      function checkIfEnableButton() {
          // Check if all checkboxes are selected
          var isprodqty = false;
  
          //var allCheckboxesSelected = checkboxes.length === checkboxes.filter(":checked").length;
  
          // Check if any select box is selected
          var anySelectBoxSelected = selectBoxes.find(":selected").length > 0;
  
          // Enable or disable the button based on checkbox and select box selection
          jQuery(".prod").each(function (index, item) {
              if (jQuery(item).find(":selected").val() > 0) {
                  isprodqty = true;
              }
          });
  
          if (
              anySelectBoxSelected &&
              isprodqty &&
              checkboxes.is("#acknowledgement:checked") &&
              checkboxes.is("#agree:checked")
          ) {
              jQuery("#prod_submit_btn").prop("disabled", false);
          } else {
              jQuery("#prod_submit_btn").prop("disabled", true);
          }
      }
  });
  
  
    (function( $ ) {
  
      /**
       * initMap
       *
       * Renders a Google Map onto the selected jQuery element
       *
       * @date    22/10/19
       * @since   5.8.6
       *
       * @param   jQuery $el The jQuery element.
       * @return  object The map instance.
       */
      function initMap( $el ) {
      
          // Find marker elements within map.
          var $markers = $el.find('.marker');
      
          // Create gerenic map.
          var mapArgs = {
              zoom        : $el.data('zoom') || 16,
              mapTypeId   : google.maps.MapTypeId.ROADMAP
          };
          var map = new google.maps.Map( $el[0], mapArgs );
      
          // Add markers.
          map.markers = [];
          $markers.each(function(){
              initMarker( $(this), map );
          });
      
          // Center map based on markers.
          centerMap( map );
      
          // Return map instance.
          return map;
      }
      
      /**
       * initMarker
       *
       * Creates a marker for the given jQuery element and map.
       *
       * @date    22/10/19
       * @since   5.8.6
       *
       * @param   jQuery $el The jQuery element.
       * @param   object The map instance.
       * @return  object The marker instance.
       */
      function initMarker( $marker, map ) {
      
          // Get position from marker.
          var lat = $marker.data('lat');
          var lng = $marker.data('lng');
          var latLng = {
              lat: parseFloat( lat ),
              lng: parseFloat( lng )
          };
      
          // Create marker instance.
          var marker = new google.maps.Marker({
              position : latLng,
              map: map
          });
      
          // Append to reference for later use.
          map.markers.push( marker );
      
          // If marker contains HTML, add it to an infoWindow.
          if( $marker.html() ){
      
              // Create info window.
              var infowindow = new google.maps.InfoWindow({
                  content: $marker.html()
              });
      
              // Show info window when marker is clicked.
              google.maps.event.addListener(marker, 'click', function() {
                  infowindow.open( map, marker );
              });
          }
      }
      
      /**
       * centerMap
       *
       * Centers the map showing all markers in view.
       *
       * @date    22/10/19
       * @since   5.8.6
       *
       * @param   object The map instance.
       * @return  void
       */
      function centerMap( map ) {
      
          // Create map boundaries from all map markers.
          var bounds = new google.maps.LatLngBounds();
          map.markers.forEach(function( marker ){
              bounds.extend({
                  lat: marker.position.lat(),
                  lng: marker.position.lng()
              });
          });
      
          // Case: Single marker.
          if( map.markers.length == 1 ){
              map.setCenter( bounds.getCenter() );
      
          // Case: Multiple markers.
          } else{
              map.fitBounds( bounds );
          }
      }
      
      // Render maps on page load.
      jQuery(function($) {
      
          $('.acf-map').each(function(){
              var map = initMap( $(this) );
          });
      });
      
      })(jQuery);
      jQuery(()=> {
              jQuery('.cart-icon').click(function(){
                  jQuery('.cart-dropdown').addClass("show");
              });
              jQuery('.close-icon').click(function(){
                  jQuery('.cart-dropdown').removeClass('show');
              })
          })
  
      jQuery( document ).ready(function($) {
        function search_load_more(){
          
          var data = {
        'action': 'search_loadmore',
        'query': localVars.posts, // that's how we get params from wp_localize_script() function
        'page' : localVars.current_page
      };
        
          jQuery.ajax({
            type: 'POST',
            url: localVars.ajax_url,
            dataType: "json",
            data: data,
            beforeSend:function(xhr){
              
              jQuery('.search-more-btn').html('');
              jQuery('.search-more-btn').html("<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>");
            },
            success: function(data) {
    
              var result = JSON.stringify(data);
              if( data.data != "" ) { 
                
                jQuery('.search-more-btn').html('');
                jQuery('.cls_loadmore').text( 'Load More' ).prev().after();
                jQuery('.ajax-blog-post').append(data.data);
                // insert new posts
                localVars.current_page++;
       
                if ( localVars.current_page == localVars.max_page ) {
                
                  jQuery('.cls_loadmore').hide(); // if last page, remove the button
                }
                // you can also fire the "post-load" event here if you use a plugin that requires it
              } else {
                jQuery('.cls_loadmore').hide(); // if no data, remove the button as well
              }
            },
        
          });
          return false;
        }
        jQuery("#search_test").on("click",function(){ // When btn is pressed.
         
          search_load_more();
          
       });
        var toggleButtons = document.getElementsByClassName('toggleone');
        var modals = document.getElementsByClassName('modal');
  
        for (var i = 0; i < toggleButtons.length; i++) {
          toggleButtons[i].addEventListener('click', showModal.bind(null, i));
        }
        function showModal(index) {
          for (var i = 0; i < modals.length; i++) {
            if (i === index) {
              modals[i].classList.add('is-visible');
            } else {
              modals[i].classList.remove('is-visible');
            }
          }
        }
        var modalCloses = document.getElementsByClassName('modal-close');
        for (var i = 0; i < modalCloses.length; i++) {
          modalCloses[i].addEventListener('click', closeModal);
        }
  
        function closeModal() {
          for (var i = 0; i < modals.length; i++) {
            modals[i].classList.remove('is-visible');
          }
        }
  
        jQuery(".toggleone").click(function(){
          jQuery('body').addClass('staff-popup');
        });
        jQuery(".modal-close").click(function(){
          jQuery('body').removeClass('staff-popup');
        });
        jQuery('.modal-overlay').click(function(){
          jQuery('.modal').removeClass('is-visible');
          jQuery('body').removeClass('staff-popup');
        })
  
        document.addEventListener('DOMContentLoaded', function() {
          var urlParams = new URLSearchParams(window.location.search);
          
          if (urlParams.has('signupfornewsletter')) {
              PUM.open(1170);
          } 
        });
      });
  
  
      jQuery(function($) {
    if(jQuery("#hid_select_business").length > 0 ){
  
      jQuery("#hid_select_business").val(JSON.parse(localStorage.getItem("bid")));
    }
    if(jQuery("#hid_select_event").length > 0 ){
  
      jQuery("#hid_select_event").val(JSON.parse(localStorage.getItem("eid")));
    }
    if(jQuery("#hid_select_event_prod").length > 0 ){
  
      jQuery("#hid_select_event_prod").val(JSON.parse(localStorage.getItem("eval")));
    }
  
    if(jQuery("#hid_select_event_featured").length > 0 ){
  
      jQuery("#hid_select_event_featured").val(JSON.parse(localStorage.getItem("f_eid")));
    }
    if(jQuery("#hid_select_event_prod_featured").length > 0 ){
  
      jQuery("#hid_select_event_prod_featured").val(JSON.parse(localStorage.getItem("f_eval")));
    }
    // hide the topbutton on page load/ready.
    jQuery('.button-top').hide();
  
    //Check to see if the window is top if not then display button
    jQuery(window).scroll(function(){
        if (jQuery(this).scrollTop() > 100) {
            jQuery('.button-top').show().fadeIn();
        } else {
            jQuery('.button-top').fadeOut().hide();
        }
    });
    
  });
  function addZeroes(num) {
    return num.toLocaleString("en", {useGrouping: false, minimumFractionDigits: 2})
  }
  
  //Accordian on /my-account/account-details/ Page.
  jQuery( document ).ready(function() {
  if (jQuery('body').hasClass('woocommerce-account')) {
    jQuery('.details-wrapper').show();
    jQuery('.item-title').addClass('active-tab');
    jQuery('.item-title').each(function(){
        jQuery(this).click(function(){
           jQuery(this).next('.details-wrapper').slideToggle();
           jQuery(this).toggleClass('active-tab');
        });
    });
  }
  
  });
  
  function make_event(obj){
    var eid = jQuery(obj).attr("data-id");
    var efeatured = jQuery(obj).attr("data-featured");
    jQuery.ajax({
      type: 'POST',
      url: localVars.ajax_url,
      data: {
        action: 'make_event_featured',
        eid,
        efeatured,
      },
      beforeSend:function(xhr){
        jQuery(obj).html(" <div class='section-loader'><div class='loader'> <div></div> </div></div>"); 
      },
      success: function(data) {
        //jQuery('.featured_action').html('');
        //jQuery('.featured_action').html('<span>Featured</span>');
        
        var result = JSON.parse(data);
        if(result.success){
          location.reload();
        }
      },
      
    });
   
  }
  
  jQuery(function() {
    jQuery(document).on('change', '[name="sel_businesses[]"]', function() {
      var checkbox = jQuery(this);
      var value = checkbox.val();
      console.log(value);
     
      if (checkbox.is(':checked'))
      {
        jQuery('#buy_multi_premium').removeAttr('disabled');
      }else
      {
        jQuery('#buy_multi_premium').attr("disabled", true);
      }
    });
    
  
    jQuery('#chk_all').click(function(){
        if(this.checked){
            jQuery(".chkbox").prop("checked", true);
            jQuery('#buy_multi_premium').removeAttr('disabled');
            
        }else{
            jQuery(".chkbox").prop("checked", false);
            jQuery('#buy_multi_premium').attr("disabled", true);
           
        }
    });
  
    jQuery(document).on('change', '[name="sel_event[]"]', function() {
      var checkbox = jQuery(this);
      var value = checkbox.val();
      console.log(value);
     
      if (checkbox.is(':checked'))
      {
        jQuery('#buy_multi_event_basic').removeAttr('disabled');
        jQuery('#buy_multi_event_featured').removeAttr('disabled');
      }else
      {
        jQuery('#buy_multi_event_basic').attr("disabled", true);
        jQuery('#buy_multi_event_featured').attr("disabled", true);
      }
    });
    
    jQuery('#event_chk_all').click(function(){
      if(this.checked){
          jQuery(".event_chkbox").prop("checked", true);
          jQuery('#buy_multi_event_basic').removeAttr('disabled');
          jQuery('#buy_multi_event_featured').removeAttr('disabled');
          
      }else{
          jQuery(".event_chkbox").prop("checked", false);
          jQuery('#buy_multi_event_basic').attr("disabled", true);
          jQuery('#buy_multi_event_featured').attr("disabled", true);
         
      }
    });
    jQuery('.event_active').on('click', function() {
      
      var modal = jQuery("#submit-event-modal");
            var event_id = jQuery(this).data("id");
            var event_title = jQuery(this).data("title");
            jQuery('.e_popup_title').text(event_title);
            jQuery('.e_popup_btn').attr('data-id',event_id);
  
            var event_action = jQuery(this).data("action");
            var event_mkb = jQuery(this).data("mkb");
            var event_mkf = jQuery(this).data("mkf");
  
            //alert(event_action + "| Bs: " + event_mkb + "| FR: " + event_mkf);
            modal.show();
            modal.addClass("is-visible");
            if(event_mkb == true) {
              console.log("if Bs: " + event_mkb);
              jQuery('div.item_make_basic').show();
              jQuery('div.item_make_basic').addClass("is-visible");
            } else {
              console.log("else Bs: " + event_mkb);
              jQuery('div.item_buy_basic').show();
              jQuery('div.item_buy_basic').addClass("is-visible");
            }
  
            if(event_mkf == true) {
              console.log("if FR: " + event_mkf);
              jQuery('div.item_make_featured').show();
              jQuery('div.item_make_featured').addClass("is-visible");
            } else {
              console.log("else FR: " + event_mkf);
              jQuery('div.item_buy_featured').show();
              jQuery('div.item_buy_featured').addClass("is-visible");
            }
            
            if((event_mkb == true && event_mkf == false) || (event_mkb == false && event_mkf == true)){
              jQuery("div.modal-footer").addClass('displayBothBtn');
            }else{
              jQuery("div.modal-footer").removeClass('displayBothBtn');
            }
  
    });
    jQuery('.close_popup').on('click', function() {
      jQuery(this).parents('#submit-event-modal').removeClass("is-visible");
      jQuery('.e_popup_title').text('');
      jQuery('.e_popup_btn').attr('data-id','');
      jQuery(this).parents('#submit-event-modal').removeClass("is-visible");
      
      jQuery('div.item_make_basic').hide()
      jQuery('div.item_make_featured').hide()
      jQuery('div.item_make_basic').removeClass("is-visible");
      jQuery('div.item_make_featured').removeClass("is-visible");
  
      jQuery('div.item_buy_basic').hide()
      jQuery('div.item_buy_featured').hide()
      jQuery('div.item_buy_basic').removeClass("is-visible");
      jQuery('div.item_buy_featured').removeClass("is-visible");
      jQuery("div.modal-footer").removeClass('displayBothBtn');
    });
  
  });
  
  jQuery(function() {
    var values=JSON.parse(localStorage.getItem("bid"));
    if(values != null){
     var bqty =0;
      jQuery.each(values.split(","), function(i,e){
        bqty = bqty +1;
          jQuery("#select_business option[value='" + e + "']").prop("selected", true);
      });
      // jQuery("#select_business").attr("disabled", true);
      jQuery(".sel_bus_msg").hide();
      jQuery(".presel_note").show();
  
    }
    
    var eid_values=JSON.parse(localStorage.getItem("eid"));
    if(eid_values != null){
    var eqty =0;
      jQuery.each(eid_values.split(","), function(i,e){
        eqty = eqty +1;
          jQuery("#select_event option[value='" + e + "']").prop("selected", true);
      });
      jQuery("select_event").attr("disabled", true);
      //jQuery(".sel_bus_msg").hide();
      jQuery(".presel_event_note").show();
    }
  
    var f_eid_values=JSON.parse(localStorage.getItem("f_eid"));
    if(f_eid_values != null){
    var f_eqty =0;
      jQuery.each(f_eid_values.split(","), function(i,e){
        f_eqty = f_eqty +1;
          jQuery("#select_event_featured option[value='" + e + "']").prop("selected", true);
      });
      jQuery("#select_event_featured").attr("disabled", true);
      //jQuery(".sel_bus_msg").hide();
      jQuery(".presel_event_note").show();
    }
  
        // Function to prevent duplicate selections
      function preventDuplicateSelection() {
        const field1 = document.getElementById("select_event");
        const field2 = document.getElementById("select_event_featured");
  
        field1.addEventListener("change", function () {
          const selectedOptions = Array.from(field1.selectedOptions).map(option => option.value);
          for (const option of field2.options) {
            option.disabled = selectedOptions.includes(option.value);
          }
        });
  
        field2.addEventListener("change", function () {
          const selectedOptions = Array.from(field2.selectedOptions).map(option => option.value);
          for (const option of field1.options) {
            option.disabled = selectedOptions.includes(option.value);
          }
        });
      }
  
      
      if(jQuery('#select_event').length > 0 ){
      preventDuplicateSelection();
    };
  });
  
  function checkout_event(check_obj){
    var prod_id_arr = new Array();
    var eid = "";
    var eval = ""; 
    var val = [];
    
    if(jQuery(check_obj).attr("data-id") != "")
    {
      eid =jQuery(check_obj).attr("data-id");
      localStorage.removeItem('eid');
      localStorage.setItem("eid", JSON.stringify(eid));
    }else{
      
      jQuery("input[class='event_chkbox']:checked").each(function() {
        // Add the selected value to the array
        val.push(jQuery(this).val());
      });
      eid =  val.join(",");
      localStorage.removeItem('eid');
      localStorage.setItem("eid", JSON.stringify(eid));
      
    }
  
    eval =jQuery(check_obj).attr("data-featured");
    localStorage.removeItem('eval');
    localStorage.setItem("eval", JSON.stringify(eval));
  
    var obj = {
      prod_id: jQuery(check_obj).attr("data-prod-id"),
      qty:eid.split(",").length,
      prd_tot: jQuery(check_obj).attr("data-tot"),
      start_date: 'na',
      no_of_month : 'na',
      base_price: jQuery(check_obj).attr("data-tot")
    };
   
    prod_id_arr.push(obj);
    jQuery.ajax({
      type: 'POST',
      url: localVars.ajax_url,
      data: {
        action: "add_prod_to_cart",
                  prod_id_arr,
      },
      beforeSend:function(xhr){
        jQuery(check_obj).html(" <div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>"); 
  
      },
      success: function(data) {
        jQuery('.ajax_filter_res_onethree_col').html('');
        
        //var result = JSON.parse(data);
       
          location.href = "/checkout/";
        
      },
      
    });
  }
  
  function checkout_event_featured(check_obj){
    var prod_id_arr = new Array();
    var f_eid = "";
    var f_eval = ""; 
    var f_val = [];
    
    if(jQuery(check_obj).attr("data-id") != "")
    {
      f_eid =jQuery(check_obj).attr("data-id");
      localStorage.removeItem('f_eid');
      localStorage.setItem("f_eid", JSON.stringify(f_eid));
    }else{
      
      jQuery("input[class='event_chkbox']:checked").each(function() {
        // Add the selected value to the array
        f_val.push(jQuery(this).val());
      });
      f_eid =  f_val.join(",");
      localStorage.removeItem('f_eid');
      localStorage.setItem("f_eid", JSON.stringify(f_eid));
      
    }
  
    f_eval =jQuery(check_obj).attr("data-featured");
    localStorage.removeItem('f_eval');
    localStorage.setItem("f_eval", JSON.stringify(f_eval));
  
    var f_obj = {
      prod_id: jQuery(check_obj).attr("data-prod-id"),
      qty:f_eid.split(",").length,
      prd_tot: jQuery(check_obj).attr("data-tot"),
      start_date: 'na',
      no_of_month : 'na',
      base_price: jQuery(check_obj).attr("data-tot")
    };
   
    prod_id_arr.push(f_obj);
    jQuery.ajax({
      type: 'POST',
      url: localVars.ajax_url,
      data: {
        action: "add_prod_to_cart",
        prod_id_arr,
      },
      beforeSend:function(xhr){
        jQuery(check_obj).html(" <div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>"); 
  
      },
      success: function(data) {
        jQuery('.ajax_filter_res_onethree_col').html('');
        location.href = "/checkout/";
        
      },
      
    });
  }



function show_disable_web_ad_popup(obj){
    jQuery("#confirmModal").toggleClass("is-visible");
    jQuery('body').addClass('cart-popup');
    jQuery("#inactive_ad").attr("data-id",jQuery(obj).data("id"));
    
  }
  function show_disable_newsletter_ad_popup(obj){
    jQuery("#confirmModal").toggleClass("is-visible");
    jQuery('body').addClass('cart-popup');
    jQuery("#inactive_newsletter_ad").attr("data-id",jQuery(obj).data("id"));
    
  }
  jQuery("#inactive_ad").on("click", function (e) {

    var post_id = jQuery(this).attr('data-id');
    
    jQuery.ajax({
      type: "POST",
      url: localVars.ajax_url,
      data: {
          action: "disable_web_ad",
          post_id
      },
      beforeSend: function () {
          
          jQuery("#inactive_ad").html("");
          jQuery("#inactive_ad").html(
              "<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>"
          );
      },
      success: function (data) {
        location.reload();
      },
  });
  });

  jQuery("#inactive_newsletter_ad").on("click", function (e) {

    var post_id = jQuery(this).attr('data-id');
    
    jQuery.ajax({
      type: "POST",
      url: localVars.ajax_url,
      data: {
          action: "disable_newsletter_ad",
          post_id
      },
      beforeSend: function () {
          
          jQuery("#inactive_newsletter_ad").html("");
          jQuery("#inactive_newsletter_ad").html(
              "<div class='section-loader'><div class='loader'><div></div> <div></div><div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div></div>"
          );
      },
      success: function (data) {
        location.reload();
      },
  });
  });