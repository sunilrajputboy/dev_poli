$(document).ready(function() {

    "use strict";

    //***** VIEW-IMPORTED-NODES *****//
    // 	function viewImportedNodes(project_id,send_url){
    // 		$.ajax({
    // 			url: send_url,
    // 			data: {'project_id':project_id},
    // 			type: 'POST',
    // 			success: function(res) {
    // 			var res = jQuery.parseJSON(res);
    // 			if (res.status == 200) {
    // 				$('#AllDataViewModel').html(res.html_data);
    // 				$("#ViewNodesModal").modal('show');
    // 			}else{
    // 				//html_data
    // 			}
    // 			},
    // 			error: function() {
    // 			alert('An error has occurred');
    // 			}
    // 			});
    // 	}
    //***** VIEW-IMPORTED-NODES *****//

    //***** Progress Bar *****//
    var loaded = 0;
    var imgCounter = $("body img").length;
    if (imgCounter > 0) {
        $("body img").load(function() {
            loaded++;
            var newWidthPercentage = (loaded / imgCounter) * 100;
            console.log('ok');
            animateLoader(newWidthPercentage + '%');
        });
    } else {
        setTimeout(function() {
            $("#progressBar").css({
                "opacity": 0,
                "width": "100%"
            });
        }, 500);
    }

    function animateLoader(newWidth) {
        $("#progressBar").width(newWidth);
        if (imgCounter === loaded) {
            setTimeout(function() {
                $("#progressBar").animate({ opacity: 0 });
            }, 500);
        }
    }

    //***** Side Menu *****//
    $(".side-menus li.menu-item-has-children > a").on("click", function() {
        $(this).parent().siblings().children("ul").slideUp();
        $(this).parent().siblings().removeClass("active");
        $(this).parent().children("ul").slideToggle();
        $(this).parent().toggleClass("active");
        return false;
    });


    //***** Side Menu Option *****//
    $('.menu-options').on("click", function() {
        $(".side-header.opened-menu").toggleClass('slide-menu');
        $(".main-content").toggleClass('wide-content');
        $("footer").toggleClass('wide-footer');
        $(".menu-options").toggleClass('active');
    });

    /*** FIXED Menu APPEARS ON SCROLL DOWN ***/
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 10) {
            $(".side-header").addClass("sticky");
        } else {
            $(".side-header").removeClass("sticky");
            $(".side-header").addClass("");
        }
    });

    $(".side-menus nav > ul > li ul li > a").on("click", function() {
        $(".side-header").removeClass("slide-menu");
        $(".menu-options").removeClass("active");
    });

    //***** Quick Stats *****//
    $('.show-stats').on("click", function() {
        $(".toggle-content").addClass('active');
    });

    //***** Quick Stats *****//
    $('.toggle-content > span').on("click", function() {
        $(".toggle-content").removeClass('active');
    });

    //***** Quick Stats *****//
    $('.quick-links > ul > li > a').on("click", function() {
        $(this).parent().siblings().find('.dialouge').fadeOut();
        $(this).next('.dialouge').fadeIn();
        return false;
    });

    $("html").on("click", function() {
        $(".dialouge").fadeOut();
    });
    $(".quick-links > ul > li > a, .dialouge").on("click", function(e) {
        e.stopPropagation();
    });

    //***** Toggle Full Screen *****//
    function goFullScreen() {
        var
            el = document.documentElement,
            rfs =
            el.requestFullScreen ||
            el.webkitRequestFullScreen ||
            el.mozRequestFullScreen ||
            el.msRequestFullscreen

        ;
        rfs.call(el);
    }
    $("#toolFullScreen").on("click", function() {
        goFullScreen();
    });

    //***** Side Menu *****//
    //   $(function(){
    //       $('.side-menus').slimScroll({
    //           height: '400px',
    //           wheelStep: 10,
    //           size: '2px'
    //       });
    //   });


    //   $(".data-attributes span").peity("donut");

    // Activates Tooltips for Social Links
    $('[data-toggle="tooltip"]').tooltip();

    // Activates Popovers for Social Links 
    $('[data-toggle="popover"]').popover();


    //*** Refresh Content ***//
    $('.refresh-content').on("click", function() {
        $(this).parent().parent().addClass("loading-wait").delay(3000).queue(function(next) {
            $(this).removeClass("loading-wait");
            next();
        });
        $(this).addClass("fa-spin").delay(3000).queue(function(next) {
            $(this).removeClass("fa-spin");
            next();
        });
    });

    //*** Expand Content ***//
    $('.expand-content').on("click", function() {
        $(this).parent().parent().toggleClass("expand-this");
    });

    //*** Delete Content ***//
    $('.close-content').on("click", function() {
        $(this).parent().parent().slideUp();
    });

    // Activates Tooltips for Social Links
    $('.tooltip-social').tooltip({
        selector: "a[data-toggle=tooltip]"
    });

    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }

    $(document).ready(function() {

        function format(d) {


            var str = '';
            for (i = 0; i < d.length; i++) {
                if (d[i + 3] != undefined) {
                    str = str + '<tr><td>' + d[i + 3] + '</td><tr>';
                }

                if (i == d.length - 1) {
                    localStorage.setItem("tableData", str);
                }
            }

            var tdata = '<tr>' + localStorage.getItem("tableData") + '</tr>';

            // `d` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                tdata +
                '</table><div class="btn-rounded"><a class="btn btn-info tool" data-tip="Edit" onclick="editProjectsfieldsvalueForm(' + d[1] + ',' + d[2] + ',`' + d[0] + '`)" href="javascript:void(0)"><i class="fa green fa-edit"></i></a></div>';
        }
        var table = $('#packages').DataTable({
            "DisplayLength": 5,
            //"scrollY":        "300px",
            //  "scrollCollapse": true,
            //  "scrollX": true,
            "paging": true,
            "bSort": false,
            lengthMenu: [
                [100, 200, -1],
                [100, 200, 'All']
            ],
            responsive: true,
            "footer": false
        });
        
        //   var tableClient = $('#clientDatatable').DataTable({
        //   "DisplayLength" : 5 , 
        //     //"scrollY":        "300px",
        //     //  "scrollCollapse": true,
        //     //  "scrollX": true,
        //      "paging":         true,
        //       lengthMenu: [20, 50, 100],
        //       responsive: true,
        //     "footer":false
        //   });


        $('#table-filter').on('change', function() {
            var str = $(this).val();
            //  str = str.replace(/ +/g, "");
            // table.column(3).search(str).draw();
            if(str !== ''){
            var regex = '^\\s' + str + '\\s*$';
            table.column(3).search("(^"+str+"$)",true,false).draw();
            }else{
               table.search('').columns().search('').draw();
            }
        });
        
            $('#table-filter1').on('change', function() {
            var str = $(this).val();
            if(str !== ''){
            var regex = '^\\s' + str + '\\s*$';
            table.column(2).search("(^"+str+"$)",true,false).draw();
            }else{
               table.search('').columns().search('').draw();
            }
        });

        var table4 = $('#packages1').DataTable({
            "DisplayLength": 5,
            "paging": true,
            lengthMenu: [
                [100, 200, -1],
                [100, 200, 'All']
            ],
            responsive: true,
            "footer": false,
            "scrollY": "300px",
            "scrollCollapse": true,
        });


        var table2 = $('#constituencyNodestable').DataTable({
            "DisplayLength": 5,

            // "bLengthChange": false,
            // "scrollY":        "300px",
            lengthMenu: [
                [100, 200, -1],
                [100, 200, 'All']
            ],
            //  "scrollCollapse": true,
            //  "paging":         true,
            // "footer":false
        });

        var table3 = $('#datafieldstable').DataTable({
            "DisplayLength": 5,
            "bLengthChange": false,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": true,
            "footer": false
        });

        $('#constituencyNodestable tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table2.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        $('#datafieldstable tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table3.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        jQuery("#nav-icon").click(function() {
            jQuery(this).toggleClass("open");
            jQuery("body").toggleClass("menu-open");
        });

        jQuery(".overlay-close").click(function() {
            jQuery("#nav-icon").removeClass("open");
            jQuery("body").removeClass("menu-open");
        });


        $('#tabAll').on('click', function() {
            $('#tabAll').parent().addClass('active');
            $('.tab-pane').addClass('active');
            $('[data-toggle="tab"]').parent().removeClass('active');
        });



        $(window).on("load resize ", function() {
            var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
            $('.tbl-header').css({ 'padding-right': scrollWidth });
        }).resize();


        $('.import-tables').scroll(function() {
            $('.tbl-content').width($('.import-tables').width() + $('.import-tables').scrollLeft());
        });


        // I've added annotations to make this easier to follow along at home. Good luck learning and check out my other pens if you found this useful


        // First let's set the colors of our sliders
        const settings = {
            fill: '#e6133d',
            background: '#f1f1f1'
        }

        // First find all our sliders
        const sliders = document.querySelectorAll('.range-sliders');

        // Iterate through that list of sliders
        // ... this call goes through our array of sliders [slider1,slider2,slider3] and inserts them one-by-one into the code block below with the variable name (slider). We can then access each of wthem by calling slider
        Array.prototype.forEach.call(sliders, (slider) => {
            // Look inside our slider for our input add an event listener
            //   ... the input inside addEventListener() is looking for the input action, we could change it to something like change
            slider.querySelector('input').addEventListener('input', (event) => {
                // 1. apply our value to the span
                slider.querySelector('span').innerHTML = event.target.value;
                // 2. apply our fill to the input
                applyFill(event.target);
            });
            // Don't wait for the listener, apply it now!
            applyFill(slider.querySelector('input'));
        });

        // This function applies the fill to our sliders by using a linear gradient background
        function applyFill(slider) {
            // Let's turn our value into a percentage to figure out how far it is in between the min and max of our input
            const percentage = 100 * (slider.value - slider.min) / (slider.max - slider.min);
            // now we'll create a linear gradient that separates at the above point
            // Our background color will change here
            const bg = `linear-gradient(90deg, ${settings.fill} ${percentage}%, ${settings.background} ${percentage+0.1}%)`;
            slider.style.background = bg;
        }




    });




});;