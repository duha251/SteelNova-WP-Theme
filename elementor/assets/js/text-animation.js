(function ($) {
    "use strict";

    function textAnimationInit( $scope ) {
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function () {
                initTextAnimation($scope);
            });
        } else {
            initTextAnimation($scope);
        }
    }

    function initTextAnimation( $scope ) {
        var $element = $scope.find('[data-text-animation]');
        if ($element.length === 0) return;

        var animationType = $element.data('text-animation');
        var duration = $element.data('animation-duration') || 1;
        var delay = $element.data('animation-delay') || 0;
        var stagger = $element.data('animation-stagger') || 0.025;

        gsap.registerPlugin(ScrollTrigger);

        var splitText, tl, chars, words, lines;

        var scrollTriggerConfig = {
            trigger: $element[0],
            start: "top 85%",
            end: "bottom 15%",
            toggleActions: "play none none none"
        };

        var scrubScrollTrigger = {
            trigger: $element[0],
            start: "top 85%",
            end: "bottom 15%",
            scrub: 1
        };

        switch (animationType) {
            case 'textRevealUp':
                gsap.set($element[0], { overflow: 'hidden' });
                splitText = new SplitText($element[0], { types: 'lines, words' });
                gsap.set(splitText.words, { yPercent: 100, opacity: 0 });
                gsap.to(splitText.words, {
                    yPercent: 0,
                    opacity: 1,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textRevealDown':
                gsap.set($element[0], { overflow: 'hidden' });
                splitText = new SplitText($element[0], { types: 'lines, words' });
                gsap.set(splitText.words, { yPercent: -100, opacity: 0 });
                gsap.to(splitText.words, {
                    yPercent: 0,
                    opacity: 1,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textFadeIn':
                gsap.set($element[0], { opacity: 0 });
                gsap.to($element[0], {
                    opacity: 1,
                    duration: duration,
                    delay: delay,
                    ease: "power2.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textBlurReveal':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, filter: 'blur(10px)' });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    filter: 'blur(0px)',
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power2.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textSplitWordsReveal':
                splitText = new SplitText($element[0], { types: 'words' });
                gsap.set(splitText.words, { opacity: 0, yPercent: 50 });
                gsap.to(splitText.words, {
                    opacity: 1,
                    yPercent: 0,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textSplitCharsReveal':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, yPercent: 80 });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    yPercent: 0,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textSplitLinesReveal':
                splitText = new SplitText($element[0], { types: 'lines' });
                gsap.set(splitText.lines, { opacity: 0, yPercent: 100 });
                gsap.to(splitText.lines, {
                    opacity: 1,
                    yPercent: 0,
                    duration: duration,
                    delay: delay,
                    stagger: 0.15,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textMaskReveal':
                gsap.set($element[0], { overflow: 'hidden' });
                splitText = new SplitText($element[0], { types: 'lines' });
                $(splitText.lines).each(function () {
                    $(this).wrap('<div style="overflow:hidden;"></div>');
                });
                gsap.set(splitText.lines, { yPercent: 100 });
                gsap.to(splitText.lines, {
                    yPercent: 0,
                    duration: duration,
                    delay: delay,
                    stagger: 0.1,
                    ease: "power4.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textStaggerReveal':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, y: 20 });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    y: 0,
                    duration: duration,
                    delay: delay,
                    stagger: {
                        each: stagger,
                        from: "start"
                    },
                    ease: "back.out(1.7)",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textRotateReveal':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, rotationX: -90, transformOrigin: "50% 50%" });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    rotationX: 0,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textScaleReveal':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, scale: 0 });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    scale: 1,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "back.out(1.7)",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textSkewReveal':
                splitText = new SplitText($element[0], { types: 'words' });
                gsap.set(splitText.words, { opacity: 0, skewX: 30, x: 50 });
                gsap.to(splitText.words, {
                    opacity: 1,
                    skewX: 0,
                    x: 0,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textClipPathReveal':
                gsap.set($element[0], { clipPath: 'inset(0 100% 0 0)' });
                gsap.to($element[0], {
                    clipPath: 'inset(0 0% 0 0)',
                    duration: duration,
                    delay: delay,
                    ease: "power3.inOut",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textColorChangeOnScroll':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                var originalColor = $element.css('color');
                gsap.set(splitText.chars, { color: '#cccccc' });
                gsap.to(splitText.chars, {
                    color: originalColor,
                    duration: duration,
                    stagger: stagger,
                    ease: "none",
                    scrollTrigger: scrubScrollTrigger
                });
                break;

            case 'textGradientReveal':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0.2 });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    duration: duration,
                    stagger: stagger,
                    ease: "none",
                    scrollTrigger: scrubScrollTrigger
                });
                break;

            case 'textParallax':
                gsap.to($element[0], {
                    yPercent: -30,
                    ease: "none",
                    scrollTrigger: {
                        trigger: $element[0],
                        start: "top bottom",
                        end: "bottom top",
                        scrub: 1
                    }
                });
                break;

            case 'textScrubAnimation':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0.1 });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    stagger: 0.1,
                    ease: "none",
                    scrollTrigger: scrubScrollTrigger
                });
                break;

            case 'textPinReveal':
                splitText = new SplitText($element[0], { types: 'lines' });
                gsap.set(splitText.lines, { opacity: 0, y: 30 });
                tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: $element[0],
                        start: "top 60%",
                        end: "+=300",
                        pin: true,
                        scrub: 1
                    }
                });
                tl.to(splitText.lines, {
                    opacity: 1,
                    y: 0,
                    stagger: 0.2,
                    duration: duration,
                    ease: "power3.out"
                });
                break;

            case 'textTypewriterOnScroll':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0 });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    stagger: 0.03,
                    ease: "steps(1)",
                    scrollTrigger: scrubScrollTrigger
                });
                break;

            case 'textWaveReveal':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, y: 50 });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    y: 0,
                    duration: duration,
                    delay: delay,
                    stagger: {
                        each: stagger,
                        from: "start"
                    },
                    ease: "elastic.out(1, 0.5)",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textSlideFromLeft':
                gsap.set($element[0], { opacity: 0, x: -100 });
                gsap.to($element[0], {
                    opacity: 1,
                    x: 0,
                    duration: duration,
                    delay: delay,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textSlideFromRight':
                gsap.set($element[0], { opacity: 0, x: 100 });
                gsap.to($element[0], {
                    opacity: 1,
                    x: 0,
                    duration: duration,
                    delay: delay,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textOpacityStagger':
                splitText = new SplitText($element[0], { types: 'words' });
                gsap.set(splitText.words, { opacity: 0 });
                gsap.to(splitText.words, {
                    opacity: 1,
                    duration: duration,
                    delay: delay,
                    stagger: 0.1,
                    ease: "power2.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textCounterOnScroll':
                var target = { val: 0 };
                var endVal = parseInt($element.text(), 10) || 100;
                gsap.to(target, {
                    val: endVal,
                    duration: duration * 2,
                    ease: "power1.out",
                    scrollTrigger: scrollTriggerConfig,
                    onUpdate: function () {
                        $element.text(Math.floor(target.val));
                    }
                });
                break;

            case 'textFlipReveal':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, rotationY: -90, transformOrigin: "50% 50%" });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    rotationY: 0,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'text3DRotateReveal':
                gsap.set($element[0], { perspective: 600 });
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, rotationX: 90, rotationY: 45, transformOrigin: "50% 50%" });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    rotationX: 0,
                    rotationY: 0,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power3.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textLineMaskReveal':
                splitText = new SplitText($element[0], { types: 'lines' });
                $(splitText.lines).each(function () {
                    $(this).wrap('<div style="overflow:hidden;"></div>');
                });
                gsap.set(splitText.lines, { yPercent: 100, opacity: 0 });
                gsap.to(splitText.lines, {
                    yPercent: 0,
                    opacity: 1,
                    duration: duration,
                    delay: delay,
                    stagger: 0.15,
                    ease: "power4.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textWordMaskReveal':
                splitText = new SplitText($element[0], { types: 'words' });
                $(splitText.words).each(function () {
                    $(this).wrap('<div style="overflow:hidden; display:inline-block;"></div>');
                });
                gsap.set(splitText.words, { yPercent: 100, opacity: 0 });
                gsap.to(splitText.words, {
                    yPercent: 0,
                    opacity: 1,
                    duration: duration,
                    delay: delay,
                    stagger: stagger,
                    ease: "power4.out",
                    scrollTrigger: scrollTriggerConfig
                });
                break;

            case 'textCharacterWaveOnScroll':
                splitText = new SplitText($element[0], { types: 'words, chars' });
                gsap.set(splitText.chars, { opacity: 0, y: 30 });
                gsap.to(splitText.chars, {
                    opacity: 1,
                    y: 0,
                    stagger: {
                        each: 0.03,
                        from: "start"
                    },
                    ease: "sine.out",
                    scrollTrigger: scrubScrollTrigger
                });
                break;
        }

    }

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction( "frontend/element_ready/steelnova-heading.default", textAnimationInit );
    });
})(jQuery);