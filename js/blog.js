/* =============================================
   BLOG PAGE JAVASCRIPT
   ============================================= */

// ============ BLOG ARTICLES DATA ============
const blogArticles = [
  // TUTORIAL DESIGN
  {
    id: 1,
    title: "Panduan Lengkap Memulai Desain Grafis untuk Pemula",
    excerpt:
      "Belajar dasar-dasar desain grafis dari nol. Panduan ini mencakup teori warna, tipografi, komposisi, dan tools yang perlu Anda kuasai.",
    category: "tutorial-design",
    image: '<i class="fas fa-palette"></i>',
    date: "2026-02-05",
    readTime: "8 min",
    tags: ["Design", "Beginner", "Tutorial"],
  },
  {
    id: 2,
    title: "Logo Design: Tips & Trik Membuat Logo yang Memorable",
    excerpt:
      "Pelajari cara membuat logo yang efektif, memorable, dan timeless. Dari sketsa awal hingga finalisasi dengan software profesional.",
    category: "tutorial-design",
    image: '<i class="fas fa-pen-nib"></i>',
    date: "2026-02-04",
    readTime: "10 min",
    tags: ["Logo", "Branding", "Design"],
  },
  {
    id: 3,
    title: "Psikologi Warna dalam Desain Grafis",
    excerpt:
      "Pahami bagaimana warna mempengaruhi emosi dan keputusan viewer. Panduan lengkap untuk memilih palet warna yang tepat untuk brand Anda.",
    category: "tutorial-design",
    image: '<i class="fas fa-eye-dropper"></i>',
    date: "2026-02-03",
    readTime: "7 min",
    tags: ["Color Theory", "Design", "Psychology"],
  },
  {
    id: 4,
    title: "Tipografi dalam Desain: Font Selection & Pairing",
    excerpt:
      "Pelajari cara memilih dan menggabungkan font yang tepat untuk desain Anda. Tips praktis untuk hierarchy dan readability yang optimal.",
    category: "tutorial-design",
    image: '<i class="fas fa-font"></i>',
    date: "2026-02-02",
    readTime: "6 min",
    tags: ["Typography", "Fonts", "Design"],
  },
  {
    id: 5,
    title: "Desain Banner & Social Media yang Menarik",
    excerpt:
      "Tutorial lengkap membuat banner dan konten visual untuk media sosial. Ukuran, format, dan tips desain untuk engagement maksimal.",
    category: "tutorial-design",
    image: '<i class="fas fa-image"></i>',
    date: "2026-02-01",
    readTime: "9 min",
    tags: ["Social Media", "Banner", "Marketing"],
  },
  {
    id: 6,
    title: "Adobe Photoshop untuk Beginner: Fitur-Fitur Dasar",
    excerpt:
      "Panduan memaksimalkan Photoshop dari level beginner. Pelajari tools essential, layer management, dan teknik editing dasar.",
    category: "tutorial-design",
    image: '<i class="fas fa-image"></i>',
    date: "2026-01-31",
    readTime: "12 min",
    tags: ["Photoshop", "Software", "Design"],
  },
  {
    id: 7,
    title: "Edit Foto Profesional: Teknik & Tips dari Expert",
    excerpt:
      "Teknik editing foto level profesional dengan Lightroom & Photoshop. Dari color grading hingga retouching untuk hasil sempurna.",
    category: "tutorial-design",
    image: '<i class="fas fa-camera"></i>',
    date: "2026-01-30",
    readTime: "11 min",
    tags: ["Photo Editing", "Lightroom", "Professional"],
  },
  {
    id: 8,
    title: "Canva: Tool Design Mudah untuk Non-Designer",
    excerpt:
      "Manfaatkan Canva untuk membuat desain profesional tanpa pengalaman design. Template, tips, dan trik untuk hasil maksimal.",
    category: "tutorial-design",
    image: '<i class="fas fa-paint-brush"></i>',
    date: "2026-01-29",
    readTime: "5 min",
    tags: ["Canva", "Tool", "Easy Design"],
  },
  {
    id: 9,
    title: "UI/UX Design Fundamental untuk Website & App",
    excerpt:
      "Pelajari prinsip UI/UX design yang good. User research, wireframing, prototyping, dan testing untuk interface yang user-friendly.",
    category: "tutorial-design",
    image: '<i class="fas fa-mobile-alt"></i>',
    date: "2026-01-28",
    readTime: "13 min",
    tags: ["UI/UX", "Design", "Web"],
  },
  {
    id: 10,
    title: "Figma: Design Tool Modern untuk Kolaborasi Tim",
    excerpt:
      "Master Figma untuk design modern. Fitur collaboration, component system, dan plugin yang mempercepat workflow design Anda.",
    category: "tutorial-design",
    image: '<i class="fas fa-figma"></i>',
    date: "2026-01-27",
    readTime: "10 min",
    tags: ["Figma", "Design Tool", "Collaboration"],
  },
  {
    id: 11,
    title: "Mockup & Presentation: Showcase Desain Seperti Pro",
    excerpt:
      "Cara membuat mockup profesional untuk portfolio & client presentation. Tools dan teknik untuk hasil yang impressive.",
    category: "tutorial-design",
    image: '<i class="fas fa-presentation"></i>',
    date: "2026-01-26",
    readTime: "8 min",
    tags: ["Mockup", "Presentation", "Portfolio"],
  },

  // TUTORIAL WEB DEVELOPMENT
  {
    id: 12,
    title: "6 Tips Membuat Website yang SEO Friendly dan Cepat",
    excerpt:
      "Optimasi website untuk ranking tinggi di Google. Teknik SEO on-page, off-page, dan technical SEO yang proven meningkatkan traffic.",
    category: "tutorial-web",
    image: '<i class="fas fa-search"></i>',
    date: "2026-02-03",
    readTime: "10 min",
    tags: ["SEO", "Web Development", "Performance"],
  },
  {
    id: 13,
    title: "HTML & CSS: Fondasi Web Development yang Solid",
    excerpt:
      "Pelajari HTML5 dan CSS3 dari dasar. Semantic HTML, modern CSS techniques, dan best practices untuk clean code.",
    category: "tutorial-web",
    image: '<i class="fas fa-code"></i>',
    date: "2026-02-02",
    readTime: "12 min",
    tags: ["HTML", "CSS", "Web Development"],
  },
  {
    id: 14,
    title: "JavaScript untuk Pemula: Interaksi & DOM Manipulation",
    excerpt:
      "Master JavaScript dasar untuk membuat website interaktif. Event listening, DOM manipulation, dan async programming yang mudah dipahami.",
    category: "tutorial-web",
    image: '<i class="fas fa-js-square"></i>',
    date: "2026-02-01",
    readTime: "14 min",
    tags: ["JavaScript", "Frontend", "Programming"],
  },
  {
    id: 15,
    title: "Responsive Design: Buat Website yang Mobile-Friendly",
    excerpt:
      "Teknik responsive design untuk website yang sempurna di semua device. Media queries, flexbox, & grid layout yang powerful.",
    category: "tutorial-web",
    image: '<i class="fas fa-mobile-alt"></i>',
    date: "2026-01-31",
    readTime: "9 min",
    tags: ["Responsive Design", "Mobile", "CSS"],
  },
  {
    id: 16,
    title: "Frameworks JavaScript: React, Vue, Angular Comparison",
    excerpt:
      "Perbandingan framework JavaScript populer. Pilih yang tepat untuk project Anda dengan pros, cons, dan use case dari masing-masing.",
    category: "tutorial-web",
    image: '<i class="fas fa-react"></i>',
    date: "2026-01-30",
    readTime: "11 min",
    tags: ["React", "Framework", "JavaScript"],
  },
  {
    id: 17,
    title: "Backend Development: Node.js & Express Dasar",
    excerpt:
      "Belajar backend programming dengan Node.js. Setup server, routing, middleware, dan database connection dengan Express.js.",
    category: "tutorial-web",
    image: '<i class="fas fa-server"></i>',
    date: "2026-01-29",
    readTime: "13 min",
    tags: ["Node.js", "Backend", "Express"],
  },
  {
    id: 18,
    title: "Database: MySQL, MongoDB, dan PostgreSQL untuk Pemula",
    excerpt:
      "Pengenalan database relational & non-relational. Query dasar, design schema, dan tips optimization untuk performa database.",
    category: "tutorial-web",
    image: '<i class="fas fa-database"></i>',
    date: "2026-01-28",
    readTime: "12 min",
    tags: ["Database", "SQL", "MongoDB"],
  },
  {
    id: 19,
    title: "Git & GitHub: Version Control untuk Developer",
    excerpt:
      "Master Git untuk collaboration yang smooth. Branching, merging, resolving conflicts, dan best practices dalam team development.",
    category: "tutorial-web",
    image: '<i class="fas fa-git"></i>',
    date: "2026-01-27",
    readTime: "8 min",
    tags: ["Git", "GitHub", "Version Control"],
  },
  {
    id: 20,
    title: "API Development: REST API & GraphQL Basics",
    excerpt:
      "Buat API yang scalable dan maintainable. REST principles, status codes, authentication, dan intro ke GraphQL.",
    category: "tutorial-web",
    image: '<i class="fas fa-network-wired"></i>',
    date: "2026-01-26",
    readTime: "11 min",
    tags: ["API", "REST", "GraphQL"],
  },
  {
    id: 21,
    title: "Hosting & Deployment: Deploy Website ke Production",
    excerpt:
      "Panduan lengkap hosting & deployment. Pilih hosting provider, domain setup, SSL certificate, dan continuous deployment.",
    category: "tutorial-web",
    image: '<i class="fas fa-cloud-upload-alt"></i>',
    date: "2026-01-25",
    readTime: "10 min",
    tags: ["Hosting", "Deployment", "Cloud"],
  },

  // TUTORIAL MICROSOFT
  {
    id: 22,
    title: "Microsoft Office Mastery: Word, Excel, PowerPoint",
    excerpt:
      "Kuasai Microsoft Office suite. Tips & trik untuk produktivitas maksimal di Word, Excel, dan PowerPoint.",
    category: "tutorial-ms",
    image: '<i class="fas fa-file-word"></i>',
    date: "2026-02-02",
    readTime: "9 min",
    tags: ["Microsoft Office", "Productivity", "Tutorial"],
  },
  {
    id: 23,
    title: "Excel Advanced: Formula, Pivot Table & Chart",
    excerpt:
      "Tutorial Excel lanjutan untuk analisis data profesional. Formula kompleks, pivot table, dan data visualization yang impressive.",
    category: "tutorial-ms",
    image: '<i class="fas fa-file-excel"></i>',
    date: "2026-02-01",
    readTime: "11 min",
    tags: ["Excel", "Data Analysis", "Advanced"],
  },
  {
    id: 24,
    title: "PowerPoint: Presentasi Profesional yang Memikat",
    excerpt:
      "Cara membuat presentasi yang engaging dan persuasif. Design tips, animation, dan storytelling untuk presentasi sukses.",
    category: "tutorial-ms",
    image: '<i class="fas fa-presentation"></i>',
    date: "2026-01-31",
    readTime: "8 min",
    tags: ["PowerPoint", "Presentation", "Design"],
  },
  {
    id: 25,
    title: "OneNote & Teams: Kolaborasi & Produktivitas",
    excerpt:
      "Manfaatkan OneNote dan Teams untuk kolaborasi tim yang efektif. Organization, sharing, dan communication tools.",
    category: "tutorial-ms",
    image: '<i class="fas fa-users"></i>',
    date: "2026-01-30",
    readTime: "7 min",
    tags: ["Teams", "OneNote", "Collaboration"],
  },
  {
    id: 26,
    title: "Outlook: Email Management & Calendar Organization",
    excerpt:
      "Optimalkan Outlook untuk email & scheduling yang efisien. Rules, templates, dan calendar management untuk produktivitas.",
    category: "tutorial-ms",
    image: '<i class="fas fa-envelope"></i>',
    date: "2026-01-29",
    readTime: "6 min",
    tags: ["Outlook", "Email", "Organization"],
  },
  {
    id: 27,
    title: "Windows 10/11: Tips Mengoptimalkan & Troubleshoot",
    excerpt:
      "Maksimalkan performa Windows. Setup optimal, maintenance, security tips, dan solusi problem umum.",
    category: "tutorial-ms",
    image: '<i class="fas fa-windows"></i>',
    date: "2026-01-28",
    readTime: "10 min",
    tags: ["Windows", "System", "Optimization"],
  },
  {
    id: 28,
    title: "Azure Cloud: Intro untuk Developer & IT Pro",
    excerpt:
      "Pengenalan Microsoft Azure cloud platform. Virtual machines, databases, dan deployment untuk scalable solutions.",
    category: "tutorial-ms",
    image: '<i class="fas fa-cloud"></i>',
    date: "2026-01-27",
    readTime: "12 min",
    tags: ["Azure", "Cloud", "Microsoft"],
  },
  {
    id: 29,
    title: "Access Database: Create & Manage Database Profesional",
    excerpt:
      "Buat database yang robust dengan Microsoft Access. Tables, queries, forms, dan reports untuk data management.",
    category: "tutorial-ms",
    image: '<i class="fas fa-database"></i>',
    date: "2026-01-26",
    readTime: "9 min",
    tags: ["Access", "Database", "Microsoft"],
  },

  // EDUKASI DIGITALISASI
  {
    id: 30,
    title: "Transformasi Digital: Panduan untuk Bisnis Modern",
    excerpt:
      "Memahami digital transformation dan implementasinya. Strategy, tools, dan best practices untuk bisnis di era digital.",
    category: "edukasi",
    image: '<i class="fas fa-digital-tachograph"></i>',
    date: "2026-02-01",
    readTime: "9 min",
    tags: ["Digital Transformation", "Business", "Strategy"],
  },
  {
    id: 31,
    title: "Content Marketing: Strategy Membuat Konten yang Valuable",
    excerpt:
      "Pelajari cara membuat konten yang engaging dan mendorong konversi. Planning, creation, distribution, dan analysis.",
    category: "edukasi",
    image: '<i class="fas fa-pen"></i>',
    date: "2026-01-31",
    readTime: "10 min",
    tags: ["Content Marketing", "Strategy", "Digital"],
  },
  {
    id: 32,
    title: "Social Media Marketing: Strategi Media Sosial Efektif",
    excerpt:
      "Master social media untuk business growth. Platform strategy, content planning, engagement tactics, dan analytics.",
    category: "edukasi",
    image: '<i class="fas fa-share-alt"></i>',
    date: "2026-01-30",
    readTime: "11 min",
    tags: ["Social Media", "Marketing", "Digital"],
  },
  {
    id: 33,
    title: "Email Marketing: Automation dan Campaign yang Sukses",
    excerpt:
      "Strategi email marketing yang menghasilkan ROI tinggi. Segmentation, automation, copywriting, dan A/B testing.",
    category: "edukasi",
    image: '<i class="fas fa-envelope-open"></i>',
    date: "2026-01-29",
    readTime: "8 min",
    tags: ["Email Marketing", "Automation", "Digital"],
  },
  {
    id: 34,
    title: "E-Commerce: Memulai Bisnis Online Dari Dasar",
    excerpt:
      "Panduan lengkap memulai toko online. Platform pilihan, product listing, payment gateway, dan marketing strategies.",
    category: "edukasi",
    image: '<i class="fas fa-shopping-cart"></i>',
    date: "2026-01-28",
    readTime: "12 min",
    tags: ["E-Commerce", "Business", "Digital"],
  },
  {
    id: 35,
    title: "Data Literacy: Membaca & Menganalisa Data untuk Bisnis",
    excerpt:
      "Pentingnya data literacy di era digital. Cara membaca data, analytics tools, dan decision making berbasis data.",
    category: "edukasi",
    image: '<i class="fas fa-chart-bar"></i>',
    date: "2026-01-27",
    readTime: "9 min",
    tags: ["Data Analysis", "Literacy", "Business"],
  },
  {
    id: 36,
    title: "Cybersecurity Basics: Proteksi Data di Era Digital",
    excerpt:
      "Fundamental cybersecurity untuk protect bisnis Anda. Password management, encryption, threats, dan best practices.",
    category: "edukasi",
    image: '<i class="fas fa-shield-alt"></i>',
    date: "2026-01-26",
    readTime: "10 min",
    tags: ["Cybersecurity", "Protection", "Digital"],
  },

  // TEKNOLOGI TERKINI
  {
    id: 37,
    title: "AI & Machine Learning: Revolusi Teknologi 2026",
    excerpt:
      "Update terkini tentang AI & ML. ChatGPT, image generation, automation tools, dan impact terhadap industri.",
    category: "teknologi",
    image: '<i class="fas fa-brain"></i>',
    date: "2026-02-05",
    readTime: "11 min",
    tags: ["AI", "Machine Learning", "Tech News"],
  },
  {
    id: 38,
    title: "Web3 & Cryptocurrency: Masa Depan Internet",
    excerpt:
      "Mengerti Web3, blockchain, NFT, dan cryptocurrency. Peluang dan risk di era decentralization.",
    category: "teknologi",
    image: '<i class="fas fa-cube"></i>',
    date: "2026-02-04",
    readTime: "10 min",
    tags: ["Web3", "Blockchain", "Cryptocurrency"],
  },
  {
    id: 39,
    title: "Cloud Computing: Trend & Praktik Terbaik 2026",
    excerpt:
      "Perkembangan cloud computing terkini. Multi-cloud strategy, edge computing, dan serverless architecture.",
    category: "teknologi",
    image: '<i class="fas fa-cloud"></i>',
    date: "2026-02-03",
    readTime: "9 min",
    tags: ["Cloud", "Technology", "Trend"],
  },
  {
    id: 40,
    title: "5G & IoT: Konektivitas Masa Depan",
    excerpt:
      "Inovasi 5G dan Internet of Things. Aplikasi praktis, peluang bisnis, dan dampak terhadap society.",
    category: "teknologi",
    image: '<i class="fas fa-wifi"></i>',
    date: "2026-02-02",
    readTime: "8 min",
    tags: ["5G", "IoT", "Technology"],
  },
  {
    id: 41,
    title: "DevOps & CI/CD: Workflow Development Modern",
    excerpt:
      "Praktik DevOps untuk development yang efficient. CI/CD pipeline, container, kubernetes, & automation tools.",
    category: "teknologi",
    image: '<i class="fas fa-cogs"></i>',
    date: "2026-02-01",
    readTime: "10 min",
    tags: ["DevOps", "CI/CD", "Technology"],
  },
  {
    id: 42,
    title: "Low-Code & No-Code: Development Tanpa Coding",
    excerpt:
      "Trend low-code dan no-code platforms. Rapid development, accessibility, dan impact ke industri software.",
    category: "teknologi",
    image: '<i class="fas fa-code"></i>',
    date: "2026-01-31",
    readTime: "7 min",
    tags: ["Low-Code", "No-Code", "Development"],
  },
  {
    id: 43,
    title: "Quantum Computing: Komputasi Masa Depan",
    excerpt:
      "Pengenalan quantum computing. Bagaimana cara kerja, aplikasi potential, dan timeline development.",
    category: "teknologi",
    image: '<i class="fas fa-microchip"></i>',
    date: "2026-01-30",
    readTime: "9 min",
    tags: ["Quantum", "Computing", "Future"],
  },
  {
    id: 44,
    title: "Metaverse: Dunia Virtual & Aplikasinya",
    excerpt:
      "Apa itu metaverse dan potensi aplikasinya. VR, AR, virtual worlds, dan peluang bisnis di masa depan.",
    category: "teknologi",
    image: '<i class="fas fa-vr-cardboard"></i>',
    date: "2026-01-29",
    readTime: "8 min",
    tags: ["Metaverse", "VR", "Technology"],
  },

  // TUTORIAL INSTALSI KOMPUTER
  {
    id: 45,
    title: "Membangun PC Gaming: Panduan Hardware Lengkap",
    excerpt:
      "Cara memilih dan merakit PC gaming yang powerful. Component selection, budget planning, dan assembly tips.",
    category: "tutorial-komputer",
    image: '<i class="fas fa-desktop"></i>',
    date: "2026-02-02",
    readTime: "12 min",
    tags: ["PC Build", "Gaming", "Hardware"],
  },
  {
    id: 46,
    title: "Install & Setup Windows: Fresh Install hingga Optimization",
    excerpt:
      "Tutorial lengkap install Windows dari USB. Driver installation, system optimization, dan security setup.",
    category: "tutorial-komputer",
    image: '<i class="fas fa-windows"></i>',
    date: "2026-02-01",
    readTime: "10 min",
    tags: ["Windows", "Installation", "Setup"],
  },
  {
    id: 47,
    title: "Linux untuk Pemula: Install & Penggunaan Dasar",
    excerpt:
      "Pengenalan Linux sistem operasi. Instalasi, basic command line, dan tips untuk pengguna baru.",
    category: "tutorial-komputer",
    image: '<i class="fas fa-linux"></i>',
    date: "2026-01-31",
    readTime: "9 min",
    tags: ["Linux", "OS", "Tutorial"],
  },
  {
    id: 48,
    title: "BIOS & UEFI: Pengertian & Cara Konfigurasi",
    excerpt:
      "Memahami BIOS/UEFI settings. Boot order, overclocking, security settings, dan troubleshooting.",
    category: "tutorial-komputer",
    image: '<i class="fas fa-cogs"></i>',
    date: "2026-01-30",
    readTime: "8 min",
    tags: ["BIOS", "Hardware", "Setup"],
  },
  {
    id: 49,
    title: "SSD vs HDD: Instalasi & Migrasi Hard Drive",
    excerpt:
      "Perbedaan SSD & HDD. Instalasi, cloning OS, dan tips maximize performa storage Anda.",
    category: "tutorial-komputer",
    image: '<i class="fas fa-hdd"></i>',
    date: "2026-01-29",
    readTime: "7 min",
    tags: ["Storage", "Hardware", "Tutorial"],
  },

  // TUTORIAL TEKNISI KOMPUTER
  {
    id: 50,
    title: "Troubleshooting Komputer: Error Umum & Solusinya",
    excerpt:
      "Diagnosis dan solusi masalah komputer umum. Blue screen, slow performance, dan hardware issues.",
    category: "tutorial-teknis",
    image: '<i class="fas fa-wrench"></i>',
    date: "2026-02-01",
    readTime: "11 min",
    tags: ["Troubleshooting", "Tech Support", "Repair"],
  },
  {
    id: 51,
    title: "Maintenance Komputer: Cleaning & Preventive Care",
    excerpt:
      "Perawatan rutin komputer untuk longevity. Cleaning, thermal management, dan preventive maintenance.",
    category: "tutorial-teknis",
    image: '<i class="fas fa-vacuum"></i>',
    date: "2026-01-31",
    readTime: "8 min",
    tags: ["Maintenance", "Care", "PC"],
  },
  {
    id: 52,
    title: "Virus & Malware: Proteksi & Removal Komputer",
    excerpt:
      "Proteksi komputer dari virus & malware. Antivirus recommendations, cleaning malware, dan prevention tips.",
    category: "tutorial-teknis",
    image: '<i class="fas fa-shield-virus"></i>',
    date: "2026-01-30",
    readTime: "10 min",
    tags: ["Security", "Malware", "Protection"],
  },
  {
    id: 53,
    title: "Network Troubleshooting: WiFi & Internet Issues",
    excerpt:
      "Solusi masalah network & internet. WiFi connectivity, speed issues, dan diagnosis tools.",
    category: "tutorial-teknis",
    image: '<i class="fas fa-wifi"></i>',
    date: "2026-01-29",
    readTime: "9 min",
    tags: ["Network", "WiFi", "Internet"],
  },
  {
    id: 54,
    title: "Driver & Update: Management & Troubleshoot",
    excerpt:
      "Pengelolaan driver hardware. Update driver, rollback, conflict resolution, dan optimization.",
    category: "tutorial-teknis",
    image: '<i class="fas fa-microchip"></i>',
    date: "2026-01-28",
    readTime: "7 min",
    tags: ["Drivers", "Hardware", "Updates"],
  },
  {
    id: 55,
    title: "Backup & Recovery: Proteksi Data Komputer Anda",
    excerpt:
      "Strategi backup data yang effective. Tools, scheduling, cloud backup, dan disaster recovery.",
    category: "tutorial-teknis",
    image: '<i class="fas fa-arrow-circle-down"></i>',
    date: "2026-01-27",
    readTime: "10 min",
    tags: ["Backup", "Recovery", "Data Protection"],
  },

  // MANAGEMENT KONTEN
  {
    id: 56,
    title: "Content Calendar: Planning & Organization Konten",
    excerpt:
      "Cara membuat dan manage content calendar yang efektif. Planning, scheduling, dan consistency.",
    category: "management-konten",
    image: '<i class="fas fa-calendar-alt"></i>',
    date: "2026-02-02",
    readTime: "8 min",
    tags: ["Content Planning", "Organization", "Management"],
  },
  {
    id: 57,
    title: "CMS Populer: WordPress, Shopify, Wix Comparison",
    excerpt:
      "Perbandingan platform CMS terpopuler. Features, pros-cons, dan rekomendasi untuk kebutuhan Anda.",
    category: "management-konten",
    image: '<i class="fas fa-sitemap"></i>',
    date: "2026-02-01",
    readTime: "10 min",
    tags: ["CMS", "WordPress", "Platform"],
  },
  {
    id: 58,
    title: "WordPress: Instalasi, Setup, & Plugin Essential",
    excerpt:
      "Tutorial lengkap WordPress untuk beginner. Installation, theme setup, essential plugin, dan optimization.",
    category: "management-konten",
    image: '<i class="fas fa-wordpress"></i>',
    date: "2026-01-31",
    readTime: "12 min",
    tags: ["WordPress", "CMS", "Website"],
  },
  {
    id: 59,
    title: "SEO Content: Menulis untuk Search Engine & Reader",
    excerpt:
      "Cara menulis konten yang SEO optimized namun tetap engaging. Keyword research, on-page SEO, dan readability.",
    category: "management-konten",
    image: '<i class="fas fa-pen-fancy"></i>',
    date: "2026-01-30",
    readTime: "9 min",
    tags: ["SEO", "Content Writing", "Copywriting"],
  },
  {
    id: 60,
    title: "Video Content: Production & Distribution Strategy",
    excerpt:
      "Cara membuat video content berkualitas. Production tips, editing, optimization, dan distribution strategy.",
    category: "management-konten",
    image: '<i class="fas fa-video"></i>',
    date: "2026-01-29",
    readTime: "11 min",
    tags: ["Video", "Content Production", "Marketing"],
  },
];

