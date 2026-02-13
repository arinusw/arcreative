/* =============================================
   PROFESSIONAL PORTFOLIO JAVASCRIPT
   ============================================= */
// ============ HANDLE MOBILE RESIZE ============
function handleMobileResize() {
  const vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty("--vh", `${vh}px`);

  // Fix untuk elemen yang mungkin overflow
  const containers = document.querySelectorAll(".container");
  containers.forEach((container) => {
    if (container.scrollWidth > window.innerWidth) {
      container.style.overflow = "hidden";
    }
  });
}

window.addEventListener("resize", handleMobileResize);
window.addEventListener("orientationchange", handleMobileResize);
handleMobileResize();

// ============ FIX TOUCH SCROLL ============
document.addEventListener(
  "touchmove",
  function (e) {
    if (e.target.closest(".modal-content")) {
      e.stopPropagation();
    }
  },
  { passive: false },
);
// ============ MOBILE MENU TOGGLE ============
const menuToggle = document.querySelector(".navbar-toggle");
const navbar = document.querySelector(".navbar-menu");
const menuLinks = document.querySelectorAll(".menu-list a");

if (menuToggle) {
  menuToggle.addEventListener("click", function (e) {
    e.stopPropagation();
    navbar.classList.toggle("active");
    menuToggle.classList.toggle("active");
  });
}

// Close menu when clicking on a link
menuLinks.forEach((link) => {
  link.addEventListener("click", function () {
    navbar.classList.remove("active");
    menuToggle.classList.remove("active");
  });
});

// Close menu when clicking outside
document.addEventListener("click", function (e) {
  if (navbar && navbar.classList.contains("active")) {
    if (
      !e.target.closest(".navbar-menu") &&
      !e.target.closest(".navbar-toggle")
    ) {
      navbar.classList.remove("active");
      menuToggle.classList.remove("active");
    }
  }
});

// ============ SCROLL TO TOP BUTTON ============
const scrollToTopBtn = document.querySelector(".scroll-to-top");

if (scrollToTopBtn) {
  window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
      scrollToTopBtn.classList.add("show");
    } else {
      scrollToTopBtn.classList.remove("show");
    }
  });

  scrollToTopBtn.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
}

// ============ SMOOTH SCROLLING ============
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const targetId = this.getAttribute("href");
    const targetElement = document.querySelector(targetId);

    if (targetElement) {
      targetElement.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  });
});

// ============ PORTFOLIO MODAL ============
const portfolioModal = document.getElementById("portfolioModal");
const modalCloseBtn = document.querySelector(".modal-close");
const closeModalBtn = document.getElementById("closeModalBtn");
const allPortfolioItems = document.querySelectorAll(".portfolio-item");

// Portfolio data dengan deskripsi dan informasi detail
const portfolioData = {
  1: {
    title: "Logo Perusahaan Modern",
    category: "Graphic Design",
    description:
      "Desain logo profesional untuk perusahaan teknologi dengan konsep modern dan minimalis. Logo ini menggabungkan elemen geometri dengan palet warna yang mencerminkan profesionalisme dan inovasi. Proses kreatif melibatkan riset mendalam tentang industri dan target market klien.",
    image: "img/placeholder-work.jpg",
    tags: ["Logo Design", "Branding", "Corporate Identity"],
    blogCategory: "tutorial-design",
  },
  2: {
    title: "Website E-Commerce Profesional",
    category: "Web Development",
    description:
      "Pengembangan website e-commerce responsif dengan fitur lengkap seperti shopping cart, payment gateway integration, dan admin dashboard. Website dibangun menggunakan teknologi terkini dengan fokus pada user experience dan performa tinggi. Dilengkapi dengan SEO optimization untuk meningkatkan visibility di search engine.",
    image: "img/placeholder-web.jpeg",
    tags: ["Web Development", "E-Commerce", "Responsive Design"],
    blogCategory: "tutorial-web",
  },
  3: {
    title: "Kampanye Promosi Digital",
    category: "Graphic Design",
    description:
      "Desain banner dan material promosi digital untuk kampanye pemasaran multi-channel. Mencakup design untuk media sosial, website banner, dan iklan digital dengan konsistensi brand identity. Strategi visual dirancang untuk meningkatkan engagement dan konversi penjualan.",
    image: "img/placeholder-banerdesign.jpg",
    tags: ["Banner Design", "Social Media", "Marketing"],
    blogCategory: "tutorial-design",
  },
  4: {
    title: "Website Portofolio Kreatif",
    category: "Web Development",
    description:
      "Pembuatan website portofolio interaktif untuk menampilkan karya digital dengan style yang menarik dan navigasi intuitif. Website ini menampilkan gallery project dengan filter kategori, detail project dengan lightbox effect, dan contact form terintegrasi. Dioptimalkan untuk semua device dengan performa loading yang cepat.",
    image: "img/placeholder-webfortofolio.jpeg",
    tags: ["Web Development", "Portofolio", "UI/UX Design"],
    blogCategory: "tutorial-web",
  },
};

