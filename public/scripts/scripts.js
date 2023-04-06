if (!window.Polimapper) Polimapper = {};

(function($, _, Chart) {
    Polimapper.maindata = {};

     Polimapper.baseUrl = "";
   // Polimapper.baseUrl = "https://api-cdn.polimapper.co.uk";
    var summaryData = true;
    var averages = true;
    var dragging = false;

    window.addthis_share = {
        url: window.location.href,
        title: document.title
    };

    setTimeout(function() {
        $(document).ready(function() {

            if (Polimapper.container) {
                if ($('#' + Polimapper.container).children('.polimapper-desktop')) {
                    $('#' + Polimapper.container).append('<div class="polimapper-desktop"></div>');
                }
                if ($('#' + Polimapper.container).children('.polimapper-mobile')) {
                    $('#' + Polimapper.container).append('<div class="polimapper-mobile"></div>');
                }
            }

            // Get mobile map layout

            /*if (Polimapper.isMobile()) {

                Polimapper.insertMobileLayout();

                $(this).on('touchmove', function(event) {
                    //if(event.originalEvent.scale !== 1) {
                    //  event.preventDefault();
                    //  event.stopPropagation();
                    //}
                });
                $('.help-text').hide();
                $('.licensing-text').hide();
                $('.social, .content').show();


                $('.icon-question').click(function() {
                    $('.help-text').toggle();
                    $('.social, .content').toggle();
                });

                $('.icon-exclamation').click(function() {
                    $('.licensing-text').toggle();
                    $('.social, .content').toggle();
                });

            } else {
                Polimapper.insertDesktopLayout();

                $('span.close').click(function() {
                    $('.modal').modal('hide');
                    $('#sel_con').get(0).selectedIndex = 0;
                });
            }*/
            Polimapper.insertDesktopLayout();
            $('.closes').on('click',function() {
                $('#con_over').hide();
                $('.con_name').remove();
                $(this).hide();
                $('.constituency-view #data, .constituency-view .map').addClass('col-md-6');
                $('.constituency-view #data').removeClass('col-md-8');
                $('.constituency-view .map').removeClass('col-md-4');
                $(".app_wrapper").removeClass('constituency-view');
                $('.results').css(
                    {
                      "background": "none"
                    }
                  );
                $('#data .results').empty().append(Polimapper.maindata);
                $('#sel_con').get(0).selectedIndex = 0;
                $('.node-description-wraper').hide();
                // $("#sel_con").select2({
                //     placeholder: "Enter a Postcode"
                // });
               
            });
            /*window.addEventListener('resize', function() {
                if (Polimapper.isResizeMobile() || Polimapper.isResizeDesktop()) {
                    location.reload();
                }
            });*/
          //  Polimapper.getUrlVariableEnhanced("dataSetKey");
            if (!Polimapper.key) Polimapper.key = Polimapper.getUrlVariable("dataSetKey");
            if (!Polimapper.group) Polimapper.group = Polimapper.getUrlVariable("group");
            if(Polimapper.group !== false){
                var proKey = Polimapper.key
                var groupKey = Polimapper.group
                var dataSet = {proKey, groupKey};
            }else{
                var dataSet = Polimapper.key;
            }
            // var dataSet = Polimapper.key;
            $('#data .results').prepend('<div class="col-xs-12 loading"><div><div class="triforce"></div></div></div>');
            $('body').addClass('fixed-body');
            Polimapper.loadDataset(dataSet, function() {
                Polimapper.insertUkConstituencyMap(Polimapper.data.topology.mapTemplatePath, function() {

                    Polimapper.setColors(Polimapper.data);

                    Polimapper.setMapDetails();

                    Polimapper.orderDatafields(Polimapper.data.dataFields);

                    /*if (!Polimapper.isMobile()) {
                        switch (Polimapper.data.dataFieldLabelStyle) {
                            case "Text":
                                Polimapper.loadDatafieldText();
                                break;
                            case "Icons":

                            default:
                                Polimapper.loadDatafieldIcons();
                                break;
                        }
                    } else {
                        Polimapper.loadDatafieldText();
                    }*/
                    Polimapper.loadDatafieldText();
                    var comparableFields = _.filter(Polimapper.data.dataFields, function(t) { return t.comparable; });

                    var dataField, dataColumn;
                    if (comparableFields[0]) {
                        dataField = comparableFields[0];
                        if (dataField.columns[0]) {
                            dataColumn = dataField.columns[0];
                        }
                    }

                    Polimapper.paintMap(dataField.name, dataColumn.name);

                    /*if (Polimapper.isMobile()) {
                        condenseSummaryDescription();
                    }

                    if (summaryData && !Polimapper.isMobile()) {
                        Polimapper.summaryData();

                    } else if (summaryData && Polimapper.isMobile()) {
                        Polimapper.mobileSummaryData();
                    }*/

                    Polimapper.summaryData();

                    Polimapper.loadScript(Polimapper.data.embeddedCode);

                    Polimapper.displayNodeFromUrl();

                    Polimapper.getNodes(dataSet);

                    $('#data_selector .icon').click(function() {
                        $('#data_selector .icon').removeClass('selected');
                        $(this).addClass('selected');
                        Polimapper.paintMap($(this).data("name"));
                    });

                    $("#data_selector").bind("change", function() {
                        // $('#data_selector .icon').removeClass('selected');
                        // $(this).addClass('selected');
                        Polimapper.paintMap($(this).find(":selected").data("fieldName"), $(this).find(":selected").data("name"));
                    });

                    $('#data_selector .icon').bind("mouseover", function(e) {
                        $('#cons_name_overlay').empty().append($(this).data("name"));
                        // if (!$('.showmap').is(':visible')) {
                        //     $('#cons_name_overlay').css("left", e.pageX - 50);
                        //     $('#cons_name_overlay').css("top", e.pageY - 20);
                        // } else {
                        //     $('#cons_name_overlay').css("left", e.pageX - 50);
                        //     $('#cons_name_overlay').css("top", e.pageY + 20);
                        // }
                    });

                    $("#data_selector .icon").bind(" mouseenter", function() {
                        $("#cons_name_overlay").show();
                    }).mouseleave(function() {
                        $("#cons_name_overlay").hide();
                    });

                    if (!Polimapper.isOnline()) {
                        $('#offline').modal('show');
                    }

                    function getMapInitialScale() {
                        var scale = 'scale(1)';
                        if (Polimapper.data.topology.name === 'Scottish Regions Map') {
                            scale = 'scale(0.5)';
                        } else if (Polimapper.data.topology.name === 'European Countries Map') {
                            scale = 'scale(0.7)';
                        }  else if (Polimapper.data.topology.name === 'UK CCG Map') {
                            scale = 'scale(0.5)';
                        } else if (Polimapper.data.topology.name === 'UK STP Map') {
                            scale = 'scale(0.5)';
                        } else if (Polimapper.data.topology.name === 'Welsh Assembly Constituencies Map') {
                            scale = 'scale(0.5)';
                        } else if (Polimapper.data.topology.name === 'Scottish Health Boards Map') {
                            scale = 'scale(0.9)';
                        } else if (Polimapper.data.topology.name === 'UK Local Authorities Map') {
                            scale = 'scale(0.9)';
                        } else if (Polimapper.data.topology.name === 'Scottish Local Authorities Map') {
                            scale = 'scale(1.2)';
                        }else if (Polimapper.data.topology.name === 'Postcodes Map') {
                            scale = 'scale(0.8)';
                        }else if (Polimapper.data.topology.name === 'Scottish Constituency Map') {
                            scale = 'scale(0.4)';
                        } else if (Polimapper.data.topology.name === 'UK Constituency Map') {
                            scale = 'scale(0.47)';
                        }  else if (Polimapper.data.topology.name === 'Welsh Health Boards Map') {
                            scale = 'scale(0.5)';
                        } else if (Polimapper.data.topology.name === 'UK Regions Map') {
                            scale = 'scale(0.5)';
                        } else if (Polimapper.data.topology.name === 'Welsh Assembly Regions Map') {
                            scale = 'scale(0.5)';
                        }
                        return scale;
                    }


                    if ($(window).width() < 500) {
                        function getMapInitialScale() {
                            var scale = 'scale(1)';
                            if (Polimapper.data.topology.name === 'UK Local Authorities Map') {
                                scale = 'scale(0.4)';
                            } else if (Polimapper.data.topology.name === 'UK Regions Map') {
                                scale = 'scale(0.3)';
                            } else if (Polimapper.data.topology.name === 'UK CCG Map') {
                                scale = 'scale(0.31)';
                            } else if (Polimapper.data.topology.name === 'UK STP Map') {
                                scale = 'scale(0.31)';
                            } else if (Polimapper.data.topology.name === 'Scottish Local Authorities Map') {
                                scale = 'scale(0.7)';
                            }  else if (Polimapper.data.topology.name === 'Scottish Health Boards Map') {
                                scale = 'scale(0.6)';
                            } else if (Polimapper.data.topology.name === 'Scottish Constituency Map') {
                                scale = 'scale(0.2)';
                            } else if (Polimapper.data.topology.name === 'Welsh Health Boards Map') {
                                scale = 'scale(0.4)';
                            } else if (Polimapper.data.topology.name === 'Welsh Assembly Regions Map') {
                                scale = 'scale(0.4)';
                            } else if (Polimapper.data.topology.name === 'Welsh Assembly Constituencies Map') {
                                scale = 'scale(0.4)';
                            }  else if (Polimapper.data.topology.name === 'Puzzle') {
                                scale = 'scale(0.3)';
                            } else if (Polimapper.data.topology.name === 'European Countries Map') {
                                scale = 'scale(0.4)';
                            } else if (Polimapper.data.topology.name === 'UK Constituency Map') {
                                scale = 'scale(0.2)';
                            } else if (Polimapper.data.topology.name === 'Postcodes Map') {
                                scale = 'scale(0.4)';
                            } else if (Polimapper.data.topology.name === 'Scottish Regions Map') {
                                scale = 'scale(0.2)';
                            }
                            return scale;
                        }
                    }



                    var maxScale = 2;

                    /*function getMobileMapInitialScale() {
                        var scale = 'matrix(0.3, 0, 0, 0.3, 0, -50)';
                        maxScale = 2;

                        if (Polimapper.data.topology.name === 'Scottish Regions Map') {
                            scale = 'matrix(0.2, 0, 0, 0.2, 0, 0)';
                        } else if (Polimapper.data.topology.name === 'European Countries Map') {
                            scale = 'matrix(1.6, 0, 0, 1.6, 250, -150)';
                            maxScale = 4;
                        } else if (Polimapper.data.topology.name === 'UK Local Authorities Map') {
                            scale = 'matrix(0.6, 0, 0, 0.6, 0, 0)';
                        } else if (Polimapper.data.topology.name === 'Scottish Local Authorities Map') {
                            scale = 'matrix(2.0, 0, 0, 2.0, 450, 550)';
                            maxScale = 4;
                        } else if (Polimapper.data.topology.name === 'UK CCG Map') {
                            scale = 'matrix(0.7, 0, 0, 0.7, 50, 0)';
                        } else if (Polimapper.data.topology.name === 'Scottish Health Boards Map') {
                            scale = 'matrix(1.6, 0, 0, 1.6, 230, -60)';
                        }

                        return scale;
                    }*/

                    /*if (Polimapper.isMobile()) {
                        $('.svg_wrapper').panzoom({
                            $zoomIn: $('#buttons').find(".zoom-in"),
                            $zoomOut: $('#buttons').find(".zoom-out"),
                            //$zoomRange: $('#buttons').find(".zoom-range"),
                            //$reset: $('#buttons').find(".reset"),
                            startTransform: getMobileMapInitialScale(),
                            maxScale: maxScale,
                            minScale: 0.3,
                            increment: 0.5,
                            which: -1,
                        }).panzoom('zoom');
                    } else {
                        $('.pz').panzoom({
                            $zoomIn: $('#buttons').find(".zoom-in"),
                            $zoomOut: $('#buttons').find(".zoom-out"),
                            //$zoomRange: $('#buttons').find(".zoom-range"),
                            //$reset: $('#buttons').find(".reset"),
                            startTransform: getMapInitialScale(),
                            maxScale: 3,
                            minScale: 0.2,
                            increment: 0.3,
                        }).panzoom('zoom');
                    }*/
                    $('.pz').panzoom({
                        $zoomIn: $('#buttons').find(".zoom-in"),
                        $zoomOut: $('#buttons').find(".zoom-out"),
                        //$zoomRange: $('#buttons').find(".zoom-range"),
                        //$reset: $('#buttons').find(".reset"),
                        startTransform: getMapInitialScale(),
                        maxScale: 3,
                        minScale: 0.2,
                        increment: 0.3,
                    }).panzoom('zoom');
                    $("#submit_postcode").submit(function(event) {

                        if (!Polimapper.isOnline()) {
                            $('#offline2').modal('show');
                            return false;
                        }

                        Polimapper.getNode(dataSet, $("#submit_postcode #postcode")[0].value);
                        return false;
                    });

                    $('#overlay').click(function() {
                        //this.style.fill = "#fff";
                        // $('#data .results').empty().append(Polimapper.maindata);
                        Polimapper.setPageTitle(Polimapper.data.title);
                        addthis_share.url = window.location.href;
                        if (summaryData) {
                            Polimapper.summaryData();
                        }
                        // $('#con_over').hide();
                    });

                    $('#close-constituency').click(function() {
                        //this.style.fill = "#fff";
                        $('#data .results').empty().append(Polimapper.maindata);
                        $('.constituency-view #data, .constituency-view .map').addClass('col-md-6');
                        $('.constituency-view #data').removeClass('col-md-8');
                        $('.constituency-view .map').removeClass('col-md-4');
                        $('.app_wrapper').removeClass('constituency-view');
                        $('.results').css(
                            {
                              "background": "none"
                            }
                          );
                        condenseSummaryDescription();
                        stickyNav();
                        $('#con_over').hide();
                        var back = Polimapper.getHashParam('back');
                        if (back === 'map') {
                            $('.svg-modal').addClass('show');
                            $('.svg-modal .back-button').show();
                            $('.svg-modal .search-constituency').removeClass('open');
                            $('.results, .map-nav-container').hide();
                        }
                        Polimapper.setPageTitle(Polimapper.data.title);
                        window.location.hash = '';
                        var shareUrl = window.location.href;
                        if (shareUrl.indexOf('#') === shareUrl.length - 1) {
                            shareUrl = shareUrl.substr(0, shareUrl.length - 1);
                        }
                        addthis_share.url = shareUrl;
                        /*if (summaryData && !Polimapper.isMobile()) {
                            Polimapper.summaryData();
                        } else if (summaryData && Polimapper.isMobile()) {
                            Polimapper.mobileSummaryData();
                        }*/
                        Polimapper.summaryData();
                    });

                    /*$('#logo-mobile').click(function() {
                        $('#data .results').empty().append(Polimapper.maindata);
                        $('.svg-modal').removeClass('show');
                        $('.svg-modal .search-constituency').removeClass('open');
                        $('.results, .map-nav-container').show();
                        $('.svg-modal .back-button').show();
                        $('.app_wrapper').removeClass('constituency-view');
                        $('#con_over').hide();
                        condenseSummaryDescription();
                        stickyNav();
                        Polimapper.setPageTitle(Polimapper.data.title);
                        window.location.hash = '';
                        var shareUrl = window.location.href;
                        if (shareUrl.indexOf('#') === shareUrl.length - 1) {
                            shareUrl = shareUrl.substr(0, shareUrl.length - 1);
                        }
                        addthis_share.url = shareUrl;
                        if (summaryData && !Polimapper.isMobile()) {
                            Polimapper.summaryData();
                        } else if (summaryData && Polimapper.isMobile()) {
                            Polimapper.mobileSummaryData();
                        }
                    });*/


                    /*if (!Polimapper.isMobile()) {
                        $('.showmap').click(function() {
                            //this.style.fill = "#fff";
                            $('.pz').panzoom("resetPan");
                            $('.map').toggle();
                        });
                        $('path').dblclick(function() {
                            //this.style.fill = "#fff";
                            var path = this;
                            var name = $(this).data("name");

                            if (name) {
                                Polimapper.drawNode(this);
                                if (isMobileWidth()) {
                                    $('.map').toggle();
                                }
                            }
                        });
                    }*/
                    var topologiesWithoutPostcode = [
                        'European Countries Map',
                        'UK STP Map',
                        'UK CCG Map',
                        'Scottish Health Boards Map',
                    ];

                    if (topologiesWithoutPostcode.indexOf(Polimapper.data.topology.name) === -1) {
                        $('.searchbox.postcode').show();

                        $('.searchbox.postcode .icon-wrapper').click(function() {
                            //this.style.fill = "#fff";
                            $('.searchbox.postcode').toggleClass('expand');
                        });
                    }

                    /* if (!Polimapper.isMobile()) {
                         $('path').on('touchend', function() {
                             var _this = this;

                             if (dragging) {
                                 return;
                             }

                             $('.svg-modal').removeClass('show');
                             $('body').removeClass('modal-open');
                             $('.results, .map-nav-container').show();

                             setTimeout(function() {
                                 Polimapper.drawNode(_this);
                                 if (isMobileWidth()) {
                                     $('.map').toggle();
                                 }
                             });

                             event.stopPropagation();
                         });
                     }*/

                    $(".svg_wrapper").on("touchmove", function() {
                        dragging = true;
                    });

                    $("path").on("touchstart", function() {
                        dragging = false;
                    });

                    $('#sel_con').on('change', function() {
                        var path = $("path[data-name='" + this.value + "']").get(0);

                        $('.modal').modal('hide');

                        $('#main-body').removeClass('modal-open');
                        $('#main-body').css('overflow', 'scroll');
                        Polimapper.drawNode(path);
                        $('.node-description-wraper').show();
                    });

                    $('.svg_wrapper path').mouseover(function(e) {
                        var path = this;
                        var name = $(this).data("name");
                        if (name) {
                            $('#cons_name_overlay').empty().append(name);
                            if (!isMobileWidth()) {
                                if(e.pageX >1300){
                                    $('#cons_name_overlay').css("left", e.pageX - 1050);
                                }else{
                                    $('#cons_name_overlay').css("left", e.pageX - 800);
                                }
                                if(e.pageY >600){
                                    $('#cons_name_overlay').css("top", e.pageY - 140);
                                }else{
                                    $('#cons_name_overlay').css("top", e.pageY - 140);
                                }

                            } else {
                                $('#cons_name_overlay').css("left", e.pageX -200);
                                $('#cons_name_overlay').css("top", e.pageY + 200);
                                // if(e.pageX >1300){
                                //     $('#cons_name_overlay').css("left", e.pageX - 900);
                                // }else{
                                //     $('#cons_name_overlay').css("left", e.pageX - 850);
                                // }
                                // if(e.pageY >600){
                                //     $('#cons_name_overlay').css("top", e.pageY - 187);
                                // }else{
                                //     $('#cons_name_overlay').css("top", e.pageY - 90);
                                // }
                            }
                        }
                    });

                    $(".svg_wrapper path").mouseenter(function() {
                        var path = this;
                        var name = $(this).data("name");
                        if (name) {
                            $("#cons_name_overlay").show();
                        }
                    }).mouseleave(function() {
                        var path = this;
                        var name = $(this).data("name");
                        if (name) {
                            $("#cons_name_overlay").hide();
                        }
                    });

                    function isMobileWidth() {
                        return $('.showmap').is(':visible');
                    }

                    // $('.tweet').click(function() {

                    //     Polimapper.tweetCurrentPage();
                    // });

                    // $('.fbshare').click(function() {
                    //     Polimapper.fbShareCurrentPage();
                    // });

                    // $('.lkshare').click(function() {
                    //     Polimapper.lkShareCurrentPage();
                    // });

                    $('.sbm-twitter').click(function() {
                        $("#twitter").modal("toggle");
                        $("#email").modal("hide");
                        $('#main-body').css('overflow', 'hidden');
                    });

                    $('.email-mp').click(function() {
                        $("#emailMp").modal("toggle");
                        $("#twitter").modal("hide");
                        $("#email").modal("hide");
                        $('#main-body').css('overflow', 'hidden');
                    });

                    $('.sbm-email').click(function() {
                        $("#email").modal("toggle");
                        $("#twitter").modal("hide");
                        $("#emailMp").modal("hide");
                        $('#main-body').css('overflow', 'hidden');
                    });

                    $('.sbm-close').click(function() {
                        $('.modal').hide();
                        $('body').removeClass('modal-open');
                        $('#main-body').css('overflow', 'scroll');
                    });


                    $('.more-info').click(function() {
                        $('.footer-take-over').addClass('show');
                        $('body').addClass('modal-open');
                        $(this).hide();
                    });

                    $('.footer-take-over .close').click(function() {
                        $('.footer-take-over').removeClass('show');
                        $('body').removeClass('modal-open');
                        $('.more-info').show();
                    });

                    var slickCarouselInitialised = false;

                    /*function initialiseSlickCarousel() {
                        if (!slickCarouselInitialised) {
                            slickCarouselInitialised = true;
                            var _currentSlide = 0;
                            var moving = false;

                            setTimeout(function() {
                                var elem = $('.polimapper-mobile #data_con-mobile');
                                elem.on('swipe', function(event, slick, direction) {
                                    if (!moving) {
                                        return;
                                    }

                                    var currentSlide = $('.select-wrapper .slick-slide:not(.slick-cloned).slick-current').index() - 1;
                                    if (currentSlide === _currentSlide) {
                                        return;
                                    }
                                    _currentSlide = currentSlide;
                                    console.log('current slide: ' + currentSlide);

                                    var dots = $("#dots .dot");
                                    dots.removeClass('selected');
                                    var newDot = dots.eq(currentSlide);
                                    newDot.addClass('selected');

                                    var slides = $(".data-field-mobile.slick-slide:not(.slick-cloned)");
                                    var newSlide = slides.eq(currentSlide);
                                    setTimeout(function() {
                                        Polimapper.paintMap(
                                            newSlide.data("fieldName"),
                                            newSlide.data("value"));
                                    }, 50);
                                });
                                elem.on('beforeChange', function(event, slick, direction) {
                                    moving = true;
                                    $(this).addClass('moving');
                                });
                                elem.on('afterChange', function(event, slick, direction) {
                                    moving = false;
                                    $(this).removeClass('moving');
                                });
                                elem.slick();
                            });
                        }
                    }*/

                    /* $('.polimapper-mobile .showmap').click(function() {
                         //$('.pz').panzoom("resetPan");
                         $('.svg-modal').addClass('show');
                         $('body').addClass('modal-open');
                         $('.results, .map-nav-container').hide();
                         initialiseSlickCarousel();
                     });*/

                    $('.svg-modal .back-button').click(function() {
                        $('.svg-modal').removeClass('show');
                        $('body').removeClass('modal-open');
                        $('.results, .map-nav-container').show();
                    });

                    stickyNav = function() {
                        var mapNav = $('.map-nav-container');
                        var scrollTop = $(window).scrollTop();
                        var startPoint = window.pageYOffset || document.documentElement.scrollTop;
                        if (startPoint > 50) {
                            // downscroll code
                            $(mapNav).addClass('scroll-shadow');
                        } else if (scrollTop < 50) {
                            $(mapNav).removeClass('scroll-shadow');
                        }
                    };

                    $(window).scroll(function() {
                        stickyNav();
                    });

                    function getNodeFromCacheByName(name) {
                        return _.find(Polimapper.data.nodes, function(node) {
                            return node.name === name;
                        });
                    }

                    function submitSearchForm(query, back) {
                        if (!query) {
                            return;
                        }
                        var node = getNodeFromCacheByName(query);

                        function displayNode(node) {
                            $('.search-constituency input[type="search"]').val('');
                            $('.search-constituency').removeClass('open');
                            $('.map-nav-container .showmap').removeClass('hide');
                            $('.svg-modal').removeClass('show');
                            $('body').removeClass('modal-open');
                            $('.results, .map-nav-container').show();
                            $('.app_wrapper').addClass('constituency-view');
                            $('.constituency-view #data, .constituency-view .map').removeClass('col-md-6');
                            $('.constituency-view #data').addClass('col-md-8');
                            $('.constituency-view .map').addClass('col-md-4');
                            $('.results').css(
                                {
                                  "background": Polimapper.data.primaryColour
                                }
                              );
                            $('#con_over').show();
                            setTimeout(function() {
                                var path = $("path[data-name='" + node.name + "']").get(0);
                                Polimapper.drawNode(path);
                                if (back) {
                                    Polimapper.setHashParam('back', back);
                                }
                            });
                        }

                        if (node) {
                            console.log('found node locally: ' + node.name);
                            return displayNode(node);
                        }

                        Polimapper.getNode(dataSet, query, function(result) {
                            var node = getNodeFromCacheByName(result.name);
                            console.log('loaded node from api: ' + node.name);
                            displayNode(node);
                        });
                    }

                    var currentQuery;

                    function getAutoCompleteConfig(back) {
                        return {
                            lookup: function(query, done) {
                                // we do this manually, rather than passing the
                                // list on init, so the latest data is used

                                var nodes = Polimapper.nodesAutocomplete;

                                query = query && query.toLowerCase();

                                var matching = _.filter(nodes, function(node) {
                                    return node.value.toLowerCase().indexOf(query) !== -1;
                                });

                                var topHits = matching.slice(0, 5);

                                // Do Ajax call or lookup locally, when done,
                                // call the callback and pass your results:
                                var result = {
                                    suggestions: topHits
                                };

                                done(result);
                            },
                            onSelect: function(suggestion) {
                                if (suggestion.data === currentQuery) {
                                    return;
                                }

                                currentQuery = suggestion.data;
                                submitSearchForm(suggestion.data, back);
                            }
                        };
                    }

                    // all search

                    if (topologiesWithoutPostcode.indexOf(Polimapper.data.topology.name) === -1) {
                        $('.search-constituency input[type="search"]').attr('placeholder', Polimapper.data.topology.labelForSingularNode + '/Postcode');
                    } else {
                        $('.search-constituency input[type="search"]').attr('placeholder', Polimapper.data.topology.labelForSingularNode);
                    }

                    // home page search

                    $('.map-nav-container .search-constituency input[type="search"]').autocomplete(getAutoCompleteConfig());

                    $('.map-nav-container .search-constituency form').submit(function(event) {
                        event.preventDefault();
                        var query = jQuery('.search-constituency input[type="search"]').val();
                        submitSearchForm(query);
                        return false;
                    });

                    $('.map-nav-container .search-constituency').click(function() {
                        if ($(this).hasClass('open')) {
                            var query = $('input[type="search"]', this).val();
                            submitSearchForm(query);
                        } else {
                            $(this).addClass('open');
                            $('.map-nav-container .showmap').addClass('hide');
                        }
                    });

                    // map page search

                    $('.svg-modal .search-constituency input[type="search"]').autocomplete(getAutoCompleteConfig('map'));

                    $('.svg-modal .search-constituency form').submit(function(event) {
                        event.preventDefault();
                        var query = jQuery('.search-constituency input[type="search"]').val();
                        submitSearchForm(query, 'map');
                        return false;
                    });

                    $('.svg-modal .search-constituency').click(function() {
                        if ($(this).hasClass('open')) {
                            var query = $('input[type="search"]', this).val();
                            submitSearchForm(query, 'map');
                        } else {
                            $(this).addClass('open');
                            $('.svg-modal .back-button').hide();
                        }
                    });

                    $('.app_wrapper').click(function() {
                        $('.map-nav-container .search-constituency').removeClass('open');
                        $('.map-nav-container .showmap').removeClass('hide');
                    });

                    $('.svg_wrapper').click(function() {
                        $('.svg-modal .search-constituency').removeClass('open');
                        $('.svg-modal .back-button').show();
                    });

                    $('.svg-modal .legend').click(function() {
                        $(this).toggleClass('show');
                        $('.dtfield .icon').toggleClass('icon-arrow-down3');
                        $('.dtfield .icon').toggleClass('icon-arrow-up3');
                    });

                    // window.onresize = function() {
                    //     if (!Polimapper.isMobile()) {
                    //         Polimapper.equalHeight(true, 'result_graph');
                    //     }
                    // };

                    Chart.defaults.global.scaleFontFamily = "'oxygen', 'Helvetica', 'Arial', sans-serif";
                    Chart.defaults.global.tooltipFontFamily = "'oxygen', 'Helvetica', 'Arial', sans-serif";
                    Chart.defaults.global.tooltipTitleFontFamily = "'oxygen', 'Helvetica', 'Arial', sans-serif";
                    Chart.defaults.global.tooltipTemplate = "<%if (label){%><%=label%>: <%}%><%= Polimapper.addCommas(value) %>";

                    if (!Polimapper.isMobile()) {
                        $('.svg_wrapper path').on('touchstart', function(e) {
                            var path = this;
                            $('#cons_name_overlay').empty().append($(this).data("name"));
                            /*if (!isMobileWidth()) {
                                $('#cons_name_overlay').css("left", e.pageX - 50);
                                $('#cons_name_overlay').css("top", e.pageY - 20);
                            } else {
                                $('#cons_name_overlay').css("left", e.pageX);
                                $('#cons_name_overlay').css("top", e.pageY + 20);
                            }*/
                            // $('#cons_name_overlay').css("left", e.pageX);
                            // $('#cons_name_overlay').css("top", e.pageY + 20);
                        });
                    }
                });
            });
        });
    }, 0);

    Polimapper.tweetCurrentPage = function() {
        var twitterHandle = 'polimapper';

        if (Polimapper.key === '72bc86358fc244dfb1135cc1205436de') {
            twitterHandle = 'jrf_uk';

        }
        window.open('https://twitter.com/share?url=' + escape(window.location.href) + '&text=' + Polimapper.data.title + ' via @' + twitterHandle, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
        return false;
    };

    Polimapper.fbShareCurrentPage = function() {
        window.open("https://www.facebook.com/sharer/sharer.php?u=" + escape(window.location.href) + "&p[title]=" + Polimapper.data.title + "&p[images][0]=" + Polimapper.data.logo, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
        return false;
    };

    Polimapper.lkShareCurrentPage = function() {
        window.open("https://www.linkedin.com/shareArticle?mini=true&url=" + escape(window.location.href) + "&title=" + Polimapper.data.title, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
        return false;
    };

    Polimapper.isOnline = function() {
        if (!navigator) {
            // don't know how to find out properly
            // assume online for most graceful behaviour
            return true;
        }
        return navigator.onLine;
    };

    var moretext = "Show more";
    var lesstext = "Show less";

    function condenseSummaryDescription() {
        var showChar = 100; // How many characters are shown by default
        var ellipsestext = "...";

        $('.read-more-wrapper').each(function() {
            var content = $(this).html();
            if (content.length > showChar) {
                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);
                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }
        });

        $(".morelink").click(function() {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    }
})(Polimapper.$ || window.$, Polimapper._ || window._, Polimapper.Chart || window.Chart);
if (!window.Polimapper) Polimapper = {};

(function ($, _, Chart) {
  Polimapper.loadData = function (cacheKey, url, data, successCallback) {
    if (!Polimapper.isOnline()) {
      var results = Polimapper.getLocalData(cacheKey);

      if (results) {
        successCallback(results);
      }
    } else {
      $.ajax({
        crossDomain: true,
        type: "GET",
        url: url,
        data: data,
        dataType: "json",
        async:true,
        success: function (results) {
          if(cacheKey == 'nodes'){
          Polimapper.setLocalData(cacheKey, results.nodes);
          }
          // else{
          //   Polimapper.setLocalData(cacheKey, results);
          // }
            // Polimapper.setLocalData(cacheKey, results);
          successCallback(results);
        },
        error: function (xhr) {
          var results = Polimapper.getLocalData(cacheKey);

          if (results) {
            successCallback(results);
          }
        }
      });
    }
  };

  Polimapper.getNodes = function (dataSet) {
    // var url = Polimapper.baseUrl + "/nodes/?dataSetKey=" + dataSet;
    if(dataSet.groupKey){
    var url = Polimapper.baseUrl + "/nodes/?dataSetKey=" + dataSet.proKey;
  }else{
    var url = Polimapper.baseUrl + "/nodes/?dataSetKey=" + dataSet;
  }
    // var url = Polimapper.baseUrl + "/generator/nodes?dataSetKey=" + dataSet;
    var cacheKey = 'nodes';

    Polimapper.loadData(cacheKey, url, {}, function (results) {
      var select = $('#sel_con').get(0);
      var searchText = '<option selected disable>Enter a ' + Polimapper.data.topology.labelForSingularNode + '</option>';
      $('#sel_con').append(searchText);
      if (typeof results !== 'object') {
        results = JSON.parse(results);
      }

      for (i = 0; i < results.nodes.length; ++i) {
        var name = results.nodes[i].name;

        var select_template = Polimapper.templates['src/templates/select.handlebars'];
        var select_template_mobile = Polimapper.templates['src/templates/selectMobile.handlebars'];
        var select_context = {
          name: name,
          value: name
        };
        var select_context_mobile = {
          name: name,
          value: name
        };
        var select_html = select_template(select_context);
        var select_html_mobile = select_template_mobile(select_context_mobile);
        $('#sel_con').append(select_html);

      }
      Polimapper.nodesAutocomplete = _.map(results.nodes, function (node) {
        return {
          value: node.name,
          data: node.name
        };
      });
    });
  };

  Polimapper.getNode = function (dataSet, query, callback) {
    if(dataSet.groupKey){
    var url = Polimapper.baseUrl + "/nodes/?dataSetKey=" + dataSet.proKey;
    }else{
      var url = Polimapper.baseUrl + "/nodes/?dataSetKey=" + dataSet;
    }
    // var url = Polimapper.baseUrl + "/nodes/?dataSetKey=" + dataSet;
    var cacheKey = 'node_by_query_' + query;

    Polimapper.loadData(cacheKey, url, {
      query: query,
      dataSetTopology: Polimapper.data.topology.id
    }, function (results) {
      if (callback) {
        callback(results);
      } else {
        var path = $("path[data-name='" + results.name + "']").get(0);
        Polimapper.drawNode(path); //logic here
      }
    });
  };

  Polimapper.loadDatafieldIcons = function () {
    /* $("#data_selector.text").hide();
     var comparableFields = _.filter(Polimapper.orderDatafields(Polimapper.data.dataFields), function (t) {
       return t.comparable;
     });
     for (var i = 0; i < comparableFields.length; ++i) {
       var comparableField = comparableFields[i];
       for (var k = 0; k < comparableField.columns.length; k++) {
         var column = comparableField.columns[k];
 
         if (i === 0 && k === 0) {
           column.icon = column.icon + " selected";
         }
         var template = Polimapper.templates['src/templates/datafields.handlebars'];
         var context = {
           name: column.name,
           fieldName: comparableField.name,
           icon: column.icon
         };
         var html = template(context);
        $('#data_selector').append(html);
       }
     }
     $("#data_selector").bind("click touchend", function () {
       // $('#data_selector .icon').removeClass('selected');
       // $(this).addClass('selected');
       Polimapper.paintMap($(this).data("fieldName"), $(this).data("name"));
     });
     $('#data_selector .icon').bind("mouseover", function (e) {
       $('#cons_name_overlay').empty().append($(this).data("name"));
       if (!$('.showmap').is(':visible')) {
         $('#cons_name_overlay').css("left", e.pageX - 50);
         $('#cons_name_overlay').css("top", e.pageY - 20);
       } else {
         $('#cons_name_overlay').css("left", e.pageX - 50);
         $('#cons_name_overlay').css("top", e.pageY + 20);
       }
     });
     $("#data_selector .icon").bind(" mouseenter", function () {
       $("#cons_name_overlay").show();
     }).mouseleave(function () {
       $("#cons_name_overlay").hide();
     });*/
  };

  Polimapper.loadDatafieldText = function () {

    $("#data_selector.icons").hide();
    var comparableFields = _.filter(Polimapper.orderDatafields(Polimapper.data.dataFields), function (t) {
      return t.comparable;
    });
    // var comparableFields = Polimapper.data.dataFields;
    for (var i = 0; i < comparableFields.length; i++) {
      if(comparableFields[i].isGroup == true){
    $("#data_con").append("<option data-class='isparent' value='"+comparableFields[i].name+"' data-field-name='"+comparableFields[i].name+"'>"+comparableFields[i].name + "</option>");
  }else if(comparableFields[i].parentId !=="0"){
    $("#data_con").append("<option class='ischild' value='"+comparableFields[i].name+"' data-field-name='"+comparableFields[i].name+"'>↪ "+comparableFields[i].name + "</option>");
  }else {
    $("#data_con").append("<option value='"+comparableFields[i].name+"' data-field-name='"+comparableFields[i].name+"'>"+comparableFields[i].name + "</option>");
      }
  }
    // for (var i = 0; i < comparableFields.length; ++i) {
    //   var comparableField = comparableFields[i];
    //   for (var k = 0; k < comparableField.columns.length; k++) {
    //     var column = comparableField.columns[k];
    //     var name = '';

    //     if (comparableField.columns.length > 1) {
    //       name = column.label ? column.label + ' - ' + comparableField.name : column.name;
    //     } else {
    //       name = column.label ? column.label : column.name;
    //     }

    //     var select_template, select_template_mobile;
    //     // if(comparableField.parentId === "0" && comparableField.isGroup === "1") { //
    //     //    select_template = Polimapper.templates['src/templates/selectDatafieldsParent.handlebars'];
    //     //    select_template_mobile = Polimapper.templates['src/templates/selectDatafieldsParent.handlebars'];
    //     // } else if(comparableField.parentId === "0" ) {
    //     //   select_template = Polimapper.templates['src/templates/selectDatafields.handlebars'];
    //     //    select_template_mobile = Polimapper.templates['src/templates/selectDatafields.handlebars'];
    //     // } else {
    //     //    select_template = Polimapper.templates['src/templates/selectDatafieldsChild.handlebars'];
    //     //    select_template_mobile = Polimapper.templates['src/templates/selectDatafieldsChild.handlebars'];
    //     // }
    //      // select_template = Polimapper.templates['src/templates/selectDatafields.handlebars'];
    //       // select_template_mobile = Polimapper.templates['src/templates/selectDatafields.handlebars'];
    //     // var select_context = {
    //     //   name: name,
    //     //   value: column.name,
    //     //   fieldName: comparableField.name
    //     // };
    //     // var select_context_mobile = {
    //     //   name: name,
    //     //   value: column.name,
    //     //   fieldName: comparableField.name
    //     // };
    //     // var select_html = select_template(select_context);
    //     // var select_html_mobile = select_template_mobile(select_context_mobile);
    //     $('#data_con').append(select_html);
    //     $('#data_con-mobile').append(select_html_mobile);
    //     if (i === 0 && k === 0) {
    //       //if ($('.polimapper-mobile').is(':visible')) {
    //        // var selMobile = document.getElementById('data_con-mobile');
    //       //  selMobile.selectedIndex = 0;
    //      // } else {
    //      //   var sel = document.getElementById('data_con');
    //       //  sel.selectedIndex = 0;
    //      // }
    //       var sel = document.getElementById('data_con');
    //       sel.selectedIndex = 0;
    // const resultFields = comparableFields.find(({ isGroup }) => isGroup === true);
    //     }
    //   }
    // }
    $("#data_con").bind("change", function () {
      Polimapper.paintMap($(this).find("option:selected").data("fieldName"), $(this)[0].value);
    });
    var dataFieldOption = $("#data_con-mobile .data-field-mobile");
    var selectedDataField = $("#data_con-mobile .data-field-mobile.selected");
    var optionsLength = dataFieldOption.length;
    if (optionsLength > 0) {
      $(dataFieldOption).first().addClass('selected');
    }
    for (i = 0; i < optionsLength; i++) {
      $("#dots").append("<div class='dot'></div>");
    }
    var dots = $("#dots .dot").length;
    if (dots > 0) {
      $('.dot').first().addClass('selected');
    }
  };

    Polimapper.loadDataset = function (dataset, onSuccess) {
     if(dataset.groupKey){
      var url = Polimapper.baseUrl + "/generator/";
      var cacheKey = 'dataset_' + dataset.proKey;
  
      Polimapper.loadData(cacheKey, url, {
        dataSetKey: dataset.proKey, group:dataset.groupKey
      }, function (results) {
        if (typeof results !== 'object') {
          results = JSON.parse(results);
        }
        for (var i = 0; i < results.nodes.length; i++) {
          results.nodes[i] = new Polimapper.Node(results.nodes[i]);
        }
  
        Polimapper.data = results;
  
        onSuccess();
      });
     }else{
      var url = Polimapper.baseUrl + "/generator/";
      var cacheKey = 'dataset_' + dataset;
  
      Polimapper.loadData(cacheKey, url, {
        dataSetKey: dataset
      }, function (results) {
        if (typeof results !== 'object') {
          results = JSON.parse(results);
        }
        for (var i = 0; i < results.nodes.length; i++) {
          results.nodes[i] = new Polimapper.Node(results.nodes[i]);
        }
  
        Polimapper.data = results;
  
        onSuccess();
      });
     }
    };

 

  function shortenNodeNameForGraph(nodeName) {
    var nodeNameLength = 22;
    return nodeName.substr(0, nodeNameLength).trim() + '..';
  }

  Polimapper.loadNodeData = function (node) {
    var dataFields = Polimapper.data.dataFields;
    var path = $("path[data-name='" + node + "']").get(0);

    var color = Polimapper.data[path.className.baseVal.trim()];

    if (!color) {
      color = '#dedede';
    }

    node = Polimapper.arrayLookup(Polimapper.data.nodes, "name", node);
    Polimapper.loadRankingIcons(node);
    $('#data .results').empty().html('<div class="col-xs-12 loading"><div><div class="triforce"></div></div></div>');
    //Load data into templates and display
    $('#data .results').empty();

    if (Polimapper.data.key === '41a8db966f6446b8803d0a33094f61b1') {
      if ($(path).attr("data-name") === 'South Manchester' || $(path).attr("data-name") === 'Central Manchester' || $(path).attr("data-name") === 'North Manchester') {
        $('.con_name').empty();
        $('#data').prepend("<h2 class=\"con_name\">" + $(path).attr("data-name") + "*</h2>");
        $('.con_name').css("color", Polimapper.data.primaryColour);
      }
    } else {
      $('.con_name').empty();
      $('#data').prepend("<h2 class=\"con_name\">" + $(path).attr("data-name") + "</h2>");
      $('.con_name').css("color", Polimapper.data.primaryColour);
    }

    var orderedDatafields = Polimapper.orderDatafields(Polimapper.data.dataFields);
    $('.graph-wrapper').html('');
    for (var i = 0; i < orderedDatafields.length; i++) {
      var dataField = orderedDatafields[i];
      var key = dataField.name;
      var label = dataField.columns[0].label ? dataField.columns[0].label : dataField.name;

      //CHANGED THE WAY THE LOOP WORKS SO WE CAN REORDER THE DATAFIELDS
      //}
      //for (var key in node.data) {
      if (node.field(key)) {

        //CHANGED THE WAY THE LOOP WORKS SO WE CAN REORDER THE DATAFIELDS
        //var dataField = Polimapper.arrayLookup (Polimapper.data.dataFields, "name", key);

        var currency = "";

        /* jshint ignore:start */
        switch (dataField.type) {
          case "Pound":
          case "Euro":
          case "Dollar":
          case "Decimal":
          case "Number":
            var template;

            if (dataField.type === 'Pound') {
              currency = "&#163; ";
            }

            if (dataField.type === 'Dollar') {
              currency = "&#36; ";
            }

            if (dataField.type === 'Euro') {
              currency = "&#128; ";
            }

            // this is currently assuming the field has a column with the same name
            var number = node.columnValue(key, key);
            var icons = "";
            var dataNumbers = "";
            var columnKeys = "";
            var totalValues = 0;

            dataField.columns.forEach(function (columnDefinition, i) {
              var columnData = node.column(dataField.name, columnDefinition.name);
              columnKeys = columnKeys + ',' + columnDefinition.label;
              icons = icons + ',' + columnDefinition.icon;
              if (columnData.value) {
                dataNumbers = dataNumbers + ',' + columnData.value;

                if (i === dataField.columns.length - 1) {
                  totalValues += parseFloat(columnData.value);
                }
              }
              // do stuff
            });

            dataNumbers = Polimapper.parseValueStrings(dataNumbers);
            columnKeys = Polimapper.parseValueStrings(columnKeys);
            icons = Polimapper.parseValueStrings(icons);

            if (!dataField.isMultivalued) {
              columnKeys[0] = Polimapper.data.topology.labelForSingularNode;
              icons = [dataField.columns[0].icon];
            } else {

              if (dataField.showTotalInDataSetSummary) {
                number = parseFloat(totalValues.toFixed(2));
              } else {
                number = "";
              }
            }
            if (icons === '') {
              icons = [];
            }
            var context = {
              name: key,
              value: number,
              currency: Polimapper.decodeHtml(currency),
              icons: icons.reverse(),
              color: color,
              escapedName: Polimapper.toSlug(key),
              multivalued: dataField.isMultivalued,
              label: label,
              description: dataField.description,
              node: Polimapper.data.topology.labelForSingularNode
            };

            if (number > 1000000) {
              template = Polimapper.templates['src/templates/bigNumberNode.handlebars'];
            } else {
              template = Polimapper.templates['src/templates/numberNode.handlebars'];
              textTemplate = Polimapper.templates['src/templates/numberTextNode.handlebars'];
              number = Polimapper.numberWithCommas(number);
            }

            var html = template(context);
            var htmlText = textTemplate(context);
            $('#data .results').append(htmlText);
            $('.graph-wrapper').append('<div class="col-md-6 graph-data"><div class="card">' + html + '</div></div>');
            if (dataField.includeAverageInNodeGraphs) {
              var averages = '';
              columnKeys = '';

              for (var k = 0; k < dataField.columns.length; k++) {
                if (dataField.averageOverride) {
                  averages = averages + ',' + dataField.columns[k].averageOverride.toFixed(2);
                } else {
                  averages = averages + ',' + dataField.columns[k].average.toFixed(2);
                }
                columnKeys = columnKeys + ',' + dataField.columns[k].label;
              }

              averages = Polimapper.parseValueStrings(averages);
              columnKeys = Polimapper.parseValueStrings(columnKeys);

              if (!dataField.isMultivalued) {
                columnKeys[0] = Polimapper.data.topology.labelForSingularNode;
              }

              var data = {
                labels: columnKeys,
                datasets: [{
                  label: shortenNodeNameForGraph(node.name),
                  fillColor: Polimapper.hexToRgba(color, 60),
                  strokeColor: color,
                  highlightFill: color,
                  highlightStroke: color,
                  pointColor: color,
                  pointStrokeColor: color,
                  pointHighlightFill: color,
                  pointHighlightStroke: "#ffffff",
                  data: dataNumbers
                  //data: [node.data[key], dataField.average]
                },
                {
                  label: "Average",
                  fillColor: "rgba(220,220,220,0.5)",
                  strokeColor: "rgba(220,220,220,0.8)",
                  highlightFill: "rgba(220,220,220,0.75)",
                  highlightStroke: "rgba(220,220,220,1)",
                  data: averages
                  //data: [node.data[key], dataField.average]
                }
                ]
              };
            } else {
              var data = {
                labels: columnKeys,
                datasets: [{
                  label: shortenNodeNameForGraph(node.name),
                  fillColor: Polimapper.hexToRgba(color, 60),
                  strokeColor: color,
                  highlightFill: color,
                  highlightStroke: color,
                  data: dataNumbers
                  //data: [node.data[key], dataField.average]
                }]
              };
            }

            var ctx = $('#' + Polimapper.toSlug(key)).get(0).getContext("2d");

            var myBarChart;

            if (dataField.graphType === 'Bar' || !dataField.isMultivalued) {
              myBarChart = new Chart(ctx).Bar(data, {
                //animateScale: true,
                responsive: true,
                labelLength: 30,
                tooltipXOffset: -50,
                tooltipTemplate: "<%if (label){%><%=label %>:  <%}%><%= Polimapper.addCommas(value) %>",
                multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel %>:  <%}%><%= Polimapper.addCommas(value) %>",
                //segmentShowStroke : false
              });
            } else {
              myBarChart = new Chart(ctx).Line(data, {
                //animateScale: true,
                responsive: true,
                labelLength: 30,
                // String - Template string for multiple tooltips
                multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel %>:  <%}%><%= Polimapper.addCommas(value) %>",
                //segmentShowStroke : false
              });
            }

            //Pretify number
            $('.pretty-number').removeAttr("data-pretty-number");
            $('.pretty-number').prettyNumber();

            break;
          case "Percentage":

            if (!dataField.isMultivalued) {
              var number = node.columnValue(key, key);
              var template = Polimapper.templates['src/templates/percentageNode.handlebars'];
              var context = {
                name: key,
                value: number,
                icon: dataField.columns[0].icon,
                escapedName: Polimapper.toSlug(key),
                label: label,
                description: dataField.description
              };
              var html = template(context);

              $('#data .results').append(html);

              var data = [{
                value: number,
                color: color,
                highlight: "#FF5A5E",
                label: key
              },
              {
                value: 100 - number,
                color: "#f1f1f1",
                highlight: "#f1f1f1",
                label: ""
              },

              ];

              //document.getElementById('#' + key).getContext("2d");
              var ctx = $('#' + Polimapper.toSlug(key)).get(0).getContext("2d");
              var myDoughnutChart = new Chart(ctx).Doughnut(data, {
                animateScale: true,
                labelLength: 30,
                //responsive: true,
                segmentShowStroke: false
              });
            } else {
              Polimapper.drawMultivalueBarChart(node, dataField, key, color, label);
            }

            break;

          case "Hyperlink":
            var value = node.columnValue(key, key);
            if (value) {
              var template = Polimapper.templates['src/templates/link.handlebars'];
              var link = value.split(':::');
              var context = {
                name: key,
                url: link[0],
                text: link[1],
                icon: dataField.columns[0].icon,
                label: label
              };
              var html = template(context);

              $('#data .results').append(html);
            }

            break;
          case "Text":
          default:
            var value = node.columnValue(key, key);
            var template = Polimapper.templates['src/templates/text.handlebars'];
            var templateMobile = Polimapper.templates['src/templates/textMobile.handlebars'];
            var context = {
              name: key,
              value: value,
              description: dataField.description,
              icon: dataField.columns[0].icon,
              escapedName: Polimapper.toSlug(key),
              label: label
            };
            var html = template(context);
            var htmlMobile = templateMobile(context);

            $('#data .results').append(html);
            break;
        }
        /* jshint ignore:end */
      }
    }

    // Polimapper.equalHeight(false, 'result_graph');
  };

  Polimapper.drawMultivalueBarChart = function (node, dataField, key, color, label) {

    var number = node.columnValue(key, key);
    var icons = "";
    var dataNumbers = "";
    var columnKeys = "";
    var totalValues = 0;

    dataField.columns.forEach(function (columnDefinition, i) {
      var columnData = node.column(dataField.name, columnDefinition.name);
      columnKeys = columnKeys + ',' + columnDefinition.label;
      icons = icons + ',' + columnDefinition.icon;
      if (columnData.value) {
        dataNumbers = dataNumbers + ',' + columnData.value;

        if (i === dataField.columns.length - 1) {
          totalValues += parseFloat(columnData.value);
        }
      }
      // do stuff
    });

    dataNumbers = Polimapper.parseValueStrings(dataNumbers);

    columnKeys = Polimapper.parseValueStrings(columnKeys);
    icons = Polimapper.parseValueStrings(icons);

    if (number > 1000000) {
      template = Polimapper.templates['src/templates/bigNumber.handlebars'];
    } else {

      template = Polimapper.templates['src/templates/number.handlebars'];
      number = Polimapper.numberWithCommas(number);
    }
    if (icons === '') {
      icons = [];
    }

    var context = {
      name: key,
      value: number,
      color: color,
      escapedName: Polimapper.toSlug(key),
      icons: icons.reverse(),
      multivalued: dataField.isMultivalued,
      label: label,
      description: dataField.description,
      showGraph: true
    };
    var html = template(context);

    $('#data .results').append(html);

    var data;
    if (dataField.includeAverageInNodeGraphs) {
      var averages = '';
      columnKeys = '';

      for (var k = 0; k < dataField.columns.length; k++) {
        if (dataField.averageOverride) {
          averages = averages + ',' + dataField.columns[k].averageOverride.toFixed(2);
        } else {
          averages = averages + ',' + dataField.columns[k].average.toFixed(2);
        }
        columnKeys = columnKeys + ',' + dataField.columns[k].name;
      }

      averages = Polimapper.parseValueStrings(averages);
      columnKeys = Polimapper.parseValueStrings(columnKeys);

      data = {
        labels: columnKeys,
        datasets: [{
          label: shortenNodeNameForGraph(node.name),
          fillColor: Polimapper.hexToRgba(color, 60),
          strokeColor: color,
          highlightFill: color,
          highlightStroke: color,
          pointColor: "#ffffff",
          pointStrokeColor: color,
          pointHighlightFill: color,
          pointHighlightStroke: "#ffffff",
          data: dataNumbers
          //data: [node.data[key], dataField.average]
        },
        {
          label: "Average",
          fillColor: "rgba(220,220,220,0.5)",
          strokeColor: "rgba(220,220,220,0.8)",
          highlightFill: "rgba(220,220,220,0.75)",
          highlightStroke: "rgba(220,220,220,1)",
          data: averages
          //data: [node.data[key], dataField.average]
        }
        ]
      };
    } else {
      data = {
        labels: columnKeys,
        datasets: [{
          label: shortenNodeNameForGraph(node.name),
          fillColor: Polimapper.hexToRgba(color, 60),
          strokeColor: color,
          highlightFill: color,
          highlightStroke: color,
          data: dataNumbers
          //data: [node.data[key], dataField.average]
        }]
      };
    }

    var ctx = $('#' + Polimapper.toSlug(key)).get(0).getContext("2d");

    var myBarChart = new Chart(ctx).Bar(data, {
      //animateScale: true,
      responsive: true,
      labelLength: 30,
      // String - Template string for multiple tooltips
      multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel %>:  <%}%><%= Polimapper.addCommas(value) %>",
      //segmentShowStroke : false
    });
  };

  Polimapper.drawMultivalueSummaryBarChart = function (dataField, key, label) {
    var template;
    var number = '';
    var icons = "";
    var maxNumbers = "";
    var minNumbers = "";
    var avgNumbers = "";
    var columnKeys = "";


    dataField.columns.forEach(function (columnDefinition) {
      columnKeys = columnKeys + ',' + columnDefinition.label;
      maxNumbers = maxNumbers + ',' + columnDefinition.maxValue;
      minNumbers = minNumbers + ',' + columnDefinition.minValue;
      avgNumbers = avgNumbers + ',' + (columnDefinition.averageOverride ? columnDefinition.averageOverride.toFixed(2) : columnDefinition.average.toFixed(2));
      icons = icons + ',' + columnDefinition.icon;
      // do stuff
    });

    maxNumbers = Polimapper.parseValueStrings(maxNumbers);
    minNumbers = Polimapper.parseValueStrings(minNumbers);
    avgNumbers = Polimapper.parseValueStrings(avgNumbers);
    columnKeys = Polimapper.parseValueStrings(columnKeys);
    icons = Polimapper.parseValueStrings(icons);

    var legend = '';

    if (!dataField.excludeMinFromDataSetSummaryGraph) {
      legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour4 + ';"></span> Min</div>';
    }
    if (!dataField.excludeAverageFromDataSetSummaryGraph) {
      legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour3 + ';"></span> Avg</div>';
    }
    if (!dataField.excludeMaxFromDataSetSummaryGraph) {
      legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour1 + ';"></span> Max</div>';
    }

    template = Polimapper.templates['src/templates/number.handlebars'];
    number = Polimapper.numberWithCommas(number);

    if (icons === '') {
      icons = [];
    }

    var context = {
      name: dataField.name,
      value: number,
      currency: '',
      icons: icons.reverse(),
      escapedName: Polimapper.toSlug(dataField.name),
      multivalued: dataField.isMultivalued,
      label: label,
      description: dataField.description,
      legend: legend !== '',
      legendHtml: legend,
      showGraph: true
    };
    var html = template(context);

    $('#data .totals').append(html);

    var minDataset = {
      label: 'Min',
      fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour4, 20),
      strokeColor: Polimapper.data.keyColour4,
      highlightFill: Polimapper.data.keyColour4,
      highlightStroke: "rgba(220,220,220,1)",
      pointColor: Polimapper.data.keyColour4,
      pointStrokeColor: Polimapper.data.keyColour4,
      pointHighlightFill: Polimapper.data.keyColour4,
      pointHighlightStroke: "rgba(220,220,220,1)",
      data: minNumbers
      //data: [constituency.data[key], dataField.average]
    };

    var avgDataset = {
      label: 'Avg',
      fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour3, 20),
      strokeColor: Polimapper.data.keyColour3,
      highlightFill: Polimapper.data.keyColour3,
      pointColor: Polimapper.data.keyColour3,
      pointStrokeColor: Polimapper.data.keyColour3,
      pointHighlightFill: Polimapper.data.keyColour3,
      pointHighlightStroke: "rgba(220,220,220,1)",
      data: avgNumbers
      //data: [constituency.data[key], dataField.average]
    };

    var maxDataset = {
      label: 'Max',
      fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour1, 20),
      strokeColor: Polimapper.data.keyColour1,
      highlightFill: Polimapper.data.keyColour1,
      pointColor: Polimapper.data.keyColour1,
      pointStrokeColor: Polimapper.data.keyColour1,
      pointHighlightFill: Polimapper.data.keyColour1,
      pointHighlightStroke: "rgba(220,220,220,1)",
      data: maxNumbers
      //data: [constituency.data[key], dataField.average]
    };

    var summaryDatasets = [];

    if (!dataField.excludeMinFromDataSetSummaryGraph) {
      summaryDatasets.push(minDataset);
    }
    if (!dataField.excludeAverageFromDataSetSummaryGraph) {
      summaryDatasets.push(avgDataset);
    }
    if (!dataField.excludeMaxFromDataSetSummaryGraph) {
      summaryDatasets.push(maxDataset);
    }

    var data = {
      labels: columnKeys,
      datasets: summaryDatasets
    };

    var ctx = $('#' + Polimapper.toSlug(key)).get(0).getContext("2d");
    var myBarChart = new Chart(ctx).Bar(data, {
      //animateScale: true,
      responsive: true,
      labelLength: 30,
      multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel %>:  <%}%><%= Polimapper.addCommas(value) %>",
      //segmentShowStroke : false
    });
  };

  Polimapper.setLocalData = function (key, data) {
    if (!window.localStorage) {
      return;
    }
    try {
      window.localStorage.setItem(key, JSON.stringify(data));
  } catch (error) {
      console.log('Error in local storage', error);
      window.localStorage.setItem(key, JSON.stringify(data));
  }
  };

    Polimapper.getLocalData = function (key) {
    if (!window.localStorage) {
      return null;
    }

    return JSON.parse(window.localStorage.getItem(key));
  };

  Polimapper.summaryData = function () {

    var orderedDatafields = Polimapper.orderDatafields(Polimapper.data.dataFields);
    Polimapper.setPageTitle(Polimapper.data.title);

    $('#data .totals .result').remove();
    // $('#data .back-map').hide();
    $('.graph-wrapper').html('');
    for (var i = 0; i < orderedDatafields.length; i++) {
      var dataField = orderedDatafields[i];
      var key = dataField.name;
      var label = dataField.columns[0].label ? dataField.columns[0].label : dataField.name;

      if (dataField.showAverageInDataSetSummary || dataField.showTotalInDataSetSummary) {

        //CHANGED THE WAY THE LOOP WORKS SO WE CAN REORDER THE DATAFIELDS
        //}
        //for (var key in node.data) {

        //CHANGED THE WAY THE LOOP WORKS SO WE CAN REORDER THE DATAFIELDS
        //var dataField = Polimapper.arrayLookup (Polimapper.data.dataFields, "name", key);

        dataField.average = dataField.average || 0;
        dataField.totalValue = dataField.totalValue || 0;

        var currency = "";
        var average = dataField.averageOverride ? dataField.averageOverride : dataField.average.toFixed(2);
        var total = dataField.totalValue.toFixed(2);
        var legend = '';
        var description = null;

        switch (dataField.type) {
          case "Pound":
          case "Euro":
          case "Dollar":
          case "Decimal":
          case "Number":

            var template;
            var number = parseFloat(total);

            if (dataField.type === 'Pound') {
              currency = "&#163; ";
            }

            if (dataField.type === 'Dollar') {
              currency = "&#36; ";
            }

            if (dataField.type === 'Euro') {
              currency = "&#128; ";
            }

            var maxNumbers = "";
            var minNumbers = "";
            var avgNumbers = "";
            var columnKeys = "";
            var totalValues = 0;
            var icons = '';

            /* jshint ignore:start */
            dataField.columns.forEach(function (columnDefinition, i) {
              columnKeys = columnKeys + ',' + columnDefinition.label;
              maxNumbers = maxNumbers + ',' + columnDefinition.maxValue;
              minNumbers = minNumbers + ',' + columnDefinition.minValue;
              columnDefinition.average = columnDefinition.average || 0;
              columnDefinition.totalValue = columnDefinition.totalValue || 0;
              avgNumbers = avgNumbers + ',' + (columnDefinition.averageOverride ? columnDefinition.averageOverride.toFixed(2) : columnDefinition.average.toFixed(2));
              icons = icons + ',' + columnDefinition.icon;

              if (i === dataField.columns.length - 1) {
                totalValues += columnDefinition.totalValue;
              }
              // do stuff
            });
            /* jshint ignore:end */

            maxNumbers = Polimapper.parseValueStrings(maxNumbers);
            minNumbers = Polimapper.parseValueStrings(minNumbers);
            avgNumbers = Polimapper.parseValueStrings(avgNumbers);
            columnKeys = Polimapper.parseValueStrings(columnKeys);
            icons = Polimapper.parseValueStrings(icons);

            // create legend

            if (!dataField.excludeMinFromDataSetSummaryGraph) {
              legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour4 + ';"></span> Min</div>';
            }
            if (!dataField.excludeAverageFromDataSetSummaryGraph) {
              legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour3 + ';"></span> Avg</div>';
            }
            if (!dataField.excludeMaxFromDataSetSummaryGraph) {
              legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour1 + ';"></span> Max</div>';
            }

            if (!dataField.isMultivalued) {
              columnKeys[0] = '';
            } else {
              number = parseFloat(totalValues.toFixed(2));
            }

            if (!dataField.showTotalInDataSetSummary) {
              number = '';
            }

            if (number > 1000000) {
              template = Polimapper.templates['src/templates/bigNumber.handlebars'];
            } else {
              template = Polimapper.templates['src/templates/number.handlebars'];

              number = Polimapper.numberWithCommas(number);
            }

            if (!dataField.showAverageInDataSetSummary) {
              legend = null;
              escapedName = null;
              description = null;
            } else {
              description = dataField.description;
            }

            if (icons === '') {
              icons = [];
            }

            var context = {
              name: dataField.name,
              value: number,
              currency: Polimapper.decodeHtml(currency),
              icons: icons.reverse(),
              escapedName: Polimapper.toSlug(dataField.name),
              multivalued: dataField.isMultivalued,
              label: label,
              description: description,
              total: dataField.showTotalInDataSetSummary,
              legend: legend !== '',
              legendHtml: legend,
              showGraph: dataField.showAverageInDataSetSummary
            };
            var html = template(context);


            $('.graph-wrapper').append('<div class="col-md-6 graph-data"><div class="card">' + html + '</div></div>');
            // $('#data .totals').append(html);

            var minDataset = {
              label: 'Min',
              fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour4, 20),
              strokeColor: Polimapper.data.keyColour4,
              highlightFill: Polimapper.data.keyColour4,
              highlightStroke: "rgba(220,220,220,1)",
              pointColor: Polimapper.data.keyColour4,
              pointStrokeColor: Polimapper.data.keyColour4,
              pointHighlightFill: Polimapper.data.keyColour4,
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: minNumbers
              //data: [constituency.data[key], dataField.average]
            };

            var avgDataset = {
              label: 'Avg',
              fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour3, 20),
              strokeColor: Polimapper.data.keyColour3,
              highlightFill: Polimapper.data.keyColour3,
              pointColor: Polimapper.data.keyColour3,
              pointStrokeColor: Polimapper.data.keyColour3,
              pointHighlightFill: Polimapper.data.keyColour3,
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: avgNumbers
              //data: [constituency.data[key], dataField.average]
            };

            var maxDataset = {
              label: 'Max',
              fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour1, 20),
              strokeColor: Polimapper.data.keyColour1,
              highlightFill: Polimapper.data.keyColour1,
              pointColor: Polimapper.data.keyColour1,
              pointStrokeColor: Polimapper.data.keyColour1,
              pointHighlightFill: Polimapper.data.keyColour1,
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: maxNumbers
              //data: [constituency.data[key], dataField.average]
            };

            var summaryDatasets = [];

            if (!dataField.excludeMinFromDataSetSummaryGraph) {
              summaryDatasets.push(minDataset);
            }
            if (!dataField.excludeAverageFromDataSetSummaryGraph) {
              summaryDatasets.push(avgDataset);
            }
            if (!dataField.excludeMaxFromDataSetSummaryGraph) {
              summaryDatasets.push(maxDataset);
            }

            if (dataField.showAverageInDataSetSummary) {

              var data = {
                labels: columnKeys,
                datasets: summaryDatasets
              };
              var ctx = $('#' + Polimapper.toSlug(key)).get(0).getContext("2d");

              var myBarChart;

              if (dataField.graphType === 'Bar' || !dataField.isMultivalued) {
                myBarChart = new Chart(ctx).Bar(data, {
                  //animateScale: true,
                  responsive: true,
                  labelLength: 30,
                  tooltipTemplate: "<%if (label){%><%=label %>:  <%}%><%= Polimapper.addCommas(value) %>",
                  multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel %>:  <%}%><%= Polimapper.addCommas(value) %>",
                  //segmentShowStroke : false
                });
              } else {
                myBarChart = new Chart(ctx).Line(data, {
                  //animateScale: true,
                  responsive: true,
                  labelLength: 30,
                  tooltipTemplate: "<%if (label){%><%=label %>:  <%}%><%= Polimapper.addCommas(value) %>",
                  multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel %>:  <%}%><%= Polimapper.addCommas(value) %>",
                  //segmentShowStroke : false
                });
              }
            }

            //Pretify number
            $('.pretty-number').removeAttr("data-pretty-number");
            $('.pretty-number').prettyNumber();

            break;
          case "Percentage":
            if (dataField.showAverageInDataSetSummary || dataField.showTotalInDataSetSummary) {
              if (!dataField.isMultivalued) {
                var handlebarsTemplate = Polimapper.templates['src/templates/percentage.handlebars'];
                var templateContext = {
                  name: dataField.name,
                  value: average,
                  icon: dataField.icon,
                  escapedName: Polimapper.toSlug(dataField.name),
                  label: label,
                  description: dataField.description,
                  showGraph: dataField.showAverageInDataSetSummary
                };
                var templateOutput = handlebarsTemplate(templateContext);
                $('#data .totals').append(templateOutput);

                var d = [{
                  value: average,
                  color: Polimapper.data.keyColour1,
                  highlight: "#FF5A5E",
                  label: "Average"
                },
                {
                  value: 100 - average,
                  color: "#f1f1f1",
                  highlight: "#f1f1f1",
                  label: ""
                },
                ];

                if (dataField.showAverageInDataSetSummary) {

                  //document.getElementById('#' + key).getContext("2d");
                  var ctxt = $('#' + Polimapper.toSlug(key)).get(0).getContext("2d");
                  var myDoughnutChart = new Chart(ctxt).Doughnut(d, {
                    animateScale: true,
                    labelLength: 30,
                    //responsive: true,
                    segmentShowStroke: false
                  });
                }
              } else {
                Polimapper.drawMultivalueSummaryBarChart(dataField, key, label);
              }
            }
            break;
        }
      }
    }
    //Polimapper.equalHeight(false, 'result_graph');
  };


  Polimapper.addCommas = function (nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  };

  Polimapper.parseValueStrings = function (values) {
    if (values.substring(0, 1) == ',') {
      values = values.substring(1).split(',');
    }
    return values;
  };

  Polimapper.orderDatafields = function (datafields) {
    var orderedDataFields = _.sortBy(datafields, function (t) {
      return [t.parentId,t.isGroup,t.sequence_no];
      // return [t.parentId,t.isGroup];
    });

    for (var i = 0; i < orderedDataFields.length; ++i) {
      orderedDataFields[i].columns = _.sortBy(orderedDataFields[i].columns, function (t) {
        return t.columnIndex;
      });
    }
    return orderedDataFields;
  };

  Polimapper.orderDatafields2 = function (dataFields) {

    var orderedDatafields;

    orderedDatafields = _.filter(dataFields, function (t) {
      return t.type === 'Number';
    });
    orderedDatafields = _.union(orderedDatafields, _.filter(dataFields, function (t) {
      return t.type === 'Decimal';
    }));
    orderedDatafields = _.union(orderedDatafields, _.filter(dataFields, function (t) {
      return t.type === 'Pound';
    }));
    orderedDatafields = _.union(orderedDatafields, _.filter(dataFields, function (t) {
      return t.type === 'Euro';
    }));
    orderedDatafields = _.union(orderedDatafields, _.filter(dataFields, function (t) {
      return t.type === 'Dollar';
    }));
    orderedDatafields = _.union(orderedDatafields, _.filter(dataFields, function (t) {
      return t.type === 'Percentage';
    }));
    orderedDatafields = _.union(orderedDatafields, _.filter(dataFields, function (t) {
      return t.type === 'Text';
    }));
    orderedDatafields = _.union(orderedDatafields, _.filter(dataFields, function (t) {
      return t.type === 'Hyperlink';
    }));
    return orderedDatafields;
  };

  Polimapper.orderNodesByColumnValue = function (datafield, dataColumn) {
    return _.sortBy(Polimapper.data.nodes, function (node) {
      return isNaN(parseFloat(node.columnValue(datafield, dataColumn))) ? null : parseFloat(node.columnValue(datafield, dataColumn));
    }).reverse();
  };

  Polimapper.loadRankingIcons = function (node) {
    var comparableFields = _.filter(Polimapper.data.dataFields, function (t) {
      return t.comparable && t.type !== 'Text';
    });
    var showRankingTitle = false;
    $('#ranking_title')[0].innerHTML = '';

    for (var i = 0; i < comparableFields.length; ++i) {
      var comparableField = comparableFields[i];
      var lastIndex = comparableField.columns.length - 1;
      var column = comparableField.columns[lastIndex];
      var value = node.columnValue(comparableField.name, column.name);
      var orderedNodes = null;
      var nodesTotal = Polimapper.data.nodes.length;
      if (node.columnValue(comparableField.name, column.name) !== null && column.displayRankings) {
        //sending value for ranking instead of node name
        if (!showRankingTitle) {
          $('#ranking_title')[0].innerHTML = Polimapper.data.topology.labelForSingularNode + ' Rankings' + '<div class="total-nodes">' + ' OUT OF ' + nodesTotal + '</div>';
          showRankingTitle = true;
        }

        if (!column.invertRankings) {
          orderedNodes = Polimapper.orderNodesByColumnValue(comparableField.name, column.name);
        } else {
          orderedNodes = Polimapper.orderNodesByColumnValue(comparableField.name, column.name).reverse();
        }

        var ranking = Polimapper.arrayRankingLookup(orderedNodes, comparableField.name, column.name, node.columnValue(comparableField.name, column.name)) + 1;
        var template = Polimapper.templates['src/templates/rankings.handlebars'];
        var context = {
          name: column.name,
          fieldName: comparableField.name,
          icon: column.icon,
          ranking: ranking,
        };
        var html = template(context);
        $('#rankings').append(html);
      }
      /*for (var k = 0; k < comparableField.columns.length; k++) {
          var column = comparableField.columns[k];
          var value = node.columnValue(comparableField.name, column.name);
          if(node.columnValue(comparableField.name, column.name) !== null) {
            //sending value for ranking instead of node name
          var ranking = Polimapper.arrayRankingLookup(Polimapper.orderNodesByColumnValue(comparableField.name, column.name), comparableField.name, column.name, node.columnValue(comparableField.name, column.name)) + 1;
          var template = Polimapper.templates['src/templates/rankings.handlebars'];
          var context = { name: column.name, fieldName: comparableField.name, icon: column.icon, ranking: ranking };
          var html = template(context);
          $('#rankings').append(html);
        }
      }*/
    }
    $('#rankings .icon').bind("mouseover", function (e) {
      $('#cons_name_overlay').empty().append($(this).data("name"));
      if (!$('.showmap').is(':visible')) {
        $('#cons_name_overlay').css("left", e.pageX - 50);
        $('#cons_name_overlay').css("top", e.pageY - 20);
      } else {
        $('#cons_name_overlay').css("left", e.pageX - 50);
        $('#cons_name_overlay').css("top", e.pageY + 20);
      }
    });

    $("#rankings .icon").bind(" mouseenter", function () {
      $("#cons_name_overlay").show();
    }).mouseleave(function () {
      $("#cons_name_overlay").hide();
    });
  };
})(Polimapper.$ || window.$, Polimapper._ || window._, Polimapper.Chart || window.Chart);


