export default {
  init() {
    // JavaScript to be fired on all pages
    $(window).scroll(function (event) {
      var scroll = $(window).scrollTop();
      if(scroll>118) {
        $(".banner").addClass("fixed");
      }
      else {
        $(".banner").removeClass("fixed");
      }
    });

    $('a[href*="#"]:not([href="#"])').click(function() {
      if (
        location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
        location.hostname === this.hostname
      ) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
          $('html, body').animate(
            {
              scrollTop: target.offset().top + 50
            },
            1000
          );
          return false;
        }
      }
    });
    var rate = 602/720;
    $(window).load(function() {
      //console.log("sdsd:" + $(".real-estate-div-table-cell").width());
      if($(".mobile-primary").is(':visible')) {
        if(!$(".icon-menu").hasClass("close")) {
          $(".mobile-primary").click(function() {
            $(".icon-menu").addClass("close");
            $(".hide-desktop").addClass("open");
            $("body").addClass("open");
          });
        }
      }

      $('.main-container').on('click touchstart', function(e) {
         if( $("body").hasClass("open") ){
          if($(".icon-menu").hasClass("close")) {
            $(".icon-menu").removeClass("close");
            $(".hide-desktop").removeClass("open");
            $("body").removeClass("open");
          }
        }
      }).on('click', '.mobile-primary', function(e) {
        e.stopPropagation();
      });

      $(".real-estate-div-table-cell").height($(".real-estate-div-table-cell").width()*rate);
      if($(window).width()>767) {
        if($(".imgHalf").length>0) {
          //console.log($(".imgHalf").height());
          $(".imgHalf").each(function() {
            $(this).next().height($(this).height());
          });
        }
      }
      else {
        if($(".imgHalf").length>0) {
          //console.log($(".imgHalf").height());
          $(".imgHalf").each(function() {
            $(this).next().height();
          });
        }
      }
      var filterValue = $(".tab-active").attr("data-value");
      $(".grid").isotope({
        itemSelector: ".element-item",
        layoutMode: "fitRows",
        filter: filterValue,
      });
      $(".filter-list-item").click(function() {
        $(".filter-list-item").removeClass("tab-active");
        $(this).addClass("tab-active");
        var filterValue1 = $(this).attr("data-value");
        var $grid = '';
        $(".grid").isotope({
          itemSelector: ".element-item",
          layoutMode: "fitRows",
          filter: filterValue1,
        });
      });
      if($('.news-wrap').length>0) {
        $('.news-wrap').masonry({
        // options
          itemSelector: '.news-post',
          columnWidth: '.news-post',
          percentPosition: true
        });
      }
    });

    $(window).resize(function() {
      $(".real-estate-div-table-cell").height($(".real-estate-div-table-cell").width()*rate);
      if($(window).width()>767) {
        if($(".imgHalf").length>0) {
          //console.log($(".imgHalf").height());
          $(".imgHalf").each(function() {
            $(this).next().height($(this).height());
          });
        }
      }
      else {
        if($(".imgHalf").length>0) {
          //console.log($(".imgHalf").height());
          $(".imgHalf").each(function() {
            $(this).next().height();
          });
        }
      }
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
