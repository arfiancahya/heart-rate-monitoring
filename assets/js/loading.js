window.addEventListener('load', () => {
    const preload = document.querySelector('.loading');
    preload.classList.add('loading-finish');
})

const time = gsap.timeline({ default: { ease: 'power1.out' } });
time.fromTo("#div1", { opacity: 0 }, { opacity: 1, duration: 1 });
time.fromTo("#app", { opacity: 0 }, { opacity: 1, duration: 5 }, "-=1");