if (!window.Polimapper) Polimapper = {};

(function($, _) {
  Polimapper.loadScript = function (input) {
    if (input !== null) {
      postscribe(document.getElementsByTagName("body")[0], input);
    }
  };

  Polimapper.arrayLookup = function (array, prop, value) {
    for (var i = 0, len = array.length; i < len; i++)
      if (array[i][prop] === value) return array[i];
  };

  Polimapper.arrayIndexLookup = function (array, prop, value) {
    for (var i = 0, len = array.length; i < len; i++)
      if (array[i][prop] === value) return i;
  };

  Polimapper.arrayRankingLookup = function (array, dataField, dataColumn, value) {
    for (var i = 0, len = array.length; i < len; i++)
      if (array[i].columnValue(dataField, dataColumn) === value) return i;

  };

  Polimapper.toSlug = function (Text) {
    return Text
      .toLowerCase()
      .replace(/[^\w ]+/g, '')
      .replace(/ +/g, '-');
  };

  Polimapper.getUrlVariable = function (variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
      var pair = vars[i].split("=");
      if (pair[0] == variable) { return pair[1]; }
    }
    return (false);
  };

  Polimapper.getUrlVariableEnhanced = function (variable) {
    var query = window.location.pathname;

    var vars = query.split("/");
    for (var i = 0; i < vars.length; i++) {
      return vars[1]; 
    }
    return (false);
  };

  Polimapper.getHashParams = function () {
    var hashParams = {};
    var e,
        a = /\+/g,  // Regex for replacing addition symbol with a space
        r = /([^&;=]+)=?([^&;]*)/g,
        d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
        q = window.location.hash.substring(1);

    /* jshint ignore:start */
    while (e = r.exec(q))
      hashParams[d(e[1])] = d(e[2]);
    /* jshint ignore:end */

    return hashParams;
  };

  Polimapper.getHashParam = function (key) {
    var hashParams = Polimapper.getHashParams();
    return hashParams[key];
  };

  Polimapper.setHashParam = function(key, value) {
    var hashParams = Polimapper.getHashParams();

    hashParams[key] = value;

    var hash = '#';

    for (var property in hashParams) {
      if (hashParams.hasOwnProperty(property)) {
        if (hash !== '#') {
          hash += '&';
        }
        hash += property + '=' + encodeURIComponent(hashParams[property]);
      }
    }

    window.location.hash = hash;
  };

  Polimapper.isMobile = function() {
    return $('.polimapper-mobile').is(':visible');
  };

  Polimapper.isResizeMobile = function() {
    return ($.trim( $('.polimapper-mobile').html()).length === 0 && $('.polimapper-mobile').is(':visible'));
  };

  Polimapper.isResizeDesktop = function() {
    return ($.trim( $('.polimapper-desktop').html()).length === 0 && $('.polimapper-desktop').is(':visible'));
  };

  Polimapper.decodeHtml = function (input) {
    var y = document.createElement('textarea');
    y.innerHTML = input;
    return y.value;

  };

  Polimapper.hexToRgba = function (hex,opacity){
      hex = hex.replace('#','');
      r = parseInt(hex.substring(0,2), 16);
      g = parseInt(hex.substring(2,4), 16);
      b = parseInt(hex.substring(4,6), 16);

      result = 'rgba('+r+','+g+','+b+','+opacity/100+')';
      return result;
  };

  Polimapper.numberWithCommas = function (n) {
    if (!n) { return n; }
    var parts = n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
  };

  Polimapper.equalHeight  = function (resize, cssClass) {
    var elements = document.getElementsByClassName(cssClass),
        allHeights = [],
        i = 0;
    if(resize === true){
      for(i = 0; i < elements.length; i++){
        elements[i].style.height = 'auto';
      }
    }
    for(i = 0; i < elements.length; i++){
      var elementHeight = elements[i].clientHeight;
      allHeights.push(elementHeight);
    }
    for(i = 0; i < elements.length; i++){
      elements[i].style.height = Math.max.apply( Math, allHeights) + 'px';
      if(resize === false){
        elements[i].className = elements[i].className + " show";
      }
    }
  };

  SVGElement.prototype.hasClass = function (className) {
    return new RegExp('(\\s|^)' + className + '(\\s|$)').test(this.getAttribute('class'));
  };

  SVGElement.prototype.addClass = function (className) {
    if (!this.hasClass(className)) {
      this.setAttribute('class', this.getAttribute('class') + ' ' + className);
    }
  };

  SVGElement.prototype.removeClass = function (className) {
    var removedClass = this.getAttribute('class').replace(new RegExp('(\\s|^)' + className + '(\\s|$)', 'g'), '$2');
    if (this.hasClass(className)) {
      this.setAttribute('class', removedClass);
    }
  };

  SVGElement.prototype.toggleClass = function (className) {
    if (this.hasClass(className)) {
      this.removeClass(className);
    } else {
      this.addClass(className);
    }
  };

  Polimapper.addClass = function(element, className) {
    var c = element.getAttribute('class');
    var newClass = (c || '').replace(className, '');
    element.setAttribute('class', newClass + (newClass ? ' ' : '') + className);
  };

  Polimapper.removeClass = function(element, className) {
    var c = element.getAttribute('class');
    element.setAttribute('class', (c || '').replace(className, ''));
  };

  Element.prototype.remove = function () {
    this.parentElement.removeChild(this);
  };

  NodeList.prototype.remove = HTMLCollection.prototype.remove = function () {
    for (var i = this.length - 1; i >= 0; i--) {
      if (this[i] && this[i].parentElement) {
        this[i].parentElement.removeChild(this[i]);
      }
    }
  };
})(Polimapper.$ || window.$, Polimapper._ || window._);

