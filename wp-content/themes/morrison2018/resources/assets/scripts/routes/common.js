export default {
  init() {
    // JavaScript to be fired on all pages
    $(window).load(function() {
      if($(".imgHalf").length>0) {
        console.log($(".imgHalf").height());
        $(".imgHalf").each(function() {
          $(this).next().height($(this).height());
        });
      }
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