// ============ PAGINATION SETTINGS ============
const itemsPerPage = 12;
let currentPage = 1;
let filteredArticles = blogArticles;

// ============ DOM ELEMENTS ============
const blogGrid = document.getElementById("blogGrid");
const categoryLinks = document.querySelectorAll(".category-link");
const searchInput = document.getElementById("searchBlog");
const blogPagination = document.getElementById("blogPagination");
const postsLoading = document.getElementById("postsLoading");
const postsEmpty = document.getElementById("postsEmpty");

// ============ RENDER BLOG ARTICLES ============
function renderBlogArticles(page = 1) {
  if (filteredArticles.length === 0) {
    blogGrid.innerHTML = "";
    postsEmpty.style.display = "flex";
    blogPagination.innerHTML = "";
    return;
  }

  postsEmpty.style.display = "none";

  const start = (page - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  const paginatedArticles = filteredArticles.slice(start, end);

  blogGrid.innerHTML = "";

  paginatedArticles.forEach((article) => {
    const card = document.createElement("div");
    card.className = "blog-card";
    card.innerHTML = `
      <div class="blog-card-image">${article.image}</div>
      <div class="blog-card-content">
        <span class="blog-card-category">${article.category.replace(/-/g, " ")}</span>
        <h3 class="blog-card-title">${article.title}</h3>
        <p class="blog-card-excerpt">${article.excerpt}</p>
        <div class="blog-card-meta">
          <span class="blog-card-date">
            <i class="fas fa-calendar"></i>
            ${formatDate(article.date)}
          </span>
          <span class="blog-card-read-time">
            <i class="fas fa-clock"></i>
            ${article.readTime}
          </span>
        </div>
        <a href="#" class="blog-card-link">
          Baca Selengkapnya <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    `;
    blogGrid.appendChild(card);
  });

  // Render pagination
  renderPagination(filteredArticles.length);
}

// ============ RENDER PAGINATION ============
function renderPagination(totalItems) {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  blogPagination.innerHTML = "";

  if (totalPages <= 1) return;

  // Previous button
  if (currentPage > 1) {
    const prevBtn = document.createElement("button");
    prevBtn.className = "pagination-btn";
    prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
    prevBtn.addEventListener("click", () => {
      currentPage--;
      renderBlogArticles(currentPage);
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
    blogPagination.appendChild(prevBtn);
  }

  // Page numbers
  for (let i = 1; i <= totalPages; i++) {
    const btn = document.createElement("button");
    btn.className = `pagination-btn ${i === currentPage ? "active" : ""}`;
    btn.textContent = i;
    btn.addEventListener("click", () => {
      currentPage = i;
      renderBlogArticles(currentPage);
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
    blogPagination.appendChild(btn);
  }

  // Next button
  if (currentPage < totalPages) {
    const nextBtn = document.createElement("button");
    nextBtn.className = "pagination-btn";
    nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
    nextBtn.addEventListener("click", () => {
      currentPage++;
      renderBlogArticles(currentPage);
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
    blogPagination.appendChild(nextBtn);
  }
}

// ============ FILTER BY CATEGORY ============
categoryLinks.forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();

    categoryLinks.forEach((l) => l.classList.remove("active"));
    this.classList.add("active");

    const category = this.getAttribute("data-category");

    if (category === "all") {
      filteredArticles = blogArticles;
    } else {
      filteredArticles = blogArticles.filter((a) => a.category === category);
    }

    currentPage = 1;
    renderBlogArticles();
  });
});

// ============ SEARCH FUNCTIONALITY ============
searchInput.addEventListener("keyup", function (e) {
  const searchTerm = e.target.value.toLowerCase();

  if (searchTerm === "") {
    filteredArticles = blogArticles;
  } else {
    filteredArticles = blogArticles.filter(
      (a) =>
        a.title.toLowerCase().includes(searchTerm) ||
        a.excerpt.toLowerCase().includes(searchTerm) ||
        a.tags.some((tag) => tag.toLowerCase().includes(searchTerm)),
    );
  }

  currentPage = 1;
  renderBlogArticles();
});

// ============ HELPER FUNCTIONS ============
function formatDate(dateString) {
  const options = { year: "numeric", month: "long", day: "numeric" };
  return new Date(dateString).toLocaleDateString("id-ID", options);
}

function clearFilter(e) {
  e.preventDefault();
  categoryLinks.forEach((l) => l.classList.remove("active"));
  categoryLinks[0].classList.add("active");
  filteredArticles = blogArticles;
  currentPage = 1;
  renderBlogArticles();
}

// ============ INIT ============
document.addEventListener("DOMContentLoaded", function () {
  // Check for URL parameter untuk category
  const urlParams = new URLSearchParams(window.location.search);
  const categoryParam = urlParams.get("category");

  if (categoryParam) {
    // Find dan click category link based on URL param
    const categoryLink = document.querySelector(
      `.category-link[data-category="${categoryParam}"]`,
    );
    if (categoryLink) {
      categoryLink.click();
    }
  }

  renderBlogArticles();
});

// ============ NEWSLETTER FORM ============
const newsletterForm = document.getElementById("newsletterForm");
if (newsletterForm) {
  newsletterForm.addEventListener("submit", function (e) {
    e.preventDefault();
    alert("Terima kasih! Email Anda telah terdaftar untuk newsletter kami.");
    this.reset();
  });
}

console.log("Blog JavaScript loaded successfully!");