if (!window.Polimapper) Polimapper = {};

(function ($, _) {

  Polimapper.setMapDetails = function () {
    Polimapper.setPageTitle(Polimapper.data.title);
    document.getElementsByClassName("loading").remove();
    $('body').removeClass('fixed-body');
    // $('body').css('font-family',Polimapper.data.fontFamily.font_family + ', sans-serif');
    $('.node-description-wraper').hide();
    $('#name').empty().html(Polimapper.data.title);
    $('#description').empty().html(Polimapper.data.description);
    $('.node_description').empty().html(Polimapper.data.nodeDescription);
    $("#logo").attr('src', Polimapper.data.logo);
    $("#logo-mobile").attr('src', Polimapper.data.logo);
    $(".content").empty().html(Polimapper.data.footerContent);
    $("#project_password").val(Polimapper.data.project_status.password);
    $("#project_key").val(Polimapper.data.key);

    // grouplinks
      if(Polimapper.data.isGroup === true){
        document.getElementById('select_group').onchange = function () {
        var url = window.location.origin;
        var newKey = $("#select_group").val();
        window.location.href = url +'?'+newKey;
        localStorage.setItem('selectedGroup',newKey)
      }
        for (var i = 0; i < Polimapper.data.grouplinks.length; i++) {
        $("#select_group").append("<option value='"+Polimapper.data.grouplinks[i].url+"'>"+Polimapper.data.grouplinks[i].name + "</option>");
      if(localStorage.getItem('selectedGroup'))  {
        const result = Polimapper.data.grouplinks.find(({ url }) => url === localStorage.getItem('selectedGroup'));
        if(result){
          $("#select_group").val(localStorage.getItem('selectedGroup'));
        }
      }
      }
      }else{
        $("#select_group").remove();
      }
      
// select_group
    if (Polimapper.data.socialShare !== false) {
      if (Polimapper.data.sociallinksarray[0].enable !== false) {
        $("#is_facebook").val(Polimapper.data.sociallinksarray[0].text);
      } else {
        $("#is_facebook_modal").remove();
      }
      if (Polimapper.data.sociallinksarray[3].enable !== false) {
        $("#is_linkedin").val(Polimapper.data.sociallinksarray[3].text);
      } else {
        $("#is_linkedin_modal").remove();
      }
      if (Polimapper.data.sociallinksarray[2].enable !== false) {
        $("#is_twitter").val(Polimapper.data.sociallinksarray[2].text);
      } else {
        $("#is_twitter_modal").remove();
      }
      //if(Polimapper.data.sociallinksarray[1].enable !==false){
      // $("#is_insta").attr('href', Polimapper.data.sociallinksarray[1].text);
      // }else{
      //  $("#is_insta_modal").remove();
      // }
    } else {
      $("#is_facebook_modal").remove();
      $("#is_linkedin_modal").remove();
      $("#is_twitter_modal").remove();
      // $("#is_insta_modal").remove();
    }

    if (Polimapper.data.topology.name !== 'UK Constituency Map') {
      $(".modal-map-legend").remove();
    }
    if (Polimapper.data.emailFriend !== false) {
      $("#email_friend_title").val(Polimapper.data.emailFriendTitle);
      $("#email_friend_text").empty().html(Polimapper.data.emailFriendCody);
    } else {
      $("#is_email_friend").remove();
    }

    // email mp
    if (Polimapper.data.emailMP !== false) {
      $("#email_mp_sub").val(Polimapper.data.emailMPTitle);
      //$("#email_mp_message").empty().html(Polimapper.data.emailMPMessage);

    } else {
      $("#email_mp_share").remove();
    }

    if (Polimapper.data.tweetMP !== false) {
      // $("#is_twitter_text").empty().html(Polimapper.data.tweetMPText);
    } else {
      $("#email_mp_tweet").remove();
    }
    // country function 
    var url = Polimapper.baseUrl + "/nodes/?dataSetKey=" + Polimapper.data.key;
    // var url = Polimapper.baseUrl + "/generator/?dataSetKey=" + Polimapper.data.key;
    var cacheKey = 'nodes';
    var nodeData;
    Polimapper.loadData(cacheKey, url, {}, function (results) {
      nodeData = results.nodes
    });
  
    document.getElementById('sel_con').onchange = function () {
      $('.constituency-view #data_selector').hide();
      if (Polimapper.data.topology.name !== 'Postcodes Map') {
        $('.postal-wrapper').hide();
      }
    }

    if (Polimapper.data.topology.name == 'UK Constituency Map') {
      document.getElementById('sel_con').onchange = function () {
        var selectedValue = $("#sel_con").val();
        let myArr = nodeData;
        const result = myArr.find(({ name }) => name === selectedValue);
        $("#email_mp_message").empty().html("Hii " + result.mpdetails.prefix + ', ' + result.mpdetails.fname + ' ' + result.mpdetails.lname + "\n" + Polimapper.data.emailMPMessage);
        $("#is_twitter_text").empty().html("Hii " + result.mpdetails.prefix + ', ' + result.mpdetails.fname + ' ' + result.mpdetails.lname + "\n" + Polimapper.data.tweetMPText);
        $('#mp_name').empty().html(result.mpdetails.fname + ' ' + result.mpdetails.lname);
        $("#mp_profile_url").attr('href', result.mpdetails.profile_url);
        $("#mp_email").val(result.mpdetails.email);
        // email_mp_tweet
        var tid = result.mpdetails.twitter_handle.replace('\r\n', '');
        if (tid.toUpperCase() == "NOT ON TWITTER") {
          $("#email_mp_tweet").hide();
          $("#not_on_twitter").show();
          $("#not_on_twitter").empty().html(result.mpdetails.twitter_handle);
        } else {
          $("#not_on_twitter").hide();
          $("#email_mp_tweet").show();
          $("#mp_twitter_id").val(result.mpdetails.twitter_handle);
        }
      }
    };
    //DataFields mix-min value
    document.getElementById('data_con').onchange = function (e) {
      $('.ischild').hide();
      var name = $(e.target).find("option:selected").attr('data-class');
      var seleceted = $(e.target).find("option:selected")
      if (name == "isparent") {
        seleceted.next().css("display", "block");
      }

      var datafieldselectedValue = $("#data_con").val();
      let dataFieldsArr = Polimapper.data.dataFields;
      const resultData = dataFieldsArr.find(({ name }) => name === datafieldselectedValue);
      $('.map-key').empty();
      $('#defaultcolor').remove();
      $('#onchangecolor').remove();
      var colorCount = resultData.keyColors.length;
      css = '<style id="onchangecolor" type="text/css">';
      for (var i = 0; i < colorCount; i++) {
        $('.map-key').append('<div class="map-val"><div class="bar" style="height:20px !important; background:' + resultData.keyColors[i].keyColor + '"></div><span id="pn' + (i + 1) + '" class="pretty-number"></span></div>');
        css = css + '.keyColour' + (i + 1) + '{fill: ' + resultData.keyColors[i].keyColor + '; }';
        if (i == 0) {
          $("#pn" + (i + 1)).empty().text(resultData.keyColors[i].minKeyValue);
        } else {
          $("#pn" + (i + 1)).empty().html(resultData.keyColors[i].minKeyValue + ' - ' + resultData.keyColors[i].MaxKeyValue);
        }
      }
      css = css + '100%);}</style>';
      $(document.body).prepend($(css));
      $('.map-key').append('<div class="map-val"><div class="bar" style="height:20px !important; background:#dedede"></div><span id="nodata" class="pretty-number">Data unavailable</span></div>');

    }

    //Ajax view count projects
    var dataKeySelected = Polimapper.data.key;

    function setCookie(cname, cvalue, exdays) {
      const d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      let expires = "expires=" + d.toGMTString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }


    if(getCookie('is_viewed_'+dataKeySelected) == '' || getCookie('is_viewed_'+dataKeySelected) != 1){

      urlnew = Polimapper.baseUrl+"/generator/projectviewcount.php";
      $.ajax({
        type: "POST",
        url: urlnew,
        data: {'viewcount':1,'key':dataKeySelected},
        success: function (results) {
          setCookie('is_viewed_'+dataKeySelected,1,1);
        },
        error: function (xhr) {
          console.log(xhr);
        }
      });
     }


    // Map Double click function
    $(".svg_wrapper svg").dblclick(function () {
      var cons_name_overlay = $("#cons_name_overlay").html();
      let myArr = nodeData;
      const dblresult = myArr.find(({ name }) => name === cons_name_overlay);
      if (dblresult == undefined) {
        $("#undefined").show();
        $("#undefined").html(cons_name_overlay + " is not found.").fadeOut(4000);
      } else {
        $("#undefined").hide();
        $('#sel_con').val(cons_name_overlay).change();
        $('.closes').show();
      }
    });



    //selected datafield
    $('.map-key').empty();
    // let dataFieldsArray = Polimapper.data.dataFields;
    var resultArray = _.filter(Polimapper.orderDatafields(Polimapper.data.dataFields), function (t) {
      return t.comparable;
    });
    var colorCount = resultArray[0].keyColors.length;
   
    css = '<style type="text/css">';
    for (var i = 0; i < colorCount; i++) {
      $('.map-key').append('<div class="map-val"><div class="bar" style="height:20px !important; background:' + resultArray[0].keyColors[i].keyColor + '"></div><span id="pn' + (i + 1) + '" class="pretty-number"></span></div>');
      css = css + '.keyColour' + (i + 1) + '{fill: ' + resultArray[0].keyColors[i].keyColor + '; }';
      if (i == 0) {
        $("#pn" + (i + 1)).empty().text(resultArray[0].keyColors[i].minKeyValue);
      } else {
        $("#pn" + (i + 1)).empty().html(resultArray[0].keyColors[i].minKeyValue + ' - ' + resultArray[0].keyColors[i].MaxKeyValue);
      }
    }
    css = css + '100%);}</style>';
    $('.map-key').append('<div class="map-val"><div class="bar" style="height:20px !important; background:#dedede"></div><span id="nodata" class="pretty-number">Data unavailable</span></div>');


    // project status check
    var passkey = localStorage.getItem('passKey');
    var projectKey = localStorage.getItem('projectKey');
    if (Polimapper.data.project_status.visibility == 'draft') {
      $('.polimapper').remove();
      $('.protected-project').empty().html('<div class="draft-project"><h2>Hii, your project ' + Polimapper.data.title + ' is in draft.</h2>');
    } else {
      if (Polimapper.data.project_status.password_protected == true) {
        if (passkey == Polimapper.data.project_status.password && projectKey == Polimapper.data.key) {
        } else {
          if (Polimapper.data.project_status.password !== null) {
            $('.polimapper').remove();
            $('.protected-project').empty().html('<div class="protected-form"><div><div class="form-fields"><form><input type="password" id="input_password" value="" autocomplete="off" placeholder="Enter your project password"></form><button id="password_verify" onclick="verifyPass()">Verify</button></div><span id="password_error"></span></div></div>');
          } else {
          }
        }
      } else {
        //
      }
    }
    $('.closes').on('click',function() {
      $('#data .results').empty().append("<div class='totals'><h2 id='name'></h2><div id='description'> </div></div>");
      $('#name').empty().html(Polimapper.data.title);
      $('#description').empty().html(Polimapper.data.description);
    $('#data_selector').show();
    $('#sel_con').select2({
      placeholder: 'Enter a '+ Polimapper.data.topology.labelForSingularNode
  });
  $('span.select2').css(
    {
      "color": Polimapper.data.secondaryColour,
      "background": Polimapper.data.primaryColour
    }
);
$('body .select2-selection__arrow b').append('<svg xmlns="http://www.w3.org/2000/svg" width="67" height="67" viewBox="0 0 67 67"><path d="M33.5,0A33.5,33.5,0,1,1,0,33.5,33.5,33.5,0,0,1,33.5,0ZM29.53,21.054a9.277,9.277,0,0,0-9.5,9,9.27,9.27,0,0,0,9.5,9,9.27,9.27,0,0,0,9.5-9,9.281,9.281,0,0,0-9.5-9ZM49.464,50.947h0a2.492,2.492,0,0,1-1.7-.672l-9.593-8.953a14.2,14.2,0,0,1-8.391,2.732l-.245,0-.245,0a14.257,14.257,0,0,1-14.254-14,14.257,14.257,0,0,1,14.254-14l.245,0h0l.246,0a14.257,14.257,0,0,1,14.253,14,14.176,14.176,0,0,1-2.4,7.662l9.544,8.9a2.5,2.5,0,0,1-1.706,4.327h0Z" fill-rule="evenodd"/></svg>')
$('body .select2-selection__arrow b svg path').css(
  {
    "fill": Polimapper.data.secondaryColour
  });
      var url = window.location.href.split('#')[0];
      setTimeout(function(){
          history.replaceState("", null, url);
      }, 1);
  });

    //------------------------------------ Colours
    var style = $('<style>.results *  { color: ' + Polimapper.data.secondaryColour + ' !important' + '}  </style>');
    $('html > head').append(style);

    var style = $('<style>.mytooltip svg path { fill: ' + Polimapper.data.secondaryColour + ' !important' + '}  </style>');
    $('html > head').append(style);


    //---- set secondary colour
    $('.polimapper .app_wrapper .map-section .map-option .buttons span svg path, .print svg path').css(
      {
        "fill": Polimapper.data.secondaryColour
      }
    );
    $('input#postcode, .graph-section.footer-area *, .polimapper .closes.cus-close a, .node-description-wraper, .sbm-btn-white, .sbm-btn, .protected-form button, span.select2, .node-description-wraper').css(
      {
        "color": Polimapper.data.secondaryColour
      }
    );
    $('.custom-topbar .postcodea .icon-wrapper').css(
      {
        "border-color": Polimapper.data.secondaryColour
      }
    );

    $('body .select2-selection__arrow b').append('<svg xmlns="http://www.w3.org/2000/svg" width="67" height="67" viewBox="0 0 67 67"><path d="M33.5,0A33.5,33.5,0,1,1,0,33.5,33.5,33.5,0,0,1,33.5,0ZM29.53,21.054a9.277,9.277,0,0,0-9.5,9,9.27,9.27,0,0,0,9.5,9,9.27,9.27,0,0,0,9.5-9,9.281,9.281,0,0,0-9.5-9ZM49.464,50.947h0a2.492,2.492,0,0,1-1.7-.672l-9.593-8.953a14.2,14.2,0,0,1-8.391,2.732l-.245,0-.245,0a14.257,14.257,0,0,1-14.254-14,14.257,14.257,0,0,1,14.254-14l.245,0h0l.246,0a14.257,14.257,0,0,1,14.253,14,14.176,14.176,0,0,1-2.4,7.662l9.544,8.9a2.5,2.5,0,0,1-1.706,4.327h0Z" fill-rule="evenodd"/></svg>')


    $('body .select2-selection__arrow b svg path').css(
      {
        "fill": Polimapper.data.secondaryColour
      }
    );

    //--- set primary colour
    $('#name, #description, select#sel_con,.graph-section.footer-area, .polimapper .searchbox select, .polimapper div.app_wrapper div.data h2.con_name, .polimapper div.app_wrapper div.data .results h3.n, .polimapper div.app_wrapper div.data .results h3, .modal-map-legend .mp-name, .modal-map-legend .link-bio a, .modal-map-legend .email-mp, .modal-map-legend .tweet-mp, .sbm-modal-title h2, .sbm-modal-title p, .sbm-modal-1 .modal-right-content p, .sbm-modal-1-form .form-field, .form-field, .protected-form input ').css(
      {
        "color": Polimapper.data.primaryColour
      }
    );

    $('.modal-map-legend .left-box, .sbm-modal-1-form, .sbm-btn-white, .sbm-btn, .protected-form button, span.select2, .node-description-wraper' ).css(
      {
        "background": Polimapper.data.primaryColour
      }
    );

    $('.sbm-modal-1-form .form-field, .form-field, .sbm-btn-white, .sbm-btn, .bordered-box-1, .protected-form button,  .protected-form input').css(
      {
        "border-color": Polimapper.data.primaryColour
      }
    );


    $('span.zoom-out, span.zoom-in, .graph-section.footer-area, #postcode, .graph-section, .polimapper .closes.cus-close, .select2-container--default').css(
      {
        "background-color": Polimapper.data.primaryColour
      }
    );
    $('.social a svg path, .select-wrapper svg path, .polimapper .close path, #select_group').css(
      {
        "fill": Polimapper.data.primaryColour
      }
    );
    //__________________________________________________________ Set fonts
    function addGoogleFont(fontFamily, Property) {
      //  FontName = fontFamily.replace(/ /g, '+');
      $("head").append("<link href='https://fonts.googleapis.com/css?family=" + fontFamily.font_family + "' rel='stylesheet' type='text/css'>");

      $('.polimapper, .polimapper .app_wrapper, .polimapper .content-wrapper .showmap, .autocomplete-suggestions,   .footer-take-over, .polimapper, .polimapper a, .polimapper select, .polimapper button, .polimapper input, .polimapper textarea, .polimapper div.topbar h2#name, .polimapper div.app_wrapper div.map .dtfield h2, .polimapper div.app_wrapper div.map .dtfield h2, .polimapper div.app_wrapper div.map div.options div.text .select-wrapper select, .polimapper div.app_wrapper div.data .results, .polimapper div.app_wrapper div.data .results p.description, .polimapper div.app_wrapper div.data .copy p, .polimapper .searchbox input, .polimapper .searchbox select, .polimapper .lightbox h3, .polimapper .modal-dialog, #select2-sel_con-results .select2-results__option, .select2-container, body').css("font-family", fontFamily.font_family + ', sans-serif');
    }
    addGoogleFont(Polimapper.data.fontFamily, Polimapper.data.fontFamily);
    // for example

    //___________________________________________________________ Set logo
    $('.logo-sec .logo').attr("src", Polimapper.data.logo);

    Polimapper.setOGImage();
  };

  Polimapper.setPageTitle = function (title) {
    if (!Polimapper.embedded) {
      document.title = title;
    }
    addthis_share.title = title;
  };

  Polimapper.setOGImage = function () {
    if (!Polimapper.embedded) {
      $('meta[property=og\\:image]').attr('content', Polimapper.data.logo);
    }
  };

  Polimapper.displayNodeFromUrl = function () {
    if (window.location.hash && window.location.hash.split('=')[1]) {

      var cons = decodeURIComponent(window.location.hash.split('=')[1]);

      var path = $("path[data-name='" + cons + "']").get(0);

      if (path) {
        Polimapper.drawNode(path);
      }
    }
  };

  Polimapper.insertDesktopLayout = function () {
    var template = Polimapper.templates['src/templates/desktopLayout.handlebars'];
    var context = { resourcePrefix: (Polimapper.resourcePrefix || '') };
    var html = template(context);
    if (Polimapper.container) {
      $('#' + Polimapper.container).prepend(html);
    } else {
      $('.polimapper-desktop').prepend(html);
    }
  };

  Polimapper.insertMobileLayout = function () {
    var template = Polimapper.templates['src/templates/mobileLayout.handlebars'];

    //var template = Polimapper.templates['src/templates/desktopLayout.handlebars'];
    var context = { resourcePrefix: (Polimapper.resourcePrefix || '') };
    var html = template(context);
    if (Polimapper.container) {
      $('#' + Polimapper.container).prepend(html);
    } else {
      $('.polimapper-mobile').prepend(html);
    }
  };

  Polimapper.insertUkConstituencyMap = function (mapTemplatePath, onSuccess) {
    var mapUrl = (Polimapper.resourcePrefix || '') + 'html/' + mapTemplatePath;

    $(".svg_wrapper").load(mapUrl, onSuccess);
  };

  Polimapper.drawNode = function (path) {

    //Hide node name overlay
    // $("#cons_name_overlay").hide();

    // just incase this breaks browsers as it
    // was working before this fix for 90% of cases
    var tempPath;
    if (path.cloneNode) {
      tempPath = path.cloneNode();
    } else {
      tempPath = path;
    }

    if (($(path).parent().attr("id") == "greater-london") || ($(path).parent().attr("id") == "west-midlands")) {

      if (!(tempPath.hasClass("done"))) {
        var one = $(tempPath).attr("d").split(/z/i)[1];
        $(tempPath).attr("d", one + 'z');
        Polimapper.addClass(tempPath, "done");
      }
    }

    if (tempPath.removeAttr) {
      tempPath.removeAttr('transform');
    } else if (tempPath.removeAttribute) {
      tempPath.removeAttribute('transform');
    } else {
      tempPath = $(tempPath).clone();
      tempPath.removeAttr('transform');
    }

    $('#ov_c').empty();
    $('#ov_c').append(tempPath).html();

    $('#con_name').innerHTML = $(tempPath).attr("data-name");

    $('#rankings').empty();
    Polimapper.setPageTitle($(tempPath).attr("data-name") + '- ' + Polimapper.data.title);
    addthis_share.url = window.location.href;
    //$('#con_over svg g')[0].innerHTML = '<polygon points="' +  stp + '" />';

    Polimapper.setHashParam('con_over', $(tempPath).data("name"));
    $('#con_over').show();
    $('.closes').show();
    $('.app_wrapper').addClass('constituency-view');
    $('.constituency-view #data, .constituency-view .map').removeClass('col-md-6');
    $('.constituency-view #data').addClass('col-md-8');
    $('.constituency-view .map').addClass('col-md-4');
    $('.results').css(
      {
        "background": Polimapper.data.primaryColour
      }
    );

    /*if (Polimapper.isMobile()) {
      Polimapper.loadNodeDataMobile($(tempPath).data("name"));
    } else {
      Polimapper.loadNodeData($(tempPath).data("name"));
    }*/
    Polimapper.loadNodeData($(tempPath).data("name"));
    var x = Math.floor(tempPath.getBBox().x) * -1;
    var y = Math.floor(tempPath.getBBox().y) * -1;

    var path_h = tempPath.getBBox().height;
    var path_w = tempPath.getBBox().width;

    var mapEl = $('.map');

    if (mapEl.length) {
      var svg_h = $('.map')[0].clientHeight * 0.45;
      var svg_w = $('.map')[0].clientWidth * 0.9;

      var scale_x = svg_h / path_h;
      var scale_y = svg_w / path_w;

      var scale = Math.min(scale_x, scale_y);

      var offset = (svg_w - (path_w * scale)) / 2 / scale;

      x = x + offset;

      $('#ov_c').attr("transform", "scale(" + (scale || 0) + ") translate(" + (x || 0) + " " + (y || 0) + ")");
    }
  };

  function isIE() {
    return navigator.appName == 'Microsoft Internet Explorer' ||
      (navigator.appName === 'Netscape' && new RegExp('Trident/.*rv:([0-9]{1,}[\.0-9]{0,})').exec(navigator.userAgent) !== null);
  }

  Polimapper.paintMap = function (dataField, dataColumn) {
    if (dataColumn) {
      dataColumn = String(dataColumn);
      var field = Polimapper.arrayLookup(Polimapper.data.dataFields, "name", dataField);
      var column = Polimapper.arrayLookup(field.columns, "name", dataColumn);

      // if (!Polimapper.isMobile()) {
      //   if (field.columns.length > 1) {
      //     $('#c_field')[0].innerHTML = (column && (column.label + ' - ' + field.name || column.name)) || 'No data available';
      //   }
      //   else {
      //     $('#c_field')[0].innerHTML = (column && (column.label || column.name)) || 'No data available';
      //   }
      // }


      if (field.type === 'Text') {
        Polimapper.textGrouping(dataField, dataColumn);
      } else {
        if (field.groupingMethod) {
          switch (field.groupingMethod) {
            case "Percentiles":
              Polimapper.percentilesGrouping(dataField, dataColumn);
              break;
            case "EqualRanges":
              Polimapper.equalRangesGrouping(dataField, dataColumn);
              break;
            default:
              Polimapper.equalRangesGrouping(dataField, dataColumn);
              break;
          }
        } else {
          Polimapper.equalRangesGrouping(dataColumn);
        }
      }

      Polimapper.maindata = $('#data .results').html();
    } else {
      // $('#c_field')[0].innerHTML = 'No data available';
    }
  };

  Polimapper.setColors = function (dataset) {

    var css = '<style type="text/css">.fi {fill: ' + dataset.keyColour1 + '; }';
    css = css + '.se {fill: ' + dataset.keyColour2 + '; }';
    css = css + '.th {fill: ' + dataset.keyColour3 + '; }';
    css = css + '.fo {fill: ' + dataset.keyColour4 + '; }';

    $(document.body).prepend($(css));

    //var barHeight = 30;
    var barHeight = 20;
    if (Polimapper.isMobile()) {
      barHeight = 19;
    }
    // for (var i = 1; i <= Polimapper.data.numberOfKeyColours + 1; i++) {

    //   if (i == 1) {
    //     $('.map-key').append('<div class="map-val"><div class="bar" style="height:' + barHeight + 'px !important; background:' + dataset["keyColour" + (i)] + '"></div><span id="q' + i + '" class="pretty-number"></span></div>');
    //   }
    //   else if (i == Polimapper.data.numberOfKeyColours + 1) {
    //     $('.map-key').append('<div class="map-val"><div class="bar" style="margin-top:7px;height:' + barHeight + 'px !important; background:#dadada;"></div><span id="q' + i + '" class="pretty-number"></span></div>');
    //   }
    //   else {
    //     $('.map-key').append('<div class="map-val"><div class="bar" style="float:;margin-top:7px;height:' + barHeight + 'px !important; background:' + dataset["keyColour" + (i)] + '"></div><span id="q' + i + '" class="pretty-number"></span></div>');
    //   }

    // }

    css = '<style id="defaultcolor" type="text/css">';
    /* var legend = '.legend .bar {height:' + (Polimapper.data.numberOfKeyColours * barHeight + barHeight) + 'px !important; background:  linear-gradient(0deg, #dadada 0%, #dadada ';*/
    /*var legend = '.legend .bar {height:' + (barHeight) + 'px !important; background:  linear-gradient(0deg, #dadada 0%, #dadada ';*/
    var increment = 100 / (Polimapper.data.numberOfKeyColours + 1);

    // for (i = Polimapper.data.numberOfKeyColours; i > 0; i--) {
    //   css = css + '.keyColour' + (i) + '{fill: ' + dataset["keyColour" + (i)] + '; }';

    //   /*if (i === Polimapper.data.numberOfKeyColours) {
    //     legend = legend + (100 - i * increment) + '%, ' + dataset["keyColour" + (i)] + ' ' + (100 - i * increment) + '%, ' + dataset["keyColour" + (i)] + ' ';
    //   } else {
    //     legend = legend + (100 - i * increment) + '%, ' + dataset["keyColour" + (i)] + ' ' + (100 - i * increment) + '%, ' + dataset["keyColour" + (i)] + ' ';
    //   }*/
    // }

    //node color
    let dataFieldsArray = Polimapper.data.dataFields;
    var resultArray = _.filter(Polimapper.orderDatafields(Polimapper.data.dataFields), function (t) {
      return t.comparable;
    });
    // const resultArray = dataFieldsArray[0];
    var colorCount = resultArray[0].keyColors.length;
    for (var i = 0; i < colorCount; i++) {

      css = css + '.keyColour' + (i + 1) + '{fill: ' + resultArray[0].keyColors[i].keyColor + '; }';
    }

    css = css + '100%);}</style>';
    //css = css + legend + '100%);}</style>';
    $(document.body).prepend($(css));
    return false;
  };


})(Polimapper.$ || window.$, Polimapper._ || window._);

