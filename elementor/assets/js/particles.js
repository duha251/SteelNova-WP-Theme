( function( $ ) {
    "use strict";

    function initParticles( $scope, $ ) {
        const $selector = $scope.find('.cs-particles');
        if (!$selector.length) {
            return;
        }
        const getParticleConfig = (settings) => {
            return {
                "particles": {
                    "number": {
                        "value": settings.number || 30,
                        "density": {
                            "enable": true,
                            "value_area": 800 
                        }
                    },
                    "color": {
                        "value": settings.color || '#ffffff'
                    },
                    "shape": {
                        "type": settings.shape.type || 'circle', 
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5 
                        },
                        "image": {
                            "src": settings.shape.image.src || '',
                            "width": parseInt( settings.shape.image.width ) || 50,
                            "height": parseInt( settings.shape.image.height ) || 50
                        }
                    },
                    "opacity": {
                        "value": 1,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": settings.size || 3, 
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 4,
                            "size_min": 0.3,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": false
                    },
                    "move": {
                        "enable": true,
                        "speed": 1.5,
                        "direction": settings.dir ?? 'none',
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": false
                        },
                        "onclick": {
                            "enable": false
                        },
                        "resize": true
                    }
                },
                "retina_detect": true
            };
        }

        const id = $selector.attr('id');
        const settings = $selector.data('particles-settings') || {};
        
        if (typeof particlesJS !== 'undefined') {
            particlesJS(id, getParticleConfig(settings));
        } else {
            console.error('particles.js library not loaded.');
        }
    }

    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/steelnova-particles.default', initParticles );
    });
} )( jQuery );