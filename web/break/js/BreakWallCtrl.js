var breakWallAppModule = angular.module('BreakWallApp', ['ui.sortable']);

breakWallAppModule.controller('BreakWallCtrl', function BreakWallCtrl($scope) {
    $scope.slides = [];
    $scope.presets = {};
    $scope.newSlide = {url: '', time: '', reload: false};

    (function loadSlidesFromUrl() {
        var parameters = getQueryParameters();

        if (parameters.slides) {
            $scope.slides = JSON.parse(parameters.slides);
        }
    }());

    (function setupFirebase() {
        var presetsRef = new Firebase('https://luminous-fire-4957.firebaseio.com/presets/');

        presetsRef.on('child_added', function (snapshot) {
            var id = snapshot.name();
            $scope.presets[id] = snapshot.val();
            $scope.$digest();
        });

        presetsRef.on('child_removed', function (snapshot) {
            delete $scope.presets[snapshot.name()];
            $scope.$digest();
        });


        $scope.usePreset = function (presetId) {
            $scope.slides = $scope.presets[presetId];
        };

        $scope.savePreset = function () {
            presetsRef.push(angular.copy($scope.slides));
        };

        $scope.deletePreset = function (presetId) {
            presetsRef.child(presetId).remove();
        };

        $scope.anyPreset = function() {
            return Object.keys($scope.presets).length > 0;
        };
    }());


    $scope.addSlide = function () {
        if($scope.newSlide.url.substr(0, 4) !== 'http') {
            $scope.newSlide.url = 'http://' + $scope.newSlide.url;
        }
        $scope.slides.push($scope.newSlide);
        $scope.newSlide = {url: '', time: ''};
    };

    $scope.remove = function (index) { // doesn't work with sortable :(
        $scope.slides.splice(index, 1);
    };

    $scope.removeAll = function () { // doesn't work with sortable :(
        $scope.slides = [];
    };

    (function slideshow() {
        var $slideshowElement = $('#slideshow');
        $scope.runSlideshow = function () {
            window.history.pushState(null, null, $scope.createUrl());
            $slideshowElement.empty();
            $scope.slides.forEach(function (slide) {
                var $slide = $('<div class="slide">');
                var $frame = $('<iframe frameborder="0" marginheight="0" marginwidth="0" scrolling="no">');
                $frame.css({width: '100%', height: '100%'});
                $frame.attr('src', slide.url);
                $slide.append($frame);
                $slide.data('info', slide);
                $('#slideshow').append($slide);
            });
            $("html, body").css("overflow", "hidden");
            $slideshowElement.show();
            toggleFullScreen();
            $scope.continueWith(0);
        };

        $scope.continueWith = function (slideNumber) {
            var $slide = $('.slide:nth(' + slideNumber + ')');
            var slideInfo = $slide.data('info');
            var nextSlideNumber = slideNumber + 1 < $scope.slides.length ? slideNumber + 1 : 0;

            $slide.animate({opacity: 1}, function () {
                if ($scope.slides[nextSlideNumber].reload) {
                    var $nextSlideIframe = $('.slide:nth(' + nextSlideNumber + ')').find('iframe');
                    $nextSlideIframe.attr('src', $nextSlideIframe.attr('src'));
                }
            });

            setTimeout(function () {
                $slide.animate({opacity: 0});
                $scope.continueWith(nextSlideNumber);
            }, slideInfo.time * 1000);
        };
    }());
    $scope.createUrl = function () {
        var baseUrl = window.location.href.substr(0, window.location.href.length - window.location.search.length);
        return baseUrl + '?slides=' +
            angular.toJson($scope.slides)
                .replace(/=/g, encodeURIComponent("="))
                .replace(/&/g, encodeURIComponent("&"));
    };
});


function getQueryParameters() {
    return window.location.search.slice(1)
        .split('&')
        .reduce(function (a, b) {
            b = b.split('=');
            a[b[0]] = decodeURIComponent(b[1]);
            return a;
        }, {});
}

function toggleFullScreen() {
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||    // alternative standard method
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {               // current working methods
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}