if (!window.Polimapper) Polimapper = {};

(function($, _) {

 
  Polimapper.equalRangesGrouping = function (datafield, dataColumn) {

 
    var field = Polimapper.arrayLookup(Polimapper.data.dataFields, "name", datafield);
    var column = Polimapper.arrayLookup(field.columns, "name", dataColumn);
    var nodes = Polimapper.data.nodes;
    var filteredNodes = [];

    for (var i = 0, iLen = nodes.length; i < iLen; i++) {
      var val = nodes[i].columnValue(datafield, column.name);
      filteredNodes = filteredNodes.concat(val && val.toLowerCase().trim());
    }

    var uniqueValues = _.uniq(_.without(filteredNodes, '', null));

    var ocurrences = {};

    var countBy = function (c) {
      var val = c.columnValue(datafield, dataColumn);
      return val && val.toLowerCase() === uniqueValues[j];
    };

    for (var j = 0, jLen = uniqueValues.length; j < jLen; j++) {
      var x = _.countBy(nodes, countBy);

      ocurrences[uniqueValues[j]] = x.true;
    }

    var ocurrencesArray = [];

    Object.keys(ocurrences).forEach(function(key) {
      ocurrencesArray.push({ label: key, count: ocurrences[key] });
    });

    var order = _.sortBy(ocurrencesArray, "count").reverse();

    $('.lt').empty().text('');
    // $('#q1').empty().html((order[0] && order[0].label) || '&nbsp;');
    // $('#q2').empty().html((order[1] && order[1].label) || '&nbsp;');
    // $('#q3').empty().html((order[2] && order[2].label) || '&nbsp;');
    // $('#q4').empty().html((order[3] && order[3].label) || '&nbsp;');
    $('#q' + (uniqueValues.length + 1)).empty().html('unknown');

    for (var k = 0, len = nodes.length; k < len; k++) {
      //var path = $('#' + nodes[i].id).get(0);

      var paths = $("path[data-name='" + nodes[k].name + "']");
   
      for (var pathIndex = 0; pathIndex < paths.length; pathIndex++) {
        var path = paths[pathIndex];

        var value = nodes[k].columnValue(datafield, dataColumn);
        value = value && value.toLowerCase();
        if (path) {
         
          Polimapper.removeClass(path, "null");
          Polimapper.removeClass(path, "keyColour1");
          Polimapper.removeClass(path, "keyColour2");
          Polimapper.removeClass(path, "keyColour3");
          Polimapper.removeClass(path, "keyColour4");
          Polimapper.removeClass(path, "keyColour5");
          Polimapper.removeClass(path, "keyColour6");
          Polimapper.removeClass(path, "keyColour7");
          Polimapper.removeClass(path, "keyColour8");
          Polimapper.removeClass(path, "keyColour9");
          Polimapper.removeClass(path, "keyColour10");

          var numcolor = parseInt(field.keyColors[0].minKeyValue.replace("+", ""));
            if(value >= numcolor){
              Polimapper.addClass(path, "keyColour1");
            }else{
              var colorcount = field.keyColors.length;
            for(i = 1; i < colorcount; i++){
              if(value >= parseInt(field.keyColors[i].minKeyValue) && value <= parseInt(field.keyColors[i].MaxKeyValue)){
                
                Polimapper.addClass(path, "keyColour"+(i+1));
              }
       
            }

          }


          // value = value && value.toLowerCase();
          // if (order[0] && order[0].label === value) {
          //   Polimapper.addClass(path, "keyColour1");
          // } else if (order[1] && order[1].label === value) {
          //   Polimapper.addClass(path, "keyColour2");
          // } else if (order[2] && order[2].label === value) {
          //   Polimapper.addClass(path, "keyColour3");
          // } else if (order[3] && order[3].label === value) {
          //   Polimapper.addClass(path, "keyColour4");
          // } else {
          //   Polimapper.addClass(path, "null");
          // }
        }
      }
    }
  };

  Polimapper.percentilesGrouping = function (datafield, dataColumn) {
   

    var field = Polimapper.arrayLookup(Polimapper.data.dataFields, "name", datafield);
    var column = Polimapper.arrayLookup(field.columns, "name", dataColumn);
    var nodes = Polimapper.data.nodes;
    var filteredNodes = [];

    for (var i = 0, iLen = nodes.length; i < iLen; i++) {
      var val = nodes[i].columnValue(datafield, column.name);
      filteredNodes = filteredNodes.concat(val && val.toLowerCase().trim());
    }

    var uniqueValues = _.uniq(_.without(filteredNodes, '', null));

    var ocurrences = {};

    var countBy = function (c) {
      var val = c.columnValue(datafield, dataColumn);
      return val && val.toLowerCase() === uniqueValues[j];
    };

    for (var j = 0, jLen = uniqueValues.length; j < jLen; j++) {
      var x = _.countBy(nodes, countBy);

      ocurrences[uniqueValues[j]] = x.true;
    }

    var ocurrencesArray = [];

    Object.keys(ocurrences).forEach(function(key) {
      ocurrencesArray.push({ label: key, count: ocurrences[key] });
    });

    var order = _.sortBy(ocurrencesArray, "count").reverse();

    $('.lt').empty().text('');
    // $('#q1').empty().html((order[0] && order[0].label) || '&nbsp;');
    // $('#q2').empty().html((order[1] && order[1].label) || '&nbsp;');
    // $('#q3').empty().html((order[2] && order[2].label) || '&nbsp;');
    // $('#q4').empty().html((order[3] && order[3].label) || '&nbsp;');
    $('#q' + (uniqueValues.length + 1)).empty().html('unknown');

    for (var k = 0, len = nodes.length; k < len; k++) {
      //var path = $('#' + nodes[i].id).get(0);

      var paths = $("path[data-name='" + nodes[k].name + "']");
   
      for (var pathIndex = 0; pathIndex < paths.length; pathIndex++) {
        var path = paths[pathIndex];

        var value = nodes[k].columnValue(datafield, dataColumn);
        value = value && value.toLowerCase();
        if (path) {
         
          Polimapper.removeClass(path, "null");
          Polimapper.removeClass(path, "keyColour1");
          Polimapper.removeClass(path, "keyColour2");
          Polimapper.removeClass(path, "keyColour3");
          Polimapper.removeClass(path, "keyColour4");
          Polimapper.removeClass(path, "keyColour5");
          Polimapper.removeClass(path, "keyColour6");
          Polimapper.removeClass(path, "keyColour7");
          Polimapper.removeClass(path, "keyColour8");
          Polimapper.removeClass(path, "keyColour9");
          Polimapper.removeClass(path, "keyColour10");

          var numcolor = parseInt(field.keyColors[0].minKeyValue.replace("+", ""));
            if(value >= numcolor){
              Polimapper.addClass(path, "keyColour1");
            }else{
              var colorcount = field.keyColors.length;
            for(i = 1; i < colorcount; i++){
              if(value >= parseInt(field.keyColors[i].minKeyValue) && value <= parseInt(field.keyColors[i].MaxKeyValue)){
                Polimapper.addClass(path, "keyColour"+(i+1));
              }
            }

          }


          // value = value && value.toLowerCase();
          // if (order[0] && order[0].label === value) {
          //   Polimapper.addClass(path, "keyColour1");
          // } else if (order[1] && order[1].label === value) {
          //   Polimapper.addClass(path, "keyColour2");
          // } else if (order[2] && order[2].label === value) {
          //   Polimapper.addClass(path, "keyColour3");
          // } else if (order[3] && order[3].label === value) {
          //   Polimapper.addClass(path, "keyColour4");
          // } else {
          //   Polimapper.addClass(path, "null");
          // }
        }
      }
    }
  };

  Polimapper.textGrouping = function (datafield, dataColumn) {

    var field = Polimapper.arrayLookup(Polimapper.data.dataFields, "name", datafield);
    var column = Polimapper.arrayLookup(field.columns, "name", dataColumn);
    var nodes = Polimapper.data.nodes;
    var filteredNodes = [];

    for (var i = 0, iLen = nodes.length; i < iLen; i++) {
      var val = nodes[i].columnValue(datafield, column.name);
      filteredNodes = filteredNodes.concat(val && val.toLowerCase().trim());
    }

    var uniqueValues = _.uniq(_.without(filteredNodes, '', null));

    var ocurrences = {};

    var countBy = function (c) {
      var val = c.columnValue(datafield, dataColumn);
      return val && val.toLowerCase() === uniqueValues[j];
    };

    for (var j = 0, jLen = uniqueValues.length; j < jLen; j++) {
      var x = _.countBy(nodes, countBy);

      ocurrences[uniqueValues[j]] = x.true;
    }

    var ocurrencesArray = [];

    Object.keys(ocurrences).forEach(function(key) {
      ocurrencesArray.push({ label: key, count: ocurrences[key] });
    });

    var order = _.sortBy(ocurrencesArray, "count").reverse();

    $('.lt').empty().text('');
    // $('#q1').empty().html((order[0] && order[0].label) || '&nbsp;');
    // $('#q2').empty().html((order[1] && order[1].label) || '&nbsp;');
    // $('#q3').empty().html((order[2] && order[2].label) || '&nbsp;');
    // $('#q4').empty().html((order[3] && order[3].label) || '&nbsp;');
    $('#q' + (uniqueValues.length + 1)).empty().html('unknown');

    for (var k = 0, len = nodes.length; k < len; k++) {
      //var path = $('#' + nodes[i].id).get(0);

      var paths = $("path[data-name='" + nodes[k].name + "']");
   
      for (var pathIndex = 0; pathIndex < paths.length; pathIndex++) {
        var path = paths[pathIndex];

        var value = nodes[k].columnValue(datafield, dataColumn);
        value = value && value.toLowerCase();
        if (path) {
         
          Polimapper.removeClass(path, "null");
          Polimapper.removeClass(path, "keyColour1");
          Polimapper.removeClass(path, "keyColour2");
          Polimapper.removeClass(path, "keyColour3");
          Polimapper.removeClass(path, "keyColour4");
          Polimapper.removeClass(path, "keyColour5");
          Polimapper.removeClass(path, "keyColour6");
          Polimapper.removeClass(path, "keyColour7");
          Polimapper.removeClass(path, "keyColour8");
          Polimapper.removeClass(path, "keyColour9");
          Polimapper.removeClass(path, "keyColour10");

          var numcolor = parseInt(field.keyColors[0].minKeyValue.replace("+", ""));
            if(value >= numcolor){
              Polimapper.addClass(path, "keyColour1");
            }else{
              var colorcount = field.keyColors.length;
            for(i = 1; i < colorcount; i++){
              if(value >= parseInt(field.keyColors[i].minKeyValue) && value <= parseInt(field.keyColors[i].MaxKeyValue)){
                
                Polimapper.addClass(path, "keyColour"+(i+1));
              }
            
            }

          }


          // value = value && value.toLowerCase();
          // if (order[0] && order[0].label === value) {
          //   Polimapper.addClass(path, "keyColour1");
          // } else if (order[1] && order[1].label === value) {
          //   Polimapper.addClass(path, "keyColour2");
          // } else if (order[2] && order[2].label === value) {
          //   Polimapper.addClass(path, "keyColour3");
          // } else if (order[3] && order[3].label === value) {
          //   Polimapper.addClass(path, "keyColour4");
          // } else {
          //   Polimapper.addClass(path, "null");
          // }
        }
      }
    }
  };

  Polimapper.prettyPrintNumber = function (number) {
 
		var numberString;
		var scale = '';
		if (isNaN(number) || !isFinite(number)) {
			numberString = 'N/A';
		} else {
			var absVal = number;

			if (absVal < 1000) {
				scale = '';
			} else if (absVal < 1000000) {
				scale = 'K';
				absVal = absVal / 1000;

			} else if (absVal < 1000000000) {
				scale = 'M';
				absVal = absVal / 1000000;

			} else if (absVal < 1000000000000) {
				scale = 'B';
				absVal = absVal / 1000000000;

			} else if (absVal < 1000000000000000) {
				scale = 'T';
				absVal = absVal / 1000000000000;
			}

			var maxDecimals = 0;
			if (scale === '') {
				maxDecimals = 3;
			}
			numberString = parseFloat(absVal.toFixed(maxDecimals));
			numberString += scale;
		}
		return numberString;
	};

    Polimapper.prettyPrintNumberDecimal = function (number) {
  
		var numberString;
		var scale = '';
		if (isNaN(number) || !isFinite(number)) {
			numberString = 'N/A';
		} else {
			var absVal = parseFloat(number);

			if (absVal < 1000) {
				scale = '';
			} else if (absVal < 1000000) {
				scale = 'K';
				absVal = absVal / 1000;

			} else if (absVal < 1000000000) {
				scale = 'M';
				absVal = absVal / 1000000;

			} else if (absVal < 1000000000000) {
				scale = 'B';
				absVal = absVal / 1000000000;

			} else if (absVal < 1000000000000000) {
				scale = 'T';
				absVal = absVal / 1000000000000;
			}

			var maxDecimals = 1;
			if (scale === '') {
				maxDecimals = 3;
			}
			numberString = parseFloat(absVal.toFixed(maxDecimals));
			numberString += scale;
		}
		return numberString;
	};

  function formatLowerAndUpper(lower, upper) {
    return Polimapper.prettyPrintNumber(lower) + ' to < ' + Polimapper.prettyPrintNumber(upper);
  }

  function formatLowerAndUpperDecimal(lower, upper) {
    return Polimapper.prettyPrintNumberDecimal(lower) + ' to < ' + Polimapper.prettyPrintNumberDecimal(upper);
  }

  function getDecimalPlaces(numString) {
    return (numString.split('.')[1] || []).length;
  }



  // taking the upper bound of a percentile and the
  // lowest value of the next percentile,
  // figure out what the lower bound of the next
  // percentile should be.
  function getNextLowerIncrease(percentileUpperBound, nextPercentileLowestValue) {

    // we need to block against adding an amount to
    // the upper bound of a percentile which means the
    // lower bound of the next percentile leaves values
    // outside of the bounds of either percentile.
    // e.g.
    // values: [ 1, 2, 2.003, 4 ]
    //
    // here we expect to see each value in a
    // percentile of it's own
    //
    // percentile cut offs, and thus upper bounds: 1, 2, 3
    //
    // but,
    // if we have a single digit whole number for the
    // cut off of the second percentile we'll add 0.1 to get
    // the lower bound for the next value and end up with:
    //
    // 3.1 - 4
    // 2.1 - 3
    // 1.1 - 2
    // 0 - 1
    //
    // the third value should go in the third percentile,
    // but ends up outside of the bounds of either.
    //
    // thus in that case we set the lower bound of the
    // next quartile to the lowest value in that quartile.
    // Better still, we want to take that value and round
    // down to the 1 in that significant digit
    // (i.e. 0.003 => 0.001)
    //
    // a percentile cut off of 7.56 with a lowest value
    // in the next percentile of 7.563 should then
    // result in a lower bound of 7.561
    //

    if (isNaN(percentileUpperBound) || !isFinite(percentileUpperBound)) {
			return 1;
		} else {
			var increase = 1;

      var numberDecimals = getDecimalPlaces(percentileUpperBound.toString());
      if (percentileUpperBound < 1000) {
        switch (numberDecimals) {
          case 0:
            increase = 1;
            break;
          case 1:
            increase = 0.1;
            break;
          case 2:
            increase = 0.01;
            break;
          case 3:
            increase = 0.001;
            break;
          case 4:
            increase = 0.0001;
            break;
          default:
            increase = 1;
            break;
        }
			} else if (percentileUpperBound < 1000000) {
				increase = increase / 1000;

			} else if (percentileUpperBound < 1000000000) {
				increase = increase / 1000000;

			} else if (percentileUpperBound < 1000000000000) {
				increase = increase / 1000000000;

			} else if (percentileUpperBound < 1000000000000000) {
				increase = increase / 1000000000000;
			}

      if (increase > nextPercentileLowestValue) {
        return nextPercentileLowestValue;
      }

      return increase;
		}
  }
})(Polimapper.$ || window.$, Polimapper._ || window._);

