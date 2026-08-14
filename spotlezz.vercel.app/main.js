document.addEventListener("DOMContentLoaded", function() {

  // 1. Swiper Slider (Only initialize if it exists on the page)
  if (document.querySelector('.mySwiper')) {
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 1,
      spaceBetween: 25,
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true, 
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        768: { slidesPerView: 1, spaceBetween: 30 },
        1024: { slidesPerView: 2, spaceBetween: 30 }, 
      },
    });
  }

  // 2. FAQ Accordion (Class based toggle)
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    if (question) {
      question.addEventListener('click', () => {
        const isActive = item.classList.contains('active');
        // Close all others
        faqItems.forEach(otherItem => otherItem.classList.remove('active'));
        // Toggle current
        if (!isActive) item.classList.add('active');
      });
    }
  });

  // 3. Scroll Reveal Animations
  const reveals = document.querySelectorAll('.reveal, .bento-item, .service-card, .kwaliteit-item');
  if (reveals.length > 0) {
    // We add the reveal class dynamically if it's missing so we can animate grids and cards automatically
    reveals.forEach(el => {
      if(!el.classList.contains('reveal')) {
        el.classList.add('reveal');
      }
    });

    const revealOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px"
    };
    
    const revealOnScroll = new IntersectionObserver(function(entries, observer) {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('active');
        observer.unobserve(entry.target); // Animate only once
      });
    }, revealOptions);

    reveals.forEach(reveal => {
      revealOnScroll.observe(reveal);
    });
  }
});

// Mobile Menu Toggle (Global function accessible via onclick)
window.toggleMobileMenu = function() {
  const nav = document.getElementById('mobileNav');
  if(nav) {
    nav.classList.toggle('open');
    document.body.style.overflow = nav.classList.contains('open') ? 'hidden' : '';
  }
};

// Close mobile menu when clicking a link
document.addEventListener("DOMContentLoaded", function() {
  const mobileLinks = document.querySelectorAll('#mobileNav a');
  mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
      const nav = document.getElementById('mobileNav');
      if(nav && nav.classList.contains('open')) {
        nav.classList.remove('open');
        document.body.style.overflow = '';
      }
    });
  });
});

// 5. Initialize Lenis Smooth Scrolling (Disabled for local file:/// viewing)
/*
document.addEventListener("DOMContentLoaded", function() {
  const lenisScript = document.createElement('script');
  lenisScript.src = 'https://unpkg.com/lenis@1.1.13/dist/lenis.min.js';
  lenisScript.onload = () => {
    const lenis = new Lenis();
    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
  };
  document.head.appendChild(lenisScript);
});
*/

// 4. Highlight active nav link dynamically
document.addEventListener('DOMContentLoaded', function() {
  const currentUrl = window.location.href.split('?')[0].split('#')[0];
  const navLinks = document.querySelectorAll('nav a, .mobile-nav-links a');
  navLinks.forEach(link => {
    if (link.classList.contains('dropbtn')) return;
    const hrefAttr = link.getAttribute('href');
    if (hrefAttr && !hrefAttr.startsWith('#') && link.href.split('?')[0].split('#')[0] === currentUrl) {
      link.style.color = 'var(--accent-orange)';
    }
  });
});