// Event listener untuk membuka modal
allPortfolioItems.forEach((item) => {
  const btn = item.querySelector(".portfolio-btn");
  if (btn) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      const projectId = item.getAttribute("data-project-id");
      openPortfolioModal(projectId);
    });
  }
});

// Fungsi membuka modal
function openPortfolioModal(projectId) {
  const data = portfolioData[projectId];
  if (!data) return;

  document.getElementById("modalImage").src = data.image;
  document.getElementById("modalTitle").textContent = data.title;
  document.getElementById("modalCategory").textContent = data.category;
  document.getElementById("modalDescription").textContent = data.description;

  // Tags
  const tagsContainer = document.getElementById("modalTags");
  tagsContainer.innerHTML = "";
  data.tags.forEach((tag) => {
    const tagEl = document.createElement("span");
    tagEl.className = "modal-tag";
    tagEl.textContent = tag;
    tagsContainer.appendChild(tagEl);
  });

  // Update blog link
  const readMoreBtn = document.getElementById("readMoreBtn");
  readMoreBtn.href = `blog.html?category=${data.blogCategory}`;

  portfolioModal.classList.add("active");
  document.body.style.overflow = "hidden";
}

// Fungsi menutup modal
function closePortfolioModal() {
  portfolioModal.classList.remove("active");
  document.body.style.overflow = "auto";
}

if (modalCloseBtn) {
  modalCloseBtn.addEventListener("click", closePortfolioModal);
}

if (closeModalBtn) {
  closeModalBtn.addEventListener("click", closePortfolioModal);
}

if (portfolioModal) {
  portfolioModal.addEventListener("click", function (e) {
    if (e.target === portfolioModal) {
      closePortfolioModal();
    }
  });
}

// Close modal with Escape key
document.addEventListener("keydown", function (e) {
  if (e.key === "Escape" && portfolioModal.classList.contains("active")) {
    closePortfolioModal();
  }
});

// ============ PORTFOLIO FILTER ============
const filterButtons = document.querySelectorAll(".filter-btn");

filterButtons.forEach((button) => {
  button.addEventListener("click", function () {
    // Remove active from all buttons
    filterButtons.forEach((btn) => btn.classList.remove("active"));
    // Add active to clicked button
    this.classList.add("active");

    const filterValue = this.getAttribute("data-filter");

    // Filter items dengan smooth animation
    allPortfolioItems.forEach((item) => {
      const itemCategory = item.getAttribute("data-category");

      if (filterValue === "all" || itemCategory === filterValue) {
        item.style.display = "block";
        item.style.opacity = "0";
        item.style.transform = "scale(0.95)";
        setTimeout(() => {
          item.style.opacity = "1";
          item.style.transform = "scale(1)";
        }, 10);
      } else {
        item.style.opacity = "1";
        item.style.transform = "scale(1)";
        setTimeout(() => {
          item.style.opacity = "0";
          item.style.transform = "scale(0.95)";
          setTimeout(() => {
            item.style.display = "none";
          }, 300);
        }, 10);
      }
    });
  });
});