if (!window.Polimapper) Polimapper = {};

(function($, _) {
  Polimapper.FieldData = function(name, columns) {
    this.name = name;
    this.columns = columns;
  };

  Polimapper.ColumnData = function(field, name, value) {
    this.field = field;
    this.name = name;
    this.value = value;
  };

  Polimapper.Node = function(apiNode) {
    var _this = this;
    var node = apiNode;

    this.name = node.name;

    var fields = [];
    var columns = [];
    _.keys(node.data).forEach(function(fieldKey) {
      var dataField = node.data[fieldKey];
      var fieldColumns = [];
      var field = new Polimapper.FieldData(fieldKey, fieldColumns);
      _.keys(dataField).forEach(function(columnKey) {
        var columnValue = dataField[columnKey];
        var column = new Polimapper.ColumnData(field, columnKey, columnValue);
        fieldColumns.push(column);
        columns.push(column);
      });
      fields.push(field);
    });

    this.column = function(dataFieldName, dataColumnName) {
      return _.find(columns, function(column) {
        return column.field.name === dataFieldName && column.name === dataColumnName;
      });
    };

    this.columnValue = function(dataFieldName, dataColumnName) {
      var column = _this.column(dataFieldName, dataColumnName);
      if (!column) return null;
      return column.value;
    };

    this.field = function(dataFieldName) {
      return _.findWhere(fields, { name: dataFieldName });
    };

    this.columns = function() {
      return columns;
    };

    this.fields = function() {
      return fields;
    };

    this.forEachColumn = function(toRun) {
      columns.forEach(toRun);
    };

    this.forEachField = function(toRun) {
      fields.forEach(toRun);
    };
  };
})(Polimapper.$ || window.$, Polimapper._ || window._);

