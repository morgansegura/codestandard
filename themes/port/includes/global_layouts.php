<?php

add_action('wp_footer', 'footer_javascript_addons');

function footer_javascript_addons() {
setup_postdata(isset($post)); 
global $XQS_utm_content, $page, $detectedDevice;
if ($XQS_utm_content == 'gallery') { ?>
  <script>
    jQuery(document).ready(function($) {
    "use strict";
    //load next slides with a button click - utm_content=gallery
      if($('body .type_newnext').length){
        let slideNum = <?php echo $page ?>;
        if (slideNum == 1) {
          $('#page-link-next-prev-bot').hide();
          jQuery('.type_newnext:not(#slide_id-1) .ad_placeholder').remove();
        }

        function updateNextSlide() {
          $('body .type_newnext').each(function(){
            let slideID = jQuery(this).attr('id').replace(/slide_id-/, '');
            if(slideID == slideNum){
              $(this).removeClass('newnext_hidden');
              $(this).prev().find('.ad_placeholder').remove();
              $(this).prev().addClass('newnext_hidden');
            } 
          });
          slideNum++;
          window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        if (slideNum > 1) {
          $('body .type_newnext').each(function(index) {
            let slideID = jQuery(this).attr('id').replace(/slide_id-/, '');
            if(slideID == slideNum){
              $(this).removeClass('newnext_hidden');
              $('body .type_newnext').not(this).find('.ad_placeholder').remove();
              $(this).prev().addClass('newnext_hidden');
            } 
          });
          updateNextSlide();
        }
        
        window.onpopstate = function() {
          slideNum--;
          $('body .type_newnext').each(function(index){
            let slideID = jQuery(this).attr('id').replace(/slide_id-/, '');
            if(slideID == slideNum){
              $(this).prev().removeClass('newnext_hidden');
              $(this).addClass('newnext_hidden');
            } 
          });
         }; history.pushState({}, '');

        $("div.next-slide a, .featured-img a, #page-link-next-prev-bot a, .next_prev_on_img a").click(
          function(event) {
            let slideNumCorrect = slideNum;
             if ($(".type_newnext").not( ".newnext_hidden" ).is(':nth-last-child(2)')) {
                $('#nextslide').hide();
                $('#nextPost_withThumb').show();
             }
             if (!$(".type_newnext").not( ".newnext_hidden" ).is(':last-child')) {
               deApp.refresh('all');
               event.preventDefault();
             }
         
             if (slideNum == 1) {
               $('#page-link-next-prev-bot').show();
               $('#nextPost_withThumb').hide();
               // mobile
               <?php if($detectedDevice === "mobile") { ?>
                  jQuery('#banner-top-1').parent().detach().insertBefore("header.narrow-header").css({'clear': 'both'});

                  jQuery('#rect-mid-1:first').parent().detach().insertAfter("#slide_id-1 .wp-caption").css('clear', 'both');
               <?php } else { ?>
               // DESKTOP
               if (window.innerWidth <= 1079) {
                 jQuery('.dual_ad_placeholder').detach().insertAfter("#slide_id-1 p:last").css('clear', 'both');
                 jQuery('#leader-bot-center-1').parent().detach().insertAfter("#page-link-next-prev-bot").css('clear', 'both');
               } else if (window.innerWidth >= 1271) {
                  jQuery('#leader-mid-center-1:first').parent().detach().insertAfter("#slide_id-1 .wp-caption").css('clear', 'both');
                  jQuery('#rect-mid-center-2:first').parent().detach().insertBefore("#slide_id-1 .wp-caption").css('clear', 'both');
                  jQuery('#rect-bot-right-1:first').parent().detach().insertAfter("#slide_id-1 .wp-caption").css('clear', 'both');
               } else {
                  jQuery('#leader-mid-center-1:first').parent().detach().insertBefore("#slide_id-1 .wp-caption").css('clear', 'both');
                  jQuery('#leader-bot-center-1:first').parent().detach().insertAfter("#slide_id-1 .wp-caption").css('clear', 'both');
               }
               <?php } ?>
               
               jQuery(".grey_bg_next, .f-text.f-main, .post_container > .mb-2:first" ).remove();
             } else {
               <?php if($detectedDevice === "mobile") { ?>
                 // mobile
                 jQuery('#banner-top-1').parent().detach().insertBefore("header.narrow-header").css({'clear': 'both'});

                 jQuery('#rect-top-1:first').parent().detach().insertBefore("#slide_id-"+slideNumCorrect+" .wp-caption").css('clear', 'both');

                 jQuery('#rect-mid-1:first').parent().detach().insertAfter("#slide_id-"+slideNumCorrect+" .wp-caption").css('clear', 'both');

               <?php } else { ?>
               // DESKTOP
               if (window.innerWidth <= 1079) {
                 jQuery('.dual_ad_placeholder').detach().insertAfter("#slide_id-"+slideNumCorrect+" p:last").css('clear', 'both');
               } else if (window.innerWidth >= 1271) {
                 jQuery('#rect-bot-right-1:first').parent().detach().insertAfter("#slide_id-"+slideNumCorrect+" .wp-caption").css('clear', 'both');
                 jQuery('#rect-mid-center-2:first').parent().detach().insertBefore("#slide_id-"+slideNumCorrect+" .wp-caption").css('clear', 'both');
                 jQuery('#leader-mid-center-1:first').parent().detach().insertAfter("#slide_id-"+slideNumCorrect+" .wp-caption").css('clear', 'both');
               } else {
                   jQuery('#leader-mid-center-1:first').parent().detach().insertBefore("#slide_id-"+slideNumCorrect+" .wp-caption").css('clear', 'both');
                   jQuery('#leader-bot-center-1:first').parent().detach().insertAfter("#slide_id-"+slideNumCorrect+" .wp-caption").css('clear', 'both');
               }
               <?php } ?>
             }

            updateNextSlide();
            deApp.updatePage(parseInt(slideNum-1));

          }
          
        );
      }
    });
  </script>
<?php } } ?>