// ============ CONTACT FORM ============
const contactForm = document.getElementById("contactForm");

if (contactForm) {
  contactForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    if (name === "" || email === "" || message === "") {
      alert("Please fill in all fields!");
      return;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Please enter a valid email!");
      return;
    }

    // Success message
    alert("Thank you for your message! I will get back to you soon.");

    // Reset form
    contactForm.reset();
  });
}

// ============ SKILLS CHART ============
document.addEventListener("DOMContentLoaded", function () {
  const skillsChartCanvas = document.getElementById("skillsChart");

  if (skillsChartCanvas) {
    // Pastikan canvas punya ukuran yang jelas
    skillsChartCanvas.style.width = "100%";
    skillsChartCanvas.style.height = "400px";
    skillsChartCanvas.width = skillsChartCanvas.offsetWidth;
    skillsChartCanvas.height = skillsChartCanvas.offsetHeight;

    const ctx = skillsChartCanvas.getContext("2d");

    // Hapus chart lama jika ada
    if (window.mySkillsChart) {
      window.mySkillsChart.destroy();
    }

    // Buat chart baru
    window.mySkillsChart = new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: [
          "Design Grafis (90%)",
          "CMS Web Dev (80%)",
          "Content Management (78%)",
          "IT Support (85%)",
        ],
        datasets: [
          {
            data: [90, 80, 78, 85],
            backgroundColor: ["#569ae3", "#004e89", "#7cb5e8", "#06a77d"],
            borderColor: "#1a1f2e",
            borderWidth: 3,
            hoverOffset: 10,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: "60%",
        plugins: {
          legend: {
            position: "bottom",
            labels: {
              color: "#e0e0e0",
              font: {
                size: 12,
                weight: "500",
                family: "'Poppins', sans-serif",
              },
              padding: 15,
              usePointStyle: true,
              boxWidth: 10,
            },
          },
          tooltip: {
            backgroundColor: "#1a1f2e",
            titleColor: "#569ae3",
            bodyColor: "#e0e0e0",
            borderColor: "#569ae3",
            borderWidth: 1,
            titleFont: {
              size: 13,
              weight: "600",
            },
            bodyFont: {
              size: 12,
            },
            padding: 10,
            callbacks: {
              label: function (context) {
                return context.label + ": " + context.parsed + "%";
              },
            },
          },
        },
      },
    });
  }
});

// ============ SCROLL ANIMATIONS ============
const observerOptions = {
  threshold: 0.1,
  rootMargin: "0px 0px -100px 0px",
};

const observer = new IntersectionObserver(function (entries) {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = "1";
      entry.target.style.transform = "translateY(0)";
    }
  });
}, observerOptions);

// Observe elements for scroll animation
const animatedElements = document.querySelectorAll(
  ".service-card, .portfolio-item, .skill-item",
);
animatedElements.forEach((el) => {
  el.style.opacity = "0";
  el.style.transform = "translateY(20px)";
  el.style.transition = "all 0.6s ease";
  observer.observe(el);
});

// ============ ACTIVE NAVBAR ON SCROLL ============
window.addEventListener("scroll", () => {
  let current = "";
  const sections = document.querySelectorAll("section");

  sections.forEach((section) => {
    const sectionTop = section.offsetTop;
    if (scrollY >= sectionTop - 200) {
      current = section.getAttribute("id");
    }
  });

  menuLinks.forEach((link) => {
    link.classList.remove("active");
    if (link.getAttribute("href").slice(1) === current) {
      link.classList.add("active");
    }
  });
});

console.log("Portfolio JavaScript loaded successfully!");