(function ($) {

	/**
	** Defines method lookup for specific element types.
	**/
	var elementMethods = {
		'DIV': function ($element) {
			handleTextElement($element);
		},
		'SPAN': function ($element) {
			handleTextElement($element);
		},
		'A': function ($element) {
			handleTextElement($element);
		}
	};

	/**
	** Handles any html element that has a text node.
	**/
	function handleTextElement($element) {
		var number = $element.text();
		setElementAttributes($element, number, function (prettyNumber) {
			if (prettyNumber) {
				$element.text(prettyNumber);
			}
		});
	}

	/**
	** Sets element attributes before invoking the callback to set the pretty number.
	** In an effort to not destroy any existing numbers, we create a data-pretty-number
	** attribute with the original number and create a title that can display the
	** original value when the element is hovered.
	**/
	function setElementAttributes($element, number, callback) {
		var prettyNumber;
		if (number && number.length > 0 && !isNaN(number) && !$element.data('pretty-number')) {
			prettyNumber = Polimapper.prettyPrintNumberDecimal(number);
			$element.attr('data-pretty-number', number);
			$element.attr('title', number);
		}
		if (callback) {
			callback(prettyNumber);
		}
	}

	/**
	** The pretty number formatting method extending jquery.
	** Elements modifiable by prettyNumber include: div, span, a
	**/
	$.fn.prettyNumber = function () {
		return this.each(function () {
			var $this = $(this);
			if (elementMethods[this.tagName]) {
				elementMethods[this.tagName]($this);
			}
		});
	};

})(Polimapper.$ || window.$);

