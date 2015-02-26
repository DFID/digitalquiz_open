/**
 * UI customisations, transitions and general quiz flow amends
 */

var DQ = DQ || {};

DQ = {
  // current question index
  count: 1,
  // total questions
  max_length: 0,
  // total visible questions
  max_length_visible: 0,
  // something
  min_length_visible: 0,
  // zoom level
  zoom: 1,


  init: function() {
    DQ.Quiz.setup();
    DQ.Question.setup();
    DQ.Answer.setup();
  },

  // Results page chart
  chart: function() {
    var labels = [];
    var scores = [];
    var intro_section_title = 'A. Introductory Questions';

    // transform score into %
    var max_points = jQuery('.score-header .max-points').text();
    var own_score = jQuery('.score-header .score').text();
    var others_avg_score = jQuery('.score-header .others-avg').text();
    var own_percentage_score = Math.abs(parseInt(own_score / max_points * 100));
    var others_percentage_score = Math.abs(parseInt(others_avg_score / max_points * 100));

    // some UI cleanup
    jQuery('.progress-meter, .mobile-footer .navigation, .title-pipe').hide();
    jQuery('.print-button').show();

    jQuery('.score').html(own_percentage_score + '%');
    jQuery('.others-avg').html(others_percentage_score + '%');
    
    // hide Intro section from results
    jQuery('.quiz-results .section:first').remove();

    // get section titles and scores
    jQuery('.quiz-results .section').each(function() {
      var title = jQuery(this).find('h2').text();
      // Exclude introductory questions section from the chart
      if (title != intro_section_title) {
        labels.push(title);

      var score = Math.abs(parseInt(jQuery(this).find('h3 span').text()));
        scores.push(score);       
      }
    });

    jQuery('#chart-container').highcharts({
        chart: {
            polar: true,
            type: 'line',
            backgroundColor: '#2193CC'
        },

        pane: {
            size: '100%'
        },

        title: {
            text: ''
        },

        xAxis: {
            categories: labels,
            tickmarkPlacement: 'on',
            lineWidth: 0,
            ceiling: 100,
            gridLineColor: '#72C8EA',
            labels: {
              enabled: false  
          }
        },

        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            ceiling: 100,
            gridLineColor: '#72C8EA',
            min: 0
        },

        legend: {
          enabled: false
        },

        plotOptions: {
          line: {
            lineColor: '#ffffff',
            lineWidth: 4
          }
        },

        tooltip: {
            shared: true,
            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f}%</b><br/>'
        },

        series: [{
            name: 'Score',
            data: scores,
            pointPlacement: 'off'
        }]
    });
  },

  Quiz: {
    setup: function() {
      // move section title to header
      DQ.Quiz.updateTitle();
      // question counter
      DQ.Quiz.resetCounter();
      // handler for clicking on nav buttons (up/down)
      DQ.Quiz.navHandler();
      // focus on first question
      DQ.Question.setFocus();
      // number of questions
      DQ.max_length = jQuery('.watu-question').length;
      // number of visible questions
      DQ.max_length_visible = jQuery('.watu-question:visible').length;

      // hide category description & title when showing email field
      jQuery('#action-button').on('click', function(event) {
        event.preventDefault();
        jQuery(this).parents('form').find('.watupro_catpage').hide();
      });
      
      // intercept clicks on next/previous (section) buttons
      jQuery('.watupro_buttons input').on('click', function (event) {
        DQ.Quiz.changeSection();
      });

      // Sticky header
      jQuery('#masthead').sticky({ topSpacing: 0 });

      DQ.zoom = detectZoom.zoom();
    },

    // Update progress indicator
    updateProgress: function(progress) {
      jQuery('.progress-meter .percent').html(progress);
    },

    // Scroll to the specified element selector
    scrollToElement: function(selector, time, verticalOffset) {        
      time = time ? time : 500;
      element = jQuery(selector);
      offset = element.offset();
      offsetTop = (offset.top - (jQuery(window).outerHeight() - element.outerHeight()) / 2);

      if (DQ.zoom > 1.2 && DQ.zoom <= 1.33) {
        offsetTop -= 50;
      }
      else if (DQ.zoom > 1.33 && DQ.zoom <= 1.5) {
        if (DQ.count == 1)
        {
          offsetTop -= 80;
        }
        else {
          offsetTop += 30;  
        }
      }

      jQuery('html, body').animate({
          scrollTop: offsetTop
      }, time);

      DQ.Question.setFocus(element);
    },

    // Handler for changing a section (next/previous)
    changeSection: function(is_final) {
      jQuery('.site-header').find('h2').remove();
      DQ.Quiz.resetCounter();
      DQ.Quiz.updateTitle();
      if (!is_final) {
        DQ.Question.setFocus();  
      }
    },

    // Move section title to header
    updateTitle: function() {
      if ( jQuery('.watupro-ask-for-contact').css('display') == 'none' ) {
        var $cattitle = jQuery('.watupro_catpage:visible h3').contents();
        var $subheading = jQuery('<h2></h2>');
        $subheading.appendTo('.site-header');
        $cattitle.clone().appendTo($subheading);
      }
    },

    // Update navigation buttons state
    updateNavState: function($question) {
      if (typeof $question == 'undefined' || typeof $question.prop('id') == 'undefined') {
        return ;
      }
      
      // set the corrent count based on selected question
      DQ.count = $question.prop('id').split('-')[1];

      if (DQ.count == DQ.min_length_visible) {
        jQuery('#prev').animate({ 'opacity': '0' }, 200);
      } 
      else {
        jQuery('#prev').animate({ 'opacity': '100' }, 200);
      }

      if (DQ.count == DQ.max_length_visible) {
        jQuery('#next').animate({ 'opacity': '0' }, 200);
      } 
      else {
        jQuery('#next').animate({ 'opacity': '100' }, 200);
      }
    },

    // Handle clicking on nav buttons
    navHandler: function() {
      jQuery('.navigation a').on('click', function (event) {
        event.preventDefault();

        var id = jQuery(this).prop('id');
        if (id === 'next') {
          if ( (DQ.count < DQ.max_length) && (DQ.count != DQ.max_length_visible) ) {
            DQ.count++;
          } 
          else {
            return false;
          }
        }
        else {
          if (DQ.count > 1 && DQ.count != DQ.min_length_visible) {
            DQ.count--;
          } 
          else {
            return false;
          }  
        }

        DQ.Quiz.scrollToElement('#question-' + DQ.count, 500, 50);
      });
    },      

    // Question counter
    resetCounter: function() {
      $category_visible = jQuery('.watu-question:visible');

      ids = _.pluck($category_visible, 'id');

      _.each( ids, function( id, i ) {
        ids[i] = Number(id.replace(/[^0-9]/g, ''));
      });

      DQ.max_length_visible = _.max(ids);
      DQ.min_length_visible = _.min(ids);
    }
  },


  Question: {
    setup: function() {
      // Scroll to clicked question
      jQuery('.watu-question').on('click', function (event) {
        if (! jQuery(this).hasClass('current')) {
          DQ.Quiz.scrollToElement(jQuery(this), 400);    
        }
      });  

      // add 'next question' button for multiple-selection questions
      var $next = jQuery('<p class="next-question" style="display:none"><a href="#">Next question &rarr;</a></p>');
      $next
        .insertAfter('.question-choices')
        .on('click', function(event) {
          event.preventDefault();
          DQ.Question.scrollToNext(jQuery(this).data('qid'));
        });
    },

    // Focus on a question
    setFocus: function($question) {
      // blur all
      jQuery('.watu-question:visible').removeClass('current');

      // if no element provided, focus on the first visible one
      if (typeof $question == 'undefined') {
        $question = jQuery('.watu-question:visible:first');
      }
      // focus/unblur question
      $question.addClass('current');
      // update nav state
      DQ.Quiz.updateNavState($question);
    },

    // Scroll to next question 
    scrollToNext: function(current_question_id) {
      var next_question_id = '#question-' + ++current_question_id;
      if (jQuery(next_question_id).is(':visible')) {
        setTimeout(function() { DQ.Quiz.scrollToElement(next_question_id, 500, 50) }, 10);  
      }
    }
  },


  Answer: {
    setup: function() {
      // handler for choosing an answer
      DQ.Answer.choose();
    },

    // handler for choosing an answer
    choose: function() {
      // click on an answer
      jQuery('.question-choices input, .question-choices textarea').click(function(event) {
        var total_answered = 0;
        for (var i = 0; i < WatuPRO.qArr.length; i++) {
          var question_id = WatuPRO.qArr[i];  
          if (WatuPRO.isAnswered(question_id)) {
            total_answered++;
          }
        }

        // update progress
        progress = Math.round(total_answered / WatuPRO.total_questions * 100) + '%';
        DQ.Quiz.updateProgress(progress);

        // handle selected answer
        DQ.Answer.handleSelected(jQuery(this));
      });
    },

    // Handler for clicking on an answer and advancing to next question (or showing the 'next q' button for non-radios)
    handleSelected: function($answer) {
      // get current question id
      var current_question_id = $answer.parents('.watu-question').attr('id').split('-')[1];
      var $nextBtn = $answer.parents('.watu-question').find('.next-question').data('qid', current_question_id);

      // scroll to next question if this is a single choice question
      if ( $answer.prop('type') == 'radio' ) {
        DQ.Question.scrollToNext(current_question_id);
      } else if ( $answer.prop('type') == 'checkbox' ) {
        var $questions = $answer.parents('.question-choices');
        // handle checkbox selection
        if ( $questions.find(jQuery('input:checked')).length > 0 ) {
          $nextBtn.show();
        } else {
          $nextBtn.hide();
        }
      } else if ( $answer.prop('type') == 'textarea' ) {
        $nextBtn.show();
      }
    }

  }
}

jQuery(document).ready(DQ.init);