if (!window.Polimapper) Polimapper = {};

(function($, _, Chart) {
  Polimapper.mobileSummaryData = function () {

    var orderedDatafields = Polimapper.orderDatafields(Polimapper.data.dataFields);
    Polimapper.setPageTitle(Polimapper.data.title);

    $('#data .totals .result').remove();

    for (var i = 0; i < orderedDatafields.length; i++) {
      var dataField = orderedDatafields[i];
      var key = dataField.name;
      var label = dataField.columns[0].label ? dataField.columns[0].label : dataField.name;

      if (dataField.showAverageInDataSetSummary || dataField.showTotalInDataSetSummary) {

      //CHANGED THE WAY THE LOOP WORKS SO WE CAN REORDER THE DATAFIELDS
      //}
      //for (var key in node.data) {

      //CHANGED THE WAY THE LOOP WORKS SO WE CAN REORDER THE DATAFIELDS
      //var dataField = Polimapper.arrayLookup (Polimapper.data.dataFields, "name", key);

        dataField.average = dataField.average || 0;
        dataField.totalValue = dataField.totalValue || 0;

        var currency = "";
        var average = dataField.averageOverride ? dataField.averageOverride : dataField.average.toFixed(2);
        var total = dataField.totalValue.toFixed(2);
        var legend = '';
        var description = null;
        var html = "";
        var context = null;
        var ctx = null;
        var myBarChart = null;

        switch (dataField.type) {
          case "Pound":
          case "Euro":
          case "Dollar":
          case "Decimal":
          case "Number":
          case "Percentage":

            var template;
            var number = parseFloat(total);

            if (dataField.type === 'Pound') {
              currency = "&#163; ";
            }

            if (dataField.type === 'Dollar') {
              currency = "&#36; ";
            }

            if (dataField.type === 'Euro') {
              currency = "&#128; ";
            }

            /* jshint ignore:start */
            dataField.columns.reverse().forEach(function(columnDefinition, i) {
              var maxNumbers = "";
              var minNumbers = "";
              var avgNumbers = "";
              var columnKeys = "";
              var totalValues = 0;
              var icons = '';

              columnKeys = columnKeys + ',' + columnDefinition.label;
              maxNumbers = maxNumbers + ',' + columnDefinition.maxValue;
              minNumbers = minNumbers + ',' + columnDefinition.minValue;
              columnDefinition.average = columnDefinition.average || 0;
              columnDefinition.totalValue = columnDefinition.totalValue || 0;
              avgNumbers = avgNumbers + ',' + (columnDefinition.averageOverride ? columnDefinition.averageOverride.toFixed(2) : columnDefinition.average.toFixed(2));
              icons = icons + ',' + columnDefinition.icon;

              if (i === dataField.columns.length - 1){
                totalValues += columnDefinition.totalValue;
              }
              // do stuff


              maxNumbers = Polimapper.parseValueStrings(maxNumbers);
              minNumbers = Polimapper.parseValueStrings(minNumbers);
              avgNumbers = Polimapper.parseValueStrings(avgNumbers);
              columnKeys = Polimapper.parseValueStrings(columnKeys);
              icons = Polimapper.parseValueStrings(icons);

            // create legend

            if(!dataField.excludeMinFromDataSetSummaryGraph) {
              legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour4 + ';"></span> Min</div>';
            }
            if(!dataField.excludeAverageFromDataSetSummaryGraph) {
              legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour3 + ';"></span> Avg</div>';
            }
            if(!dataField.excludeMaxFromDataSetSummaryGraph) {
              legend += '<div class="legend-item"><span style="background-color:' + Polimapper.data.keyColour1 + ';"></span> Max</div>';
            }

            if (!dataField.isMultivalued) {
              columnKeys[0] = '';
            }
            else {
              number = parseFloat(totalValues.toFixed(2));
            }

            if(!dataField.showTotalInDataSetSummary) {
              number = '';
            }

            if(!dataField.showAverageInDataSetSummary) {
              legend = null;
              escapedName = null;
              description = null;
            }
            else {
              description = dataField.description;
            }

            if (icons === '') {
              icons = [];
            }

            var minDataset = {
                fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour4, 20),
                highlightFill: Polimapper.data.keyColour4,
                data: minNumbers,
              };

            var avgDataset = {
              fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour3, 20),
              highlightFill: Polimapper.data.keyColour3,
              data: avgNumbers,
            };

            var maxDataset = {
              fillColor: Polimapper.hexToRgba(Polimapper.data.keyColour1, 20),
              highlightFill: Polimapper.data.keyColour1,
              data: maxNumbers,
            };

            var summaryDatasets = [];

            if(!dataField.excludeMinFromDataSetSummaryGraph) {
              summaryDatasets.push(minDataset);
            }
            if(!dataField.excludeAverageFromDataSetSummaryGraph) {
              summaryDatasets.push(avgDataset);
            }
            if(!dataField.excludeMaxFromDataSetSummaryGraph) {
              summaryDatasets.push(maxDataset);
            }

            if(dataField.showAverageInDataSetSummary) {

              var data = {
                labels: columnKeys,
                datasets: summaryDatasets
              };

              if (dataField.type === "Percentage") {
                template = Polimapper.templates['src/templates/percentageMobile.handlebars'];
              } else {
                template = Polimapper.templates['src/templates/mobileNumber.handlebars'];
              }

              var graphBarWrapper = 200;

              var refMax;
              if (dataField.type === 'Percentage') {
                refMax = 100;
              } else {
                refMax = getRefMax(maxNumbers);
              }

              var setGraphBarWitdhMax = {
                refMax: refMax,
                getBarWidth: (maxNumbers * graphBarWrapper) / refMax,
              };
              var setGraphBarWitdhAvg = {
                refMax: refMax,
                getBarWidth: (avgNumbers * graphBarWrapper) / refMax,
              };
              var setGraphBarWitdhMin = {
                refMax: refMax,
                getBarWidth: (minNumbers * graphBarWrapper) / refMax,
              };

              context = {
                name: dataField.name,
                value: number,
                currency: Polimapper.decodeHtml(currency),
                icons: icons.reverse(),
                escapedName: Polimapper.toSlug(dataField.name),
                bigNumber: avgDataset.data > 10000 ? true : false,
                multivalued: dataField.isMultivalued,
                firstColumn: i === 0,
                lastColumn: i === dataField.columns.length - 1,
                label: columnDefinition.label,
                description: description,
                total: dataField.showTotalInDataSetSummary,
                legend: legend !== '',
                legendHtml: legend,
                showGraph: dataField.showAverageInDataSetSummary,
                showMin: !dataField.excludeMinFromDataSetSummaryGraph,
                showAvg: !dataField.excludeAverageFromDataSetSummaryGraph,
                showMax: !dataField.excludeMaximumFromDataSetSummaryGraph,
                minDataset: minDataset,
                avgDataset: avgDataset,
                maxDataset: maxDataset,
                setGraphBarWitdhMax: setGraphBarWitdhMax,
                setGraphBarWitdhAvg: setGraphBarWitdhAvg,
                setGraphBarWitdhMin: setGraphBarWitdhMin
              };

              html = html + template(context);

              if(!dataField.isMultivalued) {
                var totals = $('#data .totals').append(html);

                var option1 = $('.option-1', totals).last();
                var option2 = $('.option-2', totals).last();

                if (dataField.type === 'Percentage') {
                  option2 = [];
                } else {
                  option1 = [];
                }

                setupAnimationsForSummary(option1, option2, setGraphBarWitdhMax, setGraphBarWitdhAvg, setGraphBarWitdhMin);
              }
            }

          });

          if(dataField.isMultivalued) {
            $('#data .totals').append(html);
            $('.charts.'+Polimapper.toSlug(dataField.name)).slick({
                dots: true,
                arrows: true
            });
          }

          /* jshint ignore:end */

            //Pretify number
            $('.pretty-number').removeAttr("data-pretty-number");
            $('.pretty-number').prettyNumber();

            break;
          case "Percentage":
            if(dataField.showAverageInDataSetSummary || dataField.showTotalInDataSetSummary) {

              if (!dataField.isMultivalued) {
                var handlebarsTemplate = Polimapper.templates['src/templates/percentageMobile.handlebars'];
                var templateContext = {
                  name: dataField.name,
                  value: average,
                  icon: dataField.icon,
                  escapedName: Polimapper.toSlug(dataField.name),
                  label: label,
                  description: dataField.description,
                  showGraph: dataField.showAverageInDataSetSummary ,
                  showMin: !dataField.excludeMinFromDataSetSummaryGraph,
                  showAvg: !dataField.excludeAverageFromDataSetSummaryGraph,
                  showMax: !dataField.excludeMaximumFromDataSetSummaryGraph,
                  //minDataset: minDataset,
                  //avgDataset: avgDataset,
                  //maxDataset: maxDataset,
                };
                var templateOutput = handlebarsTemplate(templateContext);

                $('#data .totals').append(templateOutput);

                var d = [
                  {
                    value: average,
                    color: Polimapper.data.keyColour1,
                    highlight: "#FF5A5E",
                    label: "Average"
                  },
                  {
                    value: 100 - average,
                    color: "#f1f1f1",
                    highlight: "#f1f1f1",
                    label: ""
                  },

                ];


              }
              else {
                Polimapper.drawMultivalueSummaryBarChart(dataField, key, label);
              }
            }

            break;
          }
      }
    }
  };

  function setupAnimationsForSummary(option1, option2, setGraphBarWitdhMax, setGraphBarWitdhAvg, setGraphBarWitdhMin) {
    var body = document.body;
    var windowHeight = window.innerHeight;

    function option1OnScrollAction(chartWrapper) {
      $('.chart-value.max', chartWrapper).animate({width: setGraphBarWitdhMax.getBarWidth});
      $('.chart-value.avg', chartWrapper).animate({width: setGraphBarWitdhAvg.getBarWidth});
      $('.chart-value.min', chartWrapper).animate({width: setGraphBarWitdhMin.getBarWidth});
    }

    function option2OnScrollAction(chartWrapper) {
      $('.chart-value.max', chartWrapper).animate({height: setGraphBarWitdhMax.getBarWidth});
      $('.chart-value.avg', chartWrapper).animate({height: setGraphBarWitdhAvg.getBarWidth});
      $('.chart-value.min', chartWrapper).animate({height: setGraphBarWitdhMin.getBarWidth});
    }

    if (option1.length > 0) {
      var option1ChartWrapper = option1[0];
      var option1ClientRectBottom = option1ChartWrapper.getBoundingClientRect().bottom;


      // animate graphs that are visible on page load
      if (option1ClientRectBottom < windowHeight) {
        option1OnScrollAction(option1ChartWrapper);
      } else {
        showChartOnScroll(option1ChartWrapper, option1OnScrollAction);
      }
    }

    if (option2.length > 0) {

      var option2ChartWrapper = option2[0];
      var option2ClientRectBottom = option2ChartWrapper.getBoundingClientRect().bottom;

      // animate graphs that are visible on page load
      if (option2ClientRectBottom < windowHeight) {
        option2OnScrollAction(option2ChartWrapper);
      } else {
        showChartOnScroll(option2ChartWrapper, option2OnScrollAction);
      }
    }
  }

  function setupAnimationsForNode(chartWrapper, setGraphBarWitdhAvg, setGraphBarWitdhNodeValue) {
    var body = document.body;
    var windowHeight = window.innerHeight;

    function onScrollAction(chartWrapper) {
      $('.chart-value.avg', chartWrapper).animate({height: setGraphBarWitdhAvg.getBarWidth});
      $('.chart-value.node', chartWrapper).animate({height: setGraphBarWitdhNodeValue.getBarWidth});
    }

    chartWrapper = chartWrapper[0];
    var clientRectBottom = chartWrapper.getBoundingClientRect().bottom;

    // animate graphs that are visible on page load
    if (clientRectBottom < windowHeight) {
      onScrollAction(chartWrapper);
    } else {
      showChartOnScroll(chartWrapper, onScrollAction);
    }
  }

  function setupAnimationsForNodeWidth(chartWrapper, setGraphBarWitdhAvg, setGraphBarWitdhNodeValue) {
    var body = document.body;
    var windowHeight = window.innerHeight;

    function onScrollAction(chartWrapper) {
      $('.chart-value.avg', chartWrapper).animate({width: setGraphBarWitdhAvg.getBarWidth});
      $('.chart-value.node', chartWrapper).animate({width: setGraphBarWitdhNodeValue.getBarWidth});
    }

    chartWrapper = chartWrapper[0];
    var clientRectBottom = chartWrapper.getBoundingClientRect().bottom;

    // animate graphs that are visible on page load
    if (clientRectBottom < windowHeight) {
      onScrollAction(chartWrapper);
    } else {
      showChartOnScroll(chartWrapper, onScrollAction);
    }
  }

  function showChartOnScroll(chartWrapper, onScrollAction) {
    var windowHeight = window.innerHeight;

    function scrollHandler() {
      var clientRectTop = chartWrapper.getBoundingClientRect().top;

      if (clientRectTop < windowHeight / 2) {
        $(document).off('scroll', scrollHandler);
        onScrollAction(chartWrapper);
      }
    }

    $(document).scroll(scrollHandler);
  }

  function getNodeColor(path) {
    var color = Polimapper.data[path.className.baseVal.trim()];

    if (!color) {
      color = '#dedede';
    }

    return color;
  }

  function getRefMax(maxNumbers, graphBarWrapper) {
    var refMax = maxNumbers.toString().split('.')[0].length;
    var maxRoundUp = 1;
    var setGraphBarWitdh = 0;
    var j;

    for (j = 1; j < refMax; j++){
      maxRoundUp = maxRoundUp * 10;
    }
    refMax = Math.ceil(maxNumbers / maxRoundUp) * maxRoundUp;
    return refMax;
  }

  Polimapper.loadNodeDataMobile = function (node) {
    var dataFields = Polimapper.data.dataFields;
    var path = $("path[data-name='" + node + "']").get(0);
    var nodeName = $(path).attr("data-name");
    var color = getNodeColor(path);

    node = Polimapper.arrayLookup(Polimapper.data.nodes, "name", node);
    Polimapper.loadRankingIcons(node);
    // if (Polimapper.data.key === '41a8db966f6446b8803d0a33094f61b1') {
    //   if (nodeName === 'South Manchester' || nodeName === 'Central Manchester' || nodeName === 'North Manchester') {
    //     $('#data').empty().html("<h2 class=\"con_name\">" + nodeName + "*</h2>");
    //     $('.con_name').css("color", Polimapper.data.primaryColour);
    //   } else {
    //     $('#data').empty().html("<h2 class=\"con_name\">" + nodeName + "</h2>");
    //     $('.con_name').css("color", Polimapper.data.primaryColour);
    //   }
    // } else {
    //   $('#data').empty().html("<h2 class=\"con_name\">" + nodeName + "</h2>");
    //   $('.con_name').css("color", Polimapper.data.primaryColour);
    // }


    var orderedDatafields = Polimapper.orderDatafields(Polimapper.data.dataFields);

    for (var i = 0; i < orderedDatafields.length; i++) {
      var dataField = orderedDatafields[i];
      var key = dataField.name;
      var label = dataField.columns[0].label ? dataField.columns[0].label : dataField.name;

      if (node.field(key)) {
        var currency = "";
        var html = "";

        /* jshint ignore:start */
        switch (dataField.type) {
          case "Pound":
          case "Euro":
          case "Dollar":
          case "Decimal":
          case "Number":
          case "Percentage":

            if (dataField.isMultivalued) {
              //Polimapper.drawMultivalueBarChartMobile(node, dataField, key, color, label);
              //continue;
            }

            var template;

            if (dataField.type === 'Pound') {
              currency = "&#163; ";
            }

            if (dataField.type === 'Dollar') {
              currency = "&#36; ";
            }

            if (dataField.type === 'Euro') {
              currency = "&#128; ";
            }

            dataField.columns.reverse().forEach(function(columnDefinition, i) {

              // this is currently assuming the field has a column with the same name
              var number = parseFloat(node.columnValue(key, key));
              var average = columnDefinition.averageOverride ? columnDefinition.averageOverride.toFixed(2) : columnDefinition.average.toFixed(2);
              var icons = "";
              var dataNumbers = "";
              var columnKeys = "";
              var totalValues = 0;
              var maxNumbers = "";
              var avgNumbers = "";

              var columnData = node.column(dataField.name, columnDefinition.name);
              columnKeys = columnKeys + ',' + columnDefinition.label;
              maxNumbers = maxNumbers + ',' + columnDefinition.maxValue;
              avgNumbers = avgNumbers + ',' + (columnDefinition.averageOverride ? columnDefinition.averageOverride.toFixed(2) : columnDefinition.average.toFixed(2));
              icons = icons + ',' + columnDefinition.icon;
              if(columnData.value) {
                dataNumbers = dataNumbers + ',' + columnData.value;
                number = parseFloat(columnData.value);
                if (i === dataField.columns.length - 1){
                  totalValues += parseFloat(columnData.value);
                }
              }
              // do stuff


            dataNumbers = Polimapper.parseValueStrings(dataNumbers);
            columnKeys = Polimapper.parseValueStrings(columnKeys);
            icons = Polimapper.parseValueStrings(icons);
            maxNumbers = Polimapper.parseValueStrings(maxNumbers);
            avgNumbers = Polimapper.parseValueStrings(avgNumbers);

            columnKeys[0] = Polimapper.data.topology.labelForSingularNode;
            icons = [dataField.columns[0].icon];

            if (icons === '') {
              icons = [];
            }

            var nodeDataset = {
              fillColor: Polimapper.hexToRgba(color, 20),
              highlightFill: color,
              data: number,
            };

            var avgDataset = {
              fillColor: 'rgba(220,220,220,.20)',
              highlightFill: 'rgba(220,220,220,1)',
              data: avgNumbers,
            };

            var graphBarWrapper = 200;
            var refMax;
            if (dataField.type === 'Percentage') {
              refMax = 100;
            } else {
              refMax = getRefMax(number > average ? number: average);
            }

            var setGraphBarWitdhNodeValue = {
              refMax: refMax,
              getBarWidth: Math.abs((number * graphBarWrapper) / refMax),
            };
            var setGraphBarWitdhAvg = {
              refMax: refMax,
              getBarWidth: Math.abs((average * graphBarWrapper) / refMax),
            };

            var context = {
              name: key,
              value: number,
              currency: Polimapper.decodeHtml(currency),
              icons: icons.reverse(),
              color: color,
              bigNumber: avgDataset.data > 100000 ? true : false,
              escapedName: Polimapper.toSlug(key),
              multivalued: dataField.isMultivalued,
              firstColumn: i === 0,
              lastColumn: i === dataField.columns.length - 1,
              label: columnDefinition.label,
              description: dataField.description,
              node: node.name,
              showGraph: true,
              showAvg: dataField.includeAverageInNodeGraphs,
              nodeDataset: nodeDataset,
              avgDataset: avgDataset,
              setGraphBarWitdhNodeValue: setGraphBarWitdhNodeValue,
              setGraphBarWitdhAvg: setGraphBarWitdhAvg,
            };

            if (dataField.type === "Percentage") {
              template = Polimapper.templates['src/templates/percentageNodeMobile.handlebars'];
            } else {
              if (number > 1000000) {
                template = Polimapper.templates['src/templates/mobileNumberNode.handlebars'];
                $('.n-value').addClass('pretty-number');
              } else if (number < 0){
                template = Polimapper.templates['src/templates/minusNumberNode.handlebars'];
                number = Polimapper.numberWithCommas(number);
              } else {
                template = Polimapper.templates['src/templates/mobileNumberNode.handlebars'];
                number = Polimapper.numberWithCommas(number);
              }
            }

            html = html + template(context);

            if(!dataField.isMultivalued) {
              var totals = $('#data .results').append(html);

              var chartWrapper = $('.node-graph', totals).last();

              if (dataField.type === 'Percentage') {
                setupAnimationsForNodeWidth(chartWrapper, setGraphBarWitdhAvg, setGraphBarWitdhNodeValue);
              } else {
                setupAnimationsForNode(chartWrapper, setGraphBarWitdhAvg, setGraphBarWitdhNodeValue);
              }


            }
          });


          if(dataField.isMultivalued) {
            $('#data .results').append(html);
            $('.charts.'+Polimapper.toSlug(dataField.name)).slick({
                dots: true,
                arrows: true
            });
          }

            $('.pretty-number').removeAttr("data-pretty-number");
            $('.pretty-number').prettyNumber();

            break;
          case "Percentage":

            if (!dataField.isMultivalued) {
              var number = node.columnValue(key, key);
              var template = Polimapper.templates['src/templates/percentageNodeMobile.handlebars'];

              var context = {
                name: key,
                value: number,
                bigNumber: avgDataset.data > 100000 ? true : false,
                icon: dataField.columns[0].icon,
                escapedName: Polimapper.toSlug(key),
                label: label,
                showGraph: true,
                description: dataField.description,
                nodeDataset: nodeDataset,
                avgDataset: avgDataset,
                setGraphBarWitdhNodeValue: setGraphBarWitdhNodeValue,
                setGraphBarWitdhAvg: setGraphBarWitdhAvg,
              };

              var html = template(context);

              $('#data .results').append(html);

              var data = [
                {
                  value: number,
                  color: color,
                  highlight: "#FF5A5E",
                  label: key
                },
                {
                  value: 100 - number,
                  color: "#f1f1f1",
                  highlight: "#f1f1f1",
                  label: ""
                },

              ];

              //document.getElementById('#' + key).getContext("2d");
              var ctx = $('#' + Polimapper.toSlug(key)).get(0).getContext("2d");
              var myDoughnutChart = new Chart(ctx).Doughnut(data, {
                animateScale: true,
                labelLength: 30,
                //responsive: true,
                segmentShowStroke: false
              });
            }
            else {
              Polimapper.drawMultivalueBarChart(node, dataField, key, color, label);
            }

            break;

          case "Hyperlink":
            var value = node.columnValue(key, key);
            if (value) {
              var template = Polimapper.templates['src/templates/link.handlebars'];
              var link = value.split(':::');
              var context = { name: key, url: link[0], text: link[1], icon: dataField.columns[0].icon, label: label };
              var html = template(context);

              $('#data .results').append(html);
            }

            break;
          case "Text":
          default:
            var value = node.columnValue(key, key);
            var template = Polimapper.templates['src/templates/text.handlebars'];
            var templateMobile = Polimapper.templates['src/templates/textMobile.handlebars'];
            var context = { name: key, value: value, icon: dataField.columns[0].icon, escapedName: Polimapper.toSlug(key), label: label };
            var html = template(context);
            var htmlMobile = templateMobile(context);

            $('#data .results').append(html);
            break;
        }
        /* jshint ignore:end */
      }
    }
  };

  Polimapper.drawMultivalueBarChartMobile = function(node, dataField, key, color, label) {

    var number = node.columnValue(key, key);
    var icons = "";
    var dataNumbers = "";
    var columnKeys = "";
    var totalValues = 0;

    dataField.columns.forEach(function(columnDefinition, i) {
      var columnData = node.column(dataField.name, columnDefinition.name);
      columnKeys = columnKeys + ',' + columnDefinition.label;
      icons = icons + ',' + columnDefinition.icon;
      if(columnData.value) {
        dataNumbers = dataNumbers + ',' + columnData.value;

        if (i === dataField.columns.length - 1){
          totalValues += parseFloat(columnData.value);
        }
      }
      // do stuff
    });

    dataNumbers = Polimapper.parseValueStrings(dataNumbers);

    columnKeys = Polimapper.parseValueStrings(columnKeys);
    icons = Polimapper.parseValueStrings(icons);
    template = Polimapper.templates['src/templates/mobileNumberNode.handlebars'];

    if (icons === '') {
      icons = [];
    }

    var context = {
      name: key,
      value: number,
      bigNumber: number > 100000 ? true : false,
      color: color,
      escapedName: Polimapper.toSlug(key),
      icons: icons.reverse(),
      multivalued: dataField.isMultivalued,
      label: label,
      description: dataField.description,
      showGraph: true
    };

    var html = template(context);

    $('#data .results').append(html);

    var data;
    if (dataField.includeAverageInNodeGraphs) {
      var averages = '';
      columnKeys = '';

      for(var k = 0; k < dataField.columns.length; k++) {
        if(dataField.averageOverride) {
          averages = averages + ',' + dataField.columns[k].averageOverride.toFixed(2);
        }
        else {
          averages = averages + ',' + dataField.columns[k].average.toFixed(2);
        }
        columnKeys = columnKeys + ',' + dataField.columns[k].name;
      }

      averages = Polimapper.parseValueStrings(averages);
      columnKeys = Polimapper.parseValueStrings(columnKeys);

      data = {
        labels: columnKeys,
        datasets: [
          {
            label: node.name,
            fillColor:  Polimapper.hexToRgba(color, 60),
            strokeColor: color,
            highlightFill: color,
            highlightStroke: color,
            pointColor:  "#ffffff",
            pointStrokeColor: color,
            pointHighlightFill: color,
            pointHighlightStroke: "#ffffff",
            data: dataNumbers
            //data: [node.data[key], dataField.average]
          },
          {
            label: "Average",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: averages
            //data: [node.data[key], dataField.average]
          }
        ]
      };
    } else {
      data = {
        labels: columnKeys,
        datasets: [
          {
            label: node.name,
            fillColor: Polimapper.hexToRgba(color, 60),
            strokeColor: color,
            highlightFill: color,
            highlightStroke: color,
            data: dataNumbers
            //data: [node.data[key], dataField.average]
          }
        ]
      };
    }

    var ctx = $('#' + Polimapper.toSlug(key)).get(0).getContext("2d");

    var myBarChart = new Chart(ctx).Bar(data, {
        //animateScale: true,
        responsive: true,
        labelLength: 4,
        // String - Template string for multiple tooltips
        showTooltips: false,
        onAnimationComplete: function () {

            var ctx = this.chart.ctx;
            ctx.font = this.scale.font;
            ctx.fillStyle = this.scale.textColor;
            ctx.textAlign = "center";
            ctx.textBaseline = "bottom";

            this.datasets.forEach(function (dataset) {
                dataset.bars.forEach(function (bar) {
                    ctx.fillText(bar.value, bar.x, bar.y + 25);
                });
            });
        }
    });
  };
})(Polimapper.$ || window.$, Polimapper._ || window._, Polimapper.Chart || window.Chart